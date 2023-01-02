<?php

class PendingRequestController extends Controller {

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
            $filterChain->action->id === 'viewSent' || 
            $filterChain->action->id === 'viewTransfer'
        ) {
            if (!(Yii::app()->user->checkAccess('operationHead'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $status_document = (isset($_GET['status_document'])) ? $_GET['status_document'] : '';
        $destination_approval_status = (isset($_GET['destination_approval_status'])) ? $_GET['destination_approval_status'] : '';
        $mainBranch = (isset($_GET['MainBranch'])) ? $_GET['MainBranch'] : '';
        $requesterBranch = (isset($_GET['RequesterBranch'])) ? $_GET['RequesterBranch'] : '';

        $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
        $branch = Branch::model()->findByPk($branchId);

        $transfer = Search::bind(new TransactionTransferRequest('search'), isset($_GET['TransactionTransferRequest']) ? $_GET['TransactionTransferRequest'] : '');
        $transferDataProvider = $transfer->search();
        $transferDataProvider->criteria->with = array('destinationBranch', 'requesterBranch');
        $transferDataProvider->criteria->order = 't.transfer_request_date DESC';
        $transferDataProvider->criteria->addBetweenCondition('t.transfer_request_date', $tanggal_mulai, $tanggal_sampai);

        $sent = Search::bind(new TransactionSentRequest('search'), isset($_GET['TransactionSentRequest']) ? $_GET['TransactionSentRequest'] : '');
        $sentDataProvider = $sent->search();
        $sentDataProvider->criteria->with = array('requesterBranch', 'destinationBranch');
        $sentDataProvider->criteria->order = 't.sent_request_date DESC';
        $sentDataProvider->criteria->addBetweenCondition('t.sent_request_date', $tanggal_mulai, $tanggal_sampai);

        $employeeDayoff = Search::bind(new EmployeeDayoff('search'), isset($_GET['EmployeeDayoff']) ? $_GET['EmployeeDayoff'] : '');
        $employeeDayoffDataProvider = $employeeDayoff->search();
        $employeeDayoffDataProvider->criteria->with = array('employee');
        $employeeDayoffDataProvider->criteria->order = 't.date_created DESC';
        $employeeDayoffDataProvider->criteria->addBetweenCondition('t.date_created', $tanggal_mulai, $tanggal_sampai);

        $maintenanceRequestHeader = Search::bind(new MaintenanceRequestHeader('search'), isset($_GET['MaintenanceRequestHeader']) ? $_GET['MaintenanceRequestHeader'] : '');
        $maintenanceRequestHeaderDataProvider = $maintenanceRequestHeader->search();
        $maintenanceRequestHeaderDataProvider->criteria->with = array('branch');
        $maintenanceRequestHeaderDataProvider->criteria->order = 't.transaction_date DESC';
        $maintenanceRequestHeaderDataProvider->criteria->addBetweenCondition('t.transaction_date', $tanggal_mulai, $tanggal_sampai);

        if (!empty($mainBranch)) {
            $transferDataProvider->criteria->addCondition('destination_branch_id = :destination_branch_id');
            $transferDataProvider->criteria->params[':destination_branch_id'] = $mainBranch;

            $sentDataProvider->criteria->addCondition('destination_branch_id = :destination_branch_id');
            $sentDataProvider->criteria->params[':destination_branch_id'] = $mainBranch;
        }

        if (!empty($requesterBranch)) {
            $transferDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $transferDataProvider->criteria->params[':requester_branch_id'] = $requesterBranch;

            $sentDataProvider->criteria->addCondition('requester_branch_id = :requester_branch_id');
            $sentDataProvider->criteria->params[':requester_branch_id'] = $requesterBranch;
        }

        if (!empty($status_document)) {
            $transferDataProvider->criteria->addCondition('status_document = :status_document');
            $transferDataProvider->criteria->params[':status_document'] = $status_document;

            $sentDataProvider->criteria->addCondition('status_document = :status_document');
            $sentDataProvider->criteria->params[':status_document'] = $status_document;
        }

        if (!empty($destination_approval_status)) {
            $transferDataProvider->criteria->addCondition('destination_approval_status = :destination_approval_status');
            $transferDataProvider->criteria->params[':destination_approval_status'] = $destination_approval_status;

            $sentDataProvider->criteria->addCondition('destination_approval_status = :destination_approval_status');
            $sentDataProvider->criteria->params[':destination_approval_status'] = $destination_approval_status;
        }

        $this->render('index', array(
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_sampai' => $tanggal_sampai,
            'status_document' => $status_document,
            'destination_approval_status' => $destination_approval_status,
            'branch' => $branch,
            'sent' => $sent,
            'sentDataProvider' => $sentDataProvider,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
            'mainBranch' => $mainBranch,
            'requesterBranch' => $requesterBranch,
            'employeeDayoffDataProvider' => $employeeDayoffDataProvider,
            'employeeDayoff' => $employeeDayoff,
            'maintenanceRequestHeader' => $maintenanceRequestHeader,
            'maintenanceRequestHeaderDataProvider' => $maintenanceRequestHeaderDataProvider,
        ));
    }
}
