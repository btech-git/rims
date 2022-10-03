<?php

class GeneralRepairRegistrationController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('generalRepairCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('generalRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'addProductService' ||
            $filterChain->action->id === 'generateSalesOrder' ||
            $filterChain->action->id === 'generateWorkOrder' ||
            $filterChain->action->id === 'generateInvoice' ||
            $filterChain->action->id === 'view' ||
            $filterChain->action->id === 'showRealization'
        ) {
            if (!(Yii::app()->user->checkAccess('generalRepairCreate')) || !(Yii::app()->user->checkAccess('generalRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
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
//        $generalRepairRegistration->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($generalRepairRegistration->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($generalRepairRegistration->header->transaction_date)), $generalRepairRegistration->header->branch_id);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['Submit'])) {
//            if ($_POST['_FormSubmit_'] === 'Submit') {
            $this->loadState($generalRepairRegistration);
            $generalRepairRegistration->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($generalRepairRegistration->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($generalRepairRegistration->header->transaction_date)), $generalRepairRegistration->header->branch_id);

            if ($generalRepairRegistration->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $generalRepairRegistration->header->id));
//            }
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
        $generalRepairRegistration->header->pph = 1;

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
        $serviceCriteria->compare('t.is_deleted', 0);
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

            if ($generalRepairRegistration->saveDetails(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $generalRepairRegistration->header->id));
            }
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

    public function actionUpdate($id) {
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

    public function actionView($id) {
        $model = $this->loadModel($id);
        
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

        if (isset($_POST['SubmitFinish'])) {
            $model->status = 'Finished';
            $model->transaction_date_out = date('Y-m-d');
            $model->transaction_time_out = date('H:i:s');
            $model->update(array('status', 'transaction_date_out', 'transaction_time_out'));
        }

        if (isset($_POST['SubmitOffPremise'])) {
            $model->vehicle_status = 'Sudah Diambil';
            $model->transaction_date_out = date('Y-m-d');
            $model->transaction_time_out = date('H:i:s');

            $model->update(array('vehicle_status', 'transaction_date_out', 'transaction_time_out'));
        }

        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->transaction_number,
            ));
            
        $transactionType = 'RG GR';
        $postingDate = date('Y-m-d');
        $transactionCode = $model->transaction_number;
        $transactionDate = $model->transaction_date;
        $branchId = $model->branch_id;
        $transactionSubject = $model->customer->name;
        
        $journalReferences = array();
        
        $jurnalUmumReceivable = new JurnalUmum;
        $jurnalUmumReceivable->kode_transaksi = $model->transaction_number;
        $jurnalUmumReceivable->tanggal_transaksi = $model->transaction_date;
        $jurnalUmumReceivable->coa_id = (empty($model->insurance_company_id)) ? $model->customer->coa_id : $model->insuranceCompany->coa_id;
        $jurnalUmumReceivable->branch_id = $model->branch_id;
        $jurnalUmumReceivable->total = $model->grand_total;
        $jurnalUmumReceivable->debet_kredit = 'D';
        $jurnalUmumReceivable->tanggal_posting = date('Y-m-d');
        $jurnalUmumReceivable->transaction_subject = $model->customer->name;
        $jurnalUmumReceivable->is_coa_category = 0;
        $jurnalUmumReceivable->transaction_type = 'RG GR';
        $jurnalUmumReceivable->save();

        if ($model->ppn_price > 0.00) {
            $coaPpn = Coa::model()->findByAttributes(array('code' => '224.00.001'));
            $jurnalUmumPpn = new JurnalUmum;
            $jurnalUmumPpn->kode_transaksi = $model->transaction_number;
            $jurnalUmumPpn->tanggal_transaksi = $model->transaction_date;
            $jurnalUmumPpn->coa_id = $coaPpn->id;
            $jurnalUmumPpn->branch_id = $model->branch_id;
            $jurnalUmumPpn->total = $model->ppn_price;
            $jurnalUmumPpn->debet_kredit = 'K';
            $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
            $jurnalUmumPpn->transaction_subject = $model->customer->name;
            $jurnalUmumPpn->is_coa_category = 0;
            $jurnalUmumPpn->transaction_type = 'RG GR';
            $jurnalUmumPpn->save();
        }

        if ($model->pph_price > 0.00) {
            $coaPph = Coa::model()->findByAttributes(array('code' => '224.00.004'));
            $jurnalUmumPpn = new JurnalUmum;
            $jurnalUmumPpn->kode_transaksi = $model->transaction_number;
            $jurnalUmumPpn->tanggal_transaksi = $model->transaction_date;
            $jurnalUmumPpn->coa_id = $coaPph->id;
            $jurnalUmumPpn->branch_id = $model->branch_id;
            $jurnalUmumPpn->total = $model->pph_price;
            $jurnalUmumPpn->debet_kredit = 'D';
            $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
            $jurnalUmumPpn->transaction_subject = $model->customer->name;
            $jurnalUmumPpn->is_coa_category = 0;
            $jurnalUmumPpn->transaction_type = 'RG GR';
            $jurnalUmumPpn->save();
        }

        if (count($model->registrationProducts) > 0) {
            foreach ($model->registrationProducts as $key => $rProduct) {
                $jurnalUmumHpp = $rProduct->product->productSubMasterCategory->coa_hpp;
                $journalReferences[$jurnalUmumHpp]['debet_kredit'] = 'D';
                $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumHpp]['values'][] = $rProduct->quantity * $rProduct->hpp;

                $jurnalUmumPenjualan = $rProduct->product->productSubMasterCategory->coa_penjualan_barang_dagang;
                $journalReferences[$jurnalUmumPenjualan]['debet_kredit'] = 'K';
                $journalReferences[$jurnalUmumPenjualan]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumPenjualan]['values'][] = $rProduct->sale_price * $rProduct->quantity;

                $jurnalUmumOutstandingPart = $rProduct->product->productSubMasterCategory->coa_outstanding_part_id;
                $journalReferences[$jurnalUmumOutstandingPart]['debet_kredit'] = 'K';
                $journalReferences[$jurnalUmumOutstandingPart]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumOutstandingPart]['values'][] = $rProduct->quantity * $rProduct->hpp;

                if ($rProduct->discount > 0) {
                    $jurnalUmumDiskon = $rProduct->product->productSubMasterCategory->coa_diskon_penjualan;
                    $journalReferences[$jurnalUmumDiskon]['debet_kredit'] = 'D';
                    $journalReferences[$jurnalUmumDiskon]['is_coa_category'] = 0;
                    $journalReferences[$jurnalUmumDiskon]['values'][] = $rProduct->getDiscountAmount();
                }
            }
        }

        if (count($model->registrationServices) > 0) {
            foreach ($model->registrationServices as $key => $rService) {
                $price = $rService->is_quick_service == 1 ? $rService->price : $rService->price;

                $jurnalUmumPendapatanJasa = $rService->service->serviceCategory->coa_id;
                $journalReferences[$jurnalUmumPendapatanJasa]['debet_kredit'] = 'K';
                $journalReferences[$jurnalUmumPendapatanJasa]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumPendapatanJasa]['values'][] = $price;

                if ($rService->discount_price > 0.00) {
                    $jurnalUmumDiscountPendapatanJasa = $rService->service->serviceCategory->coa_diskon_service;
                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['debet_kredit'] = 'D';
                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['is_coa_category'] = 0;
                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['values'][] = $rService->discountAmount;
                }
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
            
        $this->render('view', array(
            'model' => $model,
            'quickServices' => $quickServices,
            'services' => $services,
            'products' => $products,
            'registrationMemos' => $registrationMemos,
            'memo' => $memo,
        ));
    }

    public function actionPendingOrder($id) {
        $model = $this->loadModel($id);
        $model->status = 'Pending';
        $model->update(array('status'));
        $this->redirect(array('view', 'id' => $id));
        
    }
        
    public function actionAdmin() {
//        $model = new RegistrationTransaction('search');
//        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';
        $carMake = (isset($_GET['CarMake'])) ? $_GET['CarMake'] : '';
        $carModel = (isset($_GET['CarModel'])) ? $_GET['CarModel'] : '';
        $customerName = (isset($_GET['CustomerName'])) ? $_GET['CustomerName'] : '';

//        if (isset($_GET['RegistrationTransaction'])) {
//            $model->attributes = $_GET['RegistrationTransaction'];
//        }

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $dataProvider = $model->searchAdmin();
        $dataProvider->criteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
        $dataProvider->criteria->together = true;
        $dataProvider->criteria->with = array(
            'customer',
            'branch',
            'vehicle',
        );
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->addCondition('vehicle.plate_number LIKE :plate_number');
            $dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
        
        if (!empty($carMake)) {
            $dataProvider->criteria->addCondition('vehicle.car_make_id = :car_make_id');
            $dataProvider->criteria->params[':car_make_id'] = $carMake;
        }
        
        if (!empty($carModel)) {
            $dataProvider->criteria->addCondition('vehicle.car_model_id = :car_model_id');
            $dataProvider->criteria->params[':car_model_id'] = $carModel;
        }
        
        if (!empty($customerName)) {
            $dataProvider->criteria->addCondition('customer.name LIKE :name');
            $dataProvider->criteria->params[':name'] = "%{$customerName}%";
        }
        
        $dataProvider->criteria->addCondition("repair_type = 'GR'");
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'plateNumber' => $plateNumber,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'customerName' => $customerName,
        ));
    }

    public function actionFinishTransaction($id) {
        $model = $this->loadModel($id);
        $model->status = 'Finished';
        $model->transaction_date_out = date('Y-m-d');
        $model->transaction_time_out = date('H:i:s');
        
        if ($model->update(array('status', 'transaction_date_out', 'transaction_time_out'))) {
            $this->redirect(array('admin'));
        }
    }
    
    public function actionGenerateInvoice($id) {
        $registration = $this->instantiate($id);
        
        if (IdempotentManager::check()) {
            if ($registration->saveInvoice(Yii::app()->db, $id)) {
                $this->redirect(array('view', 'id' => $id));
            }
        }
    }

    public function actionGenerateSalesOrder($id) {
        $model = $this->instantiate($id);

        if (empty($model->header->sales_order_number)) {
            $model->generateCodeNumberSaleOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        } else {
            $model->setCodeNumberSaleOrderByRevision('sales_order_number');
        }
        
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

    public function actionGenerateWorkOrder($id) {
        $model = $this->instantiate($id);

        if (empty($model->header->work_order_number)) {
            $model->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($model->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->header->transaction_date)), $model->header->branch_id);
        } else {
            $model->setCodeNumberWorkOrderByRevision('work_order_number');
        }
        
        $model->header->work_order_date = date('Y-m-d');
        $model->header->work_order_time = date('H:i:s');
        $model->header->status = 'Processing WO';
        $model->header->service_status = 'Waitlist';

        if ($model->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status', 'service_status'))) {
            $real = new RegistrationRealizationProcess();
            $real->registration_transaction_id = $model->header->id;
            $real->name = 'Work Order';
            $real->checked = 1;
            $real->checked_date = date('Y-m-d');
            $real->checked_by = 1;
            $real->detail = 'Add When Generate Work Order. WorkOrder#' . $model->header->work_order_number;
            $real->save();

            $this->redirect(array('view', 'id' => $id));
        }
    }

    public function actionShowRealization($id) {
        $head = RegistrationTransaction::model()->findByPk($id);
        $reals = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        
        $this->render('realization', array(
            'head' => $head,
            'reals' => $reals,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $registrationRealizationProcess = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $model->id));
        foreach($registrationRealizationProcess as $detail) {
            $detail->delete();
        }
        $model->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function actionDeleteImage($id) {
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

    public function actionDeleteFeatured($id) {
        $model = RegistrationInsuranceData::model()->findByPk($id);
        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/insurance/' . $model->id . '/' . $model->featuredname;
        if (file_exists($dir)) {
            unlink($dir);
        }

        $model->spk_insurance = null;
        $model->update(array('spk_insurance'));
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionDeleteImageRealization($id) {
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

//    public function actionReceive($movementOutDetailId, $registrationProductId, $quantity) {
//
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
//            
//            if ($receiveDetail->save(false)) {
//
//                $criteria = new CDbCriteria;
//                $criteria->together = 'true';
//                $criteria->with = array('receiveItem');
//                $criteria->condition = "receiveItem.movement_out_id =" . $movementOut->id . " AND receive_item_id != " . $receiveHeader->id;
//                $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);
//
//                $quantity = 0;
//
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

    public function actionPdf($id) {
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

    public function actionPdfSaleOrder($id) {
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

    public function actionPdfWorkOrder($id) {
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
    public function actionAjaxHtmlAddQuickServiceDetail($id, $quickServiceId) {
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

    public function actionAjaxHtmlAddQsServiceDetail($id, $quickServiceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiateProductService($id);
            $this->loadState($generalRepairRegistration);

            $generalRepairRegistration->addQsServiceDetail($quickServiceId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            
            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $generalRepairRegistration
            ), false, true);
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveQuickServiceDetail($id, $index) {
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

    public function actionAjaxHtmlRemoveQuickServiceDetailAll($id) {
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
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair) {
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
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'generalRepairRegistration' => $generalRepairRegistration,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveServiceDetailAll($id) {
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
    public function actionAjaxHtmlAddProductDetail($id, $productId) {
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
    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);
            $branches = Branch::model()->findAll();

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $generalRepairRegistration->removeProductDetailAt($index);

            $this->renderPartial('_detailProduct', array(
                'generalRepairRegistration' => $generalRepairRegistration,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($generalRepairRegistration->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepairRegistration->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxItemAmount));
//            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxServiceAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmount' => $totalAmount,
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
//                'taxServiceAmount' => $taxServiceAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $generalRepairRegistration = $this->instantiate($id);
            $this->loadStateDetails($generalRepairRegistration);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($generalRepairRegistration->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $generalRepairRegistration->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxItemAmount));
//            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxServiceAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmountProduct' => $totalAmountProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
                'subTotalProduct' => $subTotalProduct,
                'totalDiscountProduct' => $totalDiscountProduct,
                'grandTotalProduct' => $grandTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
//                'taxServiceAmount' => $taxServiceAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
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
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalProduct));
//            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->taxServiceAmount));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $generalRepairRegistration->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalQuickServiceQuantity' => $totalQuickServiceQuantity,
                'subTotalQuickService' => $subTotalQuickService,
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalProduct' => $grandTotalProduct,
//                'taxServiceAmount' => $taxServiceAmount,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function actionAjaxShowPricelist($index, $serviceId, $customerId, $vehicleId, $insuranceId) {
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

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $generalRepairRegistration = new GeneralRepairRegistration(new RegistrationTransaction(), array(), array(), array());
        } else {
            $generalRepairRegistrationModel = $this->loadModel($id);
            $generalRepairRegistration = new GeneralRepairRegistration($generalRepairRegistrationModel, $generalRepairRegistrationModel->registrationQuickServices, $generalRepairRegistrationModel->registrationServices, $generalRepairRegistrationModel->registrationProducts);
        }
        return $generalRepairRegistration;
    }

    public function loadState($generalRepairRegistration) {
        if (isset($_POST['RegistrationTransaction'])) {
            $generalRepairRegistration->header->attributes = $_POST['RegistrationTransaction'];
        }
    }

    public function loadStateDetails($generalRepairRegistration) {
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

    public function instantiateRegistrationService($id) {
        if (empty($id)) {
            $registrationService = new RegistrationServices(new RegistrationService(), array(), array());
        } else {
            $registrationServiceModel = RegistrationService::model()->findByAttributes(array('id' => $id));
            $registrationService = new RegistrationServices($registrationServiceModel, $registrationServiceModel->registrationServiceEmployees, $registrationServiceModel->registrationServiceSupervisors);
        }
        return $registrationService;
    }

    public function loadStateRegistrationService($registrationService) {
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

    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');

        return $model;
    }

}
