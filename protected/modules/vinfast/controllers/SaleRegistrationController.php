<?php

class SaleRegistrationController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('generalRepairCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'update' || $filterChain->action->id === 'reworkTransaction') {
            if (!(Yii::app()->user->checkAccess('generalRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'addDownpayment' ||
            $filterChain->action->id === 'addProductService' ||
            $filterChain->action->id === 'updateCustomerWorkOrder' ||
            $filterChain->action->id === 'updateDischargeDate' ||
            $filterChain->action->id === 'updateLocation' ||
            $filterChain->action->id === 'updateMileage' ||
            $filterChain->action->id === 'updateProblem'
        ) {
            if (!(Yii::app()->user->checkAccess('generalRepairCreate') || Yii::app()->user->checkAccess('generalRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'view') {
            if (!(
                Yii::app()->user->checkAccess('generalRepairCreate') || 
                Yii::app()->user->checkAccess('generalRepairEdit') || 
                Yii::app()->user->checkAccess('generalRepairView')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionVehicleList() {
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        
        $vehicleDataProvider = $vehicle->searchByRegistration();
        $vehicleDataProvider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482)");

        $this->render('vehicleList', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
        ));
    }
    
    public function actionCreate($vehicleId) {
        
        $registrationTransaction = $this->instantiate(null, 'create');        
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);

        $registrationTransaction->header->transaction_date = date('Y-m-d H:i:s');
        $registrationTransaction->header->created_datetime = date('Y-m-d H:i:s');
        $registrationTransaction->header->user_id = Yii::app()->user->id;
        $registrationTransaction->header->vehicle_id = $vehicleId;
        $registrationTransaction->header->customer_id = $vehicle->customer_id;
        $registrationTransaction->header->branch_id = Yii::app()->user->branch_id;
        $registrationTransaction->header->status = 'Registration';
        $registrationTransaction->header->vehicle_status = 'DI BENGKEL';
        $registrationTransaction->header->service_status = 'Pending';
        $registrationTransaction->header->product_status = 'Draft';
        $registrationTransaction->header->priority_level = 2;
        $registrationTransaction->header->vehicle_entry_datetime = null;
        $registrationTransaction->header->vehicle_exit_datetime = null;
        $registrationTransaction->header->vehicle_start_service_datetime = null;
        $registrationTransaction->header->vehicle_finish_service_datetime = null;
        $registrationTransaction->header->work_order_time = null;
        
        $branches = Branch::model()->findAll();

        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->compare('t.status', 'Active');

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($registrationTransaction);
            $registrationTransaction->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);

            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('create', array(
            'registrationTransaction' => $registrationTransaction,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionUpdate($id) {
        $registrationTransaction = $this->instantiate($id, 'update');   
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        
        $registrationTransaction->header->edited_datetime = date('Y-m-d H:i:s');
        $registrationTransaction->header->user_id_edited = Yii::app()->user->id;

        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($registrationTransaction);
            
            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('update', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionAddDownpayment($id) {
        $registrationTransaction = $this->instantiate($id, 'addDownpayment');
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        
        if ($registrationTransaction->header->downpayment_amount > 0) {
            $registrationTransaction->header->downpayment_updated_datetime = date('Y-m-d H:i:s');
            $registrationTransaction->header->user_id_updated_downpayment = Yii::app()->user->id;
        } else {
            $registrationTransaction->header->downpayment_transaction_date = date('Y-m-d');
            $registrationTransaction->header->downpayment_created_datetime = date('Y-m-d H:i:s');
            $registrationTransaction->header->user_id_created_downpayment = Yii::app()->user->id;
            $registrationTransaction->header->is_downpayment_paid = 0;
            $registrationTransaction->header->downpayment_status = 'Issued';
        }

        $products = RegistrationProduct::model()->findAll(array(
            'condition' => 'registration_transaction_id = :registration_transaction_id AND sale_package_detail_id IS NULL', 
            'params' => array(':registration_transaction_id' => $id)
        ));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
        ));
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($registrationTransaction);
            if ($registrationTransaction->header->downpayment_amount > 0) {
                if ($registrationTransaction->header->downpayment_transaction_number === null) {
                    $registrationTransaction->generateCodeNumberDownpayment(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->downpayment_transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->downpayment_transaction_date)), $registrationTransaction->header->branch_id);
                }

                if ($registrationTransaction->save(Yii::app()->db)) {
                    $this->saveTransactionLog('addDownpayment', $registrationTransaction->header);
                    $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
                }
            }
        }
            
        $this->render('addDownpayment', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'services' => $services,
            'products' => $products,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        
        $products = RegistrationProduct::model()->findAll(array(
            'condition' => 'registration_transaction_id = :registration_transaction_id AND sale_package_detail_id IS NULL', 
            'params' => array(':registration_transaction_id' => $id)
        ));
        $packages = RegistrationPackage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        
        if (isset($_POST['SubmitFinish'])) {
            $model->status = 'Finished';
            $model->transaction_date_out = date('Y-m-d');
            $model->transaction_time_out = date('H:i:s');
            $model->update(array('status', 'transaction_date_out', 'transaction_time_out'));
        }

        if (isset($_POST['SubmitOffPremise'])) {
            $model->vehicle_status = 'Sudah Diambil';
            $model->transaction_date_out = date('Y-m-d');
            $model->transaction_time_out = date('H:i:s');

            $model->update(array('vehicle_status', 'transaction_date_out', 'transaction_time_out'));
        }

        if (isset($_POST['SubmitService'])) {
            $model->service_status = 'Done';
            $model->update(array('service_status'));
            
            foreach ($model->registrationServices as $service) {
                $service->status = 'Done';
                $service->update(array('status')); 
            }
        }

        $this->render('view', array(
            'model' => $model,
            'packages' => $packages,
            'services' => $services,
            'products' => $products,
        ));
    }

    public function actionViewMobile($id) {

        $model = $this->loadModel($id);
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        $this->render('viewMobile', array(
            'model' => $model,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
        ));
    }

    public function actionShow($id) {
        $model = $this->loadModel($id);
        
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
        ));
        $this->render('show', array(
            'model' => $model,
            'services' => $services,
            'products' => $products,
        ));
    }

    public function actionUpdateProductService($registrationId) {
        $registrationTransaction = $this->instantiate($registrationId, 'create');
        $customer = Customer::model()->findByPk($registrationTransaction->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->header->vehicle_id);
        $branches = Branch::model()->findAll();
        $registrationTransaction->header->pph = 1;
        $registrationTransaction->header->pph_price = 0.00;

        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->compare('t.status', 'Active');

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');
        
        $salePackage = new SalePackageHeader('search');
        $salePackage->unsetAttributes();  // clear any default values

        if (isset($_GET['SalePackageHeader'])) {
            $salePackage->attributes = $_GET['SalePackageHeader'];
        }
        
        $currentDate = date('Y-m-d');

        $salePackageDataProvider = $salePackage->search();
        $salePackageDataProvider->criteria->addCondition("'{$currentDate}' BETWEEN t.start_date AND t.end_date");

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($registrationTransaction);

            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('updateProductService', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'salePackage' => $salePackage,
            'salePackageDataProvider' => $salePackageDataProvider,
            'branches' => $branches,
        ));
    }

    public function actionUpdateMileage($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $lastRegistration = RegistrationTransaction::model()->findByAttributes(array('vehicle_id' => $vehicle->id), array('order' => 't.id DESC'));

        $registrationTransaction->previous_mileage = empty($lastRegistration) ? 0 : $lastRegistration->vehicle_mileage;
        
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_POST['RegistrationTransaction'];
            
            if ($registrationTransaction->save()) {
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateMileage', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
        ));
    }

    public function actionUpdateProblem($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);

        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_POST['RegistrationTransaction'];
            
            if ($registrationTransaction->save()) {
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateProblem', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
        ));
    }

    public function actionUpdateCustomerWorkOrder($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_POST['RegistrationTransaction'];
            
            if ($registrationTransaction->save()) {
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateCustomerWorkOrder', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
        ));
    }

    public function actionUpdateVehicleServicePosition($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);

        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->attributes = $_POST['RegistrationTransaction'];
            $vehicle->status_location = $registrationTransaction->vehicle_status;
            
            if ($registrationTransaction->vehicle_status == 'Masuk Bengkel') {
                $vehicle->entry_datetime = date('Y-m-d H:i:s');
                $registrationTransaction->vehicle_entry_datetime = date('Y-m-d H:i:s');
            } elseif ($registrationTransaction->vehicle_status == 'Keluar Bengkel') {
                $vehicle->exit_datetime = date('Y-m-d H:i:s');
                $registrationTransaction->vehicle_exit_datetime = date('Y-m-d H:i:s');
            } else {
                $vehicle->entry_datetime = null;
                $vehicle->start_service_datetime = null;
                $vehicle->finish_service_datetime = null;
                $vehicle->exit_datetime = null;
                $registrationTransaction->vehicle_entry_datetime = null;
                $registrationTransaction->vehicle_start_service_datetime = null;
                $registrationTransaction->vehicle_finish_service_datetime = null;
                $registrationTransaction->vehicle_exit_datetime = null;
            }
            
            if ($vehicle->save() && $registrationTransaction->save()) {
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateVehicleServicePosition', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionAdmin() {

        if (!(Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6)) {
            $branches = Branch::model()->findAllByAttributes(array('id' => Yii::app()->user->branch_id, 'status' => 'Active'));
        } else {
            $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        }
        $detailTabs = array();

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $tabIndex = (isset($_GET['TabIndex'])) ? $_GET['TabIndex'] : 0;

        foreach ($branches as $index => $branch) {
            $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
            $dataProvider = $model->searchAdmin();

            $dataProvider->criteria->compare('t.branch_id', $branch->id);
            $dataProvider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482)");
            $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);
            $dataProvider->criteria->together = true;
            $dataProvider->criteria->with = array(
                'customer',
                'branch',
                'vehicle',
            );

            if (!empty($plateNumber)) {
                $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
                $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
            }

            if (!empty($carMake)) {
                $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
                $dataProvider->criteria->params[':car_make_id'] = $carMake;
            }

            if (!empty($carModel)) {
                $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
                $dataProvider->criteria->params[':car_model_id'] = $carModel;
            }

            if (!empty($customerName)) {
                $dataProvider->criteria->addCondition('customer.name LIKE :name');
                $dataProvider->criteria->params[':name'] = "%{$customerName}%";
            }
            
            $dataProvider->pagination->pageVar = 'page_branch_' . $branch->id;

            $tabContent = $this->renderPartial('_adminPerBranch', array(
                'dataProvider' => $dataProvider,
                'tabIndex' => $index,
            ), true);
            $detailTabs[$branch->name] = array('content' => $tabContent);
        }
        
        if (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6) {
            $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
            $dataProvider = $model->searchAdmin();

            $dataProvider->criteria->addCondition("t.customer_id IN (60849, 60926, 63482)");
            $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);
            $dataProvider->criteria->together = true;
            $dataProvider->criteria->with = array(
                'customer',
                'branch',
                'vehicle',
            );

            if (!empty($plateNumber)) {
                $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
                $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
            }

            if (!empty($carMake)) {
                $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
                $dataProvider->criteria->params[':car_make_id'] = $carMake;
            }

            if (!empty($carModel)) {
                $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
                $dataProvider->criteria->params[':car_model_id'] = $carModel;
            }

            if (!empty($customerName)) {
                $dataProvider->criteria->addCondition('customer.name LIKE :name');
                $dataProvider->criteria->params[':name'] = "%{$customerName}%";
            }
            
            $dataProvider->pagination->pageVar = 'page_branch_all';

            $detailTabs['All'] = array('content' => $this->renderPartial('_adminAllBranch', array(
                'dataProvider' => $dataProvider,
                'tabIndex' => $index + 1,
            ), true));
        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
            'detailTabs' => $detailTabs,
            'tabIndex' => $tabIndex,
        ));
    }

    public function actionReworkTransaction($id) {
        $registrationTransaction = $this->instantiate($id, 'reworkTransaction');
        
        $registrationTransaction->header->rework_transaction_date = date('Y-m-d');
        $registrationTransaction->header->rework_transaction_time = date('H:i:s');
        $registrationTransaction->header->user_id_rework = Yii::app()->user->id;

        $products = RegistrationProduct::model()->findAll(array(
            'condition' => 'registration_transaction_id = :registration_transaction_id AND sale_package_detail_id IS NULL', 
            'params' => array(':registration_transaction_id' => $id)
        ));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
        ));
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($registrationTransaction);
            $registrationTransaction->generateCodeNumberReworkTransaction(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->rework_transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->rework_transaction_date)), $registrationTransaction->header->branch_id);

            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->saveTransactionLog('reworkTransaction', $registrationTransaction->header);
            
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('reworkTransaction', array(
            'registrationTransaction' => $registrationTransaction,
            'services' => $services,
            'products' => $products,
        ));
    }
    
    public function actionGenerateSalesOrder($id) {
        $model = $this->instantiate($id, 'createSalesOrder');

        if (empty($model->header->sales_order_number)) {
            $model->generateCodeNumberSaleOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        } else {
            $model->setCodeNumberSaleOrderByRevision('sales_order_number');
        }
        
        $model->header->sales_order_date = date('Y-m-d');
        $model->header->status = 'Processing SO';

        if ($model->header->update(array('sales_order_number', 'sales_order_date', 'status'))) {
            $this->redirect(array('view', 'id' => $id));
        }
    }

    public function actionGenerateWorkOrder($id) {
        $registrationTransaction = $this->instantiate($id, 'createWorkOrder');
        $customer = Customer::model()->findByPk($registrationTransaction->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->header->vehicle_id);

        if (empty($registrationTransaction->header->work_order_number)) {
            $registrationTransaction->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);
        } else {
            $registrationTransaction->setCodeNumberWorkOrderByRevision('work_order_number');
        }
        
        $registrationTransaction->header->work_order_date = date('Y-m-d');
        $registrationTransaction->header->work_order_time = date('H:i:s');
        $registrationTransaction->header->status = 'Waitlist';
        $registrationTransaction->header->service_status = 'On-Progress';

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $id));
        }

        if (isset($_POST['Submit'])) {
            $registrationTransaction->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status'));
            $this->redirect(array('view', 'id' => $id));
        }
        
        $this->render('generateWorkOrder', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionCancel($id) {
        
        $movementOutHeader = MovementOutHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        if (empty($movementOutHeader) && empty($invoiceHeader)) { 
            $model = $this->loadModel($id);
            $model->status = 'CANCELLED!!!';
            $model->payment_status = 'CANCELLED!!!';
            $model->service_status = 'CANCELLED!!!';
            $model->vehicle_status = 'CANCELLED!!!';
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->total_service = 0; 
            $model->subtotal_service = 0; 
            $model->discount_service = 0; 
            $model->total_service_price = 0; 
            $model->total_product = 0; 
            $model->subtotal_product = 0; 
            $model->discount_product = 0; 
            $model->total_product_price = 0; 
            $model->grand_total = 0; 
            $model->ppn = 0; 
            $model->pph = 0; 
            $model->subtotal = 0; 
            $model->ppn_price = 0; 
            $model->pph_price = 0; 
            $model->vehicle_mileage = 0; 
            $model->tax_percentage = 0; 
            $model->employee_id_assign_mechanic = null; 
            $model->employee_id_sales_person = null; 
            $model->work_order_number = ''; 
            $model->sales_order_number = ''; 
            $model->note = ''; 
            $model->customer_work_order_number = ''; 
            $model->feedback = ''; 
            $model->product_status = ''; 
            $model->update(array(
                'status', 'payment_status', 'service_status', 'vehicle_status', 'cancelled_datetime', 'user_id_cancelled', 'total_service', 
                'subtotal_service', 'discount_service', 'total_service_price', 'total_product', 'subtotal_product', 'discount_product', 'total_product_price',
                'grand_total', 'work_order_number', 'sales_order_number', 'ppn', 'pph', 'subtotal', 'ppn_price', 'pph_price', 'vehicle_mileage', 'note', 
                'customer_work_order_number', 'employee_id_assign_mechanic', 'employee_id_sales_person', 'tax_percentage', 'feedback', 'product_status'
            ));
            
            foreach ($model->registrationProducts as $registrationProduct) {
                $registrationProduct->quantity = 0;
                $registrationProduct->retail_price = 0;
                $registrationProduct->hpp = 0;
                $registrationProduct->recommended_selling_price = 0;
                $registrationProduct->sale_price = 0;
                $registrationProduct->discount = 0;
                $registrationProduct->total_price = 0;
                $registrationProduct->quantity_movement = 0;
                $registrationProduct->quantity_movement_left = 0;
                $registrationProduct->quantity_receive = 0;
                $registrationProduct->quantity_receive_left = 0;
                $registrationProduct->note = '';
                
                $registrationProduct->update(array(
                    'quantity', 'retail_price', 'hpp', 'recommended_selling_price', 'sale_price', 'discount', 'total_price', 'quantity_movement', 
                    'quantity_movement_left', 'quantity_receive', 'quantity_receive_left', 'note'
                ));
            }
            
            foreach ($model->registrationServices as $registrationService) {
                $registrationService->price = 0;
                $registrationService->total_price = 0;
                $registrationService->discount_price = 0;
                $registrationService->start_mechanic_id = null;
                $registrationService->finish_mechanic_id = null;
                $registrationService->pause_mechanic_id = null;
                $registrationService->resume_mechanic_id = null;
                $registrationService->supervisor_id = null;
                $registrationService->assign_mechanic_id = null;
                $registrationService->note = '';
                
                $registrationService->update(array(
                    'price', 'total_price', 'discount_price', 'start_mechanic_id', 'finish_mechanic_id', 'pause_mechanic_id', 'resume_mechanic_id', 
                    'supervisor_id', 'assign_mechanic_id', 'note'
                ));
            }
            
            $this->saveTransactionLog('cancel', $model);
        
            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
    }

    public function saveTransactionLog($actionType, $generalRepair) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $generalRepair->transaction_number;
        $transactionLog->transaction_date = $generalRepair->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $generalRepair->tableName();
        $transactionLog->table_id = $generalRepair->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $generalRepair->attributes;
        
        if ($actionType === 'approval') {
            $newData['registrationApprovals'] = array();
            foreach($generalRepair->registrationApprovals as $detail) {
                $newData['registrationApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['registrationProducts'] = array();
            foreach($generalRepair->registrationProducts as $detail) {
                $newData['registrationProducts'][] = $detail->attributes;
            }

            $newData['registrationServices'] = array();
            foreach($generalRepair->registrationServices as $detail) {
                $newData['registrationServices'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionPdf($id) {
        $registrationTransaction = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $branch = Branch::model()->findByPk($registrationTransaction->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Estimasi');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output('Estimasi ' . $registrationTransaction->transaction_number . '.pdf', 'I');
    }

    public function actionPdfSaleOrder($id) {
        $registrationTransaction = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $branch = Branch::model()->findByPk($registrationTransaction->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Sales Order');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfSaleOrder', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output('SO ' . $registrationTransaction->sales_order_number . '.pdf', 'I');
    }

    public function actionPdfWorkOrder($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $branch = Branch::model()->findByPk($registrationTransaction->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Work Order');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfWorkOrder', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output('WO ' . $registrationTransaction->work_order_number . '.pdf', 'I');
    }

    public function actionAjaxHtmlAddProductDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);
            $branches = Branch::model()->findAll();

            if (isset($_POST['ProductId'])) {
                $registrationTransaction->addProductDetail($_POST['ProductId']);
            }
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailProduct', array(
                'registrationTransaction' => $registrationTransaction,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);
            $branches = Branch::model()->findAll();

            $registrationTransaction->removeProductDetailAt($index);

            $this->renderPartial('_detailProduct', array(
                'registrationTransaction' => $registrationTransaction,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            if (isset($_POST['ServiceId'])) {
                $registrationTransaction->addServiceDetail($_POST['ServiceId']);
            }

            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $registrationTransaction,
            ));
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $registrationTransaction->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $registrationTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmount' => $totalAmount,
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmountProduct' => $totalAmountProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
                'subTotalProduct' => $subTotalProduct,
                'totalDiscountProduct' => $totalDiscountProduct,
                'grandTotalProduct' => $grandTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalProduct' => $grandTotalProduct,
                'grandTotal' => $grandTotal,
            ));
        }
    }
    
    public function actionAjaxJsonTotalPackage($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadStateDetails($registrationTransaction);

            $totalPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->packageDetails[$index], 'totalPrice')));
            $quantitySum = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalQuantityPackage));
            $totalPriceSum = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalPricePackage));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalPrice' => $totalPrice,
                'quantitySum' => $quantitySum,
                'totalPriceSum' => $totalPriceSum,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxShowPricelist($index, $serviceId, $customerId, $vehicleId, $insuranceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_price-dialog', array(
                'index' => $index,
                'customer' => $customerId,
                'service' => $serviceId,
                'vehicle' => $vehicleId,
                'insurance' => $insuranceId
            ), false, true);
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $saleRegistration = new SaleRegistration($actionType, new RegistrationTransaction(), array(), array(), array());
        } else {
            $registrationTransaction = $this->loadModel($id);
            $saleRegistration = new SaleRegistration($actionType, $registrationTransaction, $registrationTransaction->registrationServices, $registrationTransaction->registrationProducts, $registrationTransaction->registrationPackages);
        }
        return $saleRegistration;
    }

    public function loadState($registrationTransaction) {
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->header->attributes = $_POST['RegistrationTransaction'];
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($registrationTransaction->serviceDetails[$i])) {
                    $registrationTransaction->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $registrationTransaction->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($registrationTransaction->serviceDetails)) {
                array_splice($registrationTransaction->serviceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($registrationTransaction->productDetails[$i])) {
                    $registrationTransaction->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $registrationTransaction->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($registrationTransaction->productDetails)) {
                array_splice($registrationTransaction->productDetails, $i + 1);
            }
        } else {
            $registrationTransaction->productDetails = array();
        }

        if (isset($_POST['RegistrationPackage'])) {
            foreach ($_POST['RegistrationPackage'] as $i => $item) {
                if (isset($registrationTransaction->packageDetails[$i])) {
                    $registrationTransaction->packageDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationPackage();
                    $detail->attributes = $item;
                    $registrationTransaction->packageDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationPackage']) < count($registrationTransaction->packageDetails)) {
                array_splice($registrationTransaction->packageDetails, $i + 1);
            }
        } else {
            $registrationTransaction->packageDetails = array();
        }
    }

    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }
}