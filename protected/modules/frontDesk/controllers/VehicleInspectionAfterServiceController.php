<?php

class VehicleInspectionAfterServiceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    /* public function filters()
      {
      return array(
      'accessControl', // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
      );
      } */

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'inspection', 'ajaxHtmlAddVehicleInspectionDetail'),
                'users' => array('Admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'vehicleInspection' => $this->instantiate($id),
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $vehicleInspection = $this->instantiate(null);
        $vehicleInspection->header->inspection_date = date('Y-m-d');

        $vehicleInspectionDetail = new VehicleInspectionDetail('search');
        $vehicleInspectionDetail->unsetAttributes();  // clear any default values
        
        if (isset($_GET['VehicleInspectionDetail']))
            $vehicleInspection->attributes = $_GET['VehicleInspectionDetail'];

        $vehicleInspectionDetailCriteria = new CDbCriteria;
        $vehicleInspectionDetailDataProvider = new CActiveDataProvider('VehicleInspectionDetail', array(
            'criteria' => $vehicleInspectionDetailCriteria,
        ));

        $this->performAjaxValidation($vehicleInspection->header);

        if (isset($_POST['VehicleInspection'])) {
            $this->loadState($vehicleInspection);
            
            if ($vehicleInspection->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $vehicleInspection->header->id));
            }
        }

        $this->render('create', array(
            'vehicleInspection' => $vehicleInspection,
            'vehicleInspectionDetail' => $vehicleInspectionDetail,
            'vehicleInspectionDetailDataProvider' => $vehicleInspectionDetailDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $vehicleInspection = $this->instantiate($id);
        $this->performAjaxValidation($vehicleInspection->header);

        if (isset($_POST['VehicleInspection'])) {
            $this->loadState($vehicleInspection);
            
            if ($vehicleInspection->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $vehicleInspection->header->id));
            } 
        }

        $this->render('update', array(
            'vehicleInspection' => $vehicleInspection,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('VehicleInspection');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $plate_number = '';
        $vehicle = new RegistrationTransaction('search');
        $vehicle->unsetAttributes();  // clear any default values
        
        if (isset($_GET['RegistrationTransaction'])) {
            $vehicle->attributes = $_GET['RegistrationTransaction'];
        }
        $vehicleCriteria = new CDbCriteria;
        $vehicleCriteria->condition = 't.work_order_number IS NOT NULL';
        $vehicleCriteria->together = 'true';
        $vehicleCriteria->with = array('vehicle');
        $vehicleCriteria->addSearchCondition('vehicle.plate_number', $plate_number, true);
        $vehicleCriteria->order = 'transaction_date DESC';

        $vehicleDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $vehicleCriteria,
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

        $this->render('admin', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider
        ));
    }

    /**
     * Vehicles with inspections.
     */
    public function actionInspection($id) {
        $vehicleInspection = $this->instantiate($id);
        $this->performAjaxValidation($vehicleInspection->header);

        if (isset($_GET['vehicleInspection']))
            $vehicleInspection->attributes = $_GET['VehicleInspection'];

        $vehicleInspectionDetail = new VehicleInspectionDetail('search');
        $vehicleInspectionDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['VehicleInspectionDetail']))
            $vehicleInspection->attributes = $_GET['VehicleInspectionDetail'];

        $vehicleInspectionDetailCriteria = new CDbCriteria;
        $vehicleInspectionDetailDataProvider = new CActiveDataProvider('VehicleInspectionDetail', array(
            'criteria' => $vehicleInspectionDetailCriteria,
        ));

        if ($vehicleInspection->save(Yii::app()->db)) {
            $this->redirect(array('view', 'id' => $vehicleInspection->header->id));
        } 
        
        $this->render('inspection', array(
            'vehicleInspection' => $vehicleInspection,
            'vehicleInspectionDetail' => $vehicleInspectionDetail,
            'vehicleInspectionDetailDataProvider' => $vehicleInspectionDetailDataProvider,
        ));
    }

    public function instantiate($id) {
        if (empty($id)) {
            $vehicleInspection = new VehicleInspectionAfterService(new VehicleInspection(), array());
        } else {
            $vehicleInspectionModel = $this->loadModel($id);
            $vehicleInspection = new VehicleInspectionAfterService($vehicleInspectionModel, $vehicleInspectionModel->vehicleInspectionDetails);
        }
        return $vehicleInspection;
    }

    public function loadState($vehicleInspection) {
        if (isset($_POST['VehicleInspection'])) {
            $vehicleInspection->header->attributes = $_POST['VehicleInspection'];
        }

        if (isset($_POST['VehicleInspectionDetail'])) {
            foreach ($_POST['VehicleInspectionDetail'] as $i => $item) {
                if (isset($vehicleInspection->vehicleInspectionDetails[$i]))
                    $vehicleInspection->vehicleInspectionDetails[$i]->attributes = $item;
                else {
                    $detail = new VehicleInspectionDetail();
                    $detail->attributes = $item;
                    $vehicleInspection->vehicleInspectionDetails[] = $detail;
                }
            }
            if (count($_POST['VehicleInspectionDetail']) < count($vehicleInspection->vehicleInspectionDetails))
                array_splice($vehicleInspection->vehicleInspectionDetails, $i + 1);
        } else
            $vehicleInspection->vehicleInspectionDetails = array();
    }

    public function loadModel($id) {
        $model = VehicleInspection::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param VehicleInspection $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vehicle-inspection-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
