<?php

class ProductSubCategoryController extends Controller {

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
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('frontOfficeHead')) || !(Yii::app()->user->checkAccess('inventoryHead')) || !(Yii::app()->user->checkAccess('operationHead')) || !(Yii::app()->user->checkAccess('purchaseHead')) || !(Yii::app()->user->checkAccess('salesHead')))
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
        $model = new ProductSubCategory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductSubCategory'])) {
            $model->attributes = $_POST['ProductSubCategory'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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

        if (isset($_POST['ProductSubCategory'])) {
            $model->attributes = $_POST['ProductSubCategory'];
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
        $dataProvider = new CActiveDataProvider('ProductSubCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductSubCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductSubCategory']))
            $model->attributes = $_GET['ProductSubCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxGetProductSubMasterCategory() {
        $data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $_POST['ProductSubCategory']['product_master_category_id']));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductSubCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductSubCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductSubCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-sub-category-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
