<?php

class QuickServiceController extends Controller {

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
        if (
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'update' || 
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index'
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
        $quickServiceDetails = QuickServiceDetail::Model()->findAllByAttributes(array('quick_service_id' => $id));
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'quickServiceDetails' => $quickServiceDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        // $model=new QuickService;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['QuickService']))
        // {
        // 	$model->attributes=$_POST['QuickService'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('create',array(
        // 	'model'=>$model,
        // // ));
        //Services 
        // $service = new Service('search');
        //     	$service->unsetAttributes();  // clear any default values
        //     	if (isset($_GET['Service']))
        //       	$service->attributes = $_GET['Service'];
        // $serviceCriteria = new CDbCriteria;
        // //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        // $serviceCriteria->compare('t.name',$service->name,true);
        // $serviceCriteria->together = 'true';
        // $serviceCriteria->with = array('serviceCategory','serviceType');
        // $serviceCriteria->compare('serviceCategory.name', $service->service_category_name == NULL ? $service->service_category_name : $service->service_category_name , true);
        // $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);
        // 	$serviceDataProvider = new CActiveDataProvider('Service', array(
        //   	'criteria'=>$serviceCriteria,
        // 	));
        //Services Standard Pricelist
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $service->attributes = $_GET['Service'];

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->compare('t.name', $service->name, true);
        // $serviceCriteria->together=true;
        // $serviceCriteria->select = 't.id,t.name, rims_service_standard_pricelist.price as service_price';
        // $serviceCriteria->join ='right join rims_service_standard_pricelist on t.id = rims_service_standard_pricelist.service_id';
        // $serviceCriteria->together = 'true';
        // $serviceCriteria->with = array('serviceStandardPricelists');
        // $serviceCriteria->compare('rims_service_standard_pricelist.price', $service->service_price,true);
        //$serviceCriteria->compare('serviceStandardPricelists.price', $service->serviceStandardPricelists == NULL ? $service->service_price : $service->service_price , true);
        // $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);


        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));


        $serviceArray = array();
        $quickService = $this->instantiate(null);
        $this->performAjaxValidation($quickService->header);

        if (isset($_POST['QuickService'])) {


            $this->loadState($quickService);
            if ($quickService->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $quickService->header->id));
            }
        }

        $this->render('create', array(
            'quickService' => $quickService,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'serviceArray' => $serviceArray,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        // $model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        // if(isset($_POST['QuickService']))
        // {
        // 	$model->attributes=$_POST['QuickService'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }
        // $this->render('update',array(
        // 	'model'=>$model,
        // ));
        // $service = new Service('search');
        //     	$service->unsetAttributes();  // clear any default values
        //     	if (isset($_GET['Service']))
        //       	$service->attributes = $_GET['Service'];
        // $serviceCriteria = new CDbCriteria;
        // //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        // $serviceCriteria->compare('name',$service->name,true);
        // $serviceCriteria->together = 'true';
        // $serviceCriteria->with = array('serviceCategory','serviceType');
        // $serviceCriteria->compare('serviceCategory.name', $service->service_category_name == NULL ? $service->service_category_name : $service->service_category_name , true);
        // $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);
        // 	$serviceDataProvider = new CActiveDataProvider('Service', array(
        //   	'criteria'=>$serviceCriteria,
        // 	));
        //Services Standard Pricelist
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service']))
            $service->attributes = $_GET['Service'];

        $serviceCriteria = new CDbCriteria;
        //$positionCriteria->compare('code',$position->code.'%',true,'AND', false);
        $serviceCriteria->compare('t.name', $service->name, true);
        // $serviceCriteria->together=true;
        // $serviceCriteria->select = 't.id,t.name, rims_service_standard_pricelist.price as service_price';
        // $serviceCriteria->join ='right join rims_service_standard_pricelist on t.id = rims_service_standard_pricelist.service_id';
        // $serviceCriteria->together = 'true';
        // $serviceCriteria->with = array('serviceStandardPricelists');
        // $serviceCriteria->compare('rims_service_standard_pricelist.price', $service->service_price,true);
        //$serviceCriteria->compare('serviceStandardPricelists.price', $service->serviceStandardPricelists == NULL ? $service->service_price : $service->service_price , true);
        // $serviceCriteria->compare('serviceType.name', $service->service_type_name == NULL ? $service->service_type_name : $service->service_type_name, true);


        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));
        $serviceChecks = QuickServiceDetail::model()->findAllByAttributes(array('quick_service_id' => $id));
        $serviceArray = array();
        foreach ($serviceChecks as $key => $serviceCheck) {
            array_push($serviceArray, $serviceCheck->service_id);
        }
        $quickService = $this->instantiate($id);

        $this->performAjaxValidation($quickService->header);

        if (isset($_POST['QuickService'])) {
            $this->loadState($quickService);
            if ($quickService->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $quickService->header->id));
            } else {
                
            }
        }

        $this->render('update', array(
            'quickService' => $quickService,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'serviceArray' => $serviceArray,
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
        $dataProvider = new CActiveDataProvider('QuickService');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        // $model=new QuickService('search');
        // $model->unsetAttributes();  // clear any default values
        // if(isset($_GET['QuickService']))
        // 	$model->attributes=$_GET['QuickService'];

        $model = new QuickServiceDetail('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['QuickServiceDetail']))
            $model->attributes = $_GET['QuickServiceDetail'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $serviceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $quickService = $this->instantiate($id);
            $this->loadState($quickService);

            $quickService->addDetail($serviceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('quickService' => $quickService), false, true);
        }
    }

    //Delete Detail
    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $quickService = $this->instantiate($id);
            $this->loadState($quickService);
            //print_r(CJSON::encode($salesOrder->details));
            $quickService->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('quickService' => $quickService), false, true);
        }
    }

    public function actionAjaxGetService($serviceId) {
        $service = "";
        $servicePrice = ServiceStandardPricelist::model()->findByPk($serviceId);
        if (count($servicePrice) > 0) {
            $service = $servicePrice->service_id;
        }
        $object = array('id' => $serviceId, 'service' => $service);
        echo CJSON::encode($object);
    }

    public function actionAjaxGetTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quickService = $this->instantiate($id);
            $this->loadState($quickService);
            //$requestType =$requestOrder->header->request_type;
            $total = 0;

            foreach ($quickService->details as $key => $detail) {
                $total += $detail->final_price;
            }
            $object = array('total' => $total);
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotalHr($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $quickService = $this->instantiate($id);
            $this->loadState($quickService);
            //$requestType =$requestOrder->header->request_type;
            $total = 0;

            foreach ($quickService->details as $key => $detail) {
                $total += $detail->hour;
            }
            $object = array('total' => $total);
            echo CJSON::encode($object);
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return QuickService the loaded model
     * @throws CHttpException
     */
    public function instantiate($id) {
        if (empty($id)) {
            $quickService = new QuickServices(new QuickService(), array());
            //print_r("test");
        } else {
            $quickServiceModel = $this->loadModel($id);
            $quickService = new QuickServices($quickServiceModel, $quickServiceModel->quickServiceDetails);
            //print_r("test");
        }
        return $quickService;
    }

    public function loadState($quickService) {
        if (isset($_POST['QuickService'])) {
            $quickService->header->attributes = $_POST['QuickService'];
        }


        if (isset($_POST['QuickServiceDetail'])) {
            foreach ($_POST['QuickServiceDetail'] as $i => $item) {
                if (isset($quickService->details[$i])) {
                    $quickService->details[$i]->attributes = $item;
                } else {
                    $detail = new QuickServiceDetail();
                    $detail->attributes = $item;
                    $quickService->details[] = $detail;
                }
            }
            if (count($_POST['QuickServiceDetail']) < count($quickService->details))
                array_splice($quickService->details, $i + 1);
        }
        else {
            $quickService->details = array();
        }
    }

    public function loadModel($id) {
        $model = QuickService::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param QuickService $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'quick-service-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
