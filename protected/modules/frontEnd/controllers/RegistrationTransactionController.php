<?php

class RegistrationTransactionController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('bodyRepairCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('bodyRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'addProductService' ||
            $filterChain->action->id === 'generateInvoice' ||
            $filterChain->action->id === 'generateSalesOrder' ||
            $filterChain->action->id === 'generateWorkOrder' ||
            $filterChain->action->id === 'insuranceAddition' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'showRealization'
        ) {
            if (!(Yii::app()->user->checkAccess('bodyRepairCreate')) || !(Yii::app()->user->checkAccess('bodyRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSaleEstimationList() {
        $saleEstimationHeader = Search::bind(new SaleEstimationHeader('search'), isset($_GET['SaleEstimationHeader']) ? $_GET['SaleEstimationHeader'] : '');
        $saleEstimationHeaderDataProvider = $saleEstimationHeader->searchByRegistration();

        $this->render('saleEstimationList', array(
            'saleEstimationHeader' => $saleEstimationHeader,
            'saleEstimationHeaderDataProvider' => $saleEstimationHeaderDataProvider,
        ));
    }
    
    public function actionCreate($estimationId) {
        $registrationTransaction = $this->instantiate(null);
        $saleEstimationHeader = SaleEstimationHeader::model()->findByPk($estimationId);
        $customer = Customer::model()->findByPk($saleEstimationHeader->customer_id);
        $vehicle = Vehicle::model()->findByPk($saleEstimationHeader->vehicle_id);

        $registrationTransaction->header->transaction_date = date('Y-m-d H:i:s');
        $registrationTransaction->header->work_order_time = null;
        $registrationTransaction->header->created_datetime = date('Y-m-d H:i:s');
        $registrationTransaction->header->user_id = Yii::app()->user->id;
        $registrationTransaction->header->vehicle_id = $saleEstimationHeader->vehicle_id;
        $registrationTransaction->header->customer_id = $saleEstimationHeader->customer_id;
        $registrationTransaction->header->branch_id = Yii::app()->user->branch_id;
        $registrationTransaction->header->sale_estimation_header_id = $estimationId;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($registrationTransaction);
            $registrationTransaction->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);

            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('create', array(
            'registrationTransaction' => $registrationTransaction,
            'customer' => $customer,
            'vehicle' => $vehicle,
        ));
    }

    public function actionUpdate($id) {
        $registrationTransaction = $this->instantiate($id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $registrationTransaction->header->edited_datetime = date('Y-m-d H:i:s');
        $registrationTransaction->header->user_id_edited = Yii::app()->user->id;

        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($registrationTransaction);
            
            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('update', array(
            'bodyRepair' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionView($id) {
        
        $model = $this->loadModel($id);
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationMemos = RegistrationMemo::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationBodyRepairDetails = RegistrationBodyRepairDetail::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $id;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
        }

        $this->render('view', array(
            'model' => $model,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationMemos' => $registrationMemos,
            'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
            'memo' => $memo,
        ));
    }

    public function actionAdmin() {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
//        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionGenerateSalesOrder($id) {
        $model = $this->instantiate($id);

        $model->generateCodeNumberSaleOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        $model->header->sales_order_date = date('Y-m-d');
        $model->header->status = 'Processing SO';

        if ($model->header->update(array('sales_order_number', 'sales_order_date', 'status'))) {

            $real = new RegistrationRealizationProcess();
            $real->registration_transaction_id = $model->header->id;
            $real->name = 'Sales Order';
            $real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->getId();
            $real->detail = 'Generate Sales Order with number #' . $model->header->sales_order_number;
            $real->save();

            $this->redirect(array('view', 'id' => $id));
        }
    }

    public function actionGenerateWorkOrder($id) {
        $registrationTransaction = $this->instantiate($id);
        $customer = Customer::model()->findByPk($registrationTransaction->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->header->vehicle_id);

        $registrationTransaction->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);
        $registrationTransaction->header->work_order_date = isset($_POST['RegistrationTransaction']['work_order_date']) ? $_POST['RegistrationTransaction']['work_order_date'] : date('Y-m-d');
        $registrationTransaction->header->work_order_time = date('H:i:s');
        $registrationTransaction->header->status = 'Waitlist';

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $id));
        }

        if (isset($_POST['Submit'])) {
            $registrationTransaction->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status'));
            if ($registrationTransaction->header->repair_type == 'GR') {
                $real = new RegistrationRealizationProcess();
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $registrationTransaction->header->work_order_number;
                $real->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }
        
        $this->render('generateWorkOrder', array(
            'bodyRepair' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionCancel($id) {
        
        $movementOutHeader = MovementOutHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        if (empty($movementOutHeader && $invoiceHeader)) { 
            $model = $this->loadModel($id);
            $model->status = 'CANCELLED!!!';
            $model->payment_status = 'CANCELLED!!!';
            $model->service_status = 'CANCELLED!!!';
            $model->vehicle_status = 'CANCELLED!!!';
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->update(array('status', 'payment_status', 'service_status', 'vehicle_status', 'cancelled_datetime', 'user_id_cancelled'));
            
            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id);
            $this->loadStateDetails($registrationTransaction);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmount' => $totalAmount,
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id);
            $this->loadStateDetails($registrationTransaction);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmountProduct' => $totalAmountProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
                'subTotalProduct' => $subTotalProduct,
                'totalDiscountProduct' => $totalDiscountProduct,
                'grandTotalProduct' => $grandTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id);
            $this->loadStateDetails($registrationTransaction);

            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalProduct' => $grandTotalProduct,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    public function instantiate($id) {
        if (empty($id)) {
            $registrationTransaction = new RegistrationTransactionComponent(new RegistrationTransaction(), array(), array(), array());
        } else {
            $registrationTransactionModel = $this->loadModel($id);
            $registrationTransaction = new RegistrationTransactionComponent($registrationTransactionModel, $registrationTransactionModel->registrationServices, $registrationTransactionModel->registrationProducts);
        }
        return $registrationTransaction;
    }

    public function loadState($registrationTransaction) {
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->header->attributes = $_POST['RegistrationTransaction'];
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($registrationTransaction->serviceDetails[$i])) {
                    $registrationTransaction->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $registrationTransaction->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($registrationTransaction->serviceDetails)) {
                array_splice($registrationTransaction->serviceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($registrationTransaction->productDetails[$i])) {
                    $registrationTransaction->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $registrationTransaction->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($registrationTransaction->productDetails)) {
                array_splice($registrationTransaction->productDetails, $i + 1);
            }
        } else {
            $registrationTransaction->productDetails = array();
        }
    }
}