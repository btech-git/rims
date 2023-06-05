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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('paymentInCreate')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('paymentInEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'admin' || $filterChain->action->id === 'memo' || $filterChain->action->id === 'view') {
            if (!(Yii::app()->user->checkAccess('paymentInCreate') || Yii::app()->user->checkAccess('paymentInEdit')))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('paymentInApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

//        if (
//            $filterChain->action->id === 'create' ||
//            $filterChain->action->id === 'invoiceList'
//        ) {
//            if (!(Yii::app()->user->checkAccess('paymentInCreate')) || !(Yii::app()->user->checkAccess('cashierApproval'))) {
//                $this->redirect(array('/site/login'));
//            }
//        }
//
//        if (
//            $filterChain->action->id === 'delete' ||
//            $filterChain->action->id === 'update'
//        ) {
//            if (!(Yii::app()->user->checkAccess('paymentInEdit'))) {
//                $this->redirect(array('/site/login'));
//            }
//        }

//        if (
//            $filterChain->action->id === 'admin' ||
//            $filterChain->action->id === 'index' ||
//            $filterChain->action->id === 'view'
//        ) {
//            if (!(Yii::app()->user->checkAccess('paymentInCreate')) || !(Yii::app()->user->checkAccess('cashierApproval')) || !(Yii::app()->user->checkAccess('paymentInEdit')) || !(Yii::app()->user->checkAccess('paymentInApproval'))) {
//                $this->redirect(array('/site/login'));
//            }
//        }

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

        if (isset($_POST['Process'])) {
            
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
            $jurnalPiutang->transaction_subject = $model->notes;
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
            $jurnalUmumKas->transaction_subject = $model->notes;
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
                $jurnalPph->transaction_subject = $model->notes;
                $jurnalPph->is_coa_category = 0;
                $jurnalPph->transaction_type = 'Pin';
                $jurnalPph->save();
            }
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
        $invoiceCriteria->addCondition('t.status != "CANCELLED" AND t.payment_left > 0');
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
        $model->created_datetime = date('Y-m-d H:i:s');
        $model->branch_id = $model->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $model->branch_id;
        $images = $model->images = CUploadedFile::getInstances($model, 'images');

        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['PaymentIn']) && IdempotentManager::check()) {
            $model->attributes = $_POST['PaymentIn'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->payment_date)), $model->branch_id);
                
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = true; 
                
                $paymentType = PaymentType::model()->findByPk($model->payment_type_id);
                if (empty($paymentType->coa_id) && $model->company_bank_id == null) {
                    $valid = false; 
                    $model->addError('error', 'Company Bank harus diisi untuk payment type ini.');
                } else {
                    $model->payment_type = $model->paymentType->name;
                }
                
                if ($model->payment_amount > $model->invoice->payment_left) {
                    $valid = false; 
                    $model->addError('error', 'Payment tidak bisa lebih besar dari jumlah invoice.');
                }
                
                $valid = $valid && IdempotentManager::build()->save() && $model->save();

                if (!empty($registrationTransaction)) {
                    $registrationTransaction->payment_status = 'CLEAR';
                    $registrationTransaction->update(array('payment_status'));
                }

                //update Invoice
                $invoice->payment_amount = $invoice->getTotalPayment();
                $invoice->payment_left = $invoice->getTotalRemaining();
                $invoice->update(array('payment_amount', 'payment_left'));

                $criteria = new CDbCriteria;
                $criteria->condition = "invoice_id = " . $model->invoice_id . " AND id != " . $model->id;

                foreach ($images as $file) {
                    $contentImage = new PaymentInImages();
                    $contentImage->payment_in_id = $model->id;
                    $contentImage->is_inactive = PaymentIn::STATUS_ACTIVE;
                    $contentImage->extension = $file->extensionName;
                    $valid = $contentImage->save(false) && $valid;

                    $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $contentImage->filename;
                    $file->saveAs($originalPath);
                }

                if ($valid) {
                    $dbTransaction->commit();
                } else {
                    $dbTransaction->rollback();
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }

            if ($valid) {
                $this->redirect(array('view', 'id' => $model->id));
            }
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
        $model->payment_time = date('H:i:s');
        $images = $model->images = CUploadedFile::getInstances($model, 'images');

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
            $dbTransaction = Yii::app()->db->beginTransaction();
            try {
                $valid = true; 
                $model->attributes = $_POST['PaymentIn'];
                
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $model->payment_number,
                    'branch_id' => $model->branch_id,
                ));

                $model->setCodeNumberByRevision('payment_number');

                if ((int)$model->payment_type_id !== 1 && (int)$model->company_bank_id == null) {
                    $model->addError('error', 'Company Bank cannot be empty!');
                } else {
                    if ($model->save()) {
                        //update Invoice
                        $criteria = new CDbCriteria;

                        $criteria->condition = "invoice_id =" . $model->invoice_id . " AND id != " . $model->id;
                        $payment = PaymentIn::model()->findAll($criteria);
                        $invoiceData = InvoiceHeader::model()->findByPk($model->invoice_id);
                        $totalRemaining = $invoiceData->getTotalRemaining();

                        if (count($payment) == 0) {
                            $countTotal = $invoiceData->total_price - $model->payment_amount;
                        } else {
                            $countTotal = $invoiceData->payment_left - $model->payment_amount;
                        }

                        if ($totalRemaining > 0) {
                            $invoiceData->status = 'PARTIALLY PAID';
                        } elseif ($totalRemaining == 0) {
                            $invoiceData->status = 'PAID';
                        } else {
                            $invoiceData->status = 'NOT PAID';
                        }

                        $invoiceData->payment_amount = $invoiceData->getTotalPayment();
                        $invoiceData->payment_left = $totalRemaining;
//                        $invoiceData->update(array('payment_amount', 'payment_left'));
                        $invoiceData->save(false);

                        PaymentInImages::model()->deleteAllByAttributes(array(
                            'payment_in_id' => $model->id,
                        ));

                        foreach ($images as $file) {
                            $contentImage = new PaymentInImages();
                            $contentImage->payment_in_id = $model->id;
                            $contentImage->is_inactive = PaymentIn::STATUS_ACTIVE;
                            $contentImage->extension = $file->extensionName;
                            $valid = $contentImage->save(false) && $valid;

                            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $contentImage->filename;
                            $file->saveAs($originalPath);
                        }

                        if ($valid) {
                            $dbTransaction->commit();
                        } else {
                            $dbTransaction->rollback();
                        }
                    }
                }
            } catch (Exception $e) {
                $dbTransaction->rollback();
                $valid = false;
            }

            if ($valid) {
                $this->redirect(array('view', 'id' => $model->id));
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
        
        $plateNumberInvoice = isset($_GET['PlateNumberInvoice']) ? $_GET['PlateNumberInvoice'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : '';
        
        if (isset($_GET['InvoiceHeader'])) {
            $invoice->attributes = $_GET['InvoiceHeader'];
        }

        $invoiceCriteria = new CDbCriteria;
        $invoiceCriteria->addCondition('t.payment_left > 0 AND t.invoice_date > "2021-12-31"');
        $invoiceCriteria->addInCondition('t.branch_id', Yii::app()->user->branch_ids);
        $invoiceCriteria->compare('invoice_number', $invoice->invoice_number, true);
        $invoiceCriteria->compare('invoice_date', $invoice->invoice_date, true);
        $invoiceCriteria->compare('due_date', $invoice->due_date, true);
        $invoiceCriteria->compare('total_price', $invoice->total_price, true);
        $invoiceCriteria->compare('user_id', $invoice->user_id);
        
        $invoiceCriteria->together = true;
        $invoiceCriteria->with = array('customer', 'vehicle');
        $invoiceCriteria->compare('customer.name', $invoice->customer_name, true);
        $invoiceCriteria->compare('vehicle.plate_number', $plateNumberInvoice, true);
        $invoiceDataProvider = new CActiveDataProvider('InvoiceHeader', array(
            'criteria' => $invoiceCriteria,
            'sort' => array(
                'defaultOrder' => 't.invoice_date DESC',
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
        $dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        $dataProvider->criteria->addInCondition('t.branch_id', Yii::app()->user->branch_ids);
        $dataProvider->criteria->with = array(
            'customer',
            'paymentInApprovals',
            'invoice' => array(
                'with' => array(
                    'vehicle',
                ),
            ),
        );
        $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '' ;
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : '' ;

        if (!empty($customerType)) {
            $dataProvider->criteria->compare('customer.customer_type', $customerType);        
        }
        
        if (!empty($plateNumber)) {
            $dataProvider->criteria->compare('vehicle.plate_number', $plateNumber, true);        
        }
        
        $this->render('admin', array(
            'model' => $model,
            'invoice' => $invoice,
            'invoiceDataProvider' => $invoiceDataProvider,
            'customerType' => $customerType,
            'plateNumber' => $plateNumber,
            'plateNumberInvoice' => $plateNumberInvoice,
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
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
            
            if (isset($_POST['PaymentInApproval'])) {
                $model->attributes = $_POST['PaymentInApproval'];
                if ($model->save()) {
                    $paymentIn->status = $model->approval_type;
                    $paymentIn->update(array('status'));

                    if ($model->approval_type == 'Approved') {
                        $invoiceHeader = InvoiceHeader::model()->findByPk($paymentIn->invoice_id);
                        if (!empty($invoiceHeader->registration_transaction_id)) {
                            $registrationTransaction = RegistrationTransaction::model()->findByPk($invoiceHeader->registration_transaction_id);
                            $coaId = !empty($registrationTransaction->insurance_company_id) ? $registrationTransaction->insuranceCompany->coa_id : $paymentIn->customer->coa_id;
                        } else {
                            $coaId = $paymentIn->customer->coa_id;
                        }
                        
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

                        $totalKas = ($paymentIn->is_tax_service == 2) ? $paymentIn->payment_amount : $paymentIn->payment_amount + $paymentIn->tax_service_amount;

                        $jurnalPiutang = new JurnalUmum;
                        $jurnalPiutang->kode_transaksi = $paymentIn->payment_number;
                        $jurnalPiutang->tanggal_transaksi = $paymentIn->payment_date;
                        $jurnalPiutang->coa_id = $coaId;
                        $jurnalPiutang->branch_id = $paymentIn->branch_id;
                        $jurnalPiutang->total = $totalKas;
                        $jurnalPiutang->debet_kredit = 'K';
                        $jurnalPiutang->tanggal_posting = date('Y-m-d');
                        $jurnalPiutang->transaction_subject = $paymentIn->notes;
                        $jurnalPiutang->is_coa_category = 0;
                        $jurnalPiutang->transaction_type = 'Pin';
                        $jurnalPiutang->save();

                        if (!empty($paymentIn->paymentType->coa_id)) {
                            $coaId = $paymentIn->paymentType->coa_id;
                        } else {
                            $coaId = $paymentIn->companyBank->coa_id;
                        }

                        $jurnalUmumKas = new JurnalUmum;
                        $jurnalUmumKas->kode_transaksi = $paymentIn->payment_number;
                        $jurnalUmumKas->tanggal_transaksi = $paymentIn->payment_date;
                        $jurnalUmumKas->coa_id = $coaId;
                        $jurnalUmumKas->branch_id = $paymentIn->branch_id;
                        $jurnalUmumKas->total = $paymentIn->payment_amount;
                        $jurnalUmumKas->debet_kredit = 'D';
                        $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                        $jurnalUmumKas->transaction_subject = $paymentIn->notes;
                        $jurnalUmumKas->is_coa_category = 0;
                        $jurnalUmumKas->transaction_type = 'Pin';
                        $jurnalUmumKas->save();

                        if ($paymentIn->tax_service_amount > 0) {
                            $jurnalPph = new JurnalUmum;
                            $jurnalPph->kode_transaksi = $paymentIn->payment_number;
                            $jurnalPph->tanggal_transaksi = $paymentIn->payment_date;
                            $jurnalPph->coa_id = 1473;
                            $jurnalPph->branch_id = $paymentIn->branch_id;
                            $jurnalPph->total = $paymentIn->tax_service_amount;
                            $jurnalPph->debet_kredit = 'D';
                            $jurnalPph->tanggal_posting = date('Y-m-d');
                            $jurnalPph->transaction_subject = $paymentIn->notes;
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

//    public function actionAjaxJsonTaxService($id, $invoiceId) {
//        if (Yii::app()->request->isAjaxRequest) {
//            $model = new PaymentIn;
//            $model->attributes = $_POST['PaymentIn'];
//
//            $taxServiceAmount = $model->taxServiceAmount;
//
//            $object = array(
//                'taxServiceAmount' => $taxServiceAmount,
//                'taxServiceAmountFormatted' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxServiceAmount)),
//            );
//            echo CJSON::encode($object);
//        }
//    }
    
    public function actionAjaxJsonAmount($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $model = new PaymentIn;
            $model->attributes = $_POST['PaymentIn'];

            $taxServiceAmount = empty($model->is_tax_service) ? 0.00 : $model->getTaxServiceAmount($model->is_tax_service);

            $object = array(
                'amount' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($model, 'payment_amount'))),
                'taxServiceAmount' => $taxServiceAmount,
                'taxServiceAmountFormatted' => CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $taxServiceAmount)),
            );

            echo CJSON::encode($object);
        }
    }

}