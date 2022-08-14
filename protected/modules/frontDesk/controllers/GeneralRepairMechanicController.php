<?php

class GeneralRepairMechanicController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'viewDetailWorkOrder' ||
            $filterChain->action->id === 'viewEmployeeDetail' ||
            $filterChain->action->id === 'workOrderFinishService' ||
            $filterChain->action->id === 'workOrderPauseService' ||
            $filterChain->action->id === 'workOrderResumeService' ||
            $filterChain->action->id === 'workOrderStartService'
        ) {
            if (!(Yii::app()->user->checkAccess('grMechanicCreate')) || !(Yii::app()->user->checkAccess('grMechanicEdit')))
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
        $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');
        $registrationServiceManagementQueue = RegistrationServiceManagement::model()->getRegistrationServiceManagementQueue();
        $registrationServiceManagementAssigned = RegistrationServiceManagement::model()->getRegistrationServiceManagementMechanicAssignment();
        $registrationServiceManagementProgress = RegistrationServiceManagement::model()->getRegistrationServiceManagementMechanicProgress();
        $registrationServiceManagementControl = RegistrationServiceManagement::model()->getRegistrationServiceManagementMechanicControl();
        $registrationServiceManagementFinished = RegistrationServiceManagement::model()->getRegistrationServiceManagementMechanicFinished();
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
        
//        $historyDataProvider = $model->search();
//        $historyDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.service_status = 'Finished'");
//        $historyDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';

        $this->render('index', array(
            'model' => $model,
            'branchId' => $branchId,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
//            'historyDataProvider' => $historyDataProvider,
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

        $registrationServiceCriteria->compare('id', $registrationService->id);
        $registrationServiceCriteria->compare('registration_transaction_id', $registrationId);
        $registrationServiceCriteria->compare('service_id', $registrationService->service_id);
        $registrationServiceCriteria->compare('claim', $registrationService->claim, true);
        $registrationServiceCriteria->compare('is_quick_service', $registrationService->is_quick_service);
        $registrationServiceCriteria->compare('start', $registrationService->start, true);
        $registrationServiceCriteria->compare('end', $registrationService->end, true);
        $registrationServiceCriteria->compare('pause', $registrationService->pause, true);
        $registrationServiceCriteria->compare('resume', $registrationService->resume, true);
        $registrationServiceCriteria->compare('pause_time', $registrationService->pause_time, true);
        $registrationServiceCriteria->compare('total_time', $registrationService->total_time, true);
        $registrationServiceCriteria->compare('note', $registrationService->note, true);
        $registrationServiceCriteria->compare('is_body_repair', $registrationService->is_body_repair);
        $registrationServiceCriteria->compare('LOWER(status)', strtolower($registrationService->status), false);
        $registrationServiceCriteria->compare('start_mechanic_id', $registrationService->start_mechanic_id);
        $registrationServiceCriteria->compare('finish_mechanic_id', $registrationService->finish_mechanic_id);
        $registrationServiceCriteria->compare('pause_mechanic_id', $registrationService->pause_mechanic_id);
        $registrationServiceCriteria->compare('resume_mechanic_id', $registrationService->resume_mechanic_id);
        $registrationServiceCriteria->compare('supervisor_id', $registrationService->supervisor_id);
        $registrationServiceCriteria->compare('t.status', $registrationService->status, true);

        $registrationServiceDataProvider = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $registrationServiceCriteria,
        ));

        $registrationQuickService = new RegistrationQuickService('search');
        $registrationQuickService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationQuickService'])) {
            $registrationQuickService->attributes = $_GET['RegistrationQuickService'];
        }

        $registrationQuickServiceCriteria = new CDbCriteria;
        $registrationQuickServiceCriteria->compare('id', $registrationQuickService->id);
        $registrationQuickServiceCriteria->compare('registration_transaction_id', $registrationId);
        $registrationQuickServiceCriteria->compare('quick_service_id', $registrationQuickService->quick_service_id);
        $registrationQuickServiceCriteria->compare('price', $registrationQuickService->price);
        $registrationQuickServiceCriteria->compare('hour', $registrationQuickService->hour);

        $registrationQuickServiceDataProvider = new CActiveDataProvider('RegistrationQuickService', array(
            'criteria' => $registrationQuickServiceCriteria,
        ));

        if (isset($_POST['Submit']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $registrationId;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
//        } else if (isset($_POST['DetailId']) && isset($_POST['_FormSubmit_']) && ($_POST['_FormSubmit_'] === 'StartService' || $_POST['_FormSubmit_'] === 'ResumeService' || $_POST['_FormSubmit_'] === 'PauseService' || $_POST['_FormSubmit_'] === 'FinishService')) {
        } else if (isset($_POST['DetailId']) && isset($_POST['StartService'])) {
            $registrationService = RegistrationService::model()->findByPk($_POST['DetailId']);
            $registrationService->service_activity = 'StartService';
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
            $registration->service_status = 'StartService';
            $registration->save(Yii::app()->db);
        } else if (isset($_POST['DetailId']) && isset($_POST['ResumeService'])) {
            $registrationService = RegistrationService::model()->findByPk($_POST['DetailId']);
            $registrationService->service_activity = 'ResumeService';
            $registrationService->is_paused = 0;
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
        } else if (isset($_POST['DetailId']) && isset($_POST['PauseService'])) {
            $registrationService = RegistrationService::model()->findByPk($_POST['DetailId']);
            $registrationService->service_activity = 'PauseService';
            $registrationService->is_paused = 1;
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
        } else if (isset($_POST['DetailId']) && isset($_POST['FinishService'])) {
            $registrationService = RegistrationService::model()->findByPk($_POST['DetailId']);
            $registrationService->service_activity = 'FinishService';
            $registrationService->save(Yii::app()->db);
            
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
            
            $registration->service_status = 'PrepareToCheck';
            $registration->save(Yii::app()->db);
                
            $registrationRealizationProcess = RegistrationRealizationProcess::model()->findByAttributes(array('registration_service_id' => $registrationService->id));
            $registrationRealizationProcess->checked = 1;
            $registrationRealizationProcess->checked_by = Yii::app()->user->id;
            $registrationRealizationProcess->checked_date = date('Y-m-d');
            $registrationRealizationProcess->detail = 'Finished';
            $registrationRealizationProcess->save(Yii::app()->db);
        }

        $this->render('viewDetailWorkOrder', array(
            'registration' => $registration,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationQuickService' => $registrationQuickService,
            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
            'registrationHistories' => $registrationHistories,
            'vehicle' => $vehicle,
            'memo' => $memo,
        ));
    }

    public function actionViewEmployeeDetail($employeeId) {
        $employee = Employee::model()->findByPk($employeeId);
        $employeeBranchDivisionPositionLevel = EmployeeBranchDivisionPositionLevel::model()->findByAttributes(array('employee_id' => $employeeId));

        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');

        $registrationServiceDataProvider = $registrationService->search();
        $registrationServiceDataProvider->criteria->together = 'true';
        $registrationServiceDataProvider->criteria->with = array('registrationTransaction');
        $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.status = 'Finished' AND registrationTransaction.repair_type = 'GR'");
        $registrationServiceDataProvider->criteria->compare('t.finish_mechanic_id', $employeeId);
        $registrationServiceDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $registrationServiceAssignmentDataProvider = $registrationService->search();
        $registrationServiceAssignmentDataProvider->criteria->together = 'true';
        $registrationServiceAssignmentDataProvider->criteria->with = array('registrationTransaction');
        $registrationServiceAssignmentDataProvider->criteria->addCondition("registrationTransaction.status != 'Finished' AND registrationTransaction.repair_type = 'GR'");
        $registrationServiceAssignmentDataProvider->criteria->compare('t.assign_mechanic_id', $employeeId);
        $registrationServiceAssignmentDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $this->render('viewEmployeeDetail', array(
            'employee' => $employee,
            'employeeBranchDivisionPositionLevel' => $employeeBranchDivisionPositionLevel,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationServiceAssignmentDataProvider' => $registrationServiceAssignmentDataProvider,
            'branchId' => $branchId,
        ));
    }

    /**
     * Start Finish Service.
     */
    public function actionWorkOrderStartService($serviceId, $registrationId) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->start = date('Y-m-d H:i:s');
            $registrationService->status = 'On Progress';
            $registrationService->start_mechanic_id = Yii::app()->user->id;
            $registrationService->save();

            //Ada error di bagian ini
