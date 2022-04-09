<?php

class PaymentOutController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('paymentOutCreate'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('paymentOutEdit'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if ($filterChain->action->id === 'updateApproval') {
            if (!(Yii::app()->user->checkAccess('paymentOutApproval'))) {
                $this->redirect(array('/site/login'));
            }
        }

        if (
            $filterChain->action->id === 'admin' ||
            $filterChain->action->id === 'index' ||
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('paymentOutCreate')) || !(Yii::app()->user->checkAccess('paymentOutEdit')) || !(Yii::app()->user->checkAccess('paymentOutApproval'))) {
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
        $revisionHistories = PaymentOutApproval::model()->findAllByAttributes(array('payment_out_id' => $model->id));
        $postImages = PaymentOutImages::model()->findAllByAttributes(array(
            'payment_out_id' => $model->id,
            'is_inactive' => $model::STATUS_ACTIVE
        ));
        $supplier = empty($model->supplier_id) ? '' : $model->supplier;
        
        $this->render('view', array(
            'model' => $model,
            'supplier' => $supplier,
            'postImages' => $postImages,
            'revisionHistories' => $revisionHistories,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PaymentOut the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PaymentOut::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new PaymentOut;

        $purchaseOrder = new TransactionPurchaseOrder('search');
        $purchaseOrder->unsetAttributes();
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $purchaseOrder->attributes = $_GET['TransactionPurchaseOrder'];
        }
        $purchaseOrderCriteria = new CDbCriteria;
        //$purchaseOrderCriteria->addCondition('t.status_document = "Approved" and t.payment_type = "Credit" and t.payment_status != "PAID"');
        $purchaseOrderCriteria->addCondition('t.status_document = "Approved" and t.payment_status != "PAID"');
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

        $model->date_created = date('Y-m-d H:i:s');
        $model->branch_id = $model->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $model->branch_id;
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->payment_date)), $model->branch_id);

        $images = $model->images = CUploadedFile::getInstances($model, 'images');

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['PaymentOut'])) {
            $model->attributes = $_POST['PaymentOut'];
            $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->payment_date)), $model->branch_id);
            
            $po = TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id);
            if ($po->supplier->coa->id != "") {
                if ($model->save()) {
                    $criteria = new CDbCriteria;

                    $criteria->condition = "purchase_order_id =" . $model->purchase_order_id . " AND id != " . $model->id;
                    $payment = PaymentOut::model()->findAll($criteria);
                    // $payment = PaymentIn::model()->findAllByAttributes(array('invoice_id'=>$model->invoice_id));
                    //$payment = PaymentOut::model()->findAllByAttributes(array('purchase_order_id'=>$model->purchase_order_id));
//                    $poData = TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id);
//
//                    if (count($payment) == 0) {
//                        $countTotal = $poData->total_price - $model->payment_amount;
//                    } else {
//                        $countTotal = $poData->payment_left - $model->payment_amount;
//                    }
//
//                    if ($countTotal != 0) {
//                        $poData->payment_status = 'PARTIALLY PAID';
//                    } elseif ($countTotal == 0) {
//                        $poData->payment_status = 'PAID';
//                    } else {
//                        $poData->payment_status = 'NOT PAID';
//                    }
//
//                    $poData->payment_amount = $model->payment_amount;
//                    $poData->payment_left = $countTotal;
//                    $poData->save(false);

                    if (isset($images) && !empty($images)) {
                        foreach ($model->images as $i => $image) {
                            $postImage = new PaymentOutImages;
                            $postImage->payment_out_id = $model->id;
                            $postImage->is_inactive = $model::STATUS_ACTIVE;
                            $postImage->extension = $image->extensionName;

                            if ($postImage->save()) {
                                $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentOut/' . $model->id;

                                if (!file_exists($dir)) {
                                    mkdir($dir, 0777, true);
                                }
                                $path = $dir . '/' . $postImage->filename;
                                
                                $picture = Yii::app()->image->load($path);
                                $picture_path = $dir . '/' . $postImage->filename;
                                $picture->save($picture_path);

//                                $thumb = Yii::app()->image->load($path);
//                                $thumb_path = $dir . '/' . $postImage->thumbname;
//                                $thumb->save($thumb_path);
//
//                                $square = Yii::app()->image->load($path);
//                                $square_path = $dir . '/' . $postImage->squarename;
//                                $square->save($square_path);
                                
                                $image->saveAs($path);
                            }
                        }
                    }
                    //          if($model->payment_type == "Cash"){
                    //          	$coaKas = CoaDetail::model()->findByAttributes(array('coa_id'=>3,'branch_id'=>$model->branch_id));
                    //          	if(count($coaKas)!=0){
                    //          		$coaKas->credit += $model->payment_amount;
                    //          	}
                    //          	else{
                    //          		$coaKas = new CoaDetail;
                    //          		$coaKas->coa_id = 3;
                    //          		$coaKas->branch_id = $model->branch_id;
                    //          		$coaKas->credit = $model->payment_amount;
                    //          	}
                    //          	$coaKas->save(false);
                    //          	$jurnalUmum = new JurnalUmum;
                    // 	$jurnalUmum->kode_transaksi = $model->purchaseOrder->purchase_order_no;
                    // 	$jurnalUmum->tanggal_transaksi = $model->purchaseOrder->purchase_order_date;
                    // 	$jurnalUmum->coa_id = 3;
                    // 	$jurnalUmum->total = $model->payment_amount;
                    // 	$jurnalUmum->debet_kredit = 'K';
                    // 	$jurnalUmum->tanggal_posting = date('Y-m-d');
                    // 	$jurnalUmum->save(false);
                    //          }
                    //          else{
                    //          	$coaKasBank = CoaDetail::model()->findByAttributes(array('coa_id'=>$model->purchaseOrder->companyBank->coa->id,'branch_id'=>$model->branch_id));
                    //          	if(count($coaKasBank)!= 0){
                    //          		$coaKasBank->credit += $model->payment_amount;
                    //          	}
                    //          	else{
                    //          		$coaKasBank = new CoaDetail;
                    //          		$coaKasBank->coa_id = $model->purchaseOrder->companyBank->coa->id;
                    //          		$coaKasBank->branch_id = $model->branch_id;
                    //          		$coaKasBank->credit = $model->payment_amount;
                    //          	}
                    //          	$coaKasBank->save(false);
                    //          	$jurnalUmum = new JurnalUmum;
                    // 	$jurnalUmum->kode_transaksi = $model->purchaseOrder->purchase_order_no;
                    // 	$jurnalUmum->tanggal_transaksi = $model->purchaseOrder->purchase_order_date;
                    // 	$jurnalUmum->coa_id = $model->purchaseOrder->companyBank->coa->id;
                    // 	$jurnalUmum->total = $model->payment_amount;
                    // 	$jurnalUmum->debet_kredit = 'K';
                    // 	$jurnalUmum->tanggal_posting = date('Y-m-d');
                    // 	$jurnalUmum->save(false);
                    //          }
                    //          $coaHutang = CoaDetail::model()->findByAttributes(array('coa_id'=>$model->purchaseOrder->supplier->coa->id,'branch_id'=>$model->branch_id));
                    //          if(count($coaHutang)!=0){
                    //          	$coaHutang->debit += $model->payment_amount;
                    //          }
                    //          else{
                    //          	$coaHutang = new CoaDetail;
                    //          	$coaHutang->coa_id = $model->purchaseOrder->supplier->coa->id;
                    //         		$coaHutang->branch_id = $model->branch_id;
                    //         		$coaHutang->debit = $model->payment_amount;
                    //          }
                    //          $coaHutang->save(false);
                    //          $jurnalUmum = new JurnalUmum;
                    // $jurnalUmum->kode_transaksi = $model->purchaseOrder->purchase_order_no;
                    // $jurnalUmum->tanggal_transaksi = $model->purchaseOrder->purchase_order_date;
                    // $jurnalUmum->coa_id = $model->purchaseOrder->supplier->coa->id;
                    // $jurnalUmum->total = $model->payment_amount;
                    // $jurnalUmum->debet_kredit = 'D';
                    // $jurnalUmum->tanggal_posting = date('Y-m-d');
                    // $jurnalUmum->save(false);
                    $this->redirect(array('view', 'id' => $model->id));
                }

                // elseif ($model->purchaseOrder->payment_type == 'Down Payment') {
                // 	$coaDp = CoaDetail::model()->findByAttributes(array('coa_id'=>))
                // }$this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
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

        $purchaseOrder = new TransactionPurchaseOrder('search');
        $purchaseOrder->unsetAttributes();
        
        if (isset($_GET['TransactionPurchaseOrder'])) {
            $purchaseOrder->attributes = $_GET['TransactionPurchaseOrder'];
        }
        
        $purchaseOrderCriteria = new CDbCriteria;
        $purchaseOrderCriteria->addCondition('t.status_document = "Approved" and t.payment_type = "Credit" and t.payment_status != "PAID"');
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
        
        $postImages = PaymentInImages::model()->findAllByAttributes(array(
            'payment_in_id' => $model->id,
            'is_inactive' => $model::STATUS_ACTIVE
        ));
        
        $countPostImage = count($postImages);
        $maxImage = 10;
        $allowedImages = $maxImage - $countPostImage;

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['PaymentOut'])) {
            $model->attributes = $_POST['PaymentOut'];
            $po = TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id);
            if ($po->supplier->coa->id != "") {
                if ($model->save()) {

                    $criteria = new CDbCriteria;

                    $criteria->condition = "purchase_order_id =" . $model->purchase_order_id . " OR id != " . $model->id;
                    $payment = PaymentOut::model()->findAll($criteria);
                    $poData = TransactionPurchaseOrder::model()->findByPk($model->purchase_order_id);

                    if (count($payment) == 0) {
                        $countTotal = $poData->total_price - $model->payment_amount;
                    } else {
                        $countTotal = $poData->payment_left - $model->payment_amount;
                    }

                    if ($countTotal != 0) {
                        $poData->payment_status = 'PARTIALLY PAID';
                    } elseif ($countTotal == 0) {
                        $poData->payment_status = 'PAID';
                    } else {
                        $poData->payment_status = 'NOT PAID';
                    }

                    $poData->payment_amount = $model->payment_amount;
                    $poData->payment_left = $countTotal;
                    $poData->save(false);

                    $images = $model->images = CUploadedFile::getInstances($model, 'images');

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
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
            'allowedImages' => $allowedImages,
            'postImages' => $postImages,
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
        $dataProvider = new CActiveDataProvider('PaymentOut');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
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
                'defaultOrder' => 'payment_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            )
        ));

        $model = new PaymentOut('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['PaymentOut'])) {
            $model->attributes = $_GET['PaymentOut'];
        }

        $this->render('admin', array(
            'model' => $model,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderDataProvider' => $purchaseOrderDataProvider,
        ));
    }

    public function actionAjaxPurchase($id) {
        $payment = PaymentOut::model()->findAllByAttributes(array('purchase_order_id' => $id));
        if (count($payment) == 0) {
            $count = 1;
        } else {
            $count = 2;
        }
        $purchase = TransactionPurchaseOrder::model()->findByPk($id);

        $object = array(
            'po_number' => $purchase->purchase_order_no,
            'po_date' => $purchase->purchase_order_date,
            'status' => $purchase->status_document,
            'total_price' => $purchase->total_price,
            'supplier_id' => $purchase->supplier_id,
            'supplier_name' => $purchase->supplier->name,
            'company' => $purchase->supplier->company,
            'company_attribute' => $purchase->supplier->company_attribute,
            'address' => $purchase->supplier->address,
            'province' => $purchase->supplier->province->name,
            'city' => $purchase->supplier->city->name,
            'zipcode' => $purchase->supplier->zipcode,
            'email_personal' => $purchase->supplier->email_personal,
            'email_company' => $purchase->supplier->email_company,
            'phones' => $purchase->supplier->supplierPhones != "" ? $purchase->supplier->supplierPhones : array(),
            'mobiles' => $purchase->supplier->supplierMobiles != "" ? $purchase->supplier->supplierMobiles : array(),
            'supplier_id' => $purchase->supplier_id,
            'payment_amount' => $purchase->payment_amount,
            'payment_left' => $purchase->payment_left,
            'count' => $count,
        );

        echo CJSON::encode($object);
    }

    public function actionUpdateApproval($headerId) {
//        $dbTransaction = Yii::app()->db->beginTransaction();
//        try {
            $paymentOut = PaymentOut::model()->findByPK($headerId);
            $historis = PaymentOutApproval::model()->findAllByAttributes(array('payment_out_id' => $headerId));
            $model = new PaymentOutApproval;
            $model->date = date('Y-m-d H:i:s');
    //        $branch = Branch::model()->findByPk($paymentOut->branch_id);
            $purchaseOrderHeader = TransactionPurchaseOrder::model()->findByPk($paymentOut->purchase_order_id);
    //        $getCoa = "";
    //        $getCoaDetail = "";

            if (isset($_POST['PaymentOutApproval'])) {
                $model->attributes = $_POST['PaymentOutApproval'];
                if ($model->save()) {
                    $paymentOut->status = $model->approval_type;
                    $paymentOut->save(false);

                    if ($model->approval_type == 'Approved') {
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

                        JurnalUmum::model()->deleteAllByAttributes(array(
                            'kode_transaksi' => $paymentOut->payment_number,
                            'tanggal_transaksi' => $paymentOut->payment_date,
                            'branch_id' => $paymentOut->branch_id,
                        ));

                        $coaHutang = Coa::model()->findByPk($paymentOut->supplier->coa->id);
                        $getcoaHutang = $coaHutang->code;
                        $coaHutangWithCode = Coa::model()->findByAttributes(array('code' => $getcoaHutang));
                        $jurnalHutang = new JurnalUmum;
                        $jurnalHutang->kode_transaksi = $paymentOut->payment_number;
                        $jurnalHutang->tanggal_transaksi = $paymentOut->payment_date;
                        $jurnalHutang->coa_id = $coaHutangWithCode->id;
                        $jurnalHutang->branch_id = $paymentOut->branch_id;
                        $jurnalHutang->total = $paymentOut->payment_amount;
                        $jurnalHutang->debet_kredit = 'D';
                        $jurnalHutang->tanggal_posting = date('Y-m-d');
                        $jurnalHutang->transaction_subject = $paymentOut->supplier->name;
                        $jurnalHutang->is_coa_category = 0;
                        $jurnalHutang->transaction_type = 'Pout';
                        $jurnalHutang->save();

    //                    $priceBefore = $paymentOut->purchaseOrder->ppn == 1 ? $paymentOut->payment_amount / 1.1 : $paymentOut->payment_amount;
    //                    $ppn = $paymentOut->purchaseOrder->ppn == 1 ? $priceBefore * 0.1 : 0;
                        if ($paymentOut->payment_type_id == 1) { 
                            $getCoaKas = '111.00.001';
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
                            $jurnalUmumKasBank = new JurnalUmum;
                            $jurnalUmumKasBank->kode_transaksi = $paymentOut->payment_number;
                            $jurnalUmumKasBank->tanggal_transaksi = $paymentOut->payment_date;
                            $jurnalUmumKasBank->coa_id = $paymentOut->companyBank->coa_id;
                            $jurnalUmumKasBank->branch_id = $paymentOut->branch_id;
                            $jurnalUmumKasBank->total = $paymentOut->payment_amount;
                            $jurnalUmumKasBank->debet_kredit = 'K';
                            $jurnalUmumKasBank->tanggal_posting = date('Y-m-d');
                            $jurnalUmumKasBank->transaction_subject = $paymentOut->supplier->name;
                            $jurnalUmumKasBank->is_coa_category = 0;
                            $jurnalUmumKasBank->transaction_type = 'Pout';
                            $jurnalUmumKasBank->save();
                        }
                    }
                }

                $this->redirect(array('view', 'id' => $headerId));
            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $this->header->addError('error', $e->getMessage());
//        }

        $this->render('updateApproval', array(
            'model' => $model,
            'paymentOut' => $paymentOut,
            'historis' => $historis,
        ));
    }

    public function actionAjaxGetCompanyBank() {
        $branch = Branch::model()->findByPk($_POST['PaymentOut']['branch_id']);
        $company = Company::model()->findByPk($branch->company_id);
        if ($company == null) {
            echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
        } else {
            $data = CompanyBank::model()->findAllByAttributes(array('company_id' => $company->id), array('order' => 'account_name'));

            if (count($data) > 0) {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
                
                foreach ($data as $value => $name) {
                    echo CHtml::tag('option', array('value' => $name->id), CHtml::encode($name->bank->name . " " . $name->account_no . " a/n " . $name->account_name), true);
                }
            } else {
                echo CHtml::tag('option', array('value' => ''), '[--Select Company Bank--]', true);
            }
        }
    }

    /**
     * Performs the AJAX validation.
     * @param PaymentOut $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'payment-out-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}