<?php

class SaleEstimationController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleEstimationCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('saleEstimationEdit'))) {
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
            if (!(Yii::app()->user->checkAccess('saleEstimationCreate')) || !(Yii::app()->user->checkAccess('saleEstimationEdit')) || !(Yii::app()->user->checkAccess('saleEstimationView'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $saleEstimation = $this->instantiate(null);
        $branch = Branch::model()->model()->findByPk(Yii::app()->user->branch_id);

        $saleEstimation->header->transaction_date = date('Y-m-d');
        $saleEstimation->header->transaction_time = date('H:i:s');
        $saleEstimation->header->created_datetime = date('Y-m-d H:i:s');
        $saleEstimation->header->user_id_created = Yii::app()->user->id;
        $saleEstimation->header->branch_id = Yii::app()->user->branch_id;
        $saleEstimation->header->status = 'Draft';
        $saleEstimation->header->repair_type = 'GR/BR';

        $endDate = date('Y-m-d');
                
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $vehicleData = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $productDataProvider = $product->searchBySaleEstimation($endDate);
        $serviceDataProvider = $service->searchBySaleEstimation();
        $vehicleDataProvider = $vehicleData->search();
        $vehicleDataProvider->criteria->with = array(
            'customer',
        );
        
        $productPageNumber = isset($_GET['product_page']) ? $_GET['product_page'] : 1;
        $servicePageNumber = isset($_GET['service_page']) ? $_GET['service_page'] : 1;
        $productDataProvider->pagination->pageVar = 'product_page';
        $productDataProvider->pagination->pageSize = 20;
        $productDataProvider->pagination->currentPage = $productPageNumber - 1;
        $serviceDataProvider->pagination->pageVar = 'service_page';
        $serviceDataProvider->pagination->pageSize = 20;
        $serviceDataProvider->pagination->currentPage = $servicePageNumber - 1;
        
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        if (!empty($customerName)) {
            $vehicleDataProvider->criteria->addCondition('customer.name LIKE :customer_name');
            $vehicleDataProvider->criteria->params[':customer_name'] = "%{$customerName}%";
        }

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
            'vehicleData' => $vehicleData,
            'vehicleDataProvider' => $vehicleDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
            'customerName' => $customerName,
            'isSubmitted' => isset($_POST['Submit']),
            'vehicleId' => null,
            'branch' => $branch,
        ));
    }

    public function actionCreateWithVehicle($vehicleId) {
        $saleEstimation = $this->instantiate(null);
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $branch = Branch::model()->model()->findByPk(Yii::app()->user->branch_id);

        $saleEstimation->header->transaction_date = date('Y-m-d');
        $saleEstimation->header->transaction_time = date('H:i:s');
        $saleEstimation->header->created_datetime = date('Y-m-d H:i:s');
        $saleEstimation->header->user_id_created = Yii::app()->user->id;
        $saleEstimation->header->branch_id = Yii::app()->user->branch_id;
        $saleEstimation->header->status = 'Draft';
        $saleEstimation->header->repair_type = 'GR/BR';
        $saleEstimation->header->vehicle_id = $vehicleId;
        $saleEstimation->header->customer_id = $vehicle->customer_id;

        $endDate = date('Y-m-d');
                
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $productDataProvider = $product->searchBySaleEstimation($endDate);
        $serviceDataProvider = $service->searchBySaleEstimation();
        
        $productPageNumber = isset($_GET['product_page']) ? $_GET['product_page'] : 1;
        $servicePageNumber = isset($_GET['service_page']) ? $_GET['service_page'] : 1;
        $productDataProvider->pagination->pageVar = 'product_page';
        $productDataProvider->pagination->pageSize = 20;
        $productDataProvider->pagination->currentPage = $productPageNumber - 1;
        $serviceDataProvider->pagination->pageVar = 'service_page';
        $serviceDataProvider->pagination->pageSize = 20;
        $serviceDataProvider->pagination->currentPage = $servicePageNumber - 1;
        
        $branches = Branch::model()->findAll();
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($saleEstimation);
            $saleEstimation->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($saleEstimation->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($saleEstimation->header->transaction_date)), $saleEstimation->header->branch_id);

