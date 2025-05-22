<?php

class PaymentInController extends Controller {

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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('paymentInCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('paymentInEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('paymentInCreate') || Yii::app()->user->checkAccess('paymentInEdit') || Yii::app()->user->checkAccess('paymentInView'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('paymentInApproval') || Yii::app()->user->checkAccess('paymentInSupervisor'))) {
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
        $revisionHistories = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id' => $model->id));
        $postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
//        $invoice = InvoiceHeader::model()->findByPk($model->invoice_id);
        
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

            foreach ($model->paymentInDetails as $detail) {
                $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);
                if ($invoiceHeader->payment_left > 0.00) {
                    $invoiceHeader->status = 'PARTIALLY PAID';
                } else {
                    $invoiceHeader->status = 'PAID';
                }

                $invoiceHeader->update(array('status'));
            }

            if (!empty($model->insurance_company_id)) {
                $coaId = $model->insuranceCompany->coa_id;
                $remark = $model->insuranceCompany->name;
            } else {
                $coaId = $model->customer->coa_id;
                $remark = $model->customer->name;
            }

            $totalKas = $model->totalPayment;
            $jurnalPiutang = new JurnalUmum;
            $jurnalPiutang->kode_transaksi = $model->payment_number;
            $jurnalPiutang->tanggal_transaksi = $model->payment_date;
            $jurnalPiutang->coa_id = $coaId;
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
                $coaId = $model->paymentType->coa_id;
            } else {
                $coaId = $model->companyBank->coa_id;
            }

            $jurnalUmumKas = new JurnalUmum;
            $jurnalUmumKas->kode_transaksi = $model->payment_number;
            $jurnalUmumKas->tanggal_transaksi = $model->payment_date;
            $jurnalUmumKas->coa_id = $coaId;
            $jurnalUmumKas->branch_id = $model->branch_id;
            $jurnalUmumKas->total = $model->totalDetailAmount;
            $jurnalUmumKas->debet_kredit = 'D';
            $jurnalUmumKas->tanggal_posting = date('Y-m-d');
            $jurnalUmumKas->transaction_subject = $model->notes;
            $jurnalUmumKas->remark = $remark;
            $jurnalUmumKas->is_coa_category = 0;
            $jurnalUmumKas->transaction_type = 'Pin';
            $jurnalUmumKas->save();

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
                    $jurnalPph->transaction_subject = $model->notes;
                    $jurnalPph->remark = $remark;
                    $jurnalPph->is_coa_category = 0;
                    $jurnalPph->transaction_type = 'Pin';
                    $jurnalPph->save();
                }
            }

            if ($model->downpayment_amount > 0) {
                $jurnalDownpayment = new JurnalUmum;
                $jurnalDownpayment->kode_transaksi = $model->payment_number;
                $jurnalDownpayment->tanggal_transaksi = $model->payment_date;
                $jurnalDownpayment->coa_id = 751;
                $jurnalDownpayment->branch_id = $model->branch_id;
                $jurnalDownpayment->total = $model->downpayment_amount;
                $jurnalDownpayment->debet_kredit = 'D';
                $jurnalDownpayment->tanggal_posting = date('Y-m-d');
                $jurnalDownpayment->transaction_subject = $model->notes;
                $jurnalDownpayment->remark = $remark;
                $jurnalDownpayment->is_coa_category = 0;
                $jurnalDownpayment->transaction_type = 'Pin';
                $jurnalDownpayment->save();
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

//            if ($model->discount_service_amount > 0) {
//                $jurnalDiscountService = new JurnalUmum;
//                $jurnalDiscountService->kode_transaksi = $model->payment_number;
//                $jurnalDiscountService->tanggal_transaksi = $model->payment_date;
//                $jurnalDiscountService->coa_id = 2935;
//                $jurnalDiscountService->branch_id = $model->branch_id;
//                $jurnalDiscountService->total = $model->discount_service_amount;
//                $jurnalDiscountService->debet_kredit = 'D';
//                $jurnalDiscountService->tanggal_posting = date('Y-m-d');
//                $jurnalDiscountService->transaction_subject = $model->notes;
//                $jurnalDiscountService->remark = $remark;
//                $jurnalDiscountService->is_coa_category = 0;
//                $jurnalDiscountService->transaction_type = 'Pin';
//                $jurnalDiscountService->save();
//            }

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
        
        $this->render('view', array(
            'model' => $model,
            'postImages' => $postImages,
            'revisionHistories' => $revisionHistories,
//            'invoice' => $invoice,
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

    public function actionInvoiceList() {
        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader']))
            $invoice->attributes = $_GET['InvoiceHeader'];
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.status != "CANCELLED" AND t.payment_left > 0');
        $invoiceCriteria->compare('invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('total_price', $invoice->total_price, true);
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria, 'sort' => array(
                'defaultOrder' => 'invoice_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $this->render('invoiceList', array(
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
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

        $this->render('customerList', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionInsuranceList() {

        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceCompanyDataProvider = $insuranceCompany->search();
        $insuranceCompanyDataProvider->criteria->order = 't.name ASC';

        $this->render('insuranceList', array(
            'insuranceCompany' => $insuranceCompany,
            'insuranceCompanyDataProvider' => $insuranceCompanyDataProvider,
        ));
    }

    public function actionCreateMultiple($customerId, $insuranceId) {
        $paymentIn = $this->instantiate(null, 'create');
        
        $paymentIn->header->payment_date = date('Y-m-d');
        $paymentIn->header->payment_time = date('H:i:s');
        $paymentIn->header->created_datetime = date('Y-m-d H:i:s');
        $paymentIn->header->branch_id = Yii::app()->user->branch_id;
        $paymentIn->header->status = 'Draft';
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
    
    public function instantiate($id, $actionType) {
        
        if (empty($id)) {
            $paymentIn = new PaymentInComponent($actionType, new PaymentIn(), array());
        } else {
            $paymentInModel = $this->loadModel($id);
            $paymentIn = new PaymentInComponent($actionType, $paymentInModel, $paymentInModel->paymentInDetails);
        }
        
        return $paymentIn;
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $paymentIn = $this->instantiate($id, 'update');
        $customer = Customer::model()->findByPk($paymentIn->header->customer_id);

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForPaymentIn();

        if (!empty($paymentIn->header->customer_id)) {
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $paymentIn->header->customer_id;
        }
        
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
        $invoice = new InvoiceHeader('search');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader']))
            $invoice->attributes = $_GET['InvoiceHeader'];
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.status != "CANCELLED" && t.status != "PAID"');
        $invoiceCriteria->compare('t.invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('t.invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('t.due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('t.total_price', $invoice->total_price, true);
        $invoiceCriteria->compare('t.status', $invoice->status, true);
        $invoiceCriteria->compare('t.reference_type', $invoice->reference_type);
        
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array('criteria' => $invoiceCriteria));
        $dataProvider = new CActiveDataProvider('PaymentIn');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $invoice = new InvoiceHeader('search');
        $invoice->unsetAttributes();
        
        $plateNumberInvoice = isset($_GET['PlateNumberInvoice']) ? $_GET['PlateNumberInvoice'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        if (isset($_GET['InvoiceHeader'])) {
            $invoice->attributes = $_GET['InvoiceHeader'];
        }

        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.payment_left > 1 AND t.invoice_date > "2022-12-31" AND t.status NOT LIKE "%CANCEL%"');
//        $invoiceCriteria->addInCondition('t.branch_id', Yii::app()->user->branch_id);
        $invoiceCriteria->compare('t.branch_id', $invoice->branch_id);
        $invoiceCriteria->compare('t.invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('t.invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('t.due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('t.total_price', $invoice->total_price, true);
        $invoiceCriteria->compare('t.user_id', $invoice->user_id);
        $invoiceCriteria->compare('t.status', $invoice->status, true);
        $invoiceCriteria->compare('t.reference_type', $invoice->reference_type);
        $invoiceCriteria->compare('t.insurance_company_id', $invoice->insurance_company_id);
//        $invoiceCriteria->addCondition('t.branch_id = :branch_id');
//        $invoiceCriteria->params[':branch_id'] = Yii::app()->user->branch_id;
        
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer', 'vehicle');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceCriteria->compare('vehicle.plate_number', $plateNumberInvoice, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria,
            'sort' => array(
                'defaultOrder' => 't.invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));
        
        $model = new PaymentIn('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['PaymentIn'])) {
            $model->attributes = $_GET['PaymentIn'];
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $dataProvider->criteria->with = array(
            'customer',
            'paymentInApprovals',
            'invoice' => array(
                'with' => array(
                    'vehicle',
                ),
            ),
        );
        $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '' ;
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '' ;

        if (!empty($customerType)) {
            $dataProvider->criteria->compare('customer.customer_type', $customerType);        
        }
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->compare('vehicle.plate_number', $plateNumber, true);        
        }
        
        $this->render('admin', array(
            'model' => $model,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'customerType' => $customerType,
            'plateNumber' => $plateNumber,
            'plateNumberInvoice' => $plateNumberInvoice,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
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

    public function actionAjaxInvoice($invoiceId) {
        $refNum = "";
        $vehicleId = $plate = $machine = $frame = $chasis = $power = $carMake = $carModel = $carSubModel = $carColor = "";
        $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id' => $invoiceId));
        if (count($payment) == 0)
            $count = 1;
        else
            $count = 2;
        $invoice = InvoiceHeader::model()->findByPk($invoiceId);
        if ($invoice->reference_type == 1) {
            $refNum = $invoice->salesOrder->sale_order_no;
        } else {
            $refNum = $invoice->registrationTransaction->transaction_number;
        }
        //$customer = Customer::model()->findByPk($invoice->customer_id);
        if ($invoice->vehicle_id != "") {
            $vehicle = Vehicle::model()->findByPk($invoice->vehicle_id);
            if (count($vehicle) != 0) {
                $vehicleId = $vehicle->id;
                $plate = $vehicle->plate_number != "" ? $vehicle->plate_number : '';
                $machine = $vehicle->machine_number != "" ? $vehicle->machine_number : '';
                $frame = $vehicle->frame_number != "" ? $vehicle->frame_number : '';
                $chasis = $vehicle->chasis_code != "" ? $vehicle->chasis_code : '';
                $power = $vehicle->power != "" ? $vehicle->power : '';
                $carMake = $vehicle->car_make_id != "" ? $vehicle->carMake->name : '';
                $carModel = $vehicle->car_model_id != "" ? $vehicle->carModel->name : '';
                $carSubModel = $vehicle->car_sub_model_detail_id != "" ? $vehicle->carSubModel->name : '';
                $carColor = $vehicle->color_id != "" ? Colors:: model()->findByPk($vehicle->color_id)->name : '';
            }
        }

        $object = array(
            'invoice_number' => $invoice->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'reference_type' => $invoice->reference_type == 1 ? 'Sales Order' : 'Retail Sales',
            'reference_num' => $refNum,
            'status' => $invoice->status,
            'total_price' => $invoice->total_price,
            'payment_amount' => $invoice->payment_amount != "" ? $invoice->payment_amount : "0",
            'payment_left' => $invoice->payment_left != "" ? $invoice->payment_left : "0",
            'customer_id' => $invoice->customer->id,
            'customer_name' => $invoice->customer->name,
            'type' => $invoice->customer->customer_type,
            'address' => $invoice->customer->address,
            'province' => $invoice->customer->province != "" ? $invoice->customer->province->name : '',
            'city' => $invoice->customer->city != "" ? $invoice->customer->city->name : '',
            'email' => $invoice->customer->email,
            'phones' => $invoice->customer->customerPhones != "" ? $invoice->customer->customerPhones : array(),
            'mobiles' => $invoice->customer->customerMobiles != "" ? $invoice->customer->customerMobiles : array(),
            'vehicle_id' => $vehicleId,
            'plate' => $plate,
            'machine' => $machine,
            'frame' => $frame,
            'chasis' => $chasis,
            'power' => $power,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'carSubModel' => $carSubModel,
            'carColor' => $carColor,
            'count' => $count,
        );
        echo CJSON::encode($object);
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
                            $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);

                            if ($invoiceHeader->payment_left > 0.00) {
                                $invoiceHeader->status = 'PARTIALLY PAID';
                            } else {
                                $registrationTransaction = RegistrationTransaction::model()->findByPk($invoiceHeader->registration_transaction_id);
                                $registrationTransaction->status = 'Finished';
                                $registrationTransaction->update(array('status'));
                                $invoiceHeader->status = 'PAID';
                            }

                            $invoiceHeader->update(array('status'));
                        }

                        if (!empty($paymentIn->insurance_company_id)) {
                            $coaId = $paymentIn->insuranceCompany->coa_id;
                            $remark = $paymentIn->insuranceCompany->name;
                        } else {
                            $coaId = $paymentIn->customer->coa_id;
                            $remark = $paymentIn->customer->name;
                        }
                        
                        $totalKas = $paymentIn->totalPayment;
                        $jurnalPiutang = new JurnalUmum;
                        $jurnalPiutang->kode_transaksi = $paymentIn->payment_number;
                        $jurnalPiutang->tanggal_transaksi = $paymentIn->payment_date;
                        $jurnalPiutang->coa_id = $coaId;
                        $jurnalPiutang->branch_id = $paymentIn->branch_id;
                        $jurnalPiutang->total = $totalKas;
                        $jurnalPiutang->debet_kredit = 'K';
                        $jurnalPiutang->tanggal_posting = date('Y-m-d');
                        $jurnalPiutang->transaction_subject = $paymentIn->notes;
                        $jurnalPiutang->remark = $remark;
                        $jurnalPiutang->is_coa_category = 0;
                        $jurnalPiutang->transaction_type = 'Pin';
                        $jurnalPiutang->save();
                        
                        if (!empty($paymentIn->paymentType->coa_id)) {
                            $coaId = $paymentIn->paymentType->coa_id;
                        } else {
                            $coaId = $paymentIn->companyBank->coa_id;
                        }

                        $jurnalUmumKas = new JurnalUmum;
                        $jurnalUmumKas->kode_transaksi = $paymentIn->payment_number;
                        $jurnalUmumKas->tanggal_transaksi = $paymentIn->payment_date;
                        $jurnalUmumKas->coa_id = $coaId;
                        $jurnalUmumKas->branch_id = $paymentIn->branch_id;
                        $jurnalUmumKas->total = $paymentIn->totalDetailAmount;
                        $jurnalUmumKas->debet_kredit = 'D';
                        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKas->transaction_subject = $paymentIn->notes;
                        $jurnalUmumKas->remark = $remark;
                        $jurnalUmumKas->is_coa_category = 0;
                        $jurnalUmumKas->transaction_type = 'Pin';
                        $jurnalUmumKas->save();
                        
                        foreach ($paymentIn->paymentInDetails as $detail) {
                            if ($detail->tax_service_amount > 0) {
                                $jurnalPph = new JurnalUmum;
                                $jurnalPph->kode_transaksi = $paymentIn->payment_number;
                                $jurnalPph->tanggal_transaksi = $paymentIn->payment_date;
                                $jurnalPph->coa_id = 1473;
                                $jurnalPph->branch_id = $paymentIn->branch_id;
                                $jurnalPph->total = $detail->tax_service_amount;
                                $jurnalPph->debet_kredit = 'D';
                                $jurnalPph->tanggal_posting = date('Y-m-d');
                                $jurnalPph->transaction_subject = $paymentIn->notes;
                                $jurnalPph->remark = $remark;
                                $jurnalPph->is_coa_category = 0;
                                $jurnalPph->transaction_type = 'Pin';
                                $jurnalPph->save();
                            }
                        }
                        
                        if ($paymentIn->downpayment_amount > 0) {
                            $jurnalDownpayment = new JurnalUmum;
                            $jurnalDownpayment->kode_transaksi = $paymentIn->payment_number;
                            $jurnalDownpayment->tanggal_transaksi = $paymentIn->payment_date;
                            $jurnalDownpayment->coa_id = 751;
                            $jurnalDownpayment->branch_id = $paymentIn->branch_id;
                            $jurnalDownpayment->total = $paymentIn->downpayment_amount;
                            $jurnalDownpayment->debet_kredit = 'D';
                            $jurnalDownpayment->tanggal_posting = date('Y-m-d');
                            $jurnalDownpayment->transaction_subject = $paymentIn->notes;
                            $jurnalDownpayment->remark = $remark;
                            $jurnalDownpayment->is_coa_category = 0;
                            $jurnalDownpayment->transaction_type = 'Pin';
                            $jurnalDownpayment->save();
                        }
                        
                        if ($paymentIn->discount_product_amount > 0) {
                            $jurnalDiscountProduct = new JurnalUmum;
                            $jurnalDiscountProduct->kode_transaksi = $paymentIn->payment_number;
                            $jurnalDiscountProduct->tanggal_transaksi = $paymentIn->payment_date;
                            $jurnalDiscountProduct->coa_id = 2935;
                            $jurnalDiscountProduct->branch_id = $paymentIn->branch_id;
                            $jurnalDiscountProduct->total = $paymentIn->discount_product_amount;
                            $jurnalDiscountProduct->debet_kredit = 'D';
                            $jurnalDiscountProduct->tanggal_posting = date('Y-m-d');
                            $jurnalDiscountProduct->transaction_subject = $paymentIn->notes;
                            $jurnalDiscountProduct->remark = $remark;
                            $jurnalDiscountProduct->is_coa_category = 0;
                            $jurnalDiscountProduct->transaction_type = 'Pin';
                            $jurnalDiscountProduct->save();
                        }
                        
                        if ($paymentIn->bank_administration_fee > 0) {
                            $jurnalBankAdministration = new JurnalUmum;
                            $jurnalBankAdministration->kode_transaksi = $paymentIn->payment_number;
                            $jurnalBankAdministration->tanggal_transaksi = $paymentIn->payment_date;
                            $jurnalBankAdministration->coa_id = 1111;
                            $jurnalBankAdministration->branch_id = $paymentIn->branch_id;
                            $jurnalBankAdministration->total = $paymentIn->bank_administration_fee;
                            $jurnalBankAdministration->debet_kredit = 'D';
                            $jurnalBankAdministration->tanggal_posting = date('Y-m-d');
                            $jurnalBankAdministration->transaction_subject = $paymentIn->notes;
                            $jurnalBankAdministration->remark = $remark;
                            $jurnalBankAdministration->is_coa_category = 0;
                            $jurnalBankAdministration->transaction_type = 'Pin';
                            $jurnalBankAdministration->save();
                        }
                        
                        if ($paymentIn->merimen_fee > 0) {
                            $jurnalMerimenFee = new JurnalUmum;
                            $jurnalMerimenFee->kode_transaksi = $paymentIn->payment_number;
                            $jurnalMerimenFee->tanggal_transaksi = $paymentIn->payment_date;
                            $jurnalMerimenFee->coa_id = 2921;
                            $jurnalMerimenFee->branch_id = $paymentIn->branch_id;
                            $jurnalMerimenFee->total = $paymentIn->merimen_fee;
                            $jurnalMerimenFee->debet_kredit = 'D';
                            $jurnalMerimenFee->tanggal_posting = date('Y-m-d');
                            $jurnalMerimenFee->transaction_subject = $paymentIn->notes;
                            $jurnalMerimenFee->remark = $remark;
                            $jurnalMerimenFee->is_coa_category = 0;
                            $jurnalMerimenFee->transaction_type = 'Pin';
                            $jurnalMerimenFee->save();
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

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->payment_amount = 0; 
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'payment_amount', 'cancelled_datetime', 'user_id_cancelled'));

        foreach ($model->paymentInDetails as $detail) {
            $detail->total_invoice = '0.00';
            $detail->amount = '0.00';
            $detail->tax_service_percentage = '0.00';
            $detail->tax_service_amount = '0.00';
            $detail->memo = '';
            $detail->update(array('total_invoice', 'amount', 'tax_service_percentage', 'tax_service_amount', 'memo'));
            
            $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);
            $invoiceHeader->payment_amount = $invoiceHeader->getTotalPayment();
            $invoiceHeader->payment_left = $invoiceHeader->getTotalRemaining();
            $invoiceHeader->update(array('payment_amount', 'payment_left'));
        }
        
        JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
            ':kode_transaksi' => $model->payment_number,
        ));

        $this->saveTransactionLog('cancel', $model);
        
        $this->redirect(array('admin'));
    }

    public function actionAjaxGetCompanyBank() {
        $branch = Branch::model()->findByPk($_POST['PaymentIn']['branch_id']);
        $company = Company::model()->findByPk($branch->company_id);
        if ($company == NULL) {
            echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
        } else {
            // $companyarray = [];
            // foreach ($company as $key => $value) {
            // 	$companyarray[] = (int) $value->company_id;
            // }
            $data = CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name'));
            // $criteria = new CDbCriteria;
            // $criteria->addInCondition('company_id', $companyarray); 
            // $data = CompanyBank::model()->findAll($criteria);
            // var_dump($data); die("S");			// var_dump($data->); die("S");
            if (count($data) > 0) {
                // $bank = $data->bank->name;
                // $data=CHtml::listData($data,'bank_id',$data);
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $name->id), CHtml::encode($name->bank->name . " " . $name->account_no . " a/n " . $name->account_name), true);
                }
            } else {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
            }
        }
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
                'totalAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalDetail'))),
                'totalDiscountAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalDiscount'))),
                'totalBankAdminFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalBankAdminFee'))),
                'totalMerimenFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalMerimenFee'))),
                'bankFeeAmount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'bankFeeAmount'))),
                'totalPayment' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalPayment'))),
                'totalInvoice' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($paymentIn, 'totalInvoice'))),
            );

            echo CJSON::encode($object);
        }
    }
}