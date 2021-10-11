<?php

class ServicePricelistController extends Controller {

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
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'profile' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'restore'
        ) {
            if (!(Yii::app()->user->checkAccess('frontOfficeHead')) || !(Yii::app()->user->checkAccess('operationHead')))
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
        $model = new ServicePricelist;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ServicePricelist'])) {
            $model->attributes = $_POST['ServicePricelist'];
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

        if (isset($_POST['ServicePricelist'])) {
            $model->attributes = $_POST['ServicePricelist'];
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
        $dataProvider = new CActiveDataProvider('ServicePricelist');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ServicePricelist('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ServicePricelist']))
            $model->attributes = $_GET['ServicePricelist'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ServicePricelist the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ServicePricelist::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ServicePricelist $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-pricelist-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    // Get Car Model
    public function actionAjaxGetModel() {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarSubModels', 'vehicleCarSubModels.vehicleCarSubModelDetails');
        $criteria->together = true;
        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $_POST['ServicePricelist']['car_make_id']), $criteria);

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Model--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Model--]', true);
        }
    }

    public function actionAjaxGetPrice($diff, $lux, $standard, $fr) {
        if (Yii::app()->request->isAjaxRequest) {
            $price = 0;

            $price = $diff * $lux * $standard * $fr;
            $object = array('diff' => $diff, 'lux' => $lux, 'standard' => $standard, 'fr' => $fr, 'price' => $price);
            echo CJSON::encode($object);
        }
    }

    // Get Car Sub Model
    public function actionAjaxGetSubModel() {
        $criteria = new CDbCriteria;
        $criteria->with = array('vehicleCarSubModelDetails');
        $criteria->together = true;
        $criteria->order = 't.name ASC';

        $data = VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id' => $_POST['ServicePricelist']['car_make_id'], 'car_model_id' => $_POST['ServicePricelist']['car_model_id']), $criteria);

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Sub Model--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Sub Model--]', true);
        }
    }

}
