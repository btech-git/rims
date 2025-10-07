<?php

class RegistrationTransactionController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'cashier') {
            if (!(Yii::app()->user->checkAccess('cashierApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }
        
        if ($filterChain->action->id === 'customerWaitlist') {
            if (!(Yii::app()->user->checkAccess('customerQueueApproval'))) {
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
        $quickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationMemos = RegistrationMemo::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'quickServices' => $quickServices,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationMemos' => $registrationMemos,
        ));
    }

    public function actionViewWo($id) {

        $model = $this->loadModel($id);
        // if($model->repair_type == 'GR'){
        // 	$details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$id,'is_body_repair'=>0));
        // }
        // else
        // {
        // 	$details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id'=>$id,'is_body_repair'=>1));
        // }
        $details = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $id));


        $this->render('viewWo', array(
            'model' => $model,
            'details' => $details,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($estimationId) {
        
        $data = array();
        if ($type == 1) {
            $data = Customer::model()->findByPk($id);
        } else {
            $data = Vehicle::model()->findByPk($id);
        }

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
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

        $serviceArray = array();
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productDataProvider = $product->search();

        $registrationTransaction = $this->instantiate(null);
        $registrationTransaction->header->branch_id = $registrationTransaction->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $registrationTransaction->header->branch_id;
        
        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($registrationTransaction);
            $registrationTransaction->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);
        
            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }
        $this->render('create', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'data' => $data,
            'type' => $type,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
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

        $registrationTransaction = $this->instantiate($id);
        $registrationTransaction->header->setCodeNumberByRevision('transaction_number');
        $type = "";
        $data = RegistrationTransaction::model()->findByPk($id);
        if (isset($_POST['RegistrationTransaction'])) {
            $this->loadState($registrationTransaction);
            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }
        $this->render('update', array(
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'registrationTransaction' => $registrationTransaction,
            'qs' => $qs,
            'qsDataProvider' => $qsDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'type' => $type,
            'data' => $data,
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
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $model = new RegistrationTransaction();
        $model->choice = 2;
        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $customerCompany = isset($_GET['CustomerCompany']) ? $_GET['CustomerCompany'] : '';
        $vehicle = new Vehicle('search');
        $vehicle->unsetAttributes();  // clear any default values
        if (isset($_GET['Vehicle'])) {
            $vehicle->attributes = $_GET['Vehicle'];
        }

        $vehicleDataProvider = $vehicle->search();
        $vehicleDataProvider->criteria->with = array('customer');

        if (!empty($customerCompany)) {
            $vehicleDataProvider->criteria->addCondition('customer.name LIKE :customer_company');
            $vehicleDataProvider->criteria->params[':customer_company'] = "%{$customerCompany}%";
        }

        $dataProvider = new CActiveDataProvider('RegistrationTransaction');
        $this->render('index', array(
            'model' => $model,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'customerCompany' => $customerCompany,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new RegistrationTransaction('search');

        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionCashier() {
        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader'])) {
            $invoice->attributes = $_GET['InvoiceHeader'];
        }
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->compare('t.invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('t.status', $invoice->status);
        $invoiceCriteria->compare('t.branch_id', $invoice->branch_id);
        $invoiceCriteria->compare('t.insurance_company_id', $invoice->insurance_company_id);
        if (!Yii::app()->user->checkAccess('director')) {
            $invoiceCriteria->addCondition('t.branch_id = :branch_id');
            $invoiceCriteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        $invoiceCriteria->addCondition("t.status NOT LIKE '%CANCELLED%' AND t.registration_transaction_id IS NOT NULL AND invoice_date > '" . AppParam::BEGINNING_TRANSACTION_DATE . "'");
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array(
            'customer', 
            'vehicle',
        );
        $invoiceCriteria->compare('vehicle.plate_number', $invoice->plate_number, true);
        $invoiceCriteria->addSearchCondition('customer.name', $invoice->customer_name, true);
        $invoiceCriteria->addSearchCondition('customer.customer_type', $invoice->customer_type, true);

        if (!empty($invoice->invoice_date) || !empty($invoice->invoice_date_to)) {
            $invoiceCriteria->addBetweenCondition('t.invoice_date', $invoice->invoice_date, $invoice->invoice_date_to);
        }
        
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria, 
            'sort' => array(
                'defaultOrder' => 'invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values

        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }

        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('name', $customer->name, true);
        $customerCriteria->compare('customer_type', $customer->customer_type, true);
        $customerCriteria->compare('email', $customer->email . '%', true, 'AND', false);

        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        $this->render('cashier', array(
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
        ));
    }

    public function actionPdf($id) {
        $invoiceHeader = InvoiceHeader::model()->findByPk($id);
        $invoiceDetailsData = $this->getInvoiceDetailsData($invoiceHeader);
        $customer = Customer::model()->findByPk($invoiceHeader->customer_id);
        $vehicle = Vehicle::model()->findByPk($invoiceHeader->vehicle_id);
        $branch = Branch::model()->findByPk($invoiceHeader->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Invoice');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
            'invoiceHeader' => $invoiceHeader,
            'invoiceDetailsData' => $invoiceDetailsData,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output('Invoice ' . $invoiceHeader->invoice_number . '.pdf', 'I');
    }
    
    public function actionPdfPayment($id) {
        $invoiceHeader = InvoiceHeader::model()->findByPk($id);
        $invoiceDetailsData = $this->getInvoiceDetailsData($invoiceHeader);
        $paymentInDetail = PaymentInDetail::model()->findByAttributes(array('invoice_header_id' => $id));
        $customer = Customer::model()->findByPk($invoiceHeader->customer_id);
        $vehicle = Vehicle::model()->findByPk($invoiceHeader->vehicle_id);
        $branch = Branch::model()->findByPk($invoiceHeader->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Tanda Terima');
        $mPDF1->WriteHTML($stylesheet, 1);
//        $mPDF1->SetWatermarkText('LUNAS');
//        $mPDF1->showWatermarkText = true;
//        $mPDF1->watermark_font = 'DejaVuSansCondensed'; 
        $mPDF1->WriteHTML($this->renderPartial('pdfPayment', array(
            'invoiceHeader' => $invoiceHeader,
            'invoiceDetailsData' => $invoiceDetailsData,
            'paymentInDetail' => $paymentInDetail,
            'customer' => $customer,
            'vehicle' => $vehicle,
            'branch' => $branch,
        ), true));
        $mPDF1->Output('Tanda Terima ' . $invoiceHeader->invoice_number . '.pdf', 'I');
    }

    public function actionAdminWo() {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $modelCriteria = new CDbCriteria;
        $modelCriteria->addCondition("work_order_number != ''");
        $modelDataProvider = new CActiveDataProvider('RegistrationTransaction', array(
            'criteria' => $modelCriteria,
            'sort' => array(
                'defaultOrder' => 'transaction_number',
                'attributes' => array(
                    'branch_id' => array(
                        'asc' => 'branch.name ASC',
                        'desc' => 'branch.name DESC',
                    ),
                    'customer_name' => array(
                        'asc' => 'customer.name ASC',
                        'desc' => 'customer.name DESC',
                    ),
                    'pic_name' => array(
                        'asc' => 'pic.name ASC',
                        'desc' => 'pic.name DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('adminWorkOrder', array(
            'model' => $model,
            'modelDataProvider' => $modelDataProvider,
        ));
    }

    public function actionMemo($id) {
        $model = $this->loadModel($id);
        $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $id));
        $services = InvoiceDetail::model()->findAll(array(
            'condition' => 'invoice_id = :invoice_id AND service_id IS NOT null',
            'params' => array(':invoice_id' => $invoiceHeader->id)
        ));
        $products = InvoiceDetail::model()->findAll(array(
            'condition' => 'invoice_id = :invoice_id AND product_id IS NOT null',
            'params' => array(':invoice_id' => $invoiceHeader->id)
        ));

        $this->render('memo', array(
            'model' => $model,
            'invoiceHeader' => $invoiceHeader,
            'services' => $services,
            'products' => $products,
        ));
    }

    public function actionAjaxJsonPrintCounter($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $invoiceHeader = InvoiceHeader::model()->findByPk($id);
            $invoiceHeader->number_of_print += 1;
            $invoiceHeader->user_id_printed =Yii::app()->user->getId();
            if ($invoiceHeader->save()) {
                $status = 'OK';
            } else {
                $status = 'Not OK';
            }

            echo CJSON::encode(array(
                'status' => $status,
            ));
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $registrationTransaction = new RegistrationTransactions(new RegistrationTransaction(), array(), array(), array(), array(), array());
        } else {
            $registrationTransactionModel = $this->loadModel($id);
            $registrationTransaction = new RegistrationTransactions($registrationTransactionModel, $registrationTransactionModel->registrationQuickServices, $registrationTransactionModel->registrationServices, $registrationTransactionModel->registrationProducts, $registrationTransactionModel->registrationDamages, $registrationTransactionModel->registrationInsuranceDatas);
        }
        return $registrationTransaction;
    }

    public function loadState($registrationTransaction) {
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->header->attributes = $_POST['RegistrationTransaction'];
        }
        if (isset($_POST['RegistrationQuickService'])) {
            foreach ($_POST['RegistrationQuickService'] as $i => $item) {
                if (isset($registrationTransaction->quickServiceDetails[$i])) {
                    $registrationTransaction->quickServiceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationQuickService();
                    $detail->attributes = $item;
                    $registrationTransaction->quickServiceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationQuickService']) < count($registrationTransaction->quickServiceDetails)) {
                array_splice($registrationTransaction->quickServiceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->quickServiceDetails = array();
        }

        if (isset($_POST['RegistrationService'])) {
            foreach ($_POST['RegistrationService'] as $i => $item) {
                if (isset($registrationTransaction->serviceDetails[$i])) {
                    $registrationTransaction->serviceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationService();
                    $detail->attributes = $item;
                    $registrationTransaction->serviceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationService']) < count($registrationTransaction->serviceDetails)) {
                array_splice($registrationTransaction->serviceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->serviceDetails = array();
        }

        if (isset($_POST['RegistrationProduct'])) {
            foreach ($_POST['RegistrationProduct'] as $i => $item) {
                if (isset($registrationTransaction->productDetails[$i])) {
                    $registrationTransaction->productDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationProduct();
                    $detail->attributes = $item;
                    $registrationTransaction->productDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationProduct']) < count($registrationTransaction->productDetails)) {
                array_splice($registrationTransaction->productDetails, $i + 1);
            }
        } else {
            $registrationTransaction->productDetails = array();
        }

        if (isset($_POST['RegistrationDamage'])) {
            foreach ($_POST['RegistrationDamage'] as $i => $item) {
                if (isset($registrationTransaction->damageDetails[$i])) {
                    $registrationTransaction->damageDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationDamage();
                    $detail->attributes = $item;
                    $registrationTransaction->damageDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationDamage']) < count($registrationTransaction->damageDetails)) {
                array_splice($registrationTransaction->damageDetails, $i + 1);
            }
        } else {
            $registrationTransaction->damageDetails = array();
        }

        if (isset($_POST['RegistrationInsuranceData'])) {
            foreach ($_POST['RegistrationInsuranceData'] as $i => $item) {
                if (isset($registrationTransaction->insuranceDetails[$i])) {
                    $registrationTransaction->insuranceDetails[$i]->attributes = $item;
                } else {
                    $detail = new RegistrationInsuranceData();
                    $detail->attributes = $item;
                    $registrationTransaction->insuranceDetails[] = $detail;
                }
            }
            if (count($_POST['RegistrationInsuranceData']) < count($registrationTransaction->insuranceDetails)) {
                array_splice($registrationTransaction->insuranceDetails, $i + 1);
            }
        } else {
            $registrationTransaction->insuranceDetails = array();
        }
    }

    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function actionCustomerWaitlist() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $model = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : '');
        $modelDataProvider = $model->search();
        $modelDataProvider->criteria->addCondition('t.branch_id = :branch_id');
        $modelDataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL AND t.status != 'Finished'");

        $services = Service::model()->findAll();
        $epoxyId = $paintId = $finishId = $dempulId = $washingId = $openingId = '';
        foreach ($services as $key => $service) {
            if ($service->name == 'Epoxy') {
                $epoxyId = $service->id;
            }

            if ($service->name == 'Cat') {
                $paintId = $service->id;
            }

            if ($service->name == 'Finishing') {
                $finishId = $service->id;
            }

            if ($service->name == 'Dempul') {
                $dempulId = $service->id;
            }

            if ($service->name == 'Cuci') {
                $washingId = $service->id;
            }

            if ($service->name == 'Bongkar') {
                $openingId = $service->id;
            }
        }

        $tbaId = 3; //3 is service TBA

        $modelGR = new CDbCriteria;
        $modelGR->compare("repair_type", 'GR');
        $modelGR->addCondition("work_order_number != ''");
        if (isset($_GET['RegistrationTransaction'])) {
            $modelGR->compare('name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelGR->compare('customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelGR->compare('repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelGR->compare('branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelGR->compare('status', $_GET['RegistrationTransaction']['status'], true);
        }

        // epoxy
        $modelEpoxyCriteria = new CDbCriteria;
        $modelEpoxyCriteria->compare("service_id", $epoxyId);
        $modelEpoxyCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelEpoxyCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelEpoxyCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelEpoxyCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelEpoxyCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelEpoxyCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelEpoxyCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end expoxy
        // paint
        $modelpaintCriteria = new CDbCriteria;
        $modelpaintCriteria->compare("service_id", $paintId);
        $modelpaintCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelpaintCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelpaintCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelpaintCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelpaintCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelpaintCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelpaintCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelpaintCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end paint
        // finish
        $modelfinishingCriteria = new CDbCriteria;
        $modelfinishingCriteria->compare("service_id", $finishId);
        $modelfinishingCriteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'customer',
                    'vehicle'
                )
            ),
            'service',
            'registrationServiceEmployees'
        );
        $modelfinishingCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelfinishingCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelfinishingCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelfinishingCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelfinishingCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            // $modelfinishingCriteria->compare('registrationTransaction.transaction_date',$_GET['RegistrationTransaction']['date_repair'],TRUE);
            $modelfinishingCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelfinishingCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end finish
        // dempul
        $modeldempulCriteria = new CDbCriteria;
        $modeldempulCriteria->compare("service_id", $dempulId);
        $modeldempulCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modeldempulCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modeldempulCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modeldempulCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modeldempulCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modeldempulCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modeldempulCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modeldempulCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }
        // end dempul

        $modelwashingCriteria = new CDbCriteria;
        $modelwashingCriteria->compare("service_id", $washingId);
        $modelwashingCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelwashingCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelwashingCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelwashingCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelwashingCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelwashingCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelwashingCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelwashingCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $modelopeningCriteria = new CDbCriteria;
        $modelopeningCriteria->compare("service_id", $openingId);
        $modelopeningCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelopeningCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelopeningCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelopeningCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelopeningCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelopeningCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelopeningCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelopeningCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $modeltbaCriteria = new CDbCriteria;
        $modeltbaCriteria->compare("service_id", $tbaId);
        $modeltbaCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modeltbaCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modeltbaCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modeltbaCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modeltbaCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modeltbaCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modeltbaCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modeltbaCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $modelgrCriteria = new CDbCriteria;
        $modelgrCriteria->compare("repair_type", 'GR');
        $modelgrCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelgrCriteria->together = true;

        if (isset($_GET['RegistrationTransaction'])) {
            $modelgrCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelgrCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelgrCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelgrCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }


        $oiltype = 4;
        $oiltypes = Service::model()->findAllByAttributes(array('service_type_id' => $oiltype));
        $arrayOil = CHtml::listData($oiltypes, 'id', function ($oiltypes) {
                    return $oiltypes->id;
                });
        $modelgrOilCriteria = new CDbCriteria;
        $modelgrOilCriteria->addInCondition("service_id", $arrayOil);
        $modelgrOilCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelgrOilCriteria->together = true;
        if (isset($_GET['RegistrationTransaction'])) {
            $modelgrOilCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelgrOilCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelgrOilCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrOilCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrOilCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelgrOilCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $wash = 5;
        $washs = Service::model()->findAllByAttributes(array('service_type_id' => $wash));
        $arrayWash = CHtml::listData($washs, 'id', function ($washs) {
                    return $washs->id;
                });
        $modelgrWashCriteria = new CDbCriteria;
        $modelgrWashCriteria->addInCondition("service_id", $arrayWash);
        $modelgrWashCriteria->with = array(
            'registrationTransaction' => array('with' => array('customer', 'vehicle')),
            'service',
            'registrationServiceEmployees'
        );
        $modelgrWashCriteria->together = true;
        if (isset($_GET['RegistrationTransaction'])) {
            $modelgrWashCriteria->compare('customer.name', $_GET['RegistrationTransaction']['customer_name'], true);
            $modelgrWashCriteria->compare('customer.customer_type', $_GET['RegistrationTransaction']['customer_type'], true);
            $modelgrWashCriteria->compare('registrationTransaction.repair_type', $_GET['RegistrationTransaction']['repair_type'], true);
            $modelgrWashCriteria->compare('registrationTransaction.branch_id', $_GET['RegistrationTransaction']['branch_id'], true);
            $modelgrWashCriteria->addBetweenCondition('registrationTransaction.transaction_date', $_GET['RegistrationTransaction']['transaction_date_from'], $_GET['RegistrationTransaction']['transaction_date_to']);
            $modelgrWashCriteria->compare('t.status', $_GET['RegistrationTransaction']['status'], true);
        }

        $epoxyDatas = $this->getDataProviderTimecounter($modelEpoxyCriteria);
        $paintDatas = $this->getDataProviderTimecounter($modelpaintCriteria);
        $finishingDatas = $this->getDataProviderTimecounter($modelfinishingCriteria);
        $dempulDatas = $this->getDataProviderTimecounter($modeldempulCriteria);
        $washingDatas = $this->getDataProviderTimecounter($modelwashingCriteria);
        $openingDatas = $this->getDataProviderTimecounter($modelopeningCriteria);
        $tbaDatas = $this->getDataProviderTimecounter($modeltbaCriteria);
        $grDatas = $this->getDataProviderTimecounter($modelgrCriteria);
        $grOilDatas = $this->getDataProviderTimecounter($modelgrOilCriteria);
        $grWashDatas = $this->getDataProviderTimecounter($modelgrWashCriteria);

        $this->render('customerWaitlist', array(
            'model' => $model,
//            'models' => $models,
            'modelDataProvider' => $modelDataProvider,
            'epoxyDatas' => $epoxyDatas,
            'paintDatas' => $paintDatas,
            'finishingDatas' => $finishingDatas,
            'dempulDatas' => $dempulDatas,
            'washingDatas' => $washingDatas,
            'openingDatas' => $openingDatas,
            'tbaDatas' => $tbaDatas,
            'grDatas' => $grDatas,
            'grOilDatas' => $grOilDatas,
            'grWashDatas' => $grWashDatas,
        ));
    }

    public function actionAjaxHtmlUpdateWaitlistTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new RegistrationTransaction('search');
            $model->unsetAttributes();  // clear any default values

            if (isset($_GET['RegistrationTransaction'])) {
                $model->attributes = $_GET['RegistrationTransaction'];
            }

            $modelDataProvider = $model->search();
            $modelDataProvider->criteria->addCondition("t.work_order_number IS NOT NULL");

            $this->renderPartial('_waitlistTable', array(
                'model' => $model,
                'modelDataProvider' => $modelDataProvider,
            ));
        }
    }

    public function actionMonthlyYearly() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $this->pageTitle = "RIMS - Monthly & Yearly Report";

        // $tanggal_mulai = (isset($_GET['tanggal_mulai'])) ? $_GET['tanggal_mulai'] : '';
        //       $tanggal_sampai = (isset($_GET['tanggal_sampai'])) ? $_GET['tanggal_sampai'] : '';
        $year = (isset($_GET['year'])) ? $_GET['year'] : date('Y');
        $month = (isset($_GET['month'])) ? $_GET['month'] : date('n');
        $branch = (isset($_GET['branch'])) ? $_GET['branch'] : '';
        $type = (isset($_GET['type'])) ? $_GET['type'] : 'Yearly';

        //$month = "";
        $criteria = new CDbCriteria;
        $criteria->addCondition("YEAR(transaction_date) = " . $year);
        if ($type == "Monthly") {
            $criteria->addCondition("MONTH(transaction_date) = " . $month);
        }
        if ($branch != "") {
            $criteria->addCondition("branch_id = " . $branch);
        }
        $transactions = RegistrationTransaction::model()->findAll($criteria);


        if (isset($_GET['SaveExcel'])) {
            $this->getXlsYearlyReport($year, $branch);
        }

        if (isset($_GET['SaveExcelMonth'])) {
            $this->getXlsMonthlyReport($year, $month, $branch);
        }

        $this->render('monthlyYearlyReport', array(
            'transactions' => $transactions,
            'branch' => $branch,
            'year' => $year,
            'month' => $month,
            'type' => $type,
        ));
    }
}
