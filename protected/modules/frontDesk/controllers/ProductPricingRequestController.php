<?php

class ProductPricingRequestController extends Controller {

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
                $this->redirect(array('view', 'id' => $model->id));
            } 
        }
        $this->render('update', array(
            'model' => $model,
        ));
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

    public function loadModel($id) {
        $model = ProductPricingRequest::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }
}