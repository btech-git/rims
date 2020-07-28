<?php

class PendingRequestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	/*public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','ajaxSent','ajaxHtmlAddDetail','ajaxSales','ajaxHtmlRemoveDetail','ajaxCustomer','ajaxHtmlRemoveDetailRequest','ajaxConsignment','ajaxTransfer'),
				'users'=>array('Admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : date('Y-m-d');
        $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : date('Y-m-d');
        $status_document = (isset($_GET['status_document'])) ? $_GET['status_document'] : 'Draft';
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
//        $transferDataProvider->criteria->addCondition("destination_approval_status = 0");

        $sent = Search::bind(new TransactionSentRequest('search'), isset($_GET['TransactionSentRequest']) ? $_GET['TransactionSentRequest'] : '');
        $sentDataProvider = $sent->search();
        $sentDataProvider->criteria->with = array('requesterBranch', 'destinationBranch');      
        $sentDataProvider->criteria->order = 't.sent_request_date DESC';
        $sentDataProvider->criteria->addBetweenCondition('t.sent_request_date', $tanggal_mulai, $tanggal_sampai);
//        $sentDataProvider->criteria->addCondition("destination_approval_status = 0");

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
        
		$this->render('index',array(
			'tanggal_mulai' =>$tanggal_mulai,
			'tanggal_sampai' => $tanggal_sampai,
			'status_document' =>$status_document,
			'destination_approval_status' =>$destination_approval_status,
            'branch' => $branch,
			'sent'=>$sent,
			'sentDataProvider'=>$sentDataProvider,
			'transfer'=>$transfer,
			'transferDataProvider'=>$transferDataProvider,
            'mainBranch' => $mainBranch,
            'requesterBranch' => $requesterBranch,
		));
	}	
    
    public function actionViewSent($id)
    {
        $model = TransactionSentRequest::model()->findByPk($id);
        $sentDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $id));

        if (isset($_POST['Approve'])) {
            $model->destination_approval_status = 1;

            if ($model->update(array('destination_approval_status'))) 
                $this->redirect(array('index'));
        }

        if (isset($_POST['Reject'])) {
            $model->destination_approval_status = 2;

            if ($model->update(array('destination_approval_status'))) 
                $this->redirect(array('index'));
        }

        $this->render('viewSent', array(
            'model' => $model,
            'sentDetails' => $sentDetails,
        ));
    }

    public function actionViewTransfer($id)
    {
        $model = TransactionTransferRequest::model()->findByPk($id);
        $transferDetails = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $id));
        
        if (isset($_POST['Approve'])) {
            $model->destination_approval_status = 1;

            if ($model->update(array('destination_approval_status'))) 
                $this->redirect(array('index'));
        }

        if (isset($_POST['Reject'])) {
            $model->destination_approval_status = 2;

            if ($model->update(array('destination_approval_status'))) 
                $this->redirect(array('index'));
        }

        $this->render('viewTransfer', array(
            'model' => $model,
            'transferDetails' => $transferDetails,
        ));
    }
}