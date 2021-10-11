<?php

class SupplierController extends Controller {

    public $layout = '//layouts/backend';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create' ) {
            if (!(Yii::app()->user->checkAccess('masterSupplierCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'edit' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterSupplierEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'addCoa' || 
            $filterChain->action->id === 'addProduct'
        ) {
            if (!(Yii::app()->user->checkAccess('masterSupplierCreate')) || !(Yii::app()->user->checkAccess('masterSupplierEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $supplier = $this->instantiate(null);
        $this->performAjaxValidation($supplier->header);

        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));

        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id = 15");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);

        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $coaOutstanding = new Coa('search');
        $coaOutstanding->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Coa'])) {
            $coa->attributes = $_GET['Coa'];
        }

        $coaOutstandingCriteria = new CDbCriteria;
        $coaOutstandingCriteria->addCondition("coa_sub_category_id = 16");
        $coaOutstandingCriteria->compare('code', $coaOutstanding->code . '%', true, 'AND', false);
        $coaOutstandingCriteria->compare('name', $coaOutstanding->name, true);

        $coaOutstandingDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaOutstandingCriteria,
        ));

        if (isset($_POST['Supplier'])) {
            $this->loadState($supplier);

            if ($supplier->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $supplier->header->id));
            }
        }

        $this->render('create', array(
            'supplier' => $supplier,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'coaOutstanding' => $coaOutstanding,
            'coaOutstandingDataProvider' => $coaOutstandingDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $supplier = $this->instantiate($id);
        $this->performAjaxValidation($supplier->header);

        $bank = new Bank('search');
        $bank->unsetAttributes();  // clear any default values
        if (isset($_GET['Bank']))
            $bank->attributes = $_GET['Bank'];

        $bankCriteria = new CDbCriteria;
        $bankCriteria->compare('code', $bank->code . '%', true, 'AND', false);
        $bankCriteria->compare('name', $bank->name, true);

        $bankDataProvider = new CActiveDataProvider('Bank', array(
            'criteria' => $bankCriteria,
        ));
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        $coaCriteria->addCondition("coa_sub_category_id = 15");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);


        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $coaOutstanding = new Coa('search');
        $coaOutstanding->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaOutstandingCriteria = new CDbCriteria;
        $coaOutstandingCriteria->addCondition("coa_sub_category_id = 16");
        $coaOutstandingCriteria->compare('code', $coaOutstanding->code . '%', true, 'AND', false);
        $coaOutstandingCriteria->compare('name', $coaOutstanding->name, true);

        $coaOutstandingDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaOutstandingCriteria,
        ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $productChecks = SupplierProduct::model()->findAllByAttributes(array('supplier_id' => $id));
        $productArray = array();

        foreach ($productChecks as $key => $productCheck) {
            array_push($productArray, $productCheck->product_id);
        }

        if (isset($_POST['Supplier'])) {
            $this->loadState($supplier);

            if ($supplier->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $supplier->header->id));
            } else {
                foreach ($supplier->phoneDetails as $key => $detail) {
                    //print_r(CJSON::encode($detail->jenis_persediaan_id));
                }
            }
        }

        $this->render('update', array(
            'supplier' => $supplier,
            'bank' => $bank,
            'bankDataProvider' => $bankDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'productArray' => $productArray,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
            'coaOutstanding' => $coaOutstanding,
            'coaOutstandingDataProvider' => $coaOutstandingDataProvider,
        ));
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $picDetails = SupplierPic::model()->findAllByAttributes(array('supplier_id' => $id));
        $supplierBanks = SupplierBank::model()->findAllByAttributes(array('supplier_id' => $id));
        $supplierProduct = new SupplierProduct('search');
        $supplierProduct->unsetAttributes();  // clear any default values
        
        if (isset($_GET['SupplierProduct']))
            $supplierProduct->attributes = $_GET['SupplierProduct'];

        $supplierProductCriteria = new CDbCriteria;
        $supplierProductCriteria->addCondition("supplier_id = " . $id);
        $supplierProductCriteria->with = array('product' => array('with' => array('productMasterCategory', 'productSubMasterCategory', 'productSubCategory', 'brand')));
        $supplierProductCriteria->compare('product.name', $supplierProduct->product_name, true);
        $supplierProductCriteria->compare('productMasterCategory.name', $supplierProduct->product_master_category_name, true);
        $supplierProductCriteria->compare('productSubMasterCategory.name', $supplierProduct->product_sub_master_category_name, true);
        $supplierProductCriteria->compare('productSubCategory.name', $supplierProduct->product_sub_category_name, true);
        $supplierProductCriteria->compare('brand.name', $supplierProduct->product_brand_name, true);

        $supplierProductDataProvider = new CActiveDataProvider('SupplierProduct', array(
            'criteria' => $supplierProductCriteria,
        ));
        
        if (isset($_POST['Approve']) && (int) $model->is_approved !== 1) {
            $model->is_approved = 1;
            $model->date_approval = date('Y-m-d');
            
            if ($model->save(true, array('is_approved', 'date_approval')))
                Yii::app()->user->setFlash('confirm', 'Your data has been approved!!!');
            else
                Yii::app()->user->setFlash('error', 'Your data failed to approved!!!');
        }

        $this->render('view', array(
            'model' => $model,
            'picDetails' => $picDetails,
            'supplierBanks' => $supplierBanks,
            //'supplierProducts'=>$supplierProducts,
            'supplierProduct' => $supplierProduct,
            'supplierProductDataProvider' => $supplierProductDataProvider,
        ));
    }

    public function actionAddProduct($id) {
        $supplier = $this->instantiateProduct($id);

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $product->attributes = $_GET['Product'];

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('code', $product->code . '%', true, 'AND', false);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('name', $product->name, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('view', 'id' => $supplier->header->id));

        if (isset($_POST['Submit'])) {
            $this->loadState($supplier);

            if ($supplier->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $supplier->header->id));
        }

        $this->render('addProduct', array(
            'supplier' => $supplier,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionAddCoa($id) {
        $model = $this->loadModel($id);

        $coaReceivable = new Coa;
        $coaReceivable->coa_sub_category_id = 15;

        $coaOutstanding = new Coa;
        $coaOutstanding->coa_sub_category_id = 16;
        
        if (isset($_POST['ReceivableName']) && isset($_POST['OutstandingName'])) {
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $coaReceivable->name = $_POST['ReceivableName'];
                $coaReceivable->coa_category_id = $coaReceivable->coaSubCategory->coa_category_id;
                $coaReceivable->getCodeNumber($coaReceivable->coa_sub_category_id);
                
                $coaOutstanding->name = $_POST['OutstandingName'];
                $coaOutstanding->coa_category_id = $coaOutstanding->coaSubCategory->coa_category_id;
                $coaOutstanding->getCodeNumber($coaOutstanding->coa_sub_category_id);

                if ($coaReceivable->save() && $coaOutstanding->save()) {
                    $model->coa_id = $coaReceivable->id;
                    $model->coa_outstanding_order = $coaOutstanding->id;
                    
                    if ($model->save()) {
                        $dbTransaction->commit();
                        $this->redirect(array('view', 'id' => $model->id));
                    } else {
                        $dbTransaction->rollback();
                    }
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
            }
        }

        $this->render('addCoa', array(
            'model' => $model,
            'coaReceivable' => $coaReceivable,
            'coaOutstanding' => $coaOutstanding,
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
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Supplier('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier']))
            $model->attributes = $_GET['Supplier'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    // Ajax Get City
    public function actionAjaxGetCity() {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['Supplier']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHTML::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHTML::tag('option', array('value' => ''), '[--Select City--]', true);
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

    //Add Bank Detail
    public function actionAjaxHtmlAddBankDetail($id, $bankId) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = $this->instantiate($id);
            $this->loadState($supplier);

            $supplier->addBankDetail($bankId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailBank', array('supplier' => $supplier), false, true);
        }
    }

    //Delete Bank Detail
    public function actionAjaxHtmlRemoveBankDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = $this->instantiate($id);
            $this->loadState($supplier);
            $supplier->removeBankDetailAt($index);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailBank', array('supplier' => $supplier), false, true);
        }
    }

    public function actionAjaxHtmlAddProducts($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = $this->instantiate($id);
            $this->loadState($supplier);

            if (isset($_POST['selectedIds'])) {
                $productDetails = array();
                $productDetails = $_POST['selectedIds'];

                foreach ($productDetails as $productDetail)
                    $supplier->addProduct($productDetail);
            }

            $this->renderPartial('_detailProduct', array(
                'supplier' => $supplier,
            ));
        }
    }

    public function actionAjaxHtmlRemoveItem($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = $this->instantiate($id);
            $this->loadState($supplier);
            $supplier->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'supplier' => $supplier,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'supplier-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $supplier = new SupplierComponent(new Supplier(), array(), array());
        } else {
            $supplierModel = $this->loadModel($id);
            $supplier = new SupplierComponent($supplierModel, $supplierModel->supplierBanks, array());
        }

        return $supplier;
    }

    public function instantiateProduct($id) {
        if (empty($id)) {
            $supplier = new SupplierComponent(new Supplier(), array(), array());
        } else {
            $supplierModel = $this->loadModel($id);
            $supplier = new SupplierComponent($supplierModel, array(), $supplierModel->supplierProducts);
        }

        return $supplier;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Supplier the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Supplier::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    public function loadState($supplier) {
        if (isset($_POST['Supplier'])) {
            $supplier->header->attributes = $_POST['Supplier'];
        }

        if (isset($_POST['SupplierBank'])) {
            foreach ($_POST['SupplierBank'] as $i => $item) {
                if (isset($supplier->bankDetails[$i]))
                    $supplier->bankDetails[$i]->attributes = $item;
                else {
                    $detail = new SupplierBank();
                    $detail->attributes = $item;
                    $supplier->bankDetails[] = $detail;
                }
            }
            if (count($_POST['SupplierBank']) < count($supplier->bankDetails))
                array_splice($supplier->bankDetails, $i + 1);
        } else
            $supplier->bankDetails = array();

        if (isset($_POST['SupplierProduct'])) {
            foreach ($_POST['SupplierProduct'] as $i => $item) {
                if (isset($supplier->productDetails[$i]))
                    $supplier->productDetails[$i]->attributes = $item;
                else {
                    $detail = new SupplierProduct();
                    $detail->attributes = $item;
                    $supplier->productDetails[] = $detail;
                }
            }
            if (count($_POST['SupplierProduct']) < count($supplier->productDetails))
                array_splice($supplier->productDetails, $i + 1);
        } else
            $supplier->productDetails = array();
    }

}
