<?php

class ServiceTypeController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('masterServiceTypeCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('masterServiceTypeEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'restore') {
            if (!(Yii::app()->user->checkAccess('masterServiceTypeApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(
                Yii::app()->user->checkAccess('masterServiceTypeCreate') || 
                Yii::app()->user->checkAccess('masterServiceTypeEdit') || 
                Yii::app()->user->checkAccess('masterServiceTypeView')
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
        $model = new ServiceType;
        $model->user_id_created = Yii::app()->user->id;
        $model->created_datetime = date('Y-m-d H:i:s');
        
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values

        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id IN (4, 5, 6, 24, 28, 29, 30, 31, 47, 50, 51)");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);
        $coaCriteria->compare('coa_sub_category_id', $coa->coa_sub_category_id);
        $coaCriteria->compare('coa_category_id', $coa->coa_category_id);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $coaDiskon = new Coa('search');
        $coaDiskon->unsetAttributes();  // clear any default values

        if (isset($_GET['Coa'])) {
            $coaDiskon->attributes = $_GET['Coa'];
        }

        $coaDiskonCriteria = new CDbCriteria;
        $coaDiskonCriteria->addCondition("coa_sub_category_id IN (28, 30)");
        $coaDiskonCriteria->compare('code', $coaDiskon->code . '%', true, 'AND', false);
        $coaDiskonCriteria->compare('name', $coaDiskon->name, true);
        $coaDiskonCriteria->compare('coa_sub_category_id', $coaDiskon->coa_sub_category_id);
        $coaDiskonCriteria->compare('coa_category_id', $coaDiskon->coa_category_id);

        $coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonCriteria,
        ));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ServiceType'])) {
            $model->attributes = $_POST['ServiceType'];

            if ($model->save()) {
                $this->saveMasterLog($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'coaDiskon' => $coaDiskon,
            'coaDiskonDataProvider' => $coaDiskonDataProvider,
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
        
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id IN (4, 5, 6, 24, 28, 29, 30, 31, 47, 50, 51)");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);
        $coaCriteria->compare('coa_sub_category_id', $coa->coa_sub_category_id);
        $coaCriteria->compare('coa_category_id', $coa->coa_category_id);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $coaDiskon = new Coa('search');
        $coaDiskon->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaDiskon->attributes = $_GET['Coa'];
        }

        $coaDiskonCriteria = new CDbCriteria;
        $coaDiskonCriteria->addCondition("coa_sub_category_id IN (28, 30)");
        $coaDiskonCriteria->compare('code', $coaDiskon->code . '%', true, 'AND', false);
        $coaDiskonCriteria->compare('name', $coaDiskon->name, true);
        $coaDiskonCriteria->compare('coa_sub_category_id', $coaDiskon->coa_sub_category_id);
        $coaDiskonCriteria->compare('coa_category_id', $coaDiskon->coa_category_id);

        $coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonCriteria,
        ));

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ServiceType'])) {
            $model->attributes = $_POST['ServiceType'];

            if ($model->save()) {
                $this->saveMasterLog($model);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'coaDiskon' => $coaDiskon,
            'coaDiskonDataProvider' => $coaDiskonDataProvider,
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

    public function actionRestore($id) {
        // var_dump($id); die("S");
        $this->loadModel($id)->restore();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ServiceType');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {

        $model = new ServiceType('search');
        //$model->disableBehavior('SoftDelete');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ServiceType'])) {
            $model->attributes = $_GET['ServiceType'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function saveMasterLog($model) {
        $transactionLog = new MasterLog();
        $transactionLog->name = $model->name;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $model->tableName();
        $transactionLog->table_id = $model->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $model->attributes;
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function loadModel($id) {
        $model = ServiceType::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ServiceType $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-type-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxCoa($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $coa = Coa::model()->findByPk($id);

            $object = array(
                'id' => $coa->id,
                'code' => $coa->code,
                'name' => $coa->name,
            );

            echo CJSON::encode($object);
        }
    }

}
