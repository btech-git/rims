<?php

class ServiceController extends Controller {

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
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'profile' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'restore' || 
            $filterChain->action->id === 'addProduct'
        ) {
            if (!(Yii::app()->user->checkAccess('frontOfficeHead')) || !(Yii::app()->user->checkAccess('operationHead')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $serviceEquipments = ServiceEquipment::model()->findAllByAttributes(array('service_id' => $id));
        $pricelists = ServicePricelist::model()->findAllByAttributes(array('service_id' => $id));
        $complements = ServiceComplement::model()->findAllByAttributes(array('service_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'serviceEquipments' => $serviceEquipments,
            'pricelists' => $pricelists,
            'complements' => $complements,
        ));
    }

    public function actionAddProduct($id) {
        $service = $this->instantiateProduct($id);

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
            $this->redirect(array('view', 'id' => $service->header->id));

        if (isset($_POST['Submit'])) {
            $this->loadState($service);

            if ($service->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $service->header->id));
        }

        $this->render('addProduct', array(
            'service' => $service,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        //$model=new Service;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['Service']))
        // {
        // 	$model->attributes=$_POST['Service'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('create',array(
        // 	'model'=>$model,
        // ));

        $service = $this->instantiate(null);
        $service->header->difficulty_level = 1;

        $complement = new Service('search');
        $complement->unsetAttributes();  // clear any default values

        if (isset($_GET['Service']))
            $complement->attributes = $_GET['Service'];

        $complementCriteria = new CDbCriteria;
        $complementCriteria->compare('name', $complement->name, true);

        $complementDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $complementCriteria,
        ));

        $equipment = new Equipments('search');
        $equipment->unsetAttributes();  // clear any default values

        if (isset($_GET['Equipments']))
            $equipment->attributes = $_GET['Equipments'];

        $equipmentCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $equipmentCriteria->compare('t.name', $equipment->name, true);
        $equipmentCriteria->together = true;
        $equipmentCriteria->with = array('equipmentType', 'equipmentSubType');
        $equipmentCriteria->compare('equipmentType.name', $equipment->equipment_type_name, true);
        $equipmentCriteria->compare('equipmentSubType.name', $equipment->equipment_sub_type_name, true);

        $equipmentDataProvider = new CActiveDataProvider('Equipments', array(
            'criteria' => $equipmentCriteria,
        ));

        $material = new Product('search');
        $material->unsetAttributes();  // clear any default values
        if (isset($_GET['Products']))
            $material->attributes = $_GET['Products'];

        $materialCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $materialCriteria->compare('name', $material->name, true);

        $materialDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $materialCriteria,
        ));

        $this->performAjaxValidation($service->header);

        if (isset($_POST['Service'])) {
            $this->loadState($service);
            if ($service->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $service->header->id));
            }
        }

        $this->render('create', array(
            //'model'=>$model,
            'service' => $service,
            'equipment' => $equipment,
            'equipmentDataProvider' => $equipmentDataProvider,
            'complement' => $complement,
            'complementDataProvider' => $complementDataProvider,
            'material' => $material,
            'materialDataProvider' => $materialDataProvider
        ));
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
        // if(isset($_POST['Service']))
        // {
        // 	$model->attributes=$_POST['Service'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('update',array(
        // 	'model'=>$model,
        // ));

        $complement = new Service('search');
        $complement->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $complement->attributes = $_GET['Service'];

        $complementCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $complementCriteria->compare('name', $complement->name, true);

        $complementDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $complementCriteria,
        ));

        $equipment = new Equipments('search');
        $equipment->unsetAttributes();  // clear any default values
        if (isset($_GET['Equipments']))
            $equipment->attributes = $_GET['Equipments'];

        $equipmentCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $equipmentCriteria->compare('name', $equipment->name, true);

        $equipmentDataProvider = new CActiveDataProvider('Equipments', array(
            'criteria' => $equipmentCriteria,
        ));

        $material = new Product('search');
        $material->unsetAttributes();  // clear any default values
        if (isset($_GET['Products']))
            $material->attributes = $_GET['Products'];

        $materialCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $materialCriteria->compare('name', $material->name, true);

        $materialDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $materialCriteria,
        ));

        $service = $this->instantiate($id);

        $this->performAjaxValidation($service->header);

        if (isset($_POST['Service'])) {


            $this->loadState($service);
            if ($service->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $service->header->id));
            } else {
                
            }
        }
        $this->render('update', array(
            //'model'=>$model,
            'service' => $service,
            'equipment' => $equipment,
            'equipmentDataProvider' => $equipmentDataProvider,
            'complement' => $complement,
            'complementDataProvider' => $complementDataProvider,
            'material' => $material,
            'materialDataProvider' => $materialDataProvider,
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
        $dataProvider = new CActiveDataProvider('Service');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Service('search');
        //$model->disableBehavior('SoftDelete');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $model->attributes = $_GET['Service'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Service the loaded model
     * @throws CHttpException
     */
    //Add Equipment Detail
    public function actionAjaxHtmlAddEquipmentDetail($id, $equipmentId) {
        if (Yii::app()->request->isAjaxRequest) {
            $service = $this->instantiate($id);
            $this->loadState($service);

            $service->addDetail($equipmentId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailEquipment', array('service' => $service), false, true);
        }
    }

    //Delete Equipment Detail
    public function actionAjaxHtmlRemoveEquipmentDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $service = $this->instantiate($id);
            $this->loadState($service);
            //print_r(CJSON::encode($salesOrder->details));
            $service->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailEquipment', array('service' => $service), false, true);
        }
    }

    //Add Price Detail
    public function actionAjaxHtmlAddPriceDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $service = $this->instantiate($id);
            $this->loadState($service);

            $service->addPriceDetail();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('service' => $service), false, true);
        }
    }

    //Delete Price Detail
    public function actionAjaxHtmlRemovePriceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $service = $this->instantiate($id);
            $this->loadState($service);
            //print_r(CJSON::encode($salesOrder->details));
            $service->removePriceDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('service' => $service), false, true);
        }
    }

    //Add Service Complement Detail
    public function actionAjaxHtmlAddComplementDetail($id, $complementId) {
        if (Yii::app()->request->isAjaxRequest) {
            $service = $this->instantiate($id);
            $this->loadState($service);

            $service->addComplementDetail($complementId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailComplement', array('service' => $service), false, true);
        }
    }

    //Delete Service Complement Detail
    public function actionAjaxHtmlRemoveComplementDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $service = $this->instantiate($id);
            $this->loadState($service);
            //print_r(CJSON::encode($salesOrder->details));
            $service->removeComplementDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailComplement', array('service' => $service), false, true);
        }
    }

    //Add Material Detail
    public function actionAjaxHtmlAddMaterialDetail($id, $materialId) {
        if (Yii::app()->request->isAjaxRequest) {
            $service = $this->instantiate($id);
            $this->loadState($service);

            $service->addMaterialDetail($materialId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailMaterial', array('service' => $service), false, true);
        }
    }

    //Delete Material Detail
    public function actionAjaxHtmlRemoveMaterialDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $service = $this->instantiate($id);
            $this->loadState($service);
            //print_r(CJSON::encode($salesOrder->details));
            $service->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailEquipment', array('service' => $service), false, true);
        }
    }

    public function actionAjaxHtmlAddProducts($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $service = $this->instantiate($id);
            $this->loadState($service);

            if (isset($_POST['selectedIds'])) {
                $productDetails = array();
                $productDetails = $_POST['selectedIds'];

                foreach ($productDetails as $productDetail)
                    $service->addProduct($productDetail);
            }

            $this->renderPartial('_detailProduct', array(
                'service' => $service,
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

    public function actionAjaxGetCode() {
        // $service = Service::model()->findByAttributes(array('service_type_id'=>$_POST['Service']['service_type_id'],'service_category_id'=>$_POST['Service']['service_category_id']),array('order'=>'id desc'));
        $serviceType = ServiceType::model()->findByPK($_POST['Service']['service_type_id']);
        $serviceCategory = ServiceCategory::model()->findByPK($_POST['Service']['service_category_id']);
        //$getCode = $serviceType->code .'-'.$serviceCategory->code.'-%';
        $noSpaceType = preg_replace('/\s+/', '', $serviceType->code);
        $noSpaceCat = preg_replace('/\s+/', '', $serviceCategory->code);
        $condition = 'code Like :getCode';
        $params = array(':getCode' => $noSpaceType . '-' . $noSpaceCat . '-' . '%');
        $service = Service::model()->findAll($condition, $params);
        //print_r($service);
        $countS = count($service);
        // $arrayExplode = explode('-', $service->code);
        // $count = $arrayExplode[2]+1;
        // $code = ServiceType::model()->findByPk($_POST['Service']['service_type_id'])->code .'-'. ServiceCategory::model()->findByPk($_POST['Service']['service_category_id'])->code.'-'.$count;
        // $code = preg_replace('/\s+/', '', $code);
        $number = $countS + 1;
        $code = $noSpaceType . '-' . $noSpaceCat . '-' . $number;
        echo $code;
    }

    public function actionAjaxGetServiceCategory() {
        $data = ServiceCategory::model()->findAllByAttributes(array('service_type_id' => $_POST['Service']['service_type_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Service Category--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Service Category--]', true);
        }
    }

    // Get Car Model
    public function actionAjaxGetModel($carmake) {
        $data = VehicleCarModel::model()->findAllByAttributes(array('car_make_id' => $carmake));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Model--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Model--]', true);
        }
    }

    // Get Car Sub Model
    public function actionAjaxGetSubModel($carmake, $carmodel) {
        //$data = VehicleCarSubDetail::model()->findAllByAttributes(array('car_make_id'=>$carmake,'car_model_id'=>$carmodel), array('order'=>'name ASC'));
        $data = VehicleCarSubModel::model()->findAllByAttributes(array('car_make_id' => $carmake, 'car_model_id' => $carmodel), array('order' => 'name ASC'));
        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select Car SubModel--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select Car Sub Model--]', true);
        }
    }

    public function actionAjaxGetPrice($diff, $lux, $standard, $fr) {
        if (Yii::app()->request->isAjaxRequest) {
            $price = 0;
            // $diff_calc = 0;
            // $lux_calc = 0;
            // $standard_rate = 0;
            // $fr_hour = 0;
            // if (isset($diff))
            // 	$diff_calc = $diff;
            // if(isset($lux))
            // 	$lux_calc = $lux;
            // if(isset($standrard))
            // 	$standard_rate = $standard;
            // if(isset($fr))
            // 	$fr_hour = $fr;
            //$price = $diff_calc * $lux_calc * $standard_rate * $fr_hour;
            $price = $diff * $lux * $standard * $fr;
            $object = array('diff' => $diff, 'lux' => $lux, 'standard' => $standard, 'fr' => $fr, 'price' => $price);
            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $service = new Services(new Service(), array(), array(), array(), array(), array());
        } else {
            $serviceModel = $this->loadModel($id);
            $service = new Services($serviceModel, $serviceModel->serviceEquipments, $serviceModel->servicePricelists, $serviceModel->serviceComplements, array(), $serviceModel->serviceMaterials);
        }
        return $service;
    }

    public function instantiateProduct($id) {
        if (empty($id)) {
            $service = new Services(new Service(), array(), array(), array(), array(), array());
        } else {
            $serviceModel = $this->loadModel($id);
            $service = new Services($serviceModel, array(), array(), array(), $serviceModel->serviceProducts, $serviceModel->serviceMaterials);
        }
        return $service;
    }

    public function loadState($service) {
        if (isset($_POST['Service'])) {
            $service->header->attributes = $_POST['Service'];
        }

        if (isset($_POST['ServiceEquipment'])) {
            foreach ($_POST['ServiceEquipment'] as $i => $item) {
                if (isset($service->equipmentDetails[$i]))
                    $service->equipmentDetails[$i]->attributes = $item;
                else {
                    $detail = new ServiceEquipment();
                    $detail->attributes = $item;
                    $service->equipmentDetails[] = $detail;
                }
            }
            if (count($_POST['ServiceEquipment']) < count($service->equipmentDetails))
                array_splice($service->equipmentDetails, $i + 1);
        } else
            $service->equipmentDetails = array();

        if (isset($_POST['ServicePricelist'])) {
            foreach ($_POST['ServicePricelist'] as $i => $item) {
                if (isset($service->priceDetails[$i]))
                    $service->priceDetails[$i]->attributes = $item;
                else {
                    $detail = new ServicePricelist();
                    $detail->attributes = $item;
                    $service->priceDetails[] = $detail;
                }
            }
            if (count($_POST['ServicePricelist']) < count($service->priceDetails))
                array_splice($service->priceDetails, $i + 1);
        } else
            $service->priceDetails = array();

        if (isset($_POST['ServiceComplement'])) {
            foreach ($_POST['ServiceComplement'] as $i => $item) {
                if (isset($service->complementDetails[$i]))
                    $service->complementDetails[$i]->attributes = $item;
                else {
                    $detail = new ServiceComplement();
                    $detail->attributes = $item;
                    $service->complementDetails[] = $detail;
                }
            }
            if (count($_POST['ServiceComplement']) < count($service->complementDetails))
                array_splice($service->complementDetails, $i + 1);
        } else
            $service->complementDetails = array();

        if (isset($_POST['ServiceProduct'])) {
            foreach ($_POST['ServiceProduct'] as $i => $item) {
                if (isset($service->productDetails[$i]))
                    $service->productDetails[$i]->attributes = $item;
                else {
                    $detail = new ServiceProduct();
                    $detail->attributes = $item;
                    $service->productDetails[] = $detail;
                }
            }
            if (count($_POST['ServiceProduct']) < count($service->productDetails))
                array_splice($service->productDetails, $i + 1);
        } else
            $service->productDetails = array();

        if (isset($_POST['ServiceMaterial'])) {
            foreach ($_POST['ServiceMaterial'] as $i => $item) {
                if (isset($service->materialDetails[$i]))
                    $service->materialDetails[$i]->attributes = $item;
                else {
                    $detail = new ServiceMaterial();
                    $detail->attributes = $item;
                    $service->materialDetails[] = $detail;
                }
            }
            if (count($_POST['ServiceMaterial']) < count($service->materialDetails))
                array_splice($service->materialDetails, $i + 1);
        } else
            $service->materialDetails = array();
    }

    public function loadModel($id) {
        $model = Service::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Service $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'service-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxSetValue() {
        $standardValue = GeneralStandardValue::model()->findByPK(1);
        $standardRate = GeneralStandardFr::model()->findByPK(1);

        $object = array(
            'difficulty' => $standardValue->difficulty,
            'difficulty_value' => $standardValue->difficulty_value,
            'regular' => $standardValue->regular,
            'luxury' => $standardValue->luxury,
            'luxury_value' => $standardValue->luxury_value,
            'luxury_calc' => $standardValue->luxury_calc,
            'flat_rate_hour' => $standardValue->flat_rate_hour,
            'standard_rate' => $standardRate->flat_rate,
        );

        echo CJSON::encode($object);
    }

}
