<?php

class MovementInHeaderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
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
            if (!(Yii::app()->user->checkAccess('movementInApproval')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('movementInCreate')) || !(Yii::app()->user->checkAccess('movementInEdit')) || !(Yii::app()->user->checkAccess('movementInApproval')))
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
        
        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->movement_in_number,
                'branch_id' => $model->branch_id,
            ));

            $transactionType = 'MI';
            $postingDate = date('Y-m-d');
            $transactionCode = $model->movement_in_number;
            $transactionDate = $model->date_posting;
            $branchId = $model->branch_id;
            $transactionSubject = 'Movement In';

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
        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementIn->header->branch_id));
        $movementIn->addDetails($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['MovementInHeader'])) {
            $this->loadState($movementIn);
            $movementIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($movementIn->header->date_posting)), Yii::app()->dateFormatter->format('yyyy', strtotime($movementIn->header->date_posting)), $movementIn->header->branch_id);
            
            if ($movementIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementIn->header->id));
            }
        }

        $this->render('create', array(
            'movementIn' => $movementIn,
            'warehouses' => $warehouses,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $movementIn = $this->instantiate($id);
        $warehouses = Warehouse::model()->findAllByAttributes(array('branch_id' => $movementIn->header->branch_id));

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($movementIn->header);
        $receiveItem = new TransactionReceiveItem('search');
        $receiveItem->unsetAttributes();
        
//        if (isset($_GET['TransactionReceiveItem']))
//            $receiveItem->attributes = $_GET['TransactionReceiveItem'];
//        
//        $receiveItemCriteria = new CDbCriteria;
//        $receiveItemCriteria->compare('recipient_branch_id', $movementIn->header->branch_id);
//        $receiveItemCriteria->together = 'true';
//        $receiveItemCriteria->with = array('recipientBranch');
//        $receiveItemCriteria->compare('recipientBranch.name', $receiveItem->branch_name, true);
//        $receiveItemCriteria->compare('receive_item_no', $receiveItem->receive_item_no, true);
//
//        $receiveItemDataProvider = new CActiveDataProvider('TransactionReceiveItem', array('criteria' => $receiveItemCriteria));
//
//        $receiveItemDetail = new TransactionReceiveItemDetail('search');
//        $receiveItemDetail->unsetAttributes();  // clear any default values
//        
//        if (isset($_GET['TransactionReceiveItemDetail']))
//            $receiveItemDetail->attributes = $_GET['TransactionReceiveItemDetail'];
//        
//        $receiveItemDetailCriteria = new CDbCriteria;
//        $receiveItemDetailCriteria->compare('receive_item_id', $movementIn->header->receive_item_id);
//        $receiveItemDetailCriteria->together = 'true';
//        $receiveItemDetailCriteria->with = array('product', 'receiveItem');
//
//        $receiveItemDetailCriteria->compare('receive_item_id', $receiveItemDetail->receive_item_id, true);
//        $receiveItemDetailCriteria->compare('receiveItem.receive_item_no', $receiveItemDetail->receive_item_no, true);
//        $receiveItemDetailCriteria->compare('product.name', $receiveItemDetail->product_name, true);
//        $receiveItemDetailDataProvider = new CActiveDataProvider('TransactionReceiveItemDetail', array(
//            'criteria' => $receiveItemDetailCriteria,
//        ));
//
//        /* Return Item */
//        $returnItem = new TransactionReturnItem('search');
//        $returnItem->unsetAttributes();
//        
//        if (isset($_GET['TransactionReturnItem']))
//            $returnItem->attributes = $_GET['TransactionReturnItem'];
//        
//        $returnItemCriteria = new CDbCriteria;
//        $receiveItemCriteria->compare('recipient_branch_id', $movementIn->header->branch_id);
//        $returnItemCriteria->together = 'true';
//        $returnItemCriteria->with = array('recipientBranch');
//        
//        $returnItemCriteria->compare('recipientBranch.name', $returnItem->branch_name, true);
//        $returnItemCriteria->compare('return_item_no', $returnItem->return_item_no, true);
//        $returnItemDataProvider = new CActiveDataProvider('TransactionReturnItem', array('criteria' => $returnItemCriteria));
//
//        $returnItemDetail = new TransactionReturnItemDetail('search');
//        $returnItemDetail->unsetAttributes();  // clear any default values
//        
//        if (isset($_GET['TransactionReturnItemDetail']))
//            $returnItemDetail->attributes = $_GET['TransactionReturnItemDetail'];
//        
//        $returnItemDetailCriteria = new CDbCriteria;
//        $returnItemDetailCriteria->compare('return_item_id', $movementIn->header->return_item_id);
//        $returnItemDetailCriteria->together = 'true';
//        $returnItemDetailCriteria->with = array('product', 'returnItem');
//
//        $returnItemDetailCriteria->compare('return_item_id', $returnItemDetail->return_item_id, true);
//        $returnItemDetailCriteria->compare('returnItem.return_item_no', $returnItemDetail->return_item_no, true);
//        $returnItemDetailCriteria->compare('product.name', $returnItemDetail->product_name, true);
//        $returnItemDetailDataProvider = new CActiveDataProvider('TransactionReturnItemDetail', array(
//            'criteria' => $returnItemDetailCriteria,
//        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['MovementInHeader'])) {
            $this->loadState($movementIn);
            $movementIn->header->setCodeNumberByRevision('movement_in_number');
            
            if ($movementIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementIn->header->id));
            }
        }

        $this->render('update', array(
            'movementIn' => $movementIn,
            'warehouses' => $warehouses,
//            'receiveItemDetail' => $receiveItemDetail,
//            'receiveItemDetailDataProvider' => $receiveItemDetailDataProvider,
//            'receiveItem' => $receiveItem,
//            'receiveItemDataProvider' => $receiveItemDataProvider,
//            'returnItem' => $returnItem,
//            'returnItemDataProvider' => $returnItemDataProvider,
//            'returnItemDetail' => $returnItemDetail,
//            'returnItemDetailDataProvider' => $returnItemDetailDataProvider,
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
        $dataProvider->criteria->addInCondition('t.branch_id', Yii::app()->user->branch_ids);

        $receiveItem = new TransactionReceiveItem('search');
        $receiveItem->unsetAttributes();
        
        if (isset($_GET['TransactionReceiveItem'])) {
            $receiveItem->attributes = $_GET['TransactionReceiveItem'];
        }

        $receiveItemDataProvider = $receiveItem->searchByMovementIn();
        $receiveItemDataProvider->criteria->addCondition("t.receive_item_date > '2021-12-31'");
        $receiveItemDataProvider->criteria->addInCondition('t.recipient_branch_id', Yii::app()->user->branch_ids);
    
        $returnItem = new TransactionReturnItem('search');
        $returnItem->unsetAttributes();
        
        if (isset($_GET['TransactionReturnItem'])) {
            $returnItem->attributes = $_GET['TransactionReturnItem'];
        }

        $returnItemDataProvider = $returnItem->search();
        $returnItemDataProvider->criteria->addCondition("t.return_item_date > '2021-12-31'");
        $returnItemDataProvider->criteria->addInCondition('t.recipient_branch_id', Yii::app()->user->branch_ids);

        $this->render('admin', array(
            'model' => $model,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'returnItem' => $returnItem,
            'returnItemDataProvider' => $returnItemDataProvider,
        ));
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

//    public function actionAjaxHtmlRemoveDetailAll($id) {
//        if (Yii::app()->request->isAjaxRequest) {
//            $movementIn = $this->instantiate($id);
//            $this->loadState($movementIn);
//
//            $movementIn->removeDetailAll();
//            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
//            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
//            $this->renderPartial('_detail', array('movementIn' => $movementIn), false, true);
//        }
//    }

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

        if (isset($_POST['MovementInApproval'])) {
            $model->attributes = $_POST['MovementInApproval'];
            
            if ($model->save()) {
                $movement->status = $model->approval_type;
                $movement->save(false);

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
        $movementIn = $this->instantiate($id);
        
        $received = new MovementInShipping();
        $received->movement_in_id = $id;
        $received->status = "Received";
        $received->date = date('Y-m-d');
        $received->supervisor_id = Yii::app()->user->getId();

        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $movementIn->header->movement_in_number,
            'branch_id' => $movementIn->header->branch_id,
        ));

        InventoryDetail::model()->deleteAllByAttributes(array(
            'transaction_number' => $movementIn->header->movement_in_number,
        ));

        $transactionType = 'MI';
        $postingDate = date('Y-m-d');
        $transactionCode = $movementIn->header->movement_in_number;
        $transactionDate = $movementIn->header->date_posting;
        $branchId = $movementIn->header->branch_id;
        $transactionSubject = 'Movement In';
        
        $journalReferences = array();
        
        if ($received->save()) {

            foreach ($movementIn->details as $movementDetail) {
                $inventory = Inventory::model()->findByAttributes(array('product_id' => $movementDetail->product_id, 'warehouse_id' => $movementDetail->warehouse_id));

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
                    $inventoryDetail->purchase_price = empty($movementDetail->receiveItemDetail) ? $movementDetail->product->hpp : $movementDetail->receiveItemDetail->total_price;

                    $inventoryDetail->save(false);

                    $unitPrice = empty($movementDetail->receiveItemDetail->purchase_order_detail_id) ? $movementDetail->product->hpp : $movementDetail->receiveItemDetail->purchaseOrderDetail->unit_price;
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
            }

            $movementIn->header->status = "Finished";
            $movementIn->header->save(false);

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
    }
}