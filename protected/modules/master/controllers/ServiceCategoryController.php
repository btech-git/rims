<?php

class ServiceCategoryController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('masterServiceCategoryCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'restore'
        ) {
            if (!(Yii::app()->user->checkAccess('masterServiceCategoryEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'profile' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterServiceCategoryCreate')) || !(Yii::app()->user->checkAccess('masterServiceCategoryEdit')))
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
        $model = new ServiceCategory;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        if (isset($_POST['ServiceCategory'])) {
            $model->attributes = $_POST['ServiceCategory'];
            
            $existingCoaHpp = Coa::model()->findByAttributes(array('coa_id' => $model->serviceType->coa_id), array('order' => 'id DESC'));
            $ordinalHpp = empty($existingCoaHpp) ? 0 : substr($existingCoaHpp->code, -3);
            $prefixHpp = empty($existingCoaHpp) ? '411.00.' : substr($existingCoaHpp->code, 0, 7);
            $newOrdinalHpp = $ordinalHpp + 1;
            $coaHpp = new Coa;
            $coaHpp->name = $model->name;
            $coaHpp->code = $prefixHpp . sprintf('%03d', $newOrdinalHpp);
            $coaHpp->coa_category_id = 6;
            $coaHpp->coa_sub_category_id = 24;
            $coaHpp->coa_id = $model->serviceType->coa_id;
            $coaHpp->normal_balance = 'KREDIT';
            $coaHpp->cash_transaction = 'NO';
            $coaHpp->opening_balance = 0.00;
            $coaHpp->closing_balance = 0.00;
            $coaHpp->debit = 0.00;
            $coaHpp->credit = 0.00;
            $coaHpp->status = 'Approved';
            $coaHpp->date = date('Y-m-d');
            $coaHpp->date_approval = date('Y-m-d');
            $coaHpp->time_created = date('H:i:s');
            $coaHpp->time_approval = date('H:i:s');
            $coaHpp->is_approved = 1;
            $coaHpp->user_id = Yii::app()->user->id;
            $coaHpp->user_id_approval = Yii::app()->user->id;
            $coaHpp->save();

            $existingCoaDiskon = Coa::model()->findByAttributes(array('coa_id' => $model->serviceType->coa_diskon_service), array('order' => 'id DESC'));
            $ordinalDiskon = empty($existingCoaDiskon) ? 0 : substr($existingCoaDiskon->code, -3);
            $prefixDiskon = empty($existingCoaDiskon) ? '412.00.' : substr($existingCoaDiskon->code, 0, 7);
            $newOrdinalDiskon = $ordinalDiskon + 1;
            $coaDiskon = new Coa;
            $coaDiskon->name = 'Diskon Pendapatan Jasa - ' . $model->name;
            $coaDiskon->code = $prefixDiskon . sprintf('%03d', $newOrdinalDiskon);
            $coaDiskon->coa_category_id = 6;
            $coaDiskon->coa_sub_category_id = 28;
            $coaDiskon->coa_id = $model->serviceType->coa_diskon_service;
            $coaDiskon->normal_balance = 'DEBIT';
            $coaDiskon->cash_transaction = 'NO';
            $coaDiskon->opening_balance = 0.00;
            $coaDiskon->closing_balance = 0.00;
            $coaDiskon->debit = 0.00;
            $coaDiskon->credit = 0.00;
            $coaDiskon->status = 'Approved';
            $coaDiskon->date = date('Y-m-d');
            $coaDiskon->date_approval = date('Y-m-d');
            $coaDiskon->time_created = date('H:i:s');
            $coaDiskon->time_approval = date('H:i:s');
            $coaDiskon->is_approved = 1;
            $coaDiskon->user_id = Yii::app()->user->id;
            $coaDiskon->user_id_approval = Yii::app()->user->id;
            $coaDiskon->save();

            $model->coa_id = $coaHpp->id;
            $model->coa_diskon_service = $coaDiskon->id;
            
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
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

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
        if (isset($_GET['Coa']))
            $coaDiskon->attributes = $_GET['Coa'];

        $coaDiskonCriteria = new CDbCriteria;
        $coaDiskonCriteria->addCondition("coa_sub_category_id IN (28, 30)");
        $coaDiskonCriteria->compare('code', $coaDiskon->code . '%', true, 'AND', false);
        $coaDiskonCriteria->compare('name', $coaDiskon->name, true);
        $coaDiskonCriteria->compare('coa_sub_category_id', $coaDiskon->coa_sub_category_id);
        $coaDiskonCriteria->compare('coa_category_id', $coaDiskon->coa_category_id);

        $coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonCriteria,
        ));

        if (isset($_POST['ServiceCategory'])) {
            $model->attributes = $_POST['ServiceCategory'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
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
        $this->loadModel($id)->remove();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionRestore($id) {
        // var_dump($id); die("S");
        $this->loadModel($id)->restore();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('ServiceCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ServiceCategory('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ServiceCategory'])) {
            $model->attributes = $_GET['ServiceCategory'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ServiceCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ServiceCategory::model()->findByPk((int) $id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ServiceCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-category-form') {
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
