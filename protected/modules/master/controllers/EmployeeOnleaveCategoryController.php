<?php

class EmployeeOnleaveCategoryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index'
        ) {
            if (!(
                Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryCreate') || 
                Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryEdit') || 
                Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryView')
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

    public function actionCreate() {
        $model = new EmployeeOnleaveCategory;

        if (isset($_POST['EmployeeOnleaveCategory'])) {
            $model->attributes = $_POST['EmployeeOnleaveCategory'];
            
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['EmployeeOnleaveCategory'])) {
            $model->attributes = $_POST['EmployeeOnleaveCategory'];
            
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('EmployeeOnleaveCategory');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdmin() {
        $model = new EmployeeOnleaveCategory('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['EmployeeOnleaveCategory'])) {
            $model->attributes = $_GET['EmployeeOnleaveCategory'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = EmployeeOnleaveCategory::model()->findByPk($id);
        
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param EmployeeOnleaveCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'employee-onleave-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
