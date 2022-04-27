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
        $details = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $id));
        $historis = MovementInApproval::model()->findAllByAttributes(array('movement_in_id' => $id));
        $shippings = MovementInShipping::model()->findAllByAttributes(array('movement_in_id' => $id));
        
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'details' => $details,
            'historis' => $historis,
            'shippings' => $shippings,
        ));
    }

    public function actionCreate($transactionId, $movementType) {

        $movementIn = $this->instantiate(null);
        $movementIn->header->branch_id = $movementIn->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $movementIn->header->branch_id;
        $movementIn->header->date_created = date('Y-m-d H:i:s');
        $this->performAjaxValidation($movementIn->header);

        if ($movementType == 1) {
            $movementIn->header->receive_item_id = $transactionId;
            $movementIn->header->return_item_id = null;
            
        } else if ($movementType == 2) {
            $movementIn->header->receive_item_id = null;
            $movementIn->header->return_item_id = $transactionId;
            
        } else {
            $this->redirect(array('admin'));
        }
        
        $movementIn->header->movement_type = $movementType;
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
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $movementIn = $this->instantiate($id);
        $movementIn->header->setCodeNumberByRevision('movement_in_number');

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($movementIn->header);
        $receiveItem = new TransactionReceiveItem('search');
        $receiveItem->unsetAttributes();
        
        if (isset($_GET['TransactionReceiveItem']))
            $receiveItem->attributes = $_GET['TransactionReceiveItem'];
        
        $receiveItemCriteria = new CDbCriteria;
        $receiveItemCriteria->compare('recipient_branch_id', $movementIn->header->branch_id);
        $receiveItemCriteria->together = 'true';
        $receiveItemCriteria->with = array('recipientBranch');
        $receiveItemCriteria->compare('recipientBranch.name', $receiveItem->branch_name, true);
        $receiveItemCriteria->compare('receive_item_no', $receiveItem->receive_item_no, true);

        $receiveItemDataProvider = new CActiveDataProvider('TransactionReceiveItem', array('criteria' => $receiveItemCriteria));

        $receiveItemDetail = new TransactionReceiveItemDetail('search');
        $receiveItemDetail->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionReceiveItemDetail']))
            $receiveItemDetail->attributes = $_GET['TransactionReceiveItemDetail'];
        
        $receiveItemDetailCriteria = new CDbCriteria;
        $receiveItemDetailCriteria->compare('receive_item_id', $movementIn->header->receive_item_id);
        $receiveItemDetailCriteria->together = 'true';
        $receiveItemDetailCriteria->with = array('product', 'receiveItem');

        $receiveItemDetailCriteria->compare('receive_item_id', $receiveItemDetail->receive_item_id, true);
        $receiveItemDetailCriteria->compare('receiveItem.receive_item_no', $receiveItemDetail->receive_item_no, true);
        $receiveItemDetailCriteria->compare('product.name', $receiveItemDetail->product_name, true);
        $receiveItemDetailDataProvider = new CActiveDataProvider('TransactionReceiveItemDetail', array(
            'criteria' => $receiveItemDetailCriteria,
        ));

        /* Return Item */
        $returnItem = new TransactionReturnItem('search');
        $returnItem->unsetAttributes();
        
        if (isset($_GET['TransactionReturnItem']))
            $returnItem->attributes = $_GET['TransactionReturnItem'];
        
        $returnItemCriteria = new CDbCriteria;
        $receiveItemCriteria->compare('recipient_branch_id', $movementIn->header->branch_id);
        $returnItemCriteria->together = 'true';
        $returnItemCriteria->with = array('recipientBranch');
        
        $returnItemCriteria->compare('recipientBranch.name', $returnItem->branch_name, true);
        $returnItemCriteria->compare('return_item_no', $returnItem->return_item_no, true);
        $returnItemDataProvider = new CActiveDataProvider('TransactionReturnItem', array('criteria' => $returnItemCriteria));

        $returnItemDetail = new TransactionReturnItemDetail('search');
        $returnItemDetail->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionReturnItemDetail']))
            $returnItemDetail->attributes = $_GET['TransactionReturnItemDetail'];
        
        $returnItemDetailCriteria = new CDbCriteria;
        $returnItemDetailCriteria->compare('return_item_id', $movementIn->header->return_item_id);
        $returnItemDetailCriteria->together = 'true';
        $returnItemDetailCriteria->with = array('product', 'returnItem');

        $returnItemDetailCriteria->compare('return_item_id', $returnItemDetail->return_item_id, true);
        $returnItemDetailCriteria->compare('returnItem.return_item_no', $returnItemDetail->return_item_no, true);
        $returnItemDetailCriteria->compare('product.name', $returnItemDetail->product_name, true);
        $returnItemDetailDataProvider = new CActiveDataProvider('TransactionReturnItemDetail', array(
            'criteria' => $returnItemDetailCriteria,
        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['MovementInHeader'])) {
            $this->loadState($movementIn);
            
            if ($movementIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementIn->header->id));
            }
        }

        $this->render('update', array(
            'movementIn' => $movementIn,
            'receiveItemDetail' => $receiveItemDetail,
            'receiveItemDetailDataProvider' => $receiveItemDetailDataProvider,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'returnItem' => $returnItem,
            'returnItemDataProvider' => $returnItemDataProvider,
            'returnItemDetail' => $returnItemDetail,
            'returnItemDetailDataProvider' => $returnItemDetailDataProvider,
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
        
        if (isset($_GET['MovementInHeader']))
            $model->attributes = $_GET['MovementInHeader'];
        
        $receiveItem = new TransactionReceiveItem('search');
        $receiveItem->unsetAttributes();
        
        if (isset($_GET['TransactionReceiveItem']))
            $receiveItem->attributes = $_GET['TransactionReceiveItem'];

        $returnItem = new TransactionReturnItem('search');
        $returnItem->unsetAttributes();
        
        if (isset($_GET['TransactionReturnItem']))
            $returnItem->attributes = $_GET['TransactionReturnItem'];

        $this->render('admin', array(
            'model' => $model,
            'receiveItem' => $receiveItem,
            'returnItem' => $returnItem,
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

    public function actionAjaxHtmlRemoveDetailAll($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementIn = $this->instantiate($id);
            $this->loadState($movementIn);

            $movementIn->removeDetailAll();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('movementIn' => $movementIn), false, true);
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

        $transactionType = 'MI';
        $postingDate = date('Y-m-d');
        $transactionCode = $movementIn->header->movement_in_number;
        $transactionDate = $movementIn->header->date_posting;
        $branchId = $movementIn->header->branch_id;
        $transactionSubject = 'Movement In';
        
        $journalReferences = array();
        
        if ($received->save()) {
//            $movement = MovementInHeader::model()->findByPk($id);
//            $movementDetails = MovementInDetail::model()->findAllByAttributes(array('movement_in_header_id' => $id));

            foreach ($movementIn->details as $movementDetail) {
                $inventoryId = null;
                $inventory = Inventory::model()->findByAttributes(array('product_id' => $movementDetail->product_id, 'warehouse_id' => $movementDetail->warehouse_id));

                if ($inventory !== NULL) {
                    $inventoryId = $inventory->id;
                } else {
                    $insertInventory = new Inventory();
                    $insertInventory->product_id = $movementDetail->product_id;
                    $insertInventory->warehouse_id = $movementDetail->warehouse_id;
                    $insertInventory->status = 'Active';

                    if ($insertInventory->save()) {
                        $inventoryId = $insertInventory->id;
                    } else {
                        $inventoryId = '';
                    }
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

                    $inventoryDetail->save(false);

                    $jumlah = $movementDetail->quantity * $movementDetail->product->hpp;

    //                $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '105.00.000'));
    //                $jurnalUmumMasterGroupInventory = new JurnalUmum;
    //                $jurnalUmumMasterGroupInventory->kode_transaksi = $movement->movement_in_number;
    //                $jurnalUmumMasterGroupInventory->tanggal_transaksi = $movement->date_posting;
    //                $jurnalUmumMasterGroupInventory->coa_id = $coaMasterGroupInventory->id;
    //                $jurnalUmumMasterGroupInventory->branch_id = $movement->branch_id;
    //                $jurnalUmumMasterGroupInventory->total = $jumlah;
    //                $jurnalUmumMasterGroupInventory->debet_kredit = 'K';
    //                $jurnalUmumMasterGroupInventory->tanggal_posting = date('Y-m-d');
    //                $jurnalUmumMasterGroupInventory->transaction_subject = 'Movement In';
    //                $jurnalUmumMasterGroupInventory->is_coa_category = 1;
    //                $jurnalUmumMasterGroupInventory->transaction_type = 'MI';
    //                $jurnalUmumMasterGroupInventory->save();

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
                    
                    //save product master category coa inventory in transit
//                    $coaMasterInventory = Coa::model()->findByPk($movementDetail->product->productMasterCategory->coaInventoryInTransit->id);
//                    $getCoaMasterInventory = $coaMasterInventory->code;
//                    $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
//                    $jurnalUmumMasterInventory = new JurnalUmum;
//                    $jurnalUmumMasterInventory->kode_transaksi = $movement->movement_in_number;
//                    $jurnalUmumMasterInventory->tanggal_transaksi = $movement->date_posting;
//                    $jurnalUmumMasterInventory->coa_id = $coaMasterInventoryWithCode->id;
//                    $jurnalUmumMasterInventory->branch_id = $movement->branch_id;
//                    $jurnalUmumMasterInventory->total = $jumlah;
//                    $jurnalUmumMasterInventory->debet_kredit = 'K';
//                    $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterInventory->transaction_subject = 'Movement In';
//                    $jurnalUmumMasterInventory->is_coa_category = 1;
//                    $jurnalUmumMasterInventory->transaction_type = 'MI';
//                    $jurnalUmumMasterInventory->save();
//
//                    //save product sub master category coa inventory in transit
//                    $coaInventory = Coa::model()->findByPk($movementDetail->product->productSubMasterCategory->coaInventoryInTransit->id);
//                    $getCoaInventory = $coaInventory->code;
//                    $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
//                    $jurnalUmumInventory = new JurnalUmum;
//                    $jurnalUmumInventory->kode_transaksi = $movement->movement_in_number;
//                    $jurnalUmumInventory->tanggal_transaksi = $movement->date_posting;
//                    $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
//                    $jurnalUmumInventory->branch_id = $movement->branch_id;
//                    $jurnalUmumInventory->total = $jumlah;
//                    $jurnalUmumInventory->debet_kredit = 'K';
//                    $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumInventory->transaction_subject = 'Movement In';
//                    $jurnalUmumInventory->is_coa_category = 0;
//                    $jurnalUmumInventory->transaction_type = 'MI';
//                    $jurnalUmumInventory->save();

    //                $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code' => '104.00.000'));
    //                $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
    //                $jurnalUmumMasterGroupPersediaan->kode_transaksi = $movement->movement_in_number;
    //                $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $movement->date_posting;
    //                $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
    //                $jurnalUmumMasterGroupPersediaan->branch_id = $movement->branch_id;
    //                $jurnalUmumMasterGroupPersediaan->total = $jumlah;
    //                $jurnalUmumMasterGroupPersediaan->debet_kredit = 'D';
    //                $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
    //                $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Movement In';
    //                $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
    //                $jurnalUmumMasterGroupPersediaan->transaction_type = 'MI';
    //                $jurnalUmumMasterGroupPersediaan->save();

                    //save product master coa persediaan 
//                    $coaMasterPersediaan = Coa::model()->findByPk($movementDetail->product->productMasterCategory->coaPersediaanBarangDagang->id);
//                    $getCoaMasterPersediaan = $coaMasterPersediaan->code;
//                    $coaMasterPersediaanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterPersediaan));
//                    $jurnalUmumMasterPersediaan = new JurnalUmum;
//                    $jurnalUmumMasterPersediaan->kode_transaksi = $movement->movement_in_number;
//                    $jurnalUmumMasterPersediaan->tanggal_transaksi = $movement->date_posting;
//                    $jurnalUmumMasterPersediaan->coa_id = $coaMasterPersediaanWithCode->id;
//                    $jurnalUmumMasterPersediaan->branch_id = $movement->branch_id;
//                    $jurnalUmumMasterPersediaan->total = $jumlah;
//                    $jurnalUmumMasterPersediaan->debet_kredit = 'D';
//                    $jurnalUmumMasterPersediaan->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterPersediaan->transaction_subject = 'Movement In';
//                    $jurnalUmumMasterPersediaan->is_coa_category = 1;
//                    $jurnalUmumMasterPersediaan->transaction_type = 'MI';
//                    $jurnalUmumMasterPersediaan->save();
//
//                    //save product sub master coa persediaan 
//                    $coaPersediaan = Coa::model()->findByPk($movementDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->id);
//                    $getCoaPersediaan = $coaPersediaan->code;
//                    $coaPersediaanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPersediaan));
//
//                    $jurnalUmumPersediaan = new JurnalUmum;
//                    $jurnalUmumPersediaan->kode_transaksi = $movement->movement_in_number;
//                    $jurnalUmumPersediaan->tanggal_transaksi = $movement->date_posting;
//                    $jurnalUmumPersediaan->coa_id = $coaPersediaanWithCode->id;
//                    $jurnalUmumPersediaan->branch_id = $movement->branch_id;
//                    $jurnalUmumPersediaan->total = $jumlah;
//                    $jurnalUmumPersediaan->debet_kredit = 'D';
//                    $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumPersediaan->transaction_subject = 'Movement In';
//                    $jurnalUmumPersediaan->is_coa_category = 0;
//                    $jurnalUmumPersediaan->transaction_type = 'MI';
//                    $jurnalUmumPersediaan->save();
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