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

    public function actionIndex() {
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '';
        $workOrderNumber = isset($_GET['WorkOrderNumber']) ? $_GET['WorkOrderNumber'] : '';
        $status = isset($_GET['Status']) ? $_GET['Status'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
//        $serviceTypeId = isset($_GET['ServiceTypeId']) ? $_GET['ServiceTypeId'] : '';

        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');
        $registrationServiceDataProvider = $registrationService->searchByGeneralRepairIdleManagement();

        if (!empty($plateNumber)) {
            $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.plate_number = :plate_number");
            $registrationServiceDataProvider->criteria->params[':plate_number'] = $plateNumber;
        }

        if (!empty($workOrderNumber)) {
            $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.work_order_number = :work_order_number");
            $registrationServiceDataProvider->criteria->params[':work_order_number'] = $workOrderNumber;
        }

        if (!empty($status)) {
            $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.status = :status");
            $registrationServiceDataProvider->criteria->params[':status'] = $status;
        }

        if (!empty($branchId)) {
            $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.branch_id = :branch_id");
            $registrationServiceDataProvider->criteria->params[':branch_id'] = $branchId;
        }

        $registrationServiceProgressDataProvider = $registrationService->searchByProgressMechanic();
        $registrationServiceProgressDataProvider->criteria->addCondition("t.start_mechanic_id = :start_mechanic_id");
        $registrationServiceProgressDataProvider->criteria->params[':start_mechanic_id'] = Yii::app()->user->id;

        $registrationServiceHistoryDataProvider = $registrationService->search();
        $registrationServiceHistoryDataProvider->criteria->together = 'true';
        $registrationServiceHistoryDataProvider->criteria->with = array('registrationTransaction');
        $registrationServiceHistoryDataProvider->criteria->addCondition("registrationTransaction.status = 'Finished' AND registrationTransaction.repair_type = 'GR'");
        $registrationServiceHistoryDataProvider->criteria->compare('t.start_mechanic_id', Yii::app()->user->id);
        $registrationServiceHistoryDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);
        $registrationServiceHistoryDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $this->render('index', array(
            'plateNumber' => $plateNumber,
            'workOrderNumber' => $workOrderNumber,
            'status' => $status,
            'branchId' => $branchId,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationServiceHistoryDataProvider' => $registrationServiceHistoryDataProvider,
            'registrationServiceProgressDataProvider' => $registrationServiceProgressDataProvider,
        ));
    }

    public function actionViewDetailWorkOrder($registrationId) {
        $registration = RegistrationTransaction::model()->findByPk($registrationId);
        $vehicle = Vehicle::model()->findByPk($registration->vehicle_id);
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';

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
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
        } else if (isset($_POST['DetailId']) && isset($_POST['PauseService'])) {
            $registrationService = RegistrationService::model()->findByPk($_POST['DetailId']);
            $registrationService->service_activity = 'PauseService';
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
        } else if (isset($_POST['DetailId']) && isset($_POST['FinishService'])) {
            $registrationService = RegistrationService::model()->findByPk($_POST['DetailId']);
            $registrationService->service_activity = 'FinishService';
            $generalRepairMechanic = new GeneralRepairMechanic($registrationService);
            $generalRepairMechanic->save(Yii::app()->db);
            $registration->service_status = 'PrepareToCheck';
            $registration->save(Yii::app()->db);
        }

        $this->render('viewDetailWorkOrder', array(
            'registration' => $registration,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationQuickService' => $registrationQuickService,
            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
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

    public function actionAjaxHtmlUpdateWaitlistTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = new RegistrationService('search');
            $registrationService->unsetAttributes();  // clear any default values
            $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '';
            $workOrderNumber = isset($_GET['WorkOrderNumber']) ? $_GET['WorkOrderNumber'] : '';
            $status = isset($_GET['Status']) ? $_GET['Status'] : '';
            $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
            $serviceTypeId = isset($_GET['ServiceTypeId']) ? $_GET['ServiceTypeId'] : '';

            if (isset($_GET['RegistrationService'])) {
                $registrationService->attributes = $_GET['RegistrationService'];
            }

            $registrationServiceDataProvider = $registrationService->searchByGeneralRepairMechanic();
        
            if (!empty($plateNumber)) {
                $registrationServiceDataProvider->criteria->addCondition("vehicle.plate_number = :plate_number");
                $registrationServiceDataProvider->criteria->params[':plate_number'] = $plateNumber;
            }

            if (!empty($workOrderNumber)) {
                $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.work_order_number = :work_order_number");
                $registrationServiceDataProvider->criteria->params[':work_order_number'] = $workOrderNumber;
            }

            if (!empty($status)) {
                $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.status = :status");
                $registrationServiceDataProvider->criteria->params[':status'] = $status;
            }

            if (!empty($branchId)) {
                $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.branch_id = :branch_id");
                $registrationServiceDataProvider->criteria->params[':branch_id'] = $branchId;
            }

            if (!empty($serviceTypeId)) {
                $registrationServiceDataProvider->criteria->addCondition("service.service_type_id = :service_type_id");
                $registrationServiceDataProvider->criteria->params[':service_type_id'] = $serviceTypeId;
            }

            $this->renderPartial('_waitlistTable', array(
                'registrationService' => $registrationService,
                'registrationServiceDataProvider' => $registrationServiceDataProvider,
                'plateNumber' => $plateNumber,
                'workOrderNumber' => $workOrderNumber,
                'status' => $status,
                'branchId' => $branchId,
                'serviceTypeId' => $serviceTypeId,
            ));
        }
    }

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
