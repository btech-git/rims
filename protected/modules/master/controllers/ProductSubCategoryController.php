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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterProductSubCategoryCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterProductSubCategoryEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'delete') {
            if (!(Yii::app()->user->checkAccess('masterProductSubCategoryApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(
                Yii::app()->user->checkAccess('masterProductSubCategoryCreate') || 
                Yii::app()->user->checkAccess('masterProductSubCategoryEdit') || 
                Yii::app()->user->checkAccess('masterProductSubCategoryView')
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
        $model = $this->loadModel($id);
        
        if (isset($_POST['Approve']) && (int) $model->is_approved !== 1) {
            $model->is_approved = 1;
            $model->user_id_approval = Yii::app()->user->getId();
            $model->date_approval = date('Y-m-d H:i:s');
            
            if ($model->save(true, array('is_approved', 'user_id_approval', 'date_approval'))) {
                Yii::app()->user->setFlash('confirm', 'Your data has been approved!!!');
            }
            
        } elseif (isset($_POST['Reject'])) {
            $model->is_approved = 2;
            
            if ($model->save(true, array('is_approved'))) {
                Yii::app()->user->setFlash('confirm', 'Your data has been rejected!!!');
            }
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProductSubCategory;
        $model->user_id = Yii::app()->user->id;
        $model->user_id_approval = null;
        $model->date_posting = date('Y-m-d H:i:s');
        $model->date_approval = null;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductSubCategory'])) {
            $model->attributes = $_POST['ProductSubCategory'];
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

        if (isset($_POST['ProductSubCategory'])) {
            $model->attributes = $_POST['ProductSubCategory'];
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
        if (isset($_GET['ProductSubCategory'])) {
            $model->attributes = $_GET['ProductSubCategory'];
        }

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

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['ProductSubCategory']['product_master_category_id']) ? $_GET['ProductSubCategory']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
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
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
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
