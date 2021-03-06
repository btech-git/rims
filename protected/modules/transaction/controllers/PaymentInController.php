<?php

class PaymentInController extends Controller {

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
        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'create' ||
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'invoiceList' ||
            $filterChain->action->id === 'update' ||
            $filterChain->action->id === 'updateApproval' ||
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('paymentInCreate')) || !(Yii::app()->user->checkAccess('paymentInEdit'))) {
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
        $revisionHistories = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id' => $model->id));
        $postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
        $invoice = InvoiceHeader::model()->findByPk($model->invoice_id);
        
        if (isset($_POST['SubmitFinish'])) {
            $registrationTransaction = RegistrationTransaction::model()->findByPk($model->invoice->registration_transaction_id);
            $registrationTransaction->status = 'Finished';
            $registrationTransaction->update(array('status'));
        }

        $this->render('view', array(
            'model' => $model,
            'postImages' => $postImages,
            'revisionHistories' => $revisionHistories,
            'invoice' => $invoice,
        ));
    }

    public function actionInvoiceList() {
        $invoice = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : '');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader']))
            $invoice->attributes = $_GET['InvoiceHeader'];
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.status != "CANCELLED" AND t.status != "PAID" AND t.payment_left > 0');
        $invoiceCriteria->compare('invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('total_price', $invoice->total_price, true);
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria, 'sort' => array(
                'defaultOrder' => 'invoice_date ASC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $this->render('invoiceList', array(
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($invoiceId) {
        $model = new PaymentIn;
        $invoice = InvoiceHeader::model()->findByPk($invoiceId);
        $registrationTransaction = RegistrationTransaction::model()->findByPk($invoice->registration_transaction_id);
        
        $model->invoice_id = $invoiceId;
        $model->invoice_number = $invoice->invoice_number;
        $model->customer_id = $invoice->customer_id;
        $model->vehicle_id = $invoice->vehicle_id;
        $model->payment_time = date('H:i:s');

        $model->branch_id = $model->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $model->branch_id;
        $images = $model->images = CUploadedFile::getInstances($model, 'images');

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['PaymentIn'])) {
            $model->attributes = $_POST['PaymentIn'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->payment_date)), $model->branch_id);

//            if ((int)$model->payment_type_id !== 1 && $model->company_bank_id == null) {
//                $model->addError('error', 'Company Bank cannot be empty!');
//            } else {
                if ($model->save(Yii::app()->db)) {
                    if (!empty($registrationTransaction)) {
                        $registrationTransaction->payment_status = 'CLEAR';
                        $registrationTransaction->update(array('payment_status'));
                    }

                    //update Invoice
                    $invoice->payment_amount = $invoice->getTotalPayment();
                    $invoice->payment_left = $invoice->getTotalRemaining();
                    $invoice->update(array('payment_amount', 'payment_left'));

                    $criteria = new CDbCriteria;
                    $criteria->condition = "invoice_id =" . $model->invoice_id . " AND id != " . $model->id;
    //                $payment = PaymentIn::model()->findAll($criteria);

                    if (isset($images) && !empty($images)) {
                        foreach ($model->images as $i => $image) {
                            $postImage = new PaymentInImages;
                            $postImage->payment_in_id = $model->id;
                            $postImage->is_inactive = $model::STATUS_ACTIVE;
                            $postImage->extension = $image->extensionName;

                            if ($postImage->save()) {
                                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->id;

                                if (!file_exists($dir)) {
                                    mkdir($dir, 0777, true);
                                }
                                $path = $dir . '/' . $postImage->filename;
                                $image->saveAs($path);
                                $picture = Yii::app()->image->load($path);
                                $picture->save();

                                $thumb = Yii::app()->image->load($path);
                                $thumb_path = $dir . '/' . $postImage->thumbname;
                                $thumb->save($thumb_path);

                                $square = Yii::app()->image->load($path);
                                $square_path = $dir . '/' . $postImage->squarename;
                                $square->save($square_path);
                            }
                        }
                    }

                    $this->redirect(array('view', 'id' => $model->id));
                }
