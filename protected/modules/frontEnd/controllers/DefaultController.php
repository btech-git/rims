<?php

class DefaultController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        $filterChain->run();
    }

    public function actionIndex() {
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : '');

        $endDate = date('Y-m-d');
        $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
        $vehicleDataProvider = $vehicle->searchByDashboard();
        $productDataProvider = $product->searchByStockCheck($pageNumber, $endDate, '<>');
        $customerDataProvider = $customer->searchByDashboard();
        $serviceDataProvider = $service->searchByDashboard();
        
        $branches = Branch::model()->findAll();

        $vehicleDataProvider->criteria->with = array(
            'customer',
        );

        if (isset($_GET['Vehicle'])) {
            $vehicle->attributes = $_GET['Vehicle'];
        }

        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        if (isset($_GET['Product'])) {
            $vehicle->attributes = $_GET['Product'];
        }
        
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('marketing'));
        }
        
        $this->render('index', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'product' => $product, 
            'productDataProvider' => $productDataProvider, 
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
            $carMakeId = isset($_GET['Vehicle']['car_make_id']) ? $_GET['Vehicle']['car_make_id'] : 0;

            $this->renderPartial('_carModelSelect', array(
                'vehicle' => $vehicle,
                'carMakeId' => $carMakeId,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateCarSubModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
            $carModelId = isset($_GET['Vehicle']['car_model_id']) ? $_GET['Vehicle']['car_model_id'] : 0;

            $this->renderPartial('_carSubModelSelect', array(
                'vehicle' => $vehicle,
                'carModelId' => $carModelId,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateVehicleDataTable() {
        if (Yii::app()->request->isAjaxRequest) {
            
            $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
            $vehicleDataProvider = $vehicle->search();
            $vehicleDataProvider->pagination->pageSize = 50;

            $this->renderPartial('_vehicleDataTable', array(
                'vehicleDataProvider' => $vehicleDataProvider,
            ));
        }
    }
    
    public function actionAjaxHtmlUpdateCustomerDataTable() {
        if (Yii::app()->request->isAjaxRequest) {
            
            $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
            $customerDataProvider = $customer->search();
            $customerDataProvider->pagination->pageSize = 50;

            $this->renderPartial('_customerDataTable', array(
                'customerDataProvider' => $customerDataProvider,
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
            $serviceDataProvider = $service->search();
            $serviceDataProvider->pagination->pageSize = 50;

            $this->renderPartial('_serviceDataTable', array(
                'serviceDataProvider' => $serviceDataProvider,
            ));
        }
    }
}
