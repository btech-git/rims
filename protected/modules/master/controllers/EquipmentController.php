<?php

class EquipmentController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('masterEquipmentCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterEquipmentEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'delete') {
            if (!(Yii::app()->user->checkAccess('masterEquipmentApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(
                Yii::app()->user->checkAccess('masterEquipmentCreate') || 
                Yii::app()->user->checkAccess('masterEquipmentEdit') || 
                Yii::app()->user->checkAccess('masterEquipmentView')
            )) {
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

        $serviceEquipments = ServiceEquipment::model()->findAllByAttributes(array('equipment_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'serviceEquipments' => $serviceEquipments,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Equipment;
        $model->user_id_created = Yii::app()->user->id;
        $model->created_datetime = date('Y-m-d H:i:s');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Equipment'])) {
            $model->attributes = $_POST['Equipment'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->user_id_updated = Yii::app()->user->id;
        $model->updated_datetime = date('Y-m-d H:i:s');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Equipment'])) {
            $model->attributes = $_POST['Equipment'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->is_deleted = 1;
        $model->status = 'Deleted';
        $model->user_id_deleted = Yii::app()->user->id;
        $model->deleted_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_deleted', 'user_id_deleted', 'deleted_datetime', 'status'));

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->saveMasterLog($model);
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Equipment');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Equipment('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Equipment'])) {
            $model->attributes = $_GET['Equipment'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Equipment::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Equipment $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'equipment-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}