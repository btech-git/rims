<?php

class SalePaymentController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'createDownpayment' || 
            $filterChain->action->id === 'createMultiple' || 
            $filterChain->action->id === 'customerList' || 
            $filterChain->action->id === 'insuranceList' || 
            $filterChain->action->id === 'invoiceList'
        ) {
            if (!(Yii::app()->user->checkAccess('paymentInCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('paymentInEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'show' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('paymentInCreate') || Yii::app()->user->checkAccess('paymentInEdit') || Yii::app()->user->checkAccess('paymentInView'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('paymentInApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        $filterChain->run();
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $revisionHistories = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id' => $model->id));
        $postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
        
        if (isset($_POST['SubmitFinish'])) {
            foreach ($model->paymentInDetails as $detail) {
                $registrationTransaction = RegistrationTransaction::model()->findByPk($detail->invoiceHeader->registration_transaction_id);
                $registrationTransaction->status = 'Finished';
                $registrationTransaction->update(array('status'));
            }
        }

        if (isset($_POST['Process'])) {
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->payment_number,
                'branch_id' => $model->branch_id,
            ));

            if (!empty($model->insurance_company_id)) {
                $coaIdReceivable = $model->insuranceCompany->coa_id;
                $remark = $model->insuranceCompany->name;
            } else {
                $coaIdReceivable = $model->customer->coa_id;
                $remark = $model->customer->name;
            }

            if (!empty($model->paymentType->coa_id)) {
                $coaIdBank = $model->paymentType->coa_id;
            } else {
                $coaIdBank = $model->companyBank->coa_id;
            }

            if ($model->payment_category == 'Invoice') {
                $this->setJournalTransactionInvoice($model, $coaIdReceivable, $coaIdBank, $remark);
            } elseif ($model->payment_category == 'Downpayment') {
                $this->setJournalTransactionDownpayment($model, $coaIdBank, $remark);
            } else {
                $this->setJournalTransactionInsuranceOwnRisk($model, $coaIdBank, $remark);
            }
        }
        
        $this->render('view', array(
            'model' => $model,
            'postImages' => $postImages,
            'revisionHistories' => $revisionHistories,
        ));
    }

    public function actionShow($id) {
        $model = $this->loadModel($id);
        $revisionHistories = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id' => $model->id));
        $postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
        
        $this->render('show', array(
            'model' => $model,
            'postImages' => $postImages,
            'revisionHistories' => $revisionHistories,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($invoiceId) {
        $paymentIn = $this->instantiate(null, 'create');
        $invoice = InvoiceHeader::model()->findByPk($invoiceId);
        $customer = Customer::model()->findByPk($invoice->customer_id);
        
        $paymentIn->header->customer_id = $customer->id;
        $paymentIn->header->payment_date = date('Y-m-d');
        $paymentIn->header->payment_time = date('H:i:s');
        $paymentIn->header->created_datetime = date('Y-m-d H:i:s');
        $paymentIn->header->branch_id = Yii::app()->user->branch_id;
        $paymentIn->header->status = 'Draft';
        $paymentIn->header->payment_category = 'Invoice';
        $paymentIn->header->user_id = Yii::app()->user->id;
        $paymentIn->addInvoice($invoiceId);

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForPaymentIn();

        if (!empty($customer->id)) {
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $customer->id;
        }
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentIn);
            $paymentIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentIn->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentIn->header->payment_date)), $paymentIn->header->branch_id);
            
            if ($paymentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $paymentIn->header->id));
            }
        }

        $this->render('create', array(
            'paymentIn' => $paymentIn,
            'customer' => $customer,
            'invoiceHeader' => $invoiceHeader,
            'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
        ));
    }

    public function actionCustomerList() {

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->order = 't.name ASC';
        $customerDataProvider->criteria->addCondition("t.id IN (60849, 60926, 63482)");

        $this->render('customerList', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

//    public function actionInsuranceList() {
//
//        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
//        $insuranceCompanyDataProvider = $insuranceCompany->search();
//        $insuranceCompanyDataProvider->criteria->order = 't.name ASC';
//        
//        $coaName = isset($_GET['CoaName']) ? $_GET['CoaName'] : '';
//        $insuranceCompanyDataProvider->criteria->compare('coa.name', $coaName, true);
//
//        $this->render('insuranceList', array(
//            'insuranceCompany' => $insuranceCompany,
//            'insuranceCompanyDataProvider' => $insuranceCompanyDataProvider,
//            'coaName' => $coaName,
//        ));
//    }

    public function actionCreateMultiple($customerId, $insuranceId) {
        $paymentIn = $this->instantiate(null, 'create');
        
        $paymentIn->header->payment_date = date('Y-m-d');
        $paymentIn->header->payment_time = date('H:i:s');
        $paymentIn->header->created_datetime = date('Y-m-d H:i:s');
        $paymentIn->header->branch_id = Yii::app()->user->branch_id;
        $paymentIn->header->status = 'Draft';
        $paymentIn->header->payment_category = 'Invoice';
        $paymentIn->header->user_id = Yii::app()->user->id;

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForPaymentIn();

        if (!empty($customerId)) {
            $paymentIn->header->customer_id = $customerId;
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $customerId;
            $paymentIn->header->insurance_company_id = null;
        }
        
        if (!empty($insuranceId)) {
            
            $paymentIn->header->insurance_company_id = $insuranceId;
            $invoiceHeaderDataProvider->criteria->addCondition("t.insurance_company_id = :insurance_company_id");
            $invoiceHeaderDataProvider->criteria->params[':insurance_company_id'] = $insuranceId;
            $paymentIn->header->customer_id = null;
        }
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentIn);
            $paymentIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentIn->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentIn->header->payment_date)), $paymentIn->header->branch_id);
            
            if ($paymentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $paymentIn->header->id));
            }
        }

        $this->render('createMultiple', array(
            'paymentIn' => $paymentIn,
            'invoiceHeader' => $invoiceHeader,
            'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
         ));
    }
   
    public function actionCreateDownpayment($registrationId) {
        $paymentIn = $this->instantiate(null, 'createDownpayment');
        
        $paymentIn->header->payment_date = date('Y-m-d');
        $paymentIn->header->payment_time = date('H:i:s');
        $paymentIn->header->created_datetime = date('Y-m-d H:i:s');
        $paymentIn->header->branch_id = Yii::app()->user->branch_id;
        $paymentIn->header->status = 'Draft';
        $paymentIn->header->payment_category = 'Downpayment';
        $paymentIn->header->user_id = Yii::app()->user->id;
        $paymentIn->addDownpayment($registrationId);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentIn);
            $paymentIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentIn->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentIn->header->payment_date)), $paymentIn->header->branch_id);
            
            if ($paymentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $paymentIn->header->id));
            }
        }

        $this->render('createDownpayment', array(
            'paymentIn' => $paymentIn,
         ));
    }
   
    public function actionCreateInvoiceOwnRisk($invoiceOwnRiskId) {
        $paymentIn = $this->instantiate(null, 'createOwnRisk');
        
        $paymentIn->header->payment_date = date('Y-m-d');
        $paymentIn->header->payment_time = date('H:i:s');
        $paymentIn->header->created_datetime = date('Y-m-d H:i:s');
        $paymentIn->header->branch_id = Yii::app()->user->branch_id;
        $paymentIn->header->status = 'Draft';
        $paymentIn->header->payment_category = 'Own Risk';
        $paymentIn->header->user_id = Yii::app()->user->id;
        $paymentIn->addInvoiceOwnRisk($invoiceOwnRiskId);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentIn);
            $paymentIn->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentIn->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentIn->header->payment_date)), $paymentIn->header->branch_id);
            
            if ($paymentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $paymentIn->header->id));
            }
        }

        $this->render('createInvoiceOwnRisk', array(
            'paymentIn' => $paymentIn,
         ));
    }
   
    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentIn = $this->instantiate($id, '');
            $this->loadState($paymentIn);

            if (isset($_POST['InvoiceIds'])) {
                foreach ($_POST['InvoiceIds'] as $invoiceId) {
                    $paymentIn->addInvoice($invoiceId);
                }
            }

            $this->renderPartial('_detail', array(
                'paymentIn' => $paymentIn,
            ));
        }
    }
 
    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentIn = $this->instantiate($id, '');
            $this->loadState($paymentIn);

            $paymentIn->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'paymentIn' => $paymentIn,
            ));
        }
    }
    
    public function actionUpdate($id) {
        $paymentIn = $this->instantiate($id, 'update');
        $customer = Customer::model()->findByPk($paymentIn->header->customer_id);

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForPaymentIn();

        if (!empty($paymentIn->header->customer_id)) {
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $paymentIn->header->customer_id;
        }
        
        $paymentIn->header->status = 'Draft';
        $paymentIn->header->edited_datetime = date('Y-m-d H:i:s');
        $paymentIn->header->user_id_edited = Yii::app()->user->id;
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentIn);
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $paymentIn->header->payment_number,
                'branch_id' => $paymentIn->header->branch_id,
            ));

            $paymentIn->header->setCodeNumberByRevision('payment_number');
            
            if ($paymentIn->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $paymentIn->header->id));
            }
        }

        $this->render('update', array(
            'paymentIn' => $paymentIn,
            'customer' => $customer,
            'invoiceHeader' => $invoiceHeader,
            'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PaymentIn('search');
        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        if (isset($_GET['PaymentIn'])) {
            $model->attributes = $_GET['PaymentIn'];
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        
        if (!(Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6)) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $dataProvider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482) AND t.user_id_cancelled IS NULL");
        $dataProvider->criteria->together = true;
        $dataProvider->criteria->with = array(
            'customer',
            'invoice' => array(
                'with' => array(
                    'vehicle',
                ),
            ),
        );
        
        $invoice = new InvoiceHeader('search');
        $invoice->unsetAttributes();
        if (isset($_GET['InvoiceHeader'])) {
            $invoice->attributes = $_GET['InvoiceHeader'];
        }

        $plateNumberInvoice = isset($_GET['PlateNumberInvoice']) ? $_GET['PlateNumberInvoice'] : '';
        
        $invoiceDataProvider = $invoice->searchForPaymentIn();
        $invoiceDataProvider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482) AND t.payment_left > 100 AND t.user_id_cancelled IS NULL");
        $invoiceDataProvider->criteria->compare('vehicle.plate_number', $plateNumberInvoice, true);
        
        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();
        if (isset($_GET['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_GET['RegistrationTransaction'];
        }

        $downpaymentDataProvider = $registrationTransaction->search();
        $downpaymentDataProvider->criteria->addCondition('t.customer_id IN (60849, 60926, 63482) AND t.downpayment_amount > 0 AND t.is_downpayment_paid = 0 AND t.user_id_cancelled IS NULL');
        
        $saleInvoiceInsuranceOwnRisk = new SaleInvoiceInsuranceOwnRisk('search');
        $saleInvoiceInsuranceOwnRisk->unsetAttributes();
        if (isset($_GET['SaleInvoiceInsuranceOwnRisk'])) {
            $saleInvoiceInsuranceOwnRisk->attributes = $_GET['SaleInvoiceInsuranceOwnRisk'];
        }

        $invoiceOwnRiskDataProvider = $saleInvoiceInsuranceOwnRisk->search();
        $invoiceOwnRiskDataProvider->criteria->addCondition('t.customer_id IN (60849, 60926, 63482) AND t.payment_remaining > 0 AND t.user_id_cancelled IS NULL');
        
        $this->render('admin', array(
            'model' => $model,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'plateNumberInvoice' => $plateNumberInvoice,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'registrationTransaction' => $registrationTransaction,
            'downpaymentDataProvider' => $downpaymentDataProvider,
            'saleInvoiceInsuranceOwnRisk' => $saleInvoiceInsuranceOwnRisk,
            'invoiceOwnRiskDataProvider' => $invoiceOwnRiskDataProvider,
        ));
    }

    public function actionDeleteImage($id) {
        $model = PaymentInImages::model()->findByPk($id);
        $model->scenario = 'delete';

        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->filename;
        $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->thumbname;
        $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->squarename;

        if (file_exists($dir)) {
            unlink($dir);
        }
        if (file_exists($dir_thumb)) {
            unlink($dir_thumb);
        }
        if (file_exists($dir_square)) {
            unlink($dir_square);
        }

        $model->is_inactive = 1;
        $model->update(array('is_inactive'));

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionUpdateApproval($headerId) {
//        $dbTransaction = Yii::app()->db->beginTransaction();
//        try {
            $paymentIn = PaymentIn::model()->findByPK($headerId);
            $historis = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id' => $headerId));

            $model = new PaymentInApproval;
            $model->date = date('Y-m-d H:i:s');
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $paymentIn->payment_number,
                'branch_id' => $paymentIn->branch_id,
            ));

            if (isset($_POST['PaymentInApproval'])) {
                $model->attributes = $_POST['PaymentInApproval'];
                if ($model->save()) {
                    $paymentIn->status = $model->approval_type;
                    $paymentIn->update(array('status'));

                    if ($model->approval_type == 'Approved') {
                        foreach ($paymentIn->paymentInDetails as $detail) {
                            $registrationTransaction = RegistrationTransaction::model()->findByPk($detail->registration_transaction_id);
                            $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);
                            $saleInvoiceInsuranceOwnRisk = SaleInvoiceInsuranceOwnRisk::model()->findByPk($detail->sale_invoice_insurance_own_risk_id);
                            if (!empty($invoiceHeader)) {
                                $paymentAmount = $invoiceHeader->getTotalPayment() + $detail->downpayment_amount + $detail->discount_amount + $detail->bank_administration_fee + $detail->merimen_fee;
                                $invoiceHeader->payment_amount = $paymentAmount;
                                $invoiceHeader->payment_left = $invoiceHeader->getTotalRemaining();

                                if ($invoiceHeader->payment_left > '0.00') {
                                    $invoiceHeader->status = 'PARTIALLY PAID';
                                } elseif ($invoiceHeader->payment_left == '0.00') {
                                    $invoiceHeader->status = 'PAID';
                                    
                                    $registrationTransaction->status = 'Finished';
                                    $registrationTransaction->update(array('status'));
                                } else {
                                    $invoiceHeader->status = 'UNPAID';
                                }

                                $invoiceHeader->update(array('payment_amount', 'payment_left', 'status'));
                            }
                            
                            if ($paymentIn->payment_category == 'Downpayment' && $detail->downpayment_amount > 0) {
                                $registrationTransaction->is_downpayment_paid = 1;
                                $registrationTransaction->downpayment_status = 'PAID';
                                $registrationTransaction->update(array('is_downpayment_paid', 'downpayment_status'));
                            }
                            
                            if ($paymentIn->payment_category == 'Own Risk'  && $detail->own_risk_amount > 0) {
                                $saleInvoiceInsuranceOwnRisk->amount_payment = $detail->own_risk_amount;
                                $saleInvoiceInsuranceOwnRisk->payment_remaining = $saleInvoiceInsuranceOwnRisk->amount_invoice - $saleInvoiceInsuranceOwnRisk->amount_payment;
                                $saleInvoiceInsuranceOwnRisk->status = 'PAID';
                                $saleInvoiceInsuranceOwnRisk->update(array('amount_payment', 'payment_remaining', 'status'));
                            }
                        }

                        if (!empty($paymentIn->insurance_company_id)) {
                            $coaIdReceivable = $paymentIn->insuranceCompany->coa_id;
                            $remark = $paymentIn->insuranceCompany->name;
                        } else {
                            $coaIdReceivable = $paymentIn->customer->coa_id;
                            $remark = $paymentIn->customer->name;
                        }
                        
                        if (!empty($paymentIn->paymentType->coa_id)) {
                            $coaIdBank = $paymentIn->paymentType->coa_id;
                        } else {
                            $coaIdBank = $paymentIn->companyBank->coa_id;
                        }

                        if ($paymentIn->payment_category == 'Invoice') {
                            $this->setJournalTransactionInvoice($paymentIn, $coaIdReceivable, $coaIdBank, $remark);
                        } elseif ($paymentIn->payment_category == 'Downpayment') {
                            $this->setJournalTransactionDownpayment($paymentIn, $coaIdBank, $remark);
                        } else {
                            $this->setJournalTransactionInsuranceOwnRisk($paymentIn, $coaIdBank, $remark);
                        }
                    }// end if approved
                }
                
                $this->saveTransactionLog('approval', $paymentIn);
        
                $this->redirect(array('view', 'id' => $headerId));
            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $paymentIn->addError('error', $e->getMessage());
//        }

        $this->render('updateApproval', array(
            'model' => $model,
            'paymentIn' => $paymentIn,
            'historis' => $historis,
        ));
    }

    public function saveTransactionLog($actionType, $paymentIn) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $paymentIn->payment_number;
        $transactionLog->transaction_date = $paymentIn->payment_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $paymentIn->tableName();
        $transactionLog->table_id = $paymentIn->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $paymentIn->attributes;
        
        if ($actionType === 'approval') {
            $newData['paymentInApprovals'] = array();
            foreach($paymentIn->paymentInApprovals as $detail) {
                $newData['paymentInApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['paymentInDetails'] = array();
            foreach($paymentIn->paymentInDetails as $detail) {
                $newData['paymentInDetails'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionVerify($id) {
        $model = $this->loadModel($id);
        $model->status = 'Verified';
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('status', 'is_verified', 'user_id_verified', 'verified_datetime'));

        $this->saveTransactionLog('verify', $model);
        
        $this->redirect(array('admin'));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->payment_amount = '0.00'; 
        $model->tax_service_amount = '0.00'; 
        $model->downpayment_amount = '0.00'; 
        $model->discount_product_amount = '0.00'; 
        $model->discount_service_amount = '0.00'; 
        $model->bank_administration_fee = '0.00'; 
        $model->merimen_fee = '0.00'; 
        $model->bank_fee_amount = '0.00'; 
        $model->own_risk_amount = '0.00'; 
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'payment_amount', 'tax_service_amount', 'downpayment_amount', 'discount_product_amount', 'discount_service_amount', 'bank_administration_fee', 'merimen_fee', 'bank_fee_amount', 'cancelled_datetime', 'user_id_cancelled', 'own_risk_amount'));

        foreach ($model->paymentInDetails as $detail) {
            $detail->total_invoice = '0.00';
            $detail->amount = '0.00';
            $detail->tax_service_percentage = '0.00';
            $detail->tax_service_amount = '0.00';
            $detail->downpayment_amount = '0.00';
            $detail->discount_amount = '0.00';
            $detail->bank_administration_fee = '0.00';
            $detail->merimen_fee = '0.00';
            $detail->own_risk_amount = '0.00'; 
            $detail->memo = '';
            $detail->update(array('total_invoice', 'amount', 'tax_service_percentage', 'tax_service_amount', 'downpayment_amount', 'discount_amount', 'bank_administration_fee', 'merimen_fee', 'memo', 'own_risk_amount'));
            
            if (!empty($detail->invoice_header_id)) {
                $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);
                $invoiceHeader->payment_amount = $invoiceHeader->getTotalPayment();
                $invoiceHeader->payment_left = $invoiceHeader->getTotalRemaining();
                $invoiceHeader->update(array('payment_amount', 'payment_left'));
            }
            
            if ($model->payment_category == 'Downpayment') {
                $registrationTransaction = RegistrationTransaction::model()->findByPk($detail->registration_transaction_id);
                $registrationTransaction->is_downpayment_paid = 0;
                $registrationTransaction->downpayment_status = 'Issued';
                $registrationTransaction->update(array('is_downpayment_paid', 'downpayment_status'));
            }
        }
        
        JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
            ':kode_transaksi' => $model->payment_number,
        ));

        $this->saveTransactionLog('cancel', $model);
        
        $this->redirect(array('admin'));
    }

    public function actionAjaxJsonGrandTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentIn = $this->instantiate($id, '');
            $this->loadState($paymentIn);

            $object = array(
                'paymentAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'amount'))),
                'taxServiceAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'tax_service_amount'))),
                'discountAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'discount_amount'))),
                'bankAdminFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'bank_administration_fee'))),
                'merimenFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'merimen_fee'))),
                'downpaymentAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'downpayment_amount'))),
                'totalDetailAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn->details[$index], 'totalAmount'))),
                'totalAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalDetail'))),
                'totalDiscountAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalDiscount'))),
                'totalTaxServiceAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalServiceTax'))),
                'totalBankAdminFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalBankAdminFee'))),
                'totalMerimenFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalMerimenFee'))),
                'totalDownpaymentAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalDownpaymentAmount'))),
                'bankFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'bankFeeAmount'))),
                'totalPayment' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalPayment'))),
                'totalInvoice' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalInvoice'))),
            );

            echo CJSON::encode($object);
        }
    }
    
    public function setJournalTransactionInvoice($model, $coaIdReceivable, $coaIdBank, $remark) {
        
        $totalKas = $model->totalPayment;
        $jurnalPiutang = new JurnalUmum;
        $jurnalPiutang->kode_transaksi = $model->payment_number;
        $jurnalPiutang->tanggal_transaksi = $model->payment_date;
        $jurnalPiutang->coa_id = $coaIdReceivable;
        $jurnalPiutang->branch_id = $model->branch_id;
        $jurnalPiutang->total = $totalKas;
        $jurnalPiutang->debet_kredit = 'K';
        $jurnalPiutang->tanggal_posting = date('Y-m-d');
        $jurnalPiutang->transaction_subject = $model->notes;
        $jurnalPiutang->remark = $remark;
        $jurnalPiutang->is_coa_category = 0;
        $jurnalPiutang->transaction_type = 'Pin';
        $jurnalPiutang->save();

        if (!empty($model->paymentType->coa_id)) {
            $coaIdBank = $model->paymentType->coa_id;
        } else {
            $coaIdBank = $model->companyBank->coa_id;
        }

        if ($model->totalDetailAmount > 0) {
            $jurnalUmumKas = new JurnalUmum;
            $jurnalUmumKas->kode_transaksi = $model->payment_number;
            $jurnalUmumKas->tanggal_transaksi = $model->payment_date;
            $jurnalUmumKas->coa_id = $coaIdBank;
            $jurnalUmumKas->branch_id = $model->branch_id;
            $jurnalUmumKas->total = $model->totalDetailAmount;
            $jurnalUmumKas->debet_kredit = 'D';
            $jurnalUmumKas->tanggal_posting = date('Y-m-d');
            $jurnalUmumKas->transaction_subject = $model->notes;
            $jurnalUmumKas->remark = $remark;
            $jurnalUmumKas->is_coa_category = 0;
            $jurnalUmumKas->transaction_type = 'Pin';
            $jurnalUmumKas->save();
        }

        foreach ($model->paymentInDetails as $detail) {
            if ($detail->tax_service_amount > 0) {
                $jurnalPph = new JurnalUmum;
                $jurnalPph->kode_transaksi = $model->payment_number;
                $jurnalPph->tanggal_transaksi = $model->payment_date;
                $jurnalPph->coa_id = 1473;
                $jurnalPph->branch_id = $model->branch_id;
                $jurnalPph->total = $detail->tax_service_amount;
                $jurnalPph->debet_kredit = 'D';
                $jurnalPph->tanggal_posting = date('Y-m-d');
                $jurnalPph->transaction_subject = $detail->memo;
                $jurnalPph->remark = $remark;
                $jurnalPph->is_coa_category = 0;
                $jurnalPph->transaction_type = 'Pin';
                $jurnalPph->save();
            }
        }

        if ($model->discount_product_amount > 0) {
            $jurnalDiscountProduct = new JurnalUmum;
            $jurnalDiscountProduct->kode_transaksi = $model->payment_number;
            $jurnalDiscountProduct->tanggal_transaksi = $model->payment_date;
            $jurnalDiscountProduct->coa_id = 2935;
            $jurnalDiscountProduct->branch_id = $model->branch_id;
            $jurnalDiscountProduct->total = $model->discount_product_amount;
            $jurnalDiscountProduct->debet_kredit = 'D';
            $jurnalDiscountProduct->tanggal_posting = date('Y-m-d');
            $jurnalDiscountProduct->transaction_subject = $model->notes;
            $jurnalDiscountProduct->remark = $remark;
            $jurnalDiscountProduct->is_coa_category = 0;
            $jurnalDiscountProduct->transaction_type = 'Pin';
            $jurnalDiscountProduct->save();
        }

        if ($model->bank_administration_fee > 0) {
            $jurnalBankAdministration = new JurnalUmum;
            $jurnalBankAdministration->kode_transaksi = $model->payment_number;
            $jurnalBankAdministration->tanggal_transaksi = $model->payment_date;
            $jurnalBankAdministration->coa_id = 1111;
            $jurnalBankAdministration->branch_id = $model->branch_id;
            $jurnalBankAdministration->total = $model->bank_administration_fee;
            $jurnalBankAdministration->debet_kredit = 'D';
            $jurnalBankAdministration->tanggal_posting = date('Y-m-d');
            $jurnalBankAdministration->transaction_subject = $model->notes;
            $jurnalBankAdministration->remark = $remark;
            $jurnalBankAdministration->is_coa_category = 0;
            $jurnalBankAdministration->transaction_type = 'Pin';
            $jurnalBankAdministration->save();
        }

        if ($model->merimen_fee > 0) {
            $jurnalMerimenFee = new JurnalUmum;
            $jurnalMerimenFee->kode_transaksi = $model->payment_number;
            $jurnalMerimenFee->tanggal_transaksi = $model->payment_date;
            $jurnalMerimenFee->coa_id = 2921;
            $jurnalMerimenFee->branch_id = $model->branch_id;
            $jurnalMerimenFee->total = $model->merimen_fee;
            $jurnalMerimenFee->debet_kredit = 'D';
            $jurnalMerimenFee->tanggal_posting = date('Y-m-d');
            $jurnalMerimenFee->transaction_subject = $model->notes;
            $jurnalMerimenFee->remark = $remark;
            $jurnalMerimenFee->is_coa_category = 0;
            $jurnalMerimenFee->transaction_type = 'Pin';
            $jurnalMerimenFee->save();
        }
    }
    
    public function setJournalTransactionDownpayment($model, $coaIdBank, $remark) {
        
        $jurnalUmumKas = new JurnalUmum;
        $jurnalUmumKas->kode_transaksi = $model->payment_number;
        $jurnalUmumKas->tanggal_transaksi = $model->payment_date;
        $jurnalUmumKas->coa_id = $coaIdBank;
        $jurnalUmumKas->branch_id = $model->branch_id;
        $jurnalUmumKas->total = $model->downpayment_amount;
        $jurnalUmumKas->debet_kredit = 'D';
        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
        $jurnalUmumKas->transaction_subject = $model->notes;
        $jurnalUmumKas->remark = $remark;
        $jurnalUmumKas->is_coa_category = 0;
        $jurnalUmumKas->transaction_type = 'Pin';
        $jurnalUmumKas->save();

        $jurnalDownpayment = new JurnalUmum;
        $jurnalDownpayment->kode_transaksi = $model->payment_number;
        $jurnalDownpayment->tanggal_transaksi = $model->payment_date;
        $jurnalDownpayment->coa_id = 751;
        $jurnalDownpayment->branch_id = $model->branch_id;
        $jurnalDownpayment->total = $model->downpayment_amount;
        $jurnalDownpayment->debet_kredit = 'K';
        $jurnalDownpayment->tanggal_posting = date('Y-m-d');
        $jurnalDownpayment->transaction_subject = $model->notes;
        $jurnalDownpayment->remark = $remark;
        $jurnalDownpayment->is_coa_category = 0;
        $jurnalDownpayment->transaction_type = 'Pin';
        $jurnalDownpayment->save();
    }
    
    public function setJournalTransactionInsuranceOwnRisk($model, $coaIdBank, $remark) {
        
        $jurnalUmumKas = new JurnalUmum;
        $jurnalUmumKas->kode_transaksi = $model->payment_number;
        $jurnalUmumKas->tanggal_transaksi = $model->payment_date;
        $jurnalUmumKas->coa_id = $coaIdBank;
        $jurnalUmumKas->branch_id = $model->branch_id;
        $jurnalUmumKas->total = $model->own_risk_amount;
        $jurnalUmumKas->debet_kredit = 'D';
        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
        $jurnalUmumKas->transaction_subject = $model->notes;
        $jurnalUmumKas->remark = $remark;
        $jurnalUmumKas->is_coa_category = 0;
        $jurnalUmumKas->transaction_type = 'Pin';
        $jurnalUmumKas->save();

        $jurnalOwnRisk = new JurnalUmum;
        $jurnalOwnRisk->kode_transaksi = $model->payment_number;
        $jurnalOwnRisk->tanggal_transaksi = $model->payment_date;
        $jurnalOwnRisk->coa_id = ($model->customer->customer_type == 'Company') ? $model->customer->coa_id : 1449;
        $jurnalOwnRisk->branch_id = $model->branch_id;
        $jurnalOwnRisk->total = $model->own_risk_amount;
        $jurnalOwnRisk->debet_kredit = 'K';
        $jurnalOwnRisk->tanggal_posting = date('Y-m-d');
        $jurnalOwnRisk->transaction_subject = $model->notes;
        $jurnalOwnRisk->remark = $remark;
        $jurnalOwnRisk->is_coa_category = 0;
        $jurnalOwnRisk->transaction_type = 'Pin';
        $jurnalOwnRisk->save();
    }
    
    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PaymentIn the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PaymentIn::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    public function instantiate($id, $actionType) {
        
        if (empty($id)) {
            $salePayment = new SalePayment($actionType, new PaymentIn(), array());
        } else {
            $paymentInHeader = $this->loadModel($id);
            $salePayment = new SalePayment($actionType, $paymentInHeader, $paymentInHeader->paymentInDetails);
        }
        
        return $salePayment;
    }

    public function loadState($paymentIn) {
        if (isset($_POST['PaymentIn'])) {
            $paymentIn->header->attributes = $_POST['PaymentIn'];
        }
        
        if (isset($_POST['PaymentInDetail'])) {
            foreach ($_POST['PaymentInDetail'] as $i => $item) {
                if (isset($paymentIn->details[$i])) {
                    $paymentIn->details[$i]->attributes = $item;
                } else {
                    $detail = new PaymentInDetail();
                    $detail->attributes = $item;
                    $paymentIn->details[] = $detail;
                }
            }
            if (count($_POST['PaymentInDetail']) < count($paymentIn->details)) {
                array_splice($paymentIn->details, $i + 1);
            }
        } else {
            $paymentIn->details = array();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param PaymentIn $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-in-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}