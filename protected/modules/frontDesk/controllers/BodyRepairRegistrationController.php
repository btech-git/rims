<?php

class BodyRepairRegistrationController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
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

    public function actionCreate($vehicleId) {
        $bodyRepairRegistration = $this->instantiate(null);
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        
        $bodyRepairRegistration->header->transaction_date = date('Y-m-d H:i:s');
        $bodyRepairRegistration->header->work_order_time = date('H:i:s');
        $bodyRepairRegistration->header->user_id = Yii::app()->user->id;
        $bodyRepairRegistration->header->vehicle_id = $vehicleId;
        $bodyRepairRegistration->header->customer_id = $vehicle->customer_id;
        $bodyRepairRegistration->header->branch_id = $bodyRepairRegistration->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $bodyRepairRegistration->header->branch_id;

        if (isset($_POST['Submit'])) {
            $this->loadState($bodyRepairRegistration);
            $bodyRepairRegistration->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($bodyRepairRegistration->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($bodyRepairRegistration->header->transaction_date)), $bodyRepairRegistration->header->branch_id);

            if ($bodyRepairRegistration->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $bodyRepairRegistration->header->id));
            }
        }

        $this->render('create', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionInsuranceAddition($id)
    {
        $registrationInsuranceData = new RegistrationInsuranceData();
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);
        $vehicle = Vehicle::model()->findByPk($registrationTransaction->vehicle_id);
        $customer = Customer::model()->findByPk($registrationTransaction->customer_id);
        $insuranceCompany = InsuranceCompany::model()->findByPk($registrationTransaction->insurance_company_id);
        $registrationInsuranceData->registration_transaction_id = $id;
        $registrationInsuranceData->insurance_company_id = $registrationTransaction->insurance_company_id;
        
        if (isset($_POST['Cancel'])) 
            $this->redirect(array('view', 'id' => $id));

        if (isset($_POST['_FormSubmit_'])) {
            if ($_POST['_FormSubmit_'] === 'Submit') {
                if (isset($_POST['RegistrationInsuranceData'])) 
                    $registrationInsuranceData->attributes = $_POST['RegistrationInsuranceData'];

                if ($registrationInsuranceData->save(Yii::app()->db)) 
                    $this->redirect(array('view', 'id' => $id));
            }
        } 

        $this->render('insuranceAddition', array(
            'registrationInsuranceData' => $registrationInsuranceData,
            'registrationTransaction' => $registrationTransaction,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'insuranceCompany' => $insuranceCompany,
        ));
    }
    
    public function actionAddProductService($registrationId) {
        $bodyRepairRegistration = $this->instantiate($registrationId);
        $customer = Customer::model()->findByPk($bodyRepairRegistration->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->header->vehicle_id);
        $branches = Branch::model()->findAll(); 
        $bodyRepairRegistration->header->pph = 1;

        $damage = new Service('search');
        $damage->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $damage->attributes = $_GET['Service'];
        }

        $damageCriteria = new CDbCriteria;
        $damageCriteria->together = 'true';
        $damageCriteria->with = array('serviceCategory', 'serviceType');

        $damageCriteria->compare('t.name', $damage->name, true);
        $damageCriteria->compare('t.code', $damage->code, true);
        $damageCriteria->compare('t.service_category_id', $damage->service_category_id);
        $damageCriteria->compare('t.service_type_id', 2);
        $explodeKeyword = explode(" ", $damage->findkeyword);
        
        foreach ($explodeKeyword as $key) {
            $damageCriteria->compare('t.code', $key, true, 'OR');
            $damageCriteria->compare('t.name', $key, true, 'OR');
            $damageCriteria->compare('description', $key, true, 'OR');
            $damageCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $damageCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $damageCriteria->compare('serviceType.name', $key, true, 'OR');
            $damageCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $damageDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $damageCriteria,
        ));

        $damageArray = array();
        
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
        $serviceCriteria->compare('t.service_type_id', 2);
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
            $this->redirect(array('view', 'id' => $bodyRepairRegistration->header->id));

        //if (isset($_POST['_FormSubmit_'])) {
            if (isset($_POST['Submit'])) {
                $this->loadStateDetails($bodyRepairRegistration);

        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $bodyRepairRegistration->header->transaction_number,
//            'branch_id' => $bodyRepairRegistration->header->branch_id,
        ));
        
        $jurnalUmumReceivable = new JurnalUmum;
        $jurnalUmumReceivable->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
        $jurnalUmumReceivable->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
        $jurnalUmumReceivable->coa_id = (empty($bodyRepairRegistration->header->insurance_company_id)) ? $bodyRepairRegistration->header->customer->coa_id : $bodyRepairRegistration->header->insuranceCompany->coa_id;
        $jurnalUmumReceivable->branch_id = $bodyRepairRegistration->header->branch_id;
        $jurnalUmumReceivable->total = $bodyRepairRegistration->header->grand_total;
        $jurnalUmumReceivable->debet_kredit = 'D';
        $jurnalUmumReceivable->tanggal_posting = date('Y-m-d');
        $jurnalUmumReceivable->transaction_subject = $bodyRepairRegistration->header->customer->name;
        $jurnalUmumReceivable->is_coa_category = 0;
        $jurnalUmumReceivable->transaction_type = 'RG';
        $jurnalUmumReceivable->save();

        if ($bodyRepairRegistration->header->ppn_price > 0.00) {
            $coaPpn = Coa::model()->findByAttributes(array('code' => '224.00.001'));
            $jurnalUmumPpn = new JurnalUmum;
            $jurnalUmumPpn->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
            $jurnalUmumPpn->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
            $jurnalUmumPpn->coa_id = $coaPpn->id;
            $jurnalUmumPpn->branch_id = $bodyRepairRegistration->header->branch_id;
            $jurnalUmumPpn->total = $bodyRepairRegistration->header->ppn_price;
            $jurnalUmumPpn->debet_kredit = 'K';
            $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
            $jurnalUmumPpn->transaction_subject = $bodyRepairRegistration->header->customer->name;
            $jurnalUmumPpn->is_coa_category = 0;
            $jurnalUmumPpn->transaction_type = 'RG';
            $jurnalUmumPpn->save();
        }

        if (count($bodyRepairRegistration->productDetails) > 0) {
            foreach ($bodyRepairRegistration->productDetails as $key => $rProduct) {
                // save product master category coa hpp
                $coaMasterHpp = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaHpp->id);
                $getCoaMasterHpp = $coaMasterHpp->code;
                $coaMasterHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterHpp));
                $jurnalUmumMasterHpp = new JurnalUmum;
                $jurnalUmumMasterHpp->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumMasterHpp->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumMasterHpp->coa_id = $coaMasterHppWithCode->id;
                $jurnalUmumMasterHpp->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumMasterHpp->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumMasterHpp->debet_kredit = 'D';
                $jurnalUmumMasterHpp->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterHpp->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumMasterHpp->is_coa_category = 1;
                $jurnalUmumMasterHpp->transaction_type = 'RG';
                $jurnalUmumMasterHpp->save();

                // save product sub master category coa hpp
                $coaHpp = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaHpp->id);
                $getCoaHpp = $coaHpp->code;
                $coaHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHpp));
                $jurnalUmumHpp = new JurnalUmum;
                $jurnalUmumHpp->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumHpp->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumHpp->coa_id = $coaHppWithCode->id;
                $jurnalUmumHpp->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumHpp->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumHpp->debet_kredit = 'D';
                $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
                $jurnalUmumHpp->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumHpp->is_coa_category = 0;
                $jurnalUmumHpp->transaction_type = 'RG';
                $jurnalUmumHpp->save();

                if ($rProduct->discount > 0) {
                    // save product master coa diskon penjualan
                    $coaMasterDiskon = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaDiskonPenjualan->id);
                    $getCoaMasterDiskon = $coaMasterDiskon->code;
                    $coaMasterDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterDiskon));
                    $jurnalUmumMasterDiskon = new JurnalUmum;
                    $jurnalUmumMasterDiskon->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                    $jurnalUmumMasterDiskon->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                    $jurnalUmumMasterDiskon->coa_id = $coaMasterDiskonWithCode->id;
                    $jurnalUmumMasterDiskon->branch_id = $bodyRepairRegistration->header->branch_id;
                    $jurnalUmumMasterDiskon->total = $rProduct->getDiscountAmount();
                    $jurnalUmumMasterDiskon->debet_kredit = 'D';
                    $jurnalUmumMasterDiskon->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterDiskon->transaction_subject = $bodyRepairRegistration->header->customer->name;
                    $jurnalUmumMasterDiskon->is_coa_category = 1;
                    $jurnalUmumMasterDiskon->transaction_type = 'RG';
                    $jurnalUmumMasterDiskon->save();

                    // save product sub master coa diskon penjualan
                    $coaDiskon = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaDiskonPenjualan->id);
                    $getCoaDiskon = $coaDiskon->code;
                    $coaDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaDiskon));
                    $jurnalUmumDiskon = new JurnalUmum;
                    $jurnalUmumDiskon->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                    $jurnalUmumDiskon->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                    $jurnalUmumDiskon->coa_id = $coaDiskonWithCode->id;
                    $jurnalUmumDiskon->branch_id = $bodyRepairRegistration->header->branch_id;
                    $jurnalUmumDiskon->total = $rProduct->getDiscountAmount();
                    $jurnalUmumDiskon->debet_kredit = 'D';
                    $jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
                    $jurnalUmumDiskon->transaction_subject = $bodyRepairRegistration->header->customer->name;
                    $jurnalUmumDiskon->is_coa_category = 0;
                    $jurnalUmumDiskon->transaction_type = 'RG';
                    $jurnalUmumDiskon->save();
                }

                //save product master category coa penjualan barang
