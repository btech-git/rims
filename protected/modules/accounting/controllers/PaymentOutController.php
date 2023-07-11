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
        $paymentOut = $this->instantiate(null);
        $supplier = Supplier::model()->findByPk($supplierId);

        $paymentOut->header->user_id = Yii::app()->user->id;
        $paymentOut->header->payment_date = date('Y-m-d');
        $paymentOut->header->created_datetime = date('Y-m-d H:i:s');
        $paymentOut->header->supplier_id = $supplierId;
        $paymentOut->header->status = 'Draft';
        $paymentOut->header->movement_type = $movementType;

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        if (!empty($supplierId)) {
            $receiveItemDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $receiveItemDataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($paymentOut);
            $paymentOut->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentOut->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentOut->header->payment_date)), $paymentOut->header->branch_id);

            $valid = true; 

            $paymentType = PaymentType::model()->findByPk($paymentOut->header->payment_type_id);
            if (empty($paymentType->coa_id) && $paymentOut->header->company_bank_id == null) {
                $valid = false; 
                $paymentOut->header->addError('error', 'Company Bank harus diisi untuk payment type ini.');
            } else {
                $paymentOut->header->payment_type = $paymentType->name;
            }

            if ($valid && $paymentOut->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
            }
        }

        $this->render('create', array(
            'paymentOut' => $paymentOut,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
            'movementType' => $movementType,
        ));
    }

    public function actionCreateSingle($transactionId, $movementType) {
        $paymentOut = $this->instantiate(null);
        
        if ($movementType == 1) {
            $workOrderExpense = null;
            $receiveItem = TransactionReceiveItem::model()->findByPk($transactionId);
            $supplier = Supplier::model()->findByPk($receiveItem->supplier_id);
            $paymentOut->header->supplier_id = $receiveItem->supplier_id;
        } elseif ($movementType == 2) {
            $receiveItem = null;
            $workOrderExpense = WorkOrderExpenseHeader::model()->findByPk($transactionId);
            $supplier = Supplier::model()->findByPk($workOrderExpense->supplier_id);
            $paymentOut->header->supplier_id = $workOrderExpense->supplier_id;
        } else {
            $paymentOut->header->supplier_id = null;
        }
        
        $paymentOut->header->user_id = Yii::app()->user->id;
        $paymentOut->header->payment_date = date('Y-m-d');
        $paymentOut->header->created_datetime = date('Y-m-d H:i:s');
        $paymentOut->header->status = 'Draft';
        $paymentOut->header->movement_type = $movementType;

        $paymentOut->addInvoice($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit'])) {
            $this->loadState($paymentOut);
            $paymentOut->header->payment_type = $paymentOut->header->payment_type_id;
            $paymentOut->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentOut->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentOut->header->payment_date)), $paymentOut->header->branch_id);

            $valid = true; 

            $paymentType = PaymentType::model()->findByPk($paymentOut->header->payment_type_id);
            if (empty($paymentType->coa_id) && $paymentOut->header->company_bank_id == null) {
                $valid = false; 
                $paymentOut->header->addError('error', 'Company Bank harus diisi untuk payment type ini.');
            }

            if ($valid && $paymentOut->save(Yii::app()->db)) {                
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
            }
        }

        $this->render('createSingle', array(
            'paymentOut' => $paymentOut,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'workOrderExpense' => $workOrderExpense,
            'movementType' => $movementType,
        ));
    }

    public function actionUpdate($id) {
        $paymentOut = $this->instantiate($id);
        $supplier = Supplier::model()->findByPk($paymentOut->header->supplier_id);
        $movementType = $paymentOut->header->movement_type;

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

            $jurnalHutang = new JurnalUmum;
            $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
            $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
            $jurnalHutang->coa_id = $paymentOut->supplier->coa_id;
            $jurnalHutang->branch_id = $paymentOut->branch_id;
            $jurnalHutang->total = $paymentOut->payment_amount;
            $jurnalHutang->debet_kredit = 'D';
            $jurnalHutang->tanggal_posting = date('Y-m-d');
            $jurnalHutang->transaction_subject = $paymentOut->notes;
            $jurnalHutang->is_coa_category = 0;
            $jurnalHutang->transaction_type = 'Pout';
            $jurnalHutang->save();

            if (!empty($paymentOut->paymentType->coa_id)) {
                $coaId = $paymentOut->paymentType->coa_id;
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
            $jurnalUmumKas->transaction_subject = $paymentOut->notes;
            $jurnalUmumKas->is_coa_category = 0;
            $jurnalUmumKas->transaction_type = 'Pout';
            $jurnalUmumKas->save();
        }
        
        $this->render('view', array(
            'paymentOut' => $paymentOut,
            'paymentOutDetails' => $paymentOutDetails,
            'postImages' => $postImages,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $paymentOut = $this->instantiate($id);
            if ($paymentOut !== null) {
                foreach ($this->details as $detail) {
                    $receiveItemHeader = SaleInvoiceHeader::model()->findByPk($detail->sale_invoice_header_id);
                    $receiveItemHeader->total_payment = 0.00;
                    $valid = $receiveItemHeader->update(array('total_payment')) && $valid;
                }

                $paymentOut->delete(Yii::app()->db);

                Yii::app()->user->setFlash('message', 'Delete Successful');
            }
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
//        $dataProvider->criteria->with = array(
//            'supplier',
//            'paymentOutApprovals',
//        );

        if (!empty($supplierName)) {
            $dataProvider->criteria->addCondition("supplier.name LIKE :supplier_name");
            $dataProvider->criteria->params[':supplier_name'] = "%{$supplierName}%";
        }

        $dataProvider->criteria->order = 't.payment_date DESC';

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());
        $workOrderExpenseDataProvider = $workOrderExpense->searchForPaymentOut();

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
        ));
    }

    public function actionUpdateApproval($headerId) {
        $paymentOut = PaymentOut::model()->findByPK($headerId);
        $historis = PaymentOutApproval::model()->findAllByAttributes(array('payment_out_id' => $headerId));
        $model = new PaymentOutApproval;
        $model->date = date('Y-m-d H:i:s');
        $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($paymentOut->purchase_order_id);
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $paymentOut->payment_number,
            'branch_id' => $paymentOut->branch_id,
        ));

        if (isset($_POST['PaymentOutApproval'])) {
            $model->attributes = $_POST['PaymentOutApproval'];
            if ($model->save()) {
                $paymentOut->status = $model->approval_type;
                $paymentOut->save(false);

                if ($model->approval_type == 'Approved') {

                    foreach ($paymentOut->payOutDetails as $detail) {
                        $invoiceNumber = empty($detail->receive_item_id) ? '' : $detail->receiveItem->invoice_number;
                        $jurnalHutang = new JurnalUmum;
                        $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
                        $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalHutang->coa_id = $paymentOut->supplier->coa_id;
                        $jurnalHutang->branch_id = $paymentOut->branch_id;
                        $jurnalHutang->total = $detail->total_invoice;
                        $jurnalHutang->debet_kredit = 'D';
                        $jurnalHutang->tanggal_posting = date('Y-m-d');
                        $jurnalHutang->transaction_subject = $paymentOut->supplier->company . ', ' . $detail->memo . ', ' . $invoiceNumber;
                        $jurnalHutang->is_coa_category = 0;
                        $jurnalHutang->transaction_type = 'Pout';
                        $jurnalHutang->save();

                        if (!empty($paymentOut->paymentType->coa_id)) {
                            $coaId = $paymentOut->paymentType->coa_id;
                        } else {
                            $coaId = $paymentOut->companyBank->coa_id;
                        }

                        $jurnalUmumKas = new JurnalUmum;
                        $jurnalUmumKas->kode_transaksi = $paymentOut->payment_number;
                        $jurnalUmumKas->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalUmumKas->coa_id = $coaId;
                        $jurnalUmumKas->branch_id = $paymentOut->branch_id;
                        $jurnalUmumKas->total = $detail->total_invoice;
                        $jurnalUmumKas->debet_kredit = 'K';
                        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKas->transaction_subject = $paymentOut->supplier->company . ', ' . $detail->memo . ', ' . $invoiceNumber;
                        $jurnalUmumKas->is_coa_category = 0;
                        $jurnalUmumKas->transaction_type = 'Pout';
                        $jurnalUmumKas->save();
                    }

                    if (!empty($purchaseOrderHeader)) {
                        if ($purchaseOrderHeader->payment_amount == 0) {
                            $purchaseOrderHeader->payment_amount = $paymentOut->payment_amount;
                        } else {
                            $purchaseOrderHeader->payment_amount += $paymentOut->payment_amount;
                        }

                        $purchaseOrderHeader->payment_left -= $paymentOut->payment_amount;
                        if ($purchaseOrderHeader->payment_left > 0.00) {
                            $purchaseOrderHeader->payment_status = 'PARTIALLY PAID';
                        } else {
                            $purchaseOrderHeader->payment_status = 'PAID';
                        }

                        $purchaseOrderHeader->update(array('payment_amount', 'payment_left', 'payment_status'));
                    }
                }

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'paymentOut' => $paymentOut,
            'historis' => $historis,
        ));
    }

    public function actionAjaxHtmlAddInvoices($id, $movementType) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id);
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
            $paymentOut = $this->instantiate($id);
            $this->loadState($paymentOut);

            $paymentOut->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
                'movementType' => $movementType,
            ));
        }
    }
    
    public function actionRedirectTransaction($codeNumber) {

        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        }
        
    }

    public function instantiate($id) {
        if (empty($id))
            $paymentOut = new PaymentOutComponent(new PaymentOut(), array(), new PaymentOutImages());
        else {
            $paymentOutHeader = $this->loadModel($id);
            $paymentOut = new PaymentOutComponent($paymentOutHeader, $paymentOutHeader->payOutDetails, $paymentOutHeader->paymentOutImages);
        }

        return $paymentOut;
    }

    public function loadModel($id) {
        $model = PaymentOut::model()->findByPk($id);

        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

    protected function loadState(&$paymentOut) {
        if (isset($_POST['PaymentOut'])) {
            $paymentOut->header->attributes = $_POST['PaymentOut'];
        }
        
        if (isset($_POST['PayOutDetail'])) {
            foreach ($_POST['PayOutDetail'] as $i => $item) {
                if (isset($paymentOut->details[$i]))
                    $paymentOut->details[$i]->attributes = $item;
                else {
                    $detail = new PayOutDetail();
                    $detail->attributes = $item;
                    $paymentOut->details[] = $detail;
                }
            }
            if (count($_POST['PayOutDetail']) < count($paymentOut->details))
                array_splice($paymentOut->details, $i + 1);
        } else
            $paymentOut->details = array();
        
        $paymentOut->header->images = CUploadedFile::getInstances($paymentOut->header, 'images');
    }
}