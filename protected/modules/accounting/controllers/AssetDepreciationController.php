<?php

class AssetDepreciationController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'ajaxHtmlResetPayment' || $filterChain->action->id === 'ajaxHtmlRemovePayment' || $filterChain->action->id === 'ajaxHtmlAddAccount' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxJsonSaleReceipt' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('salePaymentEdit')))
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

    public function actionAssetList() {

        $assetPurchase = Search::bind(new AssetPurchase('search'), isset($_GET['AssetPurchase']) ? $_GET['AssetPurchase'] : array());
        $assetPurchaseDataProvider = $assetPurchase->searchByDepreciation();

        $this->render('assetList', array(
            'assetPurchase' => $assetPurchase,
            'assetPurchaseDataProvider' => $assetPurchaseDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($assetId) {
        $model = new AssetDepreciation;
        $model->asset_purchase_id = $assetId;
        $model->transaction_time = date('H:i:s');
        $model->user_id = Yii::app()->user->id;
        $assetPurchase = AssetPurchase::model()->findByPk($assetId);
        $model->amount = $assetPurchase->monthlyDepreciationAmount;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AssetDepreciation'])) {
            $model->attributes = $_POST['AssetDepreciation'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->transaction_date)), 6);
            
            if ($model->save()) {
                $assetPurchase->accumulated_depreciation_value = $assetPurchase->totalDepreciationValue;
                $assetPurchase->current_value = $assetPurchase->purchase_value - $assetPurchase->totalDepreciationValue;
                $assetPurchase->status = 'Depresiasi ke ' . $model->number_of_month;
                $assetPurchase->update(array('accumulated_depreciation_value', 'current_value', 'status'));
                
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $model->transaction_number,
                ));

                $jurnalExpense = new JurnalUmum;
                $jurnalExpense->kode_transaksi = $model->transaction_number;
                $jurnalExpense->tanggal_transaksi = $model->transaction_date;
                $jurnalExpense->coa_id = $model->assetPurchase->assetCategory->coa_expense_id;
                $jurnalExpense->branch_id = 6;
                $jurnalExpense->total = $model->amount;
                $jurnalExpense->debet_kredit = 'D';
                $jurnalExpense->tanggal_posting = date('Y-m-d');
                $jurnalExpense->transaction_subject = 'Depresiasi Aset Tetap';
                $jurnalExpense->is_coa_category = 0;
                $jurnalExpense->transaction_type = 'DFA';
                $jurnalExpense->save();

                $jurnalAccumulation = new JurnalUmum;
                $jurnalAccumulation->kode_transaksi = $model->transaction_number;
                $jurnalAccumulation->tanggal_transaksi = $model->transaction_date;
                $jurnalAccumulation->coa_id = $model->assetPurchase->assetCategory->coa_accumulation_id;
                $jurnalAccumulation->branch_id = 6;
                $jurnalAccumulation->total = $model->amount;
                $jurnalAccumulation->debet_kredit = 'K';
                $jurnalAccumulation->tanggal_posting = date('Y-m-d');
                $jurnalAccumulation->transaction_subject = 'Depresiasi Aset Tetap';
                $jurnalAccumulation->is_coa_category = 0;
                $jurnalAccumulation->transaction_type = 'DFA';
                $jurnalAccumulation->save();

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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AssetDepreciation'])) {
            $model->attributes = $_POST['AssetDepreciation'];
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
        $dataProvider = new CActiveDataProvider('AssetDepreciation');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AssetDepreciation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AssetDepreciation']))
            $model->attributes = $_GET['AssetDepreciation'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AssetDepreciation the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AssetDepreciation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AssetDepreciation $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asset-depreciation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
