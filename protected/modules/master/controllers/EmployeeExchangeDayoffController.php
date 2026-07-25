<?php

class EmployeeExchangeDayoffController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
//            array('allow', // allow all users to perform 'index' and 'view' actions
//                'actions' => array('index', 'view'),
//                'users' => array('*'),
//            ),
//            array('allow', // allow authenticated user to perform 'create' and 'update' actions
//                'actions' => array('create', 'update'),
//                'users' => array('@'),
//            ),
//            array('allow', // allow admin user to perform 'admin' and 'delete' actions
//                'actions' => array('admin', 'delete'),
//                'users' => array('admin'),
//            ),
//            array('deny', // deny all users
//                'users' => array('*'),
//            ),
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
    public function actionCreate() {
        $model = new EmployeeExchangeDayoff;

        if (isset($_POST['EmployeeExchangeDayoff'])) {
            $model->attributes = $_POST['EmployeeExchangeDayoff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
            
        $dayOffOldList = array();
        if (!empty($model->employee_id) && !empty($model->date_dayoff_new)) {
            $dayNames = array(
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu',
            );
        
            $employee = Employee::model()->findByPk($model->employee_id);
            for ($i = 1; $i <= 6; $i++) {
                $previousDate = date('Y-m-d', strtotime("-{$i} day", strtotime($model->date_dayoff_new)));
                $dayName = date('l', strtotime($previousDate));
                if ($employee->off_day == $dayNames[$dayName]) {
                    $dayOffOldList[$previousDate] = $previousDate;
                    break;
                }
            }
            for ($i = 1; $i <= 6; $i++) {
                $nextDate = date('Y-m-d', strtotime("+{$i} day", strtotime($model->date_dayoff_new)));
                $dayName = date('l', strtotime($nextDate));
                if ($employee->off_day == $dayNames[$dayName]) {
                    $dayOffOldList[$nextDate] = $nextDate;
                    break;
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'dayOffOldList' => $dayOffOldList,
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

        if (isset($_POST['EmployeeExchangeDayoff'])) {
            $model->attributes = $_POST['EmployeeExchangeDayoff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }
            
        $dayOffOldList = array();
        if (!empty($model->employee_id) && !empty($model->date_dayoff_new)) {
            $dayNames = array(
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
                'Sunday' => 'Minggu',
            );
        
            $employee = Employee::model()->findByPk($model->employee_id);
            for ($i = 1; $i <= 6; $i++) {
                $previousDate = date('Y-m-d', strtotime("-{$i} day", strtotime($model->date_dayoff_new)));
                $dayName = date('l', strtotime($previousDate));
                if ($employee->off_day == $dayNames[$dayName]) {
                    $dayOffOldList[$previousDate] = $previousDate;
                    break;
                }
            }
            for ($i = 1; $i <= 6; $i++) {
                $nextDate = date('Y-m-d', strtotime("+{$i} day", strtotime($model->date_dayoff_new)));
                $dayName = date('l', strtotime($nextDate));
                if ($employee->off_day == $dayNames[$dayName]) {
                    $dayOffOldList[$nextDate] = $nextDate;
                    break;
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'dayOffOldList' => $dayOffOldList,
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
        $dataProvider = new CActiveDataProvider('EmployeeExchangeDayoff');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmployeeExchangeDayoff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeExchangeDayoff']))
            $model->attributes = $_GET['EmployeeExchangeDayoff'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxHtmlUpdateDateDayoffOld() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new EmployeeExchangeDayoff;

            if (isset($_POST['EmployeeExchangeDayoff'])) {
                $model->attributes = $_POST['EmployeeExchangeDayoff'];
            }
            
            $dayOffOldList = array();
            if (!empty($model->employee_id) && !empty($model->date_dayoff_new)) {
                $dayNames = array(
                    'Monday' => 'Senin',
                    'Tuesday' => 'Selasa',
                    'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis',
                    'Friday' => 'Jumat',
                    'Saturday' => 'Sabtu',
                    'Sunday' => 'Minggu',
                );

                $employee = Employee::model()->findByPk($model->employee_id);
                for ($i = 1; $i <= 6; $i++) {
                    $previousDate = date('Y-m-d', strtotime("-{$i} day", strtotime($model->date_dayoff_new)));
                    $dayName = date('l', strtotime($previousDate));
                    if ($employee->off_day == $dayNames[$dayName]) {
                        $dayOffOldList[$previousDate] = $previousDate;
                        break;
                    }
                }
                for ($i = 1; $i <= 6; $i++) {
                    $nextDate = date('Y-m-d', strtotime("+{$i} day", strtotime($model->date_dayoff_new)));
                    $dayName = date('l', strtotime($nextDate));
                    if ($employee->off_day == $dayNames[$dayName]) {
                        $dayOffOldList[$nextDate] = $nextDate;
                        break;
                    }
                }
            }

            $this->renderPartial('_dateDayoffOld', array(
                'model' => $model,
                'dayOffOldList' => $dayOffOldList,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmployeeExchangeDayoff the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = EmployeeExchangeDayoff::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeExchangeDayoff $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-exchange-dayoff-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
