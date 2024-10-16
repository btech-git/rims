<?php

class RegistrationTransactionController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('bodyRepairCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('bodyRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'addProductService' ||
            $filterChain->action->id === 'generateInvoice' ||
            $filterChain->action->id === 'generateSalesOrder' ||
            $filterChain->action->id === 'generateWorkOrder' ||
            $filterChain->action->id === 'insuranceAddition' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'showRealization'
        ) {
            if (!(Yii::app()->user->checkAccess('bodyRepairCreate')) || !(Yii::app()->user->checkAccess('bodyRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate($vehicleId) {
        $bodyRepair = $this->instantiate(null);
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);

        $bodyRepair->header->transaction_date = date('Y-m-d H:i:s');
        $bodyRepair->header->work_order_time = date('H:i:s');
        $bodyRepair->header->created_datetime = date('Y-m-d H:i:s');
        $bodyRepair->header->user_id = Yii::app()->user->id;
        $bodyRepair->header->vehicle_id = $vehicleId;
        $bodyRepair->header->customer_id = $vehicle->customer_id;
        $bodyRepair->header->branch_id = Yii::app()->user->branch_id;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($bodyRepair);
            $bodyRepair->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($bodyRepair->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($bodyRepair->header->transaction_date)), $bodyRepair->header->branch_id);

            if ($bodyRepair->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $bodyRepair->header->id));
            }
        }

        $this->render('create', array(
            'bodyRepair' => $bodyRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionInsuranceAddition($id) {
        $registrationInsuranceData = new RegistrationInsuranceData();
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $insuranceCompany = InsuranceCompany::model()->findByPk($registrationTransaction->insurance_company_id);
        $registrationInsuranceData->registration_transaction_id = $id;
        $registrationInsuranceData->insurance_company_id = $registrationTransaction->insurance_company_id;

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $id));

        if (isset($_POST['_FormSubmit_'])) {
            if ($_POST['_FormSubmit_'] === 'Submit') {
                if (isset($_POST['RegistrationInsuranceData']))
                    $registrationInsuranceData->attributes = $_POST['RegistrationInsuranceData'];

                if ($registrationInsuranceData->save(Yii::app()->db))
                    $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('insuranceAddition', array(
            'registrationInsuranceData' => $registrationInsuranceData,
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'insuranceCompany' => $insuranceCompany,
        ));
    }

    public function actionAddProductService($registrationId) {
        $bodyRepair = $this->instantiate($registrationId);
        $customer = Customer::model()->findByPk($bodyRepair->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepair->header->vehicle_id);
        $branches = Branch::model()->findAll();
        $bodyRepair->header->pph = 1;

        $damage = new Service('search');
        $damage->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $damage->attributes = $_GET['Service'];
        }

        $damageCriteria = new CDbCriteria;
        $damageCriteria->together = 'true';
        $damageCriteria->with = array('serviceCategory', 'serviceType');

        $damageCriteria->compare('t.name', $damage->name, true);
        $damageCriteria->compare('t.code', $damage->code, true);
        $damageCriteria->compare('t.service_category_id', $damage->service_category_id);
        $damageCriteria->compare('t.service_type_id', 2);
        $explodeKeyword = explode(" ", $damage->findkeyword);

        foreach ($explodeKeyword as $key) {
            $damageCriteria->compare('t.code', $key, true, 'OR');
            $damageCriteria->compare('t.name', $key, true, 'OR');
            $damageCriteria->compare('description', $key, true, 'OR');
            $damageCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $damageCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $damageCriteria->compare('serviceType.name', $key, true, 'OR');
            $damageCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $damageDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $damageCriteria,
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
        $serviceCriteria->compare('t.service_type_id', 2);
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

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $bodyRepair->header->id));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadStateDetails($bodyRepair);

            if ($bodyRepair->saveDetails(Yii::app()->db))
                $this->redirect(array('view', 'id' => $bodyRepair->header->id));
        }

        $this->render('addProductService', array(
            'bodyRepair' => $bodyRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'damage' => $damage,
            'damageDataProvider' => $damageDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'branches' => $branches,
        ));
    }

    public function actionUpdate($id) {
        $bodyRepair = $this->instantiate($id);
        $vehicle = Vehicle::model()->findByPk($bodyRepair->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $bodyRepair->header->edited_datetime = date('Y-m-d H:i:s');
        $bodyRepair->header->user_id_edited = Yii::app()->user->id;

        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($bodyRepair);
            
            if ($bodyRepair->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $bodyRepair->header->id));
            }
        }

        $this->render('update', array(
            'bodyRepair' => $bodyRepair,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionView($id) {
        
        $model = $this->loadModel($id);
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationMemos = RegistrationMemo::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationBodyRepairDetails = RegistrationBodyRepairDetail::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $id;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
        }

        $this->render('view', array(
            'model' => $model,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationMemos' => $registrationMemos,
            'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
            'memo' => $memo,
        ));
    }

    public function actionAdmin() {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
//        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionGenerateSalesOrder($id) {
        $model = $this->instantiate($id);

        $model->generateCodeNumberSaleOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
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
        $bodyRepair = $this->instantiate($id);
        $customer = Customer::model()->findByPk($bodyRepair->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepair->header->vehicle_id);

        $bodyRepair->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($bodyRepair->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($bodyRepair->header->transaction_date)), $bodyRepair->header->branch_id);
        $bodyRepair->header->work_order_date = isset($_POST['RegistrationTransaction']['work_order_date']) ? $_POST['RegistrationTransaction']['work_order_date'] : date('Y-m-d');
        $bodyRepair->header->work_order_time = date('H:i:s');
        $bodyRepair->header->status = 'Waitlist';

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $id));
        }

        if (isset($_POST['Submit'])) {
            $bodyRepair->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status'));
            if ($bodyRepair->header->repair_type == 'GR') {
                $real = new RegistrationRealizationProcess();
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $bodyRepair->header->work_order_number;
                $real->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }
        
        $this->render('generateWorkOrder', array(
            'bodyRepair' => $bodyRepair,
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

//Add Service
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            $bodyRepair->addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair);

            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailService', array(
                'bodyRepair' => $bodyRepair,
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepair->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'bodyRepair' => $bodyRepair,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetailAll($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepair->removeServiceDetailAll();

            $this->renderPartial('_detailService', array(
                'bodyRepair' => $bodyRepair,
            ), false, true);
        }
    }

//Add Product
    public function actionAjaxHtmlAddProductDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);
            $branches = Branch::model()->findAll();

            $bodyRepair->addProductDetail($productId);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailProduct', array(
                'bodyRepair' => $bodyRepair,
                'branches' => $branches,
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepair->removeProductDetailAt($index);

            $branches = Branch::model()->findAll();

            $this->renderPartial('_detailProduct', array(
                'bodyRepair' => $bodyRepair,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($bodyRepair->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepair->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalTransaction));

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
            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($bodyRepair->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepair->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalTransaction));

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
            $bodyRepair = $this->instantiate($id);
            $this->loadStateDetails($bodyRepair);

            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepair->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepair->grandTotalTransaction));

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
            $bodyRepair = new BodyRepair(new RegistrationTransaction(), array(), array(), array());
        } else {
            $bodyRepairModel = $this->loadModel($id);
            $bodyRepair = new BodyRepair($bodyRepairModel, $bodyRepairModel->registrationQuickServices, $bodyRepairModel->registrationServices, $bodyRepairModel->registrationProducts
            );
        }
        return $bodyRepair;
    }

    public function loadState($bodyRepair) {
        if (isset($_POST['RegistrationTransaction'])) {
            $bodyRepair->header->attributes = $_POST['RegistrationTransaction'];
        }
    }

    public function loadStateDetails($bodyRepair) {
        if (isset($_POST['RegistrationTransaction'])) {
            $bodyRepair->header->attributes = $_POST['RegistrationTransaction'];
        }

        if (isset($_POST['RegistrationDamage'])) {
            foreach ($_POST['RegistrationDamage'] as $i => $item) {
                if (isset($bodyRepair->damageDetails[$i])) {
                    $bodyRepair->damageDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationDamage();
                    $detail->attributes = $item;
                    $bodyRepair->damageDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationDamage']) < count($bodyRepair->damageDetails)) {
                array_splice($bodyRepair->damageDetails, $i + 1);
            }
        } else {
            $bodyRepair->damageDetails = array();
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($bodyRepair->serviceDetails[$i])) {
                    $bodyRepair->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $bodyRepair->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($bodyRepair->serviceDetails)) {
                array_splice($bodyRepair->serviceDetails, $i + 1);
            }
        } else {
            $bodyRepair->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($bodyRepair->productDetails[$i])) {
                    $bodyRepair->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $bodyRepair->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($bodyRepair->productDetails)) {
                array_splice($bodyRepair->productDetails, $i + 1);
            }
        } else {
            $bodyRepair->productDetails = array();
        }
    }

    public function instantiateRegistrationService($id) {
        if (empty($id)) {
            $registrationService = new RegistrationServices(new RegistrationService(), array(), array());
            //print_r("test");
        } else {
            //$registrationServiceModel = $this->loadModel($id);
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