<?php

class AssetSaleController extends Controller {

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

        $assetSale = Search::bind(new AssetPurchase('search'), isset($_GET['AssetPurchase']) ? $_GET['AssetPurchase'] : array());
        $assetSaleDataProvider = $assetSale->searchBySale();

        $this->render('assetList', array(
            'assetSale' => $assetSale,
            'assetSaleDataProvider' => $assetSaleDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($assetId) {
        $model = new AssetSale;
        $model->asset_purchase_id = $assetId;
        $model->transaction_time = date('H:i:s');
        $model->user_id = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AssetSale'])) {
            $model->attributes = $_POST['AssetSale'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->transaction_date)), 6);
            
            if ($model->save()) {
                $assetSale = AssetPurchase::model()->findByPk($assetId);
                $assetSale->status = 'Terjual';
                $assetSale->update(array('status'));
                
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $model->transaction_number,
                ));

                $jurnalSale = new JurnalUmum;
                $jurnalSale->kode_transaksi = $model->transaction_number;
                $jurnalSale->tanggal_transaksi = $model->transaction_date;
                $jurnalSale->coa_id = $model->companyBank->coa_id;
                $jurnalSale->branch_id = 6;
                $jurnalSale->total = $model->sale_price;
                $jurnalSale->debet_kredit = 'D';
                $jurnalSale->tanggal_posting = date('Y-m-d');
                $jurnalSale->transaction_subject = 'Penjualan Aset Tetap';
                $jurnalSale->is_coa_category = 0;
                $jurnalSale->transaction_type = 'SFA';
                $jurnalSale->save();

                $jurnalAccumulation = new JurnalUmum;
                $jurnalAccumulation->kode_transaksi = $model->transaction_number;
                $jurnalAccumulation->tanggal_transaksi = $model->transaction_date;
                $jurnalAccumulation->coa_id = $model->assetPurchase->assetCategory->coa_accumulation_id;
                $jurnalAccumulation->branch_id = 6;
                $jurnalAccumulation->total = $model->assetPurchase->accumulated_depreciation_value;
                $jurnalAccumulation->debet_kredit = 'D';
                $jurnalAccumulation->tanggal_posting = date('Y-m-d');
                $jurnalAccumulation->transaction_subject = 'Penjualan Aset Tetap';
                $jurnalAccumulation->is_coa_category = 0;
                $jurnalAccumulation->transaction_type = 'SFA';
                $jurnalAccumulation->save();

                if ($model->sale_price > $model->assetPurchase->purchase_value) {
                    $jurnalOtherIncome = new JurnalUmum;
                    $jurnalOtherIncome->kode_transaksi = $model->transaction_number;
                    $jurnalOtherIncome->tanggal_transaksi = $model->transaction_date;
                    $jurnalOtherIncome->coa_id = 796;
                    $jurnalOtherIncome->branch_id = 6;
                    $jurnalOtherIncome->total = $model->sale_price + $model->assetPurchase->accumulated_depreciation_value - $model->assetPurchase->purchase_value;
                    $jurnalOtherIncome->debet_kredit = 'K';
                    $jurnalOtherIncome->tanggal_posting = date('Y-m-d');
                    $jurnalOtherIncome->transaction_subject = 'Penjualan Aset Tetap';
                    $jurnalOtherIncome->is_coa_category = 0;
                    $jurnalOtherIncome->transaction_type = 'SFA';
                    $jurnalOtherIncome->save();
                } else {
                    $jurnalOtherIncome = new JurnalUmum;
                    $jurnalOtherIncome->kode_transaksi = $model->transaction_number;
                    $jurnalOtherIncome->tanggal_transaksi = $model->transaction_date;
                    $jurnalOtherIncome->coa_id = 1491;
                    $jurnalOtherIncome->branch_id = 6;
                    $jurnalOtherIncome->total = $model->assetPurchase->purchase_value - $model->sale_price + $model->assetPurchase->accumulated_depreciation_value;
                    $jurnalOtherIncome->debet_kredit = 'D';
                    $jurnalOtherIncome->tanggal_posting = date('Y-m-d');
                    $jurnalOtherIncome->transaction_subject = 'Penjualan Aset Tetap';
                    $jurnalOtherIncome->is_coa_category = 0;
                    $jurnalOtherIncome->transaction_type = 'SFA';
                    $jurnalOtherIncome->save();
                }

                $jurnalInventory = new JurnalUmum;
                $jurnalInventory->kode_transaksi = $model->transaction_number;
                $jurnalInventory->tanggal_transaksi = $model->transaction_date;
                $jurnalInventory->coa_id = $model->assetPurchase->assetCategory->coa_inventory_id;
                $jurnalInventory->branch_id = 6;
                $jurnalInventory->total = $model->assetPurchase->purchase_value;
                $jurnalInventory->debet_kredit = 'K';
                $jurnalInventory->tanggal_posting = date('Y-m-d');
                $jurnalInventory->transaction_subject = 'Penjualan Aset Tetap';
                $jurnalInventory->is_coa_category = 0;
                $jurnalInventory->transaction_type = 'SFA';
                $jurnalInventory->save();

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

        if (isset($_POST['AssetSale'])) {
            $model->attributes = $_POST['AssetSale'];
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
        $dataProvider = new CActiveDataProvider('AssetSale');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new AssetSale('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['AssetSale']))
            $model->attributes = $_GET['AssetSale'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return AssetSale the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = AssetSale::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param AssetSale $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'asset-sale-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
