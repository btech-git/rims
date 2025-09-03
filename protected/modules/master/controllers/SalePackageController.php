<?php

class SalePackageController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
                $filterChain->action->id === 'registrationTransactionList' ||
                $filterChain->action->id === 'create'
        ) {
            if (!(Yii::app()->user->checkAccess('movementServiceCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
                $filterChain->action->id === 'delete' ||
                $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('movementServiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
                $filterChain->action->id === 'admin' ||
                $filterChain->action->id === 'view'
        ) {
            if (!(
                Yii::app()->user->checkAccess('movementServiceCreate') || 
                Yii::app()->user->checkAccess('movementServiceEdit') || 
                Yii::app()->user->checkAccess('movementServiceView')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $salePackage = $this->instantiate(null);
        
        $salePackage->header->datetime_created = date('Y-m-d H:i:s');
        $salePackage->header->user_id = Yii::app()->user->id;

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : array());
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->compare('t.status', 'Active');

        if (isset($_POST['Submit'])) {
            $this->loadState($salePackage);

            if ($salePackage->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $salePackage->header->id));
            }
        }

        $this->render('create', array(
            'salePackage' => $salePackage,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
        ));
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

    public function actionShow($id) {
        $this->render('show', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $salePackage = $this->instantiate($id);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');

        $service = Search::bind(new Service('search'), isset($_GET['Service']) ? $_GET['Service'] : array());
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->compare('t.status', 'Active');

        if (isset($_POST['Submit'])) {
            $this->loadState($salePackage);

            if ($salePackage->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $salePackage->header->id));
            }
        }

        $this->render('update', array(
            'salePackage' => $salePackage,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
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
        $model = new MovementOutHeader('search');
        $model->unsetAttributes();  // clear any default values
        
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
        $workOrderNumber = (isset($_GET['WorkOrderNumber'])) ? $_GET['WorkOrderNumber'] : '';

        if (isset($_GET['MovementOutHeader'])) {
            $model->attributes = $_GET['MovementOutHeader'];
        }
        
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.material_request_header_id IS NOT NULL');
        $dataProvider = new CActiveDataProvider('MovementOutHeader', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.date_posting DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            )
        ));

        $dataProvider->criteria->together = true;
        $dataProvider->criteria->with = array(
            'materialRequestHeader' => array(
                'with' => array(
                    'registrationTransaction' => array(
                        'with' => array(
                            'customer',
                            'vehicle',
                        ),
                    ),
                ),
            ),
        );
        
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
            $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
        
        if (!empty($carMake)) {
            $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
            $dataProvider->criteria->params[':car_make_id'] = $carMake;
        }
        
        if (!empty($carModel)) {
            $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
            $dataProvider->criteria->params[':car_model_id'] = $carModel;
        }
        
        if (!empty($customerName)) {
            $dataProvider->criteria->addCondition('customer.name LIKE :name');
            $dataProvider->criteria->params[':name'] = "%{$customerName}%";
        }
        
        if (!empty($workOrderNumber)) {
            $dataProvider->criteria->addCondition('registrationTransaction.work_order_number LIKE :work_order_number');
            $dataProvider->criteria->params[':work_order_number'] = "%{$workOrderNumber}%";
        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
            'workOrderNumber' => $workOrderNumber,
        ));
    }

    public function actionAjaxHtmlAddProductDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePackage = $this->instantiate($id);
            $this->loadState($salePackage);

            if (isset($_POST['ProductId'])) {
                $salePackage->addProductDetail($_POST['ProductId']);
            }

            $this->renderPartial('_detail', array(
                'salePackage' => $salePackage,
            ));
        }
    }

    public function actionAjaxHtmlAddServiceDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePackage = $this->instantiate($id);
            $this->loadState($salePackage);

            if (isset($_POST['ServiceId'])) {
                $salePackage->addServiceDetail($_POST['ServiceId']);
            }

            $this->renderPartial('_detail', array(
                'salePackage' => $salePackage,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $salePackage = $this->instantiate($id);
            $this->loadState($salePackage);

            $salePackage->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'salePackage' => $salePackage,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RegistrationService the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SalePackageHeader::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function instantiate($id) {

        if (empty($id)) {
            $salePackage = new SalePackage(new SalePackageHeader(), array());
        } else {
            $salePackageModel = $this->loadModel($id);
            $salePackage = new SalePackage($salePackageModel, $salePackageModel->salePackageDetails);
        }
        return $salePackage;
    }

    public function loadState($salePackage) {
        if (isset($_POST['SalePackageHeader'])) {
            $salePackage->header->attributes = $_POST['SalePackageHeader'];
        }

        if (isset($_POST['SalePackageDetail'])) {
            foreach ($_POST['SalePackageDetail'] as $i => $item) {
                if (isset($salePackage->details[$i])) {
                    $salePackage->details[$i]->attributes = $item;
                } else {
                    $detail = new SalePackageDetail();
                    $detail->attributes = $item;
                    $salePackage->details[] = $detail;
                }
            }
            if (count($_POST['SalePackageDetail']) < count($salePackage->details)) {
                array_splice($salePackage->details, $i + 1);
            }
        } else {
            $salePackage->details = array();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param RegistrationService $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-service-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}