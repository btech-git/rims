<?php

class UserController extends Controller
{
    /**
     * layout for login page
     * @var string
     */
    public $layout = '//layouts/login';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array();
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array();
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
	public function actionAdd()
	{
		$model=new User;
		$modelUserLogin = new UserLogin;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		//var_dump($modelUserLogin->validate());
		if(isset($_POST['User'], $_POST['UserLogin']))
		{
			$model->attributes=$_POST['User'];
			$model->status = EnumStatus::ACTIVE;
						
			$modelUserLogin->attributes = $_POST['UserLogin'];
			$modelUserLogin->password_repeat = $_POST['UserLogin']['password_repeat'];
			$modelUserLogin->status_login = 0;
			
			$modelUserLogin->password = UserLogin::encrypt($modelUserLogin->password);
			$modelUserLogin->password_repeat = UserLogin::encrypt($modelUserLogin->password_repeat);
			
			if($model->validate() & $modelUserLogin->validate()) {
				$model->save();
				$model->log(EnumLogAction::INSERT);
				
				$modelUserLogin->user_id = $model->id;
				$modelUserLogin->save();
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$modelUserLogin->password = '';
		$modelUserLogin->password_repeat = '';

		$this->render('add',array(
			'model'=>$model,
			'modelUserLogin' => $modelUserLogin,
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
		$modelUserLogin = $this->loadModelUserLogin($id);
		$username = $modelUserLogin->username;
		$password = $modelUserLogin->password;
		$modelUserLogin->password = '';
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']) && isset($_POST['UserLogin']))
		{
			$model->attributes=$_POST['User'];
			
			$modelUserLogin->attributes = $_POST['UserLogin'];
			$modelUserLogin->username = $username;
			$modelUserLogin->password_repeat = $_POST['UserLogin']['password_repeat'];
						
			if ($modelUserLogin->password == '') {
				$modelUserLogin->password = $password;
				$modelUserLogin->password_repeat = $password;
			} else {
				$modelUserLogin->password = UserLogin::encrypt($modelUserLogin->password);
				$modelUserLogin->password_repeat = UserLogin::encrypt($modelUserLogin->password_repeat);
			}
			
			if($model->validate() & $modelUserLogin->validate()) {
				$oldModel = User::model()->findByPk($model->id);
				$model->save();
				$model->log(EnumLogAction::UPDATE, $oldModel);

				$modelUserLogin->save();
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		
		$modelUserLogin->password = '';
		$modelUserLogin->password_repeat = '';

		$this->render('update',array(
			'model'=>$model,
			'modelUserLogin' => $modelUserLogin,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel($id);
			$model->status = EnumStatus::DELETED;
			$model->save();

			$model->log(EnumLogAction::DELETE);

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Deletes a list of model.	 
	 */
	public function actionDeleteSelected()
	{
		if(Yii::app()->request->isPostRequest && isset($_POST['ids']))
		{
			// delete
			foreach ($_POST['ids'] as $id) {
				$model = $this->loadModel($id);
				$model->status = EnumStatus::DELETED;
				$model->save();
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];
		
		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModelUserLogin($id)
	{
		$model=UserLogin::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
