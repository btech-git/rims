<?php

class UnitController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterUnitCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterUnitEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterUnitCreate')) || !(Yii::app()->user->checkAccess('masterUnitEdit')))
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
        $model = new Unit;

        if (isset($_POST['Unit'])) {
            $model->attributes = $_POST['Unit'];
            $model->status = 'Active';
            if ($model->save()) {
                $this->redirect(array('view', 'id'=>$model->id));
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
        
        if (isset($_POST['Unit'])) {
            $model->attributes = $_POST['Unit'];

            if ($model->save()) {
                $this->redirect(array('view','id'=>$model->id));
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
        $dataProvider = new CActiveDataProvider('Unit');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Unit('search');
        $model->unsetAttributes();  // clear any default values
        //echo "get values"; print_r($_GET['Unit']); exit;
        if (isset($_GET['Unit'])) {

            $model->attributes = $_GET['Unit'];
        }


        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Unit the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Unit::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Unit $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'unit-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxHtmlCreate() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new Unit;

            $this->renderPartial('_create-dialog', array(
                'model' => $model,
            ), false, true);
        }
    }

    public function actionAjaxHtmlSave() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Unit'])) {
                $isiID = $_POST['Unit']['id'];
                if (!empty($isiID)) {
                    $model = $this->loadModel($isiID);
                } else {
                    $model = new Unit;
                }

                $model->attributes = $_POST['Unit'];
                if ($model->save()) {
                    echo CHtml::script('window.location.href = "' . Yii::app()->user->getReturnUrl(array('admin')) . '";');
                    Yii::app()->end();
                }
            }
        }
    }

    public function actionAjaxHtmlUpdate($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = $this->loadModel($id);

            $this->renderPartial('_update-dialog', array(
                'model' => $model,
            ), false, true);
        }
    }

}
