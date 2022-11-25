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
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $purchaseOrderSql = TransactionPurchaseOrder::pendingJournal();
        $purchaseOrderDataProvider = new CSqlDataProvider($purchaseOrderSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($purchaseOrderSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexPurchase', array(
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
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
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $registrationTransactionSql = RegistrationTransaction::pendingJournal();
        $registrationTransactionDataProvider = new CSqlDataProvider($registrationTransactionSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($registrationTransactionSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexRegistration', array(
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
        ));
    }
    
    public function actionIndexPaymentIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $paymentInSql = PaymentIn::pendingJournal();
        $paymentInDataProvider = new CSqlDataProvider($paymentInSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($paymentInSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexPaymentIn', array(
            'paymentInDataProvider' => $paymentInDataProvider,
        ));
    }
    
    public function actionIndexPaymentOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $paymentOutSql = PaymentOut::pendingJournal();
        $paymentOutDataProvider = new CSqlDataProvider($paymentOutSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($paymentOutSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexPaymentOut', array(
            'paymentOutDataProvider' => $paymentOutDataProvider,
        ));
    }
    
    public function actionIndexMovementIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $movementInSql = MovementInHeader::pendingJournal();
        $movementInDataProvider = new CSqlDataProvider($movementInSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($movementInSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexMovementIn', array(
            'movementInDataProvider' => $movementInDataProvider,
        ));
    }
    
    public function actionIndexMovementOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $movementOutSql = MovementOutHeader::pendingJournal();
        $movementOutDataProvider = new CSqlDataProvider($movementOutSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($movementOutSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexMovementOut', array(
            'movementOutDataProvider' => $movementOutDataProvider,
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
    
    public function actionIndexCashTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $cashTransactionSql = CashTransaction::pendingJournal();
        $cashTransactionDataProvider = new CSqlDataProvider($cashTransactionSql, array(
            'db' => CActiveRecord::$db,
            'totalItemCount' => CActiveRecord::$db->createCommand(SqlViewGenerator::count($cashTransactionSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));
        
        $this->render('indexCash', array(
            'cashTransactionDataProvider' => $cashTransactionDataProvider,
        ));
    }
    
    public function actionIndexSaleOrder() {
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
        
        $this->render('indexSaleOrder', array(
            'saleOrderDataProvider' => $saleOrderDataProvider,
        ));
    }
}
