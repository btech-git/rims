<?php

class OilSaeController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterOilSpecificationCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterOilSpecificationEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'delete') {
            if (!(Yii::app()->user->checkAccess('masterOilSpecificationApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(
                Yii::app()->user->checkAccess('masterOilSpecificationCreate') || 
                Yii::app()->user->checkAccess('masterOilSpecificationEdit') ||
                Yii::app()->user->checkAccess('masterOilspecificationView') || 
                Yii::app()->user->checkAccess('masterOilSpecificationApproval')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

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
        $model = new OilSae;
        $model->user_id_created = Yii::app()->user->id;
        $model->created_datetime = date('Y-m-d H:i:s');

        if (isset($_POST['OilSae'])) {
            $model->attributes = $_POST['OilSae'];
            if ($model->save()) {
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

        if (isset($_POST['OilSae'])) {
            $model->attributes = $_POST['OilSae'];
            if ($model->save()) {
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
        $dataProvider = new CActiveDataProvider('OilSae');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new OilSae('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['OilSae']))
            $model->attributes = $_GET['OilSae'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return OilSae the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = OilSae::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param OilSae $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'oil-sae-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
