<?php

class PendingJournalController extends Controller {

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
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'viewPurchase' || 
            $filterChain->action->id === 'viewSale' || 
            $filterChain->action->id === 'viewTransfer'
        ) {
            if (!(Yii::app()->user->checkAccess('purchaseHead'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionIndexPurchase() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new TransactionPurchaseOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $model->attributes = $_GET['TransactionPurchaseOrder'];
        }
        
        $purchaseOrderDataProvider = $model->searchByPendingJournal();
        $purchaseOrderDataProvider->criteria->addBetweenCondition('SUBSTRING(t.purchase_order_date, 1, 10)', $startDate, $endDate);

        $this->render('indexPurchase', array(
            'model'=> $model,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalPurchase() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $purchaseOrder->purchase_order_no,
                    ));

                    $jurnalUmumHutang = new JurnalUmum;
                    $jurnalUmumHutang->kode_transaksi = $purchaseOrder->purchase_order_no;
                    $jurnalUmumHutang->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                    $jurnalUmumHutang->coa_id = $purchaseOrder->supplier->coa_id;
                    $jurnalUmumHutang->branch_id = $purchaseOrder->main_branch_id;
                    $jurnalUmumHutang->total = $purchaseOrder->total_price;
                    $jurnalUmumHutang->debet_kredit = 'K';
                    $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
                    $jurnalUmumHutang->transaction_subject = $purchaseOrder->supplier->name;
                    $jurnalUmumHutang->is_coa_category = 0;
                    $jurnalUmumHutang->transaction_type = 'PO';
                    $jurnalUmumHutang->save();

                    if ($purchaseOrder->ppn_price > 0.00) {
                        $coaPpn = Coa::model()->findByAttributes(array('code' => '143.00.001'));
                        $jurnalUmumPpn = new JurnalUmum;
                        $jurnalUmumPpn->kode_transaksi = $purchaseOrder->purchase_order_no;
                        $jurnalUmumPpn->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                        $jurnalUmumPpn->coa_id = $coaPpn->id;
                        $jurnalUmumPpn->branch_id = $purchaseOrder->main_branch_id;
                        $jurnalUmumPpn->total = $purchaseOrder->ppn_price;
                        $jurnalUmumPpn->debet_kredit = 'D';
                        $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPpn->transaction_subject = $purchaseOrder->supplier->name;
                        $jurnalUmumPpn->is_coa_category = 0;
                        $jurnalUmumPpn->transaction_type = 'PO';
                        $jurnalUmumPpn->save();
                    }

                    $jurnalUmumOutstanding = new JurnalUmum;
                    $jurnalUmumOutstanding->kode_transaksi = $purchaseOrder->purchase_order_no;
                    $jurnalUmumOutstanding->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                    $jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coa_outstanding_order;
                    $jurnalUmumOutstanding->branch_id = $purchaseOrder->main_branch_id;
                    $jurnalUmumOutstanding->total = $purchaseOrder->subtotal;
                    $jurnalUmumOutstanding->debet_kredit = 'D';
                    $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
                    $jurnalUmumOutstanding->transaction_subject = $purchaseOrder->supplier->name;
                    $jurnalUmumOutstanding->is_coa_category = 0;
                    $jurnalUmumOutstanding->transaction_type = 'PO';
                    $jurnalUmumOutstanding->save();

                }

                $this->redirect(array('indexPurchase'));
            }
        }
    }

    public function actionIndexReceive() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $receiveItemSql = TransactionReceiveItem::pendingJournal();
        $receiveItemDataProvider = new CSqlDataProvider($receiveItemSql, array(
            'db' => Yii::app()->db,
            'totalItemCount' => Yii::app()->db->createCommand(SqlViewGenerator::count($receiveItemSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));

        $this->render('indexReceive', array(
            'receiveItemDataProvider' => $receiveItemDataProvider,
        ));
    }
    
    public function actionIndexInvoice() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2023-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new InvoiceHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['InvoiceHeader'])) {
            $model->attributes = $_GET['InvoiceHeader'];
        }
        
        $saleInvoiceDataProvider = $model->searchByPendingJournal();
        $saleInvoiceDataProvider->criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);

        $this->render('indexInvoice', array(
            'model'=> $model,
            'saleInvoiceDataProvider' => $saleInvoiceDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournaInvoice() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $model = InvoiceHeader::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $model->invoice_number,
                    ));
                    $valid = true;

                    $transactionType = 'Invoice';
                    $postingDate = date('Y-m-d');
                    $transactionCode = $model->invoice_number;
                    $transactionDate = $model->invoice_date;
                    $branchId = $model->branch_id;
                    $transactionSubject = $model->note . ' ' . $model->customer->name;

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

        //            if ($model->pph_price > 0.00) {
        //                $coaPph = Coa::model()->findByAttributes(array('code' => '224.00.004'));
        //                $jurnalUmumPpn = new JurnalUmum;
        //                $jurnalUmumPpn->kode_transaksi = $model->transaction_number;
        //                $jurnalUmumPpn->tanggal_transaksi = $model->transaction_date;
        //                $jurnalUmumPpn->coa_id = $coaPph->id;
        //                $jurnalUmumPpn->branch_id = $model->branch_id;
        //                $jurnalUmumPpn->total = $model->pph_price;
        //                $jurnalUmumPpn->debet_kredit = 'D';
        //                $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
        //                $jurnalUmumPpn->transaction_subject = $transactionSubject;
        //                $jurnalUmumPpn->is_coa_category = 0;
        //                $jurnalUmumPpn->transaction_type = $transactionType;
        //                $jurnalUmumPpn->save();
        //            }

                    foreach ($model->invoiceDetails as $key => $detail) {
                        if (!empty($detail->product_id)) {
                            $jurnalUmumHpp = $detail->product->productSubMasterCategory->coa_hpp;
                            $journalReferences[$jurnalUmumHpp]['debet_kredit'] = 'D';
                            $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumHpp]['values'][] = $detail->quantity * $detail->product->hpp;

                            $jurnalUmumPenjualan = $detail->product->productSubMasterCategory->coa_penjualan_barang_dagang;
                            $journalReferences[$jurnalUmumPenjualan]['debet_kredit'] = 'K';
                            $journalReferences[$jurnalUmumPenjualan]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumPenjualan]['values'][] = $detail->unit_price * $detail->quantity;

                            $jurnalUmumOutstandingPart = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                            $journalReferences[$jurnalUmumOutstandingPart]['debet_kredit'] = 'K';
                            $journalReferences[$jurnalUmumOutstandingPart]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumOutstandingPart]['values'][] = $detail->quantity * $detail->product->hpp;

                            $registrationProduct = RegistrationProduct::model()->findByAttributes(array('registration_transaction_id' => $model->registration_transaction_id, 'product_id' => $detail->product_id));
                            if (!empty($registrationProduct) && $registrationProduct->discount > 0) {
                                $jurnalUmumDiskon = $detail->product->productSubMasterCategory->coa_diskon_penjualan;
                                $journalReferences[$jurnalUmumDiskon]['debet_kredit'] = 'D';
                                $journalReferences[$jurnalUmumDiskon]['is_coa_category'] = 0;
                                $journalReferences[$jurnalUmumDiskon]['values'][] = $registrationProduct->discountAmount;
                            }
                        } elseif (!empty($detail->service_id)) { 
    //                        $price = $detail->is_quick_service == 1 ? $rService->price : $rService->price;

                            $jurnalUmumPendapatanJasa = $detail->service->serviceCategory->coa_id;
                            $journalReferences[$jurnalUmumPendapatanJasa]['debet_kredit'] = 'K';
                            $journalReferences[$jurnalUmumPendapatanJasa]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumPendapatanJasa]['values'][] = $detail->unit_price;

                            $registrationService = RegistrationService::model()->findByAttributes(array('registration_transaction_id' => $model->registration_transaction_id, 'service_id' => $detail->service_id));
                            if (!empty($registrationService) && $registrationService->discount_price > 0.00) {
                                $jurnalUmumDiscountPendapatanJasa = $detail->service->serviceCategory->coa_diskon_service;
                                $journalReferences[$jurnalUmumDiscountPendapatanJasa]['debet_kredit'] = 'D';
                                $journalReferences[$jurnalUmumDiscountPendapatanJasa]['is_coa_category'] = 0;
                                $journalReferences[$jurnalUmumDiscountPendapatanJasa]['values'][] = $registrationService->discount_price;
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

                }
            }
            
            $this->redirect(array('indexInvoice'));
        }
    }

    public function actionIndexPaymentIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new PaymentIn('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentIn'])) {
            $model->attributes = $_GET['PaymentIn'];
        }
        
        $paymentInDataProvider = $model->searchByPendingJournal();
        $paymentInDataProvider->criteria->addBetweenCondition('SUBSTRING(t.payment_date, 1, 10)', $startDate, $endDate);

        $this->render('indexPaymentIn', array(
            'model'=> $model,
            'paymentInDataProvider' => $paymentInDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalPaymentIn() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $model = PaymentIn::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $model->payment_number,
                        'branch_id' => $model->branch_id,
                    ));

                    $totalKas = ($model->is_tax_service == 2) ? $model->payment_amount : $model->payment_amount + $model->tax_service_amount;

                    $jurnalPiutang = new JurnalUmum;
                    $jurnalPiutang->kode_transaksi = $model->payment_number;
                    $jurnalPiutang->tanggal_transaksi = $model->payment_date;
                    $jurnalPiutang->coa_id = $model->customer->coa_id;
                    $jurnalPiutang->branch_id = $model->branch_id;
                    $jurnalPiutang->total = $totalKas;
                    $jurnalPiutang->debet_kredit = 'K';
                    $jurnalPiutang->tanggal_posting = date('Y-m-d');
                    $jurnalPiutang->transaction_subject = $model->customer->name;
                    $jurnalPiutang->is_coa_category = 0;
                    $jurnalPiutang->transaction_type = 'Pin';
                    $jurnalPiutang->save();

                    if (!empty($model->paymentType->coa_id)) {
                        $coaId = $model->paymentType->coa_id;
                    } else {
                        $coaId = $model->companyBank->coa_id;
                    }

                    $jurnalUmumKas = new JurnalUmum;
                    $jurnalUmumKas->kode_transaksi = $model->payment_number;
                    $jurnalUmumKas->tanggal_transaksi = $model->payment_date;
                    $jurnalUmumKas->coa_id = $coaId;
                    $jurnalUmumKas->branch_id = $model->branch_id;
                    $jurnalUmumKas->total = $model->payment_amount;
                    $jurnalUmumKas->debet_kredit = 'D';
                    $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                    $jurnalUmumKas->transaction_subject = $model->customer->name;
                    $jurnalUmumKas->is_coa_category = 0;
                    $jurnalUmumKas->transaction_type = 'Pin';
                    $jurnalUmumKas->save();

                    if ($model->tax_service_amount > 0) {
                        $jurnalPph = new JurnalUmum;
                        $jurnalPph->kode_transaksi = $model->payment_number;
                        $jurnalPph->tanggal_transaksi = $model->payment_date;
                        $jurnalPph->coa_id = 1473;
                        $jurnalPph->branch_id = $model->branch_id;
                        $jurnalPph->total = $model->tax_service_amount;
                        $jurnalPph->debet_kredit = 'D';
                        $jurnalPph->tanggal_posting = date('Y-m-d');
                        $jurnalPph->transaction_subject = $model->customer->name;
                        $jurnalPph->is_coa_category = 0;
                        $jurnalPph->transaction_type = 'Pin';
                        $jurnalPph->save();
                    }
                }

                $this->redirect(array('indexPaymentIn'));
            }

        }
    }

    public function actionIndexPaymentOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new PaymentOut('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PaymentOut'])) {
            $model->attributes = $_GET['PaymentOut'];
        }
        
        $paymentOutDataProvider = $model->searchByPendingJournal();
        $paymentOutDataProvider->criteria->addBetweenCondition('SUBSTRING(t.payment_date, 1, 10)', $startDate, $endDate);

        $this->render('indexPaymentOut', array(
            'model'=> $model,
            'paymentOutDataProvider' => $paymentOutDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalPaymentOut() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $paymentOut = PaymentOut::model()->findByPk($data);
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
                    $jurnalHutang->transaction_subject = $paymentOut->supplier->name;
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
                    $jurnalUmumKas->transaction_subject = $paymentOut->supplier->name;
                    $jurnalUmumKas->is_coa_category = 0;
                    $jurnalUmumKas->transaction_type = 'Pout';
                    $jurnalUmumKas->save();
                }

                $this->redirect(array('indexPaymentOut'));
            }

        }
    }

    public function actionIndexMovementIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new MovementInHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MovementInHeader'])) {
            $model->attributes = $_GET['MovementInHeader'];
        }
        
        $movementInDataProvider = $model->searchByPendingJournal();
        $movementInDataProvider->criteria->addBetweenCondition('SUBSTRING(t.date_posting, 1, 10)', $startDate, $endDate);

        $this->render('indexMovementIn', array(
            'model'=> $model,
            'movementInDataProvider' => $movementInDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalMovementIn() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $model = MovementInHeader::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $model->movement_in_number,
                        'branch_id' => $model->branch_id,
                    ));

                    $transactionType = 'MI';
                    $postingDate = date('Y-m-d');
                    $transactionCode = $model->movement_in_number;
                    $transactionDate = $model->date_posting;
                    $branchId = $model->branch_id;
                    $transactionSubject = 'Movement In';

                    $journalReferences = array();

                    foreach ($model->movementInDetails as $movementDetail) {
                        $unitPrice = empty($movementDetail->receiveItemDetail->purchaseOrderDetail) ? $movementDetail->product->hpp : $movementDetail->receiveItemDetail->purchaseOrderDetail->unit_price;
                        $jumlah = $movementDetail->quantity * $unitPrice;

                        $value = $jumlah;
                        $coaMasterTransitId = $movementDetail->product->productMasterCategory->coa_inventory_in_transit;
                        $journalReferences[$coaMasterTransitId]['debet_kredit'] = 'K';
                        $journalReferences[$coaMasterTransitId]['is_coa_category'] = 1;
                        $journalReferences[$coaMasterTransitId]['values'][] = $value;

                        $coaSubTransitId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                        $journalReferences[$coaSubTransitId]['debet_kredit'] = 'K';
                        $journalReferences[$coaSubTransitId]['is_coa_category'] = 0;
                        $journalReferences[$coaSubTransitId]['values'][] = $value;

                        $coaMasterInventoryId = $movementDetail->product->productMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaMasterInventoryId]['debet_kredit'] = 'D';
                        $journalReferences[$coaMasterInventoryId]['is_coa_category'] = 1;
                        $journalReferences[$coaMasterInventoryId]['values'][] = $value;

                        $coaSubInventoryId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaSubInventoryId]['debet_kredit'] = 'D';
                        $journalReferences[$coaSubInventoryId]['is_coa_category'] = 0;
                        $journalReferences[$coaSubInventoryId]['values'][] = $value;
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

                }

                $this->redirect(array('indexMovementIn'));
            }

        }
    }

    public function actionIndexMovementOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new MovementOutHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MovementOutHeader'])) {
            $model->attributes = $_GET['MovementOutHeader'];
        }
        
        $movementOutDataProvider = $model->searchByPendingJournal();
        $movementOutDataProvider->criteria->addBetweenCondition('SUBSTRING(t.date_posting, 1, 10)', $startDate, $endDate);

        $this->render('indexMovementOut', array(
            'model'=> $model,
            'movementOutDataProvider' => $movementOutDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalMovementOut() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $model = MovementOutHeader::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $model->movement_out_no,
                        'branch_id' => $model->branch_id,
                    ));

                    $transactionType = 'MO';
                    $postingDate = date('Y-m-d');
                    $transactionCode = $model->movement_out_no;
                    $transactionDate = $model->date_posting;
                    $branchId = $model->branch_id;
                    $transactionSubject = 'Movement Out';

                    $journalReferences = array();

                    foreach ($model->movementOutDetails as $movementDetail) {
                        $value = $movementDetail->quantity * $movementDetail->product->hpp;

                        if ((int)$model->movement_type == 3) {
                            $coaId = $movementDetail->product->productMasterCategory->coa_outstanding_part_id;
                            $journalReferences[$coaId]['debet_kredit'] = 'D';
                            $journalReferences[$coaId]['is_coa_category'] = 1;
                            $journalReferences[$coaId]['values'][] = $value;
                            $coaId = $movementDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                            $journalReferences[$coaId]['debet_kredit'] = 'D';
                            $journalReferences[$coaId]['is_coa_category'] = 0;
                            $journalReferences[$coaId]['values'][] = $value;

                        } else {
                            $coaId = $movementDetail->product->productMasterCategory->coa_inventory_in_transit;
                            $journalReferences[$coaId]['debet_kredit'] = 'D';
                            $journalReferences[$coaId]['is_coa_category'] = 1;
                            $journalReferences[$coaId]['values'][] = $value;
                            $coaId = $movementDetail->product->productSubMasterCategory->coa_inventory_in_transit;
                            $journalReferences[$coaId]['debet_kredit'] = 'D';
                            $journalReferences[$coaId]['is_coa_category'] = 0;
                            $journalReferences[$coaId]['values'][] = $value;

                        }

                        $coaId = $movementDetail->product->productMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaId]['debet_kredit'] = 'K';
                        $journalReferences[$coaId]['is_coa_category'] = 1;
                        $journalReferences[$coaId]['values'][] = $value;
                        $coaId = $movementDetail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                        $journalReferences[$coaId]['debet_kredit'] = 'K';
                        $journalReferences[$coaId]['is_coa_category'] = 0;
                        $journalReferences[$coaId]['values'][] = $value;

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

                }

                $this->redirect(array('indexMovementOut'));
            }

        }
    }

    public function actionIndexDelivery() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $deliveryOrderSql = TransactionDeliveryOrder::pendingJournal();
        $deliveryOrderDataProvider = new CSqlDataProvider($deliveryOrderSql, array(
            'db' => Yii::app()->db,
            'totalItemCount' => Yii::app()->db->createCommand(SqlViewGenerator::count($deliveryOrderSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));
        
        $this->render('indexDelivery', array(
            'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
        ));
    }
    
    public function actionIndexCash() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2022-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new CashTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CashTransaction'])) {
            $model->attributes = $_GET['CashTransaction'];
        }
        
        $cashTransactionDataProvider = $model->searchByPendingJournal();
        $cashTransactionDataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('indexCash', array(
            'model'=> $model,
            'cashTransactionDataProvider' => $cashTransactionDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalCash() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $cashTransaction = CashTransaction::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $cashTransaction->transaction_number,
                        'branch_id' => $cashTransaction->branch_id,
                    ));

                    if ($cashTransaction->transaction_type == "In") {
                        $jurnalUmum = new JurnalUmum;
                        $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                        $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                        $jurnalUmum->coa_id = $cashTransaction->coa_id;
                        $jurnalUmum->total = $cashTransaction->credit_amount;
                        $jurnalUmum->debet_kredit = 'D';
                        $jurnalUmum->tanggal_posting = date('Y-m-d');
                        $jurnalUmum->branch_id = $cashTransaction->branch_id;
                        $jurnalUmum->transaction_subject = 'Cash Transaction In';
                        $jurnalUmum->is_coa_category = 0;
                        $jurnalUmum->transaction_type = 'CASH';
                        $jurnalUmum->save();
                    } else {
                        $jurnalUmum = new JurnalUmum;
                        $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                        $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                        $jurnalUmum->coa_id = $cashTransaction->coa_id;
                        $jurnalUmum->total = $cashTransaction->debit_amount;
                        $jurnalUmum->debet_kredit = 'K';
                        $jurnalUmum->tanggal_posting = date('Y-m-d');
                        $jurnalUmum->branch_id = $cashTransaction->branch_id;
                        $jurnalUmum->transaction_subject = 'Cash Transaction Out';
                        $jurnalUmum->is_coa_category = 0;
                        $jurnalUmum->transaction_type = 'CASH';
                        $jurnalUmum->save();
                    }

                    foreach ($cashTransaction->cashTransactionDetails as $key => $ctDetail) {

                        if ($cashTransaction->transaction_type == "In") {
                            $jurnalUmum = new JurnalUmum;
                            $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                            $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                            $jurnalUmum->coa_id = $ctDetail->coa_id;
                            $jurnalUmum->total = $ctDetail->amount;
                            $jurnalUmum->debet_kredit = 'K';
                            $jurnalUmum->tanggal_posting = date('Y-m-d');
                            $jurnalUmum->branch_id = $cashTransaction->branch_id;
                            $jurnalUmum->transaction_subject = 'Cash Transaction In';
                            $jurnalUmum->is_coa_category = 0;
                            $jurnalUmum->transaction_type = 'CASH';
                            $jurnalUmum->save(false);
                        } else {
                            $jurnalUmum = new JurnalUmum;
                            $jurnalUmum->kode_transaksi = $cashTransaction->transaction_number;
                            $jurnalUmum->tanggal_transaksi = $cashTransaction->transaction_date;
                            $jurnalUmum->coa_id = $ctDetail->coa_id;
                            $jurnalUmum->total = $ctDetail->amount;
                            $jurnalUmum->debet_kredit = 'D';
                            $jurnalUmum->tanggal_posting = date('Y-m-d');
                            $jurnalUmum->branch_id = $cashTransaction->branch_id;
                            $jurnalUmum->transaction_subject = 'Cash Transaction Out';
                            $jurnalUmum->is_coa_category = 0;
                            $jurnalUmum->transaction_type = 'CASH';
                            $jurnalUmum->save(false);
                        }
                    }            

                }

                $this->redirect(array('indexCash'));
            }

        }
    }

    public function actionIndexAdjustmentStock() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '2023-01-01';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $model = new StockAdjustmentHeader('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['StockAdjustmentHeader'])) {
            $model->attributes = $_GET['StockAdjustmentHeader'];
        }
        
        $stockAdjustmentDataProvider = $model->searchByPendingJournal();
        $stockAdjustmentDataProvider->criteria->addBetweenCondition('t.date_posting', $startDate, $endDate);

        $this->render('indexAdjustmentStock', array(
            'model'=> $model,
            'stockAdjustmentDataProvider' => $stockAdjustmentDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionAjaxHtmlPostingJournalStockAdjustment() {
        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['selectedIds'])) {
                $datas = array();
                $datas = $_POST['selectedIds'];

                foreach ($datas as $data) {
                    $stockAdjustmentHeader = StockAdjustmentHeader::model()->findByPk($data);
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $stockAdjustmentHeader->stock_adjustment_number,
                    ));

                    $transactionType = StockAdjustmentHeader::CONSTANT;
                    $postingDate = date('Y-m-d');
                    $transactionCode = $stockAdjustmentHeader->stock_adjustment_number;
                    $transactionDate = $stockAdjustmentHeader->date_posting;
                    $branchId = $stockAdjustmentHeader->branch_id;
                    $transactionSubject = $stockAdjustmentHeader->transaction_type;

                    $journalReferences = array();

                    foreach ($stockAdjustmentHeader->stockAdjustmentDetails as $key => $detail) {
                        if (!empty($detail->product_id)) {
                            $quantityDifference = ($detail->quantity_current > $detail->quantity_adjustment) ? $detail->quantityDifference * -1 : $detail->quantityDifference;
                            $total = $detail->product->hpp * $quantityDifference;

                            $jurnalUmumHpp = $detail->product->productSubMasterCategory->coa_hpp;
                            $journalReferences[$jurnalUmumHpp]['debet_kredit'] = ($detail->quantity_current < $detail->quantity_adjustment) ? 'D' : 'K';
                            $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumHpp]['values'][] = $total;

                            $jurnalUmumPersediaan = $detail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                            $journalReferences[$jurnalUmumPersediaan]['debet_kredit'] = ($detail->quantity_current < $detail->quantity_adjustment) ? 'K' : 'D';
                            $journalReferences[$jurnalUmumPersediaan]['is_coa_category'] = 0;
                            $journalReferences[$jurnalUmumPersediaan]['values'][] = $total;
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
                }

                $this->redirect(array('indexAdjustmentStock'));
            }

        }
    }

    public function actionIndexSale() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : 100;
        $currentPage = (isset($_GET['CurrentPage'])) ? $_GET['CurrentPage'] - 1 : 0;
        
        $saleOrderSql = TransactionSalesOrder::pendingJournal();
        $saleOrderDataProvider = new CSqlDataProvider($saleOrderSql, array(
            'db' => Yii::app()->db,
            'totalItemCount' => Yii::app()->db->createCommand(SqlViewGenerator::count($saleOrderSql))->queryScalar(),
            'pagination' => array(
                'pageVar' => 'CurrentPage',
                'pageSize' => ($pageSize > 0) ? $pageSize : 1,
                'currentPage' => $currentPage,
            ),
        ));
        
        $this->render('indexSale', array(
            'saleOrderDataProvider' => $saleOrderDataProvider,
        ));
    }
}
