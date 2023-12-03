<?php

class CustomerController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('masterCustomerCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCustomerEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'addVehicle' || 
            $filterChain->action->id === 'updatePic' || 
            $filterChain->action->id === 'updatePrice' || 
            $filterChain->action->id === 'updateVehicle'
        ) {
            if (!(Yii::app()->user->checkAccess('masterCustomerCreate')) || !(Yii::app()->user->checkAccess('masterCustomerEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $picDetails = CustomerPic::model()->findAllByAttributes(array('customer_id' => $id));
        $vehicleDetails = Vehicle::model()->findAllByAttributes(array('customer_id' => $id), array('limit' => 100, 'order' => 'id DESC'));
        $rateDetails = CustomerServiceRate::model()->findAllByAttributes(array('customer_id' => $id));
        $registrationTransactions = RegistrationTransaction::model()->findAllByAttributes(array('customer_id' => $id));
        
        if (isset($_POST['Approve']) && (int) $model->is_approved !== 1) {
            $model->is_approved = 1;
            $model->date_approval = date('Y-m-d');
            
            if ($model->save(true, array('is_approved', 'date_approval')))
                Yii::app()->user->setFlash('confirm', 'Your data has been approved!!!');
        } elseif (isset($_POST['Reject'])) {
            $model->is_approved = 2;
            
            if ($model->save(true, array('is_approved')))
                Yii::app()->user->setFlash('confirm', 'Your data has been rejected!!!');
        }

        $this->render('view', array(
            'model' => $model,
            'picDetails' => $picDetails,
            'vehicleDetails' => $vehicleDetails,
            'rateDetails' => $rateDetails,
            'registrationTransactions' => $registrationTransactions,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id = 8");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);


        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));
        
        $customer = $this->instantiate(null);
        $customer->header->user_id = Yii::app()->user->id;
        $customer->header->date_created = date('Y-m-d H:i:s');
        
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $service->attributes = $_GET['Service'];

        $serviceCriteria = new CDbCriteria;
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);

        $serviceCriteria->compare('serviceCategory.name', $service->service_category_name == NULL ? $service->service_category_name : $service->service_category_name, true);
        $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);
        $explodeKeyword = explode(" ", $service->findkeyword);

        foreach ($explodeKeyword as $key) {
            $serviceCriteria->compare('t.code', $key, true, 'OR');
            $serviceCriteria->compare('t.name', $key, true, 'OR');
            $serviceCriteria->compare('description', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        if (isset($_POST['Submit'])) {
            $this->loadState($customer);

            if ($customer->save(Yii::app()->db)) {
                $this->redirect(array('addVehicle', 'id' => $customer->header->id));
            }
        }

        $this->render('create', array(
            'customer' => $customer,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
        ));
    }

    public function actionAddVehicle($id) {

        $model = new Vehicle;
        $model->customer_id = $id;

        $customer = Customer::model()->findByPk($id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $id));

        if (isset($_POST['Submit'])) {
            $model->attributes = $_POST['Vehicle'];
            $model->plate_number = $model->getPlateNumberCombination();

            if ($model->save())
                $this->redirect(array('view', 'id' => $id));
        }

        if (isset($_POST['Add'])) {
            $model->attributes = $_POST['Vehicle'];
            $model->plate_number = $model->getPlateNumberCombination();

            if ($model->save())
                $this->redirect(array('addVehicle', 'id' => $id));
        }

        $this->render('addVehicle', array(
            'model' => $model,
            'customer' => $customer,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {

        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id = 8");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);


        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));
        $customer = $this->instantiate($id);
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $service->attributes = $_GET['Service'];

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);

        $serviceCriteria->compare('serviceCategory.name', $service->service_category_name == NULL ? $service->service_category_name : $service->service_category_name, true);
        $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);
        $explodeKeyword = explode(" ", $service->findkeyword);
        foreach ($explodeKeyword as $key) {
            $serviceCriteria->compare('t.code', $key, true, 'OR');
            $serviceCriteria->compare('t.name', $key, true, 'OR');
            $serviceCriteria->compare('description', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        $this->performAjaxValidation($customer->header);

        if (isset($_POST['Customer'])) {
            $this->loadState($customer);
            if ($customer->save(Yii::app()->db)) {
                $customerLog = new CustomerLog();
                $customerLog->name = $customer->header->name;
                $customerLog->customer_type = $customer->header->customer_type;
                $customerLog->coa_id = $customer->header->coa_id;
                $customerLog->customer_id = $customer->header->id;
                $customerLog->date_updated = date('Y-m-d');
                $customerLog->time_updated = date('H:i:s');
                $customerLog->user_updated_id =  Yii::app()->user->id;
                $customerLog->save();
                
                $this->redirect(array('view', 'id' => $customer->header->id));
            } else {
                foreach ($customer->phoneDetails as $key => $detail) {
                }
            }
        }
        $this->render('update', array(
            'customer' => $customer,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
        ));
    }

    public function actionUpdatePic($custId, $picId) {
        // $customer = $this->instantiate($custId);
        // $this->performAjaxValidation($customer->header);
        // if(isset($_POST['CustomerPic']))
        // {
        // 	$this->loadState($customer);
        // 	if ($customer->save(Yii::app()->db)){
        // 		$this->redirect(array('view', 'id' => $customer->header->id));
        // 	} else {
        // 		foreach ($customer->phoneDetails as $key => $detail) {
        // 			//print_r(CJSON::encode($detail->jenis_persediaan_id));
        // 		}
        // 	}
        // }

        $customer = $this->instantiate($custId);

        // $this->performAjaxValidation($customer->header);
        $model = CustomerPic::model()->findByPk($picId);
        if (isset($_POST['CustomerPic'])) {
            $model->attributes = $_POST['CustomerPic'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $custId));
        }

        $this->render('update', array(
            'customer' => $customer,
            'model' => $model,
        ));
    }

    public function actionUpdateVehicle($custId, $vehicleId) {
        $customer = $this->instantiate($custId);

        // $this->performAjaxValidation($customer->header);
        $model = Vehicle::model()->findByPk($vehicleId);
        if (isset($_POST['Vehicle'])) {
            $model->attributes = $_POST['Vehicle'];
            $model->plate_number = $model->getPlateNumberCombination();
            
            if ($model->save())
                $this->redirect(array('view', 'id' => $custId));
        }

        $this->render('update', array(
            'customer' => $customer,
            'model' => $model,
        ));
    }

    public function actionUpdatePrice($custId, $priceId) {


        $customer = $this->instantiate($custId);

        // $this->performAjaxValidation($customer->header);
        $model = CustomerServiceRate::model()->findByPk($priceId);
        if (isset($_POST['CustomerServiceRate'])) {
            $model->attributes = $_POST['CustomerServiceRate'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $custId));
        }

        $this->render('update', array(
            'customer' => $customer,
            'model' => $model,
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
        $dataProvider = new CActiveDataProvider('Customer');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Customer('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer']))
            $model->attributes = $_GET['Customer'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add PhoneDetail
    public function actionAjaxHtmlAddPhoneDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = $this->instantiate($id);
            $this->loadState($customer);

            $customer->addDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPhone', array('customer' => $customer), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = $this->instantiate($id);
            $this->loadState($customer);
            //print_r(CJSON::encode($salesOrder->details));
            $customer->removeDetailAt($index);
            $this->renderPartial('_detailPhone', array('customer' => $customer), false, true);
        }
    }

    //Add Mobile Detail
    public function actionAjaxHtmlAddMobileDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = $this->instantiate($id);
            $this->loadState($customer);

            $customer->addMobileDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailMobile', array('customer' => $customer), false, true);
        }
    }

    //Delete Mobile Detail
    public function actionAjaxHtmlRemoveMobileDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = $this->instantiate($id);
            $this->loadState($customer);
            //print_r(CJSON::encode($salesOrder->details));
            $customer->removeMobileDetailAt($index);
            $this->renderPartial('_detailMobile', array('customer' => $customer), false, true);
        }
    }

    //Add Vehicle Detail
    public function actionAjaxHtmlAddVehicleDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = $this->instantiate($id);
            $this->loadState($customer);

            $customer->addVehicleDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailVehicle', array('customer' => $customer), false, true);
        }
    }

    //Delete Vehicle Detail
    public function actionAjaxHtmlRemoveVehicleDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = $this->instantiate($id);
            $this->loadState($customer);
            //print_r(CJSON::encode($salesOrder->details));
            $customer->removeVehicleDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailVehicle', array('customer' => $customer), false, true);
        }
    }

    public function actionAjaxHtmlAddPicDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = $this->instantiate($id);
            $this->loadState($customer);

            $customer->addPicDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPic', array('customer' => $customer), false, true);
        }
    }

    //Delete Pic Detail
    public function actionAjaxHtmlRemovePicDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = $this->instantiate($id);
            $this->loadState($customer);
            //print_r(CJSON::encode($salesOrder->details));
            $customer->removePicDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPic', array('customer' => $customer), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceDetail($id, $serviceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = $this->instantiate($id);
            $this->loadState($customer);

            $customer->addServiceDetail($serviceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('customer' => $customer), false, true);
        }
    }

    //Delete Pic Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $customer = $this->instantiate($id);
            $this->loadState($customer);

            //print_r(CJSON::encode($salesOrder->details));
            $customer->removeServiceDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('customer' => $customer,), false, true);
        }
    }

    // Get City
    public function actionAjaxGetCity() {


        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['Customer']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    public function actionAjaxGetCityPic() {


        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['CustomerPic']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHTML::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    public function actionAjaxGetCityPicIndex($index) {


        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['CustomerPic'][$index]['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHTML::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    // Get Car Make
    public function actionAjaxGetCarMake($year) {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarModels', 'vehicleCarModels.vehicleCarSubModels', 'vehicleCarModels.vehicleCarSubModels.vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->condition = '"' . $year . '" BETWEEN vehicleCarSubModelDetails.assembly_year_start and vehicleCarSubModelDetails.assembly_year_end';
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

    // Get Car Model for pricelist
    public function actionAjaxGetModelPrice($carmake) {


        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carmake));

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

    //Get Car Sub Model for pricelist
    public function actionAjaxGetSubModelPrice($carmake, $carmodel) {


        $data = VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id' => $carmake, 'car_model_id' => $carmodel));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car SubModel--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car SubModel--]', true);
        }
    }

    // Get Car Model
    public function actionAjaxGetModel($year, $carmake) {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarSubModels', 'vehicleCarSubModels.vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->condition = '"' . $year . '" BETWEEN vehicleCarSubModelDetails.assembly_year_start and vehicleCarSubModelDetails.assembly_year_end';
        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carmake), $criteria);

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
    public function actionAjaxGetSubModel($year, $carmake, $carmodel) {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->condition = '"' . $year . '" BETWEEN vehicleCarSubModelDetails.assembly_year_start and vehicleCarSubModelDetails.assembly_year_end';
        $criteria->order = 't.name ASC';

        $data = VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id' => $carmake, 'car_model_id' => $carmodel), $criteria);

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

    public function actionAjaxGetSubModelDetails($year, $carsubmodel) {
        $transmissionCriteria = new CDbCriteria;
        $transmissionCriteria->select = 'transmission';
        $transmissionCriteria->distinct = true;
        $transmissionCriteria->condition = 'car_sub_model_id = ' . $carsubmodel;

        $powerCriteria = new CDbCriteria;
        $powerCriteria->select = 'power';
        $powerCriteria->distinct = true;
        $powerCriteria->condition = 'car_sub_model_id = ' . $carsubmodel;

        $fuelTypeCriteria = new CDbCriteria;
        $fuelTypeCriteria->select = 'fuel_type';
        $fuelTypeCriteria->distinct = true;
        $fuelTypeCriteria->condition = 'car_sub_model_id = ' . $carsubmodel;

        $chasisCriteria = new CDbCriteria;
        $chasisCriteria->select = 'chasis_code';
        $chasisCriteria->distinct = true;
        $chasisCriteria->condition = '"' . $year . '" BETWEEN assembly_year_start and assembly_year_end' . ' AND car_sub_model_id = ' . $carsubmodel;

        $transmissions = VehicleCarSubModelDetail::model()->findAll($transmissionCriteria);
        $powers = VehicleCarSubModelDetail::model()->findAll($powerCriteria);
        $fuel_types = VehicleCarSubModelDetail::model()->findAll($fuelTypeCriteria);
        $chasis = VehicleCarSubModelDetail::model()->find($chasisCriteria);


        $power = CHtml::tag('option', array('value' => ''), '[--Select Power--]', true);
        $transmission = CHtml::tag('option', array('value' => ''), '[--Select Transmission--]', true);
        $fuel_type = CHtml::tag('option', array('value' => ''), '[--Select Fuel Type--]', true);

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

    public function actionAjaxGetFuelPower($carsubmodel, $transmission) {
        if ($transmission != NULL) {

            $powerCriteria = new CDbCriteria;
            $powerCriteria->select = 'power';
            $powerCriteria->distinct = true;
            $powerCriteria->condition = 'car_sub_model_id = ' . $carsubmodel . ' AND transmission = "' . $transmission . '"';

            $fuelTypeCriteria = new CDbCriteria;
            $fuelTypeCriteria->select = 'fuel_type';
            $fuelTypeCriteria->distinct = true;
            $fuelTypeCriteria->condition = 'car_sub_model_id = ' . $carsubmodel . ' AND transmission = "' . $transmission . '"';

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

    public function actionAjaxGetTransmissionPower($carsubmodel, $fueltype) {
        if ($fueltype != NULL) {

            $transmissionCriteria = new CDbCriteria;
            $transmissionCriteria->select = 'transmission';
            $transmissionCriteria->distinct = true;
            $transmissionCriteria->condition = 'car_sub_model_id = ' . $carsubmodel . ' AND fuel_type = "' . $fueltype . '"';

            $powerCriteria = new CDbCriteria;
            $powerCriteria->select = 'power';
            $powerCriteria->distinct = true;
            $powerCriteria->condition = 'car_sub_model_id = ' . $carsubmodel . ' AND fuel_type = "' . $fueltype . '"';

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

    public function actionAjaxGetTransmissionFuel($carsubmodel, $power) {
        if ($power != NULL) {

            $transmissionCriteria = new CDbCriteria;
            $transmissionCriteria->select = 'transmission';
            $transmissionCriteria->distinct = true;
            $transmissionCriteria->condition = 'car_sub_model_id = ' . $carsubmodel . ' AND power = "' . $power . '"';

            $fuelTypeCriteria = new CDbCriteria;
            $fuelTypeCriteria->select = 'fuel_type';
            $fuelTypeCriteria->distinct = true;
            $fuelTypeCriteria->condition = 'car_sub_model_id = ' . $carsubmodel . ' AND power = "' . $power . '"';

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

    public function actionAjaxGetChasisCode($carsubmodeldetail) {
        $data = VehicleCarSubModelDetail::model()->findByPk($carsubmodeldetail);
        if ($data != NULL) {
            $object = array('chasis_code' => $data->chasis_code);
        } else {
            $object = array();
        }
        echo CJSON::encode($object);
    }

    //get Service Category
    public function actionAjaxGetServiceCategory($serviceType) {


        $data = ServiceCategory::model()->findAllByAttributes(array('service_type_id' => $serviceType), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Service Category--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Service Category--]', true);
        }
    }

    // get service
    public function actionAjaxGetService($serviceType, $serviceCategory) {


        $data = Service::model()->findAllByAttributes(array('service_type_id' => $serviceType, 'service_category_id' => $serviceCategory), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Service--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Service--]', true);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $customer = new Customers(new Customer(), array(), array(), array(), array(), array());
            //print_r("test");
        } else {
            $customerModel = $this->loadModel($id);
            $customer = new Customers($customerModel, $customerModel->customerPhones, $customerModel->customerMobiles, $customerModel->customerPics, $customerModel->vehicles, $customerModel->customerServiceRates);
        }
        return $customer;
    }

    public function loadState($customer) {
        if (isset($_POST['Customer'])) {
            $customer->header->attributes = $_POST['Customer'];
        }

        if (isset($_POST['CustomerPhone'])) {
            foreach ($_POST['CustomerPhone'] as $i => $item) {
                if (isset($customer->phoneDetails[$i]))
                    $customer->phoneDetails[$i]->attributes = $item;
                else {
                    $detail = new CustomerPhone();
                    $detail->attributes = $item;
                    $customer->phoneDetails[] = $detail;
                }
            }
            if (count($_POST['CustomerPhone']) < count($customer->phoneDetails))
                array_splice($customer->phoneDetails, $i + 1);
        } else
            $customer->phoneDetails = array();


        if (isset($_POST['CustomerMobile'])) {
            foreach ($_POST['CustomerMobile'] as $i => $item) {
                if (isset($customer->mobileDetails[$i]))
                    $customer->mobileDetails[$i]->attributes = $item;
                else {
                    $detail = new CustomerMobile();
                    $detail->attributes = $item;
                    $customer->mobileDetails[] = $detail;
                }
            }
            if (count($_POST['CustomerMobile']) < count($customer->mobileDetails))
                array_splice($customer->mobileDetails, $i + 1);
        } else
            $customer->mobileDetails = array();


        if (isset($_POST['CustomerPic'])) {
            foreach ($_POST['CustomerPic'] as $i => $item) {
                if (isset($customer->picDetails[$i]))
                    $customer->picDetails[$i]->attributes = $item;
                else {
                    $detail = new CustomerPic();
                    $detail->attributes = $item;
                    $customer->picDetails[] = $detail;
                }
            }
            if (count($_POST['CustomerPic']) < count($customer->picDetails))
                array_splice($customer->picDetails, $i + 1);
        } else
            $customer->picDetails = array();

        if (isset($_POST['Vehicle'])) {
            foreach ($_POST['Vehicle'] as $i => $item) {
                if (isset($customer->vehicleDetails[$i]))
                    $customer->vehicleDetails[$i]->attributes = $item;
                else {
                    $detail = new Vehicle();
                    $detail->attributes = $item;
                    $customer->vehicleDetails[] = $detail;
                }
            }
            if (count($_POST['Vehicle']) < count($customer->vehicleDetails))
                array_splice($customer->vehicleDetails, $i + 1);
        } else
            $customer->vehicleDetails = array();

        if (isset($_POST['CustomerServiceRate'])) {
            foreach ($_POST['CustomerServiceRate'] as $i => $item) {
                if (isset($customer->serviceDetails[$i]))
                    $customer->serviceDetails[$i]->attributes = $item;
                else {
                    $detail = new CustomerServiceRate();
                    $detail->attributes = $item;
                    $customer->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['CustomerServiceRate']) < count($customer->serviceDetails))
                array_splice($customer->serviceDetails, $i + 1);
        } else
            $customer->serviceDetails = array();
    }

    // public function actionRegistration(){
    // 		$this->render('registration',array(
    // 		//'model'=>$model,
    // 		'customer'=>$customer,
    // 	));
    // }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Customer the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Customer::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Customer $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'customer-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxCoa($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $coa = Coa::model()->findByPk($id);

            $object = array(
                'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionExportExcel($id = NULL) {
        if ($id == NULL) {
            $dataCustomer = Customer::model()->findAll();
            $this->getXlsCustomer($dataCustomer);
        } else {
            $dataCustomer = Customer::model()->findByAttributes(array('id' => $id));
            $this->getXlsHistory($dataCustomer);
            // $dataCustomer = $this->loadModel($id);
        }
    }

    public function getXlsCustomer($customer) {

        // var_dump($customer); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("Customer Data " . date('d-m-Y'))
                ->setSubject("Customer")
                ->setDescription("Export Data Customer, generated using PHP classes.")
                ->setKeywords("Customer Data")
                ->setCategory("Export Customer");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        $styleBold = array(
            'font' => array(
                'bold' => true,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
        );

        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', 'DATA CUSTOMER')
                ->setCellValue('A2', 'Data Customer')
                ->setCellValue('E2', 'Data Kendaraan')
                ->setCellValue('H2', 'P/K')
                ->setCellValue('I2', 'Update By')
                ->setCellValue('L2', 'Historical')
                ->setCellValue('A3', 'Nama Customer')
                ->setCellValue('B3', 'Alamat')
                ->setCellValue('C3', 'No Phone')
                ->setCellValue('D3', 'Email')
                ->setCellValue('E3', 'No Polisi')
                ->setCellValue('F3', 'Merk Mobil')
                ->setCellValue('G3', 'Extensi')
                ->setCellValue('I3', 'User ID')
                ->setCellValue('J3', 'Date')
                ->setCellValue('K3', 'Time');
        // ->setCellValue('L2', 'Historical');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:G2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H3');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:K2');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L3');

        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('A1:L1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('A2:D2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('E2:G2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);
        $sheet->getStyle('A2:K3')->applyFromArray($styleBold);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->freezePane('E4');

        $startrow = 4;
        foreach ($customer as $key => $value) {

            $phone = ($value->customerPhones != NULL) ? $this->phoneNumber($value->customerPhones) : '';

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $startrow, $value->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $startrow, $value->address);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $startrow, $phone);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrow, $value->email);
            $customertype = (($value->customer_type == 'Individual') ? "P" : (($value->customer_type == 'Company') ? "K" : ""));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrow, $customertype);

            // $objPHPExcel->getActiveSheet()->setCellValue('L'.$startrow,'see details');
            // $objPHPExcel->getActiveSheet()->getCell('L'.$startrow)->getHyperlink()->setUrl("sheet://'Historical'!A1");

            $kendaraan = $value->vehicles;
            foreach ($kendaraan as $key => $vehicle) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrow, $vehicle->plate_number);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrow, $vehicle->carMake->name . ' - ' . $vehicle->carModel->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrow, $vehicle->machine_number);
                $startrow++;
            }

            $objPHPExcel->getActiveSheet()
                    ->getStyle('C' . $startrow)
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

            $startrow++;
        }
        // die();
        $objCommentRichText = $objPHPExcel->getActiveSheet(0)->getComment('E5')->getText()->createTextRun('My first comment :)');
        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('DataCustomer');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'Customer_data_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function getXlsHistory($customer) {

        // $plate_number = [];
        // $merkmobil = [];
        // foreach ($customer->vehicles as $key => $value) {
        // 	$plate_number[] = $value->plate_number;
        // 	$merkmobil[] = $value->carMake->name . ' - '. $value->carModel->name ;
        // }
        // var_dump($plate_number); die();
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Cakra Studio")
                ->setLastModifiedBy("Apri Pebriana")
                ->setTitle("Customer Data " . date('d-m-Y'))
                ->setSubject("Customer")
                ->setDescription("Export Data Customer, generated using PHP classes.")
                ->setKeywords("Customer Data")
                ->setCategory("Export Customer");

        // style for horizontal vertical center
        $styleHorizontalVertivalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleLeftVertivalCenterBold = array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );
        $styleHorizontalCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $styleVerticalCenter = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
        );

        // style color red
        $styleColorRED = array(
            'font' => array(
                'color' => array('rgb' => 'FF0000'),
                'bold' => true,
            ),
                // 'fill' => array(
                //     'type' => PHPExcel_Style_Fill::FILL_SOLID,
                //     'color' => array('rgb' => 'FF0000')
                // )
        );

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B1', 'Historical')
                ->setCellValue('B2', 'Nama Customer')
                ->setCellValue('B3', 'No Polisi')
                ->setCellValue('B4', 'Merk Mobil')
                ->setCellValue('B5', 'Phone')
                ->setCellValue('B6', 'Tanggal Cetak')
                ->setCellValue('B7', 'UserID');
        // ->setCellValue('B8', 'Halaman');
        // $customer->full_name;

        $objPHPExcel->setActiveSheetIndex(0)
                // ->setCellValue('C1', ':')
                ->setCellValue('C2', ':')
                ->setCellValue('C3', ':')
                ->setCellValue('c4', ':')
                ->setCellValue('c5', ':')
                ->setCellValue('c6', ':')
                ->setCellValue('c7', ':');
        // ->setCellValue('c8', ':');

        $phone = ($customer->customerPhones != NULL) ? $this->phoneNumber($customer->customerPhones) : '';

//		$plate_number = [];
//		$merkmobil = [];
//		$customerMobiles = [];
        foreach ($customer->vehicles as $key => $value) {
            $plate_number[] = $value->plate_number;
            $merkmobil[] = $value->carMake->name . ' - ' . $value->carModel->name;
        }

        foreach ($customer->customerPhones as $key => $cusvalue) {
            $customerMobiles[] = $cusvalue->phone_no;
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D2', $customer->name)
                ->setCellValue('D3', implode(', ', $plate_number))
                ->setCellValue('D4', implode(', ', $merkmobil))
                ->setCellValue('D5', implode(', ', $customerMobiles))
                ->setCellValue('D6', date("d-m-Y"))
                ->setCellValue('D7', $customer->id);

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('D8', 'Tanggal Nota')
                ->setCellValue('E8', 'Nomor Nota')
                ->setCellValue('F8', 'Tanggal WO')
                ->setCellValue('G8', 'Nomor WO')
                ->setCellValue('H8', 'KM')
                ->setCellValue('I8', 'Jasa')
                ->setCellValue('J8', 'Barang/Parts')
                ->setCellValue('J9', 'Kode')
                ->setCellValue('K9', 'Nama')
                ->setCellValue('L8', 'QTY')
                ->setCellValue('M8', 'Sat')
                ->setCellValue('N8', 'Kode Mekanik')
                ->setCellValue('O8', 'Rekomendasi');

        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B1:O1');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J8:K8');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D8:D9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E8:E9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F8:F9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G8:G9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H8:H9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I8:I9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L8:L9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('M8:M9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N8:N9');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O8:O9');


        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->getStyle('B1:O1')->applyFromArray($styleHorizontalVertivalCenterBold);
        $sheet->getStyle('B2:B7')->applyFromArray($styleLeftVertivalCenterBold);
        $sheet->getStyle('D8:O9')->applyFromArray($styleVerticalCenter);
        $sheet->getStyle('D8:O9')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('I2:K2')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('L2:L3')->applyFromArray($styleHorizontalVertivalCenterBold);
        // $sheet->getStyle('H2:H3')->applyFromArray($styleVerticalCenter);

        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(1.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(1.10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->freezePane('A10');

        /*
          ->setCellValue('D8', 'Tanggal Nota')
          ->setCellValue('E8', 'Nomor Nota')
          ->setCellValue('F8', 'Tanggal WO')
          ->setCellValue('G8', 'Nomor WO')
          ->setCellValue('H8', 'KM')
          ->setCellValue('I8', 'Jasa')
          ->setCellValue('J8', 'Barang/Parts')
          ->setCellValue('J9', 'Kode')
          ->setCellValue('K9', 'Nama')
          ->setCellValue('L8', 'QTY')
          ->setCellValue('M8', 'Sat')
          ->setCellValue('N8', 'Kode Mekanik')
          ->setCellValue('O8', 'Rekomendasi');
         */

//		$registrationTransaction = RegistrationTransaction::model()->findAllByAttributes(['customer_id'=>$customer->id]);
        $startrowTransaction = 10;
        foreach ($registrationTransaction as $key => $val) {
            $mekanik = ($val->pic != NULL) ? $val->pic->name . ' - ' . $val->pic->id : '';
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D' . $startrowTransaction, $val->transaction_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E' . $startrowTransaction, $val->transaction_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F' . $startrowTransaction, $val->work_order_date);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G' . $startrowTransaction, $val->work_order_number);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H' . $startrowTransaction, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I' . $startrowTransaction, $val->repair_type);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J' . $startrowTransaction, $val->getServices());
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K' . $startrowTransaction, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L' . $startrowTransaction, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M' . $startrowTransaction, '');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N' . $startrowTransaction, $mekanik);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O' . $startrowTransaction, '');
            $startrowTransaction++;
        }

        // Miscellaneous glyphs, UTF-8
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Historical');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        // $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->setActiveSheetIndex(0);

        // Save a xls file
        $filename = 'customer_' . strtolower($customer->name) . '_' . date("Y-m-d");
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');
        unset($this->objWriter);
        unset($this->objWorksheet);
        unset($this->objReader);
        unset($this->objPHPExcel);
        exit();
    }

    public function phoneNumber($phones) {
        $numberphone = array();
        foreach ($phones as $phone) {
            $numberphone[] = $phone->phone_no;
        }
        return "'" . implode(',', $numberphone);
    }

    public function actionLog($customerId) {
        $customer = Customer::model()->findByPk($customerId);
        $customerLog = CustomerLog::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 't.date_updated DESC'));
        
        $this->render('log', array(
            'customer' => $customer,
            'customerLog' => $customerLog,
        ));
    }
}
