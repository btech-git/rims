<?php

class SiteController extends Controller {

    public $layout = '//layouts/column1';

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('login'));
        } else {
            $count = 0;
            $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
            $date = date_create(date('d-m-Y'));
            date_sub($date, date_interval_create_from_date_string("7 days"));

            if (!empty($branchId)) {
                $requestCriteria = new CDbCriteria;
                $requestCriteria->addCondition(" main_branch_id = " . $branchId . " AND DATE(request_order_date) >= (NOW() - INTERVAL 7 DAY)");
                $requestOrder = TransactionRequestOrder::model()->findAll($requestCriteria);
                $purchaseCriteria = new CDbCriteria;
                $purchaseCriteria->addCondition(" main_branch_id = " . $branchId . " AND DATE(purchase_order_date) >= (NOW() - INTERVAL 7 DAY)");
                $purchase = TransactionPurchaseOrder::model()->findAll($purchaseCriteria);

                $salesCriteria = new CDbCriteria;
                $salesCriteria->addCondition(" requester_branch_id = " . $branchId . " AND DATE(sale_order_date) >= (NOW() - INTERVAL 7 DAY)");
                $sales = TransactionSalesOrder::model()->findAll($salesCriteria);

                $transferCriteria = new CDbCriteria;
                $transferCriteria->addCondition(" destination_branch_id = " . $branchId . " AND DATE(transfer_request_date) >= (NOW() - INTERVAL 7 DAY)");
                $transfer = TransactionTransferRequest::model()->findAll($transferCriteria);

                $sentCriteria = new CDbCriteria;
                $sentCriteria->addCondition(" destination_branch_id = " . $branchId . " AND DATE(sent_request_date) >= (NOW() - INTERVAL 7 DAY)");
                $sent = TransactionSentRequest::model()->findAll($sentCriteria);

                $consignmentCriteria = new CDbCriteria;
                $consignmentCriteria->addCondition(" branch_id = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $consignment = ConsignmentOutHeader::model()->findAll($consignmentCriteria);

                $consignmentInCriteria = new CDbCriteria;
                $consignmentInCriteria->addCondition(" receive_branch = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $consignmentIn = ConsignmentInHeader::model()->findAll($consignmentInCriteria);

                $movementCriteria = new CDbCriteria;
                $movementCriteria->addCondition(" branch_id = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $movement = MovementOutHeader::model()->findAll($movementCriteria);

                $movementInCriteria = new CDbCriteria;
                $movementInCriteria->addCondition(" branch_id = " . $branchId . " AND DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $movementIn = MovementInHeader::model()->findAll($movementInCriteria);

//                $count = count($requestOrder) + count($purchase) + count($sales) + count($transfer) + count($sent) + count($consignment) + count($consignmentIn) + count($movement) + count($movementIn);
            }
        }
        
        $totalReceivables = InvoiceHeader::totalReceivables();
        $totalPayables = TransactionReceiveItem::totalPayables();
        
        $resultSet = RegistrationTransaction::graphSale();
        $records = array();
        $year = intval(date('Y'));
        $month = intval(date('m'));
        for ($i = 0; $i < 12; $i++) {
            $records[$year][$month] = 0;
            $month--;
            if ($month <= 0) {
                $month += 12;
                $year--;
            }
        }
        foreach ($resultSet as $item) {
            $month = intval($item['month']);
            $year = intval($item['year']);
            if (isset($records[$year][$month])) {
                $records[$year][$month] = doubleval($item['grand_total']);
            }
        }
        $rows = array();
        foreach ($records as $y => $record) {
            foreach ($record as $m => $value) {
                $month = date("M", mktime(0, 0, 0, $m));
                $year = substr($y, 2);
                $rows[] = array($month . " " . $year, $value);
            }
        }
        $dataSale = array_merge(array(array('Monthly', 'Sales')), array_reverse($rows));

        $resultSetBranch = JurnalUmum::graphSalePerBranch();
        $branchRows = array();
        foreach ($resultSetBranch as $item) {
            $branchRows[] = array($item['branch_name'], doubleval($item['total']));
        }
        $dataSalePerBranch = array_merge(array(array('Branch', 'Sales')), $branchRows);

        $resultSetIncomeExpense = JurnalUmum::graphIncomeExpense();
        $incomeExpenseRecords = array();
        $incomeExpenseYear = intval(date('Y'));
        $incomeExpenseMonth = intval(date('m'));
        for ($i = 0; $i < 12; $i++) {
            $incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth] = 0;
            $incomeExpenseMonth--;
            if ($incomeExpenseMonth <= 0) {
                $incomeExpenseMonth += 12;
                $incomeExpenseYear--;
            }
        }
        foreach ($resultSetIncomeExpense as $item) {
            $incomeExpenseMonth = intval($item['month']);
            $incomeExpenseYear = intval($item['year']);
            if (isset($incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth])) {
                $incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth] = array(doubleval($item['debit']), doubleval($item['kredit']));
            }
        }
        $incomeExpenseRows = array();
        foreach ($incomeExpenseRecords as $y => $record) {
            foreach ($record as $m => $value) {
                $incomeExpenseMonth = date("M", mktime(0, 0, 0, $m));
                $incomeExpenseYear = substr($y, 2);
                $incomeExpenseRows[] = array_merge(array($incomeExpenseMonth . " " . $incomeExpenseYear), $value);
            }
        }
        $dataIncomeExpense = array_merge(array(array('Monthly', 'Income', 'Expense')), array_reverse($incomeExpenseRows));

        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index', array(
            'dataSale' => $dataSale,
            'dataSalePerBranch' => $dataSalePerBranch,
            'dataIncomeExpense' => $dataIncomeExpense,
            'totalReceivables' => $totalReceivables,
            'totalPayables' => $totalPayables,
            'requestOrder' => $requestOrder,
            'purchase' => $purchase,
            'sales' => $sales,
            'transfer' => $transfer,
            'sent' => $sent,
            'consignment' => $consignment,
            'consignmentIn' => $consignmentIn,
            'movement' => $movement,
            'movementIn' => $movementIn,
            'count' => $count,
        ));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
            // $this->render('error', $error);
                $this->render('error' . $error['code'], $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the setting page
     */
    public function actionSetting() {

        $this->render('settings');
    }

    /**
     * Displays the login page
     */
    public function actionLogin() {
        $model = new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(array('index'));
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
