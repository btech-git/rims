<?php

class InsuranceCompanyController extends Controller {

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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('masterInsuranceCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'delete'
        ) {
            if (!(Yii::app()->user->checkAccess('masterInsuranceEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'restore'
        ) {
            if (!(Yii::app()->user->checkAccess('masterInsuranceCreate')) || !(Yii::app()->user->checkAccess('masterInsuranceEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $pricelists = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'pricelists' => $pricelists,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {


        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['InsuranceCompany']))
        // {
        // 	$model->attributes=$_POST['InsuranceCompany'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        //$coaCriteria->addCondition("coa_sub_category_id = 2");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);


        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $service->attributes = $_GET['Service'];

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->compare('t.name', $service->name, true);

        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');
        $serviceCriteria->compare('serviceCategory.name', $service->service_category_name == NULL ? $service->service_category_name : $service->service_category_name, true);
        $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        $serviceArray = array();
        $insurance = $this->instantiate(null);
        $this->performAjaxValidation($insurance->header);

        if (isset($_POST['InsuranceCompany'])) {
            $this->loadState($insurance);
            if ($insurance->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $insurance->header->id));
            }
        }

        $this->render('create', array(
            'insurance' => $insurance,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'serviceArray' => $serviceArray,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
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
        $coa = new Coa('search');
        $coa->unsetAttributes();  // clear any default values
        if (isset($_GET['Coa']))
            $coa->attributes = $_GET['Coa'];

        $coaCriteria = new CDbCriteria;
        //$coaCriteria->addCondition("coa_sub_category_id = 2");
        $coaCriteria->compare('code', $coa->code . '%', true, 'AND', false);
        $coaCriteria->compare('name', $coa->name, true);


        $coaDataProvider = new CActiveDataProvider('Coa', array(
            'criteria' => $coaCriteria,
        ));

        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $service->attributes = $_GET['Service'];

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->compare('t.name', $service->name, true);

        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');
        $serviceCriteria->compare('serviceCategory.name', $service->service_category_name == NULL ? $service->service_category_name : $service->service_category_name, true);
        $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);


        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));
        $serviceChecks = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id' => $id));
        $serviceArray = array();
        foreach ($serviceChecks as $key => $serviceCheck) {
            array_push($serviceArray, $serviceCheck->service_id);
        }
        $insurance = $this->instantiate($id);

        $this->performAjaxValidation($insurance->header);

        if (isset($_POST['InsuranceCompany'])) {
            $this->loadState($insurance);
            if ($insurance->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $insurance->header->id));
            } else {
                
            }
        }

        $this->render('update', array(
            'insurance' => $insurance,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'serviceArray' => $serviceArray,
            'coa' => $coa,
            'coaDataProvider' => $coaDataProvider,
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
        $dataProvider = new CActiveDataProvider('InsuranceCompany');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new InsuranceCompany('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InsuranceCompany']))
            $model->attributes = $_GET['InsuranceCompany'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add Price Detail
    public function actionAjaxHtmlAddPriceDetail($id, $serviceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $insurance = $this->instantiate($id);
            $this->loadState($insurance);

            $insurance->addPriceDetail($serviceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('insurance' => $insurance), false, true);
        }
    }

    //Delete Price Detail
    public function actionAjaxHtmlRemovePriceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $insurance = $this->instantiate($id);
            $this->loadState($insurance);
            //print_r(CJSON::encode($salesOrder->details));
            $insurance->removePriceDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailPrice', array('insurance' => $insurance), false, true);
        }
    }

    public function actionAjaxHtmlPrice($id) {
        if (Yii::app()->request->isAjaxRequest) {
            //$model = $this->loadModel($id);

            $prices = InsuranceCompanyPricelist::model()->findAllByAttributes(array('insurance_company_id' => $id));

            $this->renderPartial('_price-dialog', array(
                'prices' => $prices,
                    ), false, true);
        }
    }

    public function actionAjaxGetCity() {


        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['InsuranceCompany']['province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {

            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {

                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InsuranceCompany the loaded model
     * @throws CHttpException
     */
    public function instantiate($id) {
        if (empty($id)) {
            $insurance = new Insurances(new InsuranceCompany(), array());
            //print_r("test");
        } else {
            $insuranceModel = $this->loadModel($id);
            $insurance = new Insurances($insuranceModel, $insuranceModel->insuranceCompanyPricelists);
            //print_r("test");
        }
        return $insurance;
    }

    public function loadState($insurance) {
        if (isset($_POST['InsuranceCompany'])) {
            $insurance->header->attributes = $_POST['InsuranceCompany'];
        }


        if (isset($_POST['InsuranceCompanyPricelist'])) {
            foreach ($_POST['InsuranceCompanyPricelist'] as $i => $item) {
                if (isset($insurance->priceDetails[$i])) {
                    $insurance->priceDetails[$i]->attributes = $item;
                } else {
                    $detail = new InsuranceCompanyPricelist();
                    $detail->attributes = $item;
                    $insurance->priceDetails[] = $detail;
                }
            }
            if (count($_POST['InsuranceCompanyPricelist']) < count($insurance->priceDetails))
                array_splice($insurance->priceDetails, $i + 1);
        }
        else {
            $insurance->priceDetails = array();
        }
    }

    public function loadModel($id) {
        $model = InsuranceCompany::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InsuranceCompany $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'insurance-company-form') {
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
