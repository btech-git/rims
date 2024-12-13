<?php

class ProductSubMasterCategoryController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate')) || !(Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit')))
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
        
        if (isset($_POST['Approve']) && (int) $model->is_approved !== 1) {
            $model->is_approved = 1;
            $model->user_id_approval = Yii::app()->user->getId();
            $model->date_approval = date('Y-m-d H:i:s');
            
            if ($model->save(true, array('is_approved', 'user_id_approval', 'date_approval'))) {
                Yii::app()->user->setFlash('confirm', 'Your data has been approved!!!');
            }
            
        } elseif (isset($_POST['Reject'])) {
            $model->is_approved = 2;
            
            if ($model->save(true, array('is_approved'))) {
                Yii::app()->user->setFlash('confirm', 'Your data has been rejected!!!');
            }
        }

        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new ProductSubMasterCategory;
        $model->user_id = Yii::app()->user->id;
        $model->user_id_approval = null;
        $model->date_posting = date('Y-m-d H:i:s');
        $model->date_approval = null;

        if (isset($_POST['ProductSubMasterCategory'])) {
            $model->attributes = $_POST['ProductSubMasterCategory'];
            
            $existingCoaPersediaan = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_persediaan_barang_dagang), array('order' => 'id DESC'));
            $ordinalPersediaan = empty($existingCoaPersediaan) ? 0 : substr($existingCoaPersediaan->code, -3);
            $prefixPersediaan = empty($existingCoaPersediaan) ? '131.00.' : substr($existingCoaPersediaan->code, 0, 7);
            $newOrdinalPersediaan = $ordinalPersediaan + 1;
            $coaPersediaan = new Coa;
            $coaPersediaan->name = $model->name;
            $coaPersediaan->code = $prefixPersediaan . sprintf('%03d', $newOrdinalPersediaan);
            $coaPersediaan->coa_category_id = 16;
            $coaPersediaan->coa_sub_category_id = 4;
            $coaPersediaan->coa_id = $model->productMasterCategory->coa_persediaan_barang_dagang;
            $coaPersediaan->normal_balance = 'DEBIT';
            $coaPersediaan->cash_transaction = 'NO';
            $coaPersediaan->opening_balance = 0.00;
            $coaPersediaan->closing_balance = 0.00;
            $coaPersediaan->debit = 0.00;
            $coaPersediaan->credit = 0.00;
            $coaPersediaan->status = 'Approved';
            $coaPersediaan->date = date('Y-m-d');
            $coaPersediaan->date_approval = date('Y-m-d');
            $coaPersediaan->time_created = date('H:i:s');
            $coaPersediaan->time_approval = date('H:i:s');
            $coaPersediaan->is_approved = 1;
            $coaPersediaan->user_id = Yii::app()->user->id;
            $coaPersediaan->user_id_approval = Yii::app()->user->id;
            $coaPersediaan->save();

            $existingCoaHpp = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_hpp), array('order' => 'id DESC'));
            $ordinalHpp = empty($existingCoaHpp) ? 0 : substr($existingCoaHpp->code, -3);
            $prefixHpp = empty($existingCoaHpp) ? '501.00.' : substr($existingCoaHpp->code, 0, 7);
            $newOrdinalHpp = $ordinalHpp + 1;
            $coaHpp = new Coa;
            $coaHpp->name = 'HPP ' . $model->name;
            $coaHpp->code = $prefixHpp . sprintf('%03d', $newOrdinalHpp);
            $coaHpp->coa_category_id = 7;
            $coaHpp->coa_sub_category_id = 47;
            $coaHpp->coa_id = $model->productMasterCategory->coa_hpp;
            $coaHpp->normal_balance = 'DEBIT';
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

            $existingCoaPenjualan = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_penjualan_barang_dagang), array('order' => 'id DESC'));
            $ordinalPenjualan = empty($existingCoaPenjualan) ? 0 : substr($existingCoaPenjualan->code, -3);
            $prefixPenjualan = empty($existingCoaPenjualan) ? '421.00.' : substr($existingCoaPenjualan->code, 0, 7);
            $newOrdinalPenjualan = $ordinalPenjualan + 1;
            $coaPenjualan = new Coa;
            $coaPenjualan->name = 'Penjualan ' . $model->name;
            $coaPenjualan->code = $prefixHpp . sprintf('%03d', $newOrdinalPenjualan);
            $coaPenjualan->coa_category_id = 6;
            $coaPenjualan->coa_sub_category_id = 29;
            $coaPenjualan->coa_id = $model->productMasterCategory->coa_penjualan_barang_dagang;
            $coaPenjualan->normal_balance = 'DEBIT';
            $coaPenjualan->cash_transaction = 'NO';
            $coaPenjualan->opening_balance = 0.00;
            $coaPenjualan->closing_balance = 0.00;
            $coaPenjualan->debit = 0.00;
            $coaPenjualan->credit = 0.00;
            $coaPenjualan->status = 'Approved';
            $coaPenjualan->date = date('Y-m-d');
            $coaPenjualan->date_approval = date('Y-m-d');
            $coaPenjualan->time_created = date('H:i:s');
            $coaPenjualan->time_approval = date('H:i:s');
            $coaPenjualan->is_approved = 1;
            $coaPenjualan->user_id = Yii::app()->user->id;
            $coaPenjualan->user_id_approval = Yii::app()->user->id;
            $coaPenjualan->save();
            
            $existingCoaRetur = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_retur_penjualan), array('order' => 'id DESC'));
            $ordinalRetur = empty($existingCoaRetur) ? 0 : substr($existingCoaRetur->code, -3);
            $prefixRetur = empty($existingCoaRetur) ? '423.00.' : substr($existingCoaRetur->code, 0, 7);
            $newOrdinalRetur = $ordinalRetur + 1;
            $coaRetur = new Coa;
            $coaRetur->name = 'Retur Penjualan ' . $model->name;
            $coaRetur->code = $prefixRetur . sprintf('%03d', $newOrdinalRetur);
            $coaRetur->coa_category_id = 6;
            $coaRetur->coa_sub_category_id = 31;
            $coaRetur->coa_id = $model->productMasterCategory->coa_retur_penjualan;
            $coaRetur->normal_balance = 'DEBIT';
            $coaRetur->cash_transaction = 'NO';
            $coaRetur->opening_balance = 0.00;
            $coaRetur->closing_balance = 0.00;
            $coaRetur->debit = 0.00;
            $coaRetur->credit = 0.00;
            $coaRetur->status = 'Approved';
            $coaRetur->date = date('Y-m-d');
            $coaRetur->date_approval = date('Y-m-d');
            $coaRetur->time_created = date('H:i:s');
            $coaRetur->time_approval = date('H:i:s');
            $coaRetur->is_approved = 1;
            $coaRetur->user_id = Yii::app()->user->id;
            $coaRetur->user_id_approval = Yii::app()->user->id;
            $coaRetur->save();
            
            $existingCoaDiskonJual = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_diskon_penjualan), array('order' => 'id DESC'));
            $ordinalDiskonJual = empty($existingCoaDiskonJual) ? 0 : substr($existingCoaDiskonJual->code, -3);
            $prefixDiskonJual = empty($existingCoaDiskonJual) ? '422.00.' : substr($existingCoaDiskonJual->code, 0, 7);
            $newOrdinalDiskonJual = $ordinalDiskonJual + 1;
            $coaDiskonJual = new Coa;
            $coaDiskonJual->name = 'Diskon Penjualan ' . $model->name;
            $coaDiskonJual->code = $prefixDiskonJual . sprintf('%03d', $newOrdinalDiskonJual);
            $coaDiskonJual->coa_category_id = 6;
            $coaDiskonJual->coa_sub_category_id = 30;
            $coaDiskonJual->coa_id = $model->productMasterCategory->coa_diskon_penjualan;
            $coaDiskonJual->normal_balance = 'DEBIT';
            $coaDiskonJual->cash_transaction = 'NO';
            $coaDiskonJual->opening_balance = 0.00;
            $coaDiskonJual->closing_balance = 0.00;
            $coaDiskonJual->debit = 0.00;
            $coaDiskonJual->credit = 0.00;
            $coaDiskonJual->status = 'Approved';
            $coaDiskonJual->date = date('Y-m-d');
            $coaDiskonJual->date_approval = date('Y-m-d');
            $coaDiskonJual->time_created = date('H:i:s');
            $coaDiskonJual->time_approval = date('H:i:s');
            $coaDiskonJual->is_approved = 1;
            $coaDiskonJual->user_id = Yii::app()->user->id;
            $coaDiskonJual->user_id_approval = Yii::app()->user->id;
            $coaDiskonJual->save();
            
            $existingCoaReturBeli = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_retur_pembelian), array('order' => 'id DESC'));
            $ordinalReturBeli = empty($existingCoaReturBeli) ? 0 : substr($existingCoaReturBeli->code, -3);
            $prefixReturBeli = empty($existingCoaReturBeli) ? '524.00.' : substr($existingCoaReturBeli->code, 0, 7);
            $newOrdinalReturBeli = $ordinalReturBeli + 1;
            $coaReturBeli = new Coa;
            $coaReturBeli->name = 'Retur Pembelian ' . $model->name;
            $coaReturBeli->code = $prefixReturBeli . sprintf('%03d', $newOrdinalReturBeli);
            $coaReturBeli->coa_category_id = 11;
            $coaReturBeli->coa_sub_category_id = 51;
            $coaReturBeli->coa_id = $model->productMasterCategory->coa_retur_pembelian;
            $coaReturBeli->normal_balance = 'KREDIT';
            $coaReturBeli->cash_transaction = 'NO';
            $coaReturBeli->opening_balance = 0.00;
            $coaReturBeli->closing_balance = 0.00;
            $coaReturBeli->debit = 0.00;
            $coaReturBeli->credit = 0.00;
            $coaReturBeli->status = 'Approved';
            $coaReturBeli->date = date('Y-m-d');
            $coaReturBeli->date_approval = date('Y-m-d');
            $coaReturBeli->time_created = date('H:i:s');
            $coaReturBeli->time_approval = date('H:i:s');
            $coaReturBeli->is_approved = 1;
            $coaReturBeli->user_id = Yii::app()->user->id;
            $coaReturBeli->user_id_approval = Yii::app()->user->id;
            $coaReturBeli->save();
            
            $existingCoaDiskonBeli = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_diskon_pembelian), array('order' => 'id DESC'));
            $ordinalDiskonBeli = empty($existingCoaDiskonBeli) ? 0 : substr($existingCoaDiskonBeli->code, -3);
            $prefixDiskonBeli = empty($existingCoaDiskonBeli) ? '523.00.' : substr($existingCoaDiskonBeli->code, 0, 7);
            $newOrdinalDiskonBeli = $ordinalDiskonBeli + 1;
            $coaDiskonBeli = new Coa;
            $coaDiskonBeli->name = 'Diskon Pembelian ' . $model->name;
            $coaDiskonBeli->code = $prefixDiskonBeli . sprintf('%03d', $newOrdinalDiskonBeli);
            $coaDiskonBeli->coa_category_id = 11;
            $coaDiskonBeli->coa_sub_category_id = 50;
            $coaDiskonBeli->coa_id = $model->productMasterCategory->coa_diskon_pembelian;
            $coaDiskonBeli->normal_balance = 'KREDIT';
            $coaDiskonBeli->cash_transaction = 'NO';
            $coaDiskonBeli->opening_balance = 0.00;
            $coaDiskonBeli->closing_balance = 0.00;
            $coaDiskonBeli->debit = 0.00;
            $coaDiskonBeli->credit = 0.00;
            $coaDiskonBeli->status = 'Approved';
            $coaDiskonBeli->date = date('Y-m-d');
            $coaDiskonBeli->date_approval = date('Y-m-d');
            $coaDiskonBeli->time_created = date('H:i:s');
            $coaDiskonBeli->time_approval = date('H:i:s');
            $coaDiskonBeli->is_approved = 1;
            $coaDiskonBeli->user_id = Yii::app()->user->id;
            $coaDiskonBeli->user_id_approval = Yii::app()->user->id;
            $coaDiskonBeli->save();
            
            $existingCoaTransit = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_inventory_in_transit), array('order' => 'id DESC'));
            $ordinalTransit = empty($existingCoaTransit) ? 0 : substr($existingCoaTransit->code, -3);
            $prefixTransit = empty($existingCoaTransit) ? '132.00.' : substr($existingCoaTransit->code, 0, 7);
            $newOrdinalTransit = $ordinalTransit + 1;
            $coaTransit = new Coa;
            $coaTransit->name = 'Inventory in Transit ' . $model->name;
            $coaTransit->code = $prefixTransit . sprintf('%03d', $newOrdinalTransit);
            $coaTransit->coa_category_id = 16;
            $coaTransit->coa_sub_category_id = 5;
            $coaTransit->coa_id = $model->productMasterCategory->coa_inventory_in_transit;
            $coaTransit->normal_balance = 'DEBIT';
            $coaTransit->cash_transaction = 'NO';
            $coaTransit->opening_balance = 0.00;
            $coaTransit->closing_balance = 0.00;
            $coaTransit->debit = 0.00;
            $coaTransit->credit = 0.00;
            $coaTransit->status = 'Approved';
            $coaTransit->date = date('Y-m-d');
            $coaTransit->date_approval = date('Y-m-d');
            $coaTransit->time_created = date('H:i:s');
            $coaTransit->time_approval = date('H:i:s');
            $coaTransit->is_approved = 1;
            $coaTransit->user_id = Yii::app()->user->id;
            $coaTransit->user_id_approval = Yii::app()->user->id;
            $coaTransit->save();
            
            $existingCoaConsignment = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_consignment_inventory), array('order' => 'id DESC'));
            $ordinalConsignment = empty($existingCoaConsignment) ? 0 : substr($existingCoaConsignment->code, -3);
            $prefixConsignment = empty($existingCoaConsignment) ? '133.00.' : substr($existingCoaConsignment->code, 0, 7);
            $newOrdinalConsignment = $ordinalConsignment + 1;
            $coaConsignment = new Coa;
            $coaConsignment->name = 'Consignment - ' . $model->name;
            $coaConsignment->code = $prefixConsignment . sprintf('%03d', $newOrdinalConsignment);
            $coaConsignment->coa_category_id = 16;
            $coaConsignment->coa_sub_category_id = 6;
            $coaConsignment->coa_id = $model->productMasterCategory->coa_consignment_inventory;
            $coaConsignment->normal_balance = 'DEBIT';
            $coaConsignment->cash_transaction = 'NO';
            $coaConsignment->opening_balance = 0.00;
            $coaConsignment->closing_balance = 0.00;
            $coaConsignment->debit = 0.00;
            $coaConsignment->credit = 0.00;
            $coaConsignment->status = 'Approved';
            $coaConsignment->date = date('Y-m-d');
            $coaConsignment->date_approval = date('Y-m-d');
            $coaConsignment->time_created = date('H:i:s');
            $coaConsignment->time_approval = date('H:i:s');
            $coaConsignment->is_approved = 1;
            $coaConsignment->user_id = Yii::app()->user->id;
            $coaConsignment->user_id_approval = Yii::app()->user->id;
            $coaConsignment->save();

            $existingCoaOutstanding = Coa::model()->findByAttributes(array('coa_id' => $model->productMasterCategory->coa_outstanding_part_id), array('order' => 'id DESC'));
            $ordinalOutstanding = empty($existingCoaOutstanding) ? 0 : substr($existingCoaOutstanding->code, -3);
            $prefixOutstanding = empty($existingCoaOutstanding) ? '134.00.' : substr($existingCoaOutstanding->code, 0, 7);
            $newOrdinalOutstanding = $ordinalOutstanding + 1;
            $coaOutstanding = new Coa;
            $coaOutstanding->name = 'Outstanding Parts - ' . $model->name;
            $coaOutstanding->code = $prefixOutstanding . sprintf('%03d', $newOrdinalOutstanding);
            $coaOutstanding->coa_category_id = 16;
            $coaOutstanding->coa_sub_category_id = 68;
            $coaOutstanding->coa_id = $model->productMasterCategory->coa_outstanding_part_id;
            $coaOutstanding->normal_balance = 'DEBIT';
            $coaOutstanding->cash_transaction = 'NO';
            $coaOutstanding->opening_balance = 0.00;
            $coaOutstanding->closing_balance = 0.00;
            $coaOutstanding->debit = 0.00;
            $coaOutstanding->credit = 0.00;
            $coaOutstanding->status = 'Approved';
            $coaOutstanding->date = date('Y-m-d');
            $coaOutstanding->date_approval = date('Y-m-d');
            $coaOutstanding->time_created = date('H:i:s');
            $coaOutstanding->time_approval = date('H:i:s');
            $coaOutstanding->is_approved = 1;
            $coaOutstanding->user_id = Yii::app()->user->id;
            $coaOutstanding->user_id_approval = Yii::app()->user->id;
            $coaOutstanding->save();
            
            $model->coa_persediaan_barang_dagang = $coaPersediaan->id;
            $model->coa_hpp = $coaHpp->id;
            $model->coa_penjualan_barang_dagang = $coaPenjualan->id;
            $model->coa_retur_penjualan = $coaRetur->id;
            $model->coa_diskon_penjualan = $coaDiskonJual->id;
            $model->coa_retur_pembelian = $coaReturBeli->id;
            $model->coa_diskon_pembelian = $coaDiskonBeli->id;
            $model->coa_inventory_in_transit = $coaTransit->id;
            $model->coa_consignment_inventory = $coaConsignment->id;
            $model->coa_outstanding_part_id = $coaOutstanding->id;
            
            if ($model->save()) {
                $this->saveTransactionLog($model);
        
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

        if (isset($_POST['ProductSubMasterCategory'])) {
            $model->attributes = $_POST['ProductSubMasterCategory'];
            
            if ($model->save()) {
                $this->saveTransactionLog($model);
        
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function saveTransactionLog($model) {
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
        $dataProvider = new CActiveDataProvider('ProductSubMasterCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductSubMasterCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductSubMasterCategory']))
            $model->attributes = $_GET['ProductSubMasterCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductSubMasterCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductSubMasterCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductSubMasterCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-sub-master-category-form') {
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
