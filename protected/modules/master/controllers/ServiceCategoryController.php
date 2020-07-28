<?php

class ServiceCategoryController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/backend';

	/**
	 * @return array action filters
	 */
	/* public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			// 'postOnly + delete', // we only allow deletion via POST request
		);
	}

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
				'actions'=>array('admin','delete', 'restore'),
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
		$model=new ServiceCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		$coaCriteria->addCondition("coa_sub_category_id = 22 and coa_id = 0");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);


	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));

	  	$coaDiskon = new Coa('search');
      	$coaDiskon->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaDiskon->attributes = $_GET['Coa'];

		$coaDiskonCriteria = new CDbCriteria;
		//$coaDiskonCriteria->addCondition("coa_sub_category_id = 2");
		$coaDiskonCriteria->compare('code',$coaDiskon->code.'%',true,'AND', false);
		$coaDiskonCriteria->compare('name',$coaDiskon->name,true);


	  	$coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaDiskonCriteria,
	  	));

		if(isset($_POST['ServiceCategory']))
		{
			$model->attributes=$_POST['ServiceCategory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
			'coaDiskon'=>$coaDiskon,
			'coaDiskonDataProvider'=>$coaDiskonDataProvider,
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
		$coa = new Coa('search');
      	$coa->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coa->attributes = $_GET['Coa'];

		$coaCriteria = new CDbCriteria;
		$coaCriteria->addCondition("coa_sub_category_id = 22 and coa_id = 0");
		$coaCriteria->compare('code',$coa->code.'%',true,'AND', false);
		$coaCriteria->compare('name',$coa->name,true);

	  	$coaDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaCriteria,
	  	));

  		$coaDiskon = new Coa('search');
      	$coaDiskon->unsetAttributes();  // clear any default values
      	if (isset($_GET['Coa']))
        	$coaDiskon->attributes = $_GET['Coa'];

		$coaDiskonCriteria = new CDbCriteria;
		//$coaCriteria->addCondition("coa_sub_category_id = 2");
		$coaDiskonCriteria->compare('code',$coaDiskon->code.'%',true,'AND', false);
		$coaDiskonCriteria->compare('name',$coaDiskon->name,true);


	  	$coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
	    	'criteria'=>$coaDiskonCriteria,
	  	));

		if(isset($_POST['ServiceCategory']))
		{
			$model->attributes=$_POST['ServiceCategory'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,
			'coaDiskon'=>$coaDiskon,
			'coaDiskonDataProvider'=>$coaDiskonDataProvider,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->remove();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionRestore($id)
	{
		// var_dump($id); die("S");
		$this->loadModel($id)->restore();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ServiceCategory');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ServiceCategory('search');
		//$model->disableBehavior('SoftDelete');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ServiceCategory']))
			$model->attributes=$_GET['ServiceCategory'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ServiceCategory the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ServiceCategory::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ServiceCategory $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='service-category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionAjaxCoa($id){
        if (Yii::app()->request->isAjaxRequest)
        {
            $coa = Coa::model()->findByPk($id);

            $object = array(
        		'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
  }
}
