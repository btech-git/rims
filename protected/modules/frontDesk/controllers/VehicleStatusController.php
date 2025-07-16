<?php

class VehicleStatusController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'index') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values

        $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
        $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
        $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
        $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        
        $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation();
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
        $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation();
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);

        $this->render('index', array(
            'vehicle' => $vehicle,
            'plateNumber' => $plateNumber,
            'startDateIn' => $startDateIn,
            'endDateIn' => $endDateIn,
            'startDateProcess' => $startDateProcess,
            'endDateProcess' => $endDateProcess,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
        ));
    }
    
    public function actionAjaxHtmlUpdateVehicleEntryDataTable() {
        if (Yii::app()->request->isAjaxRequest) {
            
            $vehicle = new Vehicle('search');
            $vehicle->unsetAttributes();  // clear any default values
            
            $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
            $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
            $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');

            $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation();
            $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog';
            $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
            $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
            $this->renderPartial('_vehicleEntry', array(
                'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
                'startDateIn' => $startDateIn,
                'endDateIn' => $endDateIn,
            ));
        }
    }

    public function actionAjaxHtmlUpdateVehicleStatusDataTable() {
        if (Yii::app()->request->isAjaxRequest) {

            $vehicle = new Vehicle('search');
            $vehicle->unsetAttributes();  // clear any default values

            $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
            $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
            $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');

            $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation();
            $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog';
            $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
            $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);
        
            $this->renderPartial('_vehicleProcess', array(
                'startDateProcess' => $startDateProcess,
                'endDateProcess' => $endDateProcess,
                'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
            ));
        }
    }
    
    public function actionUpdateToProgress($id) {
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values

        $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
        $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
        $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
        $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        
        $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation();
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
        $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation();
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);

        $model = Vehicle::model()->findByPk($id);
        $oldVehiclePositionTimer = VehiclePositionTimer::model()->find(array(
            'order' => ' id DESC',
            'condition' => "t.vehicle_id = :vehicle_id AND t.entry_date IS NOT NULL AND t.process_date IS NULL AND t.exit_date IS NULL",
            'params' => array(':vehicle_id' => $id)
        ));
        
        if (!empty($model) && !empty($oldVehiclePositionTimer)) {
            $model->status_location = 'On-Progress';
            $model->start_service_datetime = date('Y-m-d H:i:s');
            $model->start_service_user_id = Yii::app()->user->id;
            $model->update(array('status_location', 'start_service_datetime', 'start_service_user_id')); 

            $vehiclePositionTimer = $oldVehiclePositionTimer;
            $vehiclePositionTimer->process_date = date('Y-m-d');
            $vehiclePositionTimer->process_time = date('H:i:s');
            $vehiclePositionTimer->exit_date = null;
            $vehiclePositionTimer->exit_time = null;
            $vehiclePositionTimer->save();
        }

        $this->render('index', array(
            'vehicle' => $vehicle,
            'plateNumber' => $plateNumber,
            'startDateIn' => $startDateIn,
            'endDateIn' => $endDateIn,
            'startDateProcess' => $startDateProcess,
            'endDateProcess' => $endDateProcess,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
        ));
    }
    
    public function actionUpdateToExit($id) {
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values

        $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
        $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
        $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
        $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        
        $vehicleEntryDataprovider = $vehicle->searchByEntryStatusLocation();
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
        $vehicleProcessDataprovider = $vehicle->searchByProcessStatusLocation();
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumber, true);
        $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);

        $model = Vehicle::model()->findByPk($id);
        $oldVehiclePositionTimer = VehiclePositionTimer::model()->find(array(
            'order' => ' id DESC',
            'condition' => "t.vehicle_id = :vehicle_id AND t.entry_date IS NOT NULL AND t.process_date IS NOT NULL AND t.exit_date IS NULL",
            'params' => array(':vehicle_id' => $id)
        ));

        
        if (!empty($model) && !empty($oldVehiclePositionTimer)) {
            $model->status_location = 'Keluar Lokasi';
            $model->exit_datetime = date('Y-m-d H:i:s');
            $model->exit_user_id = Yii::app()->user->id;
            $model->update(array('status_location', 'exit_datetime', 'exit_user_id')); 
            
            $vehiclePositionTimer = $oldVehiclePositionTimer;
            $vehiclePositionTimer->exit_date = date('Y-m-d');
            $vehiclePositionTimer->exit_time = date('H:i:s');
            $vehiclePositionTimer->save();
        }
            
        $this->render('index', array(
            'vehicle' => $vehicle,
            'plateNumber' => $plateNumber,
            'startDateIn' => $startDateIn,
            'endDateIn' => $endDateIn,
            'startDateProcess' => $startDateProcess,
            'endDateProcess' => $endDateProcess,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
        ));
    }
}