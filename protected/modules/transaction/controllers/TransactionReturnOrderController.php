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
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseReturnEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('purchaseReturnApproval') || Yii::app()->user->checkAccess('purchaseReturnSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view' 
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit') || Yii::app()->user->checkAccess('purchaseReturnView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $returnDetails = TransactionReturnOrderDetail::model()->findAllByAttributes(array('return_order_id' => $id));
        
        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->return_order_no,
            ));

            if (!empty($model->supplier_id)) {
                $jurnalUmumHutang = new JurnalUmum;
                $jurnalUmumHutang->kode_transaksi = $model->return_order_no;
                $jurnalUmumHutang->tanggal_transaksi = $model->return_order_date;
                $jurnalUmumHutang->coa_id = $model->supplier->coa_id;
                $jurnalUmumHutang->branch_id = $model->recipient_branch_id;
                $jurnalUmumHutang->total = $model->totalDetail;
                $jurnalUmumHutang->debet_kredit = 'D';
                $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
                $jurnalUmumHutang->transaction_subject = $model->supplier->name;
                $jurnalUmumHutang->is_coa_category = 0;
                $jurnalUmumHutang->transaction_type = 'RTO';
                $jurnalUmumHutang->save();
            }

            foreach ($model->transactionReturnOrderDetails as $key => $returnDetail) {
                $jumlah = $returnDetail->price * $returnDetail->qty_reject;

                $jurnalUmumRetur = new JurnalUmum;
                $jurnalUmumRetur->kode_transaksi = $model->return_order_no;
                $jurnalUmumRetur->tanggal_transaksi = $model->return_order_date;
                $jurnalUmumRetur->coa_id = $returnDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumRetur->branch_id = $model->recipient_branch_id;
                $jurnalUmumRetur->total = $jumlah;
                $jurnalUmumRetur->debet_kredit = 'K';
                $jurnalUmumRetur->tanggal_posting = date('Y-m-d');
                $jurnalUmumRetur->transaction_subject = $returnDetail->note;
                $jurnalUmumRetur->is_coa_category = 0;
                $jurnalUmumRetur->transaction_type = 'RTO';
                $jurnalUmumRetur->save();
                
                if (empty($model->supplier_id)) {
                    $jurnalUmumPersediaan = new JurnalUmum;
                    $jurnalUmumPersediaan->kode_transaksi = $model->return_order_no;
                    $jurnalUmumPersediaan->tanggal_transaksi = $model->return_order_date;
                    $jurnalUmumPersediaan->coa_id = $returnDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $jurnalUmumPersediaan->branch_id = $model->recipient_branch_id;
                    $jurnalUmumPersediaan->total = $jumlah;
                    $jurnalUmumPersediaan->debet_kredit = 'D';
                    $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
                    $jurnalUmumPersediaan->transaction_subject = $returnDetail->note;
                    $jurnalUmumPersediaan->is_coa_category = 0;
                    $jurnalUmumPersediaan->transaction_type = 'RTO';
                    $jurnalUmumPersediaan->save();
                }
            }
        }
        $this->render('view', array(
            'model' => $model,
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
        if (isset($_GET['TransactionReceiveItem'])) {
            $receive->attributes = $_GET['TransactionReceiveItem'];
        }

        $receiveCriteria = new CDbCriteria;
        $receiveCriteria->together = 'true';
        $receiveCriteria->with = array('supplier');
        $receiveCriteria->compare('receive_item_no', $receive->receive_item_no . '%', true, 'AND', false);
        $receiveCriteria->compare('receive_item_date', $receive->receive_item_date, true);
        $receiveCriteria->compare('supplier.name', $receive->supplier_name, true);

        $receiveDataProvider = new CActiveDataProvider('TransactionReceiveItem', array(
            'criteria' => $receiveCriteria,
        ));
        
        $receiveDataProvider->criteria->addCondition('t.receive_item_date > "2022-12-31"');

        $returnOrder = $this->instantiate(null);
        $returnOrder->header->return_order_date = date('Y-m-d');
        $returnOrder->header->created_datetime = date('Y-m-d H:i:s');
        $returnOrder->header->status = 'Draft';
        $returnOrder->header->recipient_branch_id = Yii::app()->user->branch_id;
        $this->performAjaxValidation($returnOrder->header);

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['TransactionReturnOrder']) && IdempotentManager::check()) {
            $this->loadState($returnOrder);
            
            if (!empty($returnOrder->header->recipient_branch_id)) {
                $returnOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($returnOrder->header->return_order_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($returnOrder->header->return_order_date)), $returnOrder->header->recipient_branch_id);
            }

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

        if (isset($_POST['TransactionReturnOrder']) && IdempotentManager::check()) {
            $this->loadState($returnOrder);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $returnOrder->header->return_order_no,
                'branch_id' => $returnOrder->header->recipient_branch_id,
            ));

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
            $this->renderPartial('_detail', array('returnOrder' => $returnOrder), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetailRequest($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $returnOrder = $this->instantiate($id);
            $this->loadState($returnOrder);

            $returnOrder->removeDetailAt();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnOrder' => $returnOrder), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $returnOrder = $this->instantiate($id);
            $this->loadState($returnOrder);

            $returnOrder->removeDetail($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnOrder' => $returnOrder), false, true);
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
        if (isset($_GET['TransactionReturnOrder'])) {
            $model->attributes = $_GET['TransactionReturnOrder'];
        }

        $dataProvider = $model->search();
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.recipient_branch_id = :recipient_branch_id');
            $dataProvider->criteria->params[':recipient_branch_id'] = Yii::app()->user->branch_id;
        }

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
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
        } else {
            $returnOrderModel = $this->loadModel($id);
            $returnOrder = new ReturnOrders($returnOrderModel, $returnOrderModel->transactionReturnOrderDetails);
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

        if (isset($_POST['TransactionReturnOrderApproval'])) {
            $model->attributes = $_POST['TransactionReturnOrderApproval'];
            if ($model->save()) {
                
                $returnOrder->status = $model->approval_type;
                $returnOrder->save(false);
                
                if ($model->approval_type == 'Approved') {
                    $jumlah = 0;
                    $branch = Branch::model()->findByPk($returnOrder->recipient_branch_id);
                    
                    if (!empty($returnOrder->supplier_id)) {
                        $jurnalUmumHutang = new JurnalUmum;
                        $jurnalUmumHutang->kode_transaksi = $returnOrder->return_order_no;
                        $jurnalUmumHutang->tanggal_transaksi = $returnOrder->return_order_date;
                        $jurnalUmumHutang->coa_id = $returnOrder->supplier->coa_id;
                        $jurnalUmumHutang->branch_id = $returnOrder->recipient_branch_id;
                        $jurnalUmumHutang->total = $returnOrder->totalDetail;
                        $jurnalUmumHutang->debet_kredit = 'D';
                        $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
                        $jurnalUmumHutang->transaction_subject = $returnOrder->supplier->name;
                        $jurnalUmumHutang->is_coa_category = 0;
                        $jurnalUmumHutang->transaction_type = 'RTO';
                        $jurnalUmumHutang->save();
                    }

                    foreach ($returnOrder->transactionReturnOrderDetails as $key => $returnDetail) {
                        $jumlah = $returnDetail->price * $returnDetail->qty_reject;

                        $jurnalUmumRetur = new JurnalUmum;
                        $jurnalUmumRetur->kode_transaksi = $returnOrder->return_order_no;
                        $jurnalUmumRetur->tanggal_transaksi = $returnOrder->return_order_date;
                        $jurnalUmumRetur->coa_id = $returnDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                        $jurnalUmumRetur->branch_id = $returnOrder->recipient_branch_id;
                        $jurnalUmumRetur->total = $jumlah;
                        $jurnalUmumRetur->debet_kredit = 'K';
                        $jurnalUmumRetur->tanggal_posting = date('Y-m-d');
                        $jurnalUmumRetur->transaction_subject = $returnDetail->note;
                        $jurnalUmumRetur->is_coa_category = 0;
                        $jurnalUmumRetur->transaction_type = 'RTO';
                        $jurnalUmumRetur->save();
                        
                        //save product sub master category coa inventory in transit
                        if (empty($returnOrder->supplier_id)) {
                            $jurnalUmumPersediaan = new JurnalUmum;
                            $jurnalUmumPersediaan->kode_transaksi = $returnOrder->return_order_no;
                            $jurnalUmumPersediaan->tanggal_transaksi = $returnOrder->return_order_date;
                            $jurnalUmumPersediaan->coa_id = $returnDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                            $jurnalUmumPersediaan->branch_id = $returnOrder->recipient_branch_id;
                            $jurnalUmumPersediaan->total = $jumlah;
                            $jurnalUmumPersediaan->debet_kredit = 'D';
                            $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
                            $jurnalUmumPersediaan->transaction_subject = $returnDetail->note;
                            $jurnalUmumPersediaan->is_coa_category = 0;
                            $jurnalUmumPersediaan->transaction_type = 'RTO';
                            $jurnalUmumPersediaan->save();
                        }
                    }
                }

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'returnOrder' => $returnOrder,
            'historis' => $historis,
        ));
    }

}
