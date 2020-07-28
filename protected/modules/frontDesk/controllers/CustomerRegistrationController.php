<?php

class CustomerRegistrationController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'vehicleList') {
            if (!(Yii::app()->user->checkAccess('frontOfficeStaff')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionVehicleList() {
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        
        if (!isset($_GET['Vehicle'])) {
            $vehicle->customer_name_checked = true;
        }
        
        $vehicleDataProvider = $vehicle->searchByRegistration();

        $this->render('vehicleList', array(
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
        ));
    }
    
	public function actionAjaxHtmlUpdateCarModelSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $carMakeId = isset($_GET['Vehicle']['car_make_id']) ? $_GET['Vehicle']['car_make_id'] : 0;

            $this->renderPartial('_carModelSelect', array(
                'carMakeId' => $carMakeId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateCarSubModelSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $carModelId = isset($_GET['Vehicle']['car_model_id']) ? $_GET['Vehicle']['car_model_id'] : 0;

            $this->renderPartial('_carSubModelSelect', array(
                'carModelId' => $carModelId,
            ));
        }
    }
    
}