<?php

class EmployeeController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterEmployeeCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
                $filterChain->action->id === 'restore' ||
                $filterChain->action->id === 'edit' ||
                $filterChain->action->id === 'update' ||
                $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
                $filterChain->action->id === 'view' ||
                $filterChain->action->id === 'admin' ||
                $filterChain->action->id === 'index' ||
                $filterChain->action->id === 'updateBank' ||
                $filterChain->action->id === 'updateDeduction' ||
                $filterChain->action->id === 'updateIncentive'
        ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeCreate')) || !(Yii::app()->user->checkAccess('masterEmployeeEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $employeeBanks = EmployeeBank::model()->findAllByAttributes(array('employee_id' => $id));
        $employeeIncentives = EmployeeIncentives::model()->findAllByAttributes(array('employee_id' => $id));
        $employeeDeductions = EmployeeDeductions::model()->findAllByAttributes(array('employee_id' => $id));
        $employeeDivisions = EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array('employee_id' => $id));
        $attendance = new EmployeeAttendance('search');
        $attendance->unsetAttributes();  // clear any default values
        
        if (isset($_GET['EmployeeAttendance'])) {
            $attendance->attributes = $_GET['EmployeeAttendance'];
        }

        $attendanceCriteria = new CDbCriteria;
        $attendanceCriteria->addCondition("employee_id = " . $id);
        
        $dataProvider = new CActiveDataProvider('EmployeeAttendance', array(
            'criteria' => $attendanceCriteria,
            'pagination' => array('pageSize' => 31),
        ));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'employeeBanks' => $employeeBanks,
            'employeeIncentives' => $employeeIncentives,
            'employeeDeductions' => $employeeDeductions,
            'employeeDivisions' => $employeeDivisions,
            'attendance' => $attendance,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));

        $incentive = new Incentive('search');
        $incentive->unsetAttributes();  // clear any default values
        if (isset($_GET['Incentive']))
            $incentive->attributes = $_GET['Incentive'];

        $incentiveCriteria = new CDbCriteria;
        $incentiveCriteria->compare('id', $incentive->id . '%', true, 'AND', false);
        $incentiveCriteria->compare('name', $incentive->name, true);

        $incentiveDataProvider = new CActiveDataProvider('Incentive', array(
            'criteria' => $incentiveCriteria,
        ));

        $deduction = new Deduction('search');
        $deduction->unsetAttributes();  // clear any default values
        if (isset($_GET['Deduction']))
            $deduction->attributes = $_GET['Deduction'];

        $deductionCriteria = new CDbCriteria;
        $deductionCriteria->compare('id', $deduction->id . '%', true, 'AND', false);
        $deductionCriteria->compare('name', $deduction->name, true);

        $deductionDataProvider = new CActiveDataProvider('Deduction', array(
            'criteria' => $deductionCriteria,
        ));

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Division']))
            $branch->attributes = $_GET['Division'];

        $branchCriteria = new CDbCriteria;
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        $employee = $this->instantiate(null);
        if (isset($_POST['Employee'])) {
            $this->loadState($employee);
            if ($employee->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $employee->header->id));
            }
        }

        $this->render('create', array(
            'employee' => $employee,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
            'incentive' => $incentive,
            'incentiveDataProvider' => $incentiveDataProvider,
            'deduction' => $deduction,
            'deductionDataProvider' => $deductionDataProvider,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $employee = $this->instantiate($id);
        $this->performAjaxValidation($employee->header);

        $branch = new Branch('search');
        $branch->unsetAttributes();  // clear any default values
        if (isset($_GET['Division']))
            $branch->attributes = $_GET['Division'];

        $branchCriteria = new CDbCriteria;
        $branchCriteria->compare('name', $branch->name, true);

        $branchDataProvider = new CActiveDataProvider('Branch', array(
            'criteria' => $branchCriteria,
        ));

        if (isset($_POST['Employee'])) {
            $this->loadState($employee);
            if ($employee->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $employee->header->id));
            }
        }
        $this->render('update', array(
            'employee' => $employee,
            'branch' => $branch,
            'branchDataProvider' => $branchDataProvider,
        ));
    }

    public function actionUpdateBank($empId, $bankId) {

        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));

        $employee = $this->instantiate($empId);

        // $this->performAjaxValidation($customer->header);
        $model = EmployeeBank::model()->findByPk($bankId);
        if (isset($_POST['EmployeeBank'])) {
            $model->attributes = $_POST['EmployeeBank'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $empId));
        }

        $this->render('update', array(
            'employee' => $employee,
            'model' => $model,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
        ));
    }

    public function actionUpdateIncentive($empId, $incentiveId) {
        $incentive = new Incentive('search');
        $incentive->unsetAttributes();  // clear any default values
        if (isset($_GET['Incentive']))
            $incentive->attributes = $_GET['Incentive'];

        $incentiveCriteria = new CDbCriteria;
        $incentiveCriteria->compare('id', $incentive->id . '%', true, 'AND', false);
        $incentiveCriteria->compare('name', $incentive->name, true);

        $incentiveDataProvider = new CActiveDataProvider('Incentive', array(
            'criteria' => $incentiveCriteria,
        ));

        $employee = $this->instantiate($empId);

        // $this->performAjaxValidation($customer->header);
        $model = EmployeeIncentives::model()->findByPk($incentiveId);
        if (isset($_POST['EmployeeIncentives'])) {
            $model->attributes = $_POST['EmployeeIncentives'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $empId));
        }

        $this->render('update', array(
            'employee' => $employee,
            'model' => $model,
            'incentive' => $incentive,
            'incentiveDataProvider' => $incentiveDataProvider,
        ));
    }

    public function actionUpdateDeduction($empId, $deductionId) {

        $deduction = new Deduction('search');
        $deduction->unsetAttributes();  // clear any default values
        if (isset($_GET['Deduction']))
            $deduction->attributes = $_GET['Deduction'];

        $deductionCriteria = new CDbCriteria;
        $deductionCriteria->compare('id', $deduction->id . '%', true, 'AND', false);
        $deductionCriteria->compare('name', $deduction->name, true);

        $deductionDataProvider = new CActiveDataProvider('Deduction', array(
            'criteria' => $deductionCriteria,
        ));
        $employee = $this->instantiate($empId);

        // $this->performAjaxValidation($customer->header);
        $model = EmployeeDeductions::model()->findByPk($deductionId);
        if (isset($_POST['EmployeeDeductions'])) {
            $model->attributes = $_POST['EmployeeDeductions'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $empId));
        }

        $this->render('update', array(
            'employee' => $employee,
            'model' => $model,
            'deduction' => $deduction,
            'deductionDataProvider' => $deductionDataProvider,
        ));
    }

    public function actionAjaxBank($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $bank = Bank::model()->findByPk($id);

            $object = array(
                'id' => $bank->id,
                'name' => $bank->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxIncentive($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $incentive = Incentive::model()->findByPk($id);

            $object = array(
                'id' => $incentive->id,
                'name' => $incentive->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxDeduction($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $deduction = Deduction::model()->findByPk($id);

            $object = array(
                'id' => $deduction->id,
                'name' => $deduction->name,
            );

            echo CJSON::encode($object);
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->is_deleted = 1;
        $model->deleted_by = Yii::app()->user->id;
        $model->deleted_at = date('Y-m-d H:i:s');
        $model->update(array('is_deleted', 'deleted_by', 'deleted_at'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionRestore($id) {
        // var_dump($id); die("S");
        $this->loadModel($id)->restore();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        //$dataProvider=new CActiveDataProvider('Employee');
        // $criteria = new CDbCriteria();
        // $criteria->together = true;
        // $criteria->with= array('registrationService'=>array('with'=>array('registrationServiceEmployees'=>array('with'=>array('employee')))));
        //$criteria->addCondition("")
        // $registrationTransactions = RegistrationTransaction::model()->findAll($criteria);
        $this->render('index', array(
                //'dataProvider'=>$dataProvider,
                // 	'registrationTransactions'=>$registrationTransactions,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $model->attributes = $_GET['Employee'];
        }
        
        $dataProvider = $model->search();

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdminResigned() {
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $model->attributes = $_GET['Employee'];
        }
        
        $dataProvider = $model->searchResigned();

        $this->render('adminResigned', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    // Get City
    public function actionAjaxGetCity() {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['Employee']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHTML::tag('option', array('value' => ''), '[--Select City--]', true);

            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    // Get City Home
    public function actionAjaxGetCityHome() {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['Employee']['home_province']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHTML::tag('option', array('value' => ''), '[--Select City--]', true);

            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    //get Position
    public function actionAjaxGetPosition($divisionId) {

        $divisionPositions = DivisionPosition::model()->findAllByAttributes(array('division_id' => $divisionId));
        $positionId = array();
        foreach ($divisionPositions as $divisionPosition) {
            $positionId[] = $divisionPosition->position_id;
        }
        $positioncriteria = new CDbCriteria();
        $positioncriteria->addInCondition('id', $positionId);

        $data = Position::model()->findAll($positioncriteria);

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Position--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Position--]', true);
        }
    }

    //get Level
    public function actionAjaxGetLevel($positionId) {

        $positionLevels = PositionLevel::model()->findAllByAttributes(array('position_id' => $positionId));
        $levelId = array();
        foreach ($positionLevels as $positionLevel) {
            $levelId[] = $positionLevel->level_id;
        }
        $levelcriteria = new CDbCriteria();
        $levelcriteria->addInCondition('id', $levelId);

        $data = Level::model()->findAll($levelcriteria);

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Level--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Level--]', true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Employee the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Employee::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Employee $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    //Add PhoneDetails
    public function actionAjaxHtmlAddPhoneDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->addDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPhone', array('employee' => $employee), false, true);
        }
    }

    //Delete Phone Details
    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = $this->instantiate($id);
            $this->loadState($employee);
            $employee->removeDetailAt($index);

            $this->renderPartial('_detailPhone', array('employee' => $employee), false, true);
        }
    }

    //Add Mobile Details
    public function actionAjaxHtmlAddMobileDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->addMobileDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailMobile', array('employee' => $employee), false, true);
        }
    }

    //Delete Mobile Details
    public function actionAjaxHtmlRemoveMobileDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = $this->instantiate($id);
            $this->loadState($employee);
            $employee->removeMobileDetailAt($index);
            $this->renderPartial('_detailMobile', array('employee' => $employee), false, true);
        }
    }

    //Add Bank Detail
    public function actionAjaxHtmlAddBankDetail($id, $bankId) {

        if (Yii::app()->request->isAjaxRequest) {
            //
            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->addBankDetail($bankId);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailBank', array('employee' => $employee), false, true);
        }
    }

    //Remove Bank Detail
    public function actionAjaxHtmlRemoveBankDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = $this->instantiate($id);
            $this->loadState($employee);
            $employee->removeBankDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailBank', array('employee' => $employee), false, true);
        }
    }

    //Add Incentive Detail
    public function actionAjaxHtmlAddIncentiveDetail($id, $incentiveId) {
        //echo'here'; 
        if (Yii::app()->request->isAjaxRequest) {
            $employee = $this->instantiate($id);
            $this->loadState($employee);
            $employee->addIncentiveDetail($incentiveId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailIncentive', array('employee' => $employee), false, true);
        }
    }

    //Remove Incentive Detail
    public function actionAjaxHtmlRemoveIncentiveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = $this->instantiate($id);
            $this->loadState($employee);
            $employee->removeIncentiveDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailIncentive', array('employee' => $employee), false, true);
        }
    }

    //Add PhoneDetails
    public function actionAjaxHtmlAddDeductionDetail($id, $deductionId) {
        if (Yii::app()->request->isAjaxRequest) {
            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->addDeductionDetail($deductionId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail_deduction', array('employee' => $employee), false, true);
            //echo 'here'; exit;
        }
    }

    //Delete Phone Details
    public function actionAjaxHtmlRemoveDeductionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->removeDeductionDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail_deduction', array('employee' => $employee), false, true);
        }
    }

    //Add Division Details
    public function actionAjaxHtmlAddDivisionDetail($id, $branchId) {
        if (Yii::app()->request->isAjaxRequest) {
            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->addDivisionDetail($branchId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailDivision', array('employee' => $employee), false, true);
        }
    }

    //Delete Division Details
    public function actionAjaxHtmlRemoveDivisionDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $employee = $this->instantiate($id);
            $this->loadState($employee);

            $employee->removeDivisionDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailDivision', array('employee' => $employee), false, true);
        }
    }

    public function instantiate($id) {

        if (empty($id)) {
            $employee = new Employees(new Employee(), array(), array(), array(), array(), array(), array());
        } else {
            $employeeModel = $this->loadModel($id);
            $employee = new Employees($employeeModel, $employeeModel->employeePhones, $employeeModel->employeeMobiles, $employeeModel->employeeBanks, $employeeModel->employeeIncentives, $employeeModel->employeeDeductions, $employeeModel->employeeBranchDivisionPositionLevels);
        }
        return $employee;
    }

    // Get the details
    public function loadState($employee) {

        if (isset($_POST['Employee'])) {
            $employee->header->attributes = $_POST['Employee'];
        }

        if (isset($_POST['EmployeePhone'])) {
            foreach ($_POST['EmployeePhone'] as $i => $item) {
                if (isset($employee->phoneDetails[$i]))
                    $employee->phoneDetails[$i]->attributes = $item;
                else {
                    $detail = new EmployeePhone();
                    $detail->attributes = $item;
                    $employee->phoneDetails[] = $detail;
                }
            }
            if (count($_POST['EmployeePhone']) < count($employee->phoneDetails))
                array_splice($employee->phoneDetails, $i + 1);
        } else
            $employee->phoneDetails = array();


        if (isset($_POST['EmployeeMobile'])) {
            foreach ($_POST['EmployeeMobile'] as $i => $item) {
                if (isset($employee->mobileDetails[$i]))
                    $employee->mobileDetails[$i]->attributes = $item;
                else {
                    $detail = new EmployeeMobile();
                    $detail->attributes = $item;
                    $employee->mobileDetails[] = $detail;
                }
            }
            if (count($_POST['EmployeeMobile']) < count($employee->mobileDetails))
                array_splice($employee->mobileDetails, $i + 1);
        } else
            $employee->mobileDetails = array();

        if (isset($_POST['EmployeeBank'])) {
            foreach ($_POST['EmployeeBank'] as $i => $item) {
                if (isset($employee->bankDetails[$i]))
                    $employee->bankDetails[$i]->attributes = $item;
                else {
                    $detail = new EmployeeBank();
                    $detail->attributes = $item;
                    $employee->bankDetails[] = $detail;
                }
            }
            if (count($_POST['EmployeeBank']) < count($employee->bankDetails))
                array_splice($employee->bankDetails, $i + 1);
        } else
            $employee->bankDetails = array();

        if (isset($_POST['EmployeeIncentives'])) {

            foreach ($_POST['EmployeeIncentives'] as $i => $item) {
                if (isset($employee->incentiveDetails[$i]))
                    $employee->incentiveDetails[$i]->attributes = $item;
                else {
                    $detail = new EmployeeIncentives();
                    $detail->attributes = $item;
                    $employee->incentiveDetails[] = $detail;
                }
            }
            if (count($_POST['EmployeeIncentives']) < count($employee->incentiveDetails))
                array_splice($employee->incentiveDetails, $i + 1);
        } else
            $employee->incentiveDetails = array();


        if (isset($_POST['EmployeeDeductions'])) {
            //echo count($_POST['EmployeeDeductions']); exit;

            foreach ($_POST['EmployeeDeductions'] as $i => $item) {
                if (isset($employee->deductionDetails[$i]))
                    $employee->deductionDetails[$i]->attributes = $item;
                else {
                    $detail = new EmployeeDeductions();
                    $detail->attributes = $item;
                    $employee->deductionDetails[] = $detail;
                }
            }
            if (count($_POST['EmployeeDeductions']) < count($employee->deductionDetails))
                array_splice($employee->deductionDetails, $i + 1);
        } else
            $employee->deductionDetails = array();

        if (isset($_POST['EmployeeBranchDivisionPositionLevel'])) {
            //echo count($_POST['EmployeeDeductions']); exit;

            foreach ($_POST['EmployeeBranchDivisionPositionLevel'] as $i => $item) {
                if (isset($employee->divisionDetails[$i]))
                    $employee->divisionDetails[$i]->attributes = $item;
                else {
                    $detail = new EmployeeBranchDivisionPositionLevel();
                    $detail->attributes = $item;
                    $employee->divisionDetails[] = $detail;
                }
            }
            if (count($_POST['EmployeeBranchDivisionPositionLevel']) < count($employee->divisionDetails))
                array_splice($employee->divisionDetails, $i + 1);
        } else
            $employee->divisionDetails = array();
    }
}
