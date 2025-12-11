<?php

class CustomerWaitlistController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'cashier') {
            if (!(Yii::app()->user->checkAccess('cashierApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'customerWaitlist') {
            if (!(Yii::app()->user->checkAccess('customerQueueApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndex() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateIn = (isset($_GET['StartDateIn'])) ? $_GET['StartDateIn'] : date('Y-m-d');
        $endDateIn = (isset($_GET['EndDateIn'])) ? $_GET['EndDateIn'] : date('Y-m-d');
        $startDateProcess = (isset($_GET['StartDateProcess'])) ? $_GET['StartDateProcess'] : date('Y-m-d');
        $endDateProcess = (isset($_GET['EndDateProcess'])) ? $_GET['EndDateProcess'] : date('Y-m-d');
        $startDateExit = (isset($_GET['StartDateExit'])) ? $_GET['StartDateExit'] : date('Y-m-d');
        $endDateExit = (isset($_GET['EndDateExit'])) ? $_GET['EndDateExit'] : date('Y-m-d');
        $plateNumberWaitlist = (isset($_GET['PlateNumberWaitlist'])) ? $_GET['PlateNumberWaitlist'] : '';
        $customerNameWaitlist = (isset($_GET['CustomerNameWaitlist'])) ? $_GET['CustomerNameWaitlist'] : '';
        $plateNumberIn = (isset($_GET['PlateNumberIn'])) ? $_GET['PlateNumberIn'] : '';
        $customerNameIn = (isset($_GET['CustomerNameIn'])) ? $_GET['CustomerNameIn'] : '';
        $plateNumberProcess = (isset($_GET['PlateNumberProcess'])) ? $_GET['PlateNumberProcess'] : '';
        $customerNameProcess = (isset($_GET['CustomerNameProcess'])) ? $_GET['CustomerNameProcess'] : '';
        $plateNumberExit = (isset($_GET['PlateNumberExit'])) ? $_GET['PlateNumberExit'] : '';
        $customerNameExit = (isset($_GET['CustomerNameExit'])) ? $_GET['CustomerNameExit'] : '';
        
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $dataProvider = $model->searchByCustomerWaitlist();
        $dataProvider->pagination->pageVar = 'page_dialog_waitlist';
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        $dataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.status != 'Finished' AND t.user_id_cancelled IS NULL");
        $dataProvider->criteria->compare('vehicle.plate_number', $plateNumberWaitlist, true);
        $dataProvider->criteria->compare('customer.name', $customerNameWaitlist, true);

        $vehicleEntry = new Vehicle('search');
        $vehicleEntry->unsetAttributes();  // clear any default values
        $vehicleEntryDataprovider = $vehicleEntry->searchByEntryStatusLocation($customerNameIn);
        $vehicleEntryDataprovider->pagination->pageVar = 'page_dialog_entry';
        $vehicleEntryDataprovider->criteria->compare('t.plate_number', $plateNumberIn, true);
        $vehicleEntryDataprovider->criteria->addBetweenCondition('DATE(t.entry_datetime)', $startDateIn, $endDateIn);
        
        $vehicleProcess = new Vehicle('search');
        $vehicleProcess->unsetAttributes();  // clear any default values
        $vehicleProcessDataprovider = $vehicleProcess->searchByProcessStatusLocation($customerNameProcess);
        $vehicleProcessDataprovider->pagination->pageVar = 'page_dialog_process';
        $vehicleProcessDataprovider->criteria->compare('t.plate_number', $plateNumberProcess, true);
        $vehicleProcessDataprovider->criteria->addBetweenCondition('DATE(t.start_service_datetime)', $startDateProcess, $endDateProcess);

        $vehicleExit = new Vehicle('search');
        $vehicleExit->unsetAttributes();  // clear any default values
        $vehicleExitDataprovider = $vehicleExit->searchByExitStatusLocation($customerNameExit);
        $vehicleExitDataprovider->pagination->pageVar = 'page_dialog_exit';
        $vehicleExitDataprovider->criteria->compare('t.plate_number', $plateNumberExit, true);
        $vehicleExitDataprovider->criteria->addBetweenCondition('DATE(t.exit_datetime)', $startDateExit, $endDateExit);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('index'));
        }
        
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'vehicleEntry' => $vehicleEntry,
            'vehicleProcess' => $vehicleProcess,
            'vehicleExit' => $vehicleExit,
            'plateNumberWaitlist' => $plateNumberWaitlist,
            'customerNameWaitlist' => $customerNameWaitlist,
            'plateNumberIn' => $plateNumberIn,
            'customerNameIn' => $customerNameIn,
            'plateNumberProcess' => $plateNumberProcess,
            'customerNameProcess' => $customerNameProcess,
            'plateNumberExit' => $plateNumberExit,
            'customerNameExit' => $customerNameExit,
            'startDateIn' => $startDateIn,
            'endDateIn' => $endDateIn,
            'startDateProcess' => $startDateProcess,
            'endDateProcess' => $endDateProcess,
            'startDateExit' => $startDateExit,
            'endDateExit' => $endDateExit,
            'vehicleEntryDataprovider' => $vehicleEntryDataprovider,
            'vehicleProcessDataprovider' => $vehicleProcessDataprovider,
            'vehicleExitDataprovider' => $vehicleExitDataprovider,
        ));
    }

    public function actionAjaxHtmlUpdateWaitlistTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $dataProvider = $model->search();
            $dataProvider->criteria->addCondition("t.work_order_number IS NOT NULL");

            $this->renderPartial('_waitlistTable', array(
                'model' => $model,
                'dataProvider' => $dataProvider,
            ));
        }
    }
    
//    public function actionAdmin() {
//        $model = new RegistrationTransaction('search');
//
//        $model->unsetAttributes();  // clear any default values
//        if (isset($_GET['RegistrationTransaction'])) {
//            $model->attributes = $_GET['RegistrationTransaction'];
//        }
//
//        $this->render('admin', array(
//            'model' => $model,
//        ));
//    }
}
