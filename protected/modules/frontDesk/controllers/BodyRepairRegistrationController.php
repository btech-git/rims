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
            $filterChain->action->id === 'addProductService' ||
            $filterChain->action->id === 'generateInvoice' ||
            $filterChain->action->id === 'generateSalesOrder' ||
            $filterChain->action->id === 'generateWorkOrder' ||
            $filterChain->action->id === 'insuranceAddition' ||
            $filterChain->action->id === 'showRealization'
        ) {
            if (!(Yii::app()->user->checkAccess('bodyRepairCreate') || Yii::app()->user->checkAccess('bodyRepairEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'view'
        ) {
            if (!(
                Yii::app()->user->checkAccess('bodyRepairCreate') || 
                Yii::app()->user->checkAccess('bodyRepairEdit') || 
                Yii::app()->user->checkAccess('bodyRepairView')
            )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCreate($vehicleId) {
        $bodyRepairRegistration = $this->instantiate(null, 'create');
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $customer = Customer::model()->findByPk($vehicle->customer_id);

        $bodyRepairRegistration->header->transaction_date = date('Y-m-d H:i:s');
        $bodyRepairRegistration->header->work_order_time = date('H:i:s');
        $bodyRepairRegistration->header->created_datetime = date('Y-m-d H:i:s');
        $bodyRepairRegistration->header->user_id = Yii::app()->user->id;
        $bodyRepairRegistration->header->vehicle_id = $vehicleId;
        $bodyRepairRegistration->header->customer_id = $vehicle->customer_id;
        $bodyRepairRegistration->header->branch_id = Yii::app()->user->branch_id;
        $bodyRepairRegistration->header->vehicle_entry_datetime = null;
        $bodyRepairRegistration->header->vehicle_exit_datetime = null;
        $bodyRepairRegistration->header->vehicle_start_service_datetime = null;
        $bodyRepairRegistration->header->vehicle_finish_service_datetime = null;

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
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

    public function actionInsuranceAddition($id) {
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
        $bodyRepairRegistration = $this->instantiate($registrationId, 'create');
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
//        $serviceCriteria->compare('t.service_type_id', 2);
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
        $productDataProvider->criteria->compare('t.status', 'Active');

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $bodyRepairRegistration->header->id));
        }

        //if (isset($_POST['_FormSubmit_'])) {
        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadStateDetails($bodyRepairRegistration);

            if ($bodyRepairRegistration->saveDetails(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $bodyRepairRegistration->header->id));
            }
        }
        //}

        $this->render('addProductService', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
            'damage' => $damage,
            'damageDataProvider' => $damageDataProvider,
            'service' => $service,
            'serviceDataProvider' => $serviceDataProvider,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'serviceArray' => $serviceArray,
            'branches' => $branches,
        ));
    }

    public function actionUpdate($id) {
        $bodyRepairRegistration = $this->instantiate($id, 'update');
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->header->vehicle_id);
        $customer = Customer::model()->findByPk($vehicle->customer_id);
        $bodyRepairRegistration->header->edited_datetime = date('Y-m-d H:i:s');
        $bodyRepairRegistration->header->user_id_edited = Yii::app()->user->id;

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
        ));
    }

    public function actionView($id) {

        $model = $this->loadModel($id);
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
            'model' => $model,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationMemos' => $registrationMemos,
            'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
            'memo' => $memo,
        ));
    }

    public function actionShow($id) {

        $model = $this->loadModel($id);
        $services = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $id,
            'is_body_repair' => 0
        ));
        $products = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $damages = RegistrationDamage::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $insurances = RegistrationInsuranceData::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $registrationBodyRepairDetails = RegistrationBodyRepairDetail::model()->findAllByAttributes(array('registration_transaction_id' => $id));

        $this->render('show', array(
            'model' => $model,
            'services' => $services,
            'products' => $products,
            'damages' => $damages,
            'insurances' => $insurances,
            'registrationBodyRepairDetails' => $registrationBodyRepairDetails,
        ));
    }

    public function actionUpdateLocation($id, $vehicleId) {
        $vehicle = Vehicle::model()->findByPk($vehicleId);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($id);

        if (isset($_POST['Vehicle'])) {
            $vehicle->attributes = $_POST['Vehicle'];

//            if ($vehicle->status_location == 'Masuk Bengkel') {
//                $vehicle->entry_datetime = date('Y-m-d H:i:s');
//                $registrationTransaction->vehicle_entry_datetime = date('Y-m-d H:i:s');
//            } elseif ($vehicle->status_location == 'Mulai Service') {
//                $vehicle->start_service_datetime = date('Y-m-d H:i:s');
//                $registrationTransaction->vehicle_start_service_datetime = date('Y-m-d H:i:s');
//            } elseif ($vehicle->status_location == 'Selesai Service') {
//                $vehicle->finish_service_datetime = date('Y-m-d H:i:s');
//                $registrationTransaction->vehicle_finish_service_datetime = date('Y-m-d H:i:s');
//            } elseif ($vehicle->status_location == 'Keluar Bengkel') {
//                $vehicle->exit_datetime = date('Y-m-d H:i:s');
//                $registrationTransaction->vehicle_exit_datetime = date('Y-m-d H:i:s');
//            } else {
            $vehicle->entry_datetime = null;
            $vehicle->start_service_datetime = null;
            $vehicle->finish_service_datetime = null;
            $vehicle->exit_datetime = null;
            $registrationTransaction->vehicle_entry_datetime = null;
            $registrationTransaction->vehicle_start_service_datetime = null;
            $registrationTransaction->vehicle_finish_service_datetime = null;
            $registrationTransaction->vehicle_exit_datetime = null;
//            }

            if ($vehicle->save()) {
                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateLocation', array(
            'vehicle' => $vehicle,
        ));
    }

    public function actionPendingOrder($id) {
        $model = $this->loadModel($id);
        $model->status = 'Pending';
        $model->update(array('status'));
        $this->redirect(array('view', 'id' => $id));
    }

    public function actionAdmin() {
        $model = new RegistrationTransaction('search');
        $model->unsetAttributes();  // clear any default values

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';

        if (isset($_GET['RegistrationTransaction'])) {
            $model->attributes = $_GET['RegistrationTransaction'];
        }

        $dataProvider = $model->searchAdmin();
        if (!Yii::app()->user->checkAccess('director')) {
            $dataProvider->criteria->addCondition('t.branch_id = :branch_id');
            $dataProvider->criteria->params[':branch_id'] = Yii::app()->user->branch_id;
        }
        $dataProvider->criteria->addCondition("repair_type = 'BR'");
        $dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }

    public function actionGenerateSalesOrder($id) {
        $model = $this->instantiate($id, 'createSaleOrder');

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

    public function actionGenerateWorkOrder($id) {
        $bodyRepairRegistration = $this->instantiate($id, 'createWorkOrder');
        $customer = Customer::model()->findByPk($bodyRepairRegistration->header->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->header->vehicle_id);

        if (empty($bodyRepairRegistration->header->work_order_number)) {
            $bodyRepairRegistration->generateCodeNumberWorkOrder(Yii::app()->dateFormatter->format('M', strtotime($bodyRepairRegistration->header->transaction_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($bodyRepairRegistration->header->transaction_date)), $bodyRepairRegistration->header->branch_id);
        } else {
            $bodyRepairRegistration->setCodeNumberWorkOrderByRevision('work_order_number');
        }
        
        $bodyRepairRegistration->header->work_order_date = isset($_POST['RegistrationTransaction']['work_order_date']) ? $_POST['RegistrationTransaction']['work_order_date'] : date('Y-m-d');
        $bodyRepairRegistration->header->work_order_time = date('H:i:s');
        $bodyRepairRegistration->header->status = 'Waitlist';

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('view', 'id' => $id));
        }

        if (isset($_POST['Submit'])) {
            $bodyRepairRegistration->header->update(array('work_order_number', 'work_order_date', 'work_order_time', 'status'));
            if ($bodyRepairRegistration->header->repair_type == 'GR') {
                $real = new RegistrationRealizationProcess();
                $real->checked = 1;
                $real->checked_date = date('Y-m-d');
                $real->checked_by = 1;
                $real->detail = 'Add When Generate Work Order. WorkOrder#' . $bodyRepairRegistration->header->work_order_number;
                $real->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('generateWorkOrder', array(
            'bodyRepairRegistration' => $bodyRepairRegistration,
            'vehicle' => $vehicle,
            'customer' => $customer,
        ));
    }

    public function actionShowRealization($id) {
        $head = RegistrationTransaction::model()->findByPk($id);
        $reals = RegistrationRealizationProcess::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $this->render('realization', array(
            'head' => $head,
            'reals' => $reals,
        ));
    }

    public function actionPdf($id) {
        $bodyRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($bodyRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($bodyRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Estimasi');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array(
                    'bodyRepairRegistration' => $bodyRepairRegistration,
                    'customer' => $customer,
                    'vehicle' => $vehicle,
                    'branch' => $branch,
                        ), true));
        $mPDF1->Output('Estimasi ' . $bodyRepairRegistration->transaction_number . '.pdf', 'I');
    }

    public function actionPdfSaleOrder($id) {
        $bodyRepairRegistration = RegistrationTransaction::model()->find('id=:id', array(':id' => $id));
        $customer = Customer::model()->findByPk($bodyRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($bodyRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Sales Order');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfSaleOrder', array(
                    'bodyRepairRegistration' => $bodyRepairRegistration,
                    'customer' => $customer,
                    'vehicle' => $vehicle,
                    'branch' => $branch,
                        ), true));
        $mPDF1->Output('SO ' . $bodyRepairRegistration->sales_order_number . '.pdf', 'I');
    }

    public function actionPdfWorkOrder($id) {
        $bodyRepairRegistration = RegistrationTransaction::model()->findByPk($id);
        $customer = Customer::model()->findByPk($bodyRepairRegistration->customer_id);
        $vehicle = Vehicle::model()->findByPk($bodyRepairRegistration->vehicle_id);
        $branch = Branch::model()->findByPk($bodyRepairRegistration->branch_id);
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->SetTitle('Work Order');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdfWorkOrder', array(
                    'bodyRepairRegistration' => $bodyRepairRegistration,
                    'customer' => $customer,
                    'vehicle' => $vehicle,
                    'branch' => $branch,
                        ), true));
        $mPDF1->Output('WO ' . $bodyRepairRegistration->work_order_number . '.pdf', 'I');
    }

    public function actionUpdateSpk($id) {
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

    public function actionUpdateImages($id) {
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

    public function actionUpdateApproval($id) {
        $registrationTransaction = $this->loadModel($id);
        $historis = RegistrationApproval::model()->findAllByAttributes(array('registration_transaction_id' => $id));
        $model = new RegistrationApproval;
        $model->date = date('Y-m-d H:i:s');

        if (isset($_POST['RegistrationApproval'])) {
            $model->attributes = $_POST['RegistrationApproval'];
            if ($model->save()) {
                $registrationTransaction->status = $model->approval_type;
                $registrationTransaction->save(false);

                $this->saveTransactionLog('approval', $registrationTransaction);

                $this->redirect(array('view', 'id' => $id));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'registrationTransaction' => $registrationTransaction,
            'historis' => $historis,
        ));
    }

    public function actionCancel($id) {

        $movementOutHeader = MovementOutHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        $invoiceHeader = InvoiceHeader::model()->findByAttributes(array('registration_transaction_id' => $id, 'user_id_cancelled' => null));
        if (empty($movementOutHeader) && empty($invoiceHeader)) {
            $model = $this->loadModel($id);
            $model->status = 'CANCELLED!!!';
            $model->payment_status = 'CANCELLED!!!';
            $model->service_status = 'CANCELLED!!!';
            $model->vehicle_status = 'CANCELLED!!!';
            $model->cancelled_datetime = date('Y-m-d H:i:s');
            $model->user_id_cancelled = Yii::app()->user->id;
            $model->total_service = 0;
            $model->subtotal_service = 0;
            $model->discount_service = 0;
            $model->total_service_price = 0;
            $model->total_product = 0;
            $model->subtotal_product = 0;
            $model->discount_product = 0;
            $model->total_product_price = 0;
            $model->grand_total = 0;
            $model->ppn = 0;
            $model->pph = 0;
            $model->subtotal = 0;
            $model->ppn_price = 0;
            $model->pph_price = 0;
            $model->vehicle_mileage = 0;
            $model->tax_percentage = 0;
            $model->employee_id_assign_mechanic = null;
            $model->employee_id_sales_person = null;
            $model->work_order_number = '';
            $model->sales_order_number = '';
            $model->note = '';
            $model->customer_work_order_number = '';
            $model->feedback = '';
            $model->product_status = '';
            $model->update(array(
                'status', 'payment_status', 'service_status', 'vehicle_status', 'cancelled_datetime', 'user_id_cancelled', 'total_service',
                'subtotal_service', 'discount_service', 'total_service_price', 'total_product', 'subtotal_product', 'discount_product', 'total_product_price',
                'grand_total', 'work_order_number', 'sales_order_number', 'ppn', 'pph', 'subtotal', 'ppn_price', 'pph_price', 'vehicle_mileage', 'note',
                'customer_work_order_number', 'employee_id_assign_mechanic', 'employee_id_sales_person', 'tax_percentage', 'feedback', 'product_status'
            ));

            foreach ($model->registrationProducts as $registrationProduct) {
                $registrationProduct->quantity = 0;
                $registrationProduct->retail_price = 0;
                $registrationProduct->hpp = 0;
                $registrationProduct->recommended_selling_price = 0;
                $registrationProduct->sale_price = 0;
                $registrationProduct->discount = 0;
                $registrationProduct->total_price = 0;
                $registrationProduct->quantity_movement = 0;
                $registrationProduct->quantity_movement_left = 0;
                $registrationProduct->quantity_receive = 0;
                $registrationProduct->quantity_receive_left = 0;
                $registrationProduct->note = '';

                $registrationProduct->update(array(
                    'quantity', 'retail_price', 'hpp', 'recommended_selling_price', 'sale_price', 'discount', 'total_price', 'quantity_movement',
                    'quantity_movement_left', 'quantity_receive', 'quantity_receive_left', 'note'
                ));
            }

            foreach ($model->registrationServices as $registrationService) {
                $registrationService->price = 0;
                $registrationService->total_price = 0;
                $registrationService->discount_price = 0;
                $registrationService->start_mechanic_id = null;
                $registrationService->finish_mechanic_id = null;
                $registrationService->pause_mechanic_id = null;
                $registrationService->resume_mechanic_id = null;
                $registrationService->supervisor_id = null;
                $registrationService->assign_mechanic_id = null;
                $registrationService->note = '';

                $registrationService->update(array(
                    'price', 'total_price', 'discount_price', 'start_mechanic_id', 'finish_mechanic_id', 'pause_mechanic_id', 'resume_mechanic_id',
                    'supervisor_id', 'assign_mechanic_id', 'note'
                ));
            }

            $this->saveTransactionLog('cancel', $model);

            Yii::app()->user->setFlash('message', 'Transaction is successfully cancelled');
        } else {
            Yii::app()->user->setFlash('message', 'Transaction cannot be cancelled. Check related transactions!');
            $this->redirect(array('view', 'id' => $id));
        }

        $this->redirect(array('admin'));
    }

    public function saveTransactionLog($actionType, $bodyRepair) {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $bodyRepair->transaction_number;
        $transactionLog->transaction_date = $bodyRepair->transaction_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $bodyRepair->tableName();
        $transactionLog->table_id = $bodyRepair->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $actionType;

        $newData = $bodyRepair->attributes;

        if ($actionType === 'approval') {
            $newData['registrationApprovals'] = array();
            foreach ($bodyRepair->registrationApprovals as $detail) {
                $newData['registrationApprovals'][] = $detail->attributes;
            }
        } else {
            $newData['registrationProducts'] = array();
            foreach ($bodyRepair->registrationProducts as $detail) {
                $newData['registrationProducts'][] = $detail->attributes;
            }

            $newData['registrationServices'] = array();
            foreach ($bodyRepair->registrationServices as $detail) {
                $newData['registrationServices'][] = $detail->attributes;
            }
        }

        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }

    public function actionAjaxHtmlAddDamageDetail($id, $serviceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
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

    public function actionAjaxHtmlRemoveDamageDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
            $this->loadStateDetails($bodyRepairRegistration);

            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeDamageDetailAt($index);

            $this->renderPartial('_detailDamage', array(
                'registrationTransaction' => $bodyRepairRegistration
                    ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDamageDetailAll($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
            $this->loadStateDetails($bodyRepairRegistration);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $bodyRepairRegistration->removeDamageDetailAll();
            $this->renderPartial('_detailDamage', array('registrationTransaction' => $bodyRepairRegistration), false, true);
        }
    }

    public function actionAjaxHtmlAddServiceInsuranceDetail($id, $serviceId, $insuranceId, $damageType, $repair) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
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
    public function actionAjaxHtmlAddServiceDetail($id, $serviceId, $customerId, $custType, $vehicleId, $repair) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
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
    public function actionAjaxHtmlRemoveServiceDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepairRegistration = $this->instantiate($id, '');
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

    public function actionAjaxHtmlRemoveServiceDetailAll($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepairRegistration = $this->instantiate($id, '');
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
    public function actionAjaxHtmlAddProductDetail($id, $productId) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
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
    public function actionAjaxHtmlRemoveProductDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {

            $bodyRepairRegistration = $this->instantiate($id, '');
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

    public function actionAjaxJsonTotalService($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $bodyRepairRegistration = $this->instantiate($id, '');
            $this->loadStateDetails($bodyRepairRegistration);

            $totalAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($bodyRepairRegistration->serviceDetails[$index], 'totalAmount')));
            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepairRegistration->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxItemAmount));
//            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxServiceAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalTransaction));

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
            $bodyRepairRegistration = $this->instantiate($id, '');
            $this->loadStateDetails($bodyRepairRegistration);

            $totalAmountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($bodyRepairRegistration->productDetails[$index], 'totalAmountProduct')));
            $totalQuantityProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepairRegistration->totalQuantityProduct));
            $subTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalProduct));
            $totalDiscountProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalDiscountProduct));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalProduct));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxItemAmount));
