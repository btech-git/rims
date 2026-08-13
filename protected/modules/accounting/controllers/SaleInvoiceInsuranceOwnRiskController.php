<?php

class SaleInvoiceInsuranceOwnRiskController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'viewInvoices'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate') || Yii::app()->user->checkAccess('saleInvoiceEdit') || Yii::app()->user->checkAccess('saleInvoiceView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate($registrationId) {

        $saleInvoice = new SaleInvoiceInsuranceOwnRisk();

        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationId);
        $saleInvoice->registration_transaction_id = $registrationId;
        $saleInvoice->customer_id = $registrationTransaction->customer_id;
        $saleInvoice->vehicle_id = $registrationTransaction->vehicle_id;
        $saleInvoice->insurance_company_id = $registrationTransaction->insurance_company_id;
        $saleInvoice->transaction_date = date('Y-m-d');
        $saleInvoice->branch_id = Yii::app()->user->branch_id;
        $saleInvoice->user_id_created = Yii::app()->user->id;
        $saleInvoice->created_datetime = date('Y-m-d H:i:s');
        $saleInvoice->amount_payment = '0.00';
        $saleInvoice->status = 'Approved';
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['SaleInvoiceInsuranceOwnRisk']) && IdempotentManager::check()) {
            $saleInvoice->attributes = $_POST['SaleInvoiceInsuranceOwnRisk'];
            $saleInvoice->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($saleInvoice->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($saleInvoice->transaction_date)), $saleInvoice->branch_id);
            $saleInvoice->payment_remaining = $saleInvoice->amount_invoice;
        
            if (IdempotentManager::build()->save() && $saleInvoice->save(Yii::app()->db)) {
                $this->saveTransactionLog('addInvoiceOwnRisk', $saleInvoice);
                $this->redirect(array('view', 'id' => $saleInvoice->id));
            }
        }

        $this->render('create', array(
            'saleInvoice' => $saleInvoice,
            'registrationTransaction' => $registrationTransaction,
        ));
    }

    public function actionUpdate($id) {
        $saleInvoice = $this->loadModel($id);
        $this->performAjaxValidation($saleInvoice);
        
        $saleInvoice->updated_datetime = date('Y-m-d H:i:s');
        $saleInvoice->user_id_updated = Yii::app()->user->id;
        
        $registrationTransaction = RegistrationTransaction::model()->findByPk($saleInvoice->registration_transaction_id);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['SaleInvoiceInsuranceOwnRisk']) && IdempotentManager::check()) {
            $saleInvoice->attributes = $_POST['SaleInvoiceInsuranceOwnRisk'];
            $saleInvoice->setCodeNumberByRevision('transaction_number');
            $saleInvoice->payment_remaining = $saleInvoice->amount_invoice - $saleInvoice->amount_payment;
            
            if (IdempotentManager::build()->save() && $saleInvoice->save(Yii::app()->db)) {
                $this->saveTransactionLog('updateInvoiceOwnRisk', $saleInvoice);
                $this->redirect(array('view', 'id' => $saleInvoice->id));
            }
        }

        $this->render('update', array(
            'saleInvoice' => $saleInvoice,
            'registrationTransaction' => $registrationTransaction,
        ));
    }

    public function actionAdmin() {
        $model = new SaleInvoiceInsuranceOwnRisk('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SaleInvoiceInsuranceOwnRisk'])) {
            $model->attributes = $_GET['SaleInvoiceInsuranceOwnRisk'];
        }
        
        $dataProvider = $model->search();
        
        if (!(Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6)) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $dataProvider->criteria->with = array(
            'registrationTransaction',
            'customer',
            'vehicle',
        );
        
        $startDate = isset($_GET['StartDate']) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = isset($_GET['EndDate']) ? $_GET['EndDate'] : date('Y-m-d');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '';

        $dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        
        if (!empty($customerName)) {
            $dataProvider->criteria->compare('customer.name', $customerName, true);
        }
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->compare('vehicle.plate_number', $plateNumber, true);
        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
            'plateNumber' => $plateNumber,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
//        $payments = PaymentInDetail::model()->findAllByAttributes(array('sale_invoice_insurance_own_risk_id' => $id));
        
        $this->render('view', array(
            'model' => $model,
//            'payments' => $payments,
        ));
    }

    public function actionShow($id) {
        $model = $this->loadModel($id);
        $payments = PaymentInDetail::model()->findAllByAttributes(array('invoice_header_id' => $id));
        
        $this->render('show', array(
            'model' => $model,
            'payments' => $payments,
        ));
    }
    
    public function actionPdf($id) {
        $saleInvoice = SaleInvoiceInsuranceOwnRisk::model()->findByPk($id);
        $customer = Customer::model()->findByPk($saleInvoice->customer_id);
        $vehicle = Vehicle::model()->findByPk($saleInvoice->vehicle_id);
        $branch = Branch::model()->findByPk($saleInvoice->branch_id);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');
        $mPDF1->SetTitle('Invoice OR');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'saleInvoice' => $saleInvoice,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch, 
        ), true));
        $mPDF1->Output('Invoice OR ' . $saleInvoice->transaction_number . '.pdf', 'I');
    }
    
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionVerify($id) {
        $model = $this->loadModel($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->saveTransactionLog('verify', $model);
        
        $this->redirect(array('admin'));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $id));
        
        if (empty($paymentInDetail) || $paymentInDetail->paymentIn->user_id_cancelled !== null) {
            $model->status = 'CANCELLED!!!';
            $model->service_price = '0.00'; 
            $model->product_price = '0.00'; 
            $model->total_product = '0.00'; 
            $model->total_service = '0.00'; 
            $model->pph_total = '0.00'; 
            $model->ppn_total = '0.00'; 
            $model->total_price = '0.00'; 
            $model->invoice_amount = '0.00';
            $model->payment_amount = '0.00';
            $model->payment_left = '0.00';
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->update(array('status', 'service_price', 'product_price', 'total_product', 'total_service', 'pph_total', 'ppn_total', 'total_price', 'payment_amount', 'payment_left', 'cancelled_datetime', 'user_id_cancelled', 'invoice_amount'));

            foreach($model->invoiceDetails as $detail) {
                $detail->quantity = '0.00'; 
                $detail->unit_price = '0.00';
                $detail->discount = '0.00';
                $detail->total_price = '0.00';
                $detail->update(array('quantity', 'unit_price', 'discount', 'total_price'));
            }
            
            $this->saveTransactionLog('cancel', $model);
        
            JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
                ':kode_transaksi' => $model->invoice_number,
            ));

            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
    }

    public function saveTransactionLog($actionType, $invoiceHeader) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $invoiceHeader->transaction_number;
        $transactionLog->transaction_date = $invoiceHeader->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $invoiceHeader->tableName();
        $transactionLog->table_id = $invoiceHeader->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $invoiceHeader->attributes;
        $transactionLog->new_data = json_encode($newData);
        $transactionLog->save();
    }

    public function loadModel($id) {
        $model = SaleInvoiceInsuranceOwnRisk::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InvoiceHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoice-own-risk-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}