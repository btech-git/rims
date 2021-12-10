<?php

class BodyRepairManagementController extends Controller {

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
                $filterChain->action->id === 'assignMechanic' ||
                $filterChain->action->id === 'checkQuality'
        ) {
            if (!(Yii::app()->user->checkAccess('brMechanicApproval')))
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

        $historyDataProvider = $model->search();
        $historyDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Finished'");
        $historyDataProvider->criteria->compare('t.work_order_number', $model->work_order_number, true);
        $historyDataProvider->criteria->compare('t.branch_id', $model->branch_id);
        $historyDataProvider->criteria->compare('t.status', $model->status, true);
        $historyDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';

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
        $employeeDataProvider->criteria->addCondition("position_id IN (1, 3, 4) AND division_id = 2");

        $waitlistDataProvider = $model->search();
        $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Bongkar - Pending' AND t.status = 'Waitlist'");
        $waitlistDataProvider->criteria->compare('t.work_order_number', $model->work_order_number, true);
        $waitlistDataProvider->criteria->compare('t.branch_id', $model->branch_id);
        $waitlistDataProvider->criteria->compare('t.status', $model->status, true);
        $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

        $registrationBodyRepair = Search::bind(new RegistrationBodyRepairDetail('search'), isset($_GET['RegistrationBodyRepairDetail']) ? $_GET['RegistrationBodyRepairDetail'] : '');
        $queueBongkarDataProvider = $registrationBodyRepair->searchByQueueBongkar();
        $queueSparePartDataProvider = $registrationBodyRepair->searchByQueueSparePart();
        $queueKetokDataProvider = $registrationBodyRepair->searchByQueueKetok();
        $queueDempulDataProvider = $registrationBodyRepair->searchByQueueDempul();
        $queueEpoxyDataProvider = $registrationBodyRepair->searchByQueueEpoxy();
        $queueCatDataProvider = $registrationBodyRepair->searchByQueueCat();
        $queuePasangDataProvider = $registrationBodyRepair->searchByQueuePasang();
        $queuePolesDataProvider = $registrationBodyRepair->searchByQueuePoles();
        $queueCuciDataProvider = $registrationBodyRepair->searchByQueueCuci();
        
        $assignBongkarDataProvider = $registrationBodyRepair->searchByAssignBongkar();
        $assignSparePartDataProvider = $registrationBodyRepair->searchByAssignSparePart();
        $assignKetokDataProvider = $registrationBodyRepair->searchByAssignKetok();
        $assignDempulDataProvider = $registrationBodyRepair->searchByAssignDempul();
        $assignEpoxyDataProvider = $registrationBodyRepair->searchByAssignEpoxy();
        $assignCatDataProvider = $registrationBodyRepair->searchByAssignCat();
        $assignPasangDataProvider = $registrationBodyRepair->searchByAssignPasang();
        $assignPolesDataProvider = $registrationBodyRepair->searchByAssignPoles();
        $assignCuciDataProvider = $registrationBodyRepair->searchByAssignCuci();
        
        $progressBongkarDataProvider = $registrationBodyRepair->searchByProgressBongkar();
        $progressSparePartDataProvider = $registrationBodyRepair->searchByProgressSparepart();
        $progressKetokDataProvider = $registrationBodyRepair->searchByProgressKetok();
        $progressDempulDataProvider = $registrationBodyRepair->searchByProgressDempul();
        $progressEpoxyDataProvider = $registrationBodyRepair->searchByProgressEpoxy();
        $progressCatDataProvider = $registrationBodyRepair->searchByProgressCat();
        $progressPasangDataProvider = $registrationBodyRepair->searchByProgressPasang();
        $progressPolesDataProvider = $registrationBodyRepair->searchByProgressPoles();
        $progressCuciDataProvider = $registrationBodyRepair->searchByProgressCuci();
        
        $qualityControlBongkarDataProvider = $registrationBodyRepair->searchByQualityControlBongkar();
        $qualityControlSparePartDataProvider = $registrationBodyRepair->searchByQualityControlSparepart();
        $qualityControlKetokDataProvider = $registrationBodyRepair->searchByQualityControlKetok();
        $qualityControlDempulDataProvider = $registrationBodyRepair->searchByQualityControlDempul();
        $qualityControlEpoxyDataProvider = $registrationBodyRepair->searchByQualityControlEpoxy();
        $qualityControlCatDataProvider = $registrationBodyRepair->searchByQualityControlCat();
        $qualityControlPasangDataProvider = $registrationBodyRepair->searchByQualityControlPasang();
        $qualityControlPolesDataProvider = $registrationBodyRepair->searchByQualityControlPoles();
        $qualityControlCuciDataProvider = $registrationBodyRepair->searchByQualityControlCuci();
        
        $finishedBongkarDataProvider = $registrationBodyRepair->searchByFinishedBongkar();
        $finishedSparePartDataProvider = $registrationBodyRepair->searchByFinishedSparepart();
        $finishedKetokDataProvider = $registrationBodyRepair->searchByFinishedKetok();
        $finishedDempulDataProvider = $registrationBodyRepair->searchByFinishedDempul();
        $finishedEpoxyDataProvider = $registrationBodyRepair->searchByFinishedEpoxy();
        $finishedCatDataProvider = $registrationBodyRepair->searchByFinishedCat();
        $finishedPasangDataProvider = $registrationBodyRepair->searchByFinishedPasang();
        $finishedPolesDataProvider = $registrationBodyRepair->searchByFinishedPoles();
        $finishedCuciDataProvider = $registrationBodyRepair->searchByFinishedCuci();

        $this->render('index', array(
            'model' => $model,
            'branchId' => $branchId,
            'employee' => $employee,
            'historyDataProvider' => $historyDataProvider,
            'employeeDataProvider' => $employeeDataProvider,
            'waitlistDataProvider' => $waitlistDataProvider,
            'assignBongkarDataProvider' => $assignBongkarDataProvider,
            'assignSparePartDataProvider' => $assignSparePartDataProvider,
            'assignKetokDataProvider' => $assignKetokDataProvider,
            'assignDempulDataProvider' => $assignDempulDataProvider,
            'assignEpoxyDataProvider' => $assignEpoxyDataProvider,
            'assignCatDataProvider' => $assignCatDataProvider,
            'assignPasangDataProvider' => $assignPasangDataProvider,
            'assignPolesDataProvider' => $assignPolesDataProvider,
            'assignCuciDataProvider' => $assignCuciDataProvider,
            'progressBongkarDataProvider' => $progressBongkarDataProvider,
            'progressSparePartDataProvider' => $progressSparePartDataProvider,
            'progressKetokDataProvider' => $progressKetokDataProvider,
            'progressDempulDataProvider' => $progressDempulDataProvider,
            'progressEpoxyDataProvider' => $progressEpoxyDataProvider,
            'progressCatDataProvider' => $progressCatDataProvider,
            'progressPasangDataProvider' => $progressPasangDataProvider,
            'progressPolesDataProvider' => $progressPolesDataProvider,
            'progressCuciDataProvider' => $progressCuciDataProvider,
            'queueBongkarDataProvider' => $queueBongkarDataProvider,
            'queueSparePartDataProvider' => $queueSparePartDataProvider,
            'queueKetokDataProvider' => $queueKetokDataProvider,
            'queueDempulDataProvider' => $queueDempulDataProvider,
            'queueEpoxyDataProvider' => $queueEpoxyDataProvider,
            'queueCatDataProvider' => $queueCatDataProvider,
            'queuePasangDataProvider' => $queuePasangDataProvider,
            'queuePolesDataProvider' => $queuePolesDataProvider,
            'queueCuciDataProvider' => $queueCuciDataProvider,
            'qualityControlBongkarDataProvider' => $qualityControlBongkarDataProvider,
            'qualityControlSparePartDataProvider' => $qualityControlSparePartDataProvider,
            'qualityControlKetokDataProvider' => $qualityControlKetokDataProvider,
            'qualityControlDempulDataProvider' => $qualityControlDempulDataProvider,
            'qualityControlEpoxyDataProvider' => $qualityControlEpoxyDataProvider,
            'qualityControlCatDataProvider' => $qualityControlCatDataProvider,
            'qualityControlPasangDataProvider' => $qualityControlPasangDataProvider,
            'qualityControlPolesDataProvider' => $qualityControlPolesDataProvider,
            'qualityControlCuciDataProvider' => $qualityControlCuciDataProvider,
            'finishedBongkarDataProvider' => $finishedBongkarDataProvider,
            'finishedSparePartDataProvider' => $finishedSparePartDataProvider,
            'finishedKetokDataProvider' => $finishedKetokDataProvider,
            'finishedDempulDataProvider' => $finishedDempulDataProvider,
            'finishedEpoxyDataProvider' => $finishedEpoxyDataProvider,
            'finishedCatDataProvider' => $finishedCatDataProvider,
            'finishedPasangDataProvider' => $finishedPasangDataProvider,
            'finishedPolesDataProvider' => $finishedPolesDataProvider,
            'finishedCuciDataProvider' => $finishedCuciDataProvider,
        ));
    }

    public function actionAssignMechanic($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registration = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
        $vehicle = $registration->vehicle;
        $priorityLevel = isset($_GET['PriorityLevel']) ? $_GET['PriorityLevel'] : '';
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';

        $registrationService = new RegistrationService('search');
        $registrationService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationService'])) {
            $registrationService->attributes = $_GET['RegistrationService'];
        }
        $registrationServiceCriteria = new CDbCriteria;
        $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationBodyRepairDetail->registration_transaction_id . ' AND is_body_repair = 1 ';
        $registrationServiceDataProvider = new CActiveDataProvider('RegistrationService', array(
            'criteria' => $registrationServiceCriteria,
        ));

        $registrationDamage = new RegistrationDamage('search');
        $registrationDamage->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationDamage'])) {
            $registrationDamage->attributes = $_GET['RegistrationDamage'];
        }
        $registrationDamageCriteria = new CDbCriteria;
        $registrationDamageCriteria->condition = 'registration_transaction_id = ' . $registrationBodyRepairDetail->registration_transaction_id;
        $registrationDamageDataProvider = new CActiveDataProvider('RegistrationDamage', array(
            'criteria' => $registrationDamageCriteria,
        ));
