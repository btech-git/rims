<?php

class SiteController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        $filterChain->run();
    }

    /**
     * Declares class-based actions.
     */
//    public function actions() {
//        return array(
//            // captcha action renders the CAPTCHA image displayed on the contact page
//            'captcha' => array(
//                'class' => 'CCaptchaAction',
//                'backColor' => 0xFFFFFF,
//            ),
//            // page action renders "static" pages stored under 'protected/views/site/pages'
//            // They can be accessed via: index.php?r=site/page&view=FileName
//            'page' => array(
//                'class' => 'CViewAction',
//            ),
//        );
//    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('login'));
        } else {
            $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

            $endDate = date('Y-m-d');
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $vehicleDataProvider = $vehicle->searchByDashboard();
            $productDataProvider = $product->searchByStockCheck($pageNumber);
            $branches = Branch::model()->findAll();

            $vehicleDataProvider->criteria->with = array(
                'customer',
            );

            $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
            $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '';

            if (!empty($customerName)) {
                $vehicleDataProvider->criteria->addCondition('customer.name LIKE :customer_name');
                $vehicleDataProvider->criteria->params[':customer_name'] = "%{$customerName}%";
            }

            if (!empty($customerType)) {
                $vehicleDataProvider->criteria->addCondition('customer.customer_type = :customer_type');
                $vehicleDataProvider->criteria->params[':customer_type'] = $customerType;
            }

            if (isset($_GET['Vehicle'])) {
                $vehicle->attributes = $_GET['Vehicle'];
            }

            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

//            $assetPurchases = AssetPurchase::model()->findAll();
//            
//            $transactionDate = '2022-01-12';
//            list($year, $month, ) = explode('-', $transactionDate);
//            $startDate = $year . '-' . $month . '-01';
//            $endDate = date_create(date('Y-m-t'));
//            for ($currentDate = date_create($startDate); $currentDate < $endDate; $currentDate->add(new DateInterval('P1M'))) {
//                var_dump($currentDate);
//            }
            
//            foreach ($assetPurchases as $detail) {
//                
//                $purchaseDate = strtotime($detail->transaction_date);
//                $currentDate = strtotime(date('Y-m-t'));
//
//                for ($i = $purchaseDate; $i <= $currentDate; $i += 2630000) {
//                    echo $detail->id . ' - ' . date('Y-m-t', $i ) . '<br />';
//                }
//            }
            
//            $count = 0;
//            $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
//            $date = date_create(date('d-m-Y'));
//            date_sub($date, date_interval_create_from_date_string("7 days"));

//            if (!empty($branchId)) {
//                $requestCriteria = new CDbCriteria;
//                $requestCriteria->addCondition(" DATE(request_order_date) >= (NOW() - INTERVAL 7 DAY)");
//                $requestCriteria->addInCondition('main_branch_id', Yii::app()->user->branch_ids);
//                $requestOrder = TransactionRequestOrder::model()->findAll($requestCriteria);
//                
//                $purchaseCriteria = new CDbCriteria;
//                $purchaseCriteria->addInCondition('main_branch_id', Yii::app()->user->branch_ids);
//                $purchaseCriteria->addCondition(" DATE(purchase_order_date) >= (NOW() - INTERVAL 7 DAY)");
//                $purchase = TransactionPurchaseOrder::model()->findAll($purchaseCriteria);
//
//                $salesCriteria = new CDbCriteria;
//                $salesCriteria->addInCondition('requester_branch_id', Yii::app()->user->branch_ids);
//                $salesCriteria->addCondition(" DATE(sale_order_date) >= (NOW() - INTERVAL 7 DAY)");
//                $sales = TransactionSalesOrder::model()->findAll($salesCriteria);
//
//                $transferCriteria = new CDbCriteria;
//                $transferCriteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);
//                $transferCriteria->addCondition(" DATE(transfer_request_date) >= (NOW() - INTERVAL 7 DAY)");
//                $transfer = TransactionTransferRequest::model()->findAll($transferCriteria);
//
//                $sentCriteria = new CDbCriteria;
//                $sentCriteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);
//                $sentCriteria->addCondition(" DATE(sent_request_date) >= (NOW() - INTERVAL 7 DAY)");
//                $sent = TransactionSentRequest::model()->findAll($sentCriteria);
//
//                $consignmentCriteria = new CDbCriteria;
//                $consignmentCriteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
//                $consignmentCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
//                $consignment = ConsignmentOutHeader::model()->findAll($consignmentCriteria);
//
//                $consignmentInCriteria = new CDbCriteria;
//                $consignmentInCriteria->addInCondition('receive_branch', Yii::app()->user->branch_ids);
//                $consignmentInCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
//                $consignmentIn = ConsignmentInHeader::model()->findAll($consignmentInCriteria);
//
//                $movementCriteria = new CDbCriteria;
//                $movementCriteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
//                $movementCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
//                $movement = MovementOutHeader::model()->findAll($movementCriteria);
//
//                $movementInCriteria = new CDbCriteria;
//                $movementInCriteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
//                $movementInCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
//                $movementIn = MovementInHeader::model()->findAll($movementInCriteria);

//            }
        }
        
