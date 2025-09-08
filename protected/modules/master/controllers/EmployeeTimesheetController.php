<?php

class EmployeeTimesheetController extends Controller {

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
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $postImages = EmployeeTimesheetImages::model()->findAllByAttributes(array('employee_timesheet_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
        
        $this->render('view', array(
            'model' => $model,
            'postImages' => $postImages,
        ));
    }
    
    public function actionViewEmployeeDetail($employeeId) {
        $employee = Employee::model()->findByPk($employeeId);
        
        $employeeTimesheet = new EmployeeTimesheet('search');
        $employeeTimesheet->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeTimesheet'])) {
            $employeeTimesheet->attributes = $_GET['EmployeeTimesheet'];
        }

        $dataProvider = $employeeTimesheet->search();
        $dataProvider->criteria->compare('employee_id', $employeeId);

        $this->render('viewEmployeeDetail', array(
            'employee' => $employee,
//            'employeeTimesheet' => $employeeTimesheet,
            'dataProvider' => $dataProvider,
        ));
    }
    
    public function actionImport() {
        if (isset($_POST['Submit'])) {
            if ($_FILES['TimesheetImportFile']['error'] === UPLOAD_ERR_OK && is_uploaded_file($_FILES['TimesheetImportFile']['tmp_name'])) {
                if (($handle = fopen($_FILES['TimesheetImportFile']['tmp_name'], 'r')) !== false) {
                    $records = array();
                    while (($lineFields = fgetcsv($handle, null, ',')) !== false) {
                        if ($lineFields[0] !== 'NIP') {
                            $employee = Employee::model()->findByAttributes(array('code' => $lineFields[0]));

                            list($day, $month, $year) = explode('-', $lineFields[2]);
                            $date = $year . '-' . $month . '-' . $day;

                            $model = new EmployeeTimesheet;
                            $model->employee_id = $employee->id;
                            $model->date = $date;
                            $model->clock_in = $lineFields[3];
                            $model->clock_out = $lineFields[4];
                            $model->duration_late = strtotime($lineFields[3]) - strtotime($employee->clock_in_time);
                            $model->duration_work = strtotime($lineFields[4]) - strtotime($lineFields[3]);
                            $model->duration_overtime = strtotime($lineFields[4]) - strtotime($employee->clock_out_time);
                            $model->employee_onleave_category_id = 16;
                            
                            $records[] = $model->getAttributes();
                        }
                    }
                    Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand(EmployeeTimesheet::model()->tableName(), $records)->execute();
                            
                    $this->redirect(array('admin'));
                }
            }
        }
        
        $this->render('import');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new EmployeeTimesheet;
        $model->employee_onleave_category_id = 16;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['EmployeeTimesheet'])) {
            $model->attributes = $_POST['EmployeeTimesheet'];
            if ($model->save()) {
                
                $model->employeeTimesheetImages = CUploadedFile::getInstances($model, 'images');
                foreach ($model->employeeTimesheetImages as $file) {
                    $contentImage = new EmployeeTimesheetImages();
                    $contentImage->employee_timesheet_id = $model->id;
                    $contentImage->is_inactive = EmployeeTimesheet::STATUS_ACTIVE;
                    $contentImage->extension = $file->extensionName;
                    $contentImage->save(false);

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/employeeTimesheet/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
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

        if (isset($_POST['EmployeeTimesheet'])) {
            $model->attributes = $_POST['EmployeeTimesheet'];
            
            if ($model->save()) {
                
                $model->employeeTimesheetImages = CUploadedFile::getInstances($model, 'images');
                foreach ($model->employeeTimesheetImages as $file) {
                    $contentImage = new EmployeeTimesheetImages();
                    $contentImage->employee_timesheet_id = $model->id;
                    $contentImage->is_inactive = EmployeeTimesheet::STATUS_ACTIVE;
                    $contentImage->extension = $file->extensionName;
                    $contentImage->save(false);

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/employeeTimesheet/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
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
        $dataProvider = new CActiveDataProvider('EmployeeTimesheet');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmployeeTimesheet('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeTimesheet'])) {
            $model->attributes = $_GET['EmployeeTimesheet'];
        }

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addBetweenCondition('t.date', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmployeeTimesheet the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = EmployeeTimesheet::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeTimesheet $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-timesheet-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
