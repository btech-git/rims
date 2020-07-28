<?php

class BodyRepairManagementController extends Controller
{
    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'assignMechanic' || 
            $filterChain->action->id === 'checkQuality' || 
            $filterChain->action->id === 'viewDetailWorkOrder' || 
            $filterChain->action->id === 'viewEmployeeDetail'
        ) {
            if (!(Yii::app()->user->checkAccess('bodyRepairMechanicStaff')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Idle Management.
     */
    public function actionIndex()
    {
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        
        $waitlistDataProvider = $model->search();
        $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Bongkar - Pending'");
        $waitlistDataProvider->criteria->compare('t.work_order_number',$model->work_order_number,true);
        $waitlistDataProvider->criteria->compare('t.branch_id',$model->branch_id);
        $waitlistDataProvider->criteria->compare('t.status', $model->status, true);
        $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date ASC';
        
        $historyDataProvider = $model->search();
        $historyDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Finish'");
        $historyDataProvider->criteria->compare('t.work_order_number',$model->work_order_number,true);
        $historyDataProvider->criteria->compare('t.branch_id',$model->branch_id);
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
        
        $progressBongkarDataProvider = $model->search();
        $progressBongkarDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Bongkar - Checking'");
        $progressBongkarDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressSparePartDataProvider = $model->search();
        $progressSparePartDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Sparepart - Checking'");
        $progressSparePartDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressKetokDataProvider = $model->search();
        $progressKetokDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Ketok/Las - Checking'");
        $progressKetokDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressDempulDataProvider = $model->search();
        $progressDempulDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Dempul - Checking'");
        $progressDempulDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressEpoxyDataProvider = $model->search();
        $progressEpoxyDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Epoxy - Checking'");
        $progressEpoxyDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressCatDataProvider = $model->search();
        $progressCatDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Cat - Checking'");
        $progressCatDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressPasangDataProvider = $model->search();
        $progressPasangDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Pasang - Checking'");
        $progressPasangDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressPolesDataProvider = $model->search();
        $progressPolesDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Poles - Checking'");
        $progressPolesDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
        $progressCuciDataProvider = $model->search();
        $progressCuciDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Cuci - Checking'");
        $progressCuciDataProvider->criteria->order = 't.work_order_date DESC, t.vehicle_id ASC';
        
//        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');
//        $registrationServiceDataProvider = $registrationService->search();
//        $registrationServiceDataProvider->criteria->together = 'true';
//        $registrationServiceDataProvider->criteria->with = array('registrationTransaction');
//        $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.status = 'Finished' AND registrationTransaction.repair_type = 'BR'");
//		$registrationServiceDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);
//        $registrationServiceDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $this->render('index', array(
            'model' => $model,
            'waitlistDataProvider' => $waitlistDataProvider,
            'historyDataProvider' => $historyDataProvider,
//            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
            'progressBongkarDataProvider' => $progressBongkarDataProvider,
            'progressSparePartDataProvider' => $progressSparePartDataProvider,
            'progressKetokDataProvider' => $progressKetokDataProvider,
            'progressDempulDataProvider' => $progressDempulDataProvider,
            'progressEpoxyDataProvider' => $progressEpoxyDataProvider,
            'progressCatDataProvider' => $progressCatDataProvider,
            'progressPasangDataProvider' => $progressPasangDataProvider,
            'progressPolesDataProvider' => $progressPolesDataProvider,
            'progressCuciDataProvider' => $progressCuciDataProvider,
            'branchId' => $branchId,
        ));
    }
    
    public function actionAssignMechanic($registrationId)
    {
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
        
        $registrationBodyRepairDetail = new RegistrationBodyRepairDetail('search');
        $registrationBodyRepairDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationBodyRepairDetail'])) {
            $registrationBodyRepairDetail->attributes = $_GET['RegistrationBodyRepairDetail'];
        }
        $registrationBodyRepairDetailCriteria = new CDbCriteria;
        $registrationBodyRepairDetailCriteria->condition = 'registration_transaction_id = ' . $registrationId;
        $registrationBodyRepairDetailDataProvider = new CActiveDataProvider('RegistrationBodyRepairDetail', array(
            'criteria' => $registrationBodyRepairDetailCriteria,
        ));
        
        if (isset($_POST['SubmitMemo'])) {
            $registration->priority_level = $_POST['RegistrationTransaction']['priority_level'];
            $registration->update(array('priority_level'));

            if (!empty($_POST['Memo'])) {
                $registrationMemo = new RegistrationMemo();
                $registrationMemo->registration_transaction_id = $registrationId;
                $registrationMemo->memo = $_POST['Memo'];
                $registrationMemo->date_time = date('Y-m-d H:i:s');
                $registrationMemo->user_id = Yii::app()->user->id;
                $registrationMemo->save();
            }
        } elseif (isset($_POST['Submit'])) {
            foreach($registration->registrationBodyRepairDetails as $i => $registrationBodyRepairDetail) {
                $registrationBodyRepairDetail->mechanic_assigned_id = $_POST['RegistrationBodyRepairDetail'][$i]['mechanic_assigned_id'];
                $registrationBodyRepairDetail->update(array('mechanic_assigned_id'));
            }
        }

        $this->render('assignMechanic', array(
            'registration' => $registration,
            'registrationBodyRepairDetailDataProvider' => $registrationBodyRepairDetailDataProvider,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationDamageDataProvider' => $registrationDamageDataProvider,
            'vehicle' => $vehicle,
            'memo' => $memo,
        ));
    }

    public function actionCheckQuality($registrationId)
    {
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
        
        $registrationBodyRepairDetail = new RegistrationBodyRepairDetail('search');
        $registrationBodyRepairDetail->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationBodyRepairDetail'])) {
            $registrationBodyRepairDetail->attributes = $_GET['RegistrationBodyRepairDetail'];
        }
        $registrationBodyRepairDetailCriteria = new CDbCriteria;
        $registrationBodyRepairDetailCriteria->condition = 'registration_transaction_id = ' . $registrationId;
        $registrationBodyRepairDetailDataProvider = new CActiveDataProvider('RegistrationBodyRepairDetail', array(
            'criteria' => $registrationBodyRepairDetailCriteria,
        ));
        
        $registrationBodyRepairDetails = RegistrationBodyRepairDetail::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id));
        $runningDetail = $this->loadRunningDetail($registrationBodyRepairDetails);
        $bodyRepairManagement = new BodyRepairManagement($registration, $runningDetail);
        
        if (isset($_POST['_FormSubmit_'])) {
            if ($_POST['_FormSubmit_'] === 'SubmitMemo' && !empty($_POST['Memo'])) {
                $registrationMemo = new RegistrationMemo();
                $registrationMemo->registration_transaction_id = $registrationId;
                $registrationMemo->memo = $_POST['Memo'];
                $registrationMemo->date_time = date('Y-m-d H:i:s');
                $registrationMemo->user_id = Yii::app()->user->id;
                $registrationMemo->save();
            }
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
        ));
    }
    
    public function actionViewDetailWorkOrder($registrationId)
    {
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

    public function loadModel($id)
    {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function loadRunningDetail($registrationBodyRepairDetails) 
    {
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