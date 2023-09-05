<?php

class MechanicPerformanceController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
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
        $model = Search::bind(new EmployeeBranchDivisionPositionLevel('search'), isset($_GET['EmployeeBranchDivisionPositionLevel']) ? $_GET['EmployeeBranchDivisionPositionLevel'] : '');
        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('t.position_id', array(1, 16));
        $dataProvider->criteria->together = true;
        $dataProvider->criteria->with = array(
            'employee',
            'branch',
            'division',
            'position',
            'level',
        );
        
        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }
    
    public function actionView($employeeId) {
        $employee = Employee::model()->findByPk($employeeId);
        $employeeBranchDivisionPositionLevel = EmployeeBranchDivisionPositionLevel::model()->findByAttributes(array('employee_id' => $employeeId));
//        $user = Users::model()->findByAttributes(array('employee_id' => $employeeId));
        $registrationServices = RegistrationService::model()->findAllByAttributes(array('start_mechanic_id' => $employeeId));

        $this->render('view', array(
            'employee' => $employee,
            'employeeBranchDivisionPositionLevel' => $employeeBranchDivisionPositionLevel,
            'registrationServices' => $registrationServices,
        ));
    }
}