//            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
//                'registration_transaction_id' => $registrationId,
//                'service_id' => $serviceId,
//            ));
//            $real->checked_date = date('Y-m-d');
//            $real->checked_by = Yii::app()->user->id;
//            $real->detail = 'On Progress (Update From Idle Management)';
//            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $model = $this->loadModel($registrationId);
            $model->status = 'On Progress';
            $model->save();
        }
    }

    /**
     * Start Pause Service.
     */
    public function actionWorkOrderPauseService($serviceId, $registrationId) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->pause = date('Y-m-d H:i:s');
            $registrationService->status = 'On Progress';
            $registrationService->pause_mechanic_id = Yii::app()->user->id;

            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'service_id' => $registrationService->service_id
            ));
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->id;
            $real->detail = 'Paused (Update From Idle Management)';
            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $registrationService->save();

            $model = $this->loadModel($registrationId);
            $model->status = 'Paused';
            $model->save();
        }
    }

    /**
     * Start Resume Service.
     */
    public function actionWorkOrderResumeService($serviceId, $registrationId) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));

            $registrationService->resume = date('Y-m-d H:i:s');
            $registrationService->status = 'On Progress';
            $registrationService->resume_mechanic_id = Yii::app()->user->id;

            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'service_id' => $registrationService->service_id
            ));
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->id;
            $real->detail = 'On Progress (Update From Idle Management)';
            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $registrationService->save();

            $connection = Yii::app()->db;
            $sql = 'UPDATE rims_registration_service SET `pause_time` = SEC_TO_TIME(TIMESTAMPDIFF(SECOND,pause,resume)+TIME_TO_SEC(`pause_time`)) WHERE service_id=:service_id and registration_transaction_id=:registration_transaction_id';
            $command = $connection->createCommand($sql);
            $command->bindParam(":service_id", $serviceId, PDO::PARAM_STR);
            $command->bindParam(":registration_transaction_id", $registrationId, PDO::PARAM_STR);
            $command->execute();

            $model = $this->loadModel($registrationId);
            $model->status = 'On Progress';
            $model->save();
        }
    }

    public function actionWorkOrderFinishService($serviceId, $registrationId) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->end = date('Y-m-d H:i:s');
            $registrationService->status = 'Finished';
            $registrationService->finish_mechanic_id = Yii::app()->user->id;

            $transaction = RegistrationTransaction::model()->findByPk($registrationId);