            if ($saleEstimation->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleEstimation->header->id));
            }
        }

        $this->render('createWithVehicle', array(
            'saleEstimation' => $saleEstimation,
            'product' => $product, 
            'productDataProvider' => $productDataProvider, 
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
            'isSubmitted' => isset($_POST['Submit']),
            'vehicleId' => $vehicleId,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'branch' => $branch,
        ));
    }

    public function actionUpdate($id) {
        $saleEstimation = $this->instantiate($id, 'update');
        
        $vehicle = Vehicle::model()->findByPk($saleEstimation->header->vehicle_id);
        $customer = Customer::model()->findByPk($saleEstimation->header->customer_id);
        $saleEstimation->header->edited_datetime = date('Y-m-d H:i:s');
        $saleEstimation->header->user_id_edited = Yii::app()->user->id;
        $branch = Branch::model()->model()->findByPk($saleEstimation->header->branch_id);

        $endDate = date('Y-m-d');
                
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');
        $vehicleData = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $productDataProvider = $product->searchBySaleEstimation($endDate);
        $serviceDataProvider = $service->searchBySaleEstimation();
        $vehicleDataProvider = $vehicleData->search();
        $vehicleDataProvider->criteria->with = array(
            'customer',
        );
        
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        if (!empty($customerName)) {
            $vehicleDataProvider->criteria->addCondition('customer.name LIKE :customer_name');
            $vehicleDataProvider->criteria->params[':customer_name'] = "%{$customerName}%";
        }

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
            
            if ($saleEstimation->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $saleEstimation->header->id));
            }
        }

        $this->render('update', array(
            'saleEstimation' => $saleEstimation,
            'product' => $product, 
            'productDataProvider' => $productDataProvider, 
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
            'branch' => $branch,
            'vehicle' => $vehicle,
            'vehicleData' => $vehicleData,
            'vehicleDataProvider' => $vehicleDataProvider,
            'customer' => $customer,
            'customerName' => $customerName,
            'isSubmitted' => isset($_POST['Submit']),
        ));
    }

    public function actionView($id) {
        
        $model = $this->loadModel($id);

        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionPdf($id) {
        $saleEstimationHeader = SaleEstimationHeader::model()->findByPk($id);
        $customer = Customer::model()->findByPk($saleEstimationHeader->customer_id);
        $vehicle = Vehicle::model()->findByPk($saleEstimationHeader->vehicle_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Estimasi');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'saleEstimationHeader' => $saleEstimationHeader,
            'customer' => $customer,
            'vehicle' => $vehicle,
        ), true));
        $mPDF1->Output('Estimasi ' . $saleEstimationHeader->transaction_number . '.pdf', 'I');
    }

    public function actionMemo($id) {
        $this->layout = '//layouts/main_memo';
        $model = $this->loadModel($id);

        $this->render('memo', array(
            'model' => $model,
        ));
    }

    public function actionAdmin() {
        $model = new SaleEstimationHeader('search');
        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';

        if (isset($_GET['SaleEstimationHeader'])) {
            $model->attributes = $_GET['SaleEstimationHeader'];
        }

        $dataProvider = $model->search();
        $dataProvider->criteria->together = 'true';
        $dataProvider->criteria->with = array(
            'vehicle',
            'customer',
        );
//        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
//        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
//        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerName' => $customerName,
            'plateNumber' => $plateNumber,
        ));
    }

    public function actionOutstandingWithVehicle($vehicleId) {
        $model = new SaleEstimationHeader('search');
        $model->unsetAttributes();  // clear any default values

        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';

        if (isset($_GET['SaleEstimationHeader'])) {
            $model->attributes = $_GET['SaleEstimationHeader'];
        }

        $dataProvider = $model->searchByOutstanding();
        $dataProvider->criteria->together = 'true';
        $dataProvider->criteria->with = array(
            'vehicle',
            'customer',
        );
        
        $this->render('outstandingWithVehicle', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'customerName' => $customerName,
            'plateNumber' => $plateNumber,
            'vehicleId' => $vehicleId,
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

            $totalPriceService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleEstimation->serviceDetails[$index], 'totalAmount')));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalTransaction));
            $taxTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalPriceService' => $totalPriceService,
                'subTotalService' => $subTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxTotalTransaction' => $taxTotalTransaction,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $totalPriceProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($saleEstimation->productDetails[$index], 'totalPrice')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $saleEstimation->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->subTotalTransaction));
            $taxTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalPriceProduct' => $totalPriceProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
                'subTotalProduct' => $subTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxTotalTransaction' => $taxTotalTransaction,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $saleEstimation = $this->instantiate($id);
            $this->loadState($saleEstimation);

            $taxTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $saleEstimation->grandTotalTransaction));
            
            echo CJSON::encode(array(
                'taxTotalTransaction' => $taxTotalTransaction,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }
  
    public function actionAjaxHtmlUpdateSaleEstimationTable() {
        if (Yii::app()->request->isAjaxRequest) {
            
            $model = Search::bind(new SaleEstimationHeader('search'), isset($_POST['SaleEstimationHeader']) ? $_POST['SaleEstimationHeader'] : '');
            $dataProvider = $model->search();
//            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
//            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;

            $this->renderPartial('_saleEstimationDataTable', array(
                'model' => $model,
                'dataProvider' => $dataProvider,
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
            $productDataProvider->pagination->pageSize = 20;
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
            $serviceDataProvider->pagination->pageSize = 20;
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