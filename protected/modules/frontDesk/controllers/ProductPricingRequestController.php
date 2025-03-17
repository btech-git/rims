<?php

class ProductPricingRequestController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterBranchCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'updateDivision'
        ) {
            if (!(Yii::app()->user->checkAccess('masterBranchEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'addInterbranch' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterBranchCreate')) || !(Yii::app()->user->checkAccess('masterBranchEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionShow($id) {
        $model = $this->loadModel($id);
        
        $this->render('show', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $model = new ProductPricingRequest;
        $model->user_id_request = Yii::app()->user->id;
        $model->request_date = date('Y-m-d');
        $model->request_time = date('H:i:s');
        $model->branch_id_request = Yii::app()->user->branch_id;
        $model->user_id_reply = null;
        $model->reply_date = null;
        $model->reply_time = null;
        $model->reply_note = null;
        $model->recommended_price = '0.00';
        $model->branch_id_reply = null;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ProductPricingRequest']) && IdempotentManager::check()) {
            $model->attributes = $_POST['ProductPricingRequest'];
            
            $fileName = CUploadedFile::getInstanceByName('file');
            if ($fileName !== null) {
                $model->file = $fileName;
                $model->extension = $fileName->extensionName;
            }

            if ($model->save(Yii::app()->db)) {
                if ($fileName !== null) {
                    $this->saveImageFile($model);
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
        $model->user_id_reply = Yii::app()->user->id;
        $model->reply_date = date('Y-m-d');
        $model->reply_time = date('H:i:s');
        $model->branch_id_reply = Yii::app()->user->branch_id;

        if (isset($_POST['ProductPricingRequest'])) {
            $model->attributes = $_POST['ProductPricingRequest'];
            
            if ($model->save(Yii::app()->db)) {
                $this->redirect(array('show', 'id' => $model->id));
            } 
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function saveImageFile($model) {
        $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/product_pricing_request/' . $model->id . '.' . $model->extension;
        $model->file->saveAs($originalPath);
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductPricingRequest('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ProductPricingRequest'])) {
            $model->attributes = $_GET['ProductPricingRequest'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAjaxGetVehicleCarModel() {
        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $_POST['ProductPricingRequest']['vehicle_car_make_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Vehicle Car Model--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Vehicle Car Model--]', true);
        }
    }

    public function actionAjaxGetSubBrand() {
        $data = SubBrand::model()->findAllByAttributes(array('brand_id' => $_POST['ProductPricingRequest']['brand_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand--]', true);
        }
    }

    public function actionAjaxGetSubBrandSeries() {
        $data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $_POST['ProductPricingRequest']['sub_brand_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand Series--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand Series--]', true);
        }
    }

    public function actionAjaxGetProductSubMasterCategory() {
        $data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $_POST['ProductPricingRequest']['product_master_category_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'nameAndCode');
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
        }
    }

    public function actionAjaxGetProductSubCategory() {
        $data = ProductSubCategory::model()->findAllByAttributes(array('product_master_category_id' => $_POST['ProductPricingRequest']['product_master_category_id'], 'product_sub_master_category_id' => $_POST['ProductPricingRequest']['product_sub_master_category_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'nameAndCode');
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Category--]', true);
        }
    }

    public function loadModel($id) {
        $model = ProductPricingRequest::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }
}