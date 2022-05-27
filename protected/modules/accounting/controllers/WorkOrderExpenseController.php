<?php

class WorkOrderExpenseController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
//        if ($filterChain->action->id === 'create') {
//            if (!(Yii::app()->user->checkAccess('paymentOutCreate')))
//                $this->redirect(array('/site/login'));
//        }
//        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
//            if (!(Yii::app()->user->checkAccess('paymentOutEdit')))
//                $this->redirect(array('/site/login'));
//        }
//        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
//            if (!(Yii::app()->user->checkAccess('paymentOutCreate') || Yii::app()->user->checkAccess('paymentOutEdit')))
//                $this->redirect(array('/site/login'));
//        }

        $filterChain->run();
    }

    public function actionRegistrationTransactionList() {
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $vehicleNumber = isset($_GET['VehicleNumber']) ? $_GET['VehicleNumber'] : '';

        $registrationTransactionDataProvider = $registrationTransaction->searchByWorkOrderExpense();
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

        $this->render('registrationTransactionList', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'customerName' => $customerName,
            'vehicleNumber' => $vehicleNumber,
        ));
    }

    public function actionCreate($registrationTransactionId) {
        $workOrderExpense = $this->instantiate(null);

        $workOrderExpense->header->user_id = Yii::app()->user->id;
        $workOrderExpense->header->transaction_date = date('Y-m-d');
        $workOrderExpense->header->transaction_time = date('H:i:s');
        $workOrderExpense->header->date_created = date('Y-m-d H:i:s');
        $workOrderExpense->header->status = 'Draft';
        $workOrderExpense->header->registration_transaction_id = $registrationTransactionId;
        $workOrderExpense->header->branch_id = Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id;

        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
        $coaDataProvider = $coa->searchForWorkOrderExpense();

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['Submit'])) {
            $this->loadState($workOrderExpense);
            $workOrderExpense->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($workOrderExpense->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($workOrderExpense->header->transaction_date)), $workOrderExpense->header->branch_id);

            if ($workOrderExpense->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $workOrderExpense->header->id));
            }
        }

        $this->render('create', array(
            'workOrderExpense' => $workOrderExpense,
            'coaDataProvider' => $coaDataProvider,
            'coa' => $coa,
        ));
    }

    public function actionUpdate($id) {
        $workOrderExpense = $this->instantiate($id);
        $supplier = Supplier::model()->findByPk($workOrderExpense->header->supplier_id);

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        if (!empty($workOrderExpense->header->supplier_id)) {
            $receiveItemDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $receiveItemDataProvider->criteria->params[':supplier_id'] = $workOrderExpense->header->supplier_id;
        }
        
        if (isset($_POST['Submit'])) {
            $this->loadState($workOrderExpense);

            if ($workOrderExpense->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $workOrderExpense->header->id));
        }

        $this->render('update', array(
            'paymentOut' => $workOrderExpense,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
        ));
    }

    public function actionView($id) {
        $workOrderExpense = $this->loadModel($id);
        $workOrderExpenseDetails = WorkOrderExpenseDetail::model()->findAllByAttributes(array('work_order_expense_header_id' => $id));
        
        $this->render('view', array(
            'workOrderExpense' => $workOrderExpense,
            'workOrderExpenseDetails' => $workOrderExpenseDetails,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $workOrderExpense = $this->instantiate($id);
            if ($workOrderExpense !== null) {
                foreach ($this->details as $detail) {
                    $receiveItemHeader = SaleInvoiceHeader::model()->findByPk($detail->sale_invoice_header_id);
                    $receiveItemHeader->total_payment = 0.00;
                    $valid = $receiveItemHeader->update(array('total_payment')) && $valid;
                }

                $workOrderExpense->delete(Yii::app()->db);

                Yii::app()->user->setFlash('message', 'Delete Successful');
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAdmin() {
        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $workOrderExpense->search();
        $dataProvider->criteria->with = array(
            'registrationTransaction',
        );

        $this->render('admin', array(
            'paymentOut' => $workOrderExpense,
            'dataProvider' => $dataProvider,
        ));
    }

//    public function actionUpdateApproval($headerId) {
//        $workOrderExpense = PaymentOut::model()->findByPK($headerId);
//        $historis = PaymentOutApproval::model()->findAllByAttributes(array('payment_out_id' => $headerId));
//        $model = new PaymentOutApproval;
//        $model->date = date('Y-m-d H:i:s');
//        $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($workOrderExpense->purchase_order_id);
//
//        if (isset($_POST['PaymentOutApproval'])) {
//            $model->attributes = $_POST['PaymentOutApproval'];
//            if ($model->save()) {
//                $workOrderExpense->status = $model->approval_type;
//                $workOrderExpense->save(false);
//
//                if ($model->approval_type == 'Approved') {
//                    if (!empty($purchaseOrderHeader)) {
//                        if ($purchaseOrderHeader->payment_amount == 0) {
//                            $purchaseOrderHeader->payment_amount = $workOrderExpense->payment_amount;
//                        } else {
//                            $purchaseOrderHeader->payment_amount += $workOrderExpense->payment_amount;
//                        }
//
//                        $purchaseOrderHeader->payment_left -= $workOrderExpense->payment_amount;
//                        if ($purchaseOrderHeader->payment_left > 0.00) {
//                            $purchaseOrderHeader->payment_status = 'PARTIALLY PAID';
//                        } else {
//                            $purchaseOrderHeader->payment_status = 'PAID';
//                        }
//
//                        $purchaseOrderHeader->update(array('payment_amount', 'payment_left', 'payment_status'));
//                    }
//                }
//
//                $this->redirect(array('view', 'id' => $headerId));
//            }
//        }
//
//        $this->render('updateApproval', array(
//            'model' => $model,
//            'paymentOut' => $workOrderExpense,
//            'historis' => $historis,
//        ));
//    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            if (isset($_POST['CoaId'])) {
                $workOrderExpense->addDetail($_POST['CoaId']);
            }

            $this->renderPartial('_detail', array(
                'workOrderExpense' => $workOrderExpense,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            $workOrderExpense->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'paymentOut' => $workOrderExpense,
            ));
        }
    }
    
    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            $object = array(
                'grandTotal' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $workOrderExpense->totalDetail)),
            );

            echo CJSON::encode($object);
        }
    }

