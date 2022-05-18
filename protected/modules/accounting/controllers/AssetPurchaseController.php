<?php

class AssetPurchaseController extends Controller {

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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new AssetPurchase;
        $model->transaction_time = date('H:i:s');
        $model->user_id = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AssetPurchase'])) {
            $model->attributes = $_POST['AssetPurchase'];
            $model->accumulated_depreciation_value = 0.00;
            $model->current_value = $model->purchase_value;
            $model->monthly_useful_life = $model->assetCategory->number_of_years * 12;
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->transaction_date)), 6);
            
            if ($model->save()) {
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $model->transaction_number,
                ));

                $jurnalInventory = new JurnalUmum;
                $jurnalInventory->kode_transaksi = $model->transaction_number;
                $jurnalInventory->tanggal_transaksi = $model->transaction_date;
                $jurnalInventory->coa_id = $model->assetCategory->coa_inventory_id;
                $jurnalInventory->branch_id = 6;
                $jurnalInventory->total = $model->purchase_value;
                $jurnalInventory->debet_kredit = 'D';
                $jurnalInventory->tanggal_posting = date('Y-m-d');
                $jurnalInventory->transaction_subject = 'Pembelian Aset Tetap';
                $jurnalInventory->is_coa_category = 0;
                $jurnalInventory->transaction_type = 'PFA';
                $jurnalInventory->save();

                $jurnalBanking = new JurnalUmum;
                $jurnalBanking->kode_transaksi = $model->transaction_number;
                $jurnalBanking->tanggal_transaksi = $model->transaction_date;
                $jurnalBanking->coa_id = $model->companyBank->coa_id;
                $jurnalBanking->branch_id = 6;
                $jurnalBanking->total = $model->purchase_value;
                $jurnalBanking->debet_kredit = 'K';
                $jurnalBanking->tanggal_posting = date('Y-m-d');
                $jurnalBanking->transaction_subject = 'Pembelian Aset Tetap';
                $jurnalBanking->is_coa_category = 0;
                $jurnalBanking->transaction_type = 'PFA';
                $jurnalBanking->save();

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

        if (isset($_POST['AssetPurchase'])) {
            $model->attributes = $_POST['AssetPurchase'];
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
        $dataProvider = new CActiveDataProvider('AssetPurchase');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AssetPurchase('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AssetPurchase']))
            $model->attributes = $_GET['AssetPurchase'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AssetPurchase the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AssetPurchase::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AssetPurchase $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asset-purchase-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
