<?php

class SaleReceiptController extends Controller {

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
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'createDownpayment' || 
            $filterChain->action->id === 'createMultiple' || 
            $filterChain->action->id === 'customerList' || 
            $filterChain->action->id === 'insuranceList' || 
            $filterChain->action->id === 'invoiceList'
        ) {
            if (!(Yii::app()->user->checkAccess('saleReceiptCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('saleReceiptEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'show' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('saleReceiptCreate') || Yii::app()->user->checkAccess('saleReceiptEdit') || Yii::app()->user->checkAccess('saleReceiptView'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('saleReceiptApproval'))) {
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
        $saleReceipt->header->status = 'Approved';
        $saleReceipt->header->user_id_created = Yii::app()->user->id;

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForSaleReceipt();

        if (!empty($customerId)) {
            $saleReceipt->header->customer_id = $customerId;
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $customerId;
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
            'saleReceipt' => $saleReceipt,
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
        $saleReceipt = $this->instantiate($id, 'update');
        $customer = Customer::model()->findByPk($saleReceipt->header->customer_id);

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());
        $invoiceHeaderDataProvider = $invoiceHeader->searchForSaleReceipt();

        if (!empty($saleReceipt->header->customer_id)) {
            $invoiceHeaderDataProvider->criteria->addCondition("t.customer_id = :customer_id");
            $invoiceHeaderDataProvider->criteria->params[':customer_id'] = $saleReceipt->header->customer_id;
        }
        
        $saleReceipt->header->status = 'Draft';
        $saleReceipt->header->edited_datetime = date('Y-m-d H:i:s');
        $saleReceipt->header->user_id_edited = Yii::app()->user->id;
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleReceipt);
            $saleReceipt->header->setCodeNumberByRevision('transaction_number');
            
            if ($saleReceipt->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleReceipt->header->id));
            }
        }

        $this->render('update', array(
            'saleReceipt' => $saleReceipt,
            'customer' => $customer,
            'invoiceHeader' => $invoiceHeader,
            'invoiceHeaderDataProvider' => $invoiceHeaderDataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new SaleReceiptHeader('search');
        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        
        if (isset($_GET['SaleReceiptHeader'])) {
            $model->attributes = $_GET['SaleReceiptHeader'];
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        
        if (!(Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6)) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
            'customerType' => $customerType,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionPdf($id) {
        $saleReceiptHeader = SaleReceiptHeader::model()->findByPk($id);
        $customer = Customer::model()->findByPk($saleReceiptHeader->customer_id);

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');
        $mPDF1->SetTitle('Rekap Invoice');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'saleReceiptHeader' => $saleReceiptHeader,
            'customer' => $customer,
        ), true));
        $mPDF1->Output('Rekap Invoice ' . $saleReceiptHeader->transaction_number . '.pdf', 'I');
    }
    
    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'Cancelled';
        $model->total_invoice_amount = 0;
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'total_invoice_amount', 'cancelled_datetime', 'user_id_cancelled'));

        foreach ($model->saleReceiptDetails as $detail) {
            $detail->invoice_amount = '0.00';
            $detail->memo = '';
            $detail->update(array('invoice_amount', 'memo'));
        }
        
        $this->saveTransactionLog('cancel', $model);
        $this->redirect(array('admin'));
    }

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id, '');
            $this->loadState($saleReceipt);

            if (isset($_POST['InvoiceIds'])) {
                foreach ($_POST['InvoiceIds'] as $invoiceId) {
                    $saleReceipt->addInvoice($invoiceId);
                }
            }

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt,
            ));
        }
    }
 
    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleReceipt = $this->instantiate($id, '');
            $this->loadState($saleReceipt);

            $saleReceipt->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'saleReceipt' => $saleReceipt,
            ));
        }
    }
    
    public function loadModel($id) {
        $model = SaleReceiptHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    public function instantiate($id, $actionType) {
        
        if (empty($id)) {
            $saleReceipt = new SaleReceipt($actionType, new SaleReceiptHeader(), array());
        } else {
            $saleReceiptHeader = $this->loadModel($id);
            $saleReceipt = new SaleReceipt($actionType, $saleReceiptHeader, $saleReceiptHeader->saleReceiptDetails);
        }
        
        return $saleReceipt;
    }

    public function loadState($saleReceipt) {
        if (isset($_POST['SaleReceiptHeader'])) {
            $saleReceipt->header->attributes = $_POST['SaleReceiptHeader'];
        }
        
        if (isset($_POST['SaleReceiptDetail'])) {
            foreach ($_POST['SaleReceiptDetail'] as $i => $item) {
                if (isset($saleReceipt->details[$i])) {
                    $saleReceipt->details[$i]->attributes = $item;
                } else {
                    $detail = new SaleReceiptDetail();
                    $detail->attributes = $item;
                    $saleReceipt->details[] = $detail;
                }
            }
            if (count($_POST['SaleReceiptDetail']) < count($saleReceipt->details)) {
                array_splice($saleReceipt->details, $i + 1);
            }
        } else {
            $saleReceipt->details = array();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param SaleReceiptHeader $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'sale-receipt-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function saveTransactionLog($actionType, $saleReceipt) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $saleReceipt->payment_number;
        $transactionLog->transaction_date = $saleReceipt->payment_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $saleReceipt->tableName();
        $transactionLog->table_id = $saleReceipt->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $saleReceipt->attributes;
        
        $newData['saleReceiptDetails'] = array();
        foreach($saleReceipt->saleReceiptDetails as $detail) {
            $newData['saleReceiptDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}