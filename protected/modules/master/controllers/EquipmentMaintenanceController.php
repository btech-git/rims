<?php

class EquipmentMaintenanceController extends Controller
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
				'actions'=>array('admin','delete','ajaxGetTask','ajaxGetNext'),
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
		$model=new EquipmentMaintenance;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		if(isset($_POST['EquipmentMaintenance']) && !empty($_POST['EquipmentMaintenance']))
		{
			$model->attributes=$_POST['EquipmentMaintenance'];
			// changes in the process of storing data. 
			$t1 = microtime(true); 
			$sql = 'INSERT into rims_equipment_maintenance 
						(`id`, `equipment_task_id`, `equipment_branch_id`, `employee_id`, `maintenance_date`,`next_maintenance_date`,`checked`,`notes`,`condition`,`status`) VALUES 
						(NULL, \''.$model->equipment_task_id.'\', \''.$model->equipment_branch_id.'\', \''.$model->employee_id.'\', \''.$model->maintenance_date.'\', \''.$model->next_maintenance_date.'\', \''.$model->checked.'\', \''.$model->notes.'\', \''.$model->condition.'\',\'Active\')';
			
			$get_task_check_period = EquipmentTask::model()->findAllByPk($model->equipment_task_id);
			if(!empty($get_task_check_period)){
			switch($get_task_check_period[0]['check_period']){
				case 'Daily':
						$maintenance_date = $model->next_maintenance_date;
						for($i=0;$i<363;$i++)
						{
							$add_days = 1;
							$nextDate = date('Y-m-d', strtotime($maintenance_date. ' + '.$add_days.'days'));
							$sql .= ',(NULL, \''.$model->equipment_task_id.'\', \''.$model->equipment_branch_id.'\', \''.$model->employee_id.'\', \''.$maintenance_date.'\', \''.$nextDate.'\', \''.$model->checked.'\', \''.$model->notes.'\', \''.$model->condition.'\',\'Active\')';
							$maintenance_date = $nextDate;
						}
						break;
				case 'Weekly':
						$maintenance_date = $model->next_maintenance_date;
						for($i=0;$i<6;$i++)
						{
							$add_days = 7;
							$nextDate = date('Y-m-d', strtotime($maintenance_date. ' + '.$add_days.'days'));
							$sql .= ',(NULL, \''.$model->equipment_task_id.'\', \''.$model->equipment_branch_id.'\', \''.$model->employee_id.'\', \''.$maintenance_date.'\', \''.$nextDate.'\', \''.$model->checked.'\', \''.$model->notes.'\', \''.$model->condition.'\',\'Active\')';
							$maintenance_date = $nextDate;
						}break;
				case 'Monthly':
						$maintenance_date = $model->next_maintenance_date;
						for($i=0;$i<11;$i++)
						{
							$add_days = 30;
							$nextDate = date('Y-m-d', strtotime($maintenance_date. ' + '.$add_days.'days'));
							$sql .= ',(NULL, \''.$model->equipment_task_id.'\', \''.$model->equipment_branch_id.'\', \''.$model->employee_id.'\', \''.$maintenance_date.'\', \''.$nextDate.'\', \''.$model->checked.'\', \''.$model->notes.'\', \''.$model->condition.'\',\'Active\')';
							$maintenance_date = $nextDate;
						}break;		
				case 'Quarterly':
						$maintenance_date = $model->next_maintenance_date;
						for($i=0;$i<3;$i++)
						{
							$add_days = 91;
							$nextDate = date('Y-m-d', strtotime($maintenance_date. ' + '.$add_days.'days'));
							$sql .= ',(NULL, \''.$model->equipment_task_id.'\', \''.$model->equipment_branch_id.'\', \''.$model->employee_id.'\', \''.$maintenance_date.'\', \''.$nextDate.'\', \''.$model->checked.'\', \''.$model->notes.'\', \''.$model->condition.'\',\'Active\')';
							$maintenance_date = $nextDate;
						}
						break;
				case '6 Months':
						$maintenance_date = $model->next_maintenance_date;
						for($i=0;$i<1;$i++)
						{
							$add_days = 182;
							$nextDate = date('Y-m-d', strtotime($maintenance_date. ' + '.$add_days.'days'));
							$sql .= ',(NULL, \''.$model->equipment_task_id.'\', \''.$model->equipment_branch_id.'\', \''.$model->employee_id.'\', \''.$maintenance_date.'\', \''.$nextDate.'\', \''.$model->checked.'\', \''.$model->notes.'\', \''.$model->condition.'\',\'Active\')';
							$maintenance_date = $nextDate;
						}break;
				case 'Yearly':
						break;
			}
			}
			$sql .= ';';
			$connection = Yii::app() -> db;
			$command = $connection -> createCommand($sql);
			$command -> execute();
			//$execution_time = sprintf('It took %.5f sec', microtime(true)-$t1);
			if($model->save())
				$this->redirect(array('admin'));
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

		if(isset($_POST['EquipmentMaintenance']))
		{
			$model->attributes=$_POST['EquipmentMaintenance'];
			if($model->save())
				$this->redirect(array('admin'));
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
		$dataProvider=new CActiveDataProvider('EquipmentMaintenance');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EquipmentMaintenance('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EquipmentMaintenance']))
			$model->attributes=$_GET['EquipmentMaintenance'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EquipmentMaintenance the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EquipmentMaintenance::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EquipmentMaintenance $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipment-maintenance-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	// Get Equipment Tasks
	public function actionAjaxGetTask()
	{
		$get_eq_id  = EquipmentBranch::model()->find(array('condition'=>'id='.$_POST['EquipmentMaintenance']['equipment_branch_id']));
		if(!empty($get_eq_id)){
			$data 		= EquipmentTask::model()->findAllByAttributes(array('equipment_id'=>$get_eq_id['equipment_id']),array('order'=>'task ASC'));
		
			if(!empty($data))
			{
				$data=CHtml::listData($data,'id','task');
				echo CHtml::tag('option',array('value'=>''),'[--Select Equipment Task--]',true);
				foreach($data as $value=>$name)
				{			
					echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);				
				}
			}
			else
			{
				echo CHtml::tag('option',array('value'=>''),'[--Select Equipment Task--]',true);
			}
		}
		else
			{
				echo CHtml::tag('option',array('value'=>''),'[--Select Equipment Task--]',true);
			}
	}
	
	// calculate next maintenance date
	public function actionAjaxGetNext()
	{
		$check_period = EquipmentTask::model()->findAllByAttributes(array('id'=>$_POST['EquipmentMaintenance']['equipment_task_id']));
		if($check_period!='')
		{
			switch($check_period[0]['check_period']){
				case 'Daily':
							$add_days = 1;
							break;
				case 'Weekly':
							$add_days = 7;
							break;
				case 'Monthly':
							$add_days = 30;
							break;
				case 'Quarterly':
							$add_days = 91;
							break;
				case '6 Months':
							$add_days = 182;
							break;
				case 'Yearly':
							$add_days = 365;
							break;
			}
			
			echo $nextDate = date('Y-m-d', strtotime($_POST['EquipmentMaintenance']['maintenance_date']. ' + '.$add_days.'days'));
		}
		else
		{
			echo '0';
		}
	}
}
