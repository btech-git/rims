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
        
        $registrationTransaction = $this->instantiate(null, 'create');        
        $saleEstimationHeader = SaleEstimationHeader::model()->findByPk($estimationId);
        $vehicleData = Vehicle::model()->findByPk($saleEstimationHeader->vehicle_id);
        $customer = Customer::model()->findByPk($saleEstimationHeader->customer_id);

        $registrationTransaction->header->transaction_date = date('Y-m-d H:i:s');
        $registrationTransaction->header->created_datetime = date('Y-m-d H:i:s');
        $registrationTransaction->header->user_id = Yii::app()->user->id;
        $registrationTransaction->header->vehicle_id = empty($saleEstimationHeader->vehicle_id) ? null : $saleEstimationHeader->vehicle_id;
        $registrationTransaction->header->customer_id = empty($saleEstimationHeader->customer_id) ? null :$saleEstimationHeader->customer_id;
        $registrationTransaction->header->vehicle_mileage = $saleEstimationHeader->vehicle_mileage;
        $registrationTransaction->header->branch_id = Yii::app()->user->branch_id;
        $registrationTransaction->header->status = 'Registration';
        $registrationTransaction->header->vehicle_status = 'DI BENGKEL';
        $registrationTransaction->header->service_status = 'Pending';
        $registrationTransaction->header->product_status = 'Draft';
        $registrationTransaction->header->priority_level = 2;
        $registrationTransaction->header->sale_estimation_header_id = $estimationId;
        $registrationTransaction->header->vehicle_entry_datetime = null;
        $registrationTransaction->header->vehicle_exit_datetime = null;
        $registrationTransaction->header->vehicle_start_service_datetime = null;
        $registrationTransaction->header->vehicle_finish_service_datetime = null;
        $registrationTransaction->header->work_order_time = null;
        
        $branches = Branch::model()->findAll();
        $registrationTransaction->addDetails($estimationId);

        $service = new Service('search');
        $service->unsetAttributes();  // clear any default values
        if (isset($_GET['Service'])) {
            $service->attributes = $_GET['Service'];
        }
        $serviceDataProvider = $service->search();
        $serviceDataProvider->criteria->compare('t.status', 'Active');

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }
        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');
        
        $vehicle = Search::bind(new Vehicle('search'), isset($_GET['Vehicle']) ? $_GET['Vehicle'] : '');
        $vehicleDataProvider = $vehicle->search();
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($registrationTransaction);
            $registrationTransaction->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($registrationTransaction->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($registrationTransaction->header->transaction_date)), $registrationTransaction->header->branch_id);

            if ($registrationTransaction->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $registrationTransaction->header->id));
            }
        }

        $this->render('create', array(
            'registrationTransaction' => $registrationTransaction,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'vehicleData' => $vehicleData,
            'vehicle' => $vehicle,
            'vehicleDataProvider' => $vehicleDataProvider,
            'customer' => $customer,
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

    public function getInvoiceDetailsData($invoiceHeader) {
        $pageSize = 9;
        
        $invoiceDetails = array();
        foreach ($invoiceHeader->invoiceDetails as $invoiceDetail) {
            if (!empty($invoiceDetail->product_id)) {
                $invoiceDetails[] = $invoiceDetail;
            }
        }
        foreach ($invoiceHeader->invoiceDetails as $invoiceDetail) {
            if (!empty($invoiceDetail->service_id)) {
                $invoiceDetails[] = $invoiceDetail;
            }
        }
        
        $invoiceDetailsData = array();
        foreach ($invoiceDetails as $i => $invoiceDetail) {
            $currentPage = intval($i / $pageSize);
            if (!empty($invoiceDetail->product_id)) {
                $invoiceDetailsData['items'][$currentPage]['p'][] = $invoiceDetail;
                $invoiceDetailsData['lastpage']['p'] = $currentPage;
            } else if (!empty($invoiceDetail->service_id)) {
                $invoiceDetailsData['items'][$currentPage]['s'][] = $invoiceDetail;
                $invoiceDetailsData['lastpage']['s'] = $currentPage;
            }
        }
        
        return $invoiceDetailsData;
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

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $registrationTransaction = new RegistrationTransactionComponent(new RegistrationTransaction(), array(), array());
        } else {
            $registrationTransactionModel = $this->loadModel($id);
            $registrationTransaction = new RegistrationTransactionComponent($registrationTransactionModel, $registrationTransactionModel->registrationServices, $registrationTransactionModel->registrationProducts);
        }
        return $registrationTransaction;
    }

    public function loadState($registrationTransaction) {
        if (isset($_POST['RegistrationTransaction'])) {
            $registrationTransaction->header->attributes = $_POST['RegistrationTransaction'];
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
    }

    public function loadModel($id) {
        $model = RegistrationTransaction::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    public function actionAjaxHtmlAddProductDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);
            $branches = Branch::model()->findAll();

            if (isset($_POST['ProductId'])) {
                $registrationTransaction->addProductDetail($_POST['ProductId']);
            }
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;

            $this->renderPartial('_detailProduct', array(
                'registrationTransaction' => $registrationTransaction,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);
            $branches = Branch::model()->findAll();

            $registrationTransaction->removeProductDetailAt($index);

            $this->renderPartial('_detailProduct', array(
                'registrationTransaction' => $registrationTransaction,
                'branches' => $branches,
            ), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            if (isset($_POST['ServiceId'])) {
                $registrationTransaction->addServiceDetail($_POST['ServiceId']);
            }

            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $registrationTransaction,
            ));
        }
    }

    //Delete Phone Detail
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $registrationTransaction->removeServiceDetailAt($index);

            $this->renderPartial('_detailService', array(
                'registrationTransaction' => $registrationTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmount' => $totalAmount,
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonTotalProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($registrationTransaction->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalAmountProduct' => $totalAmountProduct,
                'totalQuantityProduct' => $totalQuantityProduct,
                'subTotalProduct' => $subTotalProduct,
                'totalDiscountProduct' => $totalDiscountProduct,
                'grandTotalProduct' => $grandTotalProduct,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalTransaction' => $grandTotalTransaction,
            ));
        }
    }

    public function actionAjaxJsonGrandTotal($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $registrationTransaction->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $registrationTransaction->grandTotalTransaction));

            echo CJSON::encode(array(
                'totalQuantityService' => $totalQuantityService,
                'subTotalService' => $subTotalService,
                'totalDiscountService' => $totalDiscountService,
                'grandTotalService' => $grandTotalService,
                'subTotalTransaction' => $subTotalTransaction,
                'taxItemAmount' => $taxItemAmount,
                'grandTotalProduct' => $grandTotalProduct,
                'grandTotal' => $grandTotal,
            ));
        }
    }
    
    public function actionAjaxJsonVehicle($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $registrationTransaction = $this->instantiate($id, '');
            $this->loadState($registrationTransaction);

            $vehicle = $registrationTransaction->header->vehicle(array('scopes' => 'resetScope', 'with' => 'customer:resetScope'));

            $object = array(
                'vehicle_name' => CHtml::value($vehicle, 'carMakeModelSubCombination'),
                'vehicle_plate_number' => CHtml::value($vehicle, 'plate_number'),
                'vehicle_frame_number' => CHtml::value($vehicle, 'frame_number'),
                'vehicle_color' => CHtml::value($vehicle, 'color.name'),
                'customer_name' => CHtml::value($vehicle, 'customer.name'),
                'customer_id' => CHtml::value($vehicle, 'customer_id'),
                'customer_address' => CHtml::value($vehicle, 'customer.address'),
                'customer_phone' => CHtml::value($vehicle, 'customer.mobile_phone'),
                'customer_email' => CHtml::value($vehicle, 'customer.email'),
            );

            echo CJSON::encode($object);
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
}
