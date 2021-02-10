<?php

class RegistrationServiceController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('admin','delete'),
				'users'=>array('Admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new RegistrationService;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RegistrationService']))
		{
			$model->attributes=$_POST['RegistrationService'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RegistrationService']))
		{
			$model->attributes=$_POST['RegistrationService'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('RegistrationService');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new RegistrationService('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['RegistrationService']))
			$model->attributes=$_GET['RegistrationService'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return RegistrationService the loaded model
	 * @throws CHttpException
	 */

	public function instantiate($id)
	{
		if (empty($id)){
			$registrationService = new RegistrationServices(new RegistrationService(), array());
			//print_r("test");
		}
		else
		{
			$registrationServiceModel = $this->loadModel($id);
			$registrationService = new RegistrationTransactions($registrationServiceModel, $registrationServiceModel->registrationServiceEmployees);
		}
		return $registrationService;
	}

	public function loadState($registrationService)
	{
		if (isset($_POST['RegistrationService']))
		{
			$registrationService->header->attributes = $_POST['RegistrationService'];
		}
		if (isset($_POST['RegistrationServiceEmployees']))
		{
			foreach ($_POST['RegistrationServiceEmployees'] as $i => $item)
			{
				if (isset($registrationService->employeeDetails[$i]))
					$registrationService->employeeDetails[$i]->attributes = $item;
				else
				{
					$detail = new RegistrationQuickService();
					$detail->attributes = $item;
					$registrationService->employeeDetails[] = $detail;
				}
			}
			if (count($_POST['RegistrationServiceEmployees']) < count($registrationService->employeeDetails))
				array_splice($registrationService->employeeDetails, $i + 1);
		}
		else
			$registrationService->employeeDetails = array();
	}

	public function loadModel($id)
	{
		$model=RegistrationService::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param RegistrationService $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='registration-service-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
