<?php

class EquipmentBranchController extends Controller
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
				'actions'=>array('create','update','ajaxGetAge'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','ajaxHtmlAddMaintenanceDetail','ajaxHtmlRemoveMaintenanceDetail','ajaxGetNext','getEvents'),
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
		$equipmentMaintenance = EquipmentMaintenance::model()->findAllByAttributes(array('equipment_branch_id'=>$id));
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'equipmentMaintenance'=>$equipmentMaintenance,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new EquipmentBranch;
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EquipmentBranch']))
		{
			$model->attributes=$_POST['EquipmentBranch'];
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
		/* $model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['EquipmentBranch']))
		{
			$model->attributes=$_POST['EquipmentBranch'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		)); */
		$todays_month_year = date('Y-m'); 
		$equipmentBranch = $this->instantiate($id);
		
		$this->performAjaxValidation($equipmentBranch->header);
		
		// get daily,monthly,half yearly and quarterly, yearly tasks count.
		$dailyTasks      = 0;
		$weeklyTasks     = 0;
		$monthlyTasks    = 0;
		$quarterlyTasks  = 0;
		$halfyearlyTasks = 0;
		$yearlyTasks     = 0;
		$tasksCount     = 0;	
		
		foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc){
			$tasksCount++;
			if($equipmentMaintenanc->equipmentTask->check_period=="Daily"){
				$dailyTasks++;
			}
			else if($equipmentMaintenanc->equipmentTask->check_period=="Weekly"){
				$weeklyTasks++;
			}
			else if($equipmentMaintenanc->equipmentTask->check_period=="Monthly"){
				$monthlyTasks++;
			}
			else if($equipmentMaintenanc->equipmentTask->check_period=="Quarterly"){
				$quarterlyTasks++;
			}
			else if($equipmentMaintenanc->equipmentTask->check_period=="6 Months"){
				$halfyearlyTasks++;
			}
			else if($equipmentMaintenanc->equipmentTask->check_period=="Yearly"){
				$yearlyTasks++;
			}
		}
		
		// end of get daily,monthly,half yearly and quarterly, yearly tasks.
		$criteria 			= new CDbCriteria ;
        $todays_month_year 	= date('Y-m');
        $criteria->addCondition(
			"DATE_FORMAT(maintenance_date, '%Y-%m') = '$todays_month_year'"
		);
		$criteria->addCondition('equipment_branch_id = '.$equipmentBranch->header->id);
		$equipmentMaintenances = EquipmentMaintenance::model()->findAll($criteria);
		$maintenanceCount = count($equipmentMaintenances);
		
		$branchEquipments = equipments::model()->findAllByAttributes(array('branch_id'=>$equipmentBranch->header->branch_id));
		//$equipmentBranchTasks = equipmentTask::model()->findAllByAttributes(array('equipment_id'=>$equipmentBranch->header->equipment_id));
		
		if(isset($_POST['EquipmentBranch']))
		{	
			//echo "<pre>"; print_r($_POST['EquipmentMaintenance']); exit;
			$this->loadState($equipmentBranch);			
			if ($equipmentBranch->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $equipmentBranch->header->id));
			} 
			/*else 
			{
				echo "test";
			}*/
		}

		$this->render('update',array(
			//'equipmentBranchTasks'	=>$equipmentBranchTasks,
			'equipmentBranch' 		=>$equipmentBranch,
			'dailyTasks' 	  		=>$dailyTasks,
			'weeklyTasks'     		=>$weeklyTasks,
			'monthlyTasks'    		=>$monthlyTasks,
			'quarterlyTasks'  		=>$quarterlyTasks,
			'halfyearlyTasks' 		=>$halfyearlyTasks,
			'yearlyTasks'     		=>$yearlyTasks,
			'tasksCount'      		=>$tasksCount,
			'maintenanceCount' 		=>$maintenanceCount,
			'branchEquipments'      =>$branchEquipments,
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
		$dataProvider=new CActiveDataProvider('EquipmentBranch');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new EquipmentBranch('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EquipmentBranch']))
			$model->attributes=$_GET['EquipmentBranch'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EquipmentBranch the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=EquipmentBranch::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param EquipmentBranch $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='equipment-branch-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionAjaxGetAge()
	{	 
		//Convert it into a timestamp.
		$then = strtotime($_POST['EquipmentBranch']['purchase_date']);
		 
		//Get the current timestamp.
		$now = time();
		 
		//Calculate the difference.
		$difference = $now - $then;
		 
		//Convert seconds into days.
		$days = floor($difference / (60*60*24) );
		 
		echo $days;
	}
	
	//Add TAsk Detail
	public function actionAjaxHtmlAddMaintenanceDetail($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$equipmentBranch = $this->instantiate($id); 	
			$this->loadState($equipmentBranch);
			
			$equipmentBranch->addMaintainanceDetail();
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailMaintenance', array('equipmentBranch'=>$equipmentBranch), false, true);
		}
	}

	//Delete Task Detail
	public function actionAjaxHtmlRemoveMaintenanceDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$equipmentBranch = $this->instantiate($id);
			$this->loadState($equipmentBranch);
			$equipmentBranch->removeMaintainanceDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
			Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailMaintenance', array('equipmentBranch'=>$equipmentBranch), false, true);
		}
	}
	
	
	public function instantiate($id)
	{
		if (empty($id)){
			
			$equipmentBranch = new EquipmentBranches(new EquipmentBranch(), array());
		}
		else
		{
			$equipmentBranchModel = $this->loadModel($id);
			$equipmentBranch = new EquipmentBranches($equipmentBranchModel,  $equipmentBranchModel->equipmentMaintenances);
		}
		return $equipmentBranch;
	}

	public function loadState($equipmentBranch)
	{
		if (isset($_POST['EquipmentBranch']))
		{
			$equipmentBranch->header->attributes = $_POST['EquipmentBranch'];
		}
		
		if (isset($_POST['EquipmentMaintenance']))
		{
			foreach ($_POST['EquipmentMaintenance'] as $i => $item)
			{
				if (isset($equipmentBranch->equipmentMaintenances[$i])){
					$equipmentBranch->equipmentMaintenances[$i]->attributes = $item;
				}
				else
				{
					$detail = new EquipmentMaintenance();
					$detail->attributes = $item;
					$equipmentBranch->equipmentMaintenances[] = $detail;
				}
				//echo "<pre>";print_r($equipmentBranch->equipmentMaintenances); //exit;
			}
			
			if (count($_POST['EquipmentMaintenance']) < count($equipmentBranch->equipmentMaintenances))
				array_splice($equipmentBranch->equipmentMaintenances, $i + 1);
		//echo "<pre>";print_r($equipmentBranch->equipmentMaintenances); exit;
		}
		else
		{
			//echo "here1	"; 
			$equipmentBranch->equipmentMaintenances = array();
		}
			

	}
	
	// calculate next maintenance date
	public function actionAjaxGetNext()
	{
		$check_period = EquipmentTask::model()->findAllByAttributes(array('id'=>$_GET['selected_task']));
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
			echo $nextDate = date('Y-m-d', strtotime($_GET['maintenance_date']. ' + '.$add_days.'days'));
		}
		else
		{
			echo '0';
		}
	}
	
	public function actionGetEvents()
    {  
		$id 	= $_GET['id'];  
        $items 	= array();																			
        $equipmentBranch = $this->instantiate($id);  
        foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc) {
			
			$color = '#CC0000';
			switch($equipmentMaintenanc->equipmentTask->check_period){
				case 'Daily':
							$color = '#CC0000';
							break;
				case 'Weekly':
							$color = '#FFE633';
							break;
				case 'Monthly':
							$color = '#68FF33';
							break;
				case 'Quarterly':
							$color = '#33FF9C';
							break;
				case '6 Months':
							$color = '#33B5FF';
							break;
				case 'Yearly':
							$color = '#AC33FF';
							break;
			}
			
            $items[]=array(
                'title'=>$equipmentMaintenanc->equipmentTask->task,
                'start'=>$equipmentMaintenanc->maintenance_date,
                'end'=>$equipmentMaintenanc->next_maintenance_date,
                'color'=>$color,
                'allDay'=>true,
                'url'=>$this->createUrl('equipmentMaintenance/update?id='.$equipmentMaintenanc->id)
            );
        }
        echo CJSON::encode($items);
        Yii::app()->end();
    }
}
