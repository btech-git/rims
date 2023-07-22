<?php

class EmployeeDayoffController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';
    public $defaultAction = 'admin';

    /**
     * @return array action filters
     */
    // public function filters()
    // {
    // 	return array(
    // 		'accessControl', // perform access control for CRUD operations
    // 		'postOnly + delete', // we only allow deletion via POST request
    // 	);
    // }

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
//				'users'=>array('Admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

    public function filters() {
        return array(
//            'access',
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new EmployeeDayoff;
        $model->date_from = date('Y-m-d');
        $model->date_to = date('Y-m-d');
        $model->date_created = date('Y-m-d');
        $model->time_created = date('H:i:s');
        $model->user_id = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $employee = new Employee('search');
        $employee->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee'])) {
            $employee->attributes = $_GET['Employe'];
        }

        $employeeCriteria = new CDbCriteria;
        $employeeDataProvider = new CActiveDataProvider('Employee', array(
            'criteria' => $employeeCriteria,
        ));
        if (isset($_POST['EmployeeDayoff'])) {
            $model->attributes = $_POST['EmployeeDayoff'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
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
        $employee = new Employee('search');
        $employee->unsetAttributes();  // clear any default values
        if (isset($_GET['Employee']))
            $employee->attributes = $_GET['Employe'];

        $employeeCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        //$employeeCriteria->condition = 'availability = "Yes"';

        $employeeDataProvider = new CActiveDataProvider('Employee', array(
            'criteria' => $employeeCriteria,
        ));
        if (isset($_POST['EmployeeDayoff'])) {
            $model->attributes = $_POST['EmployeeDayoff'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
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
        $dataProvider = new CActiveDataProvider('EmployeeDayoff');

        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new EmployeeDayoff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeDayoff']))
            $model->attributes = $_GET['EmployeeDayoff'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return EmployeeDayoff the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = EmployeeDayoff::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeDayoff $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-dayoff-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxEmployee($id) {
        if (Yii::app()->request->isAjaxRequest) {
            //$requestOrder = $this->instantiate($id);
            $employee = Employee::model()->findByPk($id);
            $name = $employee->name;

            $object = array(
                //'id'=>$supplier->id,
                'name' => $name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionUpdateApproval($headerId) {
        $dayOff = EmployeeDayoff::model()->findByPK($headerId);
        $historis = EmployeeDayoffApproval::model()->findAllByAttributes(array('employee_dayoff_id' => $headerId));
        $model = new EmployeeDayoffApproval;
        //$branch = Branch::model()->findByPK($jurnalPenyesuaian->branch_id);
        //$model = $this->loadModelDetail($detailId);
        if (isset($_POST['EmployeeDayoffApproval'])) {
            $model->attributes = $_POST['EmployeeDayoffApproval'];
            if ($model->save()) {
                $dayOff->status = $model->approval_type;
                $dayOff->save();

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'dayOff' => $dayOff,
            'historis' => $historis,
                //'jenisPersediaan'=>$jenisPersediaan,
                //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

}
