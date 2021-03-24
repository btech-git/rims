<?php

class TransactionSentRequestController extends Controller
{
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
        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'create' || 
            $filterChain->action->id === 'delete' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'updateApproval' || 
            $filterChain->action->id === 'view' || 
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('sentRequestCreate')) || !(Yii::app()->user->checkAccess('sentRequestEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $sentDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $id));

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'sentDetails' => $sentDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('t.name', $product->name, true);
        $productCriteria->compare('t.manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->compare('t.brand_id', $product->brand_id);
        $productCriteria->compare('t.sub_brand_id', $product->sub_brand_id);
        $productCriteria->compare('t.sub_brand_series_id', $product->sub_brand_series_id);
        $productCriteria->compare('t.product_master_category_id', $product->product_master_category_id);
        $productCriteria->compare('t.product_sub_master_category_id', $product->product_sub_master_category_id);
        $productCriteria->compare('t.product_sub_category_id', $product->product_sub_category_id);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));

        $sentRequest = $this->instantiate(null);
        $sentRequest->header->requester_branch_id = $sentRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $sentRequest->header->requester_branch_id;
        $sentRequest->header->sent_request_date = date('Y-m-d H:i:s');
//        $sentRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($sentRequest->header->sent_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($sentRequest->header->sent_request_date)), $sentRequest->header->requester_branch_id);
        $this->performAjaxValidation($sentRequest->header);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['TransactionSentRequest'])) {
            $this->loadState($sentRequest);
            $sentRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($sentRequest->header->sent_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($sentRequest->header->sent_request_date)), $sentRequest->header->requester_branch_id);

            if ($sentRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $sentRequest->header->id));
            }
        }

        $this->render('create', array(
            'sentRequest' => $sentRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        // $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        // if(isset($_POST['TransactionSentRequest']))
        // {
        // 	$model->attributes=$_POST['TransactionSentRequest'];
        // 	if($model->save())
        // 		$this->redirect(array('view','id'=>$model->id));
        // }

        // $this->render('update',array(
        // 	'model'=>$model,
        // ));

        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values
        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productCriteria = new CDbCriteria;
        $productCriteria->compare('name', $product->name, true);
        $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
        $productCriteria->together = true;
        $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
        $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
        $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name, true);
        $productCriteria->compare('rims_product_sub_master_category.name', $product->product_sub_master_category_name,
            true);
        $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
        $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
        $productDataProvider = new CActiveDataProvider('Product', array(
            'criteria' => $productCriteria,
        ));
        //
        $sentRequest = $this->instantiate($id);
        $sentRequest->header->setCodeNumberByRevision('sent_request_no');

        $this->performAjaxValidation($sentRequest->header);

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionSentRequest'])) {
            $this->loadState($sentRequest);
            if ($sentRequest->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $sentRequest->header->id));
            } else {
                foreach ($sentRequest->details as $detail) {
                    echo $detail->quantity;
                }
            }
        }

        $this->render('update', array(
            'sentRequest' => $sentRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionUpdateApproval($headerId)
    {
        $sentRequest = TransactionSentRequest::model()->findByPk($headerId);
        $historis = TransactionSentRequestApproval::model()->findAllByAttributes(array('sent_request_id' => $headerId));
        $model = new TransactionSentRequestApproval;
        $model->date = date('Y-m-d H:i:s');
        
        if (isset($_POST['TransactionSentRequestApproval'])) {
            $model->attributes = $_POST['TransactionSentRequestApproval'];

            if ($model->save()) {
                $sentRequest->status_document = $model->approval_type;
                if ($model->approval_type == 'Approved') {
                    $sentRequest->approved_by = $model->supervisor_id;
                }
                $sentRequest->save(false);
                
                $coaInterMasterGroupbranch = Coa::model()->findByAttributes(array('code' => '107.00.000'));
                $jurnalUmumMasterGroupInterbranchRequester = new JurnalUmum;
                $jurnalUmumMasterGroupInterbranchRequester->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumMasterGroupInterbranchRequester->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumMasterGroupInterbranchRequester->coa_id = $coaInterMasterGroupbranch->id;
                $jurnalUmumMasterGroupInterbranchRequester->branch_id = $sentRequest->requester_branch_id;
                $jurnalUmumMasterGroupInterbranchRequester->total = $sentRequest->total_price;
                $jurnalUmumMasterGroupInterbranchRequester->debet_kredit = 'D';
                $jurnalUmumMasterGroupInterbranchRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterGroupInterbranchRequester->transaction_subject = 'Sent Request';
                $jurnalUmumMasterGroupInterbranchRequester->is_coa_category = 1;
                $jurnalUmumMasterGroupInterbranchRequester->transaction_type = 'SR';
                $jurnalUmumMasterGroupInterbranchRequester->save();
                
                $jurnalUmumMasterInterbranchRequester = new JurnalUmum;
                $jurnalUmumMasterInterbranchRequester->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumMasterInterbranchRequester->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumMasterInterbranchRequester->coa_id = $sentRequest->requesterBranch->coa_interbranch_inventory;
                $jurnalUmumMasterInterbranchRequester->branch_id = $sentRequest->requester_branch_id;
                $jurnalUmumMasterInterbranchRequester->total = $sentRequest->total_price;
                $jurnalUmumMasterInterbranchRequester->debet_kredit = 'D';
                $jurnalUmumMasterInterbranchRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterInterbranchRequester->transaction_subject = 'Sent Request';
                $jurnalUmumMasterInterbranchRequester->is_coa_category = 1;
                $jurnalUmumMasterInterbranchRequester->transaction_type = 'SR';
                $jurnalUmumMasterInterbranchRequester->save();

                $jurnalUmumInterbranchRequester = new JurnalUmum;
                $jurnalUmumInterbranchRequester->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumInterbranchRequester->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumInterbranchRequester->coa_id = $sentRequest->requesterBranch->coa_interbranch_inventory;
                $jurnalUmumInterbranchRequester->branch_id = $sentRequest->requester_branch_id;
                $jurnalUmumInterbranchRequester->total = $sentRequest->total_price;
                $jurnalUmumInterbranchRequester->debet_kredit = 'D';
                $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumInterbranchRequester->transaction_subject = 'Sent Request';
                $jurnalUmumInterbranchRequester->is_coa_category = 0;
                $jurnalUmumInterbranchRequester->transaction_type = 'SR';
                $jurnalUmumInterbranchRequester->save();
                
                $jurnalUmumMasterGroupInterbranchDestination = new JurnalUmum;
                $jurnalUmumMasterGroupInterbranchDestination->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumMasterGroupInterbranchDestination->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumMasterGroupInterbranchDestination->coa_id = $coaInterMasterGroupbranch->id;
                $jurnalUmumMasterGroupInterbranchDestination->branch_id = $sentRequest->destination_branch_id;
                $jurnalUmumMasterGroupInterbranchDestination->total = $sentRequest->total_price;
                $jurnalUmumMasterGroupInterbranchDestination->debet_kredit = 'K';
                $jurnalUmumMasterGroupInterbranchDestination->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterGroupInterbranchDestination->transaction_subject = 'Sent Request';
                $jurnalUmumMasterGroupInterbranchDestination->is_coa_category = 1;
                $jurnalUmumMasterGroupInterbranchDestination->transaction_type = 'SR';
                $jurnalUmumMasterGroupInterbranchDestination->save();
                
                $jurnalUmumMasterInterbranchDestination = new JurnalUmum;
                $jurnalUmumMasterInterbranchDestination->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumMasterInterbranchDestination->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumMasterInterbranchDestination->coa_id = $sentRequest->destinationBranch->coa_interbranch_inventory;
                $jurnalUmumMasterInterbranchDestination->branch_id = $sentRequest->destination_branch_id;
                $jurnalUmumMasterInterbranchDestination->total = $sentRequest->total_price;
                $jurnalUmumMasterInterbranchDestination->debet_kredit = 'K';
                $jurnalUmumMasterInterbranchDestination->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterInterbranchDestination->transaction_subject = 'Sent Request';
                $jurnalUmumMasterInterbranchDestination->is_coa_category = 1;
                $jurnalUmumMasterInterbranchDestination->transaction_type = 'SR';
                $jurnalUmumMasterInterbranchDestination->save();

                $jurnalUmumInterbranchDestination = new JurnalUmum;
                $jurnalUmumInterbranchDestination->kode_transaksi = $sentRequest->sent_request_no;
                $jurnalUmumInterbranchDestination->tanggal_transaksi = $sentRequest->sent_request_date;
                $jurnalUmumInterbranchDestination->coa_id = $sentRequest->destinationBranch->coa_interbranch_inventory;
                $jurnalUmumInterbranchDestination->branch_id = $sentRequest->destination_branch_id;
                $jurnalUmumInterbranchDestination->total = $sentRequest->total_price;
                $jurnalUmumInterbranchDestination->debet_kredit = 'K';
                $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
                $jurnalUmumInterbranchDestination->transaction_subject = 'Sent Request';
                $jurnalUmumInterbranchDestination->is_coa_category = 0;
                $jurnalUmumInterbranchDestination->transaction_type = 'SR';
                $jurnalUmumInterbranchDestination->save();
                
//                $coaOutstandingOrder = Coa::model()->findByAttributes(array('code' => '202.00.000'));
//                $jurnalUmumOutstandingOrderDestination = new JurnalUmum;
//                $jurnalUmumOutstandingOrderDestination->kode_transaksi = $sentRequest->sent_request_no;
//                $jurnalUmumOutstandingOrderDestination->tanggal_transaksi = $sentRequest->sent_request_date;
//                $jurnalUmumOutstandingOrderDestination->coa_id = $coaOutstandingOrder->id;
//                $jurnalUmumOutstandingOrderDestination->branch_id = $sentRequest->destination_branch_id;
//                $jurnalUmumOutstandingOrderDestination->total = $sentRequest->total_price;
//                $jurnalUmumOutstandingOrderDestination->debet_kredit = 'D';
//                $jurnalUmumOutstandingOrderDestination->tanggal_posting = date('Y-m-d');
//                $jurnalUmumOutstandingOrderDestination->transaction_subject = 'Sent Request';
//                $jurnalUmumOutstandingOrderDestination->is_coa_category = 0;
//                $jurnalUmumOutstandingOrderDestination->transaction_type = 'SR';
//                $jurnalUmumOutstandingOrderDestination->save();
                
                foreach ($sentRequest->transactionSentRequestDetails as $detail) {
//                    
//                    $sentRequestDetail = TransactionTransferRequestDetail::model()->findByAttributes(array('id' => $detail->transfer_request_detail_id, 'transfer_request_id' => $sentRequest->transfer_request_id));
//                    $sentRequestDetail->quantity_delivery_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
//                    $sentRequestDetail->quantity_delivery = $quantity + $detail->quantity_delivery;
//                    $left_quantity = $sentRequestDetail->quantity_delivery_left;
//                    $sentRequestDetail->save(false);
//                    $detail->quantity_receive_left = $detail->quantity_delivery;
//
//                    $transfer = TransactionTransferRequest::model()->findByPk($sentRequest->transfer_request_id);
//                    $branch = Branch::model()->findByPk($sentRequest->sender_branch_id);
//
//                    $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
//                    $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
//                    $jurnalUmumMasterGroupPersediaan->kode_transaksi = $sentRequest->sent_request_no;
//                    $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $sentRequest->sent_request_date;
//                    $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
//                    $jurnalUmumMasterGroupPersediaan->branch_id = $sentRequest->sender_branch_id;
//                    $jurnalUmumMasterGroupPersediaan->total = $hppPrice;
//                    $jurnalUmumMasterGroupPersediaan->debet_kredit = 'K';
//                    $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Sent Request';
//                    $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
//                    $jurnalUmumMasterGroupPersediaan->transaction_type = 'SR';
//                    $jurnalUmumMasterGroupPersediaan->save();
//
//                    //save coa persediaan product master
                    $hppPrice = $detail->product->hpp * $detail->quantity_delivery;
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $sentRequest->sent_request_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $sentRequest->sent_request_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_persediaan_barang_dagang;
                    $jurnalUmumMasterOutstandingPart->branch_id = $sentRequest->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'K';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = 'Sent Request';
                    $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                    $jurnalUmumMasterOutstandingPart->transaction_type = 'SR';
                    $jurnalUmumMasterOutstandingPart->save();
//
//                    //save coa persedian product sub master
                    $jurnalUmumOutstandingPart = new JurnalUmum;
                    $jurnalUmumOutstandingPart->kode_transaksi = $sentRequest->sent_request_no;
                    $jurnalUmumOutstandingPart->tanggal_transaksi = $sentRequest->sent_request_date;
                    $jurnalUmumOutstandingPart->coa_id = $detail->product->productSubMasterCategory->coa_persediaan_barang_dagang;
                    $jurnalUmumOutstandingPart->branch_id = $sentRequest->sender_branch_id;
                    $jurnalUmumOutstandingPart->total = $hppPrice;
                    $jurnalUmumOutstandingPart->debet_kredit = 'K';
                    $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumOutstandingPart->transaction_subject = 'Sent Request';
                    $jurnalUmumOutstandingPart->is_coa_category = 0;
                    $jurnalUmumOutstandingPart->transaction_type = 'SR';
                    $jurnalUmumOutstandingPart->save();
                }
                
                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'sentRequest' => $sentRequest,
            //'sentRequestDetail'=>$sentRequestDetail,
            'historis' => $historis,
            //'jenisPersediaan'=>$jenisPersediaan,
            //'jenisPersediaanDataProvider'=>$jenisPersediaanDataProvider,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('TransactionSentRequest');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new TransactionSentRequest('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionSentRequest'])) {
            $model->attributes = $_GET['TransactionSentRequest'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionSentRequest the loaded model
     * @throws CHttpException
     */

    public function actionAjaxProduct($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = Product::model()->findByPk($id);
            $unitName = Unit::model()->findByPk($product->unit_id)->name;

            $object = array(
                'id' => $product->id,
                'name' => $product->name,
                'retail_price' => $product->retail_price,
                'hpp' => $product->hpp,
                'unit' => $product->unit_id,
                'unit_name' => $unitName,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxGetTotal($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);
            //$requestType =$sentRequest->header->request_type;
            $total = 0;
            $totalItems = 0;
            // if($requestType == 'Request for Purchase'){
            // 	foreach ($sentRequest->details as $key => $detail) {
            // 		$totalItems += $detail->total;
            // 		$total += $detail->subtotal;_quantity;
            // 	}
            // } else if($requestType == 'Request for Transfer'){
            // 	foreach ($sentRequest->transferDetails as $key => $transferDetail) {
            // 		$totalItems += $transferDetail->quantity;
            // 	}
            // }
            foreach ($sentRequest->details as $key => $detail) {
                $totalItems += $detail->quantity;
                $total += $detail->unit_price * $totalItems;
            }
            //echo($totalItems);
            $object = array('total' => $total, 'totalItems' => $totalItems);
            echo CJSON::encode($object);

        }

    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);

            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $sentRequest->totalQuantity));

            echo CJSON::encode(array(
                'totalQuantity' => $totalQuantity,
            ));
        }
    }

    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $productId)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

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
                'criteria' => $productCriteria,
            ));

            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);

            $sentRequest->addDetail($productId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.yiigridview.js'] = false;
            $this->renderPartial('_detail', array(
                'sentRequest' => $sentRequest,
                'product' => $product,
//                'productDataProvider' => $productDataProvider,

            ), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index)
    {
        if (Yii::app()->request->isAjaxRequest) {

            $product = new Product('search');
            $product->unsetAttributes();  // clear any default values
            if (isset($_GET['Product'])) {
                $product->attributes = $_GET['Product'];
            }

            $productCriteria = new CDbCriteria;
            $productCriteria->compare('name', $product->name, true);
            $productCriteria->compare('manufacturer_code', $product->manufacturer_code, true);
            $productCriteria->together = true;
            $productCriteria->select = 't.*, rims_product_master_category.name as product_master_category_name, rims_product_sub_master_category.name as product_sub_master_category_name, rims_product_sub_category.name as product_sub_category_name, rims_brand.name as product_brand_name';
            $productCriteria->join = 'join rims_product_master_category on rims_product_master_category.id = t.product_master_category_id join rims_product_sub_master_category on rims_product_sub_master_category.id = t.product_sub_master_category_id join rims_product_sub_category on rims_product_sub_category.id = t.product_sub_category_id join rims_brand on rims_brand.id = t.brand_id ';
            $productCriteria->compare('rims_product_master_category.name', $product->product_master_category_name,
                true);
            $productCriteria->compare('rims_product_sub_master_category.name',
                $product->product_sub_master_category_name, true);
            $productCriteria->compare('rims_product_sub_category.name', $product->product_sub_category_name, true);
            $productCriteria->compare('rims_brand.name', $product->product_brand_name, true);
            $productDataProvider = new CActiveDataProvider('Product', array(
                'criteria' => $productCriteria,
            ));

            $sentRequest = $this->instantiate($id);
            $this->loadState($sentRequest);

            $sentRequest->removeDetailAt($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detailSentRequest', array(
                'sentRequest' => $sentRequest,
                'product' => $product,
                'productDataProvider' => $productDataProvider,

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
            $sentRequest = new SentRequests(new TransactionSentRequest(), array());
            //print_r("test");
        } else {
            $sentRequestModel = $this->loadModel($id);
            $sentRequest = new SentRequests($sentRequestModel, $sentRequestModel->transactionSentRequestDetails);
            //print_r("test");
        }
        return $sentRequest;
    }

    public function loadState($sentRequest)
    {
        if (isset($_POST['TransactionSentRequest'])) {
            $sentRequest->header->attributes = $_POST['TransactionSentRequest'];
        }


        if (isset($_POST['TransactionSentRequestDetail'])) {
            foreach ($_POST['TransactionSentRequestDetail'] as $i => $item) {
                if (isset($sentRequest->details[$i])) {
                    $sentRequest->details[$i]->attributes = $item;

                } else {
                    $detail = new TransactionSentRequestDetail();
                    $detail->attributes = $item;
                    $sentRequest->details[] = $detail;

                }
            }
            if (count($_POST['TransactionSentRequestDetail']) < count($sentRequest->details)) {
                array_splice($sentRequest->details, $i + 1);
            }
        } else {
            $sentRequest->details = array();

        }


    }

    public function loadModel($id)
    {
        $model = TransactionSentRequest::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionSentRequest $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-sent-request-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