//                $coaMasterPenjualan = Coa::model()->findByPk($rProduct->product->productMasterCategory->coaPenjualanBarangDagang->id);
//                $getCoaMasterPenjualan = $coaMasterPenjualan->code;
//                $coaMasterPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterPenjualan));
                $jurnalUmumMasterPenjualan = new JurnalUmum;
                $jurnalUmumMasterPenjualan->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumMasterPenjualan->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumMasterPenjualan->coa_id = $rProduct->product->productMasterCategory->coa_penjualan_barang_dagang;
                $jurnalUmumMasterPenjualan->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumMasterPenjualan->total = $rProduct->total_price;
                $jurnalUmumMasterPenjualan->debet_kredit = 'K';
                $jurnalUmumMasterPenjualan->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterPenjualan->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumMasterPenjualan->is_coa_category = 1;
                $jurnalUmumMasterPenjualan->transaction_type = 'RG';
                $jurnalUmumMasterPenjualan->save();

                //save product sub master category coa penjualan barang
//                $coaPenjualan = Coa::model()->findByPk($rProduct->product->productSubMasterCategory->coaPenjualanBarangDagang->id);
//                $getCoaPenjualan = $coaPenjualan->code;
//                $coaPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPenjualan));
                $jurnalUmumPenjualan = new JurnalUmum;
                $jurnalUmumPenjualan->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumPenjualan->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumPenjualan->coa_id = $rProduct->product->productSubMasterCategory->coa_penjualan_barang_dagang;
                $jurnalUmumPenjualan->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumPenjualan->total = $rProduct->total_price;
                $jurnalUmumPenjualan->debet_kredit = 'K';
                $jurnalUmumPenjualan->tanggal_posting = date('Y-m-d');
                $jurnalUmumPenjualan->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumPenjualan->is_coa_category = 1;
                $jurnalUmumPenjualan->transaction_type = 'RG';
                $jurnalUmumPenjualan->save();

                //save product master coa inventory
                $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                $jurnalUmumMasterOutstandingPart->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumMasterOutstandingPart->coa_id = $rProduct->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPart->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumMasterOutstandingPart->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumMasterOutstandingPart->debet_kredit = 'K';
                $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPart->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPart->transaction_type = 'RG';
                $jurnalUmumMasterOutstandingPart->save();

                //save product sub master coa inventory
                $jurnalUmumOutstandingPart = new JurnalUmum;
                $jurnalUmumOutstandingPart->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumOutstandingPart->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumOutstandingPart->coa_id = $rProduct->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPart->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumOutstandingPart->total = $rProduct->quantity * $rProduct->hpp;
                $jurnalUmumOutstandingPart->debet_kredit = 'K';
                $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPart->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumOutstandingPart->is_coa_category = 0;
                $jurnalUmumOutstandingPart->transaction_type = 'RG';
                $jurnalUmumOutstandingPart->save();
            }
        }

        if (count($bodyRepairRegistration->serviceDetails) > 0) {
            foreach ($bodyRepairRegistration->serviceDetails as $key => $rService) {
                $price = $rService->is_quick_service == 1 ? $rService->price : $rService->total_price;

                // save service type coa
                $coaGroupPendapatanJasa = Coa::model()->findByPk($rService->service->serviceType->coa_id);
                $getCoaGroupPendapatanJasa = $coaGroupPendapatanJasa->code;
                $coaGroupPendapatanJasaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaGroupPendapatanJasa));
                $jurnalUmumGroupPendapatanJasa = new JurnalUmum;
                $jurnalUmumGroupPendapatanJasa->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumGroupPendapatanJasa->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumGroupPendapatanJasa->coa_id = $coaGroupPendapatanJasaWithCode->id;
                $jurnalUmumGroupPendapatanJasa->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumGroupPendapatanJasa->total = $price;
                $jurnalUmumGroupPendapatanJasa->debet_kredit = 'K';
                $jurnalUmumGroupPendapatanJasa->tanggal_posting = date('Y-m-d');
                $jurnalUmumGroupPendapatanJasa->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumGroupPendapatanJasa->is_coa_category = 1;
                $jurnalUmumGroupPendapatanJasa->transaction_type = 'RG';
                $jurnalUmumGroupPendapatanJasa->save();

                //save service category coa
                $coaPendapatanJasa = Coa::model()->findByPk($rService->service->serviceCategory->coa_id);
                $getCoaPendapatanJasa = $coaPendapatanJasa->code;
                $coaPendapatanJasaWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPendapatanJasa));
                $jurnalUmumPendapatanJasa = new JurnalUmum;
                $jurnalUmumPendapatanJasa->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                $jurnalUmumPendapatanJasa->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                $jurnalUmumPendapatanJasa->coa_id = $coaPendapatanJasaWithCode->id;
                $jurnalUmumPendapatanJasa->branch_id = $bodyRepairRegistration->header->branch_id;
                $jurnalUmumPendapatanJasa->total = $price;
                $jurnalUmumPendapatanJasa->debet_kredit = 'K';
                $jurnalUmumPendapatanJasa->tanggal_posting = date('Y-m-d');
                $jurnalUmumPendapatanJasa->transaction_subject = $bodyRepairRegistration->header->customer->name;
                $jurnalUmumPendapatanJasa->is_coa_category = 0;
                $jurnalUmumPendapatanJasa->transaction_type = 'RG';
                $jurnalUmumPendapatanJasa->save();

                if ($rService->discount_price > 0.00) {
                    $coaDiscountPendapatanJasa = Coa::model()->findByPk($rService->service->serviceCategory->coa_diskon_service);
                    $jurnalUmumDiscountPendapatanJasa = new JurnalUmum;
                    $jurnalUmumDiscountPendapatanJasa->kode_transaksi = $bodyRepairRegistration->header->transaction_number;
                    $jurnalUmumDiscountPendapatanJasa->tanggal_transaksi = $bodyRepairRegistration->header->transaction_date;
                    $jurnalUmumDiscountPendapatanJasa->coa_id = $coaDiscountPendapatanJasa->id;
                    $jurnalUmumDiscountPendapatanJasa->branch_id = $bodyRepairRegistration->header->branch_id;
                    $jurnalUmumDiscountPendapatanJasa->total = $rService->discountAmount;
                    $jurnalUmumDiscountPendapatanJasa->debet_kredit = 'D';
                    $jurnalUmumDiscountPendapatanJasa->tanggal_posting = date('Y-m-d');
                    $jurnalUmumDiscountPendapatanJasa->transaction_subject = $bodyRepairRegistration->header->customer->name;
                    $jurnalUmumDiscountPendapatanJasa->is_coa_category = 0;
                    $jurnalUmumDiscountPendapatanJasa->transaction_type = 'RG';
                    $jurnalUmumDiscountPendapatanJasa->save();
                }
            }
        }

