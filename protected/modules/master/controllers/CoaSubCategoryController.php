<?php

class CoaSubCategoryController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';
    public $defaultAction = 'admin';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterCoaSubCategoryCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterCoaSubCategoryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'delete') {
            if (!(Yii::app()->user->checkAccess('masterCoaSubCategoryApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(
                Yii::app()->user->checkAccess('masterCoaSubCategoryCreate') || 
                Yii::app()->user->checkAccess('masterCoaSubCategoryEdit') || 
                Yii::app()->user->checkAccess('masterCoaSubCategoryView')
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new CoaSubCategory;
        $model->user_id_created = Yii::app()->user->id;
        $model->created_datetime = date('Y-m-d H:i:s');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CoaSubCategory'])) {
            $model->attributes = $_POST['CoaSubCategory'];
            if ($model->save()) {
                $this->saveMasterLog($model);
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
        $model->user_id_updated = Yii::app()->user->id;
        $model->updated_datetime = date('Y-m-d H:i:s');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CoaSubCategory'])) {
            $model->attributes = $_POST['CoaSubCategory'];
            if ($model->save()) {
                $this->saveMasterLog($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function saveMasterLog($model) {
        $masterLog = new MasterLog();
        $masterLog->name = $model->name;
        $masterLog->log_date = date('Y-m-d');
        $masterLog->log_time = date('H:i:s');
        $masterLog->table_name = $model->tableName();
        $masterLog->table_id = $model->id;
        $masterLog->user_id = Yii::app()->user->id;
        $masterLog->username = Yii::app()->user->username;
        $masterLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $masterLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $model->attributes;
        $masterLog->new_data = json_encode($newData);

        $masterLog->save();
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->user_id_deleted = Yii::app()->user->id;
        $model->is_deleted = 1;
        $model->deleted_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_deleted', 'user_id_deleted', 'deleted_datetime'));

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
        $dataProvider = new CActiveDataProvider('CoaSubCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new CoaSubCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CoaSubCategory']))
            $model->attributes = $_GET['CoaSubCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return CoaSubCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = CoaSubCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CoaSubCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'coa-sub-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
