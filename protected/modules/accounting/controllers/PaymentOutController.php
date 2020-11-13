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
            if (!(Yii::app()->user->checkAccess('salePaymentCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('salePaymentEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'ajaxHtmlResetPayment' || $filterChain->action->id === 'ajaxHtmlRemovePayment' || $filterChain->action->id === 'ajaxHtmlAddAccount' || $filterChain->action->id === 'ajaxJsonTotal' || $filterChain->action->id === 'ajaxJsonSaleReceipt' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('salePaymentCreate') || Yii::app()->user->checkAccess('salePaymentEdit')))
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

    public function actionCreate($supplierId) {
        $paymentOut = $this->instantiate(null);
        $supplier = Supplier::model()->findByPk($supplierId);

        $paymentOut->header->user_id = Yii::app()->user->id;
        $paymentOut->header->payment_date = date('Y-m-d');
        $paymentOut->header->supplier_id = $supplierId;
        $paymentOut->header->status = 'Draft';
        $paymentOut->header->branch_id = Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id;
//        $paymentOut->header->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($paymentOut->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($paymentOut->header->payment_date)), $paymentOut->header->branch_id);

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        if (!empty($supplierId)) {
            $receiveItemDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $receiveItemDataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
        
        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['Submit'])) {
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
        ));
    }

    public function actionUpdate($id) {
        $paymentOut = $this->instantiate($id);
        $supplier = Supplier::model()->findByPk($paymentOut->header->supplier_id);

        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());
        $receiveItemDataProvider = $receiveItem->searchForPaymentOut();

        if (!empty($paymentOut->header->supplier_id)) {
            $receiveItemDataProvider->criteria->addCondition("t.supplier_id = :supplier_id");
            $receiveItemDataProvider->criteria->params[':supplier_id'] = $paymentOut->header->supplier_id;
        }
        
        if (isset($_POST['Submit'])) {
            $this->loadState($paymentOut);

            if ($paymentOut->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $paymentOut->header->id));
        }

        $this->render('update', array(
            'paymentOut' => $paymentOut,
            'supplier' => $supplier,
            'receiveItem' => $receiveItem,
            'receiveItemDataProvider' => $receiveItemDataProvider,
        ));
    }

    public function actionView($id) {
        $paymentOut = $this->loadModel($id);
        $paymentOutDetails = PayOutDetail::model()->findAllByAttributes(array('payment_out_id' => $id));
        
        $postImages = PaymentOutImages::model()->findAllByAttributes(array(
            'payment_out_id' => $paymentOut->id,
            'is_inactive' => $paymentOut::STATUS_ACTIVE
        ));
        
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
        $supplierName = isset($_GET['SupplierName']) ? $_GET['SupplierName'] : '';

        if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']);
        }

        $dataProvider = $paymentOut->search();
        $dataProvider->criteria->with = array(
            'supplier',
        );

        if (!empty($supplierName)) {
            $dataProvider->criteria->addCondition("supplier.name LIKE :supplier_name");
            $dataProvider->criteria->params[':supplier_name'] = "%{$supplierName}%";
        }

        $dataProvider->criteria->order = 't.id DESC';

        $purchaseOrder = new TransactionPurchaseOrder('search');
        $purchaseOrder->unsetAttributes();
        
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $purchaseOrder->attributes = $_GET['TransactionPurchaseOrder'];
        }
        
        $purchaseOrderCriteria = new CDbCriteria;
        $purchaseOrderCriteria->addCondition('t.payment_status != "PAID"');
        $purchaseOrderCriteria->addCondition('t.status_document = "Approved"');
        $purchaseOrderCriteria->compare('purchase_order_no', $purchaseOrder->purchase_order_no, true);
        $purchaseOrderCriteria->compare('purchase_order_date', $purchaseOrder->purchase_order_date, true);
        $purchaseOrderCriteria->compare('total_price', $purchaseOrder->total_price, true);
        $purchaseOrderCriteria->together = true;
        $purchaseOrderCriteria->with = array('supplier');
        $purchaseOrderCriteria->compare('supplier.name', $purchaseOrder->supplier_name, true);
        $purchaseOrderDataProvider = new CActiveDataProvider('TransactionPurchaseOrder', array(
            'criteria' => $purchaseOrderCriteria,
            'sort' => array(
                'defaultOrder' => 'purchase_order_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $this->render('admin', array(
            'paymentOut' => $paymentOut,
            'dataProvider' => $dataProvider,
            'supplierName' => $supplierName,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId) {
        $paymentOut = PaymentOut::model()->findByPK($headerId);
        $historis = PaymentOutApproval::model()->findAllByAttributes(array('payment_out_id' => $headerId));
        $model = new PaymentOutApproval;
        $model->date = date('Y-m-d H:i:s');
        $branch = Branch::model()->findByPk($paymentOut->branch_id);
        $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($paymentOut->purchase_order_id);
        $getCoa = "";
        $getCoaDetail = "";

        if (isset($_POST['PaymentOutApproval'])) {
            $model->attributes = $_POST['PaymentOutApproval'];
            if ($model->save()) {
                $paymentOut->status = $model->approval_type;
                $paymentOut->save(false);

                if ($model->approval_type == 'Approved') {
                    if (!empty($purchaseOrderHeader)) {
                        if ($purchaseOrderHeader->payment_amount == 0)
                            $purchaseOrderHeader->payment_amount = $paymentOut->payment_amount;
                        else
                            $purchaseOrderHeader->payment_amount += $paymentOut->payment_amount;

                        $purchaseOrderHeader->payment_left -= $paymentOut->payment_amount;
                        if ($purchaseOrderHeader->payment_left > 0.00)
                            $purchaseOrderHeader->payment_status = 'PARTIALLY PAID';
                        else
                            $purchaseOrderHeader->payment_status = 'PAID';

                        $purchaseOrderHeader->update(array('payment_amount', 'payment_left', 'payment_status'));
                    }
                    
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $paymentOut->payment_number,
                        'tanggal_transaksi' => $paymentOut->payment_date,
                        'branch_id' => $paymentOut->branch_id,
                    ));

                    $priceBefore = empty($purchaseOrderHeader) ? $paymentOut->payment_amount : ($purchaseOrderHeader->ppn == 1) ? $paymentOut->payment_amount / 1.1 : $paymentOut->payment_amount;
                    $ppn = empty($purchaseOrderHeader) ? 0 : $purchaseOrderHeader->ppn == 1 ? $priceBefore * 0.1 : 0;
                    if ($paymentOut->payment_type == "Cash") {
//                        $getCoaHutang = '201.00.000';
//                        $coaHutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHutang));
//                        $jurnalHutang = new JurnalUmum;
//                        $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
//                        $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
//                        $jurnalHutang->coa_id = $coaHutangWithCode->id;
//                        $jurnalHutang->branch_id = $paymentOut->branch_id;
//                        $jurnalHutang->total = $priceBefore;
//                        $jurnalHutang->debet_kredit = 'D';
//                        $jurnalHutang->tanggal_posting = date('Y-m-d');
//                        $jurnalHutang->transaction_subject = $paymentOut->supplier->name;
//                        $jurnalHutang->is_coa_category = 0;
//                        $jurnalHutang->transaction_type = 'Pout';
//                        $jurnalHutang->save();

                        if ($ppn == 1) {
                            $getCoaPpn = '108.000';
                            $coaPpnWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPpn));
                            $jurnalPpn = new JurnalUmum;
                            $jurnalPpn->kode_transaksi = $paymentOut->payment_number;
                            $jurnalPpn->tanggal_transaksi = $paymentOut->payment_date;
                            $jurnalPpn->coa_id = $coaPpnWithCode->id;
                            $jurnalPpn->branch_id = $paymentOut->branch_id;
                            $jurnalPpn->total = $ppn;
                            $jurnalPpn->debet_kredit = 'D';
                            $jurnalPpn->tanggal_posting = date('Y-m-d');
                            $jurnalPpn->transaction_subject = $paymentOut->supplier->name;
                            $jurnalPpn->is_coa_category = 0;
                            $jurnalPpn->transaction_type = 'Pout';
                            $jurnalPpn->save();
                        }

                        $getCoaKas = '101.00.000';
                        $coaKasWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKas));
                        $jurnalUmumKas = new JurnalUmum;
                        $jurnalUmumKas->kode_transaksi = $paymentOut->payment_number;
                        $jurnalUmumKas->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalUmumKas->coa_id = $coaKasWithCode->id;
                        $jurnalUmumKas->branch_id = $paymentOut->branch_id;
                        $jurnalUmumKas->total = $paymentOut->payment_amount;
                        $jurnalUmumKas->debet_kredit = 'K';
                        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKas->transaction_subject = $paymentOut->supplier->name;
                        $jurnalUmumKas->is_coa_category = 0;
                        $jurnalUmumKas->transaction_type = 'Pout';
                        $jurnalUmumKas->save();
                    } else {
                        $getCoaHutang = '201.00.000';
                        $coaHutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHutang));
                        $jurnalHutang = new JurnalUmum;
                        $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
                        $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalHutang->coa_id = $coaHutangWithCode->id;
                        $jurnalHutang->branch_id = $paymentOut->branch_id;
                        $jurnalHutang->total = $priceBefore;
                        $jurnalHutang->debet_kredit = 'D';
                        $jurnalHutang->tanggal_posting = date('Y-m-d');
                        $jurnalHutang->transaction_subject = $paymentOut->supplier->name;
                        $jurnalHutang->is_coa_category = 0;
                        $jurnalHutang->transaction_type = 'Pout';
                        $jurnalHutang->save();

                        if ($ppn == 1) {
                            $getCoaPpn = '108.00.000';
                            $coaPpnWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPpn));
                            $jurnalPpn = new JurnalUmum;
                            $jurnalPpn->kode_transaksi = $paymentOut->payment_number;
                            $jurnalPpn->tanggal_transaksi = $paymentOut->payment_date;
                            $jurnalPpn->coa_id = $coaPpnWithCode->id;
                            $jurnalPpn->branch_id = $paymentOut->branch_id;
                            $jurnalPpn->total = $ppn;
                            $jurnalPpn->debet_kredit = 'D';
                            $jurnalPpn->tanggal_posting = date('Y-m-d');
                            $jurnalPpn->transaction_subject = $paymentOut->supplier->name;
                            $jurnalPpn->is_coa_category = 0;
                            $jurnalPpn->transaction_type = 'Pout';
                            $jurnalPpn->save();
                        }
                        
                        $getCoaKasBank = '102.00.000';
                        $coaKasBankWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKasBank));
                        $jurnalUmumKasBank = new JurnalUmum;
                        $jurnalUmumKasBank->kode_transaksi = $paymentOut->payment_number;
                        $jurnalUmumKasBank->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalUmumKasBank->coa_id = $coaKasBankWithCode->id;
                        $jurnalUmumKasBank->branch_id = $paymentOut->branch_id;
                        $jurnalUmumKasBank->total = $paymentOut->payment_amount;
                        $jurnalUmumKasBank->debet_kredit = 'K';
                        $jurnalUmumKasBank->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKasBank->transaction_subject = $paymentOut->supplier->name;
                        $jurnalUmumKasBank->is_coa_category = 1;
                        $jurnalUmumKasBank->transaction_type = 'Pout';
                        $jurnalUmumKasBank->save();
                        
                        $jurnalUmumBank = new JurnalUmum;
                        $jurnalUmumBank->kode_transaksi = $paymentOut->payment_number;
                        $jurnalUmumBank->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalUmumBank->coa_id = $paymentOut->companyBank->coa_id;
                        $jurnalUmumBank->branch_id = $paymentOut->branch_id;
                        $jurnalUmumBank->total = $paymentOut->payment_amount;
                        $jurnalUmumBank->debet_kredit = 'K';
                        $jurnalUmumBank->tanggal_posting = date('Y-m-d');
                        $jurnalUmumBank->transaction_subject = $paymentOut->supplier->name;
                        $jurnalUmumBank->is_coa_category = 0;
                        $jurnalUmumBank->transaction_type = 'Pout';
                        $jurnalUmumBank->save();
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

    public function actionAjaxHtmlAddInvoices($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id);
            $this->loadState($paymentOut);

            if (isset($_POST['selectedIds'])) {
                $invoices = array();
                $invoices = $_POST['selectedIds'];

                foreach ($invoices as $invoice)
                    $paymentOut->addInvoice($invoice);
            }

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
            ));
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $paymentOut = $this->instantiate($id);
            $this->loadState($paymentOut);

            $paymentOut->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'paymentOut' => $paymentOut,
            ));
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