//            if ($transaction->repair_type == 'GR') {
//                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
//                    'registration_transaction_id' => $registrationId,
//                    'service_id' => $registrationService->service_id
//                ));
//                $real->checked = 1;
//                $real->checked_date = date('Y-m-d');
//                $real->checked_by = Yii::app()->user->id;
//                $real->detail = 'Finished (Update From Idle Management)';
//                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
//            } else {
//                if ($registrationService->is_body_repair == 1) {
//                    $real = RegistrationRealizationProcess::model()->findByAttributes(array(
//                        'registration_transaction_id' => $registrationId,
//                        'service_id' => $registrationService->service_id
//                    ));
//                    $real->checked = 1;
//                    $real->checked_date = date('Y-m-d');
//                    $real->checked_by = Yii::app()->user->id;
//                    $real->detail = 'Finished (Update From Idle Management)';
//                    $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
//                }
//            }
            $registrationService->save();

            //Update Total Time using SQL Syntax
            $connection = Yii::app()->db;
            $sql = 'UPDATE rims_registration_service SET `total_time` = SEC_TO_TIME(TIMESTAMPDIFF(SECOND,start,end)+TIME_TO_SEC(`pause_time`)) WHERE service_id=:service_id and registration_transaction_id=:registration_transaction_id';
            $command = $connection->createCommand($sql);
            $command->bindParam(":service_id", $serviceId, PDO::PARAM_STR);
            $command->bindParam(":registration_transaction_id", $registrationId, PDO::PARAM_STR);
            $command->execute();


            $criteria = new CDbCriteria();
            $criteria->condition = 'registration_transaction_id = ' . $registrationId . ' and status IN ("On Progress", "Pending", "Available")';
            $count = RegistrationService::model()->count($criteria);

            $model = $this->loadModel($registrationId);
            $model->status = $count == 0 ? 'Finished' : 'On Progress';
            $model->save();
        }
    }

    public function actionProceedToQueue($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        $model->service_status = 'Queue';
        
        foreach ($model->registrationServiceManagements as $detail) {
            $detail->status = 'Queue';
            $detail->update(array('status'));
        }
        
        if ($model->update(array('service_status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionAssignMechanic($id) {
        $registrationServiceManagement = RegistrationServiceManagement::model()->findByPk($id);
        $registrationServiceManagement->assign_mechanic_id = Yii::app()->user->id;
        
        if ($registrationServiceManagement->update(array('assign_mechanic_id'))) {
            $this->redirect(array('index'));
        }
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
    
    public function actionAjaxHtmlUpdateWaitlistTable() {
        if (Yii::app()->request->isAjaxRequest) {

            $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');

            $waitlistDataProvider = $model->search();
//            $waitlistDataProvider->criteria->together = 'true';
//            $waitlistDataProvider->criteria->with = array('vehicle');
            $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.service_status = 'Waitlist'");
            $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

//            $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '';
//            $workOrderNumber = isset($_GET['WorkOrderNumber']) ? $_GET['WorkOrderNumber'] : '';
//            $status = isset($_GET['Status']) ? $_GET['Status'] : '';
//            $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
            
//            if (!empty($plateNumber)) {
//                $waitlistDataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
//                $waitlistDataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
//            }

//            if (!empty($workOrderNumber)) {
//                $waitlistDataProvider->criteria->addCondition("work_order_number LIKE :work_order_number");
//                $waitlistDataProvider->criteria->params[':work_order_number'] = "%{$workOrderNumber}%";
//            }
//
//            if (!empty($status)) {
//                $waitlistDataProvider->criteria->addCondition("status = :status");
//                $waitlistDataProvider->criteria->params[':status'] = $status;
//            }
//
//            if (!empty($branchId)) {
//                $waitlistDataProvider->criteria->addCondition("branch_id = :branch_id");
//                $waitlistDataProvider->criteria->params[':branch_id'] = $branchId;
//            }

            $this->renderPartial('_waitlistTable', array(
                'model' => $model,
                'waitlistDataProvider' => $waitlistDataProvider,
//                'plateNumber' => $plateNumber,
//                'workOrderNumber' => $workOrderNumber,
//                'status' => $status,
//                'branchId' => $branchId,
            ));
        }
    }

//    public function actionProceedToPlanning($id) {
//        $registrationService = RegistrationService::model()->findByPk($id);
//        $registrationService->status = 'Planning';
//        
//        if ($registrationService->update(array('status'))) {
//            $this->redirect(array('index'));
//        }
//        
//    }
//    
//    public function actionSelfAssignment($id) {
//        $registrationService = RegistrationService::model()->findByPk($id);
//        $registrationService->assign_mechanic_id = Yii::app()->user->id;
//            
//        if ($registrationService->update(array('assign_mechanic_id'))) {
//            $this->redirect(array('index'));
//        }
//    }
//
//    public function actionStartProcessing($id) {
//        $registrationService = RegistrationService::model()->findByPk($id);
//        $registrationService->start_mechanic_id = Yii::app()->user->id;
//        $registrationService->status = 'On Progress';
//        
//        if ($registrationService->update(array('status', 'start_mechanic_id'))) {
//            $this->redirect(array('index'));
//        }
//    }
//    
//    public function actionProcessQualityControl($id) {
//        $registrationService = RegistrationService::model()->findByPk($id);
//        $registrationService->finish_mechanic_id = Yii::app()->user->id;
//        $registrationService->status = 'Finished';
//        
//        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationService->registration_transaction_id);
//        $registrationTransaction->service_status = 'PrepareToCheck';
//        
//        if ($registrationService->update(array('status', 'finish_mechanic_id')) && $registrationTransaction->update(array('service_status'))) {
//            $this->redirect(array('index'));
//        }
//        
//    }
    
    public function actionAjaxHtmlUpdateTransactionHistoryTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = new RegistrationService('search');
            $registrationService->unsetAttributes();  // clear any default values
            $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
            $mechanicId = isset($_GET['MechanicId']) ? $_GET['MechanicId'] : '';

            if (isset($_GET['RegistrationService'])) {
                $registrationService->attributes = $_GET['RegistrationService'];
            }

            $registrationServiceDataProvider = $registrationService->search();
            $registrationServiceDataProvider->criteria->together = 'true';
            $registrationServiceDataProvider->criteria->with = array('registrationTransaction');
            $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.work_order_number IS NOT NULL AND registrationTransaction.repair_type = 'GR' AND registrationTransaction.status = 'Finished'");
            $registrationServiceDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);

            if (empty($mechanicId)) {
                $registrationServiceDataProvider->criteria->compare('t.finish_mechanic_id', Yii::app()->user->id);
            } else {
                $registrationServiceDataProvider->criteria->compare('t.finish_mechanic_id', $mechanicId);
            };

            $this->renderPartial('_transactionHistoryTable', array(
                'registrationService' => $registrationService,
                'registrationServiceDataProvider' => $registrationServiceDataProvider,
                'branchId' => $branchId,
                'mechanicId' => $mechanicId,
            ));
        }
    }

    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

}
