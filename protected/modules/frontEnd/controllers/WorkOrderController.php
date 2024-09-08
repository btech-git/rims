<?php

class WorkOrderController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'view' 
        ) {
            if (!(Yii::app()->user->checkAccess('workOrderApproval'))) {
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
        $details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $model->registration_transaction_id));
        $this->render('view', array(
            'model' => $model,
            'details' => $details,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new WorkOrder;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['WorkOrder'])) {
            $model->attributes = $_POST['WorkOrder'];
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

        if (isset($_POST['WorkOrder'])) {
            $model->attributes = $_POST['WorkOrder'];
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
        $dataProvider = new CActiveDataProvider('WorkOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $modelDataProvider = $model->searchByWorkOrder();
        $modelDataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $modelDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;

        $this->render('admin', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
        ));
    }

    public function actionAdminProcessing() {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $dataProvider = $model->searchByProcessingWorkOrder();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;

        $this->render('adminProcessing', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAjaxHtmlUpdateCarModelSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $carMakeId = isset($_GET['RegistrationTransaction']['car_make_code']) ? $_GET['RegistrationTransaction']['car_make_code'] : '';
//            $carModelId = isset($_GET['CarModelId']) ? $_GET['CarModelId'] : '';

            $this->renderPartial('_carModelSelect', array(
                'model' => $model,
                'carMakeId' => $carMakeId,
            ));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return WorkOrder the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = WorkOrder::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param WorkOrder $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'work-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
