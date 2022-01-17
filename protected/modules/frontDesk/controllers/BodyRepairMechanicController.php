<?php

class BodyRepairMechanicController extends Controller {

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
            $filterChain->action->id === 'workOrderFinishService' ||
            $filterChain->action->id === 'workOrderPauseService' ||
            $filterChain->action->id === 'workOrderResumeService' ||
            $filterChain->action->id === 'workOrderStartService'
        ) {
            if (!(Yii::app()->user->checkAccess('brMechanicCreate')) || !(Yii::app()->user->checkAccess('brMechanicEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionIndex() {
//        $user = Users::model()->findByPk(Yii::app()->user->id);
//        $employee = Employee::model()->findByPk($user->employee_id);
        $carMakeName = (isset($_GET['CarMakeName'])) ? $_GET['CarMakeName'] : '';
        $carModelName = (isset($_GET['CarModelName'])) ? $_GET['CarModelName'] : '';
        $workOrderDate = (isset($_GET['WorkOrderDate'])) ? $_GET['WorkOrderDate'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $workOrderNumber = (isset($_GET['WorkOrderNumber'])) ? $_GET['WorkOrderNumber'] : '';

//        $employeeBDPL = EmployeeBranchDivisionPositionLevel::model()->findByAttributes(array('employee_id' => $employee->id));
//        $processName = $this->getProcessNameByLevelId($employeeBDPL->level_id);

//        $waitlistStatusCondition = '';
//        $waitlistStatusParams = array(); // $registrationProgressStatusParams = array(':mechanic_id' => ...);
//        if ($processName !== 'All') {
//            $waitlistStatusCondition = ' AND t.service_status = :service_status';
//            $waitlistStatusParams[':service_status'] = $processName . ' - Pending';
//        }

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');

        $waitlistDataProvider = $model->search();
        $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Bongkar - Pending' AND t.status = 'Waitlist'");
        $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

        $registrationBodyRepairDetail = Search::bind(new RegistrationBodyRepairDetail('search'), isset($_GET['RegistrationBodyRepairDetail']) ? $_GET['RegistrationBodyRepairDetail'] : '');

        $queueBongkarDataProvider = $registrationBodyRepairDetail->searchByQueueBongkar();
        $queueSparePartDataProvider = $registrationBodyRepairDetail->searchByQueueSparePart();
        $queueKetokDataProvider = $registrationBodyRepairDetail->searchByQueueKetok();
        $queueDempulDataProvider = $registrationBodyRepairDetail->searchByQueueDempul();
        $queueEpoxyDataProvider = $registrationBodyRepairDetail->searchByQueueEpoxy();
        $queueCatDataProvider = $registrationBodyRepairDetail->searchByQueueCat();
        $queuePasangDataProvider = $registrationBodyRepairDetail->searchByQueuePasang();
        $queuePolesDataProvider = $registrationBodyRepairDetail->searchByQueuePoles();
        $queueCuciDataProvider = $registrationBodyRepairDetail->searchByQueueCuci();
        
        $registrationAssignmentDataProvider = $registrationBodyRepairDetail->search();
        $registrationAssignmentDataProvider->criteria->together = 'true';
        $registrationAssignmentDataProvider->criteria->with = array('registrationTransaction');
        $registrationAssignmentDataProvider->criteria->addCondition("registrationTransaction.service_status != 'Finished' AND registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL AND t.mechanic_id IS NULL");
        $registrationAssignmentDataProvider->criteria->compare('t.mechanic_assigned_id', Yii::app()->user->id);
        $registrationAssignmentDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $registrationProgressDataProvider = $registrationBodyRepairDetail->search();
        $registrationProgressDataProvider->criteria->together = 'true';
        $registrationProgressDataProvider->criteria->with = array('registrationTransaction');
        $registrationProgressDataProvider->criteria->addCondition("registrationTransaction.service_status != 'Finished' AND registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL AND t.mechanic_assigned_id IS NOT NULL AND t.finish_date_time IS NULL");
        $registrationProgressDataProvider->criteria->compare('t.mechanic_id', Yii::app()->user->id);
        $registrationProgressDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $qualityControlDataProvider = $registrationBodyRepairDetail->search();
        $qualityControlDataProvider->criteria->together = 'true';
        $qualityControlDataProvider->criteria->with = array('registrationTransaction');
        $qualityControlDataProvider->criteria->addCondition("registrationTransaction.service_status != 'Finished' AND registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL AND t.to_be_checked = 1 AND t.is_passed = 0");
        $qualityControlDataProvider->criteria->compare('t.mechanic_id', Yii::app()->user->id);
        $qualityControlDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        $registrationHistoryDataProvider = $registrationBodyRepairDetail->search();
        $registrationHistoryDataProvider->criteria->together = 'true';
        $registrationHistoryDataProvider->criteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'vehicle' => array(
                        'with' => array(
                            'carMake', 
                            'carModel',
                        ),
                    ), 
                ),
            ),
        );
        $registrationHistoryDataProvider->criteria->addCondition("registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL AND t.to_be_checked = 1 AND t.is_passed = 1");
        $registrationHistoryDataProvider->criteria->compare('t.mechanic_id', Yii::app()->user->id);
        $registrationHistoryDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

        if (!empty($plateNumber)) {
            $registrationHistoryDataProvider->criteria->compare('vehicle.plate_number', $plateNumber, true);
        }
        
        if (!empty($carMakeName)) {
            $registrationHistoryDataProvider->criteria->compare('carMake.name', $carMakeName, true);
        }
        
        if (!empty($carModelName)) {
            $registrationHistoryDataProvider->criteria->compare('carModel.name', $carModelName, true);
        }
        
        if (!empty($branchId)) {
            $registrationHistoryDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);
        }
        
        if (!empty($workOrderNumber)) {
            $registrationHistoryDataProvider->criteria->compare('registrationTransaction.work_order_number', $workOrderNumber, true);
        }
        
        if (!empty($workOrderDate)) {
            $registrationHistoryDataProvider->criteria->compare('registrationTransaction.work_order_date', $workOrderDate);
        }
        
        $this->render('index', array(
            'model' => $model,
            'branchId' => $branchId,
            'carMakeName' => $carMakeName,
            'carModelName' => $carModelName,
            'workOrderDate' => $workOrderDate,
            'plateNumber' => $plateNumber,
            'workOrderNumber' => $workOrderNumber,
            'registrationBodyRepairDetail' => $registrationBodyRepairDetail,
            'waitlistDataProvider' => $waitlistDataProvider,
            'queueBongkarDataProvider' => $queueBongkarDataProvider,
            'queueSparePartDataProvider' => $queueSparePartDataProvider,
            'queueKetokDataProvider' => $queueKetokDataProvider,
            'queueDempulDataProvider' => $queueDempulDataProvider,
            'queueEpoxyDataProvider' => $queueEpoxyDataProvider,
            'queueCatDataProvider' => $queueCatDataProvider,
            'queuePasangDataProvider' => $queuePasangDataProvider,
            'queuePolesDataProvider' => $queuePolesDataProvider,
            'queueCuciDataProvider' => $queueCuciDataProvider,
            'qualityControlDataProvider' => $qualityControlDataProvider,
            'registrationAssignmentDataProvider' => $registrationAssignmentDataProvider,
            'registrationProgressDataProvider' => $registrationProgressDataProvider,
            'registrationHistoryDataProvider' => $registrationHistoryDataProvider,
        ));
    }

    public function getProcessNameByLevelId($levelId) {
        $processName = '';
        if ((int) $levelId === 8) {
            $processName = 'Bongkar';
        } else if ((int) $levelId === 9) {
            $processName = 'KetokLas';
        } else if ((int) $levelId === 10) {
            $processName = 'Dempul';
        } else if ((int) $levelId === 11) {
            $processName = 'Epoxy';
        } else if ((int) $levelId === 12) {
            $processName = 'Cat';
        } else if ((int) $levelId === 13) {
            $processName = 'Pasang';
        } else if ((int) $levelId === 14) {
            $processName = 'Cuci';
        } else if ((int) $levelId === 15) {
            $processName = 'Poles';
        } else if ((int) $levelId === 16) {
            $processName = 'All';
        }
        return $processName;
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

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $registrationId;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
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
            'registrationHistories' => $registrationHistories,
            'vehicle' => $vehicle,
            'memo' => $memo,
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

            //Ada error di bagian ini
            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registrationId,
                'service_id' => $serviceId,
//                'name' => $registrationService->service->name
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

    public function actionProceedToQueue($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        $model->status = 'Queue Bongkar';
        
        if ($model->update(array('status'))) {
            $this->redirect(array('index'));
        }
    }
    
    public function actionProceedToAssignedMechanic($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->mechanic_assigned_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('mechanic_assigned_id'))) {
//            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
//            $registrationTransaction->service_status = 'Bongkar Pasang - Started';
//            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
    }
    
    public function actionProceedToProgressMechanic($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->start_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->mechanic_id = Yii::app()->user->id;
        
        if ($registrationBodyRepairDetail->update(array('start_date_time', 'mechanic_id'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = $registrationBodyRepairDetail->service_name . ' - Started';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionProceedToQualityControlMechanic($id) {
        $registrationBodyRepairDetail = RegistrationBodyRepairDetail::model()->findByPk($id);
        $registrationBodyRepairDetail->finish_date_time = date('Y-m-d H:i:s');
        $registrationBodyRepairDetail->total_time = (strtotime($registrationBodyRepairDetail->finish_date_time) - strtotime($registrationBodyRepairDetail->start_date_time)) / 60;
        $registrationBodyRepairDetail->to_be_checked = 1;
        
        if ($registrationBodyRepairDetail->update(array('finish_date_time', 'total_time', 'to_be_checked'))) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationBodyRepairDetail->registration_transaction_id);
            $registrationTransaction->service_status = $registrationBodyRepairDetail->service_name . ' - Checking';
            $registrationTransaction->update(array('service_status'));
            
            $this->redirect(array('index'));
        }
        
    }
    
    public function actionAjaxHtmlUpdateMechanicWaitlistTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $waitlistDataProvider = $model->search();
            $waitlistDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.repair_type = 'BR' AND t.service_status = 'Bongkar - Pending' AND t.status = 'Waitlist'");
            $waitlistDataProvider->criteria->order = 't.priority_level ASC, t.work_order_date DESC';

            $this->renderPartial('_mechanicWaitlistTable', array(
                'model' => $model,
                'waitlistDataProvider' => $waitlistDataProvider,
            ));
        }
    }

    public function actionAjaxHtmlUpdateTransactionHistoryTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $carMakeName = (isset($_GET['CarMakeName'])) ? $_GET['CarMakeName'] : '';
            $carModelName = (isset($_GET['CarModelName'])) ? $_GET['CarModelName'] : '';
            $workOrderDate = (isset($_GET['WorkOrderDate'])) ? $_GET['WorkOrderDate'] : '';
            $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
            $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
            $workOrderNumber = (isset($_GET['WorkOrderNumber'])) ? $_GET['WorkOrderNumber'] : '';

            $registrationBodyRepairDetail = Search::bind(new RegistrationBodyRepairDetail('search'), isset($_GET['RegistrationBodyRepairDetail']) ? $_GET['RegistrationBodyRepairDetail'] : '');

            $registrationHistoryDataProvider = $registrationBodyRepairDetail->search();
            $registrationHistoryDataProvider->criteria->together = 'true';
            $registrationHistoryDataProvider->criteria->with = array(
                'registrationTransaction' => array(
                    'with' => array(
                        'vehicle' => array(
                            'with' => array(
                                'carMake', 
                                'carModel',
                            ),
                        ), 
                    ),
                ),
            );
            $registrationHistoryDataProvider->criteria->addCondition("registrationTransaction.repair_type = 'BR' AND registrationTransaction.work_order_number IS NOT NULL AND t.to_be_checked = 1 AND t.is_passed = 1");
            $registrationHistoryDataProvider->criteria->compare('t.mechanic_id', Yii::app()->user->id);
            $registrationHistoryDataProvider->criteria->order = 'registrationTransaction.work_order_date DESC';

            if (!empty($plateNumber)) {
                $registrationHistoryDataProvider->criteria->compare('vehicle.plate_number', $plateNumber, true);
            }

            if (!empty($carMakeName)) {
                $registrationHistoryDataProvider->criteria->compare('carMake.name', $carMakeName, true);
            }

            if (!empty($carModelName)) {
                $registrationHistoryDataProvider->criteria->compare('carModel.name', $carModelName, true);
            }

            if (!empty($branchId)) {
                $registrationHistoryDataProvider->criteria->compare('registrationTransaction.branch_id', $branchId);
            }

            if (!empty($workOrderNumber)) {
                $registrationHistoryDataProvider->criteria->compare('registrationTransaction.work_order_number', $workOrderNumber, true);
            }

            if (!empty($workOrderDate)) {
                $registrationHistoryDataProvider->criteria->compare('registrationTransaction.work_order_date', $workOrderDate);
            }

            $this->renderPartial('_transactionHistoryTable', array(
                'registrationHistoryDataProvider' => $registrationHistoryDataProvider,
                'branchId' => $branchId,
                'carMakeName' => $carMakeName,
                'carModelName' => $carModelName,
                'workOrderDate' => $workOrderDate,
                'plateNumber' => $plateNumber,
                'workOrderNumber' => $workOrderNumber,
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

    public function loadRunningDetail($registrationBodyRepairDetails) {
        $runningDetail = null;
        foreach ($registrationBodyRepairDetails as $registrationBodyRepairDetail) {
            $toBeChecked = $registrationBodyRepairDetail->to_be_checked;
            $isPassed = $registrationBodyRepairDetail->is_passed;
            if ($toBeChecked && !$isPassed) {
                $runningDetail = null;
                break;
            }
            if (!$toBeChecked && !$isPassed) {
                if ($runningDetail === null) {
                    $runningDetail = $registrationBodyRepairDetail;
                }
            }
        }

        return $runningDetail;
    }

    public function loadRunningDetailTimesheet($registrationBodyRepairDetail) {
        $runningDetailTimesheet = RegistrationBodyRepairDetailTimesheet::model()->findByAttributes(array('registration_body_repair_detail_id' => $registrationBodyRepairDetail === null ? null : $registrationBodyRepairDetail->id, 'finish_date_time' => null), array('order' => 'id DESC'));
        if ($runningDetailTimesheet === null) {
            $runningDetailTimesheet = new RegistrationBodyRepairDetailTimesheet();
        }

        return $runningDetailTimesheet;
    }

}
