<?php

class PaymentOutController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('paymentOutCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('paymentOutEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('paymentOutCreate') || Yii::app()->user->checkAccess('paymentOutEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('paymentOutApproval') || Yii::app()->user->checkAccess('paymentOutSupervisor')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSupplierList() {

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->criteria->order = 't.company ASC';

        $this->render('supplierList', array(
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
    }

    public function actionCreate($supplierId, $movementType) {
        $paymentOut = $this->instantiate(null, 'create');
        $supplier = Supplier::model()->findByPk($supplierId);

        $paymentOut->header->user_id = Yii::app()->user->id;
        $paymentOut->header->branch_id = Yii::app()->user->branch_id;
        $paymentOut->header->payment_date = date('Y-m-d');
        $paymentOut->header->created_datetime = date('Y-m-d H:i:s');
        $paymentOut->header->supplier_id = $supplierId;
        $paymentOut->header->status = 'Draft';
        $paymentOut->header->movement_type = $movementType;

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());
        $workOrderExpenseDataProvider = $workOrderExpense->searchForPaymentOut();

        $itemRequestHeader = Search::bind(new ItemRequestHeader('search'), isset($_GET['ItemRequestHeader']) ? $_GET['ItemRequestHeader'] : array());
        $itemRequestDataProvider = $itemRequestHeader->searchForPaymentOut();

        if (!empty($supplierId)) {
            $receiveItemDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $receiveItemDataProvider->criteria->params[':supplier_id'] = $supplierId;
            
            $workOrderExpenseDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $workOrderExpenseDataProvider->criteria->params[':supplier_id'] = $supplierId;
            
            $itemRequestDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $itemRequestDataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentOut);
            $paymentOut->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentOut->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentOut->header->payment_date)), $paymentOut->header->branch_id);

            if ($paymentOut->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
            }
        }

        $this->render('create', array(
            'paymentOut' => $paymentOut,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'workOrderExpense' => $workOrderExpense,
            'workOrderExpenseDataProvider' => $workOrderExpenseDataProvider,
            'itemRequestHeader' => $itemRequestHeader,
            'itemRequestDataProvider' => $itemRequestDataProvider,
            'movementType' => $movementType,
        ));
    }

    public function actionCreateSingle($transactionId, $movementType) {
        $paymentOut = $this->instantiate(null, 'create');
        
        if ($movementType == 1) {
            $workOrderExpense = null;
            $itemRequestHeader = null;
            $receiveItem = TransactionReceiveItem::model()->findByPk($transactionId);
            $supplier = Supplier::model()->findByPk($receiveItem->supplier_id);
            $paymentOut->header->supplier_id = $receiveItem->supplier_id;
        } elseif ($movementType == 2) {
            $receiveItem = null;
            $itemRequestHeader = null;
            $workOrderExpense = WorkOrderExpenseHeader::model()->findByPk($transactionId);
            $supplier = Supplier::model()->findByPk($workOrderExpense->supplier_id);
            $paymentOut->header->supplier_id = $workOrderExpense->supplier_id;
        } elseif ($movementType == 3) {
            $workOrderExpense = null;
            $receiveItem = null;
            $itemRequestHeader = ItemRequestHeader::model()->findByPk($transactionId);
            $supplier = Supplier::model()->findByPk($itemRequestHeader->supplier_id);
            $paymentOut->header->supplier_id = $itemRequestHeader->supplier_id;
        } else {
            $paymentOut->header->supplier_id = null;
        }
        
        $paymentOut->header->user_id = Yii::app()->user->id;
        $paymentOut->header->branch_id = Yii::app()->user->branch_id;
        $paymentOut->header->payment_date = date('Y-m-d');
        $paymentOut->header->created_datetime = date('Y-m-d H:i:s');
        $paymentOut->header->status = 'Draft';
        $paymentOut->header->movement_type = $movementType;

        $paymentOut->addInvoice($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentOut);
            $paymentOut->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentOut->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentOut->header->payment_date)), $paymentOut->header->branch_id);

            if ($paymentOut->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
            }
        }

        $this->render('createSingle', array(
            'paymentOut' => $paymentOut,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'workOrderExpense' => $workOrderExpense,
            'itemRequestHeader' => $itemRequestHeader,
            'movementType' => $movementType,
        ));
    }

    public function actionUpdate($id) {
        $paymentOut = $this->instantiate($id, 'update');
        $paymentOut->header->edited_datetime = date('Y-m-d H:i:s');
        $paymentOut->header->user_id_edited = Yii::app()->user->id;
        
        $supplier = Supplier::model()->findByPk($paymentOut->header->supplier_id);
        $movementType = $paymentOut->header->movement_type;

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());
        $workOrderExpenseDataProvider = $workOrderExpense->searchForPaymentOut();

        $itemRequestHeader = Search::bind(new ItemRequestHeader('search'), isset($_GET['ItemRequestHeader']) ? $_GET['ItemRequestHeader'] : array());
        $itemRequestDataProvider = $itemRequestHeader->searchForPaymentOut();

        if (!empty($paymentOut->header->supplier_id)) {
            $receiveItemDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $receiveItemDataProvider->criteria->params[':supplier_id'] = $paymentOut->header->supplier_id;
            
            $workOrderExpenseDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $workOrderExpenseDataProvider->criteria->params[':supplier_id'] = $paymentOut->header->supplier_id;
            
            $itemRequestDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $itemRequestDataProvider->criteria->params[':supplier_id'] = $paymentOut->header->supplier_id;
        }
        
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentOut);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $paymentOut->header->payment_number,
            ));

            $paymentOut->header->setCodeNumberByRevision('payment_number');

            if ($paymentOut->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
            }
        }

        $this->render('update', array(
            'paymentOut' => $paymentOut,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'workOrderExpense' => $workOrderExpense,
            'workOrderExpenseDataProvider' => $workOrderExpenseDataProvider,
            'itemRequestHeader' => $itemRequestHeader,
            'itemRequestDataProvider' => $itemRequestDataProvider,
            'movementType' => $movementType,
        ));
    }

    public function actionView($id) {
        $paymentOut = $this->loadModel($id);
        $paymentOutDetails = PayOutDetail::model()->findAllByAttributes(array('payment_out_id' => $id));
        
        $postImages = PaymentOutImages::model()->findAllByAttributes(array(
            'payment_out_id' => $paymentOut->id,
            'is_inactive' => $paymentOut::STATUS_ACTIVE
        ));
        
        if (isset($_POST['Process'])) {
            
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $paymentOut->payment_number,
                'branch_id' => $paymentOut->branch_id,
            ));

            if (!empty($paymentOut->paymentType->coa_id)) {
                $coaId = $paymentOut->paymentType->coa_id;
            } elseif ($paymentOut->payment_type_id == 12) {
                $coaId = $paymentOut->coa_id_deposit;
            } else {
                $coaId = $paymentOut->companyBank->coa_id;
            }

            $jurnalUmumKas = new JurnalUmum;
            $jurnalUmumKas->kode_transaksi = $paymentOut->payment_number;
            $jurnalUmumKas->tanggal_transaksi = $paymentOut->payment_date;
            $jurnalUmumKas->coa_id = $coaId;
            $jurnalUmumKas->branch_id = $paymentOut->branch_id;
            $jurnalUmumKas->total = $paymentOut->payment_amount;
            $jurnalUmumKas->debet_kredit = 'K';
            $jurnalUmumKas->tanggal_posting = date('Y-m-d');
            $jurnalUmumKas->transaction_subject = $paymentOut->supplier->company;
            $jurnalUmumKas->is_coa_category = 0;
            $jurnalUmumKas->transaction_type = 'Pout';
            $jurnalUmumKas->save();

            foreach ($paymentOut->payOutDetails as $detail) {
                $invoiceNumber = empty($detail->receive_item_id) ? '' : $detail->receiveItem->invoice_number;
                $jurnalHutang = new JurnalUmum;
                $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
                $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
                $jurnalHutang->coa_id = $paymentOut->supplier->coa_id;
                $jurnalHutang->branch_id = $paymentOut->branch_id;
                $jurnalHutang->total = $detail->amount;
                $jurnalHutang->debet_kredit = 'D';
                $jurnalHutang->tanggal_posting = date('Y-m-d');
                $jurnalHutang->transaction_subject = $paymentOut->supplier->company . ', ' . $detail->memo . ', ' . $invoiceNumber;
                $jurnalHutang->is_coa_category = 0;
                $jurnalHutang->transaction_type = 'Pout';
                $jurnalHutang->save();
            }
        }
        
        $this->render('view', array(
            'paymentOut' => $paymentOut,
            'paymentOutDetails' => $paymentOutDetails,
            'postImages' => $postImages,
        ));
    }

    public function actionShow($id) {
        $paymentOut = $this->loadModel($id);
        $paymentOutDetails = PayOutDetail::model()->findAllByAttributes(array('payment_out_id' => $id));
        
        $postImages = PaymentOutImages::model()->findAllByAttributes(array(
            'payment_out_id' => $paymentOut->id,
            'is_inactive' => $paymentOut::STATUS_ACTIVE
        ));
        
        $this->render('show', array(
            'paymentOut' => $paymentOut,
            'paymentOutDetails' => $paymentOutDetails,
            'postImages' => $postImages,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $paymentOut = $this->instantiate($id, '');
            if ($paymentOut !== null) {
                foreach ($this->details as $detail) {
                    $receiveItemHeader = SaleInvoiceHeader::model()->findByPk($detail->sale_invoice_header_id);
                    $receiveItemHeader->total_payment = 0.00;
                    $valid = $receiveItemHeader->update(array('total_payment')) && $valid;
                }

                $paymentOut->delete(Yii::app()->db);

                Yii::app()->user->setFlash('message', 'Delete Successful');
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionAdmin() {
        $paymentOut = Search::bind(new PaymentOut('search'), isset($_GET['PaymentOut']) ? $_GET['PaymentOut'] : array());
        $paymentApproval = PaymentOutApproval::model()->findByAttributes(array('payment_out_id' => $paymentOut->id));
        
        $supplierName = isset($_GET['SupplierName']) ? $_GET['SupplierName'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $paymentOut->search();
        $dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }

        if (!empty($supplierName)) {
            $dataProvider->criteria->addCondition("supplier.name LIKE :supplier_name");
            $dataProvider->criteria->params[':supplier_name'] = "%{$supplierName}%";
        }

        $dataProvider->criteria->order = 't.payment_date DESC';

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());
        $workOrderExpenseDataProvider = $workOrderExpense->searchForPaymentOut();

        $itemRequest = Search::bind(new ItemRequestHeader('search'), isset($_GET['ItemRequestHeader']) ? $_GET['ItemRequestHeader'] : array());
        $itemRequestDataProvider = $itemRequest->searchForPaymentOut();

        $this->render('admin', array(
            'paymentOut' => $paymentOut,
            'dataProvider' => $dataProvider,
            'supplierName' => $supplierName,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'paymentApproval' => $paymentApproval,
            'workOrderExpense' => $workOrderExpense,
            'workOrderExpenseDataProvider' => $workOrderExpenseDataProvider,
            'itemRequest' => $itemRequest,
            'itemRequestDataProvider' => $itemRequestDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $paymentOut = PaymentOut::model()->findByPK($headerId);
        $historis = PaymentOutApproval::model()->findAllByAttributes(array('payment_out_id' => $headerId));
        $model = new PaymentOutApproval;
        $model->date = date('Y-m-d H:i:s');
        
        if (isset($_POST['PaymentOutApproval'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $paymentOut->payment_number,
                'branch_id' => $paymentOut->branch_id,
            ));

            $model->attributes = $_POST['PaymentOutApproval'];
            if ($model->save()) {
                $paymentOut->status = $model->approval_type;
                $paymentOut->save(false);

                if ($model->approval_type == 'Approved') {
                    if (!empty($paymentOut->paymentType->coa_id)) {
                        $coaId = $paymentOut->paymentType->coa_id;
                    } elseif ($paymentOut->payment_type_id == 12) {
                        $coaId = $paymentOut->coa_id_deposit;
                    } else {
                        $coaId = $paymentOut->companyBank->coa_id;
                    }

                    $jurnalUmumKas = new JurnalUmum;
                    $jurnalUmumKas->kode_transaksi = $paymentOut->payment_number;
                    $jurnalUmumKas->tanggal_transaksi = $paymentOut->payment_date;
                    $jurnalUmumKas->coa_id = $coaId;
                    $jurnalUmumKas->branch_id = $paymentOut->branch_id;
                    $jurnalUmumKas->total = $paymentOut->payment_amount;
                    $jurnalUmumKas->debet_kredit = 'K';
                    $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                    $jurnalUmumKas->transaction_subject = $paymentOut->supplier->company;
                    $jurnalUmumKas->is_coa_category = 0;
                    $jurnalUmumKas->transaction_type = 'Pout';
                    $jurnalUmumKas->save();
                    
                    foreach ($paymentOut->payOutDetails as $detail) {
                        $invoiceNumber = empty($detail->receive_item_id) ? '' : $detail->receiveItem->invoice_number;
                        $jurnalHutang = new JurnalUmum;
                        $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
                        $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalHutang->coa_id = $paymentOut->supplier->coa_id;
                        $jurnalHutang->branch_id = $paymentOut->branch_id;
                        $jurnalHutang->total = $detail->amount;
                        $jurnalHutang->debet_kredit = 'D';
                        $jurnalHutang->tanggal_posting = date('Y-m-d');
                        $jurnalHutang->transaction_subject = $paymentOut->supplier->company . ', ' . $detail->memo . ', ' . $invoiceNumber;
                        $jurnalHutang->is_coa_category = 0;
                        $jurnalHutang->transaction_type = 'Pout';
                        $jurnalHutang->save();
                    }
                }

                $this->saveTransactionLog('approval', $paymentOut);
        
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'paymentOut' => $paymentOut,
            'historis' => $historis,
        ));
    }

    public function saveTransactionLog($actionType, $paymentOut) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $paymentOut->payment_number;
        $transactionLog->transaction_date = $paymentOut->payment_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $paymentOut->tableName();
        $transactionLog->table_id = $paymentOut->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;
        
        $newData = $paymentOut->attributes;
        
        if ($actionType === 'approval') {
            $newData['paymentOutApprovals'] = array();
            foreach($paymentOut->paymentOutApprovals as $detail) {
                $newData['paymentOutApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['payOutDetails'] = array();
            foreach($paymentOut->payOutDetails as $detail) {
                $newData['payOutDetails'][] = $detail->attributes;
            }
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        $model->status = 'CANCELLED!!!';
        $model->payment_amount = 0; 
        $model->ppn = 0;
        $model->notes = '';
        $model->cancelled_datetime = date('Y-m-d H:i:s');
        $model->user_id_cancelled = Yii::app()->user->id;
        $model->update(array('status', 'purchase_order_id', 'payment_amount', 'supplier_id', 'ppn', 'notes', 'cancelled_datetime', 'user_id_cancelled'));

        foreach ($model->payOutDetails as $detail) {
            $detail->total_invoice = '0.00';
            $detail->amount = '0.00';
            $detail->update(array('total_invoice', 'amount'));
            
            $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($detail->receiveItem->purchase_order_id);
            $purchaseOrderHeader->payment_amount = $purchaseOrderHeader->totalPayment;
            $purchaseOrderHeader->payment_left = $purchaseOrderHeader->totalRemaining;
            $purchaseOrderHeader->update(array('payment_amount', 'payment_left'));
        }
        
        $this->saveTransactionLog('cancel', $model);
        
        JurnalUmum::model()->updateAll(array('total' => '0.00'), 'kode_transaksi = :kode_transaksi', array(
            ':kode_transaksi' => $model->payment_number,
        ));

        $this->redirect(array('admin'));
    }

    public function actionAjaxHtmlAddInvoices($id, $movementType) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id, '');
            $this->loadState($paymentOut);

            if (isset($_POST['selectedIds'])) {
                $invoices = array();
                $invoices = $_POST['selectedIds'];

                foreach ($invoices as $invoice) {
                    $paymentOut->addInvoice($invoice, $movementType);
                }
            }

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
                'movementType' => $movementType,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index, $movementType) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id, '');
            $this->loadState($paymentOut);

            $paymentOut->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
                'movementType' => $movementType,
            ));
        }
    }
    
    public function actionAjaxJsonTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id, '');
            $this->loadState($paymentOut);
            
            $totalPayment = $paymentOut->totalPayment;
            $paymentAmountFormatted = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalPayment));
            $paymentAmount = $totalPayment;
            
            $object = array(
                'paymentAmount' => $paymentAmount,
                'paymentAmountFormatted' => $paymentAmountFormatted,
            );
            
            echo CJSON::encode($object);
        }
    }

    public function actionRedirectTransaction($codeNumber) {

        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/show', 'id' => $model->id));
        }
        
    }

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $paymentOut = new PaymentOutComponent($actionType, new PaymentOut(), array(), new PaymentOutImages());
        } else {
            $paymentOutHeader = $this->loadModel($id);
            $paymentOut = new PaymentOutComponent($actionType, $paymentOutHeader, $paymentOutHeader->payOutDetails, $paymentOutHeader->paymentOutImages);
        }

        return $paymentOut;
    }

    public function loadModel($id) {
        $model = PaymentOut::model()->findByPk($id);

        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

    protected function loadState(&$paymentOut) {
        if (isset($_POST['PaymentOut'])) {
            $paymentOut->header->attributes = $_POST['PaymentOut'];
        }
        
        if (isset($_POST['PayOutDetail'])) {
            foreach ($_POST['PayOutDetail'] as $i => $item) {
                if (isset($paymentOut->details[$i])) {
                    $paymentOut->details[$i]->attributes = $item;
                } else {
                    $detail = new PayOutDetail();
                    $detail->attributes = $item;
                    $paymentOut->details[] = $detail;
                }
            }
            if (count($_POST['PayOutDetail']) < count($paymentOut->details)) {
                array_splice($paymentOut->details, $i + 1);
            }
        } else {
            $paymentOut->details = array();
        }
        
        $paymentOut->header->images = CUploadedFile::getInstances($paymentOut->header, 'images');
    }
}