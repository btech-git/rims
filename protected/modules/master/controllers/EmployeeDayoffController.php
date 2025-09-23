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
            if (!(Yii::app()->user->checkAccess('masterEmployeeCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'restore' ||
            $filterChain->action->id === 'edit' ||
            $filterChain->action->id === 'update' ||
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'updateBank' ||
            $filterChain->action->id === 'updateDeduction' ||
            $filterChain->action->id === 'updateIncentive'
        ) {
            if (!(Yii::app()->user->checkAccess('masterEmployeeCreate')) || !(Yii::app()->user->checkAccess('masterEmployeeEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $postImages = EmployeeDayoffImages::model()->findAllByAttributes(array('employee_dayoff_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
        
        $this->render('view', array(
            'model' => $model,
            'postImages' => $postImages,
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
            $employee->attributes = $_GET['Employee'];
        }

        $employeeCriteria = new CDbCriteria;
        $employeeDataProvider = new CActiveDataProvider('Employee', array(
            'criteria' => $employeeCriteria,
        ));
        if (isset($_POST['EmployeeDayoff'])) {
            $model->attributes = $_POST['EmployeeDayoff'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->date_created)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->date_created)));
            
            $valid = true;
            if ($model->employeeOnleaveCategory->number_of_days > 0) {
                $valid = $model->day == $model->employeeOnleaveCategory->number_of_days ? true : false;
                
                if ($valid == false) {
                    $model->addError('error', 'Jumlah hari cuti melebihi ketentuan.');
                }
            } 
            
            if ($valid && $model->save()) {

                $model->employeeDayoffImages = CUploadedFile::getInstances($model, 'images');
                foreach ($model->employeeDayoffImages as $file) {
                    $contentImage = new EmployeeDayoffImages();
                    $contentImage->employee_dayoff_id = $model->id;
                    $contentImage->is_inactive = EmployeeDayoff::STATUS_ACTIVE;
                    $contentImage->extension = $file->extensionName;
                    $contentImage->save(false);

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/employeeDayoff/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'employee' => $employee,
            'employeeDataProvider' => $employeeDataProvider,
        ));
    }
    
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
            $model->status = 'Draft';
            
            if ($model->save()) {
                $start_date = $model->date_from;
                $end_date = date('Y-m-d', strtotime($model->date_to . " +1 days"));
                $interval = new DateInterval('P1D');
                $date_range = new DatePeriod(new DateTime($start_date), $interval, new DateTime($end_date));

                foreach ($date_range as $date) {
                    EmployeeTimesheet::model()->deleteAllByAttributes(array(
                        'employee_id' => $model->employee_id,
                        'remarks' => $model->transaction_number,
                        'employee_onleave_category_id' => $model->employee_onleave_category_id,
                    ));
                }
                
                $model->employeeDayoffImages = CUploadedFile::getInstances($model, 'images');
                foreach ($model->employeeDayoffImages as $file) {
                    $contentImage = new EmployeeDayoffImages();
                    $contentImage->employee_dayoff_id = $model->id;
                    $contentImage->is_inactive = EmployeeDayoff::STATUS_ACTIVE;
                    $contentImage->extension = $file->extensionName;
                    $contentImage->save(false);

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/employeeDayoff/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                $this->redirect(array('view', 'id' => $model->id));
            }
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
        if (isset($_GET['EmployeeDayoff'])) {
            $model->attributes = $_GET['EmployeeDayoff'];
        }
        
        $dataprovider = $model->search();
//        $modelDraftDataprovider->criteria->compare('t.status', 'Draft');
//
//        $modelApprovedDataprovider = $model->search();
//        $modelApprovedDataprovider->criteria->compare('t.status', 'Approved');
//
//        $modelRejectDataprovider = $model->search();
//        $modelRejectDataprovider->criteria->compare('t.status', 'Rejected');

        $this->render('admin', array(
            'model' => $model,
            'dataprovider' => $dataprovider,
//            'modelApprovedDataprovider' => $modelApprovedDataprovider,
//            'modelRejectDataprovider' => $modelRejectDataprovider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdminDraft() {
        $model = new EmployeeDayoff('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['EmployeeDayoff'])) {
            $model->attributes = $_GET['EmployeeDayoff'];
        }
        
        $modelDraftDataprovider = $model->search();
        $modelDraftDataprovider->criteria->compare('t.status', 'Draft');

        $this->render('adminDraft', array(
            'model' => $model,
            'modelDraftDataprovider' => $modelDraftDataprovider,
        ));
    }

    public function actionPdf($id) {
        $dayoff = $this->loadModel($id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Pengajuan Cuti');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'dayoff' => $dayoff,
        ), true));
        $mPDF1->Output('Permintaan Barang ' . $dayoff->transaction_number . '.pdf', 'I');
    }

    public function actionEmployeeCompletion() {
        echo CJSON::encode(Completion::employee($_GET['term']));
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

                $start_date = $dayOff->date_from;
                $end_date = date('Y-m-d', strtotime($dayOff->date_to . " +1 days"));
                $interval = new DateInterval('P1D');
                $date_range = new DatePeriod(new DateTime($start_date), $interval, new DateTime($end_date));

                foreach ($date_range as $date) {
                    $employeeTimesheet = new EmployeeTimesheet();
                    $employeeTimesheet->date = date_format($date, 'Y-m-d');
                    $employeeTimesheet->clock_in = '00:00:00';
                    $employeeTimesheet->clock_out = '00:00:00';
                    $employeeTimesheet->employee_id = $dayOff->employee_id;
                    $employeeTimesheet->duration_late = 0;
                    $employeeTimesheet->duration_work = 0;
                    $employeeTimesheet->remarks = $dayOff->transaction_number;
                    $employeeTimesheet->employee_onleave_category_id = $dayOff->employee_onleave_category_id;
                    $employeeTimesheet->save();
                }
                
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
