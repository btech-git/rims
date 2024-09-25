<?php

class GeneralRepairController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('generalRepairCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('generalRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'addProductService' ||
            $filterChain->action->id === 'generateSalesOrder' ||
            $filterChain->action->id === 'generateWorkOrder' ||
            $filterChain->action->id === 'generateInvoice' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'showRealization'
        ) {
            if (!(Yii::app()->user->checkAccess('generalRepairCreate')) || !(Yii::app()->user->checkAccess('generalRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate($vehicleId) {
        $generalRepair = $this->instantiate(null);
        
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);

        $generalRepair->header->transaction_date = date('Y-m-d H:i:s');
        $generalRepair->header->created_datetime = date('Y-m-d H:i:s');
        $generalRepair->header->user_id = Yii::app()->user->id;
        $generalRepair->header->vehicle_id = $vehicleId;
        $generalRepair->header->customer_id = $vehicle->customer_id;
        $generalRepair->header->branch_id = Yii::app()->user->branch_id;

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($generalRepair);
            $generalRepair->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($generalRepair->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($generalRepair->header->transaction_date)), $generalRepair->header->branch_id);

            if ($generalRepair->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $generalRepair->header->id));
            }
        }

        $this->render('create', array(
            'generalRepair' => $generalRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionAddProductService($registrationId) {
        $generalRepair = $this->instantiate($registrationId);
        $customer = Customer::model()->findByPk($generalRepair->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($generalRepair->header->vehicle_id);
        $branches = Branch::model()->findAll();
        $generalRepair->header->pph = 1;
        $generalRepair->header->pph_price = 0.00;

        $qs = new QuickService('search');
        $qs->unsetAttributes();  // clear any default values
        if (isset($_GET['QuickService'])) {
            $qs->attributes = $_GET['QuickService'];
        }

        $qsCriteria = new CDbCriteria;
        $qsCriteria->compare('name', $qs->name, true);
        $qsCriteria->compare('code', $qs->code, true);
        $qsCriteria->compare('rate', $qs->rate, true);

        $qsDataProvider = new CActiveDataProvider('QuickService', array(
            'criteria' => $qsCriteria,
        ));

        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }

        $serviceCriteria = new CDbCriteria;
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);
        $serviceCriteria->compare('t.service_category_id', $service->service_category_id);
        $serviceCriteria->compare('t.service_type_id', $service->service_type_id);
        $serviceCriteria->compare('t.is_deleted', 0);
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

        $serviceArray = array();

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values

        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productDataProvider = $product->search();

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $generalRepair->header->id));

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadStateDetails($generalRepair);

            if ($generalRepair->saveDetails(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $generalRepair->header->id));
            }
        }

        $this->render('addProductService', array(
            'generalRepair' => $generalRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'branches' => $branches,
        ));
    }

    public function actionUpdate($id) {
        $generalRepair = $this->instantiate($id);
        $vehicle = Vehicle::model()->findByPk($generalRepair->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $generalRepair->header->edited_datetime = date('Y-m-d H:i:s');
        $generalRepair->header->user_id_edited = Yii::app()->user->id;

        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($generalRepair);
            
            if ($generalRepair->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $generalRepair->header->id));
            }
        }

        $this->render('update', array(
            'generalRepair' => $generalRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $quickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $registrationMemos = RegistrationMemo::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $id;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
        }

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
            'quickServices' => $quickServices,
            'services' => $services,
            'products' => $products,
            'registrationMemos' => $registrationMemos,
            'memo' => $memo,
        ));
    }
  
    public function actionAdmin() {

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
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
        
        $dataProvider->criteria->addCondition("repair_type = 'GR'");
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
        ));
    }

    public function actionFinishTransaction($id) {
        $model = $this->loadModel($id);
        $model->status = 'Finished';
        $model->transaction_date_out = date('Y-m-d');
        $model->transaction_time_out = date('H:i:s');
        
        if ($model->update(array('status', 'transaction_date_out', 'transaction_time_out'))) {
            $this->redirect(array('admin'));
        }
    }
    
    public function actionGenerateSalesOrder($id) {
        $model = $this->instantiate($id);

        if (empty($model->header->sales_order_number)) {
            $model->generateCodeNumberSaleOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        } else {
            $model->setCodeNumberSaleOrderByRevision('sales_order_number');
        }
        
        $model->header->sales_order_date = date('Y-m-d');
        $model->header->status = 'Processing SO';

        if ($model->header->update(array('sales_order_number', 'sales_order_date', 'status'))) {
            $real = new RegistrationRealizationProcess();
            $real->registration_transaction_id = $model->header->id;
            $real->name = 'Sales Order';
            $real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->getId();
            $real->detail = 'Generate Sales Order with number #' . $model->header->sales_order_number;
            $real->save();

            $this->redirect(array('view', 'id' => $id));
        }
    }

    public function actionGenerateWorkOrder($id) {
        $generalRepair = $this->instantiate($id);
        $customer = Customer::model()->findByPk($generalRepair->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($generalRepair->header->vehicle_id);

        $generalRepair->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($generalRepair->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($generalRepair->header->transaction_date)), $generalRepair->header->branch_id);
        $generalRepair->header->work_order_date = isset($_POST['RegistrationTransaction']['work_order_date']) ? $_POST['RegistrationTransaction']['work_order_date'] : date('Y-m-d');
        $generalRepair->header->work_order_time = date('H:i:s');
        $generalRepair->header->status = 'Waitlist';

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $id));
        }

        if (isset($_POST['Submit'])) {
            $generalRepair->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status'));
            if ($generalRepair->header->repair_type == 'GR') {
                $real = new RegistrationRealizationProcess();
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $generalRepair->header->work_order_number;
                $real->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }
        
        $this->render('generateWorkOrder', array(
            'generalRepair' => $generalRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionShowRealization($id) {
        $head = RegistrationTransaction::model()->findByPk($id);
        $reals = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        
        $this->render('realization', array(
            'head' => $head,
            'reals' => $reals,
        ));
    }

    public function actionCancel($id) {
        
        $movementOutHeader = MovementOutHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        if (empty($movementOutHeader && $invoiceHeader)) { 
            $model = $this->loadModel($id);
            $model->status = 'CANCELLED!!!';
            $model->payment_status = 'CANCELLED!!!';
            $model->service_status = 'CANCELLED!!!';
            $model->vehicle_status = 'CANCELLED!!!';
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->update(array('status', 'payment_status', 'service_status', 'vehicle_status', 'cancelled_datetime', 'user_id_cancelled'));
            
            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
    }

    public function actionAjaxHtmlAddQuickServiceDetail($id, $quickServiceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);

            $generalRepair->addQuickServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailQuickService', array(
                'generalRepair' => $generalRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddQsServiceDetail($id, $quickServiceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepair = $this->instantiateProductService($id);
            $this->loadState($generalRepair);

            $generalRepair->addQsServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $generalRepair
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveQuickServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepair = $this->instantiate($id);
            $this->loadState($generalRepair);

            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepair->removeQuickServiceDetailAt($index);

            $this->renderPartial('_detailQuickService', array(
                'generalRepair' => $generalRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveQuickServiceDetailAll($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepair = $this->instantiateProductService($id);
            $this->loadState($generalRepair);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepair->removeQuickServiceAll();

            $this->renderPartial('_detailQuickService', array(
                'generalRepair' => $generalRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);

            $generalRepair->addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair);
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailService', array(
                'generalRepair' => $generalRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepair->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'generalRepair' => $generalRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetailAll($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepair = $this->instantiate($id);
            $this->loadState($generalRepair);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepair->removeServiceDetailAll();

            $this->renderPartial('_detailService', array(
                'generalRepair' => $generalRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddProductDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);
            $branches = Branch::model()->findAll();

            $generalRepair->addProductDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailProduct', array(
                'generalRepair' => $generalRepair,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);
            $branches = Branch::model()->findAll();

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepair->removeProductDetailAt($index);

            $this->renderPartial('_detailProduct', array(
                'generalRepair' => $generalRepair,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($generalRepair->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepair->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalTransaction));

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
            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($generalRepair->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepair->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalTransaction));

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
            $generalRepair = $this->instantiate($id);
            $this->loadStateDetails($generalRepair);

            $totalQuickServiceQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->totalQuickServiceQuantity));
            $subTotalQuickService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalQuickService));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepair->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepair->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalQuickServiceQuantity' => $totalQuickServiceQuantity,
                'subTotalQuickService' => $subTotalQuickService,
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

    public function instantiate($id) {
        if (empty($id)) {
            $generalRepair = new GeneralRepair(new RegistrationTransaction(), array(), array(), array());
        } else {
            $generalRepairModel = $this->loadModel($id);
            $generalRepair = new GeneralRepair($generalRepairModel, $generalRepairModel->registrationQuickServices, $generalRepairModel->registrationServices, $generalRepairModel->registrationProducts);
        }
        return $generalRepair;
    }

    public function loadState($generalRepair) {
        if (isset($_POST['RegistrationTransaction'])) {
            $generalRepair->header->attributes = $_POST['RegistrationTransaction'];
        }
    }

    public function loadStateDetails($generalRepair) {
        if (isset($_POST['RegistrationTransaction'])) {
            $generalRepair->header->attributes = $_POST['RegistrationTransaction'];
        }

        if (isset($_POST['RegistrationQuickService'])) {
            foreach ($_POST['RegistrationQuickService'] as $i => $item) {
                if (isset($generalRepair->quickServiceDetails[$i])) {
                    $generalRepair->quickServiceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationQuickService();
                    $detail->attributes = $item;
                    $generalRepair->quickServiceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationQuickService']) < count($generalRepair->quickServiceDetails)) {
                array_splice($generalRepair->quickServiceDetails, $i + 1);
            }
        } else {
            $generalRepair->quickServiceDetails = array();
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($generalRepair->serviceDetails[$i])) {
                    $generalRepair->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $generalRepair->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($generalRepair->serviceDetails)) {
                array_splice($generalRepair->serviceDetails, $i + 1);
            }
        } else {
            $generalRepair->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($generalRepair->productDetails[$i])) {
                    $generalRepair->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $generalRepair->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($generalRepair->productDetails)) {
                array_splice($generalRepair->productDetails, $i + 1);
            }
        } else {
            $generalRepair->productDetails = array();
        }
    }

    public function instantiateRegistrationService($id) {
        if (empty($id)) {
            $registrationService = new RegistrationServices(new RegistrationService(), array(), array());
        } else {
            $registrationServiceModel = RegistrationService::model()->findByAttributes(array('id' => $id));
            $registrationService = new RegistrationServices($registrationServiceModel, $registrationServiceModel->registrationServiceEmployees, $registrationServiceModel->registrationServiceSupervisors);
        }
        return $registrationService;
    }

    public function loadStateRegistrationService($registrationService) {
        if (isset($_POST['RegistrationService'])) {
            $registrationService->header->attributes = $_POST['RegistrationService'];
        }
        
        if (isset($_POST['RegistrationServiceEmployee'])) {
            foreach ($_POST['RegistrationServiceEmployee'] as $i => $item) {
                if (isset($registrationService->employeeDetails[$i])) {
                    $registrationService->employeeDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationServiceEmployee();
                    $detail->attributes = $item;
                    $registrationService->employeeDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationServiceEmployee']) < count($registrationService->employeeDetails)) {
                array_splice($registrationService->employeeDetails, $i + 1);
            }
        } else {
            $registrationService->employeeDetails = array();
        }

        if (isset($_POST['RegistrationServiceSupervisor'])) {
            foreach ($_POST['RegistrationServiceSupervisor'] as $i => $item) {
                if (isset($registrationService->supervisorDetails[$i])) {
                    $registrationService->supervisorDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationServiceSupervisor();
                    $detail->attributes = $item;
                    $registrationService->supervisorDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationServiceSupervisor']) < count($registrationService->supervisorDetails)) {
                array_splice($registrationService->supervisorDetails, $i + 1);
            }
        } else {
            $registrationService->supervisorDetails = array();
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