//            $taxServiceAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxServiceAmount));
            $grandTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalTransaction));

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
            $bodyRepairRegistration = $this->instantiate($id, '');
            $this->loadStateDetails($bodyRepairRegistration);

            $totalQuantityService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $bodyRepairRegistration->totalQuantityService));
            $subTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalService));
            $totalDiscountService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->totalDiscountService));
            $grandTotalService = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalService));
            $subTotalTransaction = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->subTotalTransaction));
            $taxItemAmount = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->taxItemAmount));
            $grandTotalProduct = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalProduct));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $bodyRepairRegistration->grandTotalTransaction));

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

    public function actionAjaxGetCity() {
        $data = City::model()->findAllByAttributes(array('province_id' => $_POST['RegistrationInsuranceData']['insured_province_id']), array('order' => 'name ASC'));

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

    public function actionAjaxGetCityDriver() {
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

    public function instantiate($id, $actionType) {
        if (empty($id)) {
            $bodyRepairRegistration = new BodyRepairRegistration($actionType, new RegistrationTransaction(), array(), array(), array());
        } else {
            $bodyRepairRegistrationModel = $this->loadModel($id);
            $bodyRepairRegistration = new BodyRepairRegistration($actionType, $bodyRepairRegistrationModel, $bodyRepairRegistrationModel->registrationQuickServices, $bodyRepairRegistrationModel->registrationServices, $bodyRepairRegistrationModel->registrationProducts
            );
        }
        return $bodyRepairRegistration;
    }

    public function loadState($bodyRepairRegistration) {
        if (isset($_POST['RegistrationTransaction'])) {
            $bodyRepairRegistration->header->attributes = $_POST['RegistrationTransaction'];
        }
    }

    public function loadStateDetails($bodyRepairRegistration) {
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

    public function instantiateRegistrationService($id) {
        if (empty($id)) {
            $registrationService = new RegistrationServices(new RegistrationService(), array(), array());
            //print_r("test");
        } else {
            //$registrationServiceModel = $this->loadModel($id);
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
