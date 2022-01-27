<?php

class MovementOutServiceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
                $filterChain->action->id === 'registrationTransactionList' ||
                $filterChain->action->id === 'create'
        ) {
            if (!(Yii::app()->user->checkAccess('movementServiceCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
                $filterChain->action->id === 'delete' ||
                $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('movementServiceEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
                $filterChain->action->id === 'admin' ||
                $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('movementServiceCreate')) || !(Yii::app()->user->checkAccess('movementServiceEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionRegistrationTransactionList() {
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $vehicleNumber = isset($_GET['VehicleNumber']) ? $_GET['VehicleNumber'] : '';

        $registrationTransactionDataProvider = $registrationTransaction->searchByMovementOut();
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
        $movementOut = $this->instantiate(null);
        $movementOut->header->date_posting = date('Y-m-d');
        $movementOut->header->branch_id = $movementOut->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $movementOut->header->branch_id;
        $movementOut->header->user_id = Yii::app()->user->id;
        $movementOut->header->registration_transaction_id = $registrationTransactionId;
        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationTransactionId);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        if (isset($_POST['Submit'])) {
            $this->loadState($movementOut);
            $movementOut->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($movementOut->header->date)), Yii::app()->dateFormatter->format('yy', strtotime($movementOut->header->date)));

            if ($movementOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $movementOut->header->id));
            }
        }

        $this->render('create', array(
            'movementOut' => $movementOut,
            'registrationTransaction' => $registrationTransaction,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
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
        $criteria->addCondition('t.registration_transaction_id IS NOT NULL');
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
            'registrationTransaction' => array(
                'with' => array(
                    'customer',
                    'vehicle',
                ),
            ),
        );
        
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

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $movementOut = $this->instantiate($id);
            $this->loadState($movementOut);

            if (isset($_POST['ProductId'])) {
                $movementOut->addDetail($_POST['ProductId']);
            }

            $this->renderPartial('_detail', array(
                'movementOut' => $movementOut,
            ));
        }
    }

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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return RegistrationService the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = MovementOutHeader::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function instantiate($id) {

        if (empty($id)) {
            $movementOut = new MovementOutService(new MovementOutHeader(), array());
        } else {
            $movementOutModel = $this->loadModel($id);
            $movementOut = new MovementOutService($movementOutModel, $movementOutModel->movementOutDetails);
        }
        return $movementOut;
    }

    public function loadState($movementOut) {
        if (isset($_POST['MovementOutHeader'])) {
            $movementOut->header->attributes = $_POST['MovementOutHeader'];
        }

        if (isset($_POST['MovementOutDetail'])) {
            foreach ($_POST['MovementOutDetail'] as $i => $item) {
                if (isset($movementOut->details[$i])) {
                    $movementOut->details[$i]->attributes = $item;
                } else {
                    $detail = new MovementOutDetail();
                    $detail->attributes = $item;
                    $movementOut->details[] = $detail;
                }
            }
            if (count($_POST['MovementOutDetail']) < count($movementOut->details))
                array_splice($movementOut->details, $i + 1);
        } else {
            $movementOut->details = array();
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
