<?php

class TransactionReturnItemController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('saleReturnCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleReturnEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('saleReturnApproval')) || !(Yii::app()->user->checkAccess('saleReturnSupervisor')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('saleReturnCreate')) || !(Yii::app()->user->checkAccess('saleReturnEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $returnDetails = TransactionReturnItemDetail::model()->findAllByAttributes(array('return_item_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'returnDetails' => $returnDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($transactionId, $returnType) { 
        
        $returnItem = $this->instantiate(null);
        $returnItem->header->recipient_branch_id = $returnItem->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $returnItem->header->recipient_branch_id;
        $returnItem->header->created_datetime = date('Y-m-d H:i:s');
        $returnItem->header->status = 'Draft';
        
        if ($returnType == 1) {
            $deliveryOrder = TransactionDeliveryOrder::model()->findByPk($transactionId);
            $returnItem->header->request_type = 'Delivery Order';
            $returnItem->header->delivery_order_id = $transactionId;
            $returnItem->header->transfer_request_id = empty($deliveryOrder->transfer_request_id) ? null : $deliveryOrder->transfer_request_id;
            $returnItem->header->sent_request_id = empty($deliveryOrder->sent_request_id) ? null : $deliveryOrder->sent_request_id;
            $returnItem->header->consignment_out_id = empty($deliveryOrder->consignment_out_id) ? null : $deliveryOrder->consignment_out_id;
            $returnItem->header->sales_order_id = empty($deliveryOrder->sales_order_id) ? null : $deliveryOrder->sales_order_id;
            $returnItem->header->registration_transaction_id = null;
            $returnItem->header->customer_id = empty($deliveryOrder->customer_id) ? null : $deliveryOrder->customer_id;
            $returnItem->header->destination_branch = empty($deliveryOrder->destination_branch) ? User::model()->findByPk(Yii::app()->user->getId())->branch_id : $deliveryOrder->destination_branch;
            $returnItem->header->request_date = $deliveryOrder->request_date;
            $returnItem->header->estimate_arrival_date = $deliveryOrder->estimate_arrival_date;
        } else {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($transactionId);
            $returnItem->header->request_type = 'Retail Sales';
            $returnItem->header->delivery_order_id = null;
            $returnItem->header->transfer_request_id = null;
            $returnItem->header->sent_request_id = null;
            $returnItem->header->consignment_out_id = null;
            $returnItem->header->sales_order_id = null;
            $returnItem->header->registration_transaction_id = $transactionId;
            $returnItem->header->customer_id = empty($registrationTransaction->customer_id) ? null : $registrationTransaction->customer_id;
            $returnItem->header->destination_branch = Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id;
            $returnItem->header->request_date = date('Y-m-d');
            $returnItem->header->estimate_arrival_date = date('Y-m-d');
        }
        $this->performAjaxValidation($returnItem->header);

        $returnItem->addDetails($transactionId, $returnType);
        
        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionReturnItem']) && IdempotentManager::check()) {
            $this->loadState($returnItem);
            $returnItem->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($returnItem->header->return_item_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($returnItem->header->return_item_date)), $returnItem->header->recipient_branch_id);

            if ($returnItem->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $returnItem->header->id));
            }
        }

        $this->render('create', array(
            'returnItem' => $returnItem,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $transfer = new TransactionSentRequest('search');
        $transfer->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest']))
            $transfer->attributes = $_GET['TransactionSentRequest'];

        $transferCriteria = new CDbCriteria;
        $transferCriteria->compare('sent_request_no', $transfer->sent_request_no . '%', true, 'AND', false);

        $transferDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
            'criteria' => $transferCriteria,
        ));

        $sales = new TransactionSalesOrder('search');
        $sales->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSalesOrder'])) {
            $sales->attributes = $_GET['TransactionSalesOrder'];
        }

        $salesCriteria = new CDbCriteria;
        $salesCriteria->compare('sale_order_no', $sales->sale_order_no . '%', true, 'AND', false);

        $salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
            'criteria' => $salesCriteria,
        ));

        $delivery = new TransactionDeliveryOrder('search');
        $delivery->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionDeliveryOrder'])) {
            $delivery->attributes = $_GET['TransactionDeliveryOrder'];
        }

        $deliveryCriteria = new CDbCriteria;
        $deliveryCriteria->compare('delivery_order_no', $delivery->delivery_order_no . '%', true, 'AND', false);

        $deliveryDataProvider = new CActiveDataProvider('TransactionDeliveryOrder', array(
            'criteria' => $deliveryCriteria,
        ));

        $returnItem = $this->instantiate($id);
        $returnItem->header->setCodeNumberByRevision('return_item_no');

        $this->performAjaxValidation($returnItem->header);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionReturnItem']) && IdempotentManager::check()) {
            $this->loadState($returnItem);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $returnItem->header->return_item_no,
                'branch_id' => $returnItem->header->recipient_branch_id,
            ));

            if ($returnItem->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $returnItem->header->id));
            } else {
                foreach ($returnItem->details as $detail) {
                    echo $detail->quantity;
                }
            }
        }

        $this->render('update', array(
            'returnItem' => $returnItem,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
            'sales' => $sales,
            'salesDataProvider' => $salesDataProvider,
            'delivery' => $delivery,
            'deliveryDataProvider' => $deliveryDataProvider,
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
        $dataProvider = new CActiveDataProvider('TransactionReturnItem');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionReturnItem('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionReturnItem'])) {
            $model->attributes = $_GET['TransactionReturnItem'];
        }
        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('recipient_branch_id', Yii::app()->user->branch_ids);

        $retailTransaction = new RegistrationTransaction('search');
        $retailTransaction->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $retailTransaction->attributes = $_GET['RegistrationTransaction'];
        }
        $retailTransactionDataProvider = $retailTransaction->search();
        $retailTransactionDataProvider->criteria->compare('transaction_number', $retailTransaction->transaction_number . '%', true, 'AND', false);
        $retailTransactionDataProvider->criteria->addCondition("total_product > 0 AND t.transaction_date > '2021-12-31'");

        $delivery = new TransactionDeliveryOrder('search');
        $delivery->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionDeliveryOrder'])) {
            $delivery->attributes = $_GET['TransactionDeliveryOrder'];
        }
        $deliveryCriteria = new CDbCriteria;
        $deliveryCriteria->compare('delivery_order_no', $delivery->delivery_order_no . '%', true, 'AND', false);
        $deliveryCriteria->compare('delivery_date', $delivery->delivery_date, true);
        $deliveryCriteria->compare('request_type', $delivery->request_type, true);
        $deliveryDataProvider = new CActiveDataProvider('TransactionDeliveryOrder', array(
            'criteria' => $deliveryCriteria,
            'sort' => array(
                'defaultOrder' => 'delivery_date DESC',
            ),
        ));
        $deliveryDataProvider->criteria->addCondition("t.delivery_date > '2021-12-31'");

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'retailTransaction' => $retailTransaction,
            'retailTransactionDataProvider' => $retailTransactionDataProvider,
            'delivery' => $delivery,
            'deliveryDataProvider' => $deliveryDataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionReturnItem the loaded model
     * @throws CHttpException
     */
    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $requestType, $requestId) {
        if (Yii::app()->request->isAjaxRequest) {

            $returnItem = $this->instantiate($id);
            $this->loadState($returnItem);

            $returnItem->addDetail($requestType, $requestId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnItem' => $returnItem), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetailRequest($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $returnItem = $this->instantiate($id);
            $this->loadState($returnItem);

            $returnItem->removeDetailAt();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnItem' => $returnItem), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $returnItem = $this->instantiate($id);
            $this->loadState($returnItem);

            $returnItem->removeDetail($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('returnItem' => $returnItem), false, true);
        }
    }

    public function actionAjaxSales($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer_name = "";
            $sales = TransactionSalesOrder::model()->findByPk($id);
            if ($sales->customer_id != "") {
                $customer = Customer::model()->findByPk($sales->customer_id);
                $customer_name = $customer->name;
            }

            $object = array(
                'id' => $sales->id,
                'no' => $sales->sale_order_no,
                'date' => $sales->sale_order_date,
                'eta' => $sales->estimate_arrival_date,
                'customer' => $sales->customer_id,
                'customer_name' => $customer->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxSent($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $transfer = TransactionSentRequest::model()->findByPk($id);

            if ($transfer->requester_branch_id != "")
                $branch = Branch::model()->findByPk($transfer->requester_branch_id);

            $object = array(
                'id' => $transfer->id,
                'no' => $transfer->sent_request_no,
                'date' => $transfer->sent_request_date,
                'eta' => empty($transfer->estimate_arrival_date) ? date('Y-m-d') : $transfer->estimate_arrival_date,
                'branch' => $transfer->requester_branch_id,
                'branch_name' => $branch->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxTransfer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $transfer = TransactionTransferRequest::model()->findByPk($id);

            if ($transfer->requester_branch_id != "")
                $branch = Branch::model()->findByPk($transfer->requester_branch_id);

            $object = array(
                'id' => $transfer->id,
                'no' => $transfer->transfer_request_no,
                'date' => $transfer->transfer_request_date,
                'eta' => empty($transfer->estimate_arrival_date) ? date('Y-m-d') : $transfer->estimate_arrival_date,
                'branch' => $transfer->requester_branch_id,
                'branch_name' => $branch->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxConsignment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer_name = "";
            $consignment = ConsignmentOutHeader::model()->findByPk($id);
            if ($consignment->customer_id != "") {
                $customer = Customer::model()->findByPk($consignment->customer_id);
                $customer_name = $customer->name;
            }

            $object = array(
                'id' => $consignment->id,
                'no' => $consignment->consignment_out_no,
                'date' => $consignment->date_posting,
                'eta' => $consignment->delivery_date,
                'customer' => $consignment->customer_id,
                'customer_name' => $customer_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxDelivery($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $delivery = TransactionDeliveryOrder::model()->findByPk($id);

            $object = array(
                'id' => $delivery->id,
                'no' => $delivery->delivery_order_no,
                'type' => $delivery->request_type,
                'sales' => $delivery->sales_order_id,
                'sent' => $delivery->sent_request_id,
                'consignment' => $delivery->consignment_out_id,
                'transfer' => $delivery->transfer_request_id,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = Customer::model()->findByPk($id);

            $object = array(
                'id' => $customer->id,
                'name' => $customer->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $returnItem = new ReturnItems(new TransactionReturnItem(), array());
        } else {
            $returnItemModel = $this->loadModel($id);
            $returnItem = new ReturnItems($returnItemModel, $returnItemModel->transactionReturnItemDetails);
        }
        return $returnItem;
    }

    public function loadState($returnItem) {
        if (isset($_POST['TransactionReturnItem'])) {
            $returnItem->header->attributes = $_POST['TransactionReturnItem'];
        }

        if (isset($_POST['TransactionReturnItemDetail'])) {
            foreach ($_POST['TransactionReturnItemDetail'] as $i => $item) {
                if (isset($returnItem->details[$i])) {
                    $returnItem->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionReturnItemDetail();
                    $detail->attributes = $item;
                    $returnItem->details[] = $detail;
                }
            }
            if (count($_POST['TransactionReturnItemDetail']) < count($returnItem->details))
                array_splice($returnItem->details, $i + 1);
        }
        else {
            $returnItem->details = array();
        }
    }

    public function loadModel($id) {
        $model = TransactionReturnItem::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionReturnItem $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-return-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionUpdateApproval($headerId) {
        $returnItem = TransactionReturnItem::model()->findByPK($headerId);
        $historis = TransactionReturnItemApproval::model()->findAllByAttributes(array('return_item_id' => $headerId));
        $model = new TransactionReturnItemApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPk($returnItem->recipient_branch_id);
        
        if (isset($_POST['TransactionReturnItemApproval'])) {
            $model->attributes = $_POST['TransactionReturnItemApproval'];
            if ($model->save()) {

                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $returnItem->return_item_no,
                    'branch_id' => $returnItem->recipient_branch_id,
                ));

                $returnItem->status = $model->approval_type;
                $returnItem->save(false);
                $jumlah = 0;
                $branch = Branch::model()->findByPk($returnItem->recipient_branch_id);
                if ($model->approval_type == 'Approved') {
                    foreach ($returnItem->transactionReturnItemDetails as $key => $deliveryDetail) {
                        $jumlah = $deliveryDetail->price * $deliveryDetail->quantity;

                        $jurnalUmumMasterRetur = new JurnalUmum;
                        $jurnalUmumMasterRetur->kode_transaksi = $returnItem->return_item_no;
                        $jurnalUmumMasterRetur->tanggal_transaksi = $returnItem->return_item_date;
                        $jurnalUmumMasterRetur->coa_id = $deliveryDetail->product->productMasterCategory->coa_retur_penjualan;
                        $jurnalUmumMasterRetur->branch_id = $returnItem->recipient_branch_id;
                        $jurnalUmumMasterRetur->total = $jumlah;
                        $jurnalUmumMasterRetur->debet_kredit = 'D';
                        $jurnalUmumMasterRetur->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterRetur->transaction_subject = 'Retur Penjualan';
                        $jurnalUmumMasterRetur->is_coa_category = 1;
                        $jurnalUmumMasterRetur->transaction_type = 'RTI';
                        $jurnalUmumMasterRetur->save();
                        
                        $jurnalUmumRetur = new JurnalUmum;
                        $jurnalUmumRetur->kode_transaksi = $returnItem->return_item_no;
                        $jurnalUmumRetur->tanggal_transaksi = $returnItem->return_item_date;
                        $jurnalUmumRetur->coa_id = $deliveryDetail->product->productSubMasterCategory->coa_retur_penjualan;
                        $jurnalUmumRetur->branch_id = $returnItem->recipient_branch_id;
                        $jurnalUmumRetur->total = $jumlah;
                        $jurnalUmumRetur->debet_kredit = 'D';
                        $jurnalUmumRetur->tanggal_posting = date('Y-m-d');
                        $jurnalUmumRetur->transaction_subject = 'Retur Penjualan';
                        $jurnalUmumRetur->is_coa_category = 0;
                        $jurnalUmumRetur->transaction_type = 'RTI';
                        $jurnalUmumRetur->save();

                        // save product master coa retur
                        $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                        $jurnalUmumMasterOutstandingPart->kode_transaksi = $returnItem->return_item_no;
                        $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $returnItem->return_item_date;
                        $jurnalUmumMasterOutstandingPart->coa_id = $deliveryDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                        $jurnalUmumMasterOutstandingPart->branch_id = $returnItem->recipient_branch_id;
                        $jurnalUmumMasterOutstandingPart->total = $jumlah;
                        $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                        $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                        $jurnalUmumMasterOutstandingPart->transaction_subject = 'Retur Penjualan';
                        $jurnalUmumMasterOutstandingPart->transaction_type = 'RTI';
                        $jurnalUmumMasterOutstandingPart->save();

//                        // save product master category coa hpp
                        $jurnalMasterUmumHpp = new JurnalUmum;
                        $jurnalMasterUmumHpp->kode_transaksi = $returnItem->return_item_no;
                        $jurnalMasterUmumHpp->tanggal_transaksi = $returnItem->return_item_date;
                        $jurnalMasterUmumHpp->coa_id = $deliveryDetail->product->productMasterCategory->coa_hpp;
                        $jurnalMasterUmumHpp->branch_id = $returnItem->recipient_branch_id;
                        $jurnalMasterUmumHpp->total = $jumlah;
                        $jurnalMasterUmumHpp->debet_kredit = 'K';
                        $jurnalMasterUmumHpp->tanggal_posting = date('Y-m-d');
                        $jurnalMasterUmumHpp->is_coa_category = 1;
                        $jurnalMasterUmumHpp->transaction_subject = 'Retur Penjualan';
                        $jurnalMasterUmumHpp->transaction_type = 'RTI';
                        $jurnalMasterUmumHpp->save();

//                        // save product sub master category coa hpp
                        $jurnalUmumHpp = new JurnalUmum;
                        $jurnalUmumHpp->kode_transaksi = $returnItem->return_item_no;
                        $jurnalUmumHpp->tanggal_transaksi = $returnItem->return_item_date;
                        $jurnalUmumHpp->coa_id = $deliveryDetail->product->productSubMasterCategory->coa_hpp;
                        $jurnalUmumHpp->branch_id = $returnItem->recipient_branch_id;
                        $jurnalUmumHpp->total = $jumlah;
                        $jurnalUmumHpp->debet_kredit = 'K';
                        $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
                        $jurnalUmumHpp->is_coa_category = 0;
                        $jurnalUmumHpp->transaction_subject = 'Retur Penjualan';
                        $jurnalUmumHpp->transaction_type = 'RTI';
                        $jurnalUmumHpp->save();

                    }
                    
                    if (!empty($returnItem->customer_id)) {
                        $jurnalUmumReceivable = new JurnalUmum;
                        $jurnalUmumReceivable->kode_transaksi = $returnItem->return_item_no;
                        $jurnalUmumReceivable->tanggal_transaksi = $returnItem->return_item_date;
                        $jurnalUmumReceivable->coa_id = $returnItem->customer->coa_id;
                        $jurnalUmumReceivable->branch_id = $returnItem->recipient_branch_id;
                        $jurnalUmumReceivable->total = $returnItem->totalDetail * 1.11;
                        $jurnalUmumReceivable->debet_kredit = 'K';
                        $jurnalUmumReceivable->tanggal_posting = date('Y-m-d');
                        $jurnalUmumReceivable->is_coa_category = 0;
                        $jurnalUmumReceivable->transaction_subject = 'Retur Penjualan';
                        $jurnalUmumReceivable->transaction_type = 'RTI';
                        $jurnalUmumReceivable->save();
                    }

                    $coaPpnWithCode = Coa::model()->findByAttributes(array('code' => '143.00.001'));
                    $jurnalPpn = new JurnalUmum;
                    $jurnalPpn->kode_transaksi = $returnItem->return_item_no;
                    $jurnalPpn->tanggal_transaksi = $returnItem->return_item_date;
                    $jurnalPpn->coa_id = $coaPpnWithCode->id;
                    $jurnalPpn->branch_id = $returnItem->recipient_branch_id;
                    $jurnalPpn->total = $returnItem->totalDetail * 0.11;
                    $jurnalPpn->debet_kredit = 'D';
                    $jurnalPpn->tanggal_posting = date('Y-m-d');
                    $jurnalPpn->is_coa_category = 0;
                    $jurnalPpn->transaction_subject = 'Retur Penjualan';
                    $jurnalPpn->transaction_type = 'RTI';
                    $jurnalPpn->save();

                }

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'returnItem' => $returnItem,
            'historis' => $historis,
        ));
    }
}
