<?php

class OutstandingOrderController extends Controller {

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
        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $status_document = (isset($_GET['status_document'])) ? $_GET['status_document'] : 'Approved';
        $mainBranch = (isset($_GET['MainBranch'])) ? $_GET['MainBranch'] : '';

        $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
        $branch = Branch::model()->findByPk($branchId);

        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $purchaseOrderDataProvider = $purchaseOrder->searchByReceive();
        $purchaseOrderDataProvider->criteria->with = array('mainBranch');
        $purchaseOrderDataProvider->criteria->order = 't.purchase_order_date DESC';
        $purchaseOrderDataProvider->criteria->addBetweenCondition('t.purchase_order_date', $tanggal_mulai, $tanggal_sampai);

        $saleOrder = Search::bind(new TransactionSalesOrder('search'), isset($_GET['TransactionSalesOrder']) ? $_GET['TransactionSalesOrder'] : '');
        $saleOrderDataProvider = $saleOrder->searchByDelivery();
        $saleOrderDataProvider->criteria->with = array('requesterBranch');
        $saleOrderDataProvider->criteria->order = 't.sale_order_date DESC';
        $saleOrderDataProvider->criteria->addBetweenCondition('t.sale_order_date', $tanggal_mulai, $tanggal_sampai);

        $transferRequest = Search::bind(new TransactionTransferRequest('search'), isset($_GET['TransactionTransferRequest']) ? $_GET['TransactionTransferRequest'] : '');
        $transferRequestDataProvider = $transferRequest->searchByDelivery();
        $transferRequestDataProvider->criteria->with = array('requesterBranch');
        $transferRequestDataProvider->criteria->order = 't.transfer_request_date DESC';
        $transferRequestDataProvider->criteria->addBetweenCondition('t.transfer_request_date', $tanggal_mulai, $tanggal_sampai);
        
        if (!empty($mainBranch)) {
            $purchaseOrderDataProvider->criteria->addCondition('main_branch_id = :main_branch_id');
            $purchaseOrderDataProvider->criteria->params[':main_branch_id'] = $mainBranch;

            $saleOrderDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $saleOrderDataProvider->criteria->params[':requester_branch_id'] = $mainBranch;
            
            $transferRequestDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $transferRequestDataProvider->criteria->params[':requester_branch_id'] = $mainBranch;
        }

        if (!empty($status_document)) {
            $purchaseOrderDataProvider->criteria->addCondition('status_document = :status_document');
            $purchaseOrderDataProvider->criteria->params[':status_document'] = $status_document;

            $saleOrderDataProvider->criteria->addCondition('status_document = :status_document');
            $saleOrderDataProvider->criteria->params[':status_document'] = $status_document;
            
            $transferRequestDataProvider->criteria->addCondition('status_document = :status_document');
            $transferRequestDataProvider->criteria->params[':status_document'] = $status_document;
        }

        $this->render('index', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'status_document' => $status_document,
            'branch' => $branch,
            'saleOrder' => $saleOrder,
            'saleOrderDataProvider' => $saleOrderDataProvider,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'transferRequest' => $transferRequest,
            'transferRequestDataProvider' => $transferRequestDataProvider,
            'mainBranch' => $mainBranch,
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
