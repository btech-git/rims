<?php

class MovementInHeaderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('movementInCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'updateReceived' || 
            $filterChain->action->id === 'updateStatus' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('movementInEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('movementInApproval')) || !(Yii::app()->user->checkAccess('movementInSupervisor')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('movementInCreate')) || !(Yii::app()->user->checkAccess('movementInEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $details = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $id));
        $historis = MovementInApproval::model()->findAllByAttributes(array('movement_in_id' => $id));
        $shippings = MovementInShipping::model()->findAllByAttributes(array('movement_in_id' => $id));
        
        if (isset($_POST['Process']) && IdempotentManager::check() && IdempotentManager::build()->save()) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->movement_in_number,
            ));

            $transactionType = 'MI';
            $postingDate = date('Y-m-d');
            $transactionCode = $model->movement_in_number;
            $transactionDate = $model->date_posting;
            $branchId = $model->branch_id;
            $transactionSubject = $model->getMovementType($model->movement_type);

            $journalReferences = array();
        
            foreach ($details as $movementDetail) {
                $unitPrice = empty($movementDetail->receiveItemDetail->purchaseOrderDetail) ? $movementDetail->product->averageCogs : $movementDetail->receiveItemDetail->purchaseOrderDetail->unit_price;
                $jumlah = $movementDetail->quantity * $unitPrice;

                $value = $jumlah;
                $coaMasterTransitId = $movementDetail->product->productMasterCategory->coa_inventory_in_transit;
                $journalReferences[$coaMasterTransitId]['debet_kredit'] = 'K';
                $journalReferences[$coaMasterTransitId]['is_coa_category'] = 1;
                $journalReferences[$coaMasterTransitId]['values'][] = $value;

                $coaSubTransitId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                $journalReferences[$coaSubTransitId]['debet_kredit'] = 'K';
                $journalReferences[$coaSubTransitId]['is_coa_category'] = 0;
                $journalReferences[$coaSubTransitId]['values'][] = $value;

                $coaMasterInventoryId = $movementDetail->product->productMasterCategory->coa_persediaan_barang_dagang;
                $journalReferences[$coaMasterInventoryId]['debet_kredit'] = 'D';
                $journalReferences[$coaMasterInventoryId]['is_coa_category'] = 1;
                $journalReferences[$coaMasterInventoryId]['values'][] = $value;

                $coaSubInventoryId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                $journalReferences[$coaSubInventoryId]['debet_kredit'] = 'D';
                $journalReferences[$coaSubInventoryId]['is_coa_category'] = 0;
                $journalReferences[$coaSubInventoryId]['values'][] = $value;
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
            
            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('view', array(
            'model' => $model,
            'details' => $details,
            'historis' => $historis,
            'shippings' => $shippings,
        ));
    }

    public function actionCreate($transactionId, $movementType) {

        $movementIn = $this->instantiate(null);
        $movementIn->header->created_datetime = date('Y-m-d H:i:s');
        $movementIn->header->date_posting = date('Y-m-d H:i:s');
        $this->performAjaxValidation($movementIn->header);

        if ($movementType == 1) {
            $receiveItem = TransactionReceiveItem::model()->findByPk($transactionId);
            $movementIn->header->receive_item_id = $transactionId;
            $movementIn->header->return_item_id = null;
            $movementIn->header->branch_id = $receiveItem->recipient_branch_id;
            
        } else if ($movementType == 2) {
            $returnItem = TransactionReturnItem::model()->findByPk($transactionId);
            $movementIn->header->receive_item_id = null;
            $movementIn->header->return_item_id = $transactionId;
            $movementIn->header->branch_id = $returnItem->recipient_branch_id;
            
        } else {
            $this->redirect(array('admin'));
        }
        
        $movementIn->header->movement_type = $movementType;
//        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementIn->header->branch_id));
        $movementIn->addDetails($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['MovementInHeader']) && IdempotentManager::check()) {
            $this->loadState($movementIn);
            $movementIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($movementIn->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($movementIn->header->date_posting)), $movementIn->header->branch_id);
            
            if ($movementIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementIn->header->id));
            }
        }

        $this->render('create', array(
            'movementIn' => $movementIn,
//            'warehouses' => $warehouses,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $movementIn = $this->instantiate($id);
        $movementIn->header->status = 'Draft';
//        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementIn->header->branch_id));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($movementIn->header);
        $receiveItem = new TransactionReceiveItem('search');
        $receiveItem->unsetAttributes();
        
        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['MovementInHeader']) && IdempotentManager::check()) {
            $this->loadState($movementIn);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $movementIn->header->movement_in_number,
            ));

            $movementIn->header->setCodeNumberByRevision('movement_in_number');
            
            if ($movementIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementIn->header->id));
            }
        }

        $this->render('update', array(
            'movementIn' => $movementIn,
//            'warehouses' => $warehouses,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('MovementInHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new MovementInHeader('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['MovementInHeader'])) {
            $model->attributes = $_GET['MovementInHeader'];
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;

        $receiveItem = new TransactionReceiveItem('search');
        $receiveItem->unsetAttributes();
        
        if (isset($_GET['TransactionReceiveItem'])) {
            $receiveItem->attributes = $_GET['TransactionReceiveItem'];
        }

        $receiveItemDataProvider = $receiveItem->searchByMovementIn();
    
        $returnItem = new TransactionReturnItem('search');
        $returnItem->unsetAttributes();
        
        if (isset($_GET['TransactionReturnItem'])) {
            $returnItem->attributes = $_GET['TransactionReturnItem'];
        }

        $returnItemDataProvider = $returnItem->search();

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'returnItem' => $returnItem,
            'returnItemDataProvider' => $returnItemDataProvider,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'cancelled_datetime', 'user_id_cancelled'));
        
        foreach($model->movementInDetails as $detail) {
            $detail->quantity = 0;
            $detail->update(array('quantity'));
            
            if (!empty($detail->receive_item_detail_id)) {
                $receiveItemDetail = $detail->receiveItemDetail;
                $receiveItemDetail->quantity_movement = $receiveItemDetail->getQuantityMovement();
                $receiveItemDetail->quantity_movement_left = $receiveItemDetail->getQuantityMovementLeft();
                $receiveItemDetail->update(array('quantity_movement', 'quantity_movement_left'));
            }
        }

        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $model->movement_in_number,
        ));

        InventoryDetail::model()->deleteAllByAttributes(array(
            'transaction_number' => $model->movement_in_number,
        ));

        foreach ($model->movementInDetails as $movementDetail) {
            $inventory = Inventory::model()->findByAttributes(array(
                'product_id' => $movementDetail->product_id, 
                'warehouse_id' => $movementDetail->warehouse_id
            ));

            $inventory->total_stock = $inventory->getTotalStockInventoryDetail($movementDetail->product_id, $movementDetail->warehouse_id);
            $inventory->update(array('total_stock'));
        }
        
        $this->redirect(array('admin'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return MovementInHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MovementInHeader::model()->findByPk($id);
        
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param MovementInHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'movement-in-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id) {
        ;
        if (empty($id)) {
            $movementIn = new MovementIns(new MovementInHeader(), array());
        } else {
            $movementInModel = $this->loadModel($id);
            $movementIn = new MovementIns($movementInModel, $movementInModel->movementInDetails);
        }
        return $movementIn;
    }

    public function loadState($movementIn) {
        if (isset($_POST['MovementInHeader'])) {
            $movementIn->header->attributes = $_POST['MovementInHeader'];
        }

        if (isset($_POST['MovementInDetail'])) {
            foreach ($_POST['MovementInDetail'] as $i => $item) {
                if (isset($movementIn->details[$i])) {
                    $movementIn->details[$i]->attributes = $item;
                } else {
                    $detail = new MovementInDetail();
                    $detail->attributes = $item;
                    $movementIn->details[] = $detail;
                }
            }
            
            if (count($_POST['MovementInDetail']) < count($movementIn->details))
                array_splice($movementIn->details, $i + 1);
        }
        else {
            $movementIn->details = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $detailId, $type) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementIn = $this->instantiate($id);
            $this->loadState($movementIn);

            $movementIn->addDetail($detailId, $type);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('movementIn' => $movementIn), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementIn = $this->instantiate($id);
            $this->loadState($movementIn);

            $movementIn->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('movementIn' => $movementIn), false, true);
        }
    }

    public function actionAjaxHtmlUpdateAllWarehouse($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementIn = $this->instantiate($id);
            $this->loadState($movementIn);

            $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementIn->header->branch_id));

            $this->renderPartial('_detail', array(
                'movementIn' => $movementIn,
                'warehouses' => $warehouses,
            ));
        }
    }

    public function actionAjaxReceive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receive = TransactionReceiveItem::model()->findByPk($id);
            $type = $requestNumber = "";
            
            if ($receive->request_type == "Internal Delivery Order") {
                $type = "Internal Delivery Order";
                $requestNumber = $receive->deliveryOrder->delivery_order_no;
            } elseif ($receive->request_type == "Purchase Order") {
                $type = "Purchase Order";
                $requestNumber = $receive->purchaseOrder->purchase_order_no;
            } elseif ($receive->request_type == "Consignment In") {
                $type = "Consignment In";
                $requestNumber = $receive->consignmentIn->consignment_in_number;
            }

            $object = array(
                'id' => $receive->id,
                'number' => $receive->receive_item_no,
                'type' => $type,
                'requestNumber' => $requestNumber,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateStatus($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['MovementInHeader'])) {
            $model->status = $_POST['MovementInHeader']['status'];
            $model->supervisor_id = $_POST['MovementInHeader']['supervisor_id'];

            if ($model->update(array('status', 'supervisor_id')))
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateStatus', array(
            'model' => $model,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $movement = MovementInHeader::model()->findByPK($headerId);
        $historis = MovementInApproval::model()->findAllByAttributes(array('movement_in_id' => $headerId));
        $model = new MovementInApproval;
        $model->date = date('Y-m-d H:i:s');
        $details = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $headerId));

        if (isset($_POST['MovementInApproval']) && IdempotentManager::check() && IdempotentManager::build()->save()) {
            $model->attributes = $_POST['MovementInApproval'];
            
            if ($model->save()) {
                $movement->status = $model->approval_type;
                $movement->save(false);

                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $movement->movement_in_number,
                    'branch_id' => $movement->branch_id,
                ));

                if ($model->approval_type == 'Approved') {
                    $transactionType = 'MI';
                    $postingDate = date('Y-m-d');
                    $transactionCode = $movement->movement_in_number;
                    $transactionDate = $movement->date_posting;
                    $branchId = $movement->branch_id;
                    $transactionSubject = $movement->getMovementType($movement->movement_type);

                    $journalReferences = array();

                    foreach ($details as $movementDetail) {
                        $unitPrice = empty($movementDetail->receiveItemDetail->purchaseOrderDetail) ? $movementDetail->product->hpp : $movementDetail->receiveItemDetail->purchaseOrderDetail->unit_price;
                        $jumlah = $movementDetail->quantity * $unitPrice;

                        $value = $jumlah;
                        $coaMasterTransitId = $movementDetail->product->productMasterCategory->coa_inventory_in_transit;
                        $journalReferences[$coaMasterTransitId]['debet_kredit'] = 'K';
                        $journalReferences[$coaMasterTransitId]['is_coa_category'] = 1;
                        $journalReferences[$coaMasterTransitId]['values'][] = $value;

                        $coaSubTransitId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                        $journalReferences[$coaSubTransitId]['debet_kredit'] = 'K';
                        $journalReferences[$coaSubTransitId]['is_coa_category'] = 0;
                        $journalReferences[$coaSubTransitId]['values'][] = $value;

                        $coaMasterInventoryId = $movementDetail->product->productMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaMasterInventoryId]['debet_kredit'] = 'D';
                        $journalReferences[$coaMasterInventoryId]['is_coa_category'] = 1;
                        $journalReferences[$coaMasterInventoryId]['values'][] = $value;

                        $coaSubInventoryId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaSubInventoryId]['debet_kredit'] = 'D';
                        $journalReferences[$coaSubInventoryId]['is_coa_category'] = 0;
                        $journalReferences[$coaSubInventoryId]['values'][] = $value;
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

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'movement' => $movement,
            'historis' => $historis,
        ));
    }

    public function actionAjaxReturn($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $return = TransactionReturnItem::model()->findByPk($id);

            $object = array(
                'id' => $return->id,
                'number' => $return->return_item_no,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateReceived($id) {
        IdempotentManager::generate();
        $movementIn = $this->instantiate($id);
        
        $movementInShipping = new MovementInShipping();
        $movementInShipping->movement_in_id = $id;
        $movementInShipping->status = "Received";
        $movementInShipping->date = date('Y-m-d');
        $movementInShipping->supervisor_id = Yii::app()->user->getId();

        if ($movementInShipping->save() && IdempotentManager::check() && IdempotentManager::build()->save()) {

            InventoryDetail::model()->deleteAllByAttributes(array(
                'transaction_number' => $movementIn->header->movement_in_number,
            ));

            foreach ($movementIn->details as $movementDetail) {
                $inventory = Inventory::model()->findByAttributes(array(
                    'product_id' => $movementDetail->product_id, 
                    'warehouse_id' => $movementDetail->warehouse_id
                ));

                if (empty($inventory)) {
                    $insertInventory = new Inventory();
                    $insertInventory->product_id = $movementDetail->product_id;
                    $insertInventory->warehouse_id = $movementDetail->warehouse_id;
                    $insertInventory->minimal_stock = 0;
                    $insertInventory->total_stock = $movementDetail->quantity;
                    $insertInventory->status = 'Active';
                    $insertInventory->save();

                    $inventoryId = $insertInventory->id;
                } else {
                    $inventory->total_stock += $movementDetail->quantity;
                    $inventory->update(array('total_stock'));

                    $inventoryId = $inventory->id;

                }

                if ($movementDetail->quantity > 0) {
                    $inventoryDetail = new InventoryDetail();
                    $inventoryDetail->inventory_id = $inventoryId;
                    $inventoryDetail->product_id = $movementDetail->product_id;
                    $inventoryDetail->warehouse_id = $movementDetail->warehouse_id;
                    $inventoryDetail->transaction_type = 'MVI';
                    $inventoryDetail->transaction_number = $movementIn->header->movement_in_number;
                    $inventoryDetail->transaction_date = $movementIn->header->date_posting;
                    $inventoryDetail->stock_in = $movementDetail->quantity;
                    $inventoryDetail->stock_out = 0;
                    $inventoryDetail->notes = "Data from Movement In";
                    $inventoryDetail->purchase_price = $movementDetail->product->averageCogs;
                    $inventoryDetail->transaction_time = date('H:i:s');

                    $inventoryDetail->save(false);
                }
            }
        }

        $movementIn->header->status = "Finished";
        $movementIn->header->save(false);
    }
}