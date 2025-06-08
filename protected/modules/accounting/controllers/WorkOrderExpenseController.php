<?php

class WorkOrderExpenseController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('workOrderExpenseCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('workOrderExpenseEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(
                Yii::app()->user->checkAccess('workOrderExpenseCreate') || 
                Yii::app()->user->checkAccess('workOrderExpenseEdit') || 
                Yii::app()->user->checkAccess('workOrderExpenseView')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('workOrderExpenseApproval') || Yii::app()->user->checkAccess('workOrderExpenseSupervisor'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $workOrderExpense = $this->instantiate(null, 'create');

        $workOrderExpense->header->user_id = Yii::app()->user->id;
        $workOrderExpense->header->transaction_date = date('Y-m-d');
        $workOrderExpense->header->transaction_time = date('H:i:s');
        $workOrderExpense->header->created_datetime = date('Y-m-d H:i:s');
        $workOrderExpense->header->status = 'Draft';
        $workOrderExpense->header->branch_id = Yii::app()->user->branch_id;

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        
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

        $registrationTransactionDataProvider->criteria->order = 't.transaction_date DESC';
        $registrationTransactionDataProvider->criteria->addCondition('t.transaction_date > "2021-12-31"');

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($workOrderExpense);
            $workOrderExpense->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($workOrderExpense->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($workOrderExpense->header->transaction_date)), $workOrderExpense->header->branch_id);

            if ($workOrderExpense->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $workOrderExpense->header->id));
            }
        }

        $this->render('create', array(
            'workOrderExpense' => $workOrderExpense,
            'supplierDataProvider' => $supplierDataProvider,
            'supplier' => $supplier,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'customerName' => $customerName,
            'vehicleNumber' => $vehicleNumber,
        ));
    }

    public function actionUpdate($id) {
        $workOrderExpense = $this->instantiate($id, 'update');
        $workOrderExpense->header->status = 'Draft';
        $supplier = Supplier::model()->findByPk($workOrderExpense->header->supplier_id);

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $customerName = isset($_GET['CustomerName']) ? $_GET['CustomerName'] : '';
        $vehicleNumber = isset($_GET['VehicleNumber']) ? $_GET['VehicleNumber'] : '';

        $registrationTransactionDataProvider = $registrationTransaction->search();
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

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($workOrderExpense);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $workOrderExpense->header->transaction_number,
            ));

            $workOrderExpense->header->setCodeNumberByRevision('transaction_number');

            if ($workOrderExpense->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $workOrderExpense->header->id));
            }
        }

        $this->render('update', array(
            'workOrderExpense' => $workOrderExpense,
            'supplier' => $supplier,
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'customerName' => $customerName,
            'vehicleNumber' => $vehicleNumber,
        ));
    }

    public function actionView($id) {
        $workOrderExpense = $this->loadModel($id);
        $workOrderExpenseDetails = WorkOrderExpenseDetail::model()->findAllByAttributes(array('work_order_expense_header_id' => $id));
        
        if (isset($_POST['Process'])) {
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $workOrderExpense->transaction_number,
                'branch_id' => $workOrderExpense->branch_id,
            ));

            $jurnalHutang = new JurnalUmum;
            $jurnalHutang->kode_transaksi = $workOrderExpense->transaction_number;
            $jurnalHutang->tanggal_transaksi = $workOrderExpense->transaction_date;
            $jurnalHutang->coa_id = $workOrderExpense->supplier->coa_id;
            $jurnalHutang->branch_id = $workOrderExpense->branch_id;
            $jurnalHutang->total = $workOrderExpense->grand_total;
            $jurnalHutang->debet_kredit = 'K';
            $jurnalHutang->tanggal_posting = date('Y-m-d');
            $jurnalHutang->transaction_subject = $workOrderExpense->note;
            $jurnalHutang->is_coa_category = 0;
            $jurnalHutang->transaction_type = 'WOE';
            $jurnalHutang->save();

            $jurnalUmumKas = new JurnalUmum;
            $jurnalUmumKas->kode_transaksi = $workOrderExpense->transaction_number;
            $jurnalUmumKas->tanggal_transaksi = $workOrderExpense->transaction_date;
            $jurnalUmumKas->coa_id = 1110;
            $jurnalUmumKas->branch_id = $workOrderExpense->branch_id;
            $jurnalUmumKas->total = $workOrderExpense->grand_total;
            $jurnalUmumKas->debet_kredit = 'D';
            $jurnalUmumKas->tanggal_posting = date('Y-m-d');
            $jurnalUmumKas->transaction_subject = $workOrderExpense->note;
            $jurnalUmumKas->is_coa_category = 0;
            $jurnalUmumKas->transaction_type = 'WOE';
            $jurnalUmumKas->save();

        }
        
        $this->render('view', array(
            'workOrderExpense' => $workOrderExpense,
            'workOrderExpenseDetails' => $workOrderExpenseDetails,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->grand_total = '0.00'; 
        $model->total_payment = '0.00';
        $model->payment_remaining = '0.00';
        $model->note = '';
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'grand_total', 'total_payment', 'payment_remaining', 'note', 'cancelled_datetime', 'user_id_cancelled'));

        foreach ($model->workOrderExpenseDetails as $detail) {
            $detail->memo = 'CANCELLED';
            $detail->description = '';
            $detail->amount = '0.00';
            $detail->update(array('memo', 'amount', 'description'));
        }
        
        $this->saveTransactionLog('cancel', $model);
        
        JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
            ':kode_transaksi' => $model->transaction_number,
        ));

        $this->redirect(array('admin'));
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
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAdmin() {
        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $workOrderExpense->search();
        $dataProvider->criteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'vehicle',
                ),
            ),
            'supplier',
        );
        $dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        
        if (!empty($customerId)) {
            $dataProvider->criteria->compare('registrationTransaction.customer_id', $customerId);
        }
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->compare('vehicle.plate_number', $plateNumber, true);
        }
        
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';
        
        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';
        
        $this->render('admin', array(
            'paymentOut' => $workOrderExpense,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customerId' => $customerId,
            'plateNumber' => $plateNumber,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $workOrderExpense = WorkOrderExpenseHeader::model()->findByPK($headerId);
        $historis = WorkOrderExpenseApproval::model()->findAllByAttributes(array('work_order_expense_header_id' => $headerId));
        $model = new WorkOrderExpenseApproval;
        $model->date = date('Y-m-d H:i:s');

        if (isset($_POST['WorkOrderExpenseApproval'])) {
            $model->attributes = $_POST['WorkOrderExpenseApproval'];
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $workOrderExpense->transaction_number,
                'branch_id' => $workOrderExpense->branch_id,
            ));

            if ($model->save()) {
                $workOrderExpense->status = $model->approval_type;
                $workOrderExpense->save(false);

                if ($workOrderExpense->status === 'Approved') {
                    $jurnalHutang = new JurnalUmum;
                    $jurnalHutang->kode_transaksi = $workOrderExpense->transaction_number;
                    $jurnalHutang->tanggal_transaksi = $workOrderExpense->transaction_date;
                    $jurnalHutang->coa_id = $workOrderExpense->supplier->coa_id;
                    $jurnalHutang->branch_id = $workOrderExpense->branch_id;
                    $jurnalHutang->total = $workOrderExpense->grand_total;
                    $jurnalHutang->debet_kredit = 'K';
                    $jurnalHutang->tanggal_posting = date('Y-m-d');
                    $jurnalHutang->transaction_subject = $workOrderExpense->note;
                    $jurnalHutang->is_coa_category = 0;
                    $jurnalHutang->transaction_type = 'WOE';
                    $jurnalHutang->save();

                    $jurnalUmumKas = new JurnalUmum;
                    $jurnalUmumKas->kode_transaksi = $workOrderExpense->transaction_number;
                    $jurnalUmumKas->tanggal_transaksi = $workOrderExpense->transaction_date;
                    $jurnalUmumKas->coa_id = 1110;
                    $jurnalUmumKas->branch_id = $workOrderExpense->branch_id;
                    $jurnalUmumKas->total = $workOrderExpense->grand_total;
                    $jurnalUmumKas->debet_kredit = 'D';
                    $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                    $jurnalUmumKas->transaction_subject = $workOrderExpense->note;
                    $jurnalUmumKas->is_coa_category = 0;
                    $jurnalUmumKas->transaction_type = 'WOE';
                    $jurnalUmumKas->save();
                }

                $this->saveTransactionLog('approval', $workOrderExpense);
        
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'workOrderExpense' => $workOrderExpense,
            'historis' => $historis,
        ));
    }

    public function saveTransactionLog($actionType, $workOrderExpense) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $workOrderExpense->transaction_number;
        $transactionLog->transaction_date = $workOrderExpense->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $workOrderExpense->tableName();
        $transactionLog->table_id = $workOrderExpense->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $workOrderExpense->attributes;
        
        if ($actionType === 'approval') {
            $newData['workOrderExpenseApprovals'] = array();
            foreach($workOrderExpense->workOrderExpenseApprovals as $detail) {
                $newData['workOrderExpenseApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['workOrderExpenseDetails'] = array();
            foreach($workOrderExpense->workOrderExpenseDetails as $detail) {
                $newData['workOrderExpenseDetails'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionAjaxJsonWorkOrder($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransactionId = (isset($_POST['WorkOrderExpenseHeader']['registration_transaction_id'])) ? $_POST['WorkOrderExpenseHeader']['registration_transaction_id'] : '';
            
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationTransactionId);
        
            $object = array(
                'workOrderNumber' => CHtml::value($registrationTransaction, 'work_order_number'),
                'workOrderDate' => CHtml::value($registrationTransaction, 'transaction_date'),
                'workOrderCustomer' => CHtml::value($registrationTransaction, 'customer.name'),
                'workOrderVehicle' => nl2br(CHtml::value($registrationTransaction, 'vehicle.carMakeModelSubCombination')),
                'workOrderPlate' => nl2br(CHtml::value($registrationTransaction, 'vehicle.plate_number')),
                'workOrderType' => nl2br(CHtml::value($registrationTransaction, 'repair_type')),
                
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddService($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            $this->renderPartial('_detailService', array(
                'workOrderExpense' => $workOrderExpense,
            ));
        }
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['WorkOrderExpenseHeader']['supplier_id'])) ? $_POST['WorkOrderExpenseHeader']['supplier_id'] : '';
            
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            $supplier = Supplier::model()->findByPk($supplierId);
        
            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'name'),
                'supplier_company' => CHtml::value($supplier, 'company'),
                'supplier_address' => nl2br(CHtml::value($supplier, 'address')),
                'supplier_coa' => nl2br(CHtml::value($supplier, 'coa.name')),
                
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $workOrderExpense = $this->instantiate($id);
            $this->loadState($workOrderExpense);

            $workOrderExpense->addDetail();

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

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $workOrderExpense = new WorkOrderExpense($actionType, new WorkOrderExpenseHeader(), array());
        } else {
            $workOrderExpenseHeader = $this->loadModel($id);
            $workOrderExpense = new WorkOrderExpense($actionType, $workOrderExpenseHeader, $workOrderExpenseHeader->workOrderExpenseDetails);
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