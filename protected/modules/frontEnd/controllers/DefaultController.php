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
            $product->attributes = $_GET['Product'];
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
}
