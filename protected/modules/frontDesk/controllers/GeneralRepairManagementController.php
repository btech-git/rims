<?php

class GeneralRepairManagementController extends Controller {

    public $layout = '//layouts/column1';

    /**
     * Idle Management.
     */
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'indexHead' ||
            $filterChain->action->id === 'viewDetailWorkOrder' ||
            $filterChain->action->id === 'viewEmployeeDetail' ||
            $filterChain->action->id === 'viewHeadWorkOrder' ||
            $filterChain->action->id === 'workOrderFinishService' ||
            $filterChain->action->id === 'workOrderPauseService' ||
            $filterChain->action->id === 'workOrderResumeService' ||
            $filterChain->action->id === 'workOrderStartService'
        ) {
            if (!(Yii::app()->user->checkAccess('grMechanicApproval')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Idle Management.
     */
    public function actionIndex() {
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');

        $employee = Search::bind(new EmployeeBranchDivisionPositionLevel('search'), isset($_GET['EmployeeBranchDivisionPositionLevel']) ? $_GET['EmployeeBranchDivisionPositionLevel'] : '');
        $employeeDataProvider = $employee->search();
        $employeeDataProvider->criteria->with = array(
            'employee',
            'branch',
            'division',
            'position',
            'level',
        );
        $employeeDataProvider->criteria->order = 'employee.name ASC';
        $employeeDataProvider->criteria->addCondition("position_id IN (1, 3, 4) AND division_id = 1");

        $waitlistDataProvider = $model->search();
        $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.service_status = 'Waitlist'");
        $waitlistDataProvider->criteria->compare('t.work_order_number', $model->work_order_number, true);
        $waitlistDataProvider->criteria->compare('t.branch_id', $model->branch_id);
        $waitlistDataProvider->criteria->compare('t.status', $model->status, true);
        $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');
        $registrationServiceManagementQueue = RegistrationServiceManagement::model()->getRegistrationServiceManagementQueue();
        $registrationServiceManagementAssigned = RegistrationServiceManagement::model()->getRegistrationServiceManagementAssigned();
        $registrationServiceManagementProgress = RegistrationServiceManagement::model()->getRegistrationServiceManagementProgress();
        $registrationServiceManagementControl = RegistrationServiceManagement::model()->getRegistrationServiceManagementControl();
        $registrationServiceManagementFinished = RegistrationServiceManagement::model()->getRegistrationServiceManagementFinished();
        $registrationTransactionIds = array();
        $serviceTypeIds = array();
        foreach ($registrationServiceManagementQueue as $row) {
            if (!in_array($row['registration_transaction_id'], $registrationTransactionIds)) {
                $registrationTransactionIds[] = $row['registration_transaction_id'];
            }
            if (!in_array($row['service_type_id'], $serviceTypeIds)) {
                $serviceTypeIds[] = $row['service_type_id'];
            }
        }
        foreach ($registrationServiceManagementAssigned as $row) {
            if (!in_array($row['registration_transaction_id'], $registrationTransactionIds)) {
                $registrationTransactionIds[] = $row['registration_transaction_id'];
            }
            if (!in_array($row['service_type_id'], $serviceTypeIds)) {
                $serviceTypeIds[] = $row['service_type_id'];
            }
        }
        foreach ($registrationServiceManagementProgress as $row) {
            if (!in_array($row['registration_transaction_id'], $registrationTransactionIds)) {
                $registrationTransactionIds[] = $row['registration_transaction_id'];
            }
            if (!in_array($row['service_type_id'], $serviceTypeIds)) {
                $serviceTypeIds[] = $row['service_type_id'];
            }
        }
        foreach ($registrationServiceManagementControl as $row) {
            if (!in_array($row['registration_transaction_id'], $registrationTransactionIds)) {
                $registrationTransactionIds[] = $row['registration_transaction_id'];
            }
            if (!in_array($row['service_type_id'], $serviceTypeIds)) {
                $serviceTypeIds[] = $row['service_type_id'];
            }
        }
        foreach ($registrationServiceManagementFinished as $row) {
            if (!in_array($row['registration_transaction_id'], $registrationTransactionIds)) {
                $registrationTransactionIds[] = $row['registration_transaction_id'];
            }
            if (!in_array($row['service_type_id'], $serviceTypeIds)) {
                $serviceTypeIds[] = $row['service_type_id'];
            }
        }
        $registrationServiceData = $registrationService->getRegistrationServiceData($registrationTransactionIds, $serviceTypeIds);
        $serviceNames = array();
        foreach ($registrationServiceData as $row) {
            $serviceNames[$row['registration_transaction_id'] . ':' . $row['service_type_id']][] = $row['name'];
        }
        
        $historyDataProvider = $model->search();
        $historyDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.service_status = 'Finished'");
        $historyDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';

        $this->render('index', array(
            'model' => $model,
            'branchId' => $branchId,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
            'historyDataProvider' => $historyDataProvider,
            'waitlistDataProvider' => $waitlistDataProvider,
            'registrationService' => $registrationService,
            'registrationServiceManagementQueue' => $registrationServiceManagementQueue,
            'registrationServiceManagementAssigned' => $registrationServiceManagementAssigned,
            'registrationServiceManagementProgress' => $registrationServiceManagementProgress,
            'registrationServiceManagementControl' => $registrationServiceManagementControl,
            'registrationServiceManagementFinished' => $registrationServiceManagementFinished,
            'serviceNames' => $serviceNames,
        ));
    }
    
//    public function actionProceedToQueue($id) {
//        $model = RegistrationTransaction::model()->findByPk($id);
//        $model->service_status = 'Queue';
//        
//        foreach ($model->registrationServiceManagements as $detail) {
//            $detail->status = 'Queue';
//            $detail->update(array('status'));
//        }
//        
//        if ($model->update(array('service_status'))) {
//            $this->redirect(array('index'));
//        }
//    }
    
    public function actionAssignMechanic($id) {
        $registrationServiceManagement = RegistrationServiceManagement::model()->findByPk($id);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationServiceManagement->registration_transaction_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);

        $registrationQuickService = new RegistrationQuickService('search');
        $registrationQuickService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationQuickService'])) {
            $registrationQuickService->attributes = $_GET['RegistrationQuickService'];
        }

        $registrationQuickServiceCriteria = new CDbCriteria;
        $registrationQuickServiceCriteria->compare('id', $registrationQuickService->id);
        $registrationQuickServiceCriteria->compare('registration_transaction_id', $registrationTransaction->id);
        $registrationQuickServiceCriteria->compare('quick_service_id', $registrationQuickService->quick_service_id);
        $registrationQuickServiceCriteria->compare('price', $registrationQuickService->price);
        $registrationQuickServiceCriteria->compare('hour', $registrationQuickService->hour);

        $registrationQuickServiceDataProvider = new CActiveDataProvider('RegistrationQuickService', array(
            'criteria' => $registrationQuickServiceCriteria,
        ));

        if (isset($_POST['Submit'])) {
            $registrationServiceManagement->assign_mechanic_id = $_POST['RegistrationServiceManagement']['assign_mechanic_id'];
            $registrationServiceManagement->update(array('assign_mechanic_id'));
            
            $this->redirect(array('index'));
        }

        $this->render('assignMechanic', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationServiceManagement' => $registrationServiceManagement,
            'registrationQuickService' => $registrationQuickService,
            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
            'vehicle' => $vehicle,
        ));
    }

    public function actionStartProcessing($id) {
        $registrationServiceManagement = RegistrationServiceManagement::model()->findByPk($id);
        $registrationServiceManagement->start = date('Y-m-d H:i:s');
        $registrationServiceManagement->start_mechanic_id = Yii::app()->user->id;
        $registrationServiceManagement->status = 'Start Service';
        
        if ($registrationServiceManagement->update(array('start', 'start_mechanic_id', 'status'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationServiceManagement->registration_transaction_id);
            $registrationTransaction->service_status = 'Start ' . $registrationServiceManagement->serviceType->name;
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
    }
    
    public function actionProceedToQualityControl($id) {
        $registrationServiceManagement = RegistrationServiceManagement::model()->findByPk($id);
        $registrationServiceManagement->end = date('Y-m-d H:i:s');
        $registrationServiceManagement->finish_mechanic_id = Yii::app()->user->id;
        $registrationServiceManagement->total_time = (strtotime($registrationServiceManagement->end) - strtotime($registrationServiceManagement->start)) / 60;
        $registrationServiceManagement->status = 'Ready to QC';
        
        if ($registrationServiceManagement->update(array('end', 'finish_mechanic_id', 'total_time', 'status'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationServiceManagement->registration_transaction_id);
            $registrationTransaction->service_status = 'Checking ' . $registrationServiceManagement->serviceType->name;
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionCheckQuality($id) {
        $registrationServiceManagement = RegistrationServiceManagement::model()->findByPk($id);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationServiceManagement->registration_transaction_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);

        $registrationService = new RegistrationService('search');
        $registrationService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationService'])) {
            $registrationService->attributes = $_GET['RegistrationService'];
        }
        $registrationServiceCriteria = new CDbCriteria;
        $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationTransaction->id . ' AND is_body_repair = 0';
        $registrationServiceDataProvider = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $registrationServiceCriteria,
        ));

        $registrationDamage = new RegistrationDamage('search');
        $registrationDamage->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationDamage'])) {
            $registrationDamage->attributes = $_GET['RegistrationDamage'];
        }
        $registrationDamageCriteria = new CDbCriteria;
        $registrationDamageCriteria->condition = 'registration_transaction_id = ' . $registrationTransaction->id;
        $registrationDamageDataProvider = new CActiveDataProvider('RegistrationDamage', array(
            'criteria' => $registrationDamageCriteria,
        ));

        $qualityControl = RegistrationServiceManagement::model()->findByAttributes(array('is_passed' => 0));
        if (isset($_POST['SubmitPass'])) {
            if (empty($qualityControl)) {
                $registrationTransaction->service_status = 'Finished';
                $registrationServiceManagement->status = 'Finished';
                $registrationServiceManagement->is_passed = true;
            } else {
                $serviceTypeId = isset($_POST['ServiceTypeId']) ? $_POST['ServiceTypeId'] : '';
                $registrationServiceManagement = RegistrationServiceManagement::model()->findByAttributes(array('registration_transaction_id' => $registrationTransaction->id, 'service_type_id' => $serviceTypeId));
                $registrationServiceManagement->status = 'Queue';
                $registrationServiceManagement->is_passed = false;

                $registrationTransaction->service_status = 'Queue';
            }

            if ($registrationServiceManagement->update(array('is_passed', 'status')) && $registrationTransaction->update(array('service_status'))) {
                $this->redirect(array('index'));
            }
        } else if (isset($_POST['SubmitFail'])) {
            if (empty($qualityControl)) {
                $registrationTransaction->service_status = 'Finished';
            } else {
                $registrationTransaction->service_status = 'Queue';
            }
            
            $registrationServiceManagement->start = NULL;
            $registrationServiceManagement->end = NULL;
            $registrationServiceManagement->pause = NULL;
            $registrationServiceManagement->resume = NULL;
            $registrationServiceManagement->note = NULL;
            $registrationServiceManagement->start_mechanic_id = NULL;
            $registrationServiceManagement->finish_mechanic_id = NULL;
            $registrationServiceManagement->pause_mechanic_id = NULL;
            $registrationServiceManagement->resume_mechanic_id = NULL;
            $registrationServiceManagement->assign_mechanic_id = NULL;
            $registrationServiceManagement->supervisor_id = NULL;
            $registrationServiceManagement->status = 'Queue';
            $registrationServiceManagement->total_time = 0;
            $registrationServiceManagement->pause_time = 0;
            $registrationServiceManagement->is_passed = 0;
            $registrationServiceManagement->hour = 0.00;

            if ($registrationServiceManagement->save() && $registrationTransaction->update(array('service_status'))) {
                $this->redirect(array('index'));
            }
        }

        $this->render('checkQuality', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationServiceManagement' => $registrationServiceManagement,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
            'vehicle' => $vehicle,
//            'memo' => $memo,
//            'priorityLevel' => $priorityLevel,
        ));
    }

    public function actionViewDetailWorkOrder($registrationId) {
        $registration = RegistrationTransaction::model()->findByPk($registrationId);
        $vehicle = Vehicle::model()->findByPk($registration->vehicle_id);
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $registrationHistories = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id' => $vehicle->id));

        $registrationService = new RegistrationService('search');
        $registrationService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationService'])) {
            $registrationService->attributes = $_GET['RegistrationService'];
        }
        $registrationServiceCriteria = new CDbCriteria;
        $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationId;
        $registrationServiceDataProvider = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $registrationServiceCriteria,
        ));

        $registrationDamage = new RegistrationDamage('search');
        $registrationDamage->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationDamage'])) {
            $registrationDamage->attributes = $_GET['RegistrationDamage'];
        }
        $registrationDamageCriteria = new CDbCriteria;
        $registrationDamageCriteria->condition = 'registration_transaction_id = ' . $registrationId;
        $registrationDamageDataProvider = new CActiveDataProvider('RegistrationDamage', array(
            'criteria' => $registrationDamageCriteria,
        ));

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $registrationId;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
        }

        $this->render('viewDetailWorkOrder', array(
            'registrationHistories' => $registrationHistories,
            'registration' => $registration,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamage' => $registrationDamage,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
            'vehicle' => $vehicle,
            'memo' => $memo,
        ));
    }

    public function actionProceedToQueue($id) {
        $registration = RegistrationTransaction::model()->findByPk($id);
        $vehicle = Vehicle::model()->findByPk($registration->vehicle_id);
        $registrationHistories = RegistrationTransaction::model()->findAllByAttributes(array('vehicle_id' => $vehicle->id));

        $registrationService = new RegistrationService('search');
        $registrationService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationService'])) {
            $registrationService->attributes = $_GET['RegistrationService'];
        }
        $registrationServiceCriteria = new CDbCriteria;
        $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $id;
        $registrationServiceDataProvider = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $registrationServiceCriteria,
        ));

        $registrationDamage = new RegistrationDamage('search');
        $registrationDamage->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationDamage'])) {
            $registrationDamage->attributes = $_GET['RegistrationDamage'];
        }
        $registrationDamageCriteria = new CDbCriteria;
        $registrationDamageCriteria->condition = 'registration_transaction_id = ' . $id;
        $registrationDamageDataProvider = new CActiveDataProvider('RegistrationDamage', array(
            'criteria' => $registrationDamageCriteria,
        ));

        if (isset($_POST['ProceedQueue'])) {
            
            $serviceTypeId = isset($_POST['ServiceTypeId']) ? $_POST['ServiceTypeId'] : '';
            if (!empty($serviceTypeId)) {
                $registrationServiceManagement = RegistrationServiceManagement::model()->findByAttributes(array('registration_transaction_id' => $registration->id, 'service_type_id' => $serviceTypeId));
                $registrationServiceManagement->status = 'Queue';
                $registrationServiceManagement->update(array('status'));
            }

            $registration->service_status = 'Queue';
            if ($registration->update(array('service_status'))) {
                $this->redirect(array('index'));
            }

        }
        
        $this->render('processWaitlist', array(
            'vehicle' => $vehicle,
            'registration' => $registration,
            'registrationHistories' => $registrationHistories,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamage' => $registrationDamage,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
        ));
    }

    public function actionAjaxHtmlUpdateWaitlistTable() {
        if (Yii::app()->request->isAjaxRequest) {

            $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');

            $waitlistDataProvider = $model->search();
            $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.service_status = 'Waitlist'");
            $waitlistDataProvider->criteria->compare('t.work_order_number', $model->work_order_number, true);
            $waitlistDataProvider->criteria->compare('t.branch_id', $model->branch_id);
            $waitlistDataProvider->criteria->compare('t.status', $model->status, true);
            $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

            $this->renderPartial('_waitlistTable', array(
                'model' => $model,
                'waitlistDataProvider' => $waitlistDataProvider,
            ));
        }
    }

}