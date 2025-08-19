<?php

class EmployeeScheduleController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionGenerate() {
        
        $model = new Employee('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $model->attributes = $_GET['Employee'];
        }
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addCondition("t.status = 'Active'");

        if (isset($_POST['Submit'])) {
            $valid = true;
            
            $lastEmployeeSchedule = EmployeeSchedule::model()->find(array('condition' => 't.working_date IS NOT NULL', 'order' => 't.id DESC'));
            
            $dayNumbers = array_flip(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'));
            $lastWorkingDate = $lastEmployeeSchedule === null ? date('Y-m-d') : $lastEmployeeSchedule->working_date;
            $lastWorkingDay = date('D', strtotime($lastWorkingDate));
            $nextDateDifference = $dayNumbers['Mon'] + ($dayNumbers['Mon'] < $dayNumbers[$lastWorkingDay] ? 7 : 0) - $dayNumbers[$lastWorkingDay];
            $firstDate = date('Y-m-d', strtotime($lastWorkingDate . " + {$nextDateDifference} days"));
            
            $dayToDayNames = array('Minggu' => 'Sun', 'Senin' => 'Mon', 'Selasa' => 'Tue', 'Rabu' => 'Wed', 'Kamis' => 'Thu', 'Jumat' => 'Fri', 'Sabtu' => 'Sat');

            $employees = Employee::model()->findAllByAttributes(array('status' => 'Active'));

            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($employees as $employee) {
                    $offDayName = $dayToDayNames[$employee->off_day];
                    for ($i = 0; $i < 7; $i++) {
                        $currentDay = date('D', strtotime($firstDate . " + {$i} days"));
                        if ($currentDay !== $offDayName) {
                            $currentDate = date('Y-m-d', strtotime($firstDate . " + {$i} days"));

                            $model = new EmployeeSchedule;
                            $model->employee_id = $employee->id;
                            $model->branch_id = $employee->branch_id;
                            $model->working_date = $currentDate;

                            $valid = $valid && $model->save(false);
                        }
                    }
                }
                            
                if ($valid) {
                    $dbTransaction->commit();
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }
            
            if ($valid) {
                $this->redirect(array('index'));
            }
        }

        $this->render('generate', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['EmployeeSchedule'])) {
            $model->attributes = $_POST['EmployeeSchedule'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $currentDate = date('Y-m-d');
        
        $employeeSchedules = EmployeeSchedule::model()->findAll(array(
            'condition' => 't.working_date BETWEEN :start_date AND :end_date', 
            'params' => array(':start_date' => $currentDate, ':end_date' => date('Y-m-d', strtotime($currentDate . " + 6 days"))),
            'order' => 't.id ASC',
        ));
        
        $branches = Branch::model()->findAll();
        
        $employeeScheduleData = array();
        foreach ($employeeSchedules as $employeeSchedule) {
            if (!isset($employeeScheduleData[$employeeSchedule->working_date][$employeeSchedule->branch_id])) {
                $employeeScheduleData[$employeeSchedule->working_date][$employeeSchedule->branch_id] = array();
            }
            $employeeScheduleData[$employeeSchedule->working_date][$employeeSchedule->branch_id][] = $employeeSchedule->employee->name;
        }

        $this->render('index', array(
            'employeeScheduleData' => $employeeScheduleData,
            'branches' => $branches,
            'currentDate' => $currentDate,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmployeeSchedule('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeSchedule']))
            $model->attributes = $_GET['EmployeeSchedule'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmployeeSchedule the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = EmployeeSchedule::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeSchedule $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-schedule-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