//
//        $registrationBodyRepairDetail = new RegistrationBodyRepairDetail('search');
//        $registrationBodyRepairDetail->unsetAttributes();  // clear any default values
//        if (isset($_GET['RegistrationBodyRepairDetail'])) {
//            $registrationBodyRepairDetail->attributes = $_GET['RegistrationBodyRepairDetail'];
//        }
//        $registrationBodyRepairDetailCriteria = new CDbCriteria;
//        $registrationBodyRepairDetailCriteria->condition = 'registration_transaction_id = ' . $registrationId;
//        $registrationBodyRepairDetailDataProvider = new CActiveDataProvider('RegistrationBodyRepairDetail', array(
//            'criteria' => $registrationBodyRepairDetailCriteria,
//        ));

        if (isset($_POST['SubmitMemo'])) {
            $registration->priority_level = $_POST['PriorityLevel'];
            $registration->update(array('priority_level'));

            if (!empty($_POST['Memo'])) {
                $registrationMemo = new RegistrationMemo();
                $registrationMemo->registration_transaction_id = $registrationBodyRepairDetail->registration_transaction_id;
                $registrationMemo->memo = $_POST['Memo'];
                $registrationMemo->date_time = date('Y-m-d H:i:s');
                $registrationMemo->user_id = Yii::app()->user->id;
                $registrationMemo->save();
            }
        } elseif (isset($_POST['Submit'])) {
//            foreach ($registration->registrationBodyRepairDetails as $i => $registrationBodyRepairDetail) {
                $registrationBodyRepairDetail->mechanic_assigned_id = $_POST['RegistrationBodyRepairDetail']['mechanic_assigned_id'];
                $registrationBodyRepairDetail->update(array('mechanic_assigned_id'));
//            }
            
            $registration->status = 'Assigned';
            
            if ($registration->update(array('status'))) {
                $this->redirect(array('index'));
            }
        }

        $this->render('assignMechanic', array(
            'registration' => $registration,
            'registrationBodyRepairDetail' => $registrationBodyRepairDetail,
//            'registrationBodyRepairDetailDataProvider' => $registrationBodyRepairDetailDataProvider,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
            'vehicle' => $vehicle,
            'memo' => $memo,
            'priorityLevel' => $priorityLevel,
        ));
    }

    public function actionCheckQuality($registrationId) {
        $registration = RegistrationTransaction::model()->findByPk($registrationId);
        $vehicle = Vehicle::model()->findByPk($registration->vehicle_id);
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $priorityLevel = isset($_GET['PriorityLevel']) ? $_GET['PriorityLevel'] : '';

        $registrationService = new RegistrationService('search');
        $registrationService->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationService'])) {
            $registrationService->attributes = $_GET['RegistrationService'];
        }
        $registrationServiceCriteria = new CDbCriteria;
        $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationId . ' AND is_body_repair = 1 ';
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

