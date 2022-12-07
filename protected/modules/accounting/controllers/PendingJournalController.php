<?php

class PendingJournalController extends Controller {

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
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'viewPurchase' || 
            $filterChain->action->id === 'viewSale' || 
            $filterChain->action->id === 'viewTransfer'
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseHead'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndexPurchase() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new TransactionPurchaseOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $model->attributes = $_GET['TransactionPurchaseOrder'];
        }
        
        $purchaseOrderDataProvider = $model->searchByPendingJournal();
        $purchaseOrderDataProvider->criteria->addBetweenCondition('SUBSTRING(t.purchase_order_date, 1, 10)', $startDate, $endDate);

        $this->render('indexPurchase', array(
            'model'=> $model,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexReceive() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $receiveItemSql = TransactionReceiveItem::pendingJournal();
        $receiveItemDataProvider = new CSqlDataProvider($receiveItemSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($receiveItemSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexReceive', array(
            'receiveItemDataProvider' => $receiveItemDataProvider,
        ));
    }
    
    public function actionIndexRegistration() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }
        
        $registrationTransactionDataProvider = $model->searchByPendingJournal();
        $registrationTransactionDataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('indexRegistration', array(
            'model'=> $model,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexPaymentIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new PaymentIn('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentIn'])) {
            $model->attributes = $_GET['PaymentIn'];
        }
        
        $paymentInDataProvider = $model->searchByPendingJournal();
        $paymentInDataProvider->criteria->addBetweenCondition('SUBSTRING(t.payment_date, 1, 10)', $startDate, $endDate);

        $this->render('indexPaymentIn', array(
            'model'=> $model,
            'paymentInDataProvider' => $paymentInDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexPaymentOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new PaymentOut('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentOut'])) {
            $model->attributes = $_GET['PaymentOut'];
        }
        
        $paymentOutDataProvider = $model->searchByPendingJournal();
        $paymentOutDataProvider->criteria->addBetweenCondition('SUBSTRING(t.payment_date, 1, 10)', $startDate, $endDate);

        $this->render('indexPaymentOut', array(
            'model'=> $model,
            'paymentOutDataProvider' => $paymentOutDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexMovementIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new MovementInHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MovementInHeader'])) {
            $model->attributes = $_GET['MovementInHeader'];
        }
        
        $movementInDataProvider = $model->searchByPendingJournal();
        $movementInDataProvider->criteria->addBetweenCondition('SUBSTRING(t.date_posting, 1, 10)', $startDate, $endDate);

        $this->render('indexMovementIn', array(
            'model'=> $model,
            'movementInDataProvider' => $movementInDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexMovementOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new MovementOutHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MovementOutHeader'])) {
            $model->attributes = $_GET['MovementOutHeader'];
        }
        
        $movementOutDataProvider = $model->searchByPendingJournal();
        $movementOutDataProvider->criteria->addBetweenCondition('SUBSTRING(t.date_posting, 1, 10)', $startDate, $endDate);

        $this->render('indexMovementOut', array(
            'model'=> $model,
            'movementOutDataProvider' => $movementOutDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexDelivery() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $deliveryOrderSql = TransactionDeliveryOrder::pendingJournal();
        $deliveryOrderDataProvider = new CSqlDataProvider($deliveryOrderSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($deliveryOrderSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));
        
        $this->render('indexDelivery', array(
            'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
        ));
    }
    
    public function actionIndexCash() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new CashTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CashTransaction'])) {
            $model->attributes = $_GET['CashTransaction'];
        }
        
        $cashTransactionDataProvider = $model->searchByPendingJournal();
        $cashTransactionDataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('indexCash', array(
            'model'=> $model,
            'cashTransactionDataProvider' => $cashTransactionDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionIndexSale() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $saleOrderSql = TransactionSalesOrder::pendingJournal();
        $saleOrderDataProvider = new CSqlDataProvider($saleOrderSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($saleOrderSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));
        
        $this->render('indexSale', array(
            'saleOrderDataProvider' => $saleOrderDataProvider,
        ));
    }
}
