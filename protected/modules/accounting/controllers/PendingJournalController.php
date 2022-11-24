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

    public function actionIndex() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 50;
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
        
        $transferRequest = Search::bind(new TransactionTransferRequest('search'), isset($_GET['TransactionTransferRequest']) ? $_GET['TransactionTransferRequest'] : '');
        $transferRequestDataProvider = $transferRequest->search();
        
        $this->render('index', array(
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'paymentInDataProvider' => $paymentInDataProvider,
            'paymentOutDataProvider' => $paymentOutDataProvider,
            'movementInDataProvider' => $movementInDataProvider,
            'movementOutDataProvider' => $movementOutDataProvider,
            'saleOrderDataProvider' => $saleOrderDataProvider,
            'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
            'cashTransactionDataProvider' => $cashTransactionDataProvider,
            'transferRequest' => $transferRequest,
            'transferRequestDataProvider' => $transferRequestDataProvider,
        ));
    }

    public function actionViewPurchase($id) {
        $model = TransactionPurchaseOrder::model()->findByPk($id);
        $purchaseOrderDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $id));

        $this->render('viewPurchase', array(
            'model' => $model,
            'purchaseOrderDetails' => $purchaseOrderDetails,
        ));
    }

    public function actionViewSale($id) {
        $model = TransactionSalesOrder::model()->findByPk($id);
        $saleOrderDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $id));

        $this->render('viewSale', array(
            'model' => $model,
            'saleOrderDetails' => $saleOrderDetails,
        ));
    }

    public function actionViewTransfer($id) {
        $model = TransactionTransferRequest::model()->findByPk($id);
        $transferRequestDetails = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $id));

        $this->render('viewTransfer', array(
            'model' => $model,
            'transferRequestDetails' => $transferRequestDetails,
        ));
    }
}