//        $registrationBodyRepairDetail = new RegistrationBodyRepairDetail('search');
//        $registrationBodyRepairDetail->unsetAttributes();  // clear any default values
//        if (isset($_GET['RegistrationBodyRepairDetail'])) {
//            $registrationBodyRepairDetail->attributes = $_GET['RegistrationBodyRepairDetail'];
//        }
//        $registrationBodyRepairDetailCriteria = new CDbCriteria;
//        $registrationBodyRepairDetailCriteria->condition = 'registration_transaction_id = ' . $registrationId;
//        $registrationBodyRepairDetailDataProvider = new CActiveDataProvider('RegistrationBodyRepairDetail', array(
//            'criteria' => $registrationBodyRepairDetailCriteria,
//        ));

        $registrationBodyRepairDetails = RegistrationBodyRepairDetail::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id));
        $runningDetail = $this->loadRunningDetail($registrationBodyRepairDetails);
        $bodyRepairManagement = new BodyRepairManagement($registration, $runningDetail);

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
//            if ($_POST['_FormSubmit_'] === 'SubmitMemo') {
                $registrationMemo = new RegistrationMemo();
                $registrationMemo->registration_transaction_id = $registrationId;
                $registrationMemo->memo = $_POST['Memo'];
                $registrationMemo->date_time = date('Y-m-d H:i:s');
                $registrationMemo->user_id = Yii::app()->user->id;
                $registrationMemo->save();
