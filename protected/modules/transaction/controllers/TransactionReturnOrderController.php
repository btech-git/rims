<?php

class TransactionReturnOrderController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseReturnEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnApproval')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view' 
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate')) || !(Yii::app()->user->checkAccess('purchaseReturnEdit')) || !(Yii::app()->user->checkAccess('purchaseReturnApproval')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $returnDetails = TransactionReturnOrderDetail::model()->findAllByAttributes(array('return_order_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'returnDetails' => $returnDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        
        $receive = new TransactionReceiveItem('search');
        $receive->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionReceiveItem']))
            $receive->attributes = $_GET['TransactionReceiveItem'];

        $receiveCriteria = new CDbCriteria;
        $receiveCriteria->together = 'true';
        $receiveCriteria->with = array('supplier');
        $receiveCriteria->compare('receive_item_no', $receive->receive_item_no . '%', true, 'AND', false);
        $receiveCriteria->compare('receive_item_date', $receive->receive_item_date, true);
        $receiveCriteria->compare('supplier.name', $receive->supplier_name, true);

        $receiveDataProvider = new CActiveDataProvider('TransactionReceiveItem', array(
            'criteria' => $receiveCriteria,
        ));

        $returnOrder = $this->instantiate(null);
        $returnOrder->header->recipient_branch_id = $returnOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $returnOrder->header->recipient_branch_id;
        $returnOrder->header->date_created = date('Y-m-d H:i:s');
        $this->performAjaxValidation($returnOrder->header);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionReturnOrder'])) {
            $this->loadState($returnOrder);
            $returnOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($returnOrder->header->return_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($returnOrder->header->return_order_date)), $returnOrder->header->recipient_branch_id);

            if ($returnOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $returnOrder->header->id));
            }
        }

        $this->render('create', array(
            'returnOrder' => $returnOrder,
            'receive' => $receive,
            'receiveDataProvider' => $receiveDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        // $model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['TransactionReturnOrder']))
        // {
        // 	$model->attributes=$_POST['TransactionReturnOrder'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('update',array(
        // 	'model'=>$model,
        // ));
        $receive = new TransactionReceiveItem('search');
        $receive->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionReceiveItem']))
            $receive->attributes = $_GET['TransactionReceiveItem'];

        $receiveCriteria = new CDbCriteria;
        $receiveCriteria->compare('receive_item_no', $receive->receive_item_no . '%', true, 'AND', false);

        $receiveDataProvider = new CActiveDataProvider('TransactionReceiveItem', array(
                    'criteria' => $receiveCriteria,
                ));

        $returnOrder = $this->instantiate($id);
        $returnOrder->header->setCodeNumberByRevision('return_order_no');

        $this->performAjaxValidation($returnOrder->header);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionReturnOrder'])) {
            $this->loadState($returnOrder);
            if ($returnOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $returnOrder->header->id));
            }
        }

        $this->render('update', array(
            'returnOrder' => $returnOrder,
            'receive' => $receive,
            'receiveDataProvider' => $receiveDataProvider,
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

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $requestType, $requestId) {
        if (Yii::app()->request->isAjaxRequest) {

            $returnOrder = $this->instantiate($id);
            $this->loadState($returnOrder);

            $returnOrder->addDetail($requestType, $requestId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnOrder' => $returnOrder
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetailRequest($id) {
        if (Yii::app()->request->isAjaxRequest) {



            $returnOrder = $this->instantiate($id);
            $this->loadState($returnOrder);

            $returnOrder->removeDetailAt();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnOrder' => $returnOrder
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {



            $returnOrder = $this->instantiate($id);
            $this->loadState($returnOrder);

            $returnOrder->removeDetail($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnOrder' => $returnOrder
                    ), false, true);
        }
    }

    public function actionAjaxPurchase($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier_name = "";
            $purchase = TransactionPurchaseOrder::model()->findByPk($id);
            if ($purchase->supplier_id != "") {
                $supplier = Supplier::model()->findByPk($purchase->supplier_id);
                $supplier_name = $supplier->name;
            }


            $object = array(
                'id' => $purchase->id,
                'no' => $purchase->purchase_order_no,
                'date' => $purchase->purchase_order_date,
                'eta' => $purchase->estimate_date_arrival,
                'supplier' => $purchase->supplier_id,
                'supplier_name' => $supplier_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxConsignment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier_name = "";
            $consignment = ConsignmentInHeader::model()->findByPk($id);
            if ($consignment->supplier_id != "") {
                $supplier = Supplier::model()->findByPk($consignment->supplier_id);
                $supplier_name = $supplier->name;
            }


            $object = array(
                'id' => $consignment->id,
                'no' => $consignment->consignment_in_number,
                'date' => $consignment->date_posting,
                'eta' => $consignment->date_arrival,
                'supplier' => $consignment->supplier_id,
                'supplier_name' => $supplier_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxTransfer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $transfer = TransactionDeliveryOrder::model()->findByPk($id);

            if ($transfer->sender_branch_id != "")
                $branch = Branch::model()->findByPk($transfer->sender_branch_id);

            $object = array(
                'id' => $transfer->id,
                'no' => $transfer->delivery_order_no,
                'date' => $transfer->delivery_date,
                'eta' => $transfer->estimate_arrival_date,
                'branch' => $transfer->sender_branch_id,
                'branch_name' => $branch->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxReceive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $receive = TransactionReceiveItem::model()->findByPk($id);

            $object = array(
                'id' => $receive->id,
                'no' => $receive->receive_item_no,
                'type' => $receive->request_type,
                'purchase' => $receive->purchase_order_id,
                'transfer' => $receive->delivery_order_id,
                'consignment' => $receive->consignment_in_id
            );

            echo CJSON::encode($object);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('TransactionReturnOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionReturnOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionReturnOrder']))
            $model->attributes = $_GET['TransactionReturnOrder'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionReturnOrder the loaded model
     * @throws CHttpException
     */
    public function instantiate($id) {
        if (empty($id)) {
            $returnOrder = new ReturnOrders(new TransactionReturnOrder(), array());
            //print_r("test");
        } else {
            $returnOrderModel = $this->loadModel($id);
            $returnOrder = new ReturnOrders($returnOrderModel, $returnOrderModel->transactionReturnOrderDetails);
            //print_r("test");
        }
        return $returnOrder;
    }

    public function loadState($returnOrder) {
        if (isset($_POST['TransactionReturnOrder'])) {
            $returnOrder->header->attributes = $_POST['TransactionReturnOrder'];
        }


        if (isset($_POST['TransactionReturnOrderDetail'])) {
            foreach ($_POST['TransactionReturnOrderDetail'] as $i => $item) {
                if (isset($returnOrder->details[$i])) {
                    $returnOrder->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionReturnOrderDetail();
                    $detail->attributes = $item;
                    $returnOrder->details[] = $detail;
                }
            }
            if (count($_POST['TransactionReturnOrderDetail']) < count($returnOrder->details))
                array_splice($returnOrder->details, $i + 1);
        }
        else {
            $returnOrder->details = array();
        }
    }

    public function loadModel($id) {
        $model = TransactionReturnOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionReturnOrder $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-return-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateApproval($headerId) {
        $returnOrder = TransactionReturnOrder::model()->findByPK($headerId);
        $historis = TransactionReturnOrderApproval::model()->findAllByAttributes(array('return_order_id' => $headerId));
        $model = new TransactionReturnOrderApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPk($returnOrder->recipient_branch_id);

        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $returnOrder->return_order_no,
            'branch_id' => $returnOrder->recipient_branch_id,
        ));

        //$branch = Branch::model()->findByPk($paymentOut->branch_id);
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['TransactionReturnOrderApproval'])) {
            $model->attributes = $_POST['TransactionReturnOrderApproval'];
            if ($model->save()) {
                
                $returnOrder->status = $model->approval_type;
                $returnOrder->save(false);
                
                if ($model->approval_type == 'Approved') {
                    $receive = TransactionReceiveItem::model()->findByPk($returnOrder->receive_item_id);
                    $jumlah = 0;
                    $branch = Branch::model()->findByPk($returnOrder->recipient_branch_id);
                    
//                    $getCoaKas = '101.00.000';
//                    $coaKasWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKas));
//                    $jurnalUmumKas = new JurnalUmum;
//                    $jurnalUmumKas->kode_transaksi = $returnOrder->return_order_no;
//                    $jurnalUmumKas->tanggal_transaksi = $returnOrder->return_order_date;
//                    $jurnalUmumKas->coa_id = $coaKasWithCode->id;
//                    $jurnalUmumKas->branch_id = $returnOrder->recipient_branch_id;
//                    $jurnalUmumKas->total = $returnOrder->totalDetail * 1.1;
//                    $jurnalUmumKas->debet_kredit = 'D';
//                    $jurnalUmumKas->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumKas->transaction_subject = $returnOrder->supplier->name;
//                    $jurnalUmumKas->is_coa_category = 0;
//                    $jurnalUmumKas->transaction_type = 'RTO';
//                    $jurnalUmumKas->save();

                    foreach ($returnOrder->transactionReturnOrderDetails as $key => $returnDetail) {
                        $jumlah = $returnDetail->price * $returnDetail->qty_reject;

                        $jurnalUmumRetur = new JurnalUmum;
                        $jurnalUmumRetur->kode_transaksi = $returnOrder->return_order_no;
                        $jurnalUmumRetur->tanggal_transaksi = $returnOrder->return_order_date;
                        $jurnalUmumRetur->coa_id = $returnDetail->product->productSubMasterCategory->coa_retur_pembelian;
                        $jurnalUmumRetur->branch_id = $returnOrder->recipient_branch_id;
                        $jurnalUmumRetur->total = $jumlah;
                        $jurnalUmumRetur->debet_kredit = 'K';
                        $jurnalUmumRetur->tanggal_posting = date('Y-m-d');
                        $jurnalUmumRetur->transaction_subject = $returnOrder->supplier->name;
                        $jurnalUmumRetur->is_coa_category = 0;
                        $jurnalUmumRetur->transaction_type = 'RTO';
                        $jurnalUmumRetur->save();
                        
                        //save product master category coa inventory in transit
//                        $coaMasterInventory = Coa::model()->findByPk($receiveDetail->product->productMasterCategory->coaInventoryInTransit->id);
//                        $getCoaMasterInventory = $coaMasterInventory->code;
//                        $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
//                        $jurnalUmumMasterPersediaan = new JurnalUmum;
//                        $jurnalUmumMasterPersediaan->kode_transaksi = $returnOrder->return_order_no;
//                        $jurnalUmumMasterPersediaan->tanggal_transaksi = $returnOrder->return_order_date;
//                        $jurnalUmumMasterPersediaan->coa_id = $coaMasterInventoryWithCode->id;
//                        $jurnalUmumMasterPersediaan->branch_id = $returnOrder->recipient_branch_id;
//                        $jurnalUmumMasterPersediaan->total = $jumlah;
//                        $jurnalUmumMasterPersediaan->debet_kredit = 'K';
//                        $jurnalUmumMasterPersediaan->tanggal_posting = date('Y-m-d');
//                        $jurnalUmumMasterPersediaan->transaction_subject = $returnOrder->supplier->name;
//                        $jurnalUmumMasterPersediaan->is_coa_category = 1;
//                        $jurnalUmumMasterPersediaan->transaction_type = 'RTO';
//                        $jurnalUmumMasterPersediaan->save();

                        //save product sub master category coa inventory in transit
                        $coaInventory = Coa::model()->findByPk($returnDetail->product->productSubMasterCategory->coa_inventory_in_transit);
                        $getCoaInventory = $coaInventory->code;
                        $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                        $jurnalUmumPersediaan = new JurnalUmum;
                        $jurnalUmumPersediaan->kode_transaksi = $returnOrder->return_order_no;
                        $jurnalUmumPersediaan->tanggal_transaksi = $returnOrder->return_order_date;
                        $jurnalUmumPersediaan->coa_id = $coaInventoryWithCode->id;
                        $jurnalUmumPersediaan->branch_id = $returnOrder->recipient_branch_id;
                        $jurnalUmumPersediaan->total = $jumlah;
                        $jurnalUmumPersediaan->debet_kredit = 'D';
                        $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPersediaan->transaction_subject = $returnOrder->supplier->name;
                        $jurnalUmumPersediaan->is_coa_category = 0;
                        $jurnalUmumPersediaan->transaction_type = 'RTO';
                        $jurnalUmumPersediaan->save();

//                        $getCoaPpn = '108.00.000';
//                        $coaPpnWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPpn));
//                        $jurnalPpn = new JurnalUmum;
//                        $jurnalPpn->kode_transaksi = $returnOrder->return_order_no;
//                        $jurnalPpn->tanggal_transaksi = $returnOrder->return_order_date;
//                        $jurnalPpn->coa_id = $coaPpnWithCode->id;
//                        $jurnalPpn->branch_id = $returnOrder->recipient_branch_id;
//                        $jurnalPpn->total = $jumlah * 0.1;
//                        $jurnalPpn->debet_kredit = 'K';
//                        $jurnalPpn->tanggal_posting = date('Y-m-d');
//                        $jurnalPpn->transaction_subject = $returnOrder->supplier->name;
//                        $jurnalPpn->is_coa_category = 0;
//                        $jurnalPpn->transaction_type = 'RTO';
//                        $jurnalPpn->save();
                    }
                }

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'returnOrder' => $returnOrder,
            'historis' => $historis,
                //'jenisPersediaan'=>$jenisPersediaan,
                //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

}
