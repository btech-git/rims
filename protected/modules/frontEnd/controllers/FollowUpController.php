<?php

class FollowUpController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'viewInvoices'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate')) || !(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionAdminSales() {

        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $dataProvider = $model->searchByFollowUp();
        $dataProvider->criteria->addCondition("t.status <> 'Finished' AND t.branch_id = :branch_id");
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;

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
        
        $followUpDate = date('Y-m-d', strtotime('-3 days', strtotime(date('Y-m-d')))); 
        $dataProvider->criteria->addCondition('t.sales_order_date >= :follow_up_date');
        $dataProvider->criteria->params[':follow_up_date'] = $followUpDate;

        $this->render('adminSales', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
        ));
    }
    public function actionAdminService() {

        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $dataProvider = $model->searchByFollowUp();
        $dataProvider->criteria->addCondition("t.status = 'Finished' AND t.work_order_date IS NOT NULL AND t.branch_id = :branch_id");
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        
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
        
        $followUpDate = date('Y-m-d', strtotime('-6 months', strtotime(date('Y-m-d')))); 
        $dataProvider->criteria->addCondition('t.sales_order_date = :follow_up_date');
        $dataProvider->criteria->params[':follow_up_date'] = $followUpDate;

        $this->render('adminService', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
        ));
    }
    public function actionUpdateFeedback($id) {
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);

        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        
        if (isset($_POST['Submit'])) {
            $registrationTransaction->feedback = $_POST['RegistrationTransaction']['feedback'];
            $registrationTransaction->update(array('feedback'));
            $this->redirect(array('adminSales'));
        }

        $this->render('updateFeedback', array(
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'products' => $products,
            'services' => $services,
        ));
    }
}