//            }
        } else if (isset($_POST['SubmitPass']) || isset($_POST['SubmitFail'])) {
            if ($bodyRepairManagement->runningDetail !== null) {
                $bodyRepairManagement->runningDetail->is_passed = isset($_POST['SubmitPass']);
                
                if ($bodyRepairManagement->save(Yii::app()->db)) {
                    $this->redirect(array('index'));
                }
            }
        }

        $this->render('checkQuality', array(
            'registration' => $registration,
            'runningDetail' => $runningDetail,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
            'vehicle' => $vehicle,
            'memo' => $memo,
            'priorityLevel' => $priorityLevel,
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
        $registrationServiceCriteria->condition = 'registration_transaction_id = ' . $registrationId . ' AND is_body_repair = 1 ';
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

        $registrationBodyRepairDetails = RegistrationBodyRepairDetail::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id));
        $runningDetail = $this->loadRunningDetail($registrationBodyRepairDetails);
        $runningDetailTimesheet = $this->loadRunningDetailTimesheet($runningDetail);
        $bodyRepairMechanic = new BodyRepairMechanic($registration, $runningDetail, $runningDetailTimesheet);

        if (isset($_POST['_FormSubmit_'])) {
            if ($_POST['_FormSubmit_'] === 'SubmitMemo' && !empty($_POST['Memo'])) {
                $registrationMemo = new RegistrationMemo();
                $registrationMemo->registration_transaction_id = $registrationId;
                $registrationMemo->memo = $_POST['Memo'];
                $registrationMemo->date_time = date('Y-m-d H:i:s');
                $registrationMemo->user_id = Yii::app()->user->id;
                $registrationMemo->save();
            }
        } else if (isset($_POST['StartOrPauseTimesheet']) || isset($_POST['FinishTimesheet'])) {
            if ($bodyRepairMechanic->runningDetail !== null) {
                $mechanicId = $bodyRepairMechanic->runningDetail->mechanic_id;
                if ($mechanicId === null || $mechanicId !== null && $mechanicId === Yii::app()->user->id) {
                    if (isset($_POST['FinishTimesheet'])) {
                        $bodyRepairMechanic->runningDetail->to_be_checked = true;
                    }
                    if ($mechanicId === null) {
                        $bodyRepairMechanic->runningDetail->mechanic_id = Yii::app()->user->id;
                    }
                    if ($bodyRepairMechanic->save(Yii::app()->db)) {
                        if ($bodyRepairMechanic->runningDetailTimesheet->finish_date_time !== null) {
                            $runningDetail = $this->loadRunningDetail($registrationBodyRepairDetails);
                            $runningDetailTimesheet = $this->loadRunningDetailTimesheet($runningDetail);
                            $bodyRepairMechanic->runningDetail = $runningDetail;
                            $bodyRepairMechanic->runningDetailTimesheet = $runningDetailTimesheet;
                        }
                    }
                }
            }
        }

        $this->render('viewDetailWorkOrder', array(
            'bodyRepairManagement' => $bodyRepairMechanic,
            'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
            'registration' => $registration,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamage' => $registrationDamage,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
            'vehicle' => $vehicle,
            'memo' => $memo,
        ));
    }

    public function actionViewEmployeeDetail($employeeId) {
        $employee = Employee::model()->findByPk($employeeId);
        $employeeBranchDivisionPositionLevel = EmployeeBranchDivisionPositionLevel::model()->findByAttributes(array('employee_id' => $employeeId));

        $registrationBodyRepairDetail = Search::bind(new RegistrationBodyRepairDetail('search'), isset($_GET['RegistrationBodyRepairDetail']) ? $_GET['RegistrationBodyRepairDetail'] : '');

        $registrationBodyRepairHistoryDataProvider = $registrationBodyRepairDetail->search();
        $registrationBodyRepairHistoryDataProvider->criteria->together = 'true';
        $registrationBodyRepairHistoryDataProvider->criteria->with = array('registrationTransaction');
        $registrationBodyRepairHistoryDataProvider->criteria->addCondition("registrationTransaction.service_status = 'Finish' AND registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL");
        $registrationBodyRepairHistoryDataProvider->criteria->compare('t.mechanic_id', $employeeId);
        $registrationBodyRepairHistoryDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $registrationBodyRepairAssignmentDataProvider = $registrationBodyRepairDetail->search();
        $registrationBodyRepairAssignmentDataProvider->criteria->together = 'true';
        $registrationBodyRepairAssignmentDataProvider->criteria->with = array('registrationTransaction');
        $registrationBodyRepairAssignmentDataProvider->criteria->addCondition("registrationTransaction.service_status != 'Finished' AND registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL");
        $registrationBodyRepairAssignmentDataProvider->criteria->compare('t.mechanic_assigned_id', $employeeId);
        $registrationBodyRepairAssignmentDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $this->render('viewEmployeeDetail', array(
            'employee' => $employee,
            'employeeBranchDivisionPositionLevel' => $employeeBranchDivisionPositionLevel,
            'registrationBodyRepairHistoryDataProvider' => $registrationBodyRepairHistoryDataProvider,
            'registrationBodyRepairAssignmentDataProvider' => $registrationBodyRepairAssignmentDataProvider,
//            'branchId' => $branchId,
        ));
    }

    public function actionProceedToQueue($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        $model->status = 'Queue Bongkar Pasang';
        
        if ($model->update(array('status'))) {
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingBongkar($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Bongkar Pasang - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingSparepart($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Spare Part - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingKetok($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Las Ketok - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingDempul($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Dempul - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingEpoxy($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Epoxy - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingCat($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Cat - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingPasang($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Finishing - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingCuci($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Cuci - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionStartProcessingPoles($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Poles - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlBongkar($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Bongkar Pasang - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlSparepart($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Spare Part - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlKetok($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Las Ketok - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlDempul($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Dempul - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlEpoxy($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Epoxy - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlCat($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Cat - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlPasang($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Finishing - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlCuci($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Cuci - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlPoles($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = 'Poles - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function loadRunningDetail($registrationBodyRepairDetails) {
        $runningDetail = null;
        foreach ($registrationBodyRepairDetails as $registrationBodyRepairDetail) {
            $toBeChecked = $registrationBodyRepairDetail->to_be_checked;
            $isPassed = $registrationBodyRepairDetail->is_passed;
            if ($toBeChecked && !$isPassed) {
                if ($runningDetail === null) {
                    $runningDetail = $registrationBodyRepairDetail;
                    break;
                }
            }
        }

        return $runningDetail;
    }

}