//                if ($bodyRepairRegistration->saveDetails(Yii::app()->db)) {
                    $this->redirect(array('view', 'id' => $bodyRepairRegistration->header->id));
//                }
            }
        //}

        $this->render('addProductService', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'damage' => $damage,
            'damageDataProvider' =>$damageDataProvider,
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
        $bodyRepairRegistration = $this->instantiate($id);
        $bodyRepairRegistration->header->setCodeNumberByRevision('transaction_number');
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $type = "";
        
        $damage = new Service('search');
        $damage->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $damage->attributes = $_GET['Service'];
        }

        $damageCriteria = new CDbCriteria;
        $damageCriteria->together = 'true';
        $damageCriteria->with = array('serviceCategory', 'serviceType');

        $damageCriteria->compare('t.name', $damage->name, true);
        $damageCriteria->compare('t.code', $damage->code, true);
        $damageCriteria->compare('t.service_category_id', $damage->service_category_id);
        $damageCriteria->compare('t.service_type_id', 2);
        $explodeKeyword = explode(" ", $damage->findkeyword);
        foreach ($explodeKeyword as $key) {
            $damageCriteria->compare('t.code', $key, true, 'OR');
            $damageCriteria->compare('t.name', $key, true, 'OR');
            $damageCriteria->compare('description', $key, true, 'OR');
            $damageCriteria->compare('serviceCategory.name', $key, true, 'OR');
            $damageCriteria->compare('serviceCategory.code', $key, true, 'OR');
            $damageCriteria->compare('serviceType.name', $key, true, 'OR');
            $damageCriteria->compare('serviceType.code', $key, true, 'OR');
        }

        $damageDataProvider = new CActiveDataProvider('Service', array(
            'criteria' => $damageCriteria,
        ));

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
            $this->loadState($bodyRepairRegistration);
            
            if ($bodyRepairRegistration->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $bodyRepairRegistration->header->id));
            }
        }
        
        $this->render('update', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'damage' => $damage,
            'damageDataProvider' =>$damageDataProvider,
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
            'model' => $this->loadModel($id),
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationMemos' => $registrationMemos,
            'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
            'memo' => $memo,
        ));
    }

    public function actionAdmin()
    {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }
        
        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
        $dataProvider->criteria->addCondition("repair_type = 'BR'");
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionGenerateInvoice($id)
    {
        $registration = $this->instantiate($id);
        
        if ($registration->saveInvoice(Yii::app()->db)) {

            $this->redirect(array('view', 'id' => $id));
        }
        
    }

    public function actionGenerateSalesOrder($id)
    {
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

    public function actionGenerateWorkOrder($id)
    {
        $model = $this->instantiate($id);
        
        $model->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        $model->header->work_order_date = date('Y-m-d');
        $model->header->work_order_time = date('H:i:s');
        $model->header->status = 'Waitlist';

        if ($model->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status'))) {
            if ($model->header->repair_type == 'BR') {
//                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
//                    'registration_transaction_id' => $id,
//                    'name' => 'Work Order'
//                ));
                $real = new RegistrationRealizationProcess();
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $model->header->work_order_number;
                $real->save();
//                $real->detail = 'Update When Generate Work Order. WorkOrder#' . $model->header->work_order_number;
//                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));
//            } else {
//                $real = new RegistrationRealizationProcess();
//                $real->registration_transaction_id = $model->header->id;
//                $real->name = 'Work Order';
//                $real->checked = 1;
//                $real->checked_date = date('Y-m-d');
//                $real->checked_by = 1;
//                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $model->header->work_order_number;
//                $real->save();
            }

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

//    public function actionReceive($movementOutDetailId, $registrationProductId, $quantity)
//    {
//        $registrationProduct = RegistrationProduct::model()->findByPk($registrationProductId);
//        $registration = RegistrationTransaction::model()->findByPk($registrationProduct->registration_transaction_id);
//        $movementOutDetail = MovementOutDetail::model()->findByPk($movementOutDetailId);
//        $movementOut = MovementOutHeader::model()->findByPk($movementOutDetail->movement_out_header_id);
//
//        $receiveHeader = new TransactionReceiveItem();
//        $receiveHeader->receive_item_no = 'RI_' . $registration->id . mt_rand();
//        $receiveHeader->receive_item_date = date('Y-m-d');
//        $receiveHeader->arrival_date = date('Y-m-d');
//        $receiveHeader->recipient_id = Yii::app()->user->getId();
//        $receiveHeader->recipient_branch_id = $registration->branch_id;
//        $receiveHeader->request_type = 'Retail Sales';
//        $receiveHeader->request_date = $movementOut->date_posting;
//        $receiveHeader->destination_branch = $registration->branch_id;
//        $receiveHeader->movement_out_id = $movementOut->id;
//        
//        if ($receiveHeader->save(false)) {
//            $receiveDetail = new TransactionReceiveItemDetail();
//            $receiveDetail->receive_item_id = $receiveHeader->id;
//            $receiveDetail->movement_out_detail_id = $movementOutDetail->id;
//            $receiveDetail->product_id = $registrationProduct->product_id;
//            $receiveDetail->qty_request = $registrationProduct->quantity;
//            $receiveDetail->qty_received = $quantity;
//            // $receiveDetail->save(false);
//            if ($receiveDetail->save(false)) {
//
//                $criteria = new CDbCriteria;
//                $criteria->together = 'true';
//                $criteria->with = array('receiveItem');
//                $criteria->condition = "receiveItem.movement_out_id =" . $movementOut->id . " AND receive_item_id != " . $receiveHeader->id;
//                $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);
//
//                $quantity = 0;
//                //print_r($receiveItemDetails);
//                foreach ($receiveItemDetails as $receiveItemDetail) {
//                    $quantity += $receiveItemDetail->qty_received;
//                }
//
//                $moveOutDetail = MovementOutDetail::model()->findByAttributes(array(
//                    'id' => $movementOutDetailId,
//                    'movement_out_header_id' => $movementOut->id
//                ));
//
//                $moveOutDetail->quantity_receive_left = $moveOutDetail->quantity - ($receiveDetail->qty_received + $quantity);
//                //$consignmentDetail->qty_request_left = 100;
//                $moveOutDetail->quantity_receive = $quantity + $receiveDetail->qty_received;
//
//                if ($moveOutDetail->save(false)) {
//                    $mcriteria = new CDbCriteria;
//                    $mcriteria->together = 'true';
//                    $mcriteria->with = array('movementOutHeader');
//                    $mcriteria->condition = "movementOutHeader.registration_transaction_id =" . $registration->id . " AND movement_out_header_id != " . $movementOut->id;
//                    $moDetails = MovementOutDetail::model()->findAll($mcriteria);
//
//                    $mquantity = 0;
//                    //print_r($receiveItemDetails);
//                    foreach ($moDetails as $moDetail) {
//                        $mquantity += $moDetail->quantity_receive;
//                    }
//
//                    $rpDetail = RegistrationProduct::model()->findByAttributes(array(
//                        'id' => $registrationProductId,
//                        'registration_transaction_id' => $registration->id
//                    ));
//
//                    $rpDetail->quantity_receive_left = $rpDetail->quantity - ($movementOutDetail->quantity_receive + $mquantity);
//                    //$consignmentDetail->qty_request_left = 100;
//                    $rpDetail->quantity_receive = $mquantity + $movementOutDetail->quantity_receive;
//                    
//                    if ($rpDetail->save(false)) {
//                        $registrationRealization = new RegistrationRealizationProcess();
//                        $registrationRealization->registration_transaction_id = $registration->id;
//                        $registrationRealization->name = 'Receive Item';
//                        $registrationRealization->checked = 1;
//                        $registrationRealization->checked_by = Yii::app()->user->id;
//                        $registrationRealization->checked_date = date('Y-m-d');
//                        $registrationRealization->detail = 'Receive Item for Product : ' . $registrationProduct->product->name . ' from Movement Out #: ' . $movementOut->movement_out_no . ' Quantity : ' . $quantity;
//                        $registrationRealization->save();
//                    }
//                }
//            }
//        }
//    }

    public function actionPdf($id)
    {
        $bodyRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($bodyRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($bodyRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output();
    }

    public function actionPdfSaleOrder($id)
    {
        $bodyRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($bodyRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($bodyRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfSaleOrder', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output();
    }

    public function actionPdfWorkOrder($id)
    {
        $bodyRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($bodyRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($bodyRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');
        
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfWorkOrder', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output();
    }

    public function actionUpdateSpk($id)
    {
        $model = RegistrationInsuranceData::model()->findByPk($id);

        if (isset($_POST['RegistrationInsuranceData'])) {
            $featured_image = $model->featured_image = CUploadedFile::getInstance($model, 'featured_image');

            if (isset($featured_image) && !empty($featured_image)) {
                $model->spk_insurance = $featured_image->extensionName;
            }
            
            if ($model->save()) {
                $real = RegistrationRealizationProcess::model()->findByAttributes(array(
                    'registration_transaction_id' => $model->registration_transaction_id,
                    'name' => 'SPK'
                ));
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Update When Upload SPK Image';
                $real->update(array('checked', 'checked_by', 'checked_date', 'detail'));

                if (isset($featured_image) && !empty($featured_image)) {
                    $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/' . $model->id;
                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $dir . '/' . $model->Featuredname;
                    $featured_image->saveAs($path);
                    $picture = Yii::app()->image->load($path);

                    $picture->save();
                }
                $this->redirect(array('view', 'id' => $model->registration_transaction_id));
            }
        }

        $this->render('updateSpk', array(
            'model' => $model,
        ));

    }

    public function actionUpdateImages($id)
    {
        $model = RegistrationInsuranceData::model()->findByPk($id);

        $insuranceImages = RegistrationInsuranceImages::model()->findAllByAttributes(array(
            'registration_insurance_data_id' => $model->id,
            'is_inactive' => $model::STATUS_ACTIVE
        ));
        $countPostImage = count($insuranceImages);
        $maxImage = 10;
        $allowedImages = $maxImage - $countPostImage;

        $images = $model->images = CUploadedFile::getInstances($model, 'images');
        if (isset($images) && !empty($images)) {
            foreach ($model->images as $i => $image) {
                $insuranceImage = new RegistrationInsuranceImages;
                $insuranceImage->registration_insurance_data_id = $model->id;

                $insuranceImage->extension = $image->extensionName;
                $insuranceImage->is_inactive = $model::STATUS_ACTIVE;
                if ($insuranceImage->save()) {
                    $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->id;

                    if (!file_exists($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $path = $dir . '/' . $insuranceImage->filename;
                    $image->saveAs($path);
                    $picture = Yii::app()->image->load($path);
                    $picture->save();

                    $thumb = Yii::app()->image->load($path);
                    $thumb_path = $dir . '/' . $insuranceImage->thumbname;
                    $thumb->save($thumb_path);

                    $square = Yii::app()->image->load($path);
                    $square_path = $dir . '/' . $insuranceImage->squarename;
                    $square->save($square_path);
                    $this->redirect(array('view', 'id' => $model->registration_transaction_id));
                }
                echo $image->extensionName;
            }
        }

        $this->render('updateImages', array(
            'model' => $model,
            'insuranceImages' => $insuranceImages,
            'allowedImages' => $allowedImages,
        ));
    }

    public function actionDeleteImage($id)
    {
        $model = RegistrationInsuranceImages::model()->findByPk($id);
        $model->scenario = 'delete';

        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->registrationInsuranceData->id . '/' . $model->filename;
        $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->registrationInsuranceData->id . '/' . $model->thumbname;
        $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/accident/' . $model->registrationInsuranceData->id . '/' . $model->squarename;

        if (file_exists($dir)) {
            unlink($dir);
        }
        
        if (file_exists($dir_thumb)) {
            unlink($dir_thumb);
        }
        
        if (file_exists($dir_square)) {
            unlink($dir_square);
        }

        $model->is_inactive = 1;
        $model->update(array('is_inactive'));

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteFeatured($id)
    {
        $model = RegistrationInsuranceData::model()->findByPk($id);
        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/' . $model->id . '/' . $model->featuredname;
        if (file_exists($dir)) {
            unlink($dir);
        }

        $model->spk_insurance = null;
        $model->update(array('spk_insurance'));
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteImageRealization($id)
    {
        $model = RegistrationRealizationImages::model()->findByPk($id);
        $model->scenario = 'delete';

        if ($model->registrationRealization->name == 'Epoxy') {
            $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->registrationRealization->id . '/' . $model->filename;
            $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->registrationRealization->id . '/' . $model->thumbname;
            $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/epoxy/' . $model->registrationRealization->id . '/' . $model->squarename;
        } else {
            $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->registrationRealization->id . '/' . $model->filename;
            $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->registrationRealization->id . '/' . $model->thumbname;
            $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/after_service/' . $model->registrationRealization->id . '/' . $model->squarename;
        }


        if (file_exists($dir)) {
            unlink($dir);
        }
        if (file_exists($dir_thumb)) {
            unlink($dir_thumb);
        }
        if (file_exists($dir_square)) {
            unlink($dir_square);
        }

        $model->is_inactive = 1;
        $model->update(array('is_inactive'));

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionAjaxHtmlAddDamageDetail($id, $serviceId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            
            $bodyRepairRegistration->addDamageDetail($serviceId);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailDamage', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDamageDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeDamageDetailAt($index);
            
            $this->renderPartial('_detailDamage', array(
                'registrationTransaction' => $bodyRepairRegistration
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDamageDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeDamageDetailAll();
            $this->renderPartial('_detailDamage', array('registrationTransaction' => $bodyRepairRegistration), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceInsuranceDetail($id, $serviceId, $insuranceId, $damageType, $repair)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);

            $bodyRepairRegistration->addServiceInsuranceDetail($serviceId, $insuranceId, $damageType, $repair);
            
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailService', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
            ), false, true);
        }
    }

//Add Service
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);

            $bodyRepairRegistration->addServiceDetail($serviceId, $customerId, $custType, $vehicleId, $repair);
            
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailService', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeServiceDetailAt($index);
            
            $this->renderPartial('_detailService', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetailAll($id)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeServiceDetailAll();
            
            $this->renderPartial('_detailService', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
            ), false, true);
        }
    }

//Add Product
    public function actionAjaxHtmlAddProductDetail($id, $productId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            $branches = Branch::model()->findAll(); 

            $bodyRepairRegistration->addProductDetail($productId);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailProduct', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
                'branches' => $branches,
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveProductDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($bodyRepairRegistration);
            
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeProductDetailAt($index);
            
            $branches = Branch::model()->findAll(); 
            
            $this->renderPartial('_detailProduct', array(
                'bodyRepairRegistration' => $bodyRepairRegistration,
                'branches' => $branches,
            ), false, true);
        }
    }

	public function actionAjaxJsonTotalService($id, $index)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$bodyRepairRegistration = $this->instantiate($id);
			$this->loadStateDetails($bodyRepairRegistration);

			$totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($bodyRepairRegistration->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepairRegistration->totalQuantityService));
			$subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalService));
			$totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalDiscountService));
			$grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalService));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxItemAmount));
			$taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxServiceAmount));
			$grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalTransaction));

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
			$bodyRepairRegistration = $this->instantiate($id);
			$this->loadStateDetails($bodyRepairRegistration);

			$totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($bodyRepairRegistration->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepairRegistration->totalQuantityProduct));
			$subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalProduct));
			$totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalDiscountProduct));
			$grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalProduct));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxItemAmount));
			$taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxServiceAmount));
			$grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalTransaction));

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
			$bodyRepairRegistration = $this->instantiate($id);
			$this->loadStateDetails($bodyRepairRegistration);

