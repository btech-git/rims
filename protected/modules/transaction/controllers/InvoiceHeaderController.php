<?php

class InvoiceHeaderController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';

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
        $payments = PaymentIn::model()->findAllByAttributes(array('invoice_id' => $id));
        
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

    public function actionViewInvoices() {
        // $id = array(4,5);
        (!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $pr);
        $invoices = InvoiceHeader::model()->findAll($criteria);

        //$details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id'=>$id));
        $this->render('viewInvoices', array(
            //'model'=>$this->loadModel($id),
            //'details'=>$details,
            'invoices' => $invoices,
        ));
    }

    public function actionUpdateEstimateDate($id) {
        $model = $this->loadModel($id);
        $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id' => $id));
        $payments = PaymentIn::model()->findAllByAttributes(array('invoice_id' => $id));
        
        if (isset($_POST['Update'])) {
            $model->payment_date_estimate = $_POST['InvoiceHeader']['payment_date_estimate'];
            $model->coa_bank_id_estimate = $_POST['InvoiceHeader']['coa_bank_id_estimate'];
            $model->update(array('coa_bank_id_estimate', 'payment_date_estimate'));

            $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('updateEstimateDate', array(
            'model' => $model,
            'details' => $details,
            'payments' => $payments,
        ));
    }

    public function actionPdfAll() {
        $this->layout = '//layouts/invoice';
        (!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $pr);
        $invoices = InvoiceHeader::model()->findAll($criteria);

        $mPDF1 = Yii::app()->ePdf->mpdf();
        # You can easily override default constructor's params
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A5-L');

        # render (full page)
        // $mPDF1->WriteHTML($this->render('index', array(), true));
        # Load a stylesheet
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/invoices.css');
        $mPDF1->WriteHTML($stylesheet, 1);

        # renderPartial (only 'view' of current controller)
        $mPDF1->WriteHTML(
                $this->renderPartial('pdfInvoices', array(
                    'invoices' => $invoices,
                        ), true)
        );
        // $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
        $mPDF1->Output('Invoice.pdf', 'D');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($registrationId) {

        $invoice = $this->instantiate(null);
//        $this->performAjaxValidation($invoice->header);

        $registrationTransaction = RegistrationTransaction::model()->findByPk($registrationId);
        $invoice->header->reference_type = 2;
        $invoice->header->registration_transaction_id = $registrationId;
        $invoice->header->customer_id = $registrationTransaction->customer_id;
        $invoice->header->vehicle_id = $registrationTransaction->vehicle_id;
        $invoice->header->branch_id = $registrationTransaction->branch_id;
        $invoice->header->user_id = Yii::app()->user->getId();
        $invoice->header->status = "INVOICING";
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        //$model=$this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $invoice = $this->instantiate($id);
        $invoice->header->setCodeNumberByRevision('invoice_number');
        $this->performAjaxValidation($invoice->header);

        // if(isset($_POST['InvoiceHeader']))
        // {
        // 	$model->attributes=$_POST['InvoiceHeader'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['InvoiceHeader']) && IdempotentManager::check()) {

            $this->loadState($invoice);
            if ($invoice->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $invoice->header->id));
            }
        }

        $this->render('update', array(
            //'model'=>$model,
            'invoice' => $invoice,
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

    public function actionCancel($id) {
        $model = $this->loadModel($id);
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

        $this->redirect(array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {

        $dataProvider = new CActiveDataProvider('InvoiceHeader');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
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
        $dataProvider->criteria->addInCondition('t.branch_id', Yii::app()->user->branch_ids);
        $dataProvider->criteria->with = array(
            'salesOrder',
            'registrationTransaction',
            'customer',
            'vehicle',
            
        );
        
        (!empty(Yii::app()->session['pr'])) ? $pr = Yii::app()->session['pr'] : $pr = array();
        
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
            'prChecked' => $pr,
            'saleOrderNumber' => $saleOrderNumber,
            'workOrderNumber' => $workOrderNumber,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InvoiceHeader the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = InvoiceHeader::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InvoiceHeader $model the model to be validated
     */
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
            //print_r("test");
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
            if (count($_POST['InvoiceDetail']) < count($invoice->details))
                array_splice($invoice->details, $i + 1);
        }
        else {
            $invoice->details = array();
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;

            $productCriteria->together = true;
            $productCriteria->select = 't.id,t.name, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('t.name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->compare('findkeyword', $product->findkeyword, true);
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,));

            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $consignmentIn->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('consignmentIn' => $consignmentIn, 'product' => $product,
                'productDataProvider' => $productDataProvider,
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product']))
                $product->attributes = $_GET['Product'];

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
            $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,));

            $consignmentIn = $this->instantiate($id);
            $this->loadState($consignmentIn);

            $consignmentIn->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array('consignmentIn' => $consignmentIn, 'product' => $product,
                'productDataProvider' => $productDataProvider,
                    ), false, true);
        }
    }

    public function actionPrTemp() {
        if (Yii::app()->request->isAjaxRequest) {
            // var_dump($_GET['productChecked']);die("s");
            if ($_GET['checked'] == 'clear') {
                Yii::app()->session->remove('pr');
            } else {
                Yii::app()->session['pr'] = $_GET['checked'];
            }
        }
    }

    public function actionAjaxCustomer($id) {

        if (Yii::app()->request->isAjaxRequest) {
            // $invoice = $this->instantiate($id);
            // $this->loadState($invoice);

            $customer = Customer::model()->findByPk($id);

            $object = array(
                'name' => $customer->name,
                'address' => $customer->address,
                'type' => $customer->customer_type,
                'province' => $customer->province_id,
                'city' => $customer->city_id,
                'zipcode' => $customer->zipcode,
                'email' => $customer->email,
                'rate' => $customer->flat_rate,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionPpn($id, $ppn_type, $ref) {
        $model = $this->loadModel($id);

        if ($ref == 1) {
            //$salesOrder = TransactionSalesOrder::model()->findByPk($model->sales_order_id);
            if ($ppn_type == 1) {
                $model->ppn = 1;
                $model->ppn_total = $model->product_price * 0.1;
                $model->total_price = $model->product_price * 1.1;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
            else {
                $model->ppn = 0;
                $model->ppn_total = 0;
                $model->total_price = $model->product_price;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }
        else {
            //$registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id);
            $totalPrice = $model->quick_service_price + $model->service_price + $model->product_price;
            if ($ppn_type == 1) {
                $model->ppn = 1;
                $model->ppn_total = $totalPrice * 0.1;
                $model->total_price = $totalPrice * 1.1;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
            else {
                $model->ppn = 0;
                $model->ppn_total = 0;
                $model->total_price = $totalPrice;
                if ($model->update(array('ppn', 'ppn_total', 'total_price')))
                    $this->redirect(array('view', 'id' => $model->id));
            }
        }
    }

    // public function actionPph($id,$pph){
    // 	$model = $this->loadModel($id);
    // 	$registration = RegistrationTransaction::model()->findByPk($model->registration_transaction_id);
    // 		$totalPrice = $registration->total_quickservice_price + $registration->subtotal_service + $registration->subtotal_product;
    // 	if($pph == 1){
    // 		$model->pph = 1;
    // 		$model->pph_total = $
    // 	}
    // }
}
