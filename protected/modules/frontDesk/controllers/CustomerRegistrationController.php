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
            if (!(Yii::app()->user->checkAccess('generalRepairCreate') || Yii::app()->user->checkAccess('bodyRepairCreate'))) {
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
    
    public function actionDischargeDate() {
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addCondition('user_id_cancelled IS NULL AND estimate_discharge_date IS NOT NULL AND t.status NOT IN ("Finished")');
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

        $this->render('dischargeDate', array(
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