//			$totalQuickServiceQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalQuickServiceQuantity));
//			$subTotalQuickService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalQuickService));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepairRegistration->totalQuantityService));
			$subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalService));
			$totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalDiscountService));
			$grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalService));
			$subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalTransaction));
			$taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxItemAmount));
            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxServiceAmount));
			$grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalTransaction));

			echo CJSON::encode(array(
//                'totalQuickServiceQuantity' => $totalQuickServiceQuantity,
//                'subTotalQuickService' => $subTotalQuickService,
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

    public function actionAjaxGetCity()
    {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['RegistrationInsuranceData']['insured_province_id']),
            array('order' => 'name ASC'));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
        }
    }

    public function actionAjaxGetCityDriver()
    {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['RegistrationInsuranceData']['driver_province_id']), array('order' => 'name ASC'));

        if (count($data) > 0) {
            $data = CHtml::listData($data, 'id', 'name');
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
            
            foreach ($data as $value => $name) {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
            }
        } else {
            echo CHtml::tag('option', array('value' => ''), '[--Select City--]', true);
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
            $bodyRepairRegistration = new BodyRepairRegistration(new RegistrationTransaction(), array(), array(), array());
        } else {
            $bodyRepairRegistrationModel = $this->loadModel($id);
            $bodyRepairRegistration = new BodyRepairRegistration($bodyRepairRegistrationModel,
                $bodyRepairRegistrationModel->registrationQuickServices,
                $bodyRepairRegistrationModel->registrationServices,
                $bodyRepairRegistrationModel->registrationProducts
            );
        }
        return $bodyRepairRegistration;
    }

    public function loadState($bodyRepairRegistration)
    {
        if (isset($_POST['RegistrationTransaction'])) {
            $bodyRepairRegistration->header->attributes = $_POST['RegistrationTransaction'];
        }
    }

    public function loadStateDetails($bodyRepairRegistration)
    {
        if (isset($_POST['RegistrationTransaction'])) {
            $bodyRepairRegistration->header->attributes = $_POST['RegistrationTransaction'];
        }
        
        if (isset($_POST['RegistrationDamage'])) {
            foreach ($_POST['RegistrationDamage'] as $i => $item) {
                if (isset($bodyRepairRegistration->damageDetails[$i])) {
                    $bodyRepairRegistration->damageDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationDamage();
                    $detail->attributes = $item;
                    $bodyRepairRegistration->damageDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationDamage']) < count($bodyRepairRegistration->damageDetails)) {
                array_splice($bodyRepairRegistration->damageDetails, $i + 1);
            }
        } else {
            $bodyRepairRegistration->damageDetails = array();
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($bodyRepairRegistration->serviceDetails[$i])) {
                    $bodyRepairRegistration->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $bodyRepairRegistration->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($bodyRepairRegistration->serviceDetails)) {
                array_splice($bodyRepairRegistration->serviceDetails, $i + 1);
            }
        } else {
            $bodyRepairRegistration->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($bodyRepairRegistration->productDetails[$i])) {
                    $bodyRepairRegistration->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $bodyRepairRegistration->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($bodyRepairRegistration->productDetails)) {
                array_splice($bodyRepairRegistration->productDetails, $i + 1);
            }
        } else {
            $bodyRepairRegistration->productDetails = array();
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