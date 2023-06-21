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
            if (!(Yii::app()->user->checkAccess('sentRequestCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
                $filterChain->action->id === 'delete' ||
                $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('sentRequestEdit')))
                $this->redirect(array('/site/login'));
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('sentRequestApproval')) || !(Yii::app()->user->checkAccess('sentRequestSupervisor')))
                $this->redirect(array('/site/login'));
        }

        if (
                $filterChain->action->id === 'admin' ||
                $filterChain->action->id === 'index' ||
                $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('sentRequestCreate')) || !(Yii::app()->user->checkAccess('sentRequestEdit')) || !(Yii::app()->user->checkAccess('sentRequestApproval')))
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
        $sentDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $id));

        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->sent_request_no,
            ));
            
            $coaInterbranchRequester = BranchCoaInterbranch::model()->findByAttributes(array(
                'branch_id_from' => $model->requester_branch_id, 
                'branch_id_to' => $model->destination_branch_id,
            ));

            $jurnalUmumInterbranchRequester = new JurnalUmum;
            $jurnalUmumInterbranchRequester->kode_transaksi = $model->sent_request_no;
            $jurnalUmumInterbranchRequester->tanggal_transaksi = $model->sent_request_date;
            $jurnalUmumInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
            $jurnalUmumInterbranchRequester->branch_id = $model->requester_branch_id;
            $jurnalUmumInterbranchRequester->total = $model->total_price;
            $jurnalUmumInterbranchRequester->debet_kredit = 'D';
            $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
            $jurnalUmumInterbranchRequester->transaction_subject = 'Sent Request Main';
            $jurnalUmumInterbranchRequester->is_coa_category = 0;
            $jurnalUmumInterbranchRequester->transaction_type = 'SR';
            $jurnalUmumInterbranchRequester->save();

            foreach ($model->transactionSentRequestDetails as $detail) {

                //save coa persediaan product master
                $hppPrice = $detail->unit_price * $detail->quantity;

                $jurnalUmumMasterOutstandingPartRequester = new JurnalUmum;
                $jurnalUmumMasterOutstandingPartRequester->kode_transaksi = $model->sent_request_no;
                $jurnalUmumMasterOutstandingPartRequester->tanggal_transaksi = $model->sent_request_date;
                $jurnalUmumMasterOutstandingPartRequester->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPartRequester->branch_id = $model->requester_branch_id;
                $jurnalUmumMasterOutstandingPartRequester->total = $hppPrice;
                $jurnalUmumMasterOutstandingPartRequester->debet_kredit = 'K';
                $jurnalUmumMasterOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPartRequester->transaction_subject = 'Sent Request Main';
                $jurnalUmumMasterOutstandingPartRequester->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPartRequester->transaction_type = 'SR';
                $jurnalUmumMasterOutstandingPartRequester->save();
//
//                    //save coa persedian product sub master
                $jurnalUmumOutstandingPartRequester = new JurnalUmum;
                $jurnalUmumOutstandingPartRequester->kode_transaksi = $model->sent_request_no;
                $jurnalUmumOutstandingPartRequester->tanggal_transaksi = $model->sent_request_date;
                $jurnalUmumOutstandingPartRequester->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPartRequester->branch_id = $model->requester_branch_id;
                $jurnalUmumOutstandingPartRequester->total = $hppPrice;
                $jurnalUmumOutstandingPartRequester->debet_kredit = 'K';
                $jurnalUmumOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPartRequester->transaction_subject = 'Sent Request Main';
                $jurnalUmumOutstandingPartRequester->is_coa_category = 0;
                $jurnalUmumOutstandingPartRequester->transaction_type = 'SR';
                $jurnalUmumOutstandingPartRequester->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('view', array(
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
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $sentRequest = $this->instantiate(null);
        $sentRequest->header->requester_branch_id = $sentRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $sentRequest->header->requester_branch_id;
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
        $sentRequest = $this->instantiate($id);
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
                $jurnalUmumInterbranchRequester->total = $sentRequest->total_price;
                $jurnalUmumInterbranchRequester->debet_kredit = 'D';
                $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumInterbranchRequester->transaction_subject = 'Sent Request Main';
                $jurnalUmumInterbranchRequester->is_coa_category = 0;
                $jurnalUmumInterbranchRequester->transaction_type = 'SR';
                $jurnalUmumInterbranchRequester->save();

                foreach ($sentRequest->transactionSentRequestDetails as $detail) {

                    //save coa persediaan product master
                    $hppPrice = $detail->unit_price * $detail->quantity;

                    $jurnalUmumMasterOutstandingPartRequester = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPartRequester->kode_transaksi = $sentRequest->sent_request_no;
                    $jurnalUmumMasterOutstandingPartRequester->tanggal_transaksi = $sentRequest->sent_request_date;
                    $jurnalUmumMasterOutstandingPartRequester->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPartRequester->branch_id = $sentRequest->requester_branch_id;
                    $jurnalUmumMasterOutstandingPartRequester->total = $hppPrice;
                    $jurnalUmumMasterOutstandingPartRequester->debet_kredit = 'K';
                    $jurnalUmumMasterOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPartRequester->transaction_subject = 'Sent Request Main';
                    $jurnalUmumMasterOutstandingPartRequester->is_coa_category = 1;
                    $jurnalUmumMasterOutstandingPartRequester->transaction_type = 'SR';
                    $jurnalUmumMasterOutstandingPartRequester->save();
//
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

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'sentRequest' => $sentRequest,
            'historis' => $historis,
        ));
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

//        $jurnalUmumMasterInterbranchDestination = new JurnalUmum;
//        $jurnalUmumMasterInterbranchDestination->kode_transaksi = $sentRequest->sent_request_no;
//        $jurnalUmumMasterInterbranchDestination->tanggal_transaksi = $sentRequest->sent_request_date;
//        $jurnalUmumMasterInterbranchDestination->coa_id = $sentRequest->destinationBranch->coa_interbranch_inventory;
//        $jurnalUmumMasterInterbranchDestination->branch_id = $sentRequest->destination_branch_id;
//        $jurnalUmumMasterInterbranchDestination->total = $sentRequest->total_price;
//        $jurnalUmumMasterInterbranchDestination->debet_kredit = 'K';
//        $jurnalUmumMasterInterbranchDestination->tanggal_posting = date('Y-m-d');
//        $jurnalUmumMasterInterbranchDestination->transaction_subject = 'Sent Request Destination';
//        $jurnalUmumMasterInterbranchDestination->is_coa_category = 1;
//        $jurnalUmumMasterInterbranchDestination->transaction_type = 'SR';
//        $jurnalUmumMasterInterbranchDestination->save();

        $jurnalUmumInterbranchDestination = new JurnalUmum;
        $jurnalUmumInterbranchDestination->kode_transaksi = $sentRequest->sent_request_no;
        $jurnalUmumInterbranchDestination->tanggal_transaksi = $sentRequest->sent_request_date;
        $jurnalUmumInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
        $jurnalUmumInterbranchDestination->branch_id = $sentRequest->destination_branch_id;
        $jurnalUmumInterbranchDestination->total = $sentRequest->total_price;
        $jurnalUmumInterbranchDestination->debet_kredit = 'K';
        $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
        $jurnalUmumInterbranchDestination->transaction_subject = 'Sent Request Destination';
        $jurnalUmumInterbranchDestination->is_coa_category = 0;
        $jurnalUmumInterbranchDestination->transaction_type = 'SR';
        $jurnalUmumInterbranchDestination->save();

        foreach ($sentRequest->transactionSentRequestDetails as $detail) {
            $hppPrice = $detail->product->hpp * $detail->quantity;

            //save coa persediaan product master
            $jurnalUmumMasterOutstandingPartDestination = new JurnalUmum;
            $jurnalUmumMasterOutstandingPartDestination->kode_transaksi = $sentRequest->sent_request_no;
            $jurnalUmumMasterOutstandingPartDestination->tanggal_transaksi = $sentRequest->sent_request_date;
            $jurnalUmumMasterOutstandingPartDestination->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
            $jurnalUmumMasterOutstandingPartDestination->branch_id = $sentRequest->destination_branch_id;
            $jurnalUmumMasterOutstandingPartDestination->total = $hppPrice;
            $jurnalUmumMasterOutstandingPartDestination->debet_kredit = 'D';
            $jurnalUmumMasterOutstandingPartDestination->tanggal_posting = date('Y-m-d');
            $jurnalUmumMasterOutstandingPartDestination->transaction_subject = 'Sent Request Destination';
            $jurnalUmumMasterOutstandingPartDestination->is_coa_category = 1;
            $jurnalUmumMasterOutstandingPartDestination->transaction_type = 'SR';
            $jurnalUmumMasterOutstandingPartDestination->save();
//
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
            $model = $this->instantiate($id);

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
        $dataProvider->criteria->addInCondition('requester_branch_id', Yii::app()->user->branch_ids);

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
        $destinationBranchDataProvider->criteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);
        $destinationBranchDataProvider->criteria->compare('t.status_document', "Approved");
        $destinationBranchDataProvider->criteria->compare('t.destination_approved_by', null);

        $this->render('adminDestination', array(
            'model' => $model,
            'destinationBranchDataProvider' => $destinationBranchDataProvider,
        ));
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
            $sentRequest = $this->instantiate($id);
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
            $sentRequest = $this->instantiate($id);
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

            $sentRequest = $this->instantiate($id);
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

            $sentRequest = $this->instantiate($id);
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

    public function instantiate($id) {
        if (empty($id)) {
            $sentRequest = new SentRequests(new TransactionSentRequest(), array());
            //print_r("test");
        } else {
            $sentRequestModel = $this->loadModel($id);
            $sentRequest = new SentRequests($sentRequestModel, $sentRequestModel->transactionSentRequestDetails);
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
