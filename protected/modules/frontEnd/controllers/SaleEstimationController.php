<?php

class SaleEstimationController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
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

    public function actionCreate() {
        $saleEstimation = $this->instantiate(null);

        $saleEstimation->header->transaction_date = date('Y-m-d');
        $saleEstimation->header->created_datetime = date('Y-m-d H:i:s');
        $saleEstimation->header->user_id_created = Yii::app()->user->id;
        $saleEstimation->header->branch_id = Yii::app()->user->branch_id;

        $endDate = date('Y-m-d');
                
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $productDataProvider = $product->searchBySaleEstimation($endDate);
        $serviceDataProvider = $service->searchBySaleEstimation();
        $vehicleDataProvider = $vehicle->search();
        
        $productPageNumber = isset($_GET['product_page']) ? $_GET['product_page'] : 1;
        $servicePageNumber = isset($_GET['service_page']) ? $_GET['service_page'] : 1;
        $productDataProvider->pagination->pageVar = 'product_page';
        $productDataProvider->pagination->pageSize = 50;
        $productDataProvider->pagination->currentPage = $productPageNumber - 1;
        $serviceDataProvider->pagination->pageVar = 'service_page';
        $serviceDataProvider->pagination->pageSize = 50;
        $serviceDataProvider->pagination->currentPage = $servicePageNumber - 1;
        
        $branches = Branch::model()->findAll();
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleEstimation);
            $saleEstimation->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($saleEstimation->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($saleEstimation->header->transaction_date)), $saleEstimation->header->branch_id);

            if ($saleEstimation->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleEstimation->header->id));
            }
        }

        $this->render('create', array(
            'saleEstimation' => $saleEstimation,
            'product' => $product, 
            'productDataProvider' => $productDataProvider, 
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
            'isSubmitted' => isset($_POST['Submit']),
        ));
    }

    public function actionAddProductService($registrationId) {
        $saleEstimation = $this->instantiate($registrationId);
        $customer = Customer::model()->findByPk($saleEstimation->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($saleEstimation->header->vehicle_id);
        $branches = Branch::model()->findAll();
        $saleEstimation->header->pph = 1;

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
            $this->redirect(array('view', 'id' => $saleEstimation->header->id));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleEstimation);

            if ($saleEstimation->saveDetails(Yii::app()->db))
                $this->redirect(array('view', 'id' => $saleEstimation->header->id));
        }

        $this->render('addProductService', array(
            'saleEstimation' => $saleEstimation,
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
        $saleEstimation = $this->instantiate($id);
        $vehicle = Vehicle::model()->findByPk($saleEstimation->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $saleEstimation->header->edited_datetime = date('Y-m-d H:i:s');
        $saleEstimation->header->user_id_edited = Yii::app()->user->id;

        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($saleEstimation);
            
            if ($saleEstimation->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleEstimation->header->id));
            }
        }

        $this->render('update', array(
            'saleEstimation' => $saleEstimation,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionView($id) {
        
        $model = $this->loadModel($id);
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $services = SaleEstimationServiceDetail::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = SaleEstimationProductDetail::model()->findAllByAttributes(array('registration_transaction_id' => $id));
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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        $dataProvider->criteria->addCondition("repair_type = 'BR'");
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

//Add Service
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $saleEstimation->addServiceDetail($serviceId);

            $this->renderPartial('_detailService', array(
                'saleEstimation' => $saleEstimation,
            ));
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $saleEstimation->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'saleEstimation' => $saleEstimation,
            ));
        }
    }

    //Add Product
    public function actionAjaxHtmlAddProductDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);
            $branches = Branch::model()->findAll();

            $saleEstimation->addProductDetail($productId);

            $this->renderPartial('_detailProduct', array(
                'saleEstimation' => $saleEstimation,
                'branches' => $branches,
            ));
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $saleEstimation->removeProductDetailAt($index);

            $branches = Branch::model()->findAll();

            $this->renderPartial('_detailProduct', array(
                'saleEstimation' => $saleEstimation,
                'branches' => $branches,
            ));
        }
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleEstimation->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleEstimation->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalTransaction));

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
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleEstimation->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleEstimation->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalTransaction));

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
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleEstimation->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalTransaction));

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
  
    public function actionAjaxHtmlUpdateProductStockTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $endDate = date('Y-m-d');
            
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productPageNumber = isset($_GET['product_page']) ? $_GET['product_page'] : 1;
            $productDataProvider = $product->searchBySaleEstimation($endDate);
            $productDataProvider->pagination->pageVar = 'product_page';
            $productDataProvider->pagination->pageSize = 50;
            $productDataProvider->pagination->currentPage = $productPageNumber - 1;

            $branches = Branch::model()->findAll();
            
            $this->renderPartial('_productDataTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

            $this->renderPartial('_productSubBrandSelect', array(
                'product' => $product,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'product' => $product,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'product' => $product,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

            $this->renderPartial('_productSubCategorySelect', array(
                'product' => $product,
            ));
        }
    }

    public function actionAjaxHtmlUpdateServiceDataTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
            $servicePageNumber = isset($_GET['service_page']) ? $_GET['service_page'] : 1;
            $serviceDataProvider = $service->searchBySaleEstimation();
            $serviceDataProvider->pagination->pageVar = 'service_page';
            $serviceDataProvider->pagination->pageSize = 50;
            $serviceDataProvider->pagination->currentPage = $servicePageNumber - 1;

            $this->renderPartial('_serviceDataTable', array(
                'serviceDataProvider' => $serviceDataProvider,
            ));
        }
    }

    public function actionAjaxJsonVehicle($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $vehicle = $saleEstimation->header->vehicle(array('scopes' => 'resetScope', 'with' => 'customer:resetScope'));

            $object = array(
                'vehicle_name' => CHtml::value($vehicle, 'carMakeModelSubCombination'),
                'customer_name' => CHtml::value($vehicle, 'customer.name'),
                'customer_id' => CHtml::value($vehicle, 'customer_id'),
                'vehicle_plate_number' => CHtml::value($vehicle, 'plate_number'),
                'vehicle_frame_number' => CHtml::value($vehicle, 'frame_number'),
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $saleEstimation = new SaleEstimation(new SaleEstimationHeader(), array(), array());
        } else {
            $saleEstimationModel = $this->loadModel($id);
            $saleEstimation = new SaleEstimation($saleEstimationModel, $saleEstimationModel->saleEstimationServiceDetails, $saleEstimationModel->saleEstimationProductDetails
            );
        }
        return $saleEstimation;
    }

    public function loadState($saleEstimation) {
        if (isset($_POST['SaleEstimationHeader'])) {
            $saleEstimation->header->attributes = $_POST['SaleEstimationHeader'];
        }

        if (isset($_POST['SaleEstimationServiceDetail'])) {
            foreach ($_POST['SaleEstimationServiceDetail'] as $i => $item) {
                if (isset($saleEstimation->serviceDetails[$i])) {
                    $saleEstimation->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new SaleEstimationServiceDetail();
                    $detail->attributes = $item;
                    $saleEstimation->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['SaleEstimationServiceDetail']) < count($saleEstimation->serviceDetails)) {
                array_splice($saleEstimation->serviceDetails, $i + 1);
            }
        } else {
            $saleEstimation->serviceDetails = array();
        }

        if (isset($_POST['SaleEstimationProductDetail'])) {
            foreach ($_POST['SaleEstimationProductDetail'] as $i => $item) {
                if (isset($saleEstimation->productDetails[$i])) {
                    $saleEstimation->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new SaleEstimationProductDetail();
                    $detail->attributes = $item;
                    $saleEstimation->productDetails[] = $detail;
                }
            }
            if (count($_POST['SaleEstimationProductDetail']) < count($saleEstimation->productDetails)) {
                array_splice($saleEstimation->productDetails, $i + 1);
            }
        } else {
            $saleEstimation->productDetails = array();
        }
    }

    public function loadModel($id) {
        $model = SaleEstimationHeader::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }
}