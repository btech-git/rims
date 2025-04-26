<?php

class TransactionSentRequestController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('sentRequestCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('sentRequestEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('sentRequestApproval') || Yii::app()->user->checkAccess('sentRequestSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
                $filterChain->action->id === 'admin' ||
                $filterChain->action->id === 'index' ||
                $filterChain->action->id === 'view'
        ) {
            if (!(
                Yii::app()->user->checkAccess('sentRequestCreate') || 
                Yii::app()->user->checkAccess('sentRequestEdit') || 
                Yii::app()->user->checkAccess('sentRequestView') || 
                Yii::app()->user->checkAccess('sentRequestApproval')
            )) {
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
        $sentDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $id));

        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->sent_request_no,
            ));
            
            $transactionType = 'SR';
            $postingDate = date('Y-m-d');
            $transactionCode = $model->sent_request_no;
            $transactionDate = $model->sent_request_date;
            $branchId = $model->requester_branch_id;
            $transactionSubject = 'Sent Request Main';

            $journalReferences = array();
        
            $coaInterbranchRequester = BranchCoaInterbranch::model()->findByAttributes(array(
                'branch_id_from' => $model->requester_branch_id, 
                'branch_id_to' => $model->destination_branch_id,
            ));

            $jurnalUmumInterbranchRequester = new JurnalUmum;
            $jurnalUmumInterbranchRequester->kode_transaksi = $transactionCode;
            $jurnalUmumInterbranchRequester->tanggal_transaksi = $transactionDate;
            $jurnalUmumInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
            $jurnalUmumInterbranchRequester->branch_id = $branchId;
            $jurnalUmumInterbranchRequester->total = round($model->total_price, 0);
            $jurnalUmumInterbranchRequester->debet_kredit = 'D';
            $jurnalUmumInterbranchRequester->tanggal_posting = $postingDate;
            $jurnalUmumInterbranchRequester->transaction_subject = $transactionSubject;
            $jurnalUmumInterbranchRequester->is_coa_category = 0;
            $jurnalUmumInterbranchRequester->transaction_type = $transactionType;
            $jurnalUmumInterbranchRequester->save();

            foreach ($model->transactionSentRequestDetails as $detail) {

                //save coa persediaan product master
                $hppPrice = $detail->unit_price * $detail->quantity;

                $coaOutstandingPartId = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $journalReferences[$coaOutstandingPartId]['debet_kredit'] = 'K';
                $journalReferences[$coaOutstandingPartId]['is_coa_category'] = 0;
                $journalReferences[$coaOutstandingPartId]['values'][] = $hppPrice;
            }

            foreach ($journalReferences as $coaId => $journalReference) {
                $jurnalUmumOutstandingPartRequester = new JurnalUmum();
                $jurnalUmumOutstandingPartRequester->kode_transaksi = $transactionCode;
                $jurnalUmumOutstandingPartRequester->tanggal_transaksi = $transactionDate;
                $jurnalUmumOutstandingPartRequester->coa_id = $coaId;
                $jurnalUmumOutstandingPartRequester->branch_id = $branchId;
                $jurnalUmumOutstandingPartRequester->total = array_sum($journalReference['values']);
                $jurnalUmumOutstandingPartRequester->debet_kredit = $journalReference['debet_kredit'];
                $jurnalUmumOutstandingPartRequester->tanggal_posting = $postingDate;
                $jurnalUmumOutstandingPartRequester->transaction_subject = $transactionSubject;
                $jurnalUmumOutstandingPartRequester->is_coa_category = $journalReference['is_coa_category'];
                $jurnalUmumOutstandingPartRequester->transaction_type = $transactionType;
                $jurnalUmumOutstandingPartRequester->save();
            }
            
            $coaInterbranchDestination = BranchCoaInterbranch::model()->findByAttributes(array(
                'branch_id_from' => $model->destination_branch_id, 
                'branch_id_to' => $model->requester_branch_id,
            ));

            $jurnalUmumInterbranchDestination = new JurnalUmum;
            $jurnalUmumInterbranchDestination->kode_transaksi = $model->sent_request_no;
            $jurnalUmumInterbranchDestination->tanggal_transaksi = $model->sent_request_date;
            $jurnalUmumInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
            $jurnalUmumInterbranchDestination->branch_id = $model->destination_branch_id;
            $jurnalUmumInterbranchDestination->total = round($model->total_price, 0);
            $jurnalUmumInterbranchDestination->debet_kredit = 'K';
            $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
            $jurnalUmumInterbranchDestination->transaction_subject = 'Sent Request Destination';
            $jurnalUmumInterbranchDestination->is_coa_category = 0;
            $jurnalUmumInterbranchDestination->transaction_type = 'SR';
            $jurnalUmumInterbranchDestination->save();

            foreach ($model->transactionSentRequestDetails as $detail) {
                $hppPrice = $detail->unit_price * $detail->quantity;

                $jurnalUmumOutstandingPartDestination = new JurnalUmum;
                $jurnalUmumOutstandingPartDestination->kode_transaksi = $model->sent_request_no;
                $jurnalUmumOutstandingPartDestination->tanggal_transaksi = $model->sent_request_date;
                $jurnalUmumOutstandingPartDestination->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPartDestination->branch_id = $model->destination_branch_id;
                $jurnalUmumOutstandingPartDestination->total = $hppPrice;
                $jurnalUmumOutstandingPartDestination->debet_kredit = 'D';
                $jurnalUmumOutstandingPartDestination->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPartDestination->transaction_subject = 'Sent Request Destination';
                $jurnalUmumOutstandingPartDestination->is_coa_category = 0;
                $jurnalUmumOutstandingPartDestination->transaction_type = 'SR';
                $jurnalUmumOutstandingPartDestination->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('view', array(
            'model' => $model,
            'sentDetails' => $sentDetails,
        ));
    }

    public function actionShow($id) {
        $model = $this->loadModel($id);
        $sentDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $id));

        $this->render('show', array(
            'model' => $model,
            'sentDetails' => $sentDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);
        $productCriteria->compare('t.status', 'Active');
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $sentRequest = $this->instantiate(null, 'create');
        $sentRequest->header->sent_request_date = date('Y-m-d');
        $sentRequest->header->requester_branch_id = Yii::app()->user->branch_id;
        $sentRequest->header->created_datetime = date('Y-m-d H:i:s');
        $this->performAjaxValidation($sentRequest->header);

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['TransactionSentRequest']) && IdempotentManager::check()) {
            $this->loadState($sentRequest);
            $sentRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($sentRequest->header->sent_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($sentRequest->header->sent_request_date)), $sentRequest->header->requester_branch_id);

            if ($sentRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $sentRequest->header->id));
            }
        }

        $this->render('create', array(
            'sentRequest' => $sentRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $sentRequest = $this->instantiate($id, 'update');
        $sentRequest->header->user_id_updated = Yii::app()->user->id;
        $sentRequest->header->updated_datetime = date('Y-m-d H:i:s');
        $this->performAjaxValidation($sentRequest->header);

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('name', $product->name, true);
        $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->together = true;
        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionSentRequest']) && IdempotentManager::check()) {
            $this->loadState($sentRequest);

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $sentRequest->header->sent_request_no,
            ));

            $sentRequest->header->setCodeNumberByRevision('sent_request_no');

            if ($sentRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $sentRequest->header->id));
            } else {
                foreach ($sentRequest->details as $detail) {
                    echo $detail->quantity;
                }
            }
        }

        $this->render('update', array(
            'sentRequest' => $sentRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $sentRequest = TransactionSentRequest::model()->findByPk($headerId);
        $historis = TransactionSentRequestApproval::model()->findAllByAttributes(array('sent_request_id' => $headerId));
        $model = new TransactionSentRequestApproval;
        $model->date = date('Y-m-d H:i:s');

        if (isset($_POST['TransactionSentRequestApproval'])) {
            $model->attributes = $_POST['TransactionSentRequestApproval'];

            if ($model->save()) {

                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $sentRequest->sent_request_no,
                ));

                $sentRequest->status_document = $model->approval_type;
                if ($model->approval_type == 'Approved') {
                    $sentRequest->approved_by = $model->supervisor_id;
                }
                $sentRequest->save(false);

                $coaInterbranchRequester = BranchCoaInterbranch::model()->findByAttributes(array(
                    'branch_id_from' => $sentRequest->requester_branch_id, 
                    'branch_id_to' => $sentRequest->destination_branch_id,
                ));

                $jurnalUmumInterbranchRequester = new JurnalUmum;
                $jurnalUmumInterbranchRequester->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumInterbranchRequester->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
                $jurnalUmumInterbranchRequester->branch_id = $sentRequest->requester_branch_id;
                $jurnalUmumInterbranchRequester->total = round($sentRequest->total_price, 0);
                $jurnalUmumInterbranchRequester->debet_kredit = 'D';
                $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumInterbranchRequester->transaction_subject = 'Sent Request Main';
                $jurnalUmumInterbranchRequester->is_coa_category = 0;
                $jurnalUmumInterbranchRequester->transaction_type = 'SR';
                $jurnalUmumInterbranchRequester->save();

                foreach ($sentRequest->transactionSentRequestDetails as $detail) {

                    //save coa persediaan product master
                    $hppPrice = $detail->unit_price * $detail->quantity;

//                    //save coa persedian product sub master
                    $jurnalUmumOutstandingPartRequester = new JurnalUmum;
                    $jurnalUmumOutstandingPartRequester->kode_transaksi = $sentRequest->sent_request_no;
                    $jurnalUmumOutstandingPartRequester->tanggal_transaksi = $sentRequest->sent_request_date;
                    $jurnalUmumOutstandingPartRequester->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumOutstandingPartRequester->branch_id = $sentRequest->requester_branch_id;
                    $jurnalUmumOutstandingPartRequester->total = $hppPrice;
                    $jurnalUmumOutstandingPartRequester->debet_kredit = 'K';
                    $jurnalUmumOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                    $jurnalUmumOutstandingPartRequester->transaction_subject = 'Sent Request Main';
                    $jurnalUmumOutstandingPartRequester->is_coa_category = 0;
                    $jurnalUmumOutstandingPartRequester->transaction_type = 'SR';
                    $jurnalUmumOutstandingPartRequester->save();
                }

                $this->saveTransactionLog('approval', $sentRequest);
        
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'sentRequest' => $sentRequest,
            'historis' => $historis,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status_document = 'CANCELLED!!!';
        $model->total_quantity = 0; 
        $model->total_price = 0; 
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status_document', 'total_quantity', 'total_price', 'cancelled_datetime', 'user_id_cancelled'));

        foreach ($model->transactionSentRequestDetails as $detail) {
            $detail->quantity = 0;
            $detail->unit_price = '0.00';
            $detail->amount = '0.00';
            $detail->delivery_quantity = '0.00';
            $detail->transfer_request_quantity_left = '0.00';
            $detail->quantity_delivery = '0.00';
            $detail->quantity_delivery_left = '0.00';
            $detail->update(array('quantity', 'unit_price', 'amount', 'receive_quantity', 'transfer_request_quantity_left', 'quantity_delivery', 'quantity_delivery_left'));
        }
        
        $this->saveTransactionLog('cancel', $model);
        
        JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
            ':kode_transaksi' => $model->transfer_request_no,
        ));

        $this->redirect(array('admin'));
    }

    public function saveTransactionLog($actionType, $sentRequest) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $sentRequest->sent_request_no;
        $transactionLog->transaction_date = $sentRequest->sent_request_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $sentRequest->tableName();
        $transactionLog->table_id = $sentRequest->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $sentRequest->attributes;
        
        if ($actionType === 'approval') {
            $newData['transactionSentRequestApprovals'] = array();
            foreach($sentRequest->transactionSentRequestApprovals as $detail) {
                $newData['transactionSentRequestApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['transactionSentRequestDetails'] = array();
            foreach($sentRequest->transactionSentRequestDetails as $detail) {
                $newData['transactionSentRequestDetails'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionUpdateApprovalDestination($id) {
        $sentRequest = TransactionSentRequest::model()->findByPk($id);
        $sentRequest->destination_approval_status = 1;
        $sentRequest->destination_approved_by = Yii::app()->user->id;
        $sentRequest->status_document = 'Approved by Destination Branch';
        $sentRequest->update(array('destination_approval_status', 'destination_approved_by', 'status_document'));

        $coaInterbranchDestination = BranchCoaInterbranch::model()->findByAttributes(array(
            'branch_id_from' => $sentRequest->destination_branch_id, 
            'branch_id_to' => $sentRequest->requester_branch_id,
        ));

        $jurnalUmumInterbranchDestination = new JurnalUmum;
        $jurnalUmumInterbranchDestination->kode_transaksi = $sentRequest->sent_request_no;
        $jurnalUmumInterbranchDestination->tanggal_transaksi = $sentRequest->sent_request_date;
        $jurnalUmumInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
        $jurnalUmumInterbranchDestination->branch_id = $sentRequest->destination_branch_id;
        $jurnalUmumInterbranchDestination->total = round($sentRequest->total_price, 0);
        $jurnalUmumInterbranchDestination->debet_kredit = 'K';
        $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
        $jurnalUmumInterbranchDestination->transaction_subject = 'Sent Request Destination';
        $jurnalUmumInterbranchDestination->is_coa_category = 0;
        $jurnalUmumInterbranchDestination->transaction_type = 'SR';
        $jurnalUmumInterbranchDestination->save();

        foreach ($sentRequest->transactionSentRequestDetails as $detail) {
//            $hppPrice = $detail->product->hpp * $detail->quantity;
            $hppPrice = $detail->unit_price * $detail->quantity;

//                    //save coa persedian product sub master
            $jurnalUmumOutstandingPartDestination = new JurnalUmum;
            $jurnalUmumOutstandingPartDestination->kode_transaksi = $sentRequest->sent_request_no;
            $jurnalUmumOutstandingPartDestination->tanggal_transaksi = $sentRequest->sent_request_date;
            $jurnalUmumOutstandingPartDestination->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
            $jurnalUmumOutstandingPartDestination->branch_id = $sentRequest->destination_branch_id;
            $jurnalUmumOutstandingPartDestination->total = $hppPrice;
            $jurnalUmumOutstandingPartDestination->debet_kredit = 'D';
            $jurnalUmumOutstandingPartDestination->tanggal_posting = date('Y-m-d');
            $jurnalUmumOutstandingPartDestination->transaction_subject = 'Sent Request Destination';
            $jurnalUmumOutstandingPartDestination->is_coa_category = 0;
            $jurnalUmumOutstandingPartDestination->transaction_type = 'SR';
            $jurnalUmumOutstandingPartDestination->save();
        }

        $this->redirect(array('admin'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id, '');

            if ($model->header->purchaseReturnHeaders != NULL || $model->header->receiveHeaders != NULL) {
                Yii::app()->user->setFlash('message', 'Cannot DELETE this transaction');
            } else {
                foreach ($model->details as $detail)
                    $detail->delete();

                $model->header->delete();
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('TransactionSentRequest');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionSentRequest('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest'])) {
            $model->attributes = $_GET['TransactionSentRequest'];
        }

        $dataProvider = $model->search();
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.requester_branch_id = :requester_branch_id');
            $dataProvider->criteria->params[':requester_branch_id'] = Yii::app()->user->branch_id;
        }

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdminDestination() {
        $model = new TransactionSentRequest('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest'])) {
            $model->attributes = $_GET['TransactionSentRequest'];
        }

        $destinationBranchDataProvider = $model->search();
        $destinationBranchDataProvider->criteria->addCondition('t.destination_branch_id = :destination_branch_id');
        $destinationBranchDataProvider->criteria->params[':destination_branch_id'] = Yii::app()->user->branch_id;
        $destinationBranchDataProvider->criteria->compare('t.status_document', "Approved");
        $destinationBranchDataProvider->criteria->compare('t.destination_approved_by', null);

        $this->render('adminDestination', array(
            'model' => $model,
            'destinationBranchDataProvider' => $destinationBranchDataProvider,
        ));
    }

    public function actionPdf($id) {
        $sentRequest = $this->loadModel($id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Permintaan Barang');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'sentRequest' => $sentRequest,
        ), true));
        $mPDF1->Output('Permintaan Barang ' . $sentRequest->sent_request_no . '.pdf', 'I');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionSentRequest the loaded model
     * @throws CHttpException
     */
    public function actionAjaxProduct($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);
            $unitName = Unit::model()->findByPk($product->unit_id)->name;

            $object = array(
                'id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->retail_price,
                'hpp' => $product->hpp,
                'unit' => $product->unit_id,
                'unit_name' => $unitName,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id, '');
            $this->loadState($sentRequest);

            $total = 0;
            $totalItems = 0;
            
            foreach ($sentRequest->details as $key => $detail) {
                $totalItems += $detail->quantity;
                $total += $detail->unit_price * $totalItems;
            }

            $object = array('total' => $total, 'totalItems' => $totalItems);
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id, '');
            $this->loadState($sentRequest);

            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sentRequest->totalQuantity));

            echo CJSON::encode(array(
                'totalQuantity' => $totalQuantity,
            ));
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;

            $productCriteria->together = true;
            $productCriteria->select = 't.id,t.name, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('t.name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->compare('findkeyword', $product->findkeyword, true);
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);

            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $sentRequest = $this->instantiate($id, '');
            $this->loadState($sentRequest);

            $sentRequest->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array(
                'sentRequest' => $sentRequest,
                'product' => $product,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $sentRequest = $this->instantiate($id, '');
            $this->loadState($sentRequest);

            $sentRequest->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSentRequest', array(
                'sentRequest' => $sentRequest,
                'product' => $product,
                'productDataProvider' => $productDataProvider,
            ), false, true);
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

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $sentRequest = new SentRequests($actionType, new TransactionSentRequest(), array());
            //print_r("test");
        } else {
            $sentRequestModel = $this->loadModel($id);
            $sentRequest = new SentRequests($actionType, $sentRequestModel, $sentRequestModel->transactionSentRequestDetails);
            //print_r("test");
        }
        return $sentRequest;
    }

    public function loadState($sentRequest) {
        if (isset($_POST['TransactionSentRequest'])) {
            $sentRequest->header->attributes = $_POST['TransactionSentRequest'];
        }


        if (isset($_POST['TransactionSentRequestDetail'])) {
            foreach ($_POST['TransactionSentRequestDetail'] as $i => $item) {
                if (isset($sentRequest->details[$i])) {
                    $sentRequest->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionSentRequestDetail();
                    $detail->attributes = $item;
                    $sentRequest->details[] = $detail;
                }
            }
            if (count($_POST['TransactionSentRequestDetail']) < count($sentRequest->details)) {
                array_splice($sentRequest->details, $i + 1);
            }
        } else {
            $sentRequest->details = array();
        }
    }

    public function loadModel($id) {
        $model = TransactionSentRequest::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionSentRequest $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-sent-request-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
