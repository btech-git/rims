<?php

class CustomerRegistrationController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'vehicleList') {
            if (
                !(Yii::app()->user->checkAccess('generalRepairCreate')) || 
                !(Yii::app()->user->checkAccess('generalRepairEdit')) || 
                !(Yii::app()->user->checkAccess('bodyRepairCreate')) || 
                !(Yii::app()->user->checkAccess('bodyRepairEdit'))
            ) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionVehicleList() {
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');
        
        $vehicleDataProvider = $vehicle->searchByRegistration();
        $customerDataProvider = $customer->search();

        $this->render('vehicleList', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
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
}