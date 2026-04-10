<?php

class ReceivePartsController extends Controller {

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

    public function actionRegistrationTransactionList() {
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $vehicleNumber = isset($_GET['VehicleNumber']) ? $_GET['VehicleNumber'] : '';

        $registrationTransactionDataProvider = $registrationTransaction->searchByReceiveParts();
        $registrationTransactionDataProvider->criteria->with = array(
            'customer',
            'vehicle',
            'branch',
        );

        if (!empty($customerName)) {
            $registrationTransactionDataProvider->criteria->addCondition('customer.name LIKE :customer_name');
            $registrationTransactionDataProvider->criteria->params[':customer_name'] = "%{$customerName}%";
        }

        if (!empty($vehicleNumber)) {
            $registrationTransactionDataProvider->criteria->addCondition("vehicle.plate_number LIKE :vehicle_number");
            $registrationTransactionDataProvider->criteria->params[':vehicle_number'] = "%{$vehicleNumber}%";
        }

        $registrationTransactionDataProvider->criteria->order = 't.transaction_date DESC';

        $this->render('registrationTransactionList', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'customerName' => $customerName,
            'vehicleNumber' => $vehicleNumber,
        ));
    }

    public function actionCreate($registrationTransactionId) {
        $receiveParts = $this->instantiate(null);
        
        $receiveParts->header->transaction_date = date('Y-m-d');
        $receiveParts->header->created_datetime = date('Y-m-d H:i:s');
        $receiveParts->header->branch_id = Yii::app()->user->branch_id;
        $receiveParts->header->user_id_created = Yii::app()->user->id;
        $receiveParts->header->registration_transaction_id = $registrationTransactionId;
        $receiveParts->header->status = 'Draft';
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationTransactionId);

        $receiveParts->addDetail($registrationTransactionId);
        
        if (isset($_POST['Submit'])) {
            $this->loadState($receiveParts);
            $receiveParts->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($receiveParts->header->transaction_date)), Yii::app()->dateFormatter->format('yy', strtotime($receiveParts->header->transaction_date)), $receiveParts->header->branch_id);

            if ($receiveParts->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $receiveParts->header->id));
            }
        }

        $this->render('create', array(
            'receiveParts' => $receiveParts,
            'registrationTransaction' => $registrationTransaction,
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $receiveParts = $this->loadModel($id);
        $receivePartsDetails = ReceivePartsDetail::model()->findAllByAttributes(array('receive_parts_header_id' => $id));

        $this->render('view', array(
            'receiveParts' => $receiveParts,
            'receivePartsDetails' => $receivePartsDetails,
        ));
    }

    public function actionShow($id) {
        $receiveParts = $this->loadModel($id);
        $receivePartsDetails = ReceivePartsDetail::model()->findAllByAttributes(array('receive_parts_header_id' => $id));
        
        $this->render('show', array(
            'receiveParts' => $receiveParts,
            'receivePartsDetails' => $receivePartsDetails,
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

        if (isset($_POST['RegistrationService'])) {
            $model->attributes = $_POST['RegistrationService'];
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
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
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new ReceivePartsHeader('search');
        $model->unsetAttributes();  // clear any default values
        
//        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
//        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
//        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
//        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';
//        $workOrderNumber = (isset($_GET['WorkOrderNumber'])) ? $_GET['WorkOrderNumber'] : '';

        if (isset($_GET['ReceivePartsHeader'])) {
            $model->attributes = $_GET['ReceivePartsHeader'];
        }
        
        $criteria = new CDbCriteria;
        $dataProvider = new CActiveDataProvider('ReceivePartsHeader', array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.transaction_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 50,
            )
        ));

        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        
//        if (!empty($plateNumber)) {
//            $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
//            $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
//        }
//        
//        if (!empty($carMake)) {
//            $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
//            $dataProvider->criteria->params[':car_make_id'] = $carMake;
//        }
//        
//        if (!empty($carModel)) {
//            $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
//            $dataProvider->criteria->params[':car_model_id'] = $carModel;
//        }
//        
//        if (!empty($customerName)) {
//            $dataProvider->criteria->addCondition('customer.name LIKE :name');
//            $dataProvider->criteria->params[':name'] = "%{$customerName}%";
//        }
//        
//        if (!empty($workOrderNumber)) {
//            $dataProvider->criteria->addCondition('registrationTransaction.work_order_number LIKE :work_order_number');
//            $dataProvider->criteria->params[':work_order_number'] = "%{$workOrderNumber}%";
//        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
//            'plateNumber' => $plateNumber,
//            'carMake' => $carMake,
//            'carModel' => $carModel,
//            'customerName' => $customerName,
//            'workOrderNumber' => $workOrderNumber,
        ));
    }

//    public function actionAjaxHtmlAddDetail($id) {
//        if (Yii::app()->request->isAjaxRequest) {
//            $movementOut = $this->instantiate($id);
//            $this->loadState($movementOut);
//
//            if (isset($_POST['ProductId'])) {
//                $movementOut->addDetail($_POST['ProductId']);
//            }
//
//            $this->renderPartial('_detail', array(
//                'movementOut' => $movementOut,
//            ));
//        }
//    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementOut = $this->instantiate($id);
            $this->loadState($movementOut);

            $movementOut->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'movementOut' => $movementOut,
            ));
        }
    }

//    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;
//
//            $this->renderPartial('_productSubBrandSelect', array(
//                'productBrandId' => $productBrandId,
//            ));
//        }
//    }
//
//    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;
//
//            $this->renderPartial('_productSubBrandSeriesSelect', array(
//                'productSubBrandId' => $productSubBrandId,
//            ));
//        }
//    }
//
//    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;
//
//            $this->renderPartial('_productSubMasterCategorySelect', array(
//                'productMasterCategoryId' => $productMasterCategoryId,
//            ));
//        }
//    }
//
//    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;
//
//            $this->renderPartial('_productSubCategorySelect', array(
//                'productSubMasterCategoryId' => $productSubMasterCategoryId,
//            ));
//        }
//    }

    public function loadModel($id) {
        $model = ReceivePartsHeader::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    public function instantiate($id) {

        if (empty($id)) {
            $receiveParts = new ReceiveParts(new ReceivePartsHeader(), array());
        } else {
            $receivePartsHeader = $this->loadModel($id);
            $receiveParts = new ReceiveParts($receivePartsHeader, $receivePartsHeader->receivePartsDetails);
        }
        
        return $receiveParts;
    }

    public function loadState($receiveParts) {
        if (isset($_POST['ReceivePartsHeader'])) {
            $receiveParts->header->attributes = $_POST['ReceivePartsHeader'];
        }

        if (isset($_POST['ReceivePartsDetail'])) {
            foreach ($_POST['ReceivePartsDetail'] as $i => $item) {
                if (isset($receiveParts->details[$i])) {
                    $receiveParts->details[$i]->attributes = $item;
                } else {
                    $detail = new ReceivePartsDetail();
                    $detail->attributes = $item;
                    $receiveParts->details[] = $detail;
                }
            }
            if (count($_POST['ReceivePartsDetail']) < count($receiveParts->details)) {
                array_splice($receiveParts->details, $i + 1);
            }
        } else {
            $receiveParts->details = array();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param RegistrationService $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'receive-parts-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}