<?php

class VehicleController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterVehicleCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterVehicleEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'inspection'
        ) {
            if (!(Yii::app()->user->checkAccess('masterVehicleCreate')) || !(Yii::app()->user->checkAccess('masterVehicleEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->layout = '//layouts/column1';
        $model = $this->loadModel($id);
        
        $customers = "";
        $picDetails = "";
        
        if ($model->customer_id != "") {
            $customers = Customer::model()->findAllByPK($model->customer_id);
        } else {
            $customers = "";
        }
        
        if ($model->customer_pic_id != "") {
            $picDetails = CustomerPic::model()->findAllByPK($model->customer_pic_id);
        } else {
            $picDetails = "";
        }
        
//        $registrationTransactions = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id' => $id));

        $registrationTransaction = new RegistrationTransaction('search');
        $registrationTransaction->unsetAttributes();
        
        if (isset($_GET['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_GET['RegistrationTransaction'];
        }

        $registrationTransactionCriteria = new CDbCriteria;
        $registrationTransactionCriteria->compare('id', $registrationTransaction->id);
        $registrationTransactionCriteria->compare('transaction_number', $registrationTransaction->transaction_number, true);
        $registrationTransactionCriteria->compare('transaction_date', $registrationTransaction->transaction_date, true);
        $registrationTransactionCriteria->compare('t.customer_id', $registrationTransaction->customer_id);
        $registrationTransactionCriteria->compare('vehicle_id', $id);
        $registrationTransactionCriteria->compare('branch_id', $registrationTransaction->branch_id);
        $registrationTransactionCriteria->compare('user_id', $registrationTransaction->user_id);
        $registrationTransactionCriteria->compare('grand_total', $registrationTransaction->grand_total, true);
        $registrationTransactionCriteria->compare('t.work_order_number', $registrationTransaction->work_order_number, true);
        $registrationTransactionCriteria->compare('sales_order_number', $registrationTransaction->sales_order_number, true);
        $registrationTransactionCriteria->compare('customer_work_order_number', $registrationTransaction->customer_work_order_number, true);

        $registrationTransactionCriteria->together = true;
        $registrationTransactionCriteria->with = array('customer', 'vehicle', 'branch');
        $registrationTransactionCriteria->compare('customer.name', $registrationTransaction->customer_name, true);
        $registrationTransactionDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $registrationTransactionCriteria,
            'sort' => array(
                'defaultOrder' => 't.transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 30,
            )
        ));
        
        $this->render('view', array(
            'model' => $model,
            'customers' => $customers,
            'picDetails' => $picDetails,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Vehicle;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        if (isset($_POST['Vehicle'])) {
            $model->attributes = $_POST['Vehicle'];

            //Search for Vehicle Sub Model Detail
            $subModelDetail = VehicleCarSubModelDetail::model()->findByAttributes(array('car_sub_model_id' => $_POST['Vehicle']['car_sub_model_id'], 'transmission' => $_POST['Vehicle']['transmission'], 'fuel_type' => $_POST['Vehicle']['fuel_type'], 'power' => $_POST['Vehicle']['power']))->id;
            $model->car_sub_model_detail_id = $subModelDetail;
            $model->plate_number = $model->getPlateNumberCombination();

            if ($model->save()) {
                $this->saveMasterLog($model);
        
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        if (isset($_POST['Vehicle'])) {
            $model->attributes = $_POST['Vehicle'];
            $model->plate_number = $model->getPlateNumberCombination();
            
            if ($model->save()) {
                $vehicleLog = new VehicleLog();
                $vehicleLog->vehicle_id = $model->id;
                $vehicleLog->plate_number = $model->plate_number;
                $vehicleLog->car_make_id = $model->car_make_id;
                $vehicleLog->car_model_id = $model->car_model_id;
                $vehicleLog->car_sub_model_id = $model->car_sub_model_id;
                $vehicleLog->customer_id = $model->customer_id;
                $vehicleLog->date_updated = date('Y-m-d');
                $vehicleLog->time_updated = date('H:i:s');
                $vehicleLog->user_updated_id =  Yii::app()->user->id;
                $vehicleLog->save();
                
                $this->saveMasterLog($model);
        
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function saveMasterLog($model) {
        $masterLog = new MasterLog();
        $masterLog->name = $model->plate_number;
        $masterLog->log_date = date('Y-m-d');
        $masterLog->log_time = date('H:i:s');
        $masterLog->table_name = $model->tableName();
        $masterLog->table_id = $model->id;
        $masterLog->user_id = Yii::app()->user->id;
        $masterLog->username = Yii::app()->user->username;
        $masterLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $masterLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $model->attributes;
        $masterLog->new_data = json_encode($newData);

        $masterLog->save();
    }

    public function actionUpdateLocation($id) {
        $model = $this->loadModel($id);
        $oldVehiclePositionTimer = VehiclePositionTimer::model()->find(array(
            'order' => ' id DESC',
            'condition' => "t.vehicle_id = :vehicle_id",
            'params' => array(':vehicle_id' => $id)
        ));
        
        if ($oldVehiclePositionTimer === null) {
            $statusLocation = 'Masuk Lokasi';
        } else {
            if ($oldVehiclePositionTimer->entry_date !== null && $oldVehiclePositionTimer->entry_time !== null &&
                    $oldVehiclePositionTimer->process_date == null && $oldVehiclePositionTimer->process_time == null &&
                    $oldVehiclePositionTimer->exit_date == null && $oldVehiclePositionTimer->exit_time == null) {
                $statusLocation = 'On-Progress';
            } else if ($oldVehiclePositionTimer->entry_date !== null && $oldVehiclePositionTimer->entry_time !== null &&
                    $oldVehiclePositionTimer->process_date !== null && $oldVehiclePositionTimer->process_time !== null &&
                    $oldVehiclePositionTimer->exit_date == null && $oldVehiclePositionTimer->exit_time == null) {
                $statusLocation = 'Keluar Lokasi';
            } else if ($oldVehiclePositionTimer->entry_date !== null && $oldVehiclePositionTimer->entry_time !== null &&
                    $oldVehiclePositionTimer->process_date !== null && $oldVehiclePositionTimer->process_time !== null &&
                    $oldVehiclePositionTimer->exit_date !== null && $oldVehiclePositionTimer->exit_time !== null) {
                $statusLocation = 'Masuk Lokasi';
            }
        }
        
        $statusErrorMessage = '';

        if (isset($_POST['Vehicle'])) {
            $model->attributes = $_POST['Vehicle'];
            
            if ($model->status_location !== $statusLocation) {
                $statusErrorMessage = 'Lokasi yang anda pilih salah.';
            } else {
                if ($model->status_location == 'Masuk Lokasi') {
                    $model->entry_user_id = Yii::app()->user->id;
                    $model->entry_datetime = date('Y-m-d H:i:s');
                } elseif ($model->status_location == 'On-Progress') {
                    $model->start_service_user_id = Yii::app()->user->id;
                    $model->start_service_datetime = date('Y-m-d H:i:s');
                } elseif ($model->status_location == 'Keluar Lokasi') {
                    $model->exit_user_id = Yii::app()->user->id;
                    $model->exit_datetime = date('Y-m-d H:i:s');
                } else {
                    $model->entry_user_id = null;
                    $model->start_service_user_id = null;
                    $model->finish_service_user_id = null;
                    $model->exit_user_id = null;
                    $model->entry_datetime = null;
                    $model->start_service_datetime = null;
                    $model->finish_service_datetime = null;
                    $model->exit_datetime = null;
                }
                
                if ($model->status_location == 'Masuk Lokasi') {
                    $vehiclePositionTimer = new VehiclePositionTimer();
                    $vehiclePositionTimer->entry_date = date('Y-m-d');
                    $vehiclePositionTimer->entry_time = date('H:i:s');
                } elseif ($model->status_location == 'On-Progress') {
                    $vehiclePositionTimer = $oldVehiclePositionTimer;
                    $vehiclePositionTimer->process_date = date('Y-m-d');
                    $vehiclePositionTimer->process_time = date('H:i:s');
                } elseif ($model->status_location == 'Keluar Lokasi') {
                    $vehiclePositionTimer = $oldVehiclePositionTimer;
                    $vehiclePositionTimer->exit_date = date('Y-m-d');
                    $vehiclePositionTimer->exit_time = date('H:i:s');
                }
                $vehiclePositionTimer->vehicle_id = $id;

                if ($model->save()) {
                    if ($vehiclePositionTimer->save()) {
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            }
        }

        $this->render('updateLocation', array(
            'model' => $model,
            'statusErrorMessage' => $statusErrorMessage,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionInspection($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $vehicle = $this->instantiate(null);

        $inspection = new Inspection('search');
        $inspection->unsetAttributes();  // clear any default values
        if (isset($_GET['Inspection']))
            $inspection->attributes = $_GET['Inspection'];

        $inspectionCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $inspectionCriteria->compare('name', $inspection->name, true);

        $inspectionDataProvider = new CActiveDataProvider('Inspection', array(
            'criteria' => $inspectionCriteria,
        ));

        $vehicle = $this->instantiate($id);
        $this->performAjaxValidation($vehicle->header);

        if (isset($_POST['Vehicle'])) {
            /* $model->attributes=$_POST['InspectionSection'];
              if($model->save())
              $this->redirect(array('view','id'=>$model->id)); */

            $this->loadState($vehicle);
            if ($vehicle->save())
                $this->redirect(array('view', 'id' => $vehicle->header->id));
        }

        $this->render('inspection', array(
            //'model'=>$model,
            'vehicle' => $vehicle,
            'inspection' => $inspection,
            'inspectionDataProvider' => $inspectionDataProvider,
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
        $dataProvider = new CActiveDataProvider('Vehicle');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
//		$model=new Vehicle('search');
//		$model->unsetAttributes();  // clear any default values

        $model = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $dataProvider = $model->search();
        $dataProvider->criteria->with = array(
            'customer',
        );

        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '';
        
        if (!empty($customerId)) {
            $dataProvider->criteria->addCondition('t.customer_id LIKE :customer_id');
            $dataProvider->criteria->params[':customer_id'] = "%{$customerId}%";
        }

        if (!empty($customerName)) {
            $dataProvider->criteria->addCondition('customer.name LIKE :customer_name');
            $dataProvider->criteria->params[':customer_name'] = "%{$customerName}%";
        }

        if (!empty($customerType)) {
            $dataProvider->criteria->addCondition('customer.customer_type = :customer_type');
            $dataProvider->criteria->params[':customer_type'] = $customerType;
        }

        if (isset($_GET['Vehicle']))
            $model->attributes = $_GET['Vehicle'];

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'customerId' => $customerId,
            'customerName' => $customerName,
            'customerType' => $customerType,
        ));
    }

    public function actionAjaxGetCustomerPic() {
        $data = CustomerPic::model()->findAllByAttributes(array('customer_id' => $_POST['Vehicle']['customer_id']), array('order' => 'name ASC'));
        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Customer Pic--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Customer Pic--]', true);
        }
    }

    public function actionAjaxCustomer($id) {

        if (Yii::app()->request->isAjaxRequest) {
            // $invoice = $this->instantiate($id);
            // $this->loadState($invoice);

            $customer = Customer::model()->findByPk($id);

            $object = array(
                'name' => $customer->name,
            );

            echo CJSON::encode($object);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Vehicle the loaded model
     * @throws CHttpException
     */
    // Get Car Make
    public function actionAjaxGetCarMake() {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarModels', 'vehicleCarModels.vehicleCarSubModels', 'vehicleCarModels.vehicleCarSubModels.vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->condition = '"' . $_POST['Vehicle']['year'] . '" BETWEEN vehicleCarSubModelDetails.assembly_year_start and vehicleCarSubModelDetails.assembly_year_end';
        $data = VehicleCarMake::model()->findAll($criteria);

        //$data = VehicleCarMake::model()->findAllByAttributes(array('car_make_id'=>$_POST['Vehicle']['car_make_id']));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Make--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Make--]', true);
        }
    }

    // Get Car Model
    public function actionAjaxGetModel() {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarSubModels', 'vehicleCarSubModels.vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->condition = '"' . $_POST['Vehicle']['year'] . '" BETWEEN vehicleCarSubModelDetails.assembly_year_start and vehicleCarSubModelDetails.assembly_year_end';
        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $_POST['Vehicle']['car_make_id']), $criteria);

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Model--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Model--]', true);
        }
    }

    // Get Car Sub Model
    public function actionAjaxGetSubModel() {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->condition = '"' . $_POST['Vehicle']['year'] . '" BETWEEN vehicleCarSubModelDetails.assembly_year_start and vehicleCarSubModelDetails.assembly_year_end';
        $criteria->order = 't.name ASC';

        $data = VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id' => $_POST['Vehicle']['car_make_id'], 'car_model_id' => $_POST['Vehicle']['car_model_id']), $criteria);

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Sub Model--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Sub Model--]', true);
        }
    }

    //get other details => powercc,chasiscode,transmission,fueltype
    /* public function actionAjaxGetSubModelDetails()
      {
      //$subModels = VehicleCarSubModelDetail::model()->findAllByAttributes(array('car_sub_model_id'=>$_POST['Vehicle']['car_sub_model_id']));
      $criteria = new CDbCriteria;
      $criteria->condition = '"' . $_POST['Vehicle']['year'] . '" BETWEEN assembly_year_start and assembly_year_end';
      $criteria->order = 't.name ASC';
      $data = VehicleCarSubModelDetail::model()->findAllByAttributes(array('car_sub_model_id'=>$_POST['Vehicle']['car_sub_model_id']),$criteria);
      if(count($data) > 0)
      {
      $data=CHtml::listData($data,'id','subModelDetail');
      echo CHtml::tag('option',array('value'=>''),'[--Select Car Sub Model Detail--]',true);
      foreach($data as $value=>$name)
      {
      echo CHtml::tag('option', array('value'=>$value), CHtml::encode($name), true);
      }
      }
      else
      {
      echo CHtml::tag('option',array('value'=>''),'[--Select Car Sub Model Detail--]',true);
      }
      } */

    public function actionAjaxGetSubModelDetails() {
        $transmissionCriteria = new CDbCriteria;
        $transmissionCriteria->select = 'transmission';
        $transmissionCriteria->distinct = true;
        $transmissionCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'];

        $powerCriteria = new CDbCriteria;
        $powerCriteria->select = 'power';
        $powerCriteria->distinct = true;
        $powerCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'];

        $fuelTypeCriteria = new CDbCriteria;
        $fuelTypeCriteria->select = 'fuel_type';
        $fuelTypeCriteria->distinct = true;
        $fuelTypeCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'];

        $chasisCriteria = new CDbCriteria;
        $chasisCriteria->select = 'chasis_code';
        $chasisCriteria->distinct = true;
        $chasisCriteria->condition = '"' . $_POST['Vehicle']['year'] . '" BETWEEN assembly_year_start and assembly_year_end' . ' AND car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'];

        $modelDetailCriteria = new CDbCriteria;
        $modelDetailCriteria->select = 'name';
        $modelDetailCriteria->distinct = true;
        $modelDetailCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'];

        $transmissions = VehicleCarSubModelDetail::model()->findAll($transmissionCriteria);
        $powers = VehicleCarSubModelDetail::model()->findAll($powerCriteria);
        $fuel_types = VehicleCarSubModelDetail::model()->findAll($fuelTypeCriteria);
        $chasis = VehicleCarSubModelDetail::model()->find($chasisCriteria);
        $subModelDetails = VehicleCarSubModelDetail::model()->findAll($modelDetailCriteria);


        $power = CHtml::tag('option', array('value' => ''), '[--Select Power--]', true);
        $transmission = CHtml::tag('option', array('value' => ''), '[--Select Transmission--]', true);
        $fuel_type = CHtml::tag('option', array('value' => ''), '[--Select Fuel Type--]', true);
        $subModelDetail = CHtml::tag('option', array('value' => ''), '[--Select Sub Model Detail--]', true);

        $object = array();

        if ($subModelDetails != NULL) {
            foreach ($subModelDetails as $s) {
                $subModelDetail .= CHtml::tag('option', array('value' => $s->name), CHtml::encode($s->name), true);
            }
            $object['model_detail'] = $subModelDetail;
        }

        if ($transmissions != NULL) {
            foreach ($transmissions as $t) {
                $transmission .= CHtml::tag('option', array('value' => $t->transmission), CHtml::encode($t->transmission), true);
            }
            $object['transmission'] = $transmission;
        }

        if ($powers != NULL) {
            foreach ($powers as $p) {
                $power .= CHtml::tag('option', array('value' => $p->power), CHtml::encode($p->power), true);
            }
            $object['power'] = $power;
        }

        if ($fuel_types != NULL) {
            foreach ($fuel_types as $f) {
                $fuel_type .= CHtml::tag('option', array('value' => $f->fuel_type), CHtml::encode($f->fuel_type), true);
            }
            $object['fuel_type'] = $fuel_type;
        }

        if ($chasis != NULL) {
            $object['chasis_code'] = $chasis->chasis_code;
        }

        echo CJSON::encode($object);
    }

    public function actionAjaxGetFuelPower() {
        if ($_POST['Vehicle']['transmission'] != NULL) {

            $powerCriteria = new CDbCriteria;
            $powerCriteria->select = 'power';
            $powerCriteria->distinct = true;
            $powerCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'] . ' AND transmission = "' . $_POST['Vehicle']['transmission'] . '"';

            $fuelTypeCriteria = new CDbCriteria;
            $fuelTypeCriteria->select = 'fuel_type';
            $fuelTypeCriteria->distinct = true;
            $fuelTypeCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'] . ' AND transmission = "' . $_POST['Vehicle']['transmission'] . '"';

            $powers = VehicleCarSubModelDetail::model()->findAll($powerCriteria);
            $fuel_types = VehicleCarSubModelDetail::model()->findAll($fuelTypeCriteria);

            $power = CHtml::tag('option', array('value' => ''), '[--Select Power--]', true);
            $fuel_type = CHtml::tag('option', array('value' => ''), '[--Select Fuel Type--]', true);

            $object = array();

            if ($powers != NULL) {
                foreach ($powers as $p) {
                    $power .= CHtml::tag('option', array('value' => $p->power), CHtml::encode($p->power), true);
                }
                $object['power'] = $power;
            }

            if ($fuel_types != NULL) {
                foreach ($fuel_types as $f) {
                    $fuel_type .= CHtml::tag('option', array('value' => $f->fuel_type), CHtml::encode($f->fuel_type), true);
                }
                $object['fuel_type'] = $fuel_type;
            }

            echo CJSON::encode($object);
        } else {
            $this->actionAjaxGetSubModelDetails();
        }
    }

    public function actionAjaxGetTransmissionPower() {
        if ($_POST['Vehicle']['fuel_type'] != NULL) {

            $transmissionCriteria = new CDbCriteria;
            $transmissionCriteria->select = 'transmission';
            $transmissionCriteria->distinct = true;
            $transmissionCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'] . ' AND fuel_type = "' . $_POST['Vehicle']['fuel_type'] . '"';

            $powerCriteria = new CDbCriteria;
            $powerCriteria->select = 'power';
            $powerCriteria->distinct = true;
            $powerCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'] . ' AND fuel_type = "' . $_POST['Vehicle']['fuel_type'] . '"';

            $transmissions = VehicleCarSubModelDetail::model()->findAll($transmissionCriteria);
            $powers = VehicleCarSubModelDetail::model()->findAll($powerCriteria);

            $power = CHtml::tag('option', array('value' => ''), '[--Select Power--]', true);
            $transmission = CHtml::tag('option', array('value' => ''), '[--Select Transmission--]', true);

            $object = array();

            if ($transmissions != NULL) {
                foreach ($transmissions as $t) {
                    $transmission .= CHtml::tag('option', array('value' => $t->transmission), CHtml::encode($t->transmission), true);
                }
                $object['transmission'] = $transmission;
            }

            if ($powers != NULL) {
                foreach ($powers as $p) {
                    $power .= CHtml::tag('option', array('value' => $p->power), CHtml::encode($p->power), true);
                }
                $object['power'] = $power;
            }

            echo CJSON::encode($object);
        } else {
            $this->actionAjaxGetSubModelDetails();
        }
    }

    public function actionAjaxGetTransmissionFuel() {
        if ($_POST['Vehicle']['power'] != NULL) {

            $transmissionCriteria = new CDbCriteria;
            $transmissionCriteria->select = 'transmission';
            $transmissionCriteria->distinct = true;
            $transmissionCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'] . ' AND power = "' . $_POST['Vehicle']['power'] . '"';

            $fuelTypeCriteria = new CDbCriteria;
            $fuelTypeCriteria->select = 'fuel_type';
            $fuelTypeCriteria->distinct = true;
            $fuelTypeCriteria->condition = 'car_sub_model_id = ' . $_POST['Vehicle']['car_sub_model_id'] . ' AND power = "' . $_POST['Vehicle']['power'] . '"';

            $transmissions = VehicleCarSubModelDetail::model()->findAll($transmissionCriteria);
            $fuel_types = VehicleCarSubModelDetail::model()->findAll($fuelTypeCriteria);

            $transmission = CHtml::tag('option', array('value' => ''), '[--Select Transmission--]', true);
            $fuel_type = CHtml::tag('option', array('value' => ''), '[--Select Fuel Type--]', true);

            $object = array();

            if ($transmissions != NULL) {
                foreach ($transmissions as $t) {
                    $transmission .= CHtml::tag('option', array('value' => $t->transmission), CHtml::encode($t->transmission), true);
                }
                $object['transmission'] = $transmission;
            }

            if ($fuel_types != NULL) {
                foreach ($fuel_types as $f) {
                    $fuel_type .= CHtml::tag('option', array('value' => $f->fuel_type), CHtml::encode($f->fuel_type), true);
                }
                $object['fuel_type'] = $fuel_type;
            }

            echo CJSON::encode($object);
        } else {
            $this->actionAjaxGetSubModelDetails();
        }
    }

    public function actionAjaxGetChasisCode() {
        $data = VehicleCarSubModelDetail::model()->findByPk($_POST['Vehicle']['car_sub_model_detail_id']);
        if ($data != NULL) {
            $object = array('chasis_code' => $data->chasis_code);
        } else {
            $object = array();
        }
        echo CJSON::encode($object);
    }

    public function instantiate($id) {
        if (empty($id)) {
            $vehicle = new Vehicles(new Vehicle(), array());
            //print_r("test");
        } else {
            $vehicleModel = $this->loadModel($id);
            $vehicle = new Inspections($vehicleModel, $vehicleModel->vehicleInspections);
        }
        return $vehicle;
    }

    public function loadState($vehicle) {
        if (isset($_POST['Vehicle'])) {
            $vehicle->header->attributes = $_POST['Vehicle'];
        }

        if (isset($_POST['VehicleInspections'])) {
            foreach ($_POST['VehicleInspections'] as $i => $item) {
                if (isset($vehicle->inspectionDetails[$i]))
                    $vehicle->inspectionDetails[$i]->attributes = $item;
                else {
                    $detail = new VehicleInspections();
                    $detail->attributes = $item;
                    $vehicle->inspectionDetails[] = $detail;
                    //echo "test";
                }
            }
            if (count($_POST['VehicleInspections']) < count($vehicle->inspectionDetails))
                array_splice($vehicle->inspectionDetails, $i + 1);
        } else
            $vehicle->inspectionDetails = array();
    }

    public function loadModel($id) {
        $model = Vehicle::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Vehicle $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vehicle-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionLog($vehicleId) {
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $vehicleLog = VehicleLog::model()->findAllByAttributes(array('vehicle_id' => $vehicleId), array('order' => 't.date_updated DESC'));
        
        $this->render('log', array(
            'vehicle' => $vehicle,
            'vehicleLog' => $vehicleLog,
        ));
    }
}