//    public function actionRedirectTransaction($codeNumber) {
//
//        list($leftPart,, ) = explode('/', $codeNumber);
//        list(, $codeNumberConstant) = explode('.', $leftPart);
//
//        if ($codeNumberConstant === 'PO') {
//            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
//            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
//        }
//        
//    }

    public function instantiate($id) {
        if (empty($id)) {
            $workOrderExpense = new WorkOrderExpense(new WorkOrderExpenseHeader(), array());
        } else {
            $workOrderExpenseHeader = $this->loadModel($id);
            $workOrderExpense = new WorkOrderExpense($workOrderExpenseHeader, $workOrderExpenseHeader->workOrderExpenseDetails);
        }

        return $workOrderExpense;
    }

    public function loadModel($id) {
        $model = WorkOrderExpenseHeader::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function loadState(&$workOrderExpense) {
        if (isset($_POST['WorkOrderExpenseHeader'])) {
            $workOrderExpense->header->attributes = $_POST['WorkOrderExpenseHeader'];
        }
        
        if (isset($_POST['WorkOrderExpenseDetail'])) {
            foreach ($_POST['WorkOrderExpenseDetail'] as $i => $item) {
                if (isset($workOrderExpense->details[$i])) {
                    $workOrderExpense->details[$i]->attributes = $item;
                } else {
                    $detail = new WorkOrderExpenseDetail();
                    $detail->attributes = $item;
                    $workOrderExpense->details[] = $detail;
                }
            }
            if (count($_POST['WorkOrderExpenseDetail']) < count($workOrderExpense->details)) {
                array_splice($workOrderExpense->details, $i + 1);
            }
        } else {
            $workOrderExpense->details = array();
        }
    }
}