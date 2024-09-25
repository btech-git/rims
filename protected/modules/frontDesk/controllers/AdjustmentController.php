<?php

class AdjustmentController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('stockAdjustmentCreate')) || !(Yii::app()->user->checkAccess('stockAdjustmentEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $adjustment = $this->instantiate(null);
        $adjustment->header->user_id = Yii::app()->user->id;
        $adjustment->header->status = 'Draft';
        $adjustment->header->date_posting = date('Y-m-d');
        $adjustment->header->created_datetime = date('Y-m-d H:i:s');
//        $adjustment->header->branch_id = Yii::app()->user->branch_id;

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($adjustment);
            $adjustment->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($adjustment->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($adjustment->header->date_posting)), $adjustment->header->branch_id);

            $branch = Branch::model()->findByPk($adjustment->header->branch_id);
            $warehouse = Warehouse::model()->findByAttributes(array('code' => $branch->code));
            $adjustment->header->warehouse_id = $warehouse->id;
            
            if ($adjustment->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $adjustment->header->id));
            }
        }

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        $this->render('create', array(
            'adjustment' => $adjustment,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionView($id) {
        $listApproval = StockAdjustmentApproval::model()->findAllByAttributes(array('stock_adjustment_header_id' => $id));
        $product = new Product('search');
        $warehouse = Warehouse::model()->findAll();


        $this->render('view', array(
            'model' => $this->loadModel($id),
            'product' => $product,
            'warehouse' => $warehouse,
            'listApproval' => $listApproval,
        ));
    }

    public function actionAdmin() {
        $model = new StockAdjustmentHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StockAdjustmentHeader'])) {
            $model->attributes = $_GET['StockAdjustmentHeader'];
        }

        $dataProvider = $model->search();
//        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
//        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
//        $dbTransaction = Yii::app()->db->beginTransaction();
//        try {
            $stockAdjustmentHeader = StockAdjustmentHeader::model()->findByPk($headerId);
            $historis = StockAdjustmentApproval::model()->findAllByAttributes(array('stock_adjustment_header_id' => $headerId));
            $model = new StockAdjustmentApproval;
            $model->date = date('Y-m-d H:i:s');

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $stockAdjustmentHeader->stock_adjustment_number,
            ));

            InventoryDetail::model()->deleteAllByAttributes(array(
                'transaction_number' => $stockAdjustmentHeader->header->stock_adjustment_number,
            ));

            if (isset($_POST['StockAdjustmentApproval'])) {
                $model->attributes = $_POST['StockAdjustmentApproval'];
                if ($model->save()) {
                    $stockAdjustmentHeader->status = $model->approval_type;
                    if ($model->approval_type == 'Approved') {
                        $stockAdjustmentHeader->supervisor_id = $model->supervisor_id;

                        $transactionType = StockAdjustmentHeader::CONSTANT;
                        $postingDate = date('Y-m-d');
                        $transactionCode = $stockAdjustmentHeader->stock_adjustment_number;
                        $transactionDate = $stockAdjustmentHeader->date_posting;
                        $branchId = $stockAdjustmentHeader->branch_id;
                        $transactionSubject = $stockAdjustmentHeader->transaction_type;

                        $journalReferences = array();

                        foreach ($stockAdjustmentHeader->stockAdjustmentDetails as $key => $detail) {
                            if (!empty($detail->product_id)) {
                                $inventory = Inventory::model()->findByAttributes(array(
                                    'product_id' => $detail->product_id, 
                                    'warehouse_id' => $stockAdjustmentHeader->warehouse_id
                                ));

                                if (empty($inventory)) {
                                    $insertInventory = new Inventory();
                                    $insertInventory->product_id = $detail->product_id;
                                    $insertInventory->warehouse_id = $stockAdjustmentHeader->warehouse_id;
                                    $insertInventory->minimal_stock = 0;
                                    $insertInventory->total_stock = $detail->quantity_adjustment;
                                    $insertInventory->status = 'Active';
                                    $insertInventory->save();

                                    $inventoryId = $insertInventory->id;
                                } else {
                                    $inventory->total_stock = $detail->quantity_adjustment;
                                    $inventory->update(array('total_stock'));

                                    $inventoryId = $inventory->id;
                                }

                                $inventoryDetail = new InventoryDetail();
                                $inventoryDetail->inventory_id = $inventoryId;
                                $inventoryDetail->product_id = $detail->product_id;
                                $inventoryDetail->warehouse_id = $stockAdjustmentHeader->warehouse_id;
                                $inventoryDetail->transaction_type = StockAdjustmentHeader::CONSTANT;
                                $inventoryDetail->transaction_number = $stockAdjustmentHeader->stock_adjustment_number;
                                $inventoryDetail->transaction_date = $stockAdjustmentHeader->date_posting;
                                $inventoryDetail->stock_in = $detail->quantityDifference > 0 ? $detail->quantityDifference : 0;
                                $inventoryDetail->stock_out = $detail->quantityDifference < 0 ? $detail->quantityDifference : 0;
                                $inventoryDetail->notes = "Data from Adjustment Stock";
                                $inventoryDetail->purchase_price = $detail->product->hpp;
                                $inventoryDetail->transaction_time = date('H:i:s');

                                $inventoryDetail->save(false);
                
                                $quantityDifference = ($detail->quantity_current > $detail->quantity_adjustment) ? $detail->quantityDifference * -1 : $detail->quantityDifference;
                                $total = $detail->product->hpp * $quantityDifference;

                                $jurnalUmumHpp = $detail->product->productSubMasterCategory->coa_hpp;
                                $journalReferences[$jurnalUmumHpp]['debet_kredit'] = ($detail->quantity_current < $detail->quantity_adjustment) ? 'D' : 'K';
                                $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
                                $journalReferences[$jurnalUmumHpp]['values'][] = $total;

                                $jurnalUmumPersediaan = $detail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                                $journalReferences[$jurnalUmumPersediaan]['debet_kredit'] = ($detail->quantity_current < $detail->quantity_adjustment) ? 'K' : 'D';
                                $journalReferences[$jurnalUmumPersediaan]['is_coa_category'] = 0;
                                $journalReferences[$jurnalUmumPersediaan]['values'][] = $total;
                            }
                        }

                        foreach ($journalReferences as $coaId => $journalReference) {
                            $jurnalUmumPersediaan = new JurnalUmum();
                            $jurnalUmumPersediaan->kode_transaksi = $transactionCode;
                            $jurnalUmumPersediaan->tanggal_transaksi = $transactionDate;
                            $jurnalUmumPersediaan->coa_id = $coaId;
                            $jurnalUmumPersediaan->branch_id = $branchId;
                            $jurnalUmumPersediaan->total = array_sum($journalReference['values']);
                            $jurnalUmumPersediaan->debet_kredit = $journalReference['debet_kredit'];
                            $jurnalUmumPersediaan->tanggal_posting = $postingDate;
                            $jurnalUmumPersediaan->transaction_subject = $transactionSubject;
                            $jurnalUmumPersediaan->is_coa_category = $journalReference['is_coa_category'];
                            $jurnalUmumPersediaan->transaction_type = $transactionType;
                            $jurnalUmumPersediaan->save();
                        }
                    }
                    $stockAdjustmentHeader->save(false);
                    $this->redirect(array('view', 'id' => $headerId));
                }
            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $this->header->addError('error', $e->getMessage());
//        }

        $this->render('updateApproval', array(
            'model' => $model,
            'historis' => $historis,
            'stockAdjustmentHeader' => $stockAdjustmentHeader,
        ));
    }

    public function actionAjaxHtmlAddProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);
            $branchId = Yii::app()->user->branch_id;

            if (isset($_POST['ProductId'])) {
                $adjustment->addDetail($_POST['ProductId'], $branchId);
            }

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            $adjustment->removeProductAt($index);

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
            ));
        }
    }

    public function actionAjaxHtmlUpdateAllProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            $adjustment->updateProducts();

            $this->renderPartial('_detail', array(
                'adjustment' => $adjustment,
            ));
        }
    }

    public function actionAjaxJsonDifference($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate($id);
            $this->loadState($adjustment);

            $quantityDifference = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $adjustment->details[$index]->getQuantityDifference($_POST['StockAdjustmentHeader']['warehouse_id'])));

            echo CJSON::encode(array(
                'quantityDifference' => $quantityDifference,
            ));
        }
    }

    public function actionAjaxHtmlUpdateWarehouseSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $adjustment = $this->instantiate(null);
            $branchId = isset($_GET['StockAdjustmentHeader']['branch_id']) ? $_GET['StockAdjustmentHeader']['branch_id'] : 0;

            $this->renderPartial('_warehouseSelect', array(
                'adjustment' => $adjustment,
                'branchId' => $branchId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $adjustment = new Adjustment(new StockAdjustmentHeader(), array());
        } else {
            $adjustmentHeader = $this->loadModel($id);
            $adjustment = new Adjustment($adjustmentHeader, $adjustmentHeader->stockAdjustmentDetails);
        }

        return $adjustment;
    }

    public function loadModel($id) {
        $model = StockAdjustmentHeader::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    protected function loadState(&$adjustment) {
        if (isset($_POST['StockAdjustmentHeader'])) {
            $adjustment->header->attributes = $_POST['StockAdjustmentHeader'];
        }

        if (isset($_POST['StockAdjustmentDetail'])) {
            foreach ($_POST['StockAdjustmentDetail'] as $item) {
                $detail = new StockAdjustmentDetail();
                $detail->attributes = $item;
                $adjustment->details[] = $detail;
            }
            if (count($_POST['StockAdjustmentDetail']) < count($adjustment->details))
                array_splice($adjustment->details, $i + 1);
        } else {
            $adjustment->details = array();
        }
    }

}
