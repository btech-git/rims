<?php

class IdleManagementController extends Controller
{
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
            $filterChain->action->id === 'viewHeadWorkOrder' || 
            $filterChain->action->id === 'viewEmployeeDetail'
        ) {
            if (!(Yii::app()->user->checkAccess('maintenanceMechanicHead')))
                $this->redirect(array('/site/login'));
        }
        
        if (
            $filterChain->action->id === 'indexMechanic' || 
            $filterChain->action->id === 'viewDetailWorkOrder' || 
            $filterChain->action->id === 'viewEmployeeDetail'
        ) {
            if (!(Yii::app()->user->checkAccess('maintenanceMechanicStaff')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionIndexMechanic()
    {
        $registrationTransactionStatus = (isset($_GET['RegistrationTransactionStatus'])) ? $_GET['RegistrationTransactionStatus'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $modelDataProvider = $model->searchByIdleManagement();
        
        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');
        $registrationServiceDataProvider = $registrationService->search();
        $registrationServiceDataProvider->criteria->together = 'true';
        $registrationServiceDataProvider->criteria->with = array('registrationTransaction');
        $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.status = 'Finished' AND registrationTransaction.repair_type = 'GR'");
        $registrationServiceDataProvider->criteria->compare('t.start_mechanic_id', Yii::app()->user->id);
        $registrationServiceDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);
        $registrationServiceDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $this->render('indexMechanic', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'branchId' => $branchId,
        ));
    }
    
    public function actionIndexHead()
    {
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $mechanicId = isset($_GET['MechanicId']) ? $_GET['MechanicId'] : '';
        $startMechanic = empty($model->start_mechanic_id) ? '' : Users::model()->findByPk($model->start_mechanic_id);
        
        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $modelDataProvider = $model->searchByIdleManagement();
//        $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.status != 'Finished'");
//        $modelDataProvider->criteria->compare('t.work_order_number',$model->work_order_number,true);
//        $modelDataProvider->criteria->compare('t.branch_id',$model->branch_id);
//        $modelDataProvider->criteria->compare('t.status', $model->status, true);
//        $modelDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC, t.vehicle_id ASC';
        
        $registrationService = Search::bind(new RegistrationService('search'), isset($_GET['RegistrationService']) ? $_GET['RegistrationService'] : '');
        $registrationServiceDataProvider = $registrationService->search();
        $registrationServiceDataProvider->criteria->together = 'true';
        $registrationServiceDataProvider->criteria->with = array('registrationTransaction');
        $registrationServiceDataProvider->criteria->addCondition("registrationTransaction.status = 'Finished' AND registrationTransaction.repair_type = 'GR'");
        $registrationServiceDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);
        $registrationServiceDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

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
        
        $this->render('indexHead', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'startMechanic' => $startMechanic,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
            'branchId' => $branchId,
            'mechanicId' => $mechanicId,
        ));
    }
    
    public function actionViewHeadWorkOrder($registrationId)
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
        $registrationServiceCriteria->compare('id', $registrationService->id);
        $registrationServiceCriteria->compare('registration_transaction_id', $registrationId);
        $registrationServiceCriteria->compare('service_id', $registrationService->service_id);
        $registrationServiceCriteria->compare('claim', $registrationService->claim, true);
        $registrationServiceCriteria->compare('is_quick_service', $registrationService->is_quick_service);
        $registrationServiceCriteria->compare('start', $registrationService->start, true);
        $registrationServiceCriteria->compare('end', $registrationService->end, true);
        $registrationServiceCriteria->compare('note', $registrationService->note, true);
        $registrationServiceCriteria->compare('is_body_repair', $registrationService->is_body_repair);
        $registrationServiceCriteria->compare('LOWER(status)', strtolower($registrationService->status), false);
        $registrationServiceCriteria->compare('start_mechanic_id', $registrationService->start_mechanic_id);
        $registrationServiceCriteria->compare('finish_mechanic_id', $registrationService->finish_mechanic_id);
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
        
            if (isset($_POST['Submit'])) {
                foreach($registration->registrationServices as $i => $registrationService) {
                    $registrationService->assign_mechanic_id = $_POST['RegistrationService'][$i]['assign_mechanic_id'];
                    $registrationService->update(array('assign_mechanic_id'));
                }
            } elseif (isset($_POST['Save'])) {
                $registration->is_passed = $_POST['RegistrationTransaction']['is_passed'];
                $registration->priority_level = $_POST['RegistrationTransaction']['priority_level'];
                $registration->update(array('is_passed', 'priority_level'));

                if (!empty($_POST['Memo'])) {
                    $registrationMemo = new RegistrationMemo();
                    $registrationMemo->registration_transaction_id = $registrationId;
                    $registrationMemo->memo = $_POST['Memo'];
                    $registrationMemo->date_time = date('Y-m-d H:i:s');
                    $registrationMemo->user_id = Yii::app()->user->id;
                    $registrationMemo->save();
                }
            }

        $this->render('viewHeadWorkOrder', array(
            'registration' => $registration,
            'registrationService' => $registrationService,
            'registrationServiceDataProvider' => $registrationServiceDataProvider,
            'registrationQuickService' => $registrationQuickService,
            'registrationQuickServiceDataProvider' => $registrationQuickServiceDataProvider,
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
    public function actionWorkOrderStartService($serviceId, $registrationId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->start = date('Y-m-d H:i:s');
            $registrationService->status = 'On Progress';
            $registrationService->start_mechanic_id = Yii::app()->user->id;

            //Ada error di bagian ini
            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'service_id' => $serviceId,
            ));
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->id;
            $real->detail = 'On Progress (Update From Idle Management)';
            $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

            $registrationService->save();

            $model = $this->loadModel($registrationId);
            $model->status = 'On Progress';
            $model->save();
        }
    }

    /**
     * Start Pause Service.
     */
    public function actionWorkOrderPauseService($serviceId, $registrationId)
    {
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
    public function actionWorkOrderResumeService($serviceId, $registrationId)
    {
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

    public function actionWorkOrderFinishService($serviceId, $registrationId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationService = RegistrationService::model()->findByAttributes(array(
                'service_id' => $serviceId,
                'registration_transaction_id' => $registrationId
            ));
            $registrationService->end = date('Y-m-d H:i:s');
            $registrationService->status = 'Finished';
            $registrationService->finish_mechanic_id = Yii::app()->user->id;

            $transaction = RegistrationTransaction::model()->findByPk($registrationId);

            if ($transaction->repair_type == 'GR') {
                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                    'registration_transaction_id' => $registrationId,
                    'service_id' => $registrationService->service_id
                ));
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = Yii::app()->user->id;
                $real->detail = 'Finished (Update From Idle Management)';
                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
            } else {
                if ($registrationService->is_body_repair == 1) {
                    $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                        'registration_transaction_id' => $registrationId,
                        'service_id' => $registrationService->service_id
                    ));
                    $real->checked = 1;
                    $real->checked_date = date('Y-m-d');
                    $real->checked_by = Yii::app()->user->id;
                    $real->detail = 'Finished (Update From Idle Management)';
                    $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
                }
            }
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
    
    public function actionAjaxHtmlUpdateMechanicWaitlistTable()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $modelDataProvider = $model->search();
            $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.status != 'Finished'");

            $this->renderPartial('_mechanicWaitlistTable', array(
                'model' => $model,
                'modelDataProvider' => $modelDataProvider,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateHeadWaitlistTable()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $modelDataProvider = $model->search();
            $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'GR' AND t.status != 'Finished'");

            $this->renderPartial('_headWaitlistTable', array(
                'model' => $model,
                'modelDataProvider' => $modelDataProvider,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateTransactionHistoryTable()
	{
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
    
    public function loadModel($id)
    {
        $model = RegistrationTransaction::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

}