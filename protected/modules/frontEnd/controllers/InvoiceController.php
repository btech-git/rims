<?php

class InvoiceController extends Controller {

    public $layout = '//layouts/column2-1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'viewInvoices'
        ) {
            if (!(Yii::app()->user->checkAccess('saleInvoiceCreate')) || !(Yii::app()->user->checkAccess('saleInvoiceEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id' => $id));
        $payments = PaymentInDetail::model()->findAllByAttributes(array('invoice_header_id' => $id));
        
        if (isset($_POST['Process'])) {
            if (IdempotentManager::check()) {
                $valid = true;
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $model->invoice_number,
                ));

                $transactionType = 'Invoice'; //$model->registrationTransaction->repair_type == 'GR' ? 'Invoice GR' : 'Invoice BR';
                $postingDate = date('Y-m-d');
                $transactionCode = $model->invoice_number;
                $transactionDate = $model->invoice_date;
                $branchId = $model->branch_id;
                $transactionSubject = $model->customer->name;
                
                if ($model->registrationTransaction->repair_type == 'GR') {
                    $coaReceivableId = ($model->customer->customer_type == 'Company') ? $model->customer->coa_id : 1449;
                } else {
                    $coaReceivableId = (empty($model->registrationTransaction->insurance_company_id)) ? $model->customer->coa_id : $model->registrationTransaction->insuranceCompany->coa_id;
                }

                $journalReferences = array();

                $jurnalUmumReceivable = new JurnalUmum;
                $jurnalUmumReceivable->kode_transaksi = $transactionCode;
                $jurnalUmumReceivable->tanggal_transaksi = $transactionDate;
                $jurnalUmumReceivable->coa_id = $coaReceivableId;
                $jurnalUmumReceivable->branch_id = $branchId;
                $jurnalUmumReceivable->total = $model->total_price;
                $jurnalUmumReceivable->debet_kredit = 'D';
                $jurnalUmumReceivable->tanggal_posting = date('Y-m-d');
                $jurnalUmumReceivable->transaction_subject = $transactionSubject;
                $jurnalUmumReceivable->is_coa_category = 0;
                $jurnalUmumReceivable->transaction_type = $transactionType;
                $valid = $jurnalUmumReceivable->save() && $valid;

                if ($model->ppn_total > 0.00) {
                    $coaPpn = Coa::model()->findByAttributes(array('code' => '224.00.001'));
                    $jurnalUmumPpn = new JurnalUmum;
                    $jurnalUmumPpn->kode_transaksi = $transactionCode;
                    $jurnalUmumPpn->tanggal_transaksi = $transactionDate;
                    $jurnalUmumPpn->coa_id = $coaPpn->id;
                    $jurnalUmumPpn->branch_id = $model->branch_id;
                    $jurnalUmumPpn->total = $model->ppn_total;
                    $jurnalUmumPpn->debet_kredit = 'K';
                    $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                    $jurnalUmumPpn->transaction_subject = $transactionSubject;
                    $jurnalUmumPpn->is_coa_category = 0;
                    $jurnalUmumPpn->transaction_type = $transactionType;
                    $valid = $jurnalUmumPpn->save() && $valid;
                }

                foreach ($model->invoiceDetails as $key => $detail) {
                    if (!empty($detail->product_id)) {
                        $total = $detail->product->averageCogs * $detail->quantity;
                        
                        $jurnalUmumHpp = $detail->product->productSubMasterCategory->coa_hpp;
                        $journalReferences[$jurnalUmumHpp]['debet_kredit'] = 'D';
                        $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
                        $journalReferences[$jurnalUmumHpp]['values'][] = $total;

                        $jurnalUmumPenjualan = $detail->product->productSubMasterCategory->coa_penjualan_barang_dagang;
                        $journalReferences[$jurnalUmumPenjualan]['debet_kredit'] = 'K';
                        $journalReferences[$jurnalUmumPenjualan]['is_coa_category'] = 0;
                        $journalReferences[$jurnalUmumPenjualan]['values'][] = $detail->unit_price * $detail->quantity;

                        $jurnalUmumOutstandingPart = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                        $journalReferences[$jurnalUmumOutstandingPart]['debet_kredit'] = 'K';
                        $journalReferences[$jurnalUmumOutstandingPart]['is_coa_category'] = 0;
                        $journalReferences[$jurnalUmumOutstandingPart]['values'][] = $total;

//                        $registrationProduct = RegistrationProduct::model()->findByAttributes(array('registration_transaction_id' => $model->registration_transaction_id, 'product_id' => $detail->product_id));
                        if ($detail->discount > '0.00') {
                            $jurnalUmumDiskon = $detail->product->productSubMasterCategory->coa_diskon_penjualan;
                            $journalReferences[$jurnalUmumDiskon]['debet_kredit'] = 'D';
                            $journalReferences[$jurnalUmumDiskon]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumDiskon]['values'][] = $detail->discount;
                        }
                    } elseif (!empty($detail->service_id)) { 
//                        $price = $detail->is_quick_service == 1 ? $rService->price : $rService->price;

                        $jurnalUmumPendapatanJasa = $detail->service->serviceCategory->coa_id;
                        $journalReferences[$jurnalUmumPendapatanJasa]['debet_kredit'] = 'K';
                        $journalReferences[$jurnalUmumPendapatanJasa]['is_coa_category'] = 0;
                        $journalReferences[$jurnalUmumPendapatanJasa]['values'][] = $detail->unit_price;

//                        $registrationService = RegistrationService::model()->findByAttributes(array('registration_transaction_id' => $model->registration_transaction_id, 'service_id' => $detail->service_id));
                        if ($detail->discount > '0.00') {
                            $jurnalUmumDiscountPendapatanJasa = $detail->service->serviceCategory->coa_diskon_service;
                            $journalReferences[$jurnalUmumDiscountPendapatanJasa]['debet_kredit'] = 'D';
                            $journalReferences[$jurnalUmumDiscountPendapatanJasa]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumDiscountPendapatanJasa]['values'][] = $detail->discount;
                        }
                    } else {
                        continue;
                    }
                }

                foreach ($journalReferences as $coaId => $journalReference) {
                    $jurnalUmumPersediaan = new JurnalUmum();
                    $jurnalUmumPersediaan->kode_transaksi = $transactionCode;
                    $jurnalUmumPersediaan->tanggal_transaksi = $transactionDate;
                    $jurnalUmumPersediaan->coa_id = $coaId;
                    $jurnalUmumPersediaan->branch_id = $branchId;
                    $jurnalUmumPersediaan->total = array_sum($journalReference['values']);
                    $jurnalUmumPersediaan->debet_kredit = $journalReference['debet_kredit'];
                    $jurnalUmumPersediaan->tanggal_posting = $postingDate;
                    $jurnalUmumPersediaan->transaction_subject = $transactionSubject;
                    $jurnalUmumPersediaan->is_coa_category = $journalReference['is_coa_category'];
                    $jurnalUmumPersediaan->transaction_type = $transactionType;
                    $jurnalUmumPersediaan->save();
                }

                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('view', array(
            'model' => $model,
            'details' => $details,
            'payments' => $payments,
        ));
    }

    public function actionRegistrationList() {
        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        
        $registrationTransactionDataProvider = $registrationTransaction->searchByInvoice();

        $this->render('registrationList', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
        ));
    }
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($registrationId) {

        $invoice = $this->instantiate(null);

        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationId);
        $invoice->header->reference_type = 2;
        $invoice->header->registration_transaction_id = $registrationId;
        $invoice->header->invoice_date = date('Y-m-d');
        $invoice->header->due_date = date('Y-m-d',strtotime('+' . $registrationTransaction->customer->tenor . ' days',strtotime(date('Y-m-d'))));
        $invoice->header->customer_id = $registrationTransaction->customer_id;
        $invoice->header->vehicle_id = $registrationTransaction->vehicle_id;
        $invoice->header->branch_id = $registrationTransaction->branch_id;
        $invoice->header->user_id = Yii::app()->user->getId();
        $invoice->header->status = "Outstanding Payment";
        $invoice->header->total_product = $registrationTransaction->total_product;
        $invoice->header->total_service = $registrationTransaction->total_service;
        $invoice->header->total_quick_service = $registrationTransaction->total_quickservice;
        $invoice->header->service_price = $registrationTransaction->total_service_price;
        $invoice->header->product_price = $registrationTransaction->total_product_price;
        $invoice->header->quick_service_price = $registrationTransaction->total_quickservice_price;
        $invoice->header->total_price = $registrationTransaction->grand_total;
        $invoice->header->payment_left = $registrationTransaction->grand_total;
        $invoice->header->payment_amount = 0;
        $invoice->header->ppn_total = $registrationTransaction->ppn_price;
        $invoice->header->ppn = ($registrationTransaction->tax_percentage > 0) ? 1 : 0;
        $invoice->header->tax_percentage = $registrationTransaction->tax_percentage;
        $invoice->header->payment_date_estimate = date('Y-m-d');
        $invoice->header->coa_bank_id_estimate = null;
        $invoice->header->created_datetime = date('Y-m-d H:i:s');
        $invoice->header->insurance_company_id = empty($registrationTransaction->insurance_company_id) ? null : $registrationTransaction->insurance_company_id;
        
        $invoice->addDetails($invoice->header->reference_type, $registrationId);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['InvoiceHeader']) && IdempotentManager::check()) {

            $this->loadState($invoice);
            $invoice->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($invoice->header->invoice_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($invoice->header->invoice_date)), $registrationTransaction->branch_id);
        
            if ($invoice->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $invoice->header->id));
            }
        }

        $this->render('create', array(
            'invoice' => $invoice,
        ));
    }

    public function actionUpdate($id) {
        $invoice = $this->instantiate($id);
        $this->performAjaxValidation($invoice->header);
        
        $invoice->header->edited_datetime = date('Y-m-d H:i:s');
        $invoice->header->user_id_edited = Yii::app()->user->id;
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['InvoiceHeader']) && IdempotentManager::check()) {
            $this->loadState($invoice);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $invoice->header->invoice_number,
            ));

            $invoice->header->setCodeNumberByRevision('invoice_number');
            
            if ($invoice->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $invoice->header->id));
            }
        }

        $this->render('update', array(
            'invoice' => $invoice,
        ));
    }

    public function actionCancel($id) {
        $model = $this->loadModel($id);
        
        $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $id));
        
        if (empty($paymentInDetail) || $paymentInDetail->paymentIn->user_id_cancelled !== null) {
            $model->status = 'CANCELLED!!!';
            $model->total_price = 0; 
            $model->payment_amount = 0;
            $model->payment_left = 0;
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->update(array('status', 'total_price', 'payment_amount', 'payment_left', 'cancelled_datetime', 'user_id_cancelled'));

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->invoice_number,
            ));
            
            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new InvoiceHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InvoiceHeader'])) {
            $model->attributes = $_GET['InvoiceHeader'];
        }
        
        $dataProvider = $model->searchByAdmin();
        $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        $dataProvider->criteria->with = array(
            'salesOrder',
            'registrationTransaction',
            'customer',
            'vehicle',
        );
        
        $saleOrderNumber = isset($_GET['SaleOrderNumber']) ? $_GET['SaleOrderNumber'] : '';
        $workOrderNumber = isset($_GET['WorkOrderNumber']) ? $_GET['WorkOrderNumber'] : '';

        if (!empty($saleOrderNumber)) {
            if (empty($model->sales_order_id)) {
                $dataProvider->criteria->compare('registrationTransaction.sales_order_number', $saleOrderNumber, true);
            } else {
                $dataProvider->criteria->compare('salesOrder.sale_order_no', $saleOrderNumber, true);
            }
        }
        
        if (!empty($workOrderNumber)) {
            $dataProvider->criteria->compare('registrationTransaction.work_order_number', $workOrderNumber, true);
        }
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'saleOrderNumber' => $saleOrderNumber,
            'workOrderNumber' => $workOrderNumber,
        ));
    }

    public function actionMemo($id) {
        $model = $this->loadModel($id);
        
        $this->render('memo', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = InvoiceHeader::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'invoice-header-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $invoice = new Invoices(new InvoiceHeader(), array());
        } else {
            $invoiceModel = $this->loadModel($id);
            $invoice = new Invoices($invoiceModel, $invoiceModel->invoiceDetails);
        }
        return $invoice;
    }

    public function loadState($invoice) {
        if (isset($_POST['InvoiceHeader'])) {
            $invoice->header->attributes = $_POST['InvoiceHeader'];
        }

        if (isset($_POST['InvoiceDetail'])) {
            foreach ($_POST['InvoiceDetail'] as $i => $item) {
                if (isset($invoice->details[$i])) {
                    $invoice->details[$i]->attributes = $item;
                } else {
                    $detail = new InvoiceDetail();
                    $detail->attributes = $item;
                    $invoice->details[] = $detail;
                }
            }
            if (count($_POST['InvoiceDetail']) < count($invoice->details)) {
                array_splice($invoice->details, $i + 1);
            }
        } else {
            $invoice->details = array();
        }
    }
}
