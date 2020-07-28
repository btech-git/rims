<?php

class InspectionChecklistTypeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	/* public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
				'actions'=>array('admin','delete','ajaxHtmlAddChecklistModuleDetail','ajaxHtmlRemoveChecklistModuleDetail'),
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
		$model=new InspectionChecklistType;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		/*if(isset($_POST['InspectionChecklistType']))
		{
			$model->attributes=$_POST['InspectionChecklistType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));*/

		$checklistType = $this->instantiate(null);

		$checklistModule = new InspectionChecklistModule('search');
  		$checklistModule->unsetAttributes();  // clear any default values
  		if (isset($_GET['InspectionChecklistModule']))
    		$checklistModule->attributes = $_GET['InspectionChecklistModule'];

		$checklistModuleCriteria = new CDbCriteria;
		//$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
		$checklistModuleCriteria->compare('name',$checklistModule->name,true);

  		$checklistModuleDataProvider = new CActiveDataProvider('InspectionChecklistModule', array(
    		'criteria'=>$checklistModuleCriteria,
  		));
		

		$this->performAjaxValidation($checklistType->header);
		$checklistModuleArray = array();
		if(isset($_POST['InspectionChecklistType']))
		{
			$this->loadState($checklistType);
			if ($checklistType->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $checklistType->header->id));
			}  else {
				foreach ($checklistType->checklistModuleDetails as $key => $checklistModuleDetail) {
					print_r(CJSON::encode($checklistModuleDetail->id));
				}
			}
		
		}

		$this->render('create',array(
			//'model'=>$model,
			'checklistType'=>$checklistType,
			'checklistModule'=>$checklistModule,
			'checklistModuleDataProvider'=>$checklistModuleDataProvider,
			'checklistModuleArray'=>$checklistModuleArray,
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

		$checklistType = $this->instantiate(null);

		$checklistModule = new InspectionChecklistModule('search');
  		$checklistModule->unsetAttributes();  // clear any default values
  		if (isset($_GET['InspectionChecklistModule']))
    		$level->attributes = $_GET['InspectionChecklistModule'];

		$checklistModuleCriteria = new CDbCriteria;
		//$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
		$checklistModuleCriteria->compare('name',$checklistModule->name,true);

  		$checklistModuleDataProvider = new CActiveDataProvider('InspectionChecklistModule', array(
    		'criteria'=>$checklistModuleCriteria,
  		));

	  	$checklistModuleChecks = inspectionChecklistTypeModules::model()->findAllByAttributes(array('checklist_type_id'=>$id));
		$checklistModuleArray = array();
		foreach ($checklistModuleChecks as $key => $checklistModuleCheck) {
			array_push($checklistModuleArray,$checklistModuleCheck->checklist_module_id);
		}

  		$checklistType = $this->instantiate($id);
  		$this->performAjaxValidation($checklistType->header);

		if(isset($_POST['InspectionChecklistType']))
		{
			/*$model->attributes=$_POST['InspectionChecklistType'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));*/
			$this->loadState($checklistType);
			if ($checklistType->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $checklistType->header->id));
			} 
		}

		$this->render('update',array(
			//'model'=>$model,
			'checklistType'=>$checklistType,
			'checklistModule'=>$checklistModule,
			'checklistModuleDataProvider'=>$checklistModuleDataProvider,
			'checklistModuleArray'=>$checklistModuleArray
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
		$dataProvider=new CActiveDataProvider('InspectionChecklistType');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new InspectionChecklistType('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['InspectionChecklistType']))
			$model->attributes=$_GET['InspectionChecklistType'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return InspectionChecklistType the loaded model
	 * @throws CHttpException
	 */

	//Add Checklist Module Detail
	public function actionAjaxHtmlAddChecklistModuleDetail($id,$checklistModuleId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$checklistType = $this->instantiate($id); 	
			$this->loadState($checklistType);

			$checklistType->addChecklistModuleDetail($checklistModuleId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
     		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      		$this->renderPartial('_detailChecklistModule', array('checklistType'=>$checklistType), false, true);
		}
	}

	//Delete Checklist Module Detail
	public function actionAjaxHtmlRemoveChecklistModuleDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{

			$checklistType = $this->instantiate($id);
			$this->loadState($checklistType);
			//print_r(CJSON::encode($salesOrder->details));
			$checklistType->removeDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailChecklistModule', array('checklistType'=>$checklistType), false, true);
		}
	}

	public function instantiate($id)
	{
		if (empty($id)){
			$checklistType = new ChecklistTypes(new InspectionChecklistType(), array());
			//print_r("test");
		}
		else
		{
			$checklistTypeModel = $this->loadModel($id);
			$checklistType = new ChecklistTypes($checklistTypeModel, $checklistTypeModel->inspectionChecklistTypeModules);
		}
		return $checklistType;
	}

	public function loadState($checklistType)
	{
		if (isset($_POST['InspectionChecklistType']))
		{
			$checklistType->header->attributes = $_POST['InspectionChecklistType'];
		}

		if (isset($_POST['InspectionChecklistTypeModule']))
		{
			foreach ($_POST['InspectionChecklistTypeModule'] as $i => $item)
			{
				if (isset($checklistType->checklistModuleDetails[$i]))
					$checklistType->checklistModuleDetails[$i]->attributes = $item;
				else
				{
					$detail = new InspectionChecklistTypeModule();
					$detail->attributes = $item;
					$checklistType->checklistModuleDetails[] = $detail;
					//echo "test";
				}
			}
			if (count($_POST['InspectionChecklistTypeModule']) < count($checklistType->checklistModuleDetails))
				array_splice($checklistType->checklistModuleDetails, $i + 1);
		}
		else
			$checklistType->checklistModuleDetails = array();
	}


	public function loadModel($id)
	{
		$model=InspectionChecklistType::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param InspectionChecklistType $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='inspection-checklist-type-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