//            }
        }

        $this->render('create', array(
            'model' => $model,
            'invoice' => $invoice,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->setCodeNumberByRevision('payment_number');

        $invoice = new InvoiceHeader('search');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader']))
            $invoice->attributes = $_GET['InvoiceHeader'];
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.status != "CANCELLED"');
        $invoiceCriteria->compare('invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('total_price', $invoice->total_price, true);
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria, 
            'sort' => array(
                'defaultOrder' => 'invoice_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $postImages = PaymentInImages::model()->findAllByAttributes(array('payment_in_id' => $model->id, 'is_inactive' => $model::STATUS_ACTIVE));
        $countPostImage = count($postImages);
        $maxImage = 10;
        $allowedImages = $maxImage - $countPostImage;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['PaymentIn'])) {
            $model->attributes = $_POST['PaymentIn'];
            
            if ((int)$model->payment_type_id !== 1 && (int)$model->company_bank_id == null) {
                $model->addError('error', 'Company Bank cannot be empty!');
            } else {
                if ($model->save()) {
                    //update Invoice
                    $criteria = new CDbCriteria;

                    $criteria->condition = "invoice_id =" . $model->invoice_id . " AND id != " . $model->id;
                    $payment = PaymentIn::model()->findAll($criteria);
                    // $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id'=>$model->invoice_id));
                    $invoiceData = InvoiceHeader::model()->findByPk($model->invoice_id);

                    if (count($payment) == 0) {
                        $countTotal = $invoiceData->total_price - $model->payment_amount;
                    } else {
                        $countTotal = $invoiceData->payment_left - $model->payment_amount;
                    }

                    if ($countTotal != 0)
                        $invoiceData->status = 'PARTIALLY PAID';
                    elseif ($countTotal == 0)
                        $invoiceData->status = 'PAID';
                    else
                        $invoiceData->status = 'NOT PAID';

                    $invoiceData->payment_amount = $model->payment_amount;
                    $invoiceData->payment_left = $countTotal;
                    $invoiceData->save(false);

                    $images = $model->images = CUploadedFile::getInstances($model, 'images');
                    //print_r($images);
                    if (isset($images) && !empty($images)) {

                        foreach ($model->images as $image) {

                            $postImage = new PaymentInImages;
                            $postImage->payment_in_id = $model->id;
                            $postImage->is_inactive = $model::STATUS_ACTIVE;
                            $postImage->extension = $image->extensionName;

                            if ($postImage->save()) {
                                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->id;

                                if (!file_exists($dir)) {
                                    mkdir($dir, 0777, true);
                                }
                                $path = $dir . '/' . $postImage->filename;
                                $image->saveAs($path);
                                $picture = Yii::app()->image->load($path);
                                $picture->save();

                                $thumb = Yii::app()->image->load($path);
                                $thumb_path = $dir . '/' . $postImage->thumbname;
                                $thumb->save($thumb_path);

                                $square = Yii::app()->image->load($path);
                                $square_path = $dir . '/' . $postImage->squarename;
                                $square->save($square_path);

                                echo $postImage->extension;
                            }
                        }
                    }

                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('update', array(
            'model' => $model,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'postImages' => $postImages,
            'allowedImages' => $allowedImages,
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

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $invoice = new InvoiceHeader('search');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader']))
            $invoice->attributes = $_GET['InvoiceHeader'];
        
        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.status != "CANCELLED" && t.status != "PAID"');
        $invoiceCriteria->compare('t.invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('t.invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('t.due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('t.total_price', $invoice->total_price, true);
        $invoiceCriteria->compare('t.status', $invoice->status, true);
        $invoiceCriteria->compare('t.reference_type', $invoice->reference_type);
        
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array('criteria' => $invoiceCriteria));
        $dataProvider = new CActiveDataProvider('PaymentIn');
        
        $this->render('index', array(
            'dataProvider' => $dataProvider,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $invoice = new InvoiceHeader('search');
        $invoice->unsetAttributes();
        
        if (isset($_GET['InvoiceHeader'])) {
            $invoice->attributes = $_GET['InvoiceHeader'];
        }

        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.status IN ("INVOICING", "PARTIAL PAYMENT", "NOT PAID", "PARTIALLY PAID")');
        $invoiceCriteria->compare('invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('total_price', $invoice->total_price, true);
        
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria,
            'sort' => array(
                'defaultOrder' => 'payment_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));
        
        $model = new PaymentIn('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['PaymentIn']))
            $model->attributes = $_GET['PaymentIn'];
        
        $dataProvider = $model->search();
        $dataProvider->criteria->with = array(
            'customer',
            'invoice',
        );
        $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '' ;

        if (!empty($customerType)) {
            $dataProvider->criteria->compare('customer.customer_type', $customerType);        
        }
        
        $this->render('admin', array(
            'model' => $model,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'customerType' => $customerType,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PaymentIn the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PaymentIn::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PaymentIn $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-in-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxInvoice($invoiceId) {
        $refNum = "";
        $vehicleId = $plate = $machine = $frame = $chasis = $power = $carMake = $carModel = $carSubModel = $carColor = "";
        $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id' => $invoiceId));
        if (count($payment) == 0)
            $count = 1;
        else
            $count = 2;
        $invoice = InvoiceHeader::model()->findByPk($invoiceId);
        if ($invoice->reference_type == 1) {
            $refNum = $invoice->salesOrder->sale_order_no;
        } else {
            $refNum = $invoice->registrationTransaction->transaction_number;
        }
        //$customer = Customer::model()->findByPk($invoice->customer_id);
        if ($invoice->vehicle_id != "") {
            $vehicle = Vehicle::model()->findByPk($invoice->vehicle_id);
            if (count($vehicle) != 0) {
                $vehicleId = $vehicle->id;
                $plate = $vehicle->plate_number != "" ? $vehicle->plate_number : '';
                $machine = $vehicle->machine_number != "" ? $vehicle->machine_number : '';
                $frame = $vehicle->frame_number != "" ? $vehicle->frame_number : '';
                $chasis = $vehicle->chasis_code != "" ? $vehicle->chasis_code : '';
                $power = $vehicle->power != "" ? $vehicle->power : '';
                $carMake = $vehicle->car_make_id != "" ? $vehicle->carMake->name : '';
                $carModel = $vehicle->car_model_id != "" ? $vehicle->carModel->name : '';
                $carSubModel = $vehicle->car_sub_model_detail_id != "" ? $vehicle->carSubModel->name : '';
                $carColor = $vehicle->color_id != "" ? Colors:: model()->findByPk($vehicle->color_id)->name : '';
            }
        }

        $object = array(
            'invoice_number' => $invoice->invoice_number,
            'invoice_date' => $invoice->invoice_date,
            'due_date' => $invoice->due_date,
            'reference_type' => $invoice->reference_type == 1 ? 'Sales Order' : 'Retail Sales',
            'reference_num' => $refNum,
            'status' => $invoice->status,
            'total_price' => $invoice->total_price,
            'payment_amount' => $invoice->payment_amount != "" ? $invoice->payment_amount : "0",
            'payment_left' => $invoice->payment_left != "" ? $invoice->payment_left : "0",
            'customer_id' => $invoice->customer->id,
            'customer_name' => $invoice->customer->name,
            'type' => $invoice->customer->customer_type,
            'address' => $invoice->customer->address,
            'province' => $invoice->customer->province != "" ? $invoice->customer->province->name : '',
            'city' => $invoice->customer->city != "" ? $invoice->customer->city->name : '',
            'email' => $invoice->customer->email,
            'phones' => $invoice->customer->customerPhones != "" ? $invoice->customer->customerPhones : array(),
            'mobiles' => $invoice->customer->customerMobiles != "" ? $invoice->customer->customerMobiles : array(),
            'vehicle_id' => $vehicleId,
            'plate' => $plate,
            'machine' => $machine,
            'frame' => $frame,
            'chasis' => $chasis,
            'power' => $power,
            'carMake' => $carMake,
            'carModel' => $carModel,
            'carSubModel' => $carSubModel,
            'carColor' => $carColor,
            'count' => $count,
        );
        echo CJSON::encode($object);
    }

    public function actionDeleteImage($id) {
        $model = PaymentInImages::model()->findByPk($id);
        $model->scenario = 'delete';

        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->filename;
        $dir_thumb = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->thumbname;
        $dir_square = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $model->payment_in_id . '/' . $model->squarename;

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

    public function actionUpdateApproval($headerId) {
//        $dbTransaction = Yii::app()->db->beginTransaction();
//        try {
            $paymentIn = PaymentIn::model()->findByPK($headerId);
            $historis = PaymentInApproval::model()->findAllByAttributes(array('payment_in_id' => $headerId));

            $model = new PaymentInApproval;
            $model->date = date('Y-m-d H:i:s');
            $invoiceHeader = InvoiceHeader::model()->findByPk($paymentIn->invoice_id);
            
            if (isset($_POST['PaymentInApproval'])) {
                $model->attributes = $_POST['PaymentInApproval'];
                if ($model->save()) {
                    $paymentIn->status = $model->approval_type;
                    $paymentIn->update(array('status'));

                    if ($model->approval_type == 'Approved') {
                        if ($invoiceHeader->payment_left > 0.00) {
                            $invoiceHeader->status = 'PARTIALLY PAID';
                        } else {
                            $invoiceHeader->status = 'PAID';
                        }

                        $invoiceHeader->update(array('status'));

                        JurnalUmum::model()->deleteAllByAttributes(array(
                            'kode_transaksi' => $paymentIn->payment_number,
                            'branch_id' => $paymentIn->branch_id,
                        ));

                        $getCoaPiutang = ($paymentIn->customer->customer_type == 'Company') ? '121.00.001' : '121.00.002';
                        $coaPiutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPiutang));
                        $jurnalPiutang = new JurnalUmum;
                        $jurnalPiutang->kode_transaksi = $paymentIn->payment_number;
                        $jurnalPiutang->tanggal_transaksi = $paymentIn->payment_date;
                        $jurnalPiutang->coa_id = $coaPiutangWithCode->id;
                        $jurnalPiutang->branch_id = $paymentIn->branch_id;
                        $jurnalPiutang->total = $paymentIn->payment_amount;
                        $jurnalPiutang->debet_kredit = 'K';
                        $jurnalPiutang->tanggal_posting = date('Y-m-d');
                        $jurnalPiutang->transaction_subject = $paymentIn->customer->name;
                        $jurnalPiutang->is_coa_category = 0;
                        $jurnalPiutang->transaction_type = 'Pin';
                        $jurnalPiutang->save();

                        $getCoaKas = '111.00.001';
                        $coaKasWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKas));
                        $jurnalUmumKas = new JurnalUmum;
                        $jurnalUmumKas->kode_transaksi = $paymentIn->payment_number;
                        $jurnalUmumKas->tanggal_transaksi = $paymentIn->payment_date;
                        $jurnalUmumKas->coa_id = $coaKasWithCode->id;
                        $jurnalUmumKas->branch_id = $paymentIn->branch_id;
                        $jurnalUmumKas->total = $paymentIn->payment_amount;
                        $jurnalUmumKas->debet_kredit = 'D';
                        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKas->transaction_subject = $paymentIn->customer->name;
                        $jurnalUmumKas->is_coa_category = 0;
                        $jurnalUmumKas->transaction_type = 'Pin';
                        $jurnalUmumKas->save();

                        if ($paymentIn->tax_service_amount > 0) {
                            $getCoaPph = '143.00.002';
                            $coaPphWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPph));
                            $jurnalPph = new JurnalUmum;
                            $jurnalPph->kode_transaksi = $paymentIn->payment_number;
                            $jurnalPph->tanggal_transaksi = $paymentIn->payment_date;
                            $jurnalPph->coa_id = $coaPphWithCode->id;
                            $jurnalPph->branch_id = $paymentIn->branch_id;
                            $jurnalPph->total = $paymentIn->tax_service_amount;
                            $jurnalPph->debet_kredit = 'D';
                            $jurnalPph->tanggal_posting = date('Y-m-d');
                            $jurnalPph->transaction_subject = $paymentIn->customer->name;
                            $jurnalPph->is_coa_category = 0;
                            $jurnalPph->transaction_type = 'Pin';
                            $jurnalPph->save();
                        }
                    }// end if approved
                }
                $this->redirect(array('view', 'id' => $headerId));
            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $paymentIn->addError('error', $e->getMessage());
//        }

        $this->render('updateApproval', array(
            'model' => $model,
            'paymentIn' => $paymentIn,
            'historis' => $historis,
        ));
    }

    public function actionAjaxGetCompanyBank() {
        $branch = Branch::model()->findByPk($_POST['PaymentIn']['branch_id']);
        $company = Company::model()->findByPk($branch->company_id);
        if ($company == NULL) {
            echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
        } else {
            // $companyarray = [];
            // foreach ($company as $key => $value) {
            // 	$companyarray[] = (int) $value->company_id;
            // }
            $data = CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name'));
            // $criteria = new CDbCriteria;
            // $criteria->addInCondition('company_id', $companyarray); 
            // $data = CompanyBank::model()->findAll($criteria);
            // var_dump($data); die("S");			// var_dump($data->); die("S");
            if (count($data) > 0) {
                // $bank = $data->bank->name;
                // $data=CHtml::listData($data,'bank_id',$data);
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $name->id), CHtml::encode($name->bank->name . " " . $name->account_no . " a/n " . $name->account_name), true);
                }
            } else {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
            }
        }
    }

    public function actionAjaxJsonTaxService($id, $invoiceId) {
        if (Yii::app()->request->isAjaxRequest) {
            $invoice = InvoiceHeader::model()->findByPk($invoiceId);
            $taxServiceAmount = $invoice->registrationTransaction->pph_price;

            $object = array(
                'taxServiceAmount' => $taxServiceAmount,
                'taxServiceAmountFormatted' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxServiceAmount)),
            );
            echo CJSON::encode($object);
        }
    }
}