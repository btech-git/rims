<?php

class SaleReceiptController extends Controller {

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

    public function actionCustomerList() {

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->criteria->order = 't.name ASC';

        $this->render('customerList', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionCreate($customerId) {
        $saleReceipt = $this->instantiate(null, 'create');
        
        $saleReceipt->header->transaction_date = date('Y-m-d');
        $saleReceipt->header->created_datetime = date('Y-m-d H:i:s');
        $saleReceipt->header->branch_id = Yii::app()->user->branch_id;
        $saleReceipt->header->status = 'Draft';
        $saleReceipt->header->user_id_created = Yii::app()->user->id;

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForSaleReceipt();

        if (!empty($customerId)) {
            $saleReceipt->header->customer_id = $customerId;
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $customerId;
            $saleReceipt->header->insurance_company_id = null;
        }
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleReceipt);
            $saleReceipt->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($saleReceipt->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($saleReceipt->header->transaction_date)), $saleReceipt->header->branch_id);
            
            if ($saleReceipt->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleReceipt->header->id));
            }
        }

        $this->render('create', array(
            'paymentIn' => $saleReceipt,
            'invoiceHeader' => $invoiceHeader,
            'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
         ));
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
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->total_invoice_amount = 0;
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'total_invoice_amount', 'cancelled_datetime', 'user_id_cancelled'));

        foreach ($model->saleReceiptDetails as $detail) {
            $detail->total_invoice = '0.00';
            $detail->amount = '0.00';
            $detail->tax_service_percentage = '0.00';
            $detail->tax_service_amount = '0.00';
            $detail->downpayment_amount = '0.00';
            $detail->discount_amount = '0.00';
            $detail->bank_administration_fee = '0.00';
            $detail->merimen_fee = '0.00';
            $detail->memo = '';
            $detail->update(array('total_invoice', 'amount', 'tax_service_percentage', 'tax_service_amount', 'downpayment_amount', 'discount_amount', 'bank_administration_fee', 'merimen_fee', 'memo'));
            
            if (!empty($detail->invoice_header_id)) {
                $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);
                $invoiceHeader->payment_amount = $invoiceHeader->getTotalPayment();
                $invoiceHeader->payment_left = $invoiceHeader->getTotalRemaining();
                $invoiceHeader->update(array('payment_amount', 'payment_left'));
            }
        }
        
        JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
            ':kode_transaksi' => $model->payment_number,
        ));

        $this->saveTransactionLog('cancel', $model);
        
        $this->redirect(array('admin'));
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
     * Performs the AJAX validation.
     * @param PaymentIn $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-in-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
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
}