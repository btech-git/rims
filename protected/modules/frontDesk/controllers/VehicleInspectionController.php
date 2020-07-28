<?php

class VehicleInspectionController extends Controller
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
				'actions'=>array('admin','delete','inspection','ajaxHtmlAddVehicleInspectionDetail'),
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
			'vehicleInspection'=>$this->instantiate($id),
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		/*$model=new VehicleInspection;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VehicleInspection']))
		{
			$model->attributes=$_POST['VehicleInspection'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));*/

		$vehicleInspection = $this->instantiate(null);
        $vehicleInspection->header->inspection_date = date('Y-m-d');

		$vehicleInspectionDetail = new VehicleInspectionDetail('search');
  		$vehicleInspectionDetail->unsetAttributes();  // clear any default values
  		if (isset($_GET['VehicleInspectionDetail']))
    		$vehicleInspection->attributes = $_GET['VehicleInspectionDetail'];

		$vehicleInspectionDetailCriteria = new CDbCriteria;
		//$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
		//$vehicleInspectionDetailCriteria->compare('name',$vehicleInspectionDetail->name,true);

  		$vehicleInspectionDetailDataProvider = new CActiveDataProvider('VehicleInspectionDetail', array(
    		'criteria'=>$vehicleInspectionDetailCriteria,
  		));

		$this->performAjaxValidation($vehicleInspection->header);

		//$sectionArray = array();
		if(isset($_POST['VehicleInspection']))
		{
			$this->loadState($vehicleInspection);
			if ($vehicleInspection->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $vehicleInspection->header->id));
			}  else {
				
			}
		
		}

		$this->render('create',array(
			//'model'=>$model,
			'vehicleInspection'=>$vehicleInspection,
			'vehicleInspectionDetail'=>$vehicleInspectionDetail,
			'vehicleInspectionDetailDataProvider'=>$vehicleInspectionDetailDataProvider,
			//'sectionArray'=>$sectionArray,
		));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		//$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$vehicleInspectionDetail = new VehicleInspectionDetail('search');
  		$vehicleInspectionDetail->unsetAttributes();  // clear any default values
  		if (isset($_GET['VehicleInspectionDetail']))
    		$vehicleInspection->attributes = $_GET['VehicleInspectionDetail'];

		$vehicleInspectionDetailCriteria = new CDbCriteria;
		//$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
		//$vehicleInspectionDetailCriteria->compare('name',$vehicleInspectionDetail->name,true);

  		$vehicleInspectionDetailDataProvider = new CActiveDataProvider('VehicleInspectionDetail', array(
    		'criteria'=>$vehicleInspectionDetailCriteria,
  		));

  		$vehicleInspection = $this->instantiate($id);
		$this->performAjaxValidation($vehicleInspection->header);

		if(isset($_POST['VehicleInspection']))
		{
			$this->loadState($vehicleInspection);
			if ($vehicleInspection->save(Yii::app()->db)){
				$this->redirect(array('view', 'id' => $vehicleInspection->header->id));
			}  else {
				foreach ($vehicleInspection->vehicleInspectionDetails as $key => $vehicleInspectionDetail) {
					//print_r(CJSON::encode($vehicleInspectionDetail->id));
				}
			}
		
		}

		$this->render('update',array(
			//'model'=>$model,
			'vehicleInspection'=>$vehicleInspection,
			'vehicleInspectionDetail'=>$vehicleInspectionDetail,
			'vehicleInspectionDetailDataProvider'=>$vehicleInspectionDetailDataProvider,
			//'sectionArray'=>$sectionArray,
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
		$dataProvider=new CActiveDataProvider('VehicleInspection');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		/*$vehicleInspectionCriteria = new CDbCriteria;
		$vehicleInspectionCriteria->select = 't.id'; // select fields which you want in output
		$criteria->condition = 't.status = 1';
		$vehicleInspection = VehicleInspection::model()->findAll($vehicleInspectionCriteria);*/
		$plate_number ='';
  		$vehicle = new RegistrationTransaction('search');
		$vehicle->unsetAttributes();  // clear any default values
  		// $vehicle->work_order_number != ''; // not working! move to model.
		if(isset($_GET['RegistrationTransaction'])) {
			// var_dump($_GET['RegistrationTransaction']); die();
			// $plate_number=($_GET['RegistrationTransaction']['plate_number'] == NULL)?"":$_GET['RegistrationTransaction']['plate_number'];
			$vehicle->attributes=$_GET['RegistrationTransaction'];
		}
		$vehicleCriteria = new CDbCriteria;
		//$vehicleCriteria->condition = 't.id IN (SELECT id from rims_vehicle_inspection)';
		$vehicleCriteria->condition = 't.work_order_number IS NOT NULL';
		$vehicleCriteria->together = 'true';
		$vehicleCriteria->with = array('vehicle');
		$vehicleCriteria->addSearchCondition('vehicle.plate_number', $plate_number, true);
		$vehicleCriteria->order = 'transaction_date DESC';

		$vehicleDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
    		'criteria'=>$vehicleCriteria,
			'sort' => array(
            'defaultOrder' => 'transaction_number',
            'attributes' => array(
	                'plate_number' => array(
	                    'asc' => 'vehicle.plate_number ASC',
	                    'desc' => 'vehicle.plate_number DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),

  		));

		//$model= Vehicle::model()->findAll($criteria);
		//$model->unsetAttributes();  // clear any default values
		//if(isset($_GET['Vehicle']))
			//$model->attributes=$_GET['Vehicle'];

		$this->render('admin',array(
			//'model'=>$model,
			'vehicle'=>$vehicle,
			'vehicleDataProvider'=>$vehicleDataProvider
		));
	}

	/**
	 * Vehicles with inspections.
	 */
	public function actionInspection($vehicleId, $wonumber)
	{
		$vehicleInspection = new VehicleInspection('search');
		$vehicleInspection->unsetAttributes();  // clear any default values
		if(isset($_GET['vehicleInspection']))
			$vehicleInspection->attributes=$_GET['VehicleInspection'];

		$vehicleInspectionCriteria = new CDbCriteria;
		$vehicleInspectionCriteria->condition = 'work_order_number = ' . $wonumber;

		$vehicleInspectionDataProvider = new CActiveDataProvider('VehicleInspection', array(
    		'criteria'=>$vehicleInspectionCriteria,
  		));

  		$vehicle = Vehicle::model()->findByPk($vehicleId);

		//$model= Vehicle::model()->findAll($criteria);
		//$model->unsetAttributes();  // clear any default values
		//if(isset($_GET['Vehicle']))
			//$model->attributes=$_GET['Vehicle'];

		$this->render('inspection',array(
			'vehicle'=>$vehicle,
			'vehicleInspection'=>$vehicleInspection,
			'vehicleInspectionDataProvider'=>$vehicleInspectionDataProvider
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return VehicleInspection the loaded model
	 * @throws CHttpException
	 */

	//Add Checklist Module Detail
	public function actionAjaxHtmlAddVehicleInspectionDetail($id,$inspectionId)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$vehicleInspection = $this->instantiate($id); 	
			//$this->loadState($vehicleInspection);

			$vehicleInspection->addVehicleInspectionDetail($inspectionId);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
     		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
      		$this->renderPartial('_detailVehicleInspectionDetail', array('vehicleInspection'=>$vehicleInspection), false, true);
		}
	}

	//Delete Checklist Module Detail
	public function actionAjaxHtmlRemoveSectionDetail($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$inspection = $this->instantiate($id);
			$this->loadState($inspection);
			//print_r(CJSON::encode($salesOrder->details));
			$inspection->removeDetailAt($index);
			Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
      		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
			$this->renderPartial('_detailSection', array('inspection'=>$inspection), false, true);
		}
	}

	public function instantiate($id)
	{
		if (empty($id)){
			$vehicleInspection = new VehicleInspections(new VehicleInspection(), array());
			//print_r("test");
		}
		else
		{
			$vehicleInspectionModel = $this->loadModel($id);
			$vehicleInspection = new VehicleInspections($vehicleInspectionModel, $vehicleInspectionModel->vehicleInspectionDetails);
		}
		return $vehicleInspection;
	}

	public function loadState($vehicleInspection)
	{
		if (isset($_POST['VehicleInspection']))
		{
			$vehicleInspection->header->attributes = $_POST['VehicleInspection'];
		}

		if (isset($_POST['VehicleInspectionDetail']))
		{
			foreach ($_POST['VehicleInspectionDetail'] as $i => $item)
			{
				if (isset($vehicleInspection->vehicleInspectionDetails[$i]))
					$vehicleInspection->vehicleInspectionDetails[$i]->attributes = $item;
				else
				{
					$detail = new VehicleInspectionDetail();
					$detail->attributes = $item;
					$vehicleInspection->vehicleInspectionDetails[] = $detail;
					//echo "test";
				}
			}
			if (count($_POST['VehicleInspectionDetail']) < count($vehicleInspection->vehicleInspectionDetails))
				array_splice($vehicleInspection->vehicleInspectionDetails, $i + 1);
		}
		else
			$vehicleInspection->vehicleInspectionDetails = array();
	}

	public function loadModel($id)
	{
		$model=VehicleInspection::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param VehicleInspection $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicle-inspection-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
