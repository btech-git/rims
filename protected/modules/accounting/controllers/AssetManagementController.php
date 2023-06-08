<?php

class AssetManagementController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
                $filterChain->action->id === 'create' || 
                $filterChain->action->id === 'delete' || 
                $filterChain->action->id === 'update' || 
                $filterChain->action->id === 'admin' || 
                $filterChain->action->id === 'ajaxHtmlResetPayment' || 
                $filterChain->action->id === 'ajaxHtmlRemovePayment' || 
                $filterChain->action->id === 'ajaxHtmlAddAccount' || 
                $filterChain->action->id === 'ajaxJsonTotal' || 
                $filterChain->action->id === 'ajaxJsonSaleReceipt' || 
                $filterChain->action->id === 'memo' || 
                $filterChain->action->id === 'view'
            ) {
            if (!(Yii::app()->user->checkAccess('assetManagement'))) {
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
    public function actionCreatePurchase() {
        $model = new AssetPurchase;
        $model->transaction_time = date('H:i:s');
        $model->status = 'Draft';
        $model->user_id = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $model->attributes = $_POST['AssetPurchase'];
            $model->accumulated_depreciation_value = 0.00;
            $model->depreciation_start_date = date('Y-m-d');
            $model->depreciation_end_date = date('Y-m-d', strtotime($model->depreciation_start_date . ' + ' . $model->assetCategory->number_of_years . ' years'));
            $model->current_value = $model->purchase_value;
            $model->monthly_useful_life = empty($model->assetCategory) ? 0 : $model->assetCategory->number_of_years * 12;
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->transaction_date)), 6);
            
            if ($model->save() && IdempotentManager::build()->save()) {
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
                $jurnalInventory->transaction_subject = $model->note;
                $jurnalInventory->is_coa_category = 0;
                $jurnalInventory->transaction_type = 'PFA';
                $jurnalInventory->save();

//                $companyBank = CompanyBank::model()->findByAttributes(array('company_id' => 1, 'bank_id' => $model->bank_id));
                $jurnalBanking = new JurnalUmum;
                $jurnalBanking->kode_transaksi = $model->transaction_number;
                $jurnalBanking->tanggal_transaksi = $model->transaction_date;
                $jurnalBanking->coa_id = empty($model->companyBank->coa_id) ? 7 : $model->companyBank->coa_id;
                $jurnalBanking->branch_id = 6;
                $jurnalBanking->total = $model->purchase_value;
                $jurnalBanking->debet_kredit = 'K';
                $jurnalBanking->tanggal_posting = date('Y-m-d');
                $jurnalBanking->transaction_subject = $model->note;
                $jurnalBanking->is_coa_category = 0;
                $jurnalBanking->transaction_type = 'PFA';
                $jurnalBanking->save();

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('createPurchase', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateSale($id) {
        $model = new AssetSale;
        $model->asset_purchase_id = $id;
        $model->transaction_time = date('H:i:s');
        $model->user_id = Yii::app()->user->id;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['AssetSale']) && IdempotentManager::check()) {
            $model->attributes = $_POST['AssetSale'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->transaction_date)), 6);
            
            if ($model->save() && IdempotentManager::build()->save()) {
                $assetSale = AssetPurchase::model()->findByPk($id);
                $assetSale->status = 'Sold';
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
                $jurnalSale->transaction_subject = $model->note;
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
                $jurnalAccumulation->transaction_subject = $model->note;
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
                    $jurnalOtherIncome->transaction_subject = $model->note;
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
                    $jurnalOtherIncome->transaction_subject = $model->note;
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
                $jurnalInventory->transaction_subject = $model->note;
                $jurnalInventory->is_coa_category = 0;
                $jurnalInventory->transaction_type = 'SFA';
                $jurnalInventory->save();

                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('createSale', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreateDepreciation() {
        $assetDepreciation = $this->instantiate(null);
        $assetDepreciation->header->transaction_date = date('Y-m-t');
        $assetDepreciation->header->transaction_time = date('H:i:s');
        $assetDepreciation->header->user_id = Yii::app()->user->id;
        
        $assetDepreciation->addAsset();
        
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($assetDepreciation);
            $assetDepreciation->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($assetDepreciation->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($assetDepreciation->header->transaction_date)), 6);
            
            if ($assetDepreciation->save(Yii::app()->db)) {                
                $this->redirect(array('admin'));
            }
        }

        $this->render('createDepreciation', array(
            'assetDepreciation' => $assetDepreciation,
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

        if (isset($_POST['AssetPurchase']) && IdempotentManager::check()) {
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

    public function instantiate($id) {
        if (empty($id)) {
            $assetDepreciation = new AssetDepreciation(new AssetDepreciationHeader(), array());
        } else {
            $assetDepreciationHeader = $this->loadModelDepreciation($id);
            $assetDepreciation = new AssetDepreciation($assetDepreciationHeader, $assetDepreciationHeader->assetDepreciationDetails);
        }

        return $assetDepreciation;
    }

    public function loadModelDepreciation($id) {
        $model = AssetDepreciationHeader::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function loadState(&$assetDepreciation) {
        if (isset($_POST['AssetDepreciationHeader'])) {
            $assetDepreciation->header->attributes = $_POST['AssetDepreciationHeader'];
        }
        
        if (isset($_POST['AssetDepreciationDetail'])) {
            foreach ($_POST['AssetDepreciationDetail'] as $i => $item) {
                if (isset($assetDepreciation->details[$i]))
                    $assetDepreciation->details[$i]->attributes = $item;
                else {
                    $detail = new AssetDepreciationDetail();
                    $detail->attributes = $item;
                    $assetDepreciation->details[] = $detail;
                }
            }
            
            if (count($_POST['AssetDepreciationDetail']) < count($assetDepreciation->details)) {
                array_splice($assetDepreciation->details, $i + 1);
            }
        } else {
            $assetDepreciation->details = array();
        }
    }
}
