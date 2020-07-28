<?php

class GeneralRepairRegistrationController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'generateInvoice' || 
            $filterChain->action->id === 'generateSalesOrder' || 
            $filterChain->action->id === 'generateWorkOrder' || 
            $filterChain->action->id === 'receive' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'showRealization' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('frontOfficeStaff')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate($vehicleId) {
        $generalRepairRegistration = $this->instantiate(null);
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        
        $generalRepairRegistration->header->transaction_date = date('Y-m-d H:i:s');
        $generalRepairRegistration->header->user_id = Yii::app()->user->id;
        $generalRepairRegistration->header->vehicle_id = $vehicleId;
        $generalRepairRegistration->header->customer_id = $vehicle->customer_id;
        $generalRepairRegistration->header->branch_id = $generalRepairRegistration->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $generalRepairRegistration->header->branch_id;
        $generalRepairRegistration->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($generalRepairRegistration->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($generalRepairRegistration->header->transaction_date)), $generalRepairRegistration->header->branch_id);

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        if (isset($_POST['_FormSubmit_'])) {
            if ($_POST['_FormSubmit_'] === 'Submit') {
                $this->loadState($generalRepairRegistration);

                if ($generalRepairRegistration->save(Yii::app()->db)) 
                    $this->redirect(array('view', 'id' => $generalRepairRegistration->header->id));
            }
        }

        $this->render('create', array(
            'generalRepairRegistration' => $generalRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionAddProductService($registrationId) {
        $generalRepairRegistration = $this->instantiate($registrationId);
        $customer = Customer::model()->findByPk($generalRepairRegistration->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($generalRepairRegistration->header->vehicle_id);
        $branches = Branch::model()->findAll(); 

        $qs = new QuickService('search');
        $qs->unsetAttributes();  // clear any default values
        if (isset($_GET['QuickService'])) {
            $qs->attributes = $_GET['QuickService'];
        }

        $qsCriteria = new CDbCriteria;
        $qsCriteria->compare('name', $qs->name, true);
        $qsCriteria->compare('code', $qs->code, true);
        $qsCriteria->compare('rate', $qs->rate, true);

        $qsDataProvider = new CActiveDataProvider('QuickService', array(
            'criteria' => $qsCriteria,
        ));
        
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }

        $serviceCriteria = new CDbCriteria;
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);
        $serviceCriteria->compare('t.service_category_id', $service->service_category_id);
        $serviceCriteria->compare('t.service_type_id', $service->service_type_id);
        $explodeKeyword = explode(" ", $service->findkeyword);
        
        foreach ($explodeKeyword as $key) {
            $serviceCriteria->compare('t.code', $key, true, 'OR');
            $serviceCriteria->compare('t.name', $key, true, 'OR');
            $serviceCriteria->compare('description', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        $serviceArray = array();
        
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productDataProvider = $product->search();

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('view', 'id' => $generalRepairRegistration->header->id));

//        if (isset($_POST['_FormSubmit_'])) {
            if (isset($_POST['Submit'])) {
                $this->loadStateDetails($generalRepairRegistration);

                if ($generalRepairRegistration->saveDetails(Yii::app()->db)) 
                    $this->redirect(array('view', 'id' => $generalRepairRegistration->header->id));
            }
//        }

        $this->render('addProductService', array(
            'generalRepairRegistration' => $generalRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'branches' => $branches,
        ));
    }

    public function actionUpdate($id)
    {
        $generalRepairRegistration = $this->instantiate($id);
        $generalRepairRegistration->header->setCodeNumberByRevision('transaction_number');
        $vehicle = Vehicle::model()->findByPk($generalRepairRegistration->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $type = "";
        
        $qs = new QuickService('search');
        $qs->unsetAttributes();  // clear any default values
        if (isset($_GET['QuickService'])) {
            $qs->attributes = $_GET['QuickService'];
        }
        $qsCriteria = new CDbCriteria;
        $qsCriteria->compare('name', $qs->name, true);
        $qsCriteria->compare('code', $qs->code, true);
        $qsCriteria->compare('rate', $qs->rate, true);

        $qsDataProvider = new CActiveDataProvider('QuickService', array(
            'criteria' => $qsCriteria,
        ));
        
        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }

        $serviceCriteria = new CDbCriteria;
        $serviceCriteria->together = 'true';
        $serviceCriteria->with = array('serviceCategory', 'serviceType');

        $serviceCriteria->compare('t.name', $service->name, true);
        $serviceCriteria->compare('t.code', $service->code, true);
        $explodeKeyword = explode(" ", $service->findkeyword);
        
        foreach ($explodeKeyword as $key) {
            $serviceCriteria->compare('t.code', $key, true, 'OR');
            $serviceCriteria->compare('t.name', $key, true, 'OR');
            $serviceCriteria->compare('description', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.name', $key, true, 'OR');
            $serviceCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $serviceDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $serviceCriteria,
        ));

        $serviceChecks = RegistrationService::model()->findAllByAttributes(array('service_id' => $id));
        $serviceArray = array();
        
        foreach ($serviceChecks as $key => $serviceCheck) {
            array_push($serviceArray, $serviceCheck->service_id);
        }

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->together = true;
        $productCriteria->with = array(
            'productMasterCategory',
            'productSubMasterCategory',
            'productSubCategory',
            'brand'
        );
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('productMasterCategory.name', $product->product_master_category_name, true);
        $productCriteria->compare('productSubMasterCategory.name', $product->product_sub_master_category_name, true);
        $productCriteria->compare('productSubCategory.name', $product->product_sub_category_name, true);
        $productCriteria->compare('brand.name', $product->product_brand_name, true);

        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($generalRepairRegistration);
            if ($generalRepairRegistration->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $generalRepairRegistration->header->id));
            }
        }
        
        $this->render('update', array(
            'generalRepairRegistration' => $generalRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'type' => $type,
        ));
    }

    public function actionView($id)
    {
        $memo = isset($_GET['Memo']) ? $_GET['Memo'] : '';
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $quickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $registrationMemos = RegistrationMemo::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        if (isset($_POST['SubmitMemo']) && !empty($_POST['Memo'])) {
            $registrationMemo = new RegistrationMemo();
            $registrationMemo->registration_transaction_id = $id;
            $registrationMemo->memo = $_POST['Memo'];
            $registrationMemo->date_time = date('Y-m-d H:i:s');
            $registrationMemo->user_id = Yii::app()->user->id;
            $registrationMemo->save();
        }
        
        $this->render('view', array(
            'model' => $this->loadModel($id),
            'quickServices' => $quickServices,
            'services' => $services,
            'products' => $products,
            'registrationMemos' => $registrationMemos,
            'memo' => $memo,
        ));
    }

    public function actionAdmin()
    {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        if (isset($_GET['RegistrationTransaction'])) 
            $model->attributes = $_GET['RegistrationTransaction'];
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addCondition("repair_type = 'GR'");
        $dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionGenerateInvoice($id)
    {
        $registration = RegistrationTransaction::model()->findByPK($id);
        $customer = Customer::model()->findByPk($registration->customer_id);
        $invoices = InvoiceHeader::model()->findAllByAttributes(array('registration_transaction_id' => $registration->id));
        $branch = Branch::model()->findByPk($registration->branch_id);
        
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $registration->transaction_number,
            'branch_id' => $registration->branch_id,
        ));

        foreach ($invoices as $invoice) {
            $invoice->status = "CANCELLED";
            $invoice->save(false);
        }
        
        $days = $duedate = $customer->tenor != "" ? date('Y-m-d', strtotime("+" . $customer->tenor . " days")) : date('Y-m-d', strtotime("+1 months"));
        $invoiceHeader = InvoiceHeader::model()->findAll();
        $count = count($invoiceHeader) + 1;
        
        $model = new InvoiceHeader();
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registration->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registration->transaction_date)), $registration->branch_id);
        $model->invoice_date = date('Y-m-d');
        $model->due_date = $duedate;
        $model->reference_type = 2;
        $model->registration_transaction_id = $id;
        $model->customer_id = $registration->customer_id;
        $model->vehicle_id = $registration->vehicle_id;
        $model->branch_id = $registration->branch_id == "" ? 1 : $registration->branch_id;
        $model->user_id = Yii::app()->user->getId();
        $model->status = "INVOICING";
        $model->total_product = $registration->total_product;
        $model->total_service = $registration->total_service;
        $model->total_quick_service = $registration->total_quickservice;
        $model->service_price = $registration->total_service_price;
        $model->product_price = $registration->total_product_price;
        $model->quick_service_price = $registration->total_quickservice_price;
        $model->total_price = $registration->grand_total;
        $model->payment_left = $registration->grand_total;
        $model->payment_amount = 0;
        $model->ppn_total = $registration->ppn_price;
        $model->pph_total = $registration->pph_price;
        $model->ppn = $registration->ppn;
        $model->pph = $registration->pph;
        
        if ($model->save(false)) {
            $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
            if (count($registrationProducts) != 0) {
                foreach ($registrationProducts as $registrationProduct) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->product_id = $registrationProduct->product_id;
                    $modelDetail->quantity = $registrationProduct->quantity;
                    $modelDetail->unit_price = $registrationProduct->sale_price;
                    $modelDetail->total_price = $registrationProduct->total_price;
                    $modelDetail->save(false);
                }
            } 
            
            $registrationServices = RegistrationService::model()->findAllByAttributes(array(
                'registration_transaction_id' => $id,
                'is_quick_service' => 0
            ));
            
            if (count($registrationServices) != 0) {
                foreach ($registrationServices as $registrationService) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->service_id = $registrationService->service_id;
                    $modelDetail->unit_price = $registrationService->price;
                    $modelDetail->total_price = $registrationService->total_price;
                    $modelDetail->save(false);
                }
            }
            
            $registrationQuickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
            if (count($registrationQuickServices) != 0) {
                foreach ($registrationQuickServices as $registrationQuickService) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->quick_service_id = $registrationQuickService->quick_service_id;
                    $modelDetail->unit_price = $registrationQuickService->price;
                    $modelDetail->total_price = $registrationQuickService->price;
                    $modelDetail->save(false);
                }
            }
            
            /*SAVE TO JOURNAL*/
            $jurnalUmumPiutang = new JurnalUmum;
            $jurnalUmumPiutang->kode_transaksi = $registration->transaction_number;
            $jurnalUmumPiutang->tanggal_transaksi = $registration->transaction_date;
            $jurnalUmumPiutang->coa_id = $registration->customer->coa_id;
            $jurnalUmumPiutang->branch_id = $registration->branch_id;
            $jurnalUmumPiutang->total = $registration->grand_total;
            $jurnalUmumPiutang->debet_kredit = 'D';
            $jurnalUmumPiutang->tanggal_posting = date('Y-m-d');
            $jurnalUmumPiutang->transaction_subject = $registration->customer->name;
            $jurnalUmumPiutang->is_coa_category = 0;
            $jurnalUmumPiutang->transaction_type = 'RG';
            $jurnalUmumPiutang->save();
            
            if (count($registrationProducts) > 0) {
                foreach ($registration->registrationProducts as $key => $rProduct) {

                    $coaMasterGroupHpp = Coa::model()->findByAttributes(array('code' => '520.00.000'));
                    $jurnalUmumMasterGroupHpp = new JurnalUmum;
                    $jurnalUmumMasterGroupHpp->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumMasterGroupHpp->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumMasterGroupHpp->coa_id = $coaMasterGroupHpp->id;
                    $jurnalUmumMasterGroupHpp->branch_id = $registration->branch_id;
                    $jurnalUmumMasterGroupHpp->total = $rProduct->quantity * $rProduct->hpp;
                    $jurnalUmumMasterGroupHpp->debet_kredit = 'D';
                    $jurnalUmumMasterGroupHpp->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterGroupHpp->transaction_subject = $registration->customer->name;
                    $jurnalUmumMasterGroupHpp->is_coa_category = 1;
                    $jurnalUmumMasterGroupHpp->transaction_type = 'RG';
                    $jurnalUmumMasterGroupHpp->save();

                    // save product master category coa hpp
                    $coaMasterHpp = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaHpp->id);
                    $getCoaMasterHpp = $coaMasterHpp->code;
                    $coaMasterHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterHpp));
                    $jurnalUmumMasterHpp = new JurnalUmum;
                    $jurnalUmumMasterHpp->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumMasterHpp->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumMasterHpp->coa_id = $coaMasterHppWithCode->id;
                    $jurnalUmumMasterHpp->branch_id = $registration->branch_id;
                    $jurnalUmumMasterHpp->total = $rProduct->quantity * $rProduct->hpp;
                    $jurnalUmumMasterHpp->debet_kredit = 'D';
                    $jurnalUmumMasterHpp->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterHpp->transaction_subject = $registration->customer->name;
                    $jurnalUmumMasterHpp->is_coa_category = 1;
                    $jurnalUmumMasterHpp->transaction_type = 'RG';
                    $jurnalUmumMasterHpp->save();

                    // save product sub master category coa hpp
                    $coaHpp = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaHpp->id);
                    $getCoaHpp = $coaHpp->code;
                    $coaHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHpp));
                    $jurnalUmumHpp = new JurnalUmum;
                    $jurnalUmumHpp->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumHpp->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumHpp->coa_id = $coaHppWithCode->id;
                    $jurnalUmumHpp->branch_id = $registration->branch_id;
                    $jurnalUmumHpp->total = $rProduct->quantity * $rProduct->hpp;
                    $jurnalUmumHpp->debet_kredit = 'D';
                    $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
                    $jurnalUmumHpp->transaction_subject = $registration->customer->name;
                    $jurnalUmumHpp->is_coa_category = 0;
                    $jurnalUmumHpp->transaction_type = 'RG';
                    $jurnalUmumHpp->save();

                    if ($rProduct->discount > 0) {
                        $coaMasterGroupDiskon = Coa::model()->findByAttributes(array('code' => '412.00.000'));
                        $jurnalUmumMasterGroupDiskon = new JurnalUmum;
                        $jurnalUmumMasterGroupDiskon->kode_transaksi = $registration->transaction_number;
                        $jurnalUmumMasterGroupDiskon->tanggal_transaksi = $registration->transaction_date;
                        $jurnalUmumMasterGroupDiskon->coa_id = $coaMasterGroupDiskon->id;
                        $jurnalUmumMasterGroupDiskon->branch_id = $registration->branch_id;
                        $jurnalUmumMasterGroupDiskon->total = $rProduct->discount;
                        $jurnalUmumMasterGroupDiskon->debet_kredit = 'D';
                        $jurnalUmumMasterGroupDiskon->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterGroupDiskon->transaction_subject = $registration->customer->name;
                        $jurnalUmumMasterGroupDiskon->is_coa_category = 1;
                        $jurnalUmumMasterGroupDiskon->transaction_type = 'RG';
                        $jurnalUmumMasterGroupDiskon->save();

                        // save product master coa diskon penjualan
                        $coaMasterDiskon = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaDiskonPenjualan->id);
                        $getCoaMasterDiskon = $coaMasterDiskon->code;
                        $coaMasterDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterDiskon));
                        $jurnalUmumMasterDiskon = new JurnalUmum;
                        $jurnalUmumMasterDiskon->kode_transaksi = $registration->transaction_number;
                        $jurnalUmumMasterDiskon->tanggal_transaksi = $registration->transaction_date;
                        $jurnalUmumMasterDiskon->coa_id = $coaMasterDiskonWithCode->id;
                        $jurnalUmumMasterDiskon->branch_id = $registration->branch_id;
                        $jurnalUmumMasterDiskon->total = $rProduct->discount;
                        $jurnalUmumMasterDiskon->debet_kredit = 'D';
                        $jurnalUmumMasterDiskon->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterDiskon->transaction_subject = $registration->customer->name;
                        $jurnalUmumMasterDiskon->is_coa_category = 1;
                        $jurnalUmumMasterDiskon->transaction_type = 'RG';
                        $jurnalUmumMasterDiskon->save();

                        // save product sub master coa diskon penjualan
                        $coaDiskon = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaDiskonPenjualan->id);
                        $getCoaDiskon = $coaDiskon->code;
                        $coaDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaDiskon));
                        $jurnalUmumDiskon = new JurnalUmum;
                        $jurnalUmumDiskon->kode_transaksi = $registration->transaction_number;
                        $jurnalUmumDiskon->tanggal_transaksi = $registration->transaction_date;
                        $jurnalUmumDiskon->coa_id = $coaDiskonWithCode->id;
                        $jurnalUmumDiskon->branch_id = $registration->branch_id;
                        $jurnalUmumDiskon->total = $rProduct->discount;
                        $jurnalUmumDiskon->debet_kredit = 'D';
                        $jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
                        $jurnalUmumDiskon->transaction_subject = $registration->customer->name;
                        $jurnalUmumDiskon->is_coa_category = 0;
                        $jurnalUmumDiskon->transaction_type = 'RG';
                        $jurnalUmumDiskon->save();
                    }

                    //save product master category coa penjualan barang
                    $coaMasterGroupPenjualan = Coa::model()->findByAttributes(array('code' => '411.00.000'));
                    $jurnalUmumGroupPenjualan = new JurnalUmum;
                    $jurnalUmumGroupPenjualan->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumGroupPenjualan->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumGroupPenjualan->coa_id = $coaMasterGroupPenjualan->id;
                    $jurnalUmumGroupPenjualan->branch_id = $registration->branch_id;
                    $jurnalUmumGroupPenjualan->total = $rProduct->total_price;
                    $jurnalUmumGroupPenjualan->debet_kredit = 'K';
                    $jurnalUmumGroupPenjualan->tanggal_posting = date('Y-m-d');
                    $jurnalUmumGroupPenjualan->transaction_subject = $registration->customer->name;
                    $jurnalUmumGroupPenjualan->is_coa_category = 1;
                    $jurnalUmumGroupPenjualan->transaction_type = 'RG';
                    $jurnalUmumGroupPenjualan->save();

                    //save product master category coa penjualan barang
                    $coaMasterPenjualan = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaPenjualanBarangDagang->id);
                    $getCoaMasterPenjualan = $coaMasterPenjualan->code;
                    $coaMasterPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterPenjualan));
                    $jurnalUmumMasterPenjualan = new JurnalUmum;
                    $jurnalUmumMasterPenjualan->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumMasterPenjualan->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumMasterPenjualan->coa_id = $coaMasterPenjualanWithCode->id;
                    $jurnalUmumMasterPenjualan->branch_id = $registration->branch_id;
                    $jurnalUmumMasterPenjualan->total = $rProduct->total_price;
                    $jurnalUmumMasterPenjualan->debet_kredit = 'K';
                    $jurnalUmumMasterPenjualan->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterPenjualan->transaction_subject = $registration->customer->name;
                    $jurnalUmumMasterPenjualan->is_coa_category = 1;
                    $jurnalUmumMasterPenjualan->transaction_type = 'RG';
                    $jurnalUmumMasterPenjualan->save();

                    //save product sub master category coa penjualan barang
                    $coaPenjualan = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaPenjualanBarangDagang->id);
                    $getCoaPenjualan = $coaPenjualan->code;
                    $coaPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPenjualan));
                    $jurnalUmumPenjualan = new JurnalUmum;
                    $jurnalUmumPenjualan->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumPenjualan->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumPenjualan->coa_id = $coaPenjualanWithCode->id;
                    $jurnalUmumPenjualan->branch_id = $registration->branch_id;
                    $jurnalUmumPenjualan->total = $rProduct->total_price;
                    $jurnalUmumPenjualan->debet_kredit = 'K';
                    $jurnalUmumPenjualan->tanggal_posting = date('Y-m-d');
                    $jurnalUmumPenjualan->transaction_subject = $registration->customer->name;
                    $jurnalUmumPenjualan->is_coa_category = 0;
                    $jurnalUmumPenjualan->transaction_type = 'RG';
                    $jurnalUmumPenjualan->save();

                    $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '105.00.000'));
                    $jurnalUmumMasterGroupInventory = new JurnalUmum;
                    $jurnalUmumMasterGroupInventory->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumMasterGroupInventory->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumMasterGroupInventory->coa_id = $coaMasterGroupInventory->id;
                    $jurnalUmumMasterGroupInventory->branch_id = $registration->branch_id;
                    $jurnalUmumMasterGroupInventory->total = $rProduct->quantity * $rProduct->hpp;
                    $jurnalUmumMasterGroupInventory->debet_kredit = 'K';
                    $jurnalUmumMasterGroupInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterGroupInventory->transaction_subject = $registration->customer->name;
                    $jurnalUmumMasterGroupInventory->is_coa_category = 1;
                    $jurnalUmumMasterGroupInventory->transaction_type = 'RG';
                    $jurnalUmumMasterGroupInventory->save();

                    //save product master coa inventory
                    $coaMasterInventory = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaInventoryInTransit->id);
                    $getCoaMasterInventory = $coaMasterInventory->code;
                    $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
                    $jurnalUmumMasterInventory = new JurnalUmum;
                    $jurnalUmumMasterInventory->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumMasterInventory->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumMasterInventory->coa_id = $coaMasterInventoryWithCode->id;
                    $jurnalUmumMasterInventory->branch_id = $registration->branch_id;
                    $jurnalUmumMasterInventory->total = $rProduct->quantity * $rProduct->hpp;
                    $jurnalUmumMasterInventory->debet_kredit = 'K';
                    $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterInventory->transaction_subject = $registration->customer->name;
                    $jurnalUmumMasterInventory->is_coa_category = 1;
                    $jurnalUmumMasterInventory->transaction_type = 'RG';
                    $jurnalUmumMasterInventory->save();

                    //save product sub master coa inventory
                    $coaInventory = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaInventoryInTransit->id);
                    $getCoaInventory = $coaInventory->code;
                    $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                    $jurnalUmumInventory = new JurnalUmum;
                    $jurnalUmumInventory->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumInventory->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
                    $jurnalUmumInventory->branch_id = $registration->branch_id;
                    $jurnalUmumInventory->total = $rProduct->quantity * $rProduct->hpp;
                    $jurnalUmumInventory->debet_kredit = 'K';
                    $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInventory->transaction_subject = $registration->customer->name;
                    $jurnalUmumInventory->is_coa_category = 0;
                    $jurnalUmumInventory->transaction_type = 'RG';
                    $jurnalUmumInventory->save();
                }
            }

            if (count($registrationServices) > 0) {
                foreach ($registration->registrationServices as $key => $rService) {
                    $price = $rService->is_quick_service == 1 ? $rService->price : $rService->total_price;

                    // save service type coa
                    $coaMasterGroupPendapatanJasa = Coa::model()->findByAttributes(array('code' => '401.00.000'));
                    $jurnalUmumKategoriPendapatanJasa = new JurnalUmum;
                    $jurnalUmumKategoriPendapatanJasa->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumKategoriPendapatanJasa->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumKategoriPendapatanJasa->coa_id = $coaMasterGroupPendapatanJasa->id;
                    $jurnalUmumKategoriPendapatanJasa->branch_id = $registration->branch_id;
                    $jurnalUmumKategoriPendapatanJasa->total = $price;
                    $jurnalUmumKategoriPendapatanJasa->debet_kredit = 'K';
                    $jurnalUmumKategoriPendapatanJasa->tanggal_posting = date('Y-m-d');
                    $jurnalUmumKategoriPendapatanJasa->transaction_subject = $registration->customer->name;
                    $jurnalUmumKategoriPendapatanJasa->is_coa_category = 1;
                    $jurnalUmumKategoriPendapatanJasa->transaction_type = 'RG';
                    $jurnalUmumKategoriPendapatanJasa->save();

                    // save service type coa
                    $coaGroupPendapatanJasa = Coa::model()->findByPk($rService->service->serviceType->coa_id);
                    $getCoaGroupPendapatanJasa = $coaGroupPendapatanJasa->code;
                    $coaGroupPendapatanJasaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaGroupPendapatanJasa));
                    $jurnalUmumGroupPendapatanJasa = new JurnalUmum;
                    $jurnalUmumGroupPendapatanJasa->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumGroupPendapatanJasa->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumGroupPendapatanJasa->coa_id = $coaGroupPendapatanJasaWithCode->id;
                    $jurnalUmumGroupPendapatanJasa->branch_id = $registration->branch_id;
                    $jurnalUmumGroupPendapatanJasa->total = $price;
                    $jurnalUmumGroupPendapatanJasa->debet_kredit = 'K';
                    $jurnalUmumGroupPendapatanJasa->tanggal_posting = date('Y-m-d');
                    $jurnalUmumGroupPendapatanJasa->transaction_subject = $registration->customer->name;
                    $jurnalUmumGroupPendapatanJasa->is_coa_category = 1;
                    $jurnalUmumGroupPendapatanJasa->transaction_type = 'RG';
                    $jurnalUmumGroupPendapatanJasa->save();

                    //save service category coa
                    $coaPendapatanJasa = Coa::model()->findByPk($rService->service->serviceCategory->coa_id);
                    $getCoaPendapatanJasa = $coaPendapatanJasa->code;
                    $coaPendapatanJasaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPendapatanJasa));
                    $jurnalUmumPendapatanJasa = new JurnalUmum;
                    $jurnalUmumPendapatanJasa->kode_transaksi = $registration->transaction_number;
                    $jurnalUmumPendapatanJasa->tanggal_transaksi = $registration->transaction_date;
                    $jurnalUmumPendapatanJasa->coa_id = $coaPendapatanJasaWithCode->id;
                    $jurnalUmumPendapatanJasa->branch_id = $registration->branch_id;
                    $jurnalUmumPendapatanJasa->total = $price;
                    $jurnalUmumPendapatanJasa->debet_kredit = 'K';
                    $jurnalUmumPendapatanJasa->tanggal_posting = date('Y-m-d');
                    $jurnalUmumPendapatanJasa->transaction_subject = $registration->customer->name;
                    $jurnalUmumPendapatanJasa->is_coa_category = 0;
                    $jurnalUmumPendapatanJasa->transaction_type = 'RG';
                    $jurnalUmumPendapatanJasa->save();
                }
            }
        }// end if model save
        
        if (count($invoices) > 0) {
            $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                'registration_transaction_id' => $registration->id,
                'name' => 'Invoice'
            ));
            if (count($real) != 0) {
                $real->checked_date = date('Y-m-d');
                $real->detail = 'ReGenerate Invoice with number #' . $model->invoice_number;
                $real->save(false);
            } else {
                $real = new RegistrationRealizationProcess();
                $real->registration_transaction_id = $registration->id;
                $real->name = 'Invoice';
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Generate Invoice with number #' . $model->invoice_number;
                $real->save();
            }

        } else {
            $real = new RegistrationRealizationProcess();
            $real->registration_transaction_id = $registration->id;
            $real->name = 'Invoice';
            $real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = Yii::app()->user->getId();
            $real->detail = 'Generate Invoice with number #' . $model->invoice_number;
            $real->save();
        }
    }

    public function actionGenerateSalesOrder($id)
    {
        $model = $this->instantiate($id);
        
        $model->generateCodeNumberSaleOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        $model->header->sales_order_date = date('Y-m-d');

        if ($model->save(Yii::app()->db)) {

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

    public function actionGenerateWorkOrder($id)
    {
        $model = $this->instantiate($id);

        $model->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        $model->header->work_order_date = date('Y-m-d');
        $model->header->status = 'Processing';

        if ($model->save(Yii::app()->db)) {
//            if ($model->header->repair_type == 'BR') {
//                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
//                    'registration_transaction_id' => $id,
//                    'name' => 'Work Order'
//                ));
//                $real->checked = 1;
//                $real->checked_date = date('Y-m-d');
//                $real->checked_by = 1;
//                $real->detail = 'Update When Generate Work Order. WorkOrder#' . $model->header->work_order_number;
//                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
//            } else {
                $real = new RegistrationRealizationProcess();
                $real->registration_transaction_id = $model->header->id;
                $real->name = 'Work Order';
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $model->header->work_order_number;
                $real->save();
//            }
            
            $this->redirect(array('view', 'id' => $id));
        }
    }

    public function actionShowRealization($id)
    {
        $head = RegistrationTransaction::model()->findByPk($id);
        $reals = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $this->render('realization', array(
            'head' => $head,
            'reals' => $reals,
        ));
    }

    public function actionReceive($movementOutDetailId, $registrationProductId, $quantity)
    {
        //$quantity = 0;

        $registrationProduct = RegistrationProduct::model()->findByPk($registrationProductId);
        $registration = RegistrationTransaction::model()->findByPk($registrationProduct->registration_transaction_id);
        $movementOutDetail = MovementOutDetail::model()->findByPk($movementOutDetailId);
        $movementOut = MovementOutHeader::model()->findByPk($movementOutDetail->movement_out_header_id);

        $receiveHeader = new TransactionReceiveItem();
        $receiveHeader->receive_item_no = 'RI_' . $registration->id . mt_rand();
        $receiveHeader->receive_item_date = date('Y-m-d');
        $receiveHeader->arrival_date = date('Y-m-d');
        $receiveHeader->recipient_id = Yii::app()->user->getId();
        $receiveHeader->recipient_branch_id = $registration->branch_id;
        $receiveHeader->request_type = 'Retail Sales';
        $receiveHeader->request_date = $movementOut->date_posting;
        $receiveHeader->destination_branch = $registration->branch_id;
        $receiveHeader->movement_out_id = $movementOut->id;
        if ($receiveHeader->save(false)) {
            $receiveDetail = new TransactionReceiveItemDetail();
            $receiveDetail->receive_item_id = $receiveHeader->id;
            $receiveDetail->movement_out_detail_id = $movementOutDetail->id;
            $receiveDetail->product_id = $registrationProduct->product_id;
            $receiveDetail->qty_request = $registrationProduct->quantity;
            $receiveDetail->qty_received = $quantity;
            if ($receiveDetail->save(false)) {

                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('receiveItem');
                $criteria->condition = "receiveItem.movement_out_id =" . $movementOut->id . " AND receive_item_id != " . $receiveHeader->id;
                $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);

                $quantity = 0;
                
                foreach ($receiveItemDetails as $receiveItemDetail) {
                    $quantity += $receiveItemDetail->qty_received;
                }

                $moveOutDetail = MovementOutDetail::model()->findByAttributes(array(
                    'id' => $movementOutDetailId,
                    'movement_out_header_id' => $movementOut->id
                ));

                $moveOutDetail->quantity_receive_left = $moveOutDetail->quantity - ($receiveDetail->qty_received + $quantity);
                $moveOutDetail->quantity_receive = $quantity + $receiveDetail->qty_received;

                if ($moveOutDetail->save(false)) {
                    $mcriteria = new CDbCriteria;
                    $mcriteria->together = 'true';
                    $mcriteria->with = array('movementOutHeader');
                    $mcriteria->condition = "movementOutHeader.registration_transaction_id =" . $registration->id . " AND movement_out_header_id != " . $movementOut->id;
                    $moDetails = MovementOutDetail::model()->findAll($mcriteria);

                    $mquantity = 0;
                    foreach ($moDetails as $moDetail) {
                        $mquantity += $moDetail->quantity_receive;
                    }

                    $rpDetail = RegistrationProduct::model()->findByAttributes(array(
                        'id' => $registrationProductId,
                        'registration_transaction_id' => $registration->id
                    ));

                    $rpDetail->quantity_receive_left = $rpDetail->quantity - ($movementOutDetail->quantity_receive + $mquantity);
                    $rpDetail->quantity_receive = $mquantity + $movementOutDetail->quantity_receive;
                    
                    if ($rpDetail->save(false)) {
                        $registrationRealization = new RegistrationRealizationProcess();
                        $registrationRealization->registration_transaction_id = $registration->id;
                        $registrationRealization->name = 'Receive Item';
                        $registrationRealization->checked = 1;
                        $registrationRealization->checked_by = Yii::app()->user->id;
                        $registrationRealization->checked_date = date('Y-m-d');
                        $registrationRealization->detail = 'Receive Item for Product : ' . $registrationProduct->product->name . ' from Movement Out #: ' . $movementOut->movement_out_no . ' Quantity : ' . $quantity;
                        $registrationRealization->save();
                    }
                }
            }
        }
    }

    public function actionPdf($id)
    {
        $generalRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($generalRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($generalRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($generalRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'generalRepairRegistration' => $generalRepairRegistration,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output();
    }

    public function actionPdfSaleOrder($id)
    {
        $generalRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($generalRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($generalRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($generalRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfSaleOrder', array(
            'generalRepairRegistration' => $generalRepairRegistration,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output();
    }

    public function actionPdfWorkOrder($id)
    {
        $generalRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($generalRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($generalRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($generalRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfWorkOrder', array(
            'generalRepairRegistration' => $generalRepairRegistration,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output();
    }

    //Add QuickService
    public function actionAjaxHtmlAddQuickServiceDetail($id, $quickServiceId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);

            $generalRepairRegistration->addQuickServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailQuickService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddQsServiceDetail($id, $quickServiceId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiateProductService($id);
            $this->loadState($generalRepairRegistration);

            $generalRepairRegistration->addQsServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailService', array('registrationTransaction' => $generalRepairRegistration), false,
                true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveQuickServiceDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiate($id);
            $this->loadState($generalRepairRegistration);
            
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeQuickServiceDetailAt($index);
            
            $this->renderPartial('_detailQuickService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveQuickServiceDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiateProductService($id);
            $this->loadState($generalRepairRegistration);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeQuickServiceAll();
            
            $this->renderPartial('_detailQuickService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

//Add Service
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);

            $generalRepairRegistration->addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair);
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiate($id);
            $this->loadState($generalRepairRegistration);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeServiceDetailAt($index);
            
            $this->renderPartial('_detailService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiate($id);
            $this->loadState($generalRepairRegistration);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeServiceDetailAll();
            
            $this->renderPartial('_detailService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

//Add Product
    public function actionAjaxHtmlAddProductDetail($id, $productId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);
            $branches = Branch::model()->findAll(); 

            $generalRepairRegistration->addProductDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailProduct', array(
                'generalRepairRegistration' => $generalRepairRegistration,
                'branches' => $branches,
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveProductDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiate($id);
            $this->loadState($generalRepairRegistration);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeProductDetailAt($index);
            
            $this->renderPartial('_detailProduct', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

	public function actionAjaxJsonTotalService($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$generalRepairRegistration = $this->instantiate($id);
			$this->loadStateDetails($generalRepairRegistration);

			$totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($generalRepairRegistration->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepairRegistration->totalQuantityService));
			$subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalService));
			$totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->totalDiscountService));
			$grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalService));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxItemAmount));
			$taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxServiceAmount));
			$grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalTransaction));

			echo CJSON::encode(array(
				'totalAmount' => $totalAmount,
                'totalQuantityService' => $totalQuantityService,
				'subTotalService' => $subTotalService,
				'totalDiscountService' => $totalDiscountService,
				'grandTotalService'=>$grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'taxServiceAmount' => $taxServiceAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
			));
		}
	}

	public function actionAjaxJsonTotalProduct($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$generalRepairRegistration = $this->instantiate($id);
			$this->loadStateDetails($generalRepairRegistration);

			$totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($generalRepairRegistration->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepairRegistration->totalQuantityProduct));
			$subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalProduct));
			$totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->totalDiscountProduct));
			$grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalProduct));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxItemAmount));
			$taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxServiceAmount));
			$grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalTransaction));

			echo CJSON::encode(array(
				'totalAmountProduct' => $totalAmountProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
				'subTotalProduct' => $subTotalProduct,
				'totalDiscountProduct' => $totalDiscountProduct,
				'grandTotalProduct'=>$grandTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'taxServiceAmount' => $taxServiceAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
			));
		}
	}

	public function actionAjaxJsonGrandTotal($id)
	{
		if (Yii::app()->request->isAjaxRequest) {
			$generalRepairRegistration = $this->instantiate($id);
			$this->loadStateDetails($generalRepairRegistration);

			$totalQuickServiceQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->totalQuickServiceQuantity));
			$subTotalQuickService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalQuickService));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepairRegistration->totalQuantityService));
			$subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalService));
			$totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->totalDiscountService));
			$grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalService));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxItemAmount));
            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxServiceAmount));
			$grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalTransaction));

			echo CJSON::encode(array(
                'totalQuickServiceQuantity' => $totalQuickServiceQuantity,
                'subTotalQuickService' => $subTotalQuickService,
                'totalQuantityService' => $totalQuantityService,
				'subTotalService' => $subTotalService,
				'totalDiscountService' => $totalDiscountService,
				'grandTotalService'=>$grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
				'taxItemAmount' => $taxItemAmount,
				'taxServiceAmount' => $taxServiceAmount,
				'grandTotal' => $grandTotal,
			));
		}
	}

    public function actionAjaxShowPricelist($index, $serviceId, $customerId, $vehicleId, $insuranceId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_price-dialog', array(
                'index' => $index,
                'customer' => $customerId,
                'service' => $serviceId,
                'vehicle' => $vehicleId,
                'insurance' => $insuranceId
            ), false, true);
        }
    }

	public function actionAjaxHtmlUpdateProductSubBrandSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateProductSubMasterCategorySelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }
    
	public function actionAjaxHtmlUpdateProductSubCategorySelect()
	{
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }
    
    public function instantiate($id)
    {
        if (empty($id)) {
            $generalRepairRegistration = new GeneralRepairRegistration(new RegistrationTransaction(), array(), array(), array());
        } else {
            $generalRepairRegistrationModel = $this->loadModel($id);
            $generalRepairRegistration = new GeneralRepairRegistration($generalRepairRegistrationModel,
                $generalRepairRegistrationModel->registrationQuickServices,
                $generalRepairRegistrationModel->registrationServices,
                $generalRepairRegistrationModel->registrationProducts
            );
        }
        return $generalRepairRegistration;
    }

    public function loadState($generalRepairRegistration)
    {
        if (isset($_POST['RegistrationTransaction'])) {
            $generalRepairRegistration->header->attributes = $_POST['RegistrationTransaction'];
        }
    }

    public function loadStateDetails($generalRepairRegistration)
    {
        if (isset($_POST['RegistrationTransaction'])) {
            $generalRepairRegistration->header->attributes = $_POST['RegistrationTransaction'];
        }
        
        if (isset($_POST['RegistrationQuickService'])) {
            foreach ($_POST['RegistrationQuickService'] as $i => $item) {
                if (isset($generalRepairRegistration->quickServiceDetails[$i])) {
                    $generalRepairRegistration->quickServiceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationQuickService();
                    $detail->attributes = $item;
                    $generalRepairRegistration->quickServiceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationQuickService']) < count($generalRepairRegistration->quickServiceDetails)) {
                array_splice($generalRepairRegistration->quickServiceDetails, $i + 1);
            }
        } else {
            $generalRepairRegistration->quickServiceDetails = array();
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($generalRepairRegistration->serviceDetails[$i])) {
                    $generalRepairRegistration->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $generalRepairRegistration->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($generalRepairRegistration->serviceDetails)) {
                array_splice($generalRepairRegistration->serviceDetails, $i + 1);
            }
        } else {
            $generalRepairRegistration->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($generalRepairRegistration->productDetails[$i])) {
                    $generalRepairRegistration->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $generalRepairRegistration->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($generalRepairRegistration->productDetails)) {
                array_splice($generalRepairRegistration->productDetails, $i + 1);
            }
        } else {
            $generalRepairRegistration->productDetails = array();
        }
    }

    public function instantiateRegistrationService($id)
    {
        if (empty($id)) {
            $registrationService = new RegistrationServices(new RegistrationService(), array(), array());
            //print_r("test");
        } else {
            //$registrationServiceModel = $this->loadModel($id);
            $registrationServiceModel = RegistrationService::model()->findByAttributes(array('id' => $id));
            $registrationService = new RegistrationServices($registrationServiceModel,
                $registrationServiceModel->registrationServiceEmployees,
                $registrationServiceModel->registrationServiceSupervisors);
        }
        return $registrationService;
    }

    public function loadStateRegistrationService($registrationService)
    {
        if (isset($_POST['RegistrationService'])) {
            $registrationService->header->attributes = $_POST['RegistrationService'];
        }
        if (isset($_POST['RegistrationServiceEmployee'])) {
            foreach ($_POST['RegistrationServiceEmployee'] as $i => $item) {
                if (isset($registrationService->employeeDetails[$i])) {
                    $registrationService->employeeDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationServiceEmployee();
                    $detail->attributes = $item;
                    $registrationService->employeeDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationServiceEmployee']) < count($registrationService->employeeDetails)) {
                array_splice($registrationService->employeeDetails, $i + 1);
            }
        } else {
            $registrationService->employeeDetails = array();
        }

        if (isset($_POST['RegistrationServiceSupervisor'])) {
            foreach ($_POST['RegistrationServiceSupervisor'] as $i => $item) {
                if (isset($registrationService->supervisorDetails[$i])) {
                    $registrationService->supervisorDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationServiceSupervisor();
                    $detail->attributes = $item;
                    $registrationService->supervisorDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationServiceSupervisor']) < count($registrationService->supervisorDetails)) {
                array_splice($registrationService->supervisorDetails, $i + 1);
            }
        } else {
            $registrationService->supervisorDetails = array();
        }
    }

    public function loadModel($id)
    {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) 
            throw new CHttpException(404, 'The requested page does not exist.');
        
        return $model;
    }
}