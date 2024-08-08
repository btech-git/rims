<?php

class ProductMasterCategoryController extends Controller {

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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterProductCategoryCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterProductCategoryEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index'
        ) {
            if (!(Yii::app()->user->checkAccess('masterProductCategoryCreate')) || !(Yii::app()->user->checkAccess('masterProductCategoryEdit')))
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
        $model = new ProductMasterCategory;
        $model->user_id = Yii::app()->user->id;
        $model->user_id_approval = null;
        $model->date_posting = date('Y-m-d H:i:s');
        $model->date_approval = null;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $coaPersediaan = new Coa('search');
        $coaPersediaan->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaPersediaan->attributes = $_GET['Coa'];
        }
        
        $coaPersediaanCriteria = new CDbCriteria;
        $coaPersediaanCriteria->addCondition("coa_sub_category_id = 4 and coa_id = 0 and code LIKE '%.000%'");
        $coaPersediaanCriteria->compare('code', $coaPersediaan->code . '%', true, 'AND', false);
        $coaPersediaanCriteria->compare('name', $coaPersediaan->name, true);
        $coaPersediaanDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaPersediaanCriteria,
        ));

        $coaHpp = new Coa('search');
        $coaHpp->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaHpp->attributes = $_GET['Coa'];
        }
        $coaHppCriteria = new CDbCriteria;
        $coaHppCriteria->addCondition("coa_sub_category_id = 44 and coa_id = 0 and code LIKE '%.000%'");
        $coaHppCriteria->compare('code', $coaHpp->code . '%', true, 'AND', false);
        $coaHppCriteria->compare('name', $coaHpp->name, true);
        $coaHppDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaHppCriteria,
        ));

        $coaPenjualan = new Coa('search');
        $coaPenjualan->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaPenjualan->attributes = $_GET['Coa'];
        }
        
        $coaPenjualanCriteria = new CDbCriteria;
        $coaPenjualanCriteria->addCondition("coa_sub_category_id = 26 and coa_id = 0 and code LIKE '%.000%'");
        $coaPenjualanCriteria->compare('code', $coaPenjualan->code . '%', true, 'AND', false);
        $coaPenjualanCriteria->compare('name', $coaPenjualan->name, true);
        $coaPenjualanDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaPenjualanCriteria,
        ));

        $coaRetur = new Coa('search');
        $coaRetur->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaRetur->attributes = $_GET['Coa'];
        }
        $coaReturCriteria = new CDbCriteria;
        $coaReturCriteria->addCondition("coa_sub_category_id = 28 and coa_id = 0 and code LIKE '%.000%'");
        $coaReturCriteria->compare('code', $coaRetur->code . '%', true, 'AND', false);
        $coaReturCriteria->compare('name', $coaRetur->name, true);
        $coaReturDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaReturCriteria,
        ));

        $coaDiskon = new Coa('search');
        $coaDiskon->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaDiskon->attributes = $_GET['Coa'];
        }
        $coaDiskonCriteria = new CDbCriteria;
        $coaDiskonCriteria->addCondition("coa_sub_category_id = 27 and coa_id = 0 and code LIKE '%.000%'");
        $coaDiskonCriteria->compare('code', $coaDiskon->code . '%', true, 'AND', false);
        $coaDiskonCriteria->compare('name', $coaDiskon->name, true);
        $coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonCriteria,
        ));

        $coaReturPembelian = new Coa('search');
        $coaReturPembelian->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaReturPembelian->attributes = $_GET['Coa'];
        }
        $coaReturPembelianCriteria = new CDbCriteria;
        $coaReturPembelianCriteria->addCondition("coa_sub_category_id = 48 and coa_id = 0 and code LIKE '%.000%'");
        $coaReturPembelianCriteria->compare('code', $coaReturPembelian->code . '%', true, 'AND', false);
        $coaReturPembelianCriteria->compare('name', $coaReturPembelian->name, true);
        $coaReturPembelianDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaReturPembelianCriteria,
        ));

        $coaDiskonPembelian = new Coa('search');
        $coaDiskonPembelian->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaDiskonPembelian->attributes = $_GET['Coa'];
        }
        $coaDiskonPembelianCriteria = new CDbCriteria;
        $coaDiskonPembelianCriteria->addCondition("coa_sub_category_id = 47 and coa_id = 0 and code LIKE '%.000%'");
        $coaDiskonPembelianCriteria->compare('code', $coaDiskonPembelian->code . '%', true, 'AND', false);
        $coaDiskonPembelianCriteria->compare('name', $coaDiskonPembelian->name, true);
        $coaDiskonPembelianDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonPembelianCriteria,
        ));

        $coaInventory = new Coa('search');
        $coaInventory->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaInventory->attributes = $_GET['Coa'];
        }
        $coaInventoryCriteria = new CDbCriteria;
        $coaInventoryCriteria->addCondition("coa_sub_category_id = 9 and coa_id = 0 and code LIKE '%.000%'");
        $coaInventoryCriteria->compare('code', $coaInventory->code . '%', true, 'AND', false);
        $coaInventoryCriteria->compare('name', $coaInventory->name, true);
        $coaInventoryDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaInventoryCriteria,
        ));

        $coaConsignment = new Coa('search');
        $coaConsignment->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coaConsignment->attributes = $_GET['Coa'];
        }
        $coaConsignmentCriteria = new CDbCriteria;
        $coaConsignmentCriteria->addCondition("coa_sub_category_id = 51 and coa_id = 0 and code LIKE '%.000%'");
        $coaConsignmentCriteria->compare('code', $coaConsignment->code . '%', true, 'AND', false);
        $coaConsignmentCriteria->compare('name', $coaConsignment->name, true);
        $coaConsignmentDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaConsignmentCriteria,
        ));

        $branches = Branch::model()->findAll(array('order' => 'name ASC'));
        $warehouseIds = array();
        $warehouseBranchProductCategories = array();
        foreach ($branches as $branch) {
            $warehouseIds[$branch->id] = null;
            $warehouseBranchProductCategories[$branch->id] = new WarehouseBranchProductCategory();
        }
        if (isset($_POST['ProductMasterCategory'])) {
            $model->attributes = $_POST['ProductMasterCategory'];
            $warehouseIds = $_POST['WarehouseId'];
            foreach ($warehouseIds as $branchId => $warehouseId) {
                $warehouseBranchProductCategory = $warehouseBranchProductCategories[$branchId];
                $warehouseBranchProductCategory->warehouse_id = empty($warehouseId) ? null : (int) $warehouseId;
                $warehouseBranchProductCategory->branch_id = $branchId;
            }
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = $model->validate();
                foreach ($branches as $branch) {
                    $valid = $valid && $warehouseBranchProductCategories[$branch->id]->validate(array('warehouse_id', 'branch_id'));
                }
                $valid = $valid && $model->save(false);
                foreach ($branches as $branch) {
                    $warehouseBranchProductCategories[$branch->id]->product_master_category_id = $model->id;
                    $valid = $valid && $warehouseBranchProductCategories[$branch->id]->save(false);
                }
                if ($valid) {
                    $dbTransaction->commit();
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }
            if ($valid) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'coaPersediaan' => $coaPersediaan,
            'coaPersediaanDataProvider' => $coaPersediaanDataProvider,
            'coaHpp' => $coaHpp,
            'coaHppDataProvider' => $coaHppDataProvider,
            'coaPenjualan' => $coaPenjualan,
            'coaPenjualanDataProvider' => $coaPenjualanDataProvider,
            'coaRetur' => $coaRetur,
            'coaReturDataProvider' => $coaReturDataProvider,
            'coaDiskon' => $coaDiskon,
            'coaDiskonDataProvider' => $coaDiskonDataProvider,
            'coaReturPembelian' => $coaReturPembelian,
            'coaReturPembelianDataProvider' => $coaReturPembelianDataProvider,
            'coaDiskonPembelian' => $coaDiskonPembelian,
            'coaDiskonPembelianDataProvider' => $coaDiskonPembelianDataProvider,
            'coaInventory' => $coaInventory,
            'coaInventoryDataProvider' => $coaInventoryDataProvider,
            'coaConsignment' => $coaConsignment,
            'coaConsignmentDataProvider' => $coaConsignmentDataProvider,
            'warehouseIds' => $warehouseIds,
            'branches' => $branches,
            'warehouseBranchProductCategories' => $warehouseBranchProductCategories,
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
        $coaPersediaan = new Coa('search');
        $coaPersediaan->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaPersediaan->attributes = $_GET['Coa'];
        $coaPersediaanCriteria = new CDbCriteria;
        $coaPersediaanCriteria->addCondition("coa_sub_category_id = 4 and coa_id = 0 and code LIKE '%.000%'");
        $coaPersediaanCriteria->compare('code', $coaPersediaan->code . '%', true, 'AND', false);
        $coaPersediaanCriteria->compare('name', $coaPersediaan->name, true);
        $coaPersediaanDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaPersediaanCriteria,
        ));

        $coaHpp = new Coa('search');
        $coaHpp->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaHpp->attributes = $_GET['Coa'];
        $coaHppCriteria = new CDbCriteria;
        $coaHppCriteria->addCondition("coa_sub_category_id = 44 and coa_id = 0 and code LIKE '%.000%'");
        $coaHppCriteria->compare('code', $coaHpp->code . '%', true, 'AND', false);
        $coaHppCriteria->compare('name', $coaHpp->name, true);
        $coaHppDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaHppCriteria,
        ));

        $coaPenjualan = new Coa('search');
        $coaPenjualan->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaPenjualan->attributes = $_GET['Coa'];
        $coaPenjualanCriteria = new CDbCriteria;
        $coaPenjualanCriteria->addCondition("coa_sub_category_id = 26 and coa_id = 0 and code LIKE '%.000%'");
        $coaPenjualanCriteria->compare('code', $coaPenjualan->code . '%', true, 'AND', false);
        $coaPenjualanCriteria->compare('name', $coaPenjualan->name, true);
        $coaPenjualanDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaPenjualanCriteria,
        ));

        $coaRetur = new Coa('search');
        $coaRetur->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaRetur->attributes = $_GET['Coa'];
        $coaReturCriteria = new CDbCriteria;
        $coaReturCriteria->addCondition("coa_sub_category_id = 28 and coa_id = 0 and code LIKE '%.000%'");
        $coaReturCriteria->compare('code', $coaRetur->code . '%', true, 'AND', false);
        $coaReturCriteria->compare('name', $coaRetur->name, true);
        $coaReturDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaReturCriteria,
        ));

        $coaDiskon = new Coa('search');
        $coaDiskon->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaDiskon->attributes = $_GET['Coa'];
        $coaDiskonCriteria = new CDbCriteria;
        $coaDiskonCriteria->addCondition("coa_sub_category_id = 27 and coa_id = 0 and code LIKE '%.000%'");
        $coaDiskonCriteria->compare('code', $coaDiskon->code . '%', true, 'AND', false);
        $coaDiskonCriteria->compare('name', $coaDiskon->name, true);
        $coaDiskonDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonCriteria,
        ));

        $coaReturPembelian = new Coa('search');
        $coaReturPembelian->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaReturPembelian->attributes = $_GET['Coa'];
        $coaReturPembelianCriteria = new CDbCriteria;
        $coaReturPembelianCriteria->addCondition("coa_sub_category_id = 48 and coa_id = 0 and code LIKE '%.000%'");
        $coaReturPembelianCriteria->compare('code', $coaReturPembelian->code . '%', true, 'AND', false);
        $coaReturPembelianCriteria->compare('name', $coaReturPembelian->name, true);
        $coaReturPembelianDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaReturPembelianCriteria,
        ));

        $coaDiskonPembelian = new Coa('search');
        $coaDiskonPembelian->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaDiskonPembelian->attributes = $_GET['Coa'];
        $coaDiskonPembelianCriteria = new CDbCriteria;
        $coaDiskonPembelianCriteria->addCondition("coa_sub_category_id = 47 and coa_id = 0 and code LIKE '%.000%'");
        $coaDiskonPembelianCriteria->compare('code', $coaDiskonPembelian->code . '%', true, 'AND', false);
        $coaDiskonPembelianCriteria->compare('name', $coaDiskonPembelian->name, true);
        $coaDiskonPembelianDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaDiskonPembelianCriteria,
        ));

        $coaInventory = new Coa('search');
        $coaInventory->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaInventory->attributes = $_GET['Coa'];
        $coaInventoryCriteria = new CDbCriteria;
        $coaInventoryCriteria->addCondition("coa_sub_category_id = 9 and coa_id = 0 and code LIKE '%.000%'");
        $coaInventoryCriteria->compare('code', $coaInventory->code . '%', true, 'AND', false);
        $coaInventoryCriteria->compare('name', $coaInventory->name, true);
        $coaInventoryDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaInventoryCriteria,
        ));

        $coaConsignment = new Coa('search');
        $coaConsignment->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coaConsignment->attributes = $_GET['Coa'];
        $coaConsignmentCriteria = new CDbCriteria;
        $coaConsignmentCriteria->addCondition("coa_sub_category_id = 51 and coa_id = 0 and code LIKE '%.000%'");
        $coaConsignmentCriteria->compare('code', $coaConsignment->code . '%', true, 'AND', false);
        $coaConsignmentCriteria->compare('name', $coaConsignment->name, true);
        $coaConsignmentDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaConsignmentCriteria,
        ));
        
        $branches = Branch::model()->findAll(array('order' => 'name ASC'));
        $branchIds = array_map(function($branch) { return $branch->id; }, $branches);
        $branchIdsString = implode(',', $branchIds);

        $warehouseBranchProductCategoryList = WarehouseBranchProductCategory::model()->findAll(array(
            'condition' => "product_master_category_id = :product_master_category_id AND branch_id IN ({$branchIdsString})",
            'params' => array(':product_master_category_id' => $model->id),
        ));
        
        $warehouseIds = array();
        $warehouseBranchProductCategories = array();
        foreach ($branches as $branch) {
            $warehouseIds[$branch->id] = null;
            $warehouseBranchProductCategories[$branch->id] = new WarehouseBranchProductCategory();
            foreach ($warehouseBranchProductCategoryList as $warehouseBranchProductCategoryItem) {
                if ($warehouseBranchProductCategoryItem->branch_id === $branch->id) {
                    $warehouseIds[$branch->id] = $warehouseBranchProductCategoryItem->warehouse_id;
                    $warehouseBranchProductCategories[$branch->id] = $warehouseBranchProductCategoryItem;
                }
            }
        }
        if (isset($_POST['ProductMasterCategory'])) {
            $model->attributes = $_POST['ProductMasterCategory'];
            $warehouseIds = $_POST['WarehouseId'];
            foreach ($warehouseIds as $branchId => $warehouseId) {
                $warehouseBranchProductCategory = $warehouseBranchProductCategories[$branchId];
                $warehouseBranchProductCategory->warehouse_id = empty($warehouseId) ? null : (int) $warehouseId;
                $warehouseBranchProductCategory->branch_id = $branchId;
            }
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = $model->validate();
                foreach ($branches as $branch) {
                    $valid = $valid && $warehouseBranchProductCategories[$branch->id]->validate(array('warehouse_id', 'branch_id'));
                }
                $valid = $valid && $model->save(false);
                foreach ($branches as $branch) {
                    $warehouseBranchProductCategories[$branch->id]->product_master_category_id = $model->id;
                    $valid = $valid && $warehouseBranchProductCategories[$branch->id]->save(false);
                }
                if ($valid) {
                    $dbTransaction->commit();
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }
            if ($valid) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
            'coaPersediaan' => $coaPersediaan,
            'coaPersediaanDataProvider' => $coaPersediaanDataProvider,
            'coaHpp' => $coaHpp,
            'coaHppDataProvider' => $coaHppDataProvider,
            'coaPenjualan' => $coaPenjualan,
            'coaPenjualanDataProvider' => $coaPenjualanDataProvider,
            'coaRetur' => $coaRetur,
            'coaReturDataProvider' => $coaReturDataProvider,
            'coaDiskon' => $coaDiskon,
            'coaDiskonDataProvider' => $coaDiskonDataProvider,
            'coaReturPembelian' => $coaReturPembelian,
            'coaReturPembelianDataProvider' => $coaReturPembelianDataProvider,
            'coaDiskonPembelian' => $coaDiskonPembelian,
            'coaDiskonPembelianDataProvider' => $coaDiskonPembelianDataProvider,
            'coaInventory' => $coaInventory,
            'coaInventoryDataProvider' => $coaInventoryDataProvider,
            'coaConsignment' => $coaConsignment,
            'coaConsignmentDataProvider' => $coaConsignmentDataProvider,
            'warehouseIds' => $warehouseIds,
            'branches' => $branches,
            'warehouseBranchProductCategories' => $warehouseBranchProductCategories,
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
        $dataProvider = new CActiveDataProvider('ProductMasterCategory');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ProductMasterCategory('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ProductMasterCategory']))
            $model->attributes = $_GET['ProductMasterCategory'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ProductMasterCategory the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = ProductMasterCategory::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ProductMasterCategory $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-master-category-form') {
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
