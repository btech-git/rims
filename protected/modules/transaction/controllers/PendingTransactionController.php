<?php

class PendingTransactionController extends Controller {

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
        if ($filterChain->action->id === 'index') {
            if (!(Yii::app()->user->checkAccess('pendingTransactionView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionIndex() {

        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? date('Y-m-d', strtotime($_GET['tanggal_mulai'])) : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? date('Y-m-d', strtotime($_GET['tanggal_sampai'])) : date('Y-m-d');
        $status_document = (isset($_GET['status_document'])) ? $_GET['status_document'] : 'Draft';
        $mainBranch = (isset($_GET['MainBranch'])) ? $_GET['MainBranch'] : '';
        $requesterBranch = (isset($_GET['RequesterBranch'])) ? $_GET['RequesterBranch'] : '';

        $model = new TransactionDeliveryOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionDeliveryOrder'])) {
            $model->attributes = $_GET['TransactionDeliveryOrder'];
        }

        $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
        $branch = Branch::model()->findByPk($branchId);

        $request = Search::bind(new TransactionRequestOrder('search'), isset($_GET['TransactionRequestOrder']) ? $_GET['TransactionRequestOrder'] : '');
        $requestDataProvider = $request->search();
        $requestDataProvider->criteria->with = array('mainBranch', 'requesterBranch');
        $requestDataProvider->criteria->order = 't.request_order_date DESC';
        $requestDataProvider->criteria->addBetweenCondition('t.request_order_date', $tanggal_mulai, $tanggal_sampai);

        $purchase = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : '');
        $purchaseDataProvider = $purchase->search();
        $purchaseDataProvider->criteria->with = array('mainBranch');
        $purchaseDataProvider->criteria->order = 't.purchase_order_date DESC';
        $purchaseDataProvider->criteria->addBetweenCondition('t.purchase_order_date', $tanggal_mulai, $tanggal_sampai);

        $transfer = Search::bind(new TransactionTransferRequest('search'), isset($_GET['TransactionTransferRequest']) ? $_GET['TransactionTransferRequest'] : '');
        $transferDataProvider = $transfer->search();
        $transferDataProvider->criteria->with = array('requesterBranch', 'destinationBranch');
        $transferDataProvider->criteria->order = 't.transfer_request_date DESC';
        $transferDataProvider->criteria->addBetweenCondition('t.transfer_request_date', $tanggal_mulai, $tanggal_sampai);

        $sent = Search::bind(new TransactionSentRequest('search'), isset($_GET['TransactionSentRequest']) ? $_GET['TransactionSentRequest'] : '');
        $sentDataProvider = $sent->search();
        $sentDataProvider->criteria->with = array('requesterBranch', 'destinationBranch');
        $sentDataProvider->criteria->order = 't.sent_request_date DESC';
        $sentDataProvider->criteria->addBetweenCondition('t.sent_request_date', $tanggal_mulai, $tanggal_sampai);

        $sales = Search::bind(new TransactionSalesOrder('search'), isset($_GET['TransactionSalesOrder']) ? $_GET['TransactionSalesOrder'] : '');
        $salesDataProvider = $sales->search();
        $salesDataProvider->criteria->with = array('requesterBranch');
        $salesDataProvider->criteria->order = 't.sale_order_date DESC';
        $salesDataProvider->criteria->addBetweenCondition('t.sale_order_date', $tanggal_mulai, $tanggal_sampai);

        $consignment = Search::bind(new ConsignmentOutHeader('search'), isset($_GET['ConsignmentOutHeader']) ? $_GET['ConsignmentOutHeader'] : '');
        $consignmentDataProvider = $consignment->search();
//        $consignmentDataProvider->criteria->with = array('branch');
//        $consignmentDataProvider->criteria->order = 't.date_posting DESC';
//        $consignmentDataProvider->criteria->addBetweenCondition('t.date_posting', $tanggal_mulai, $tanggal_sampai);

        $consignmentIn = Search::bind(new ConsignmentInHeader('search'), isset($_GET['ConsignmentInHeader']) ? $_GET['ConsignmentInHeader'] : '');
        $consignmentInDataProvider = $consignmentIn->search();
        $consignmentInDataProvider->criteria->with = array('receiveBranch');
        $consignmentInDataProvider->criteria->order = 't.date_posting DESC';
        $consignmentInDataProvider->criteria->addBetweenCondition('t.date_posting', $tanggal_mulai, $tanggal_sampai);

        $movement = Search::bind(new MovementOutHeader('search'), isset($_GET['MovementOutHeader']) ? $_GET['MovementOutHeader'] : '');
        $movementDataProvider = $movement->search();
        $movementDataProvider->criteria->with = array('branch');
        $movementDataProvider->criteria->order = 't.date_posting DESC';
        $movementDataProvider->criteria->addBetweenCondition('t.date_posting', $tanggal_mulai, $tanggal_sampai);

        $movementIn = Search::bind(new MovementInHeader('search'), isset($_GET['MovementInHeader']) ? $_GET['MovementInHeader'] : '');
        $movementInDataProvider = $movementIn->search();
        $movementInDataProvider->criteria->with = array('branch');
        $movementInDataProvider->criteria->order = 't.date_posting DESC';
        $movementInDataProvider->criteria->addBetweenCondition('t.date_posting', $tanggal_mulai, $tanggal_sampai);

        if (!empty($mainBranch)) {
            $requestDataProvider->criteria->addCondition('main_branch_id = :main_branch_id');
            $requestDataProvider->criteria->params[':main_branch_id'] = $mainBranch;

            $purchaseDataProvider->criteria->addCondition('main_branch_id = :main_branch_id');
            $purchaseDataProvider->criteria->params[':main_branch_id'] = $mainBranch;

            $transferDataProvider->criteria->addCondition('destination_branch_id = :destination_branch_id');
            $transferDataProvider->criteria->params[':destination_branch_id'] = $mainBranch;

            $sentDataProvider->criteria->addCondition('destination_branch_id = :destination_branch_id');
            $sentDataProvider->criteria->params[':destination_branch_id'] = $mainBranch;

            $consignmentInDataProvider->criteria->addCondition('receive_branch = :receive_branch');
            $consignmentInDataProvider->criteria->params[':receive_branch'] = $requesterBranch;
        }

        if (!empty($requesterBranch)) {
            $requestDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $requestDataProvider->criteria->params[':requester_branch_id'] = $requesterBranch;

            $transferDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $transferDataProvider->criteria->params[':requester_branch_id'] = $requesterBranch;

            $sentDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $sentDataProvider->criteria->params[':requester_branch_id'] = $requesterBranch;

            $salesDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $salesDataProvider->criteria->params[':requester_branch_id'] = $requesterBranch;

            $consignmentDataProvider->criteria->addCondition('branch_id = :branch_id');
            $consignmentDataProvider->criteria->params[':branch_id'] = $requesterBranch;

            $movementDataProvider->criteria->addCondition('branch_id = :branch_id');
            $movementDataProvider->criteria->params[':branch_id'] = $requesterBranch;

            $movementInDataProvider->criteria->addCondition('branch_id = :branch_id');
            $movementInDataProvider->criteria->params[':branch_id'] = $requesterBranch;
        }

        if (!empty($status_document)) {
            $requestDataProvider->criteria->addCondition('status_document = :status_document');
            $requestDataProvider->criteria->params[':status_document'] = $status_document;

            $purchaseDataProvider->criteria->addCondition('status_document = :status_document');
            $purchaseDataProvider->criteria->params[':status_document'] = $status_document;

            $transferDataProvider->criteria->addCondition('status_document = :status_document');
            $transferDataProvider->criteria->params[':status_document'] = $status_document;

            $sentDataProvider->criteria->addCondition('status_document = :status_document');
            $sentDataProvider->criteria->params[':status_document'] = $status_document;

            $salesDataProvider->criteria->addCondition('status_document = :status_document');
            $salesDataProvider->criteria->params[':status_document'] = $status_document;

            $consignmentDataProvider->criteria->addCondition('t.status = :status_document');
            $consignmentDataProvider->criteria->params[':status_document'] = $status_document;

            $consignmentInDataProvider->criteria->addCondition('status_document = :status_document');
            $consignmentInDataProvider->criteria->params[':status_document'] = $status_document;

            $movementDataProvider->criteria->addCondition('t.status = :status');
            $movementDataProvider->criteria->params[':status'] = $status_document;

            $movementInDataProvider->criteria->addCondition('t.status = :status');
            $movementInDataProvider->criteria->params[':status'] = $status_document;
        }

        $this->render('index', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'status_document' => $status_document,
            'model' => $model,
            'sent' => $sent,
            'sentDataProvider' => $sentDataProvider,
            'sales' => $sales,
            'salesDataProvider' => $salesDataProvider,
            'request' => $request,
            'requestDataProvider' => $requestDataProvider,
            'purchase' => $purchase,
            'purchaseDataProvider' => $purchaseDataProvider,
            'consignment' => $consignment,
            'consignmentDataProvider' => $consignmentDataProvider,
            'consignmentIn' => $consignmentIn,
            'consignmentInDataProvider' => $consignmentInDataProvider,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
            'movement' => $movement,
            'movementDataProvider' => $movementDataProvider,
            'movementIn' => $movementIn,
            'movementInDataProvider' => $movementInDataProvider,
            'branch' => $branch,
            'mainBranch' => $mainBranch,
            'requesterBranch' => $requesterBranch,
        ));
    }

}
