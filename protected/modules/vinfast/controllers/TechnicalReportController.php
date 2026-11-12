<?php

class TechnicalReportController extends Controller {

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
        
        $postFailedPartImages = TechnicalReportFailedPartPhoto::model()->findAllByAttributes(array('technical_report_header_id' => $model->id));
        $postFailedPartSerialNumberImages = TechnicalReportFailedPartSerialNumberPhoto::model()->findAllByAttributes(array('technical_report_header_id' => $model->id));
        $postNewPartImages = TechnicalReportNewPartPhoto::model()->findAllByAttributes(array('technical_report_header_id' => $model->id));
        $postOdometerImages = TechnicalReportOdometerPhoto::model()->findAllByAttributes(array('technical_report_header_id' => $model->id));
        
        $this->render('view', array(
            'model' => $model,
            'postFailedPartImages' => $postFailedPartImages,
            'postFailedPartSerialNumberImages' => $postFailedPartSerialNumberImages,
            'postNewPartImages' => $postNewPartImages,
            'postOdometerImages' => $postOdometerImages,
        ));
    }

    public function actionCreate($registrationProductId) {
        $technicalReport = $this->instantiate(null, 'create');

        $registrationProduct = RegistrationProduct::model()->findByPk($registrationProductId);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationProduct->registration_transaction_id);

        $technicalReport->header->created_datetime = date('Y-m-d H:i:s');
        $technicalReport->header->user_id_created = Yii::app()->user->id;
        $technicalReport->header->province_id = 12;
        $technicalReport->header->dealer_name = 'Raperind Pondok Kelapa';
        $technicalReport->header->warranty_claim_number = $registrationTransaction->warranty_report;
        $technicalReport->header->main_part_name = $registrationProduct->product->name;
        $technicalReport->header->main_part_number = $registrationProduct->product->manufacturer_code;
        $technicalReport->header->registration_product_id = $registrationProductId;
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($technicalReport);
            
            if ($technicalReport->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $technicalReport->header->id));
            }
        }

        $this->render('create', array(
            'technicalReport' => $technicalReport,
            'registrationProduct' => $registrationProduct,
            'registrationTransaction' => $registrationTransaction,
        ));
    }

    public function actionUpdate($id) {
        $technicalReport = $this->instantiate($id, 'update');

        $technicalReport->header->updated_datetime = date('Y-m-d H:i:s');
        $technicalReport->header->user_id_updated = Yii::app()->user->id;
        
        $registrationProduct = RegistrationProduct::model()->findByPk($technicalReport->header->registration_product_id);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationProduct->registration_transaction_id);

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($technicalReport);
            
            if ($technicalReport->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $technicalReport->header->id));
            }
        }

        $this->render('update', array(
            'technicalReport' => $technicalReport,
            'registrationProduct' => $registrationProduct,
            'registrationTransaction' => $registrationTransaction,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TechnicalReportHeader('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['TechnicalReportHeader'])) {
            $model->attributes = $_GET['TechnicalReportHeader'];
        }
        
        $dataProvider = $model->search();
        
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $pendingDataProvider = $registrationTransaction->searchAdmin();
        $pendingDataProvider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482) AND t.warranty_report <> '' AND t.user_id_cancelled IS NULL AND NOT EXISTS (
            SELECT p.registration_transaction_id 
            FROM " . TechnicalReportHeader::model()->tableName() . " r 
            INNER JOIN " . RegistrationProduct::model()->tableName() . " p ON p.id = r.registration_product_id
            WHERE t.id = p.registration_transaction_id
        )");
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'registrationTransaction' => $registrationTransaction,
            'pendingDataProvider' => $pendingDataProvider,
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

    public function loadModel($id) {
        $model = TechnicalReportHeader::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    public function instantiate($id, $actionType) {
        
        if (empty($id)) {
            $technicalReport = new TechnicalReport($actionType, new TechnicalReportHeader());
        } else {
            $technicalReportHeader = $this->loadModel($id);
            $technicalReport = new TechnicalReport($actionType, $technicalReportHeader);
        }
        
        return $technicalReport;
    }

    public function loadState($technicalReport) {
        if (isset($_POST['TechnicalReportHeader'])) {
            $technicalReport->header->attributes = $_POST['TechnicalReportHeader'];
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