//        $totalReceivables = InvoiceHeader::totalReceivables();
//        $totalPayables = TransactionReceiveItem::totalPayables();
//        
//        $resultSet = RegistrationTransaction::graphSale();
//        $records = array();
//        $year = intval(date('Y'));
//        $month = intval(date('m'));
//        for ($i = 0; $i < 12; $i++) {
//            $records[$year][$month] = 0;
//            $month--;
//            if ($month <= 0) {
//                $month += 12;
//                $year--;
//            }
//        }
//        foreach ($resultSet as $item) {
//            $month = intval($item['month']);
//            $year = intval($item['year']);
//            if (isset($records[$year][$month])) {
//                $records[$year][$month] = doubleval($item['grand_total']);
//            }
//        }
//        $rows = array();
//        foreach ($records as $y => $record) {
//            foreach ($record as $m => $value) {
//                $month = date("M", mktime(0, 0, 0, $m));
//                $year = substr($y, 2);
//                $rows[] = array($month . " " . $year, $value);
//            }
//        }
//        $dataSale = array_merge(array(array('Monthly', 'Sales')), array_reverse($rows));
//
//        $resultSetBranch = JurnalUmum::graphSalePerBranch();
//        $branchRows = array();
//        foreach ($resultSetBranch as $item) {
//            $branchRows[] = array($item['branch_name'], doubleval($item['total']));
//        }
//        $dataSalePerBranch = array_merge(array(array('Branch', 'Sales')), $branchRows);
//
//        $resultSetIncomeExpense = JurnalUmum::graphIncomeExpense();
//        $incomeExpenseRecords = array();
//        $incomeExpenseYear = intval(date('Y'));
//        $incomeExpenseMonth = intval(date('m'));
//        for ($i = 0; $i < 12; $i++) {
//            $incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth] = 0;
//            $incomeExpenseMonth--;
//            if ($incomeExpenseMonth <= 0) {
//                $incomeExpenseMonth += 12;
//                $incomeExpenseYear--;
//            }
//        }
//        foreach ($resultSetIncomeExpense as $item) {
//            $incomeExpenseMonth = intval($item['month']);
//            $incomeExpenseYear = intval($item['year']);
//            if (isset($incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth])) {
//                $incomeExpenseRecords[$incomeExpenseYear][$incomeExpenseMonth] = array(doubleval($item['debit']), doubleval($item['kredit']));
//            }
//        }
//        $incomeExpenseRows = array();
//        foreach ($incomeExpenseRecords as $y => $record) {
//            foreach ($record as $m => $value) {
//                $incomeExpenseMonth = date("M", mktime(0, 0, 0, $m));
//                $incomeExpenseYear = substr($y, 2);
//                $incomeExpenseRows[] = array_merge(array($incomeExpenseMonth . " " . $incomeExpenseYear), $value);
//            }
//        }
//        $dataIncomeExpense = array_merge(array(array('Monthly', 'Income', 'Expense')), array_reverse($incomeExpenseRows));

        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'productDataProvider' => $productDataProvider, 
            'product' => $product, 
            'customerName' => $customerName,
            'customerType' => $customerType,
            'branches' => $branches,
            'endDate' => $endDate,
//            'dataSale' => $dataSale,
//            'dataSalePerBranch' => $dataSalePerBranch,
//            'dataIncomeExpense' => $dataIncomeExpense,
//            'totalReceivables' => $totalReceivables,
//            'totalPayables' => $totalPayables,
//            'requestOrder' => $requestOrder,
//            'purchase' => $purchase,
//            'sales' => $sales,
//            'transfer' => $transfer,
//            'sent' => $sent,
//            'consignment' => $consignment,
//            'consignmentIn' => $consignmentIn,
//            'movement' => $movement,
//            'movementIn' => $movementIn,
//            'count' => $count,
        ));
    }
    
    public function actionAjaxHtmlUpdateProductStockTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $endDate = date('Y-m-d');
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productDataProvider = $product->searchByStockCheck($pageNumber);
            $branches = Branch::model()->findAll();

            $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
            ));
        }
    }

    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carMakeId = isset($_GET['Vehicle']['car_make_id']) ? $_GET['Vehicle']['car_make_id'] : 0;

            $this->renderPartial('_carModelSelect', array(
                'carMakeId' => $carMakeId,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateCarSubModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $carModelId = isset($_GET['Vehicle']['car_model_id']) ? $_GET['Vehicle']['car_model_id'] : 0;

            $this->renderPartial('_carSubModelSelect', array(
                'carModelId' => $carModelId,
            ));
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
