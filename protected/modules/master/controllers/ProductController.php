<?php

class ProductController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/backend';

    /**
     * @return array action filters
     */
    /* public function filters()
      {
      return array(
      'accessControl', // perform access control for CRUD operations
      'postOnly + delete', // we only allow deletion via POST request
      );
      }

      /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'ajaxGetProductSubMasterCategory', 'ajaxGetProductSubCategory', 'ajaxGetVehicleCarModel', 'ajaxHtmlAddVehicleDetail', 'ajaxHtmlAddPriceDetail', 'ajaxHtmlAddUnitDetail', 'ajaxSupplier', 'ajaxUnit', 'ajaxGetSubBrand', 'ajaxGetSubBrandSeries', 'ajaxHtmlRemoveVehicleDetail', 'ajaxHtmlRemovePriceDetail', 'ajaxHtmlAddProductComplementDetail', 'ajaxHtmlRemoveProductComplementDetail', 'ajaxHtmlAddProductSubstituteDetail', 'ajaxHtmlRemoveProductSubstituteDetail', 'ajaxGetCode', 'ajaxHtmlPrice'),
                'users' => array('Admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $productPrices = ProductPrice::model()->findAllByAttributes(array('product_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'productPrices' => $productPrices,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //$model=new Product;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        /* if(isset($_POST['Product']))
          {
          $model->attributes=$_POST['Product'];
          if($model->save())
          $this->redirect(array('view','id'=>$model->id));
          }

          $this->render('create',array(
          'model'=>$model,
          )); */

        $product = $this->instantiate(null);
        $productSpecificationBattery = new ProductSpecificationBattery;
        $productSpecificationOil = new ProductSpecificationOil;
        $productSpecificationTire = new ProductSpecificationTire;

        $product->header->ppn = 2;

        if (isset($_POST['Product'])) {
            $this->loadState($product);
            if ($product->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $product->header->id));
            } /* else {
              foreach ($customer->phoneDetails as $key => $phoneDetail) {
              //print_r(CJSON::encode($detail->jenis_persediaan_id));
              }
              } */
        }

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier']))
            $supplier->attributes = $_GET['Supplier'];

        $supplierCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $supplierCriteria->compare('name', $supplier->name, true);

        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        $unit = new Unit('search');
        $unit->unsetAttributes();  // clear any default values
        if (isset($_GET['Unit']))
            $unit->attributes = $_GET['Unit'];

        $unitCriteria = new CDbCriteria;
        $unitCriteria->compare('name', $unit->name, true);

        $unitDataProvider = new CActiveDataProvider('Unit', array(
            'criteria' => $unitCriteria,
        ));

        $productComplementSubstitute = new Product('search');
        $productComplementSubstitute->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $productComplementSubstitute->attributes = $_GET['Product'];

        $productComplementSubstituteCriteria = new CDbCriteria;
        $productComplementSubstituteCriteria->together = true;
        $productComplementSubstituteCriteria->with = array('productMasterCategory', 'productSubMasterCategory', 'productSubCategory');
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $productComplementSubstituteCriteria->compare('t.name', $productComplementSubstitute->name, true);
        $productComplementSubstituteCriteria->compare('productMasterCategory.name', $productComplementSubstitute->product_master_category_name, true);
        $productComplementSubstituteCriteria->compare('productSubMasterCategory.name', $productComplementSubstitute->product_sub_master_category_name, true);
        $productComplementSubstituteCriteria->compare('productSubCategory.name', $productComplementSubstitute->product_sub_category_name, true);

        $productComplementSubstituteDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productComplementSubstituteCriteria,
        ));

        $this->render('create', array(
            //'model'=>$model,
            'product' => $product,
            'productSpecificationBattery' => $productSpecificationBattery,
            'productSpecificationOil' => $productSpecificationOil,
            'productSpecificationTire' => $productSpecificationTire,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'unit' => $unit,
            'unitDataProvider' => $unitDataProvider,
            'productComplementSubstitute' => $productComplementSubstitute,
            'productComplementSubstituteDataProvider' => $productComplementSubstituteDataProvider
        ));
    }

    public function actionUpload() {
        $this->render('upload');
    }

    public function actionProcessUpload() {
        $product = $_FILES["product"];

        $filename = $product["tmp_name"];
        $file = fopen($filename, "r");
        $index = 0;
        while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
            if ($index > 0) {
                $code = $getData[0];
                $manufactur = $getData[1];
                $name = $getData[2];
                $desc = $getData[3];
                $year = $getData[4];
                $extension = $getData[5];
                $purchasePrice = $getData[6];
                $recommendedPrice = $getData[7];
                $hpp = $getData[8];
                $retailPrice = $getData[9];
                $stock = $getData[10];
                $minimumStock = $getData[11];
                $ppn = $getData[12];

                $command = Yii::app()->db->createCommand();
                $command->insert('rims_product', array(
                    'code' => $code,
                    'manufacturer_code' => $manufactur,
                    'name' => $name,
                    'extension' => $extension,
                    'margin_type' => 1,
                    'description' => $desc,
                    'production_year' => $year,
                    'brand_id' => 1,
                    'product_master_category_id' => 1,
                    'product_sub_master_category_id' => 1,
                    'product_sub_category_id' => 1,
                    'purchase_price' => $purchasePrice,
                    'recommended_selling_price' => $recommendedPrice,
                    'hpp' => $hpp,
                    'retail_price' => $retailPrice,
                    'stock' => $stock,
                    'minimum_stock' => $minimumStock,
                    'ppn' => $ppn
                ));
            }
            $index++;
        }
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //$model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        /* if(isset($_POST['Product']))
          {
          $model->attributes=$_POST['Product'];
          if($model->save())
          $this->redirect(array('view','id'=>$model->id));
          }

          $this->render('update',array(
          'model'=>$model,
          )); */

        $product = $this->instantiate($id);
        //$this->performAjaxValidation($product->header);
        if ($product->header->productSpecificationBattery == NULL) {
            $productSpecificationBattery = new ProductSpecificationBattery;
        } else {
            $productSpecificationBattery = $product->header->productSpecificationBattery;
        }

        if ($product->header->productSpecificationOil == NULL) {
            $productSpecificationOil = new ProductSpecificationOil;
        } else {
            $productSpecificationOil = $product->header->productSpecificationOil;
        }

        if ($product->header->productSpecificationTire == NULL) {
            $productSpecificationTire = new ProductSpecificationTire;
        } else {
            $productSpecificationTire = $product->header->productSpecificationTire;
        }
        //$productSpecificationOil = $product->header->productSpecificationOil;
        //$productSpecificationTire = $product->header->productSpecificationTire;

        $supplier = new Supplier('search');
        $supplier->unsetAttributes();  // clear any default values
        if (isset($_GET['Supplier']))
            $supplier->attributes = $_GET['Supplier'];

        $supplierCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $supplierCriteria->compare('name', $supplier->name, true);

        $supplierDataProvider = new CActiveDataProvider('Supplier', array(
            'criteria' => $supplierCriteria,
        ));

        $unit = new Unit('search');
        $unit->unsetAttributes();  // clear any default values
        if (isset($_GET['Unit']))
            $unit->attributes = $_GET['Unit'];

        $unitCriteria = new CDbCriteria;
        $unitCriteria->compare('name', $unit->name, true);

        $unitDataProvider = new CActiveDataProvider('Unit', array(
            'criteria' => $unitCriteria,
        ));

        $productComplementSubstitute = new Product('search');
        $productComplementSubstitute->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $productComplementSubstitute->attributes = $_GET['Product'];

        $productComplementSubstituteCriteria = new CDbCriteria;
        $productComplementSubstituteCriteria->together = true;
        $productComplementSubstituteCriteria->with = array('productMasterCategory', 'productSubMasterCategory', 'productSubCategory');
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $productComplementSubstituteCriteria->compare('t.name', $productComplementSubstitute->name, true);
        $productComplementSubstituteCriteria->compare('productMasterCategory.name', $productComplementSubstitute->product_master_category_name, true);
        $productComplementSubstituteCriteria->compare('productSubMasterCategory.name', $productComplementSubstitute->product_sub_master_category_name, true);
        $productComplementSubstituteCriteria->compare('productSubCategory.name', $productComplementSubstitute->product_sub_category_name, true);

        $productComplementSubstituteDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productComplementSubstituteCriteria,
        ));

        if (isset($_POST['Product'])) {
            $this->loadState($product);
            if ($product->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $product->header->id));
            } /* else {
              foreach ($customer->phoneDetails as $key => $detail) {
              //print_r(CJSON::encode($detail->jenis_persediaan_id));
              }
              } */
        }
        $this->render('update', array(
            'product' => $product,
            'productSpecificationBattery' => $productSpecificationBattery,
            'productSpecificationOil' => $productSpecificationOil,
            'productSpecificationTire' => $productSpecificationTire,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
            'unit' => $unit,
            'unitDataProvider' => $unitDataProvider,
            'productComplementSubstitute' => $productComplementSubstitute,
            'productComplementSubstituteDataProvider' => $productComplementSubstituteDataProvider
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
        $dataProvider = new CActiveDataProvider('Product');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Product('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Product']))
            $model->attributes = $_GET['Product'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function instantiate($id) {
        if (empty($id)) {
            $product = new Products(new Product(), array(), array(), array(), array(), array());
        } else {
            $productModel = $this->loadModel($id);
            $product = new Products($productModel, $productModel->productVehicles, $productModel->productPrices, $productModel->productUnits, $productModel->productComplements, $productModel->productSubstitutes);
        }
        
        return $product;
    }

    public function loadState($product) {
        if (isset($_POST['Product'])) {
            $product->header->attributes = $_POST['Product'];
        }
        if (isset($_POST['ProductVehicle'])) {
            foreach ($_POST['ProductVehicle'] as $i => $item) {
                if (isset($product->vehicleDetails[$i]))
                    $product->vehicleDetails[$i]->attributes = $item;
                else {
                    $detail = new ProductVehicle();
                    $detail->attributes = $item;
                    $product->vehicleDetails[] = $detail;
                }
            }
            if (count($_POST['ProductVehicle']) < count($product->vehicleDetails))
                array_splice($product->vehicleDetails, $i + 1);
        } else
            $product->vehicleDetails = array();

        if (isset($_POST['ProductPrice'])) {
            foreach ($_POST['ProductPrice'] as $i => $item) {
                if (isset($product->priceDetails[$i]))
                    $product->priceDetails[$i]->attributes = $item;
                else {
                    $detail = new ProductPrice();
                    $detail->attributes = $item;
                    $product->priceDetails[] = $detail;
                }
            }
            if (count($_POST['ProductPrice']) < count($product->priceDetails))
                array_splice($product->priceDetails, $i + 1);
        } else
            $product->priceDetails = array();

        if (isset($_POST['ProductUnit'])) {
            foreach ($_POST['ProductUnit'] as $i => $item) {
                if (isset($product->unitDetails[$i]))
                    $product->unitDetails[$i]->attributes = $item;
                else {
                    $detail = new ProductUnit();
                    $detail->attributes = $item;
                    $product->unitDetails[] = $detail;
                }
            }
            if (count($_POST['ProductUnit']) < count($product->unitDetails))
                array_splice($product->unitDetails, $i + 1);
        } else
            $product->unitDetails = array();

        if (isset($_POST['ProductComplement'])) {
            foreach ($_POST['ProductComplement'] as $i => $item) {
                if (isset($product->productComplementDetails[$i]))
                    $product->productComplementDetails[$i]->attributes = $item;
                else {
                    $detail = new ProductComplement();
                    $detail->attributes = $item;
                    $product->productComplementDetails[] = $detail;
                }
            }
            if (count($_POST['ProductComplement']) < count($product->productComplementDetails))
                array_splice($product->productComplementDetails, $i + 1);
        } else
            $product->productComplementDetails = array();

        if (isset($_POST['ProductSubstitute'])) {
            foreach ($_POST['ProductSubstitute'] as $i => $item) {
                if (isset($product->productSubstituteDetails[$i]))
                    $product->productSubstituteDetails[$i]->attributes = $item;
                else {
                    $detail = new ProductSubstitute();
                    $detail->attributes = $item;
                    $product->productSubstituteDetails[] = $detail;
                }
            }
            if (count($_POST['ProductSubstitute']) < count($product->productSubstituteDetails))
                array_splice($product->productSubstituteDetails, $i + 1);
        } else
            $product->productSubstituteDetails = array();
    }

    public function actionAjaxGetProductSubMasterCategory() {
        $data = ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $_POST['Product']['product_master_category_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'nameAndCode');
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Master Category--]', true);
        }
    }

    public function actionAjaxGetSubBrand() {
        $data = SubBrand::model()->findAllByAttributes(array('brand_id' => $_POST['Product']['brand_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand--]', true);
        }
    }

    public function actionAjaxGetSubBrandSeries() {
//		if(isset($_POST['ProductSpecificationBattery'])){
//			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['ProductSpecificationBattery']['sub_brand_id']), array('order' => 'name'));
//		}
//		if(isset($_POST['ProductSpecificationOil'])){
//			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['ProductSpecificationOil']['sub_brand_id']), array('order' => 'name'));
//		}
//		if(isset($_POST['ProductSpecificationTire'])){
//			$data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id'=>$_POST['ProductSpecificationTire']['sub_brand_id']), array('order' => 'name'));
//		}

        $data = SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $_POST['Product']['sub_brand_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand Series--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Sub Brand Series--]', true);
        }
    }

    public function actionAjaxGetProductSubCategory() {
        $data = ProductSubCategory::model()->findAllByAttributes(array('product_master_category_id' => $_POST['Product']['product_master_category_id'], 'product_sub_master_category_id' => $_POST['Product']['product_sub_master_category_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'nameAndCode');
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Product Sub Category--]', true);
        }
    }

    public function actionAjaxGetCode() {
        $code = ProductMasterCategory::model()->findByPk($_POST['Product']['product_master_category_id'])->code . ProductSubMasterCategory::model()->findByPk($_POST['Product']['product_sub_master_category_id'])->code . ProductSubCategory::model()->findByPk($_POST['Product']['product_sub_category_id'])->code;

        echo $code;
    }

    public function actionAjaxGetVehicleCarModel($index) {
        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $_POST['ProductVehicle']["$index"]['vehicle_car_make_id']), array('order' => 'name'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Vehicle Car Model--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Vehicle Car Model--]', true);
        }
    }

    public function actionAjaxHtmlAddVehicleDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $product->addVehicleDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailVehicle', array('product' => $product), false, true);
        }
    }

    public function actionAjaxHtmlAddPriceDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $supplier = new Supplier('search');
            $supplier->unsetAttributes();  // clear any default values
            if (isset($_GET['Supplier']))
                $supplier->attributes = $_GET['Supplier'];

            $supplierCriteria = new CDbCriteria;
            $supplierCriteria->compare('name', $supplier->name, true);

            $supplierDataProvider = new CActiveDataProvider('Supplier', array(
                'criteria' => $supplierCriteria,
            ));

            $product->addPriceDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('product' => $product, 'supplier' => $supplier, 'supplierDataProvider' => $supplierDataProvider), false, true);
        }
    }

    public function actionAjaxSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($id);

            $object = array(
                'name' => $supplier->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddUnitDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $unit = new Unit('search');
            $unit->unsetAttributes();  // clear any default values
            if (isset($_GET['Unit']))
                $unit->attributes = $_GET['Unit'];

            $unitCriteria = new CDbCriteria;
            $unitCriteria->compare('name', $unit->name, true);

            $unitDataProvider = new CActiveDataProvider('Unit', array(
                'criteria' => $unitCriteria,
            ));

            $product->addUnitDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailUnit', array('product' => $product, 'unit' => $unit, 'unitDataProvider' => $unitDataProvider), false, true);
        }
    }

    public function actionAjaxUnit($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $unit = Unit::model()->findByPk($id);

            $object = array(
                'name' => $unit->name,
            );

            echo CJSON::encode($object);
        }
    }

    //Delete Vehicle Detail
    public function actionAjaxHtmlRemoveVehicleDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);
            //print_r(CJSON::encode($salesOrder->details));
            $product->removeVehicleDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailVehicle', array('product' => $product), false, true);
        }
    }

    //Delete Price Detail
    public function actionAjaxHtmlRemovePriceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);
            //print_r(CJSON::encode($salesOrder->details));
            $product->removePriceDetailAt($index);

            $supplier = new Supplier('search');
            $supplier->unsetAttributes();  // clear any default values
            if (isset($_GET['Supplier']))
                $supplier->attributes = $_GET['Supplier'];

            $supplierCriteria = new CDbCriteria;
            $supplierCriteria->compare('name', $supplier->name, true);

            $supplierDataProvider = new CActiveDataProvider('Supplier', array(
                'criteria' => $supplierCriteria,
            ));

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('product' => $product, 'supplier' => $supplier, 'supplierDataProvider' => $supplierDataProvider), false, true);
        }
    }

    public function actionAjaxHtmlPrice($id) {
        if (Yii::app()->request->isAjaxRequest) {
            //$model = $this->loadModel($id);

            $prices = ProductPrice::model()->findAllByAttributes(array('product_id' => $id));

            $this->renderPartial('_price-dialog', array(
                'prices' => $prices,
            ), false, true);
        }
    }

    //Add Product Complement Detail
    public function actionAjaxHtmlAddProductComplementDetail($id, $productComplementId) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $product->addProductComplementDetail($productComplementId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailComplement', array('product' => $product), false, true);
        }
    }

    //Delete Product Complement Detail
    public function actionAjaxHtmlRemoveProductComplementDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $product->removeProductComplementDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailComplement', array('product' => $product), false, true);
        }
    }

    //Add Product Substitute Detail
    public function actionAjaxHtmlAddProductSubstituteDetail($id, $productSubstituteId) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $product->addProductSubstituteDetail($productSubstituteId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSubstitute', array('product' => $product), false, true);
        }
    }

    //Delete Product Substitute Detail
    public function actionAjaxHtmlRemoveProductSubstituteDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $product->removeProductSubstituteDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSubstitute', array('product' => $product), false, true);
        }
    }

    public function actionAjaxJsonPricing($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = $this->instantiate($id);
            $this->loadState($product);

            $taxValue = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $product->header->retailPriceTax));
            $retailAfterTax = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->header->retailPriceAfterTax));
            $recommendedSellingPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $product->header->recommendedSellingPrice));

            echo CJSON::encode(array(
                'recommendedSellingPrice' => $recommendedSellingPrice,
                'retailAfterTax' => $retailAfterTax,
                'taxValue' => $taxValue,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
                    ), false, true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Product the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Product::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Product $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'product-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
