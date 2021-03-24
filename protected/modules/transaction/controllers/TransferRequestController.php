<?php

class TransferRequestController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'view'
                || $filterChain->action->id === 'create'
                || $filterChain->action->id === 'update'
                || $filterChain->action->id === 'admin'
                || $filterChain->action->id === 'memo') {
            if (!(Yii::app()->user->checkAccess('purchaseCreate') || Yii::app()->user->checkAccess('purchaseEdit')))
                $this->redirect(array('/site/login'));
        }
        if ($filterChain->action->id === 'delete' || $filterChain->action->id === 'admin' || $filterChain->action->id === 'update') {
            if (!(Yii::app()->user->checkAccess('deleteTransaction')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionCreate() {
        $transferRequest = $this->instantiate(null);
        $transferRequest->header->requester_id = Yii::app()->user->id;
        $transferRequest->header->transfer_request_date = date('Y-m-d');
        $transferRequest->header->requester_branch_id = Users::model()->findByPk(Yii::app()->user->id)->branch_id;
        $transferRequest->header->status_document = 'Draft';
        $transferRequest->header->total_quantity =  0;
        $transferRequest->header->total_price = 0;
//        $transferRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($transferRequest->header->transfer_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($transferRequest->header->transfer_request_date)), $transferRequest->header->requester_branch_id);

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        if (isset($_POST['Submit'])) {
            $this->loadState($transferRequest);
            $transferRequest->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($transferRequest->header->transfer_request_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($transferRequest->header->transfer_request_date)), $transferRequest->header->requester_branch_id);
            
            if ($transferRequest->save(Yii::app()->db)) 
                $this->redirect(array('view', 'id' => $transferRequest->header->id));
        }

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        $this->render('create', array(
            'transferRequest' => $transferRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionUpdate($id) {
        $transferRequest = $this->instantiate($id);
        $transferRequest->header->setCodeNumberByRevision('transfer_request_no');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $details = array();
        foreach ($transferRequest->details as $detail) {
            $details[] = $detail;
        }
        $transferRequest->details = $details;

        if (isset($_POST['Submit'])) {
            $this->loadState($transferRequest);

            if ($transferRequest->save(Yii::app()->db))
                $this->redirect(array('view', 'id' => $transferRequest->header->id));
        }

        if (isset($_POST['Cancel'])) 
            $this->redirect(array('admin'));

        $this->render('update', array(
            'transferRequest' => $transferRequest,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
        ));
    }

    public function actionView($id) {
        $transferRequest = $this->loadModel($id);
        $transferDetails = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $id));

        $this->render('view', array(
            'transferRequest' => $transferRequest,
            'transferDetails' => $transferDetails,
        ));
    }


    public function actionUpdateApproval($headerId)
    {
//        $dbTransaction = Yii::app()->db->beginTransaction();
//        try {
            $transferRequest = TransactionTransferRequest::model()->findByPk($headerId);
            $historis = TransactionTransferRequestApproval::model()->findAllByAttributes(array('transfer_request_id' => $headerId));
            $model = new TransactionTransferRequestApproval;
            $model->date = date('Y-m-d H:i:s');

            if (isset($_POST['TransactionTransferRequestApproval'])) {
                $model->attributes = $_POST['TransactionTransferRequestApproval'];

                if ($model->save()) {
                    $transferRequest->status_document = $model->approval_type;

                    if ($model->approval_type == 'Approved') {
                        $transferRequest->approved_by = $model->supervisor_id;
                    }

                    $transferRequest->save(false);

    //                $coaInterMasterGroupbranch = Coa::model()->findByAttributes(array('code' => '107.00.000'));
                    $coaInterbranchRequester = BranchCoaInterbranch::model()->findByAttributes(array(
                        'branch_id_from' => $transferRequest->requester_branch_id, 
                        'branch_id_to' => $transferRequest->destination_branch_id,
                    ));

                    $coaInterbranchDestination = BranchCoaInterbranch::model()->findByAttributes(array(
                        'branch_id_from' => $transferRequest->destination_branch_id, 
                        'branch_id_to' => $transferRequest->requester_branch_id,
                    ));

    //                $jurnalUmumMasterGroupInterbranchRequester = new JurnalUmum;
    //                $jurnalUmumMasterGroupInterbranchRequester->kode_transaksi = $transferRequest->transfer_request_no;
    //                $jurnalUmumMasterGroupInterbranchRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
    //                $jurnalUmumMasterGroupInterbranchRequester->coa_id = $coaInterMasterGroupbranch->id;
    //                $jurnalUmumMasterGroupInterbranchRequester->branch_id = $transferRequest->requester_branch_id;
    //                $jurnalUmumMasterGroupInterbranchRequester->total = $transferRequest->total_price;
    //                $jurnalUmumMasterGroupInterbranchRequester->debet_kredit = 'D';
    //                $jurnalUmumMasterGroupInterbranchRequester->tanggal_posting = date('Y-m-d');
    //                $jurnalUmumMasterGroupInterbranchRequester->transaction_subject = 'Transfer Request';
    //                $jurnalUmumMasterGroupInterbranchRequester->is_coa_category = 1;
    //                $jurnalUmumMasterGroupInterbranchRequester->transaction_type = 'TR';
    //                $jurnalUmumMasterGroupInterbranchRequester->save();

//                    $jurnalUmumMasterInterbranchRequester = new JurnalUmum;
//                    $jurnalUmumMasterInterbranchRequester->kode_transaksi = $transferRequest->transfer_request_no;
//                    $jurnalUmumMasterInterbranchRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
//                    $jurnalUmumMasterInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
//                    $jurnalUmumMasterInterbranchRequester->branch_id = $transferRequest->requester_branch_id;
//                    $jurnalUmumMasterInterbranchRequester->total = $transferRequest->total_price;
//                    $jurnalUmumMasterInterbranchRequester->debet_kredit = 'D';
//                    $jurnalUmumMasterInterbranchRequester->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterInterbranchRequester->transaction_subject = 'Transfer Request';
//                    $jurnalUmumMasterInterbranchRequester->is_coa_category = 1;
//                    $jurnalUmumMasterInterbranchRequester->transaction_type = 'TR';
//                    $jurnalUmumMasterInterbranchRequester->save();

                    $jurnalUmumInterbranchRequester = new JurnalUmum;
                    $jurnalUmumInterbranchRequester->kode_transaksi = $transferRequest->transfer_request_no;
                    $jurnalUmumInterbranchRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
                    $jurnalUmumInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
                    $jurnalUmumInterbranchRequester->branch_id = $transferRequest->requester_branch_id;
                    $jurnalUmumInterbranchRequester->total = $transferRequest->total_price;
                    $jurnalUmumInterbranchRequester->debet_kredit = 'D';
                    $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInterbranchRequester->transaction_subject = 'Transfer Request';
                    $jurnalUmumInterbranchRequester->is_coa_category = 0;
                    $jurnalUmumInterbranchRequester->transaction_type = 'TR';
                    $jurnalUmumInterbranchRequester->save();

    //                $jurnalUmumMasterGroupInterbranchDestination = new JurnalUmum;
    //                $jurnalUmumMasterGroupInterbranchDestination->kode_transaksi = $transferRequest->transfer_request_no;
    //                $jurnalUmumMasterGroupInterbranchDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
    //                $jurnalUmumMasterGroupInterbranchDestination->coa_id = $coaInterMasterGroupbranch->id;
    //                $jurnalUmumMasterGroupInterbranchDestination->branch_id = $transferRequest->destination_branch_id;
    //                $jurnalUmumMasterGroupInterbranchDestination->total = $transferRequest->total_price;
    //                $jurnalUmumMasterGroupInterbranchDestination->debet_kredit = 'K';
    //                $jurnalUmumMasterGroupInterbranchDestination->tanggal_posting = date('Y-m-d');
    //                $jurnalUmumMasterGroupInterbranchDestination->transaction_subject = 'Transfer Request';
    //                $jurnalUmumMasterGroupInterbranchDestination->is_coa_category = 1;
    //                $jurnalUmumMasterGroupInterbranchDestination->transaction_type = 'TR';
    //                $jurnalUmumMasterGroupInterbranchDestination->save();

    //                $jurnalUmumMasterInterbranchDestination = new JurnalUmum;
    //                $jurnalUmumMasterInterbranchDestination->kode_transaksi = $transferRequest->transfer_request_no;
    //                $jurnalUmumMasterInterbranchDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
    //                $jurnalUmumMasterInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
    //                $jurnalUmumMasterInterbranchDestination->branch_id = $transferRequest->destination_branch_id;
    //                $jurnalUmumMasterInterbranchDestination->total = $transferRequest->total_price;
    //                $jurnalUmumMasterInterbranchDestination->debet_kredit = 'K';
    //                $jurnalUmumMasterInterbranchDestination->tanggal_posting = date('Y-m-d');
    //                $jurnalUmumMasterInterbranchDestination->transaction_subject = 'Transfer Request';
    //                $jurnalUmumMasterInterbranchDestination->is_coa_category = 1;
    //                $jurnalUmumMasterInterbranchDestination->transaction_type = 'TR';
    //                $jurnalUmumMasterInterbranchDestination->save();
    //
                    $jurnalUmumInterbranchDestination = new JurnalUmum;
                    $jurnalUmumInterbranchDestination->kode_transaksi = $transferRequest->transfer_request_no;
                    $jurnalUmumInterbranchDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
                    $jurnalUmumInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
                    $jurnalUmumInterbranchDestination->branch_id = $transferRequest->destination_branch_id;
                    $jurnalUmumInterbranchDestination->total = $transferRequest->total_price;
                    $jurnalUmumInterbranchDestination->debet_kredit = 'K';
                    $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInterbranchDestination->transaction_subject = 'Transfer Request';
                    $jurnalUmumInterbranchDestination->is_coa_category = 0;
                    $jurnalUmumInterbranchDestination->transaction_type = 'TR';
                    $jurnalUmumInterbranchDestination->save();
    //                
//                    $coaOutstanding = Coa::model()->findByPk($transferRequest->supplier->coaOutstandingOrder->id);
//                    $getCoaOutstanding = $coaOutstanding->code;
//                    $coaOutstandingOrder = Coa::model()->findByAttributes(array('code' => $getCoaOutstanding));
//                    $jurnalUmumOutstandingOrderDestination = new JurnalUmum;
//                    $jurnalUmumOutstandingOrderDestination->kode_transaksi = $transferRequest->transfer_request_no;
//                    $jurnalUmumOutstandingOrderDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
//                    $jurnalUmumOutstandingOrderDestination->coa_id = $coaOutstandingOrder->id;
//                    $jurnalUmumOutstandingOrderDestination->branch_id = $transferRequest->destination_branch_id;
//                    $jurnalUmumOutstandingOrderDestination->total = $transferRequest->total_price;
//                    $jurnalUmumOutstandingOrderDestination->debet_kredit = 'D';
//                    $jurnalUmumOutstandingOrderDestination->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumOutstandingOrderDestination->transaction_subject = 'Transfer Request';
//                    $jurnalUmumOutstandingOrderDestination->is_coa_category = 0;
//                    $jurnalUmumOutstandingOrderDestination->transaction_type = 'TR';
//                    $jurnalUmumOutstandingOrderDestination->save();

                    foreach ($transferRequest->transactionTransferRequestDetails as $detail) {
                        $transferRequestDetail = TransactionTransferRequestDetail::model()->findByAttributes(array('id' => $detail->id, 'transfer_request_id' => $transferRequest->id));
                        $transferRequestDetail->quantity_delivery_left = $detail->quantity - $detail->quantity_delivery;
                        $transferRequestDetail->quantity_delivery = $detail->quantity_delivery;
                        $left_quantity = $transferRequestDetail->quantity_delivery_left;
                        $transferRequestDetail->save(false);
    //                    $detail->quantity_receive_left = $detail->quantity_delivery;

                        $transfer = TransactionTransferRequest::model()->findByPk($transferRequest->id);
                        $branch = Branch::model()->findByPk($transferRequest->requester_branch_id);
                        $hppPrice = $detail->product->hpp * $detail->quantity_delivery;

    //                    $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
    //                    $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
    //                    $jurnalUmumMasterGroupPersediaan->kode_transaksi = $transferRequest->transfer_request_no;
    //                    $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $transferRequest->transfer_request_date;
    //                    $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
    //                    $jurnalUmumMasterGroupPersediaan->branch_id = $transferRequest->requester_branch_id;
    //                    $jurnalUmumMasterGroupPersediaan->total = $hppPrice;
    //                    $jurnalUmumMasterGroupPersediaan->debet_kredit = 'K';
    //                    $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
    //                    $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Transfer Request';
    //                    $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
    //                    $jurnalUmumMasterGroupPersediaan->transaction_type = 'TR';
    //                    $jurnalUmumMasterGroupPersediaan->save();

                        //save coa persediaan product master
                        $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                        $jurnalUmumMasterOutstandingPart->kode_transaksi = $transferRequest->transfer_request_no;
                        $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $transferRequest->transfer_request_date;
                        $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                        $jurnalUmumMasterOutstandingPart->branch_id = $transferRequest->requester_branch_id;
                        $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                        $jurnalUmumMasterOutstandingPart->debet_kredit = 'K';
                        $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterOutstandingPart->transaction_subject = 'Transfer Request';
                        $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                        $jurnalUmumMasterOutstandingPart->transaction_type = 'TR';
                        $jurnalUmumMasterOutstandingPart->save();

                        //save coa persedian product sub master
                        $jurnalUmumOutstandingPart = new JurnalUmum;
                        $jurnalUmumOutstandingPart->kode_transaksi = $transferRequest->transfer_request_no;
                        $jurnalUmumOutstandingPart->tanggal_transaksi = $transferRequest->transfer_request_date;
                        $jurnalUmumOutstandingPart->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                        $jurnalUmumOutstandingPart->branch_id = $transferRequest->requester_branch_id;
                        $jurnalUmumOutstandingPart->total = $hppPrice;
                        $jurnalUmumOutstandingPart->debet_kredit = 'K';
                        $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                        $jurnalUmumOutstandingPart->transaction_subject = 'Transfer Request';
                        $jurnalUmumOutstandingPart->is_coa_category = 0;
                        $jurnalUmumOutstandingPart->transaction_type = 'TR';
                        $jurnalUmumOutstandingPart->save();
                    }

                    $this->redirect(array('view', 'id' => $headerId));
                }
            }
//        } catch (Exception $e) {
//            $dbTransaction->rollback();
//            $this->header->addError('error', $e->getMessage());
//        }

        $this->render('updateApproval', array(
            'model' => $model,
            'transferRequest' => $transferRequest,
            'historis' => $historis,
        ));
    }

    public function actionAdmin() {
        $model = new TransactionTransferRequest('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionTransferRequest'])) {
            $model->attributes = $_GET['TransactionTransferRequest'];
        }

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->instantiate($id);

            if ($model->header->purchaseReturnHeaders != NULL || $model->header->receiveHeaders != NULL) {
                Yii::app()->user->setFlash('message', 'Cannot DELETE this transaction');
            } else {
                foreach ($model->details as $detail) 
                    $detail->delete();
                
                $model->header->delete();
            }
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionAjaxJsonTotal($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $transferRequest = $this->instantiate($id);
            $this->loadState($transferRequest);

            $unitPrice = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($transferRequest->details[$index], 'unit_price')));
            $total = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($transferRequest->details[$index], 'total')));
            $totalQuantity = CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transferRequest->totalQuantity));
            $grandTotal = CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $transferRequest->getGrandTotal()));

            echo CJSON::encode(array(
                'unitPrice' => $unitPrice,
                'total' => $total,
                'totalQuantity' => $totalQuantity,
                'grandTotal' => $grandTotal,
            ));
        }
    }

    public function actionAjaxHtmlAddDetail($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $transferRequest = $this->instantiate($id);
            $this->loadState($transferRequest);

            if (isset($_POST['ProductId']))
                $transferRequest->addDetail($_POST['ProductId']);

            $this->renderPartial('_detail', array(
                'transferRequest' => $transferRequest,
            ));
        }
    }

    public function actionAjaxHtmlRemoveProduct($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $transferRequest = $this->instantiate($id);
            $this->loadState($transferRequest);

            $transferRequest->removeDetailAt($index);

            $this->renderPartial('_detail', array(
                'transferRequest' => $transferRequest,
            ));
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
    
    public function instantiate($id) {
        if (empty($id))
            $transferRequest = new TransferRequest(new TransactionTransferRequest(), array());
        else {
            $transferRequestHeader = $this->loadModel($id);
            $transferRequest = new TransferRequest($transferRequestHeader, $transferRequestHeader->transactionTransferRequestDetails);
        }

        return $transferRequest;
    }

    public function loadModel($id) {
        $model = TransactionTransferRequest::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function loadState($transferRequest) {
        if (isset($_POST['TransactionTransferRequest'])) {
            $transferRequest->header->attributes = $_POST['TransactionTransferRequest'];
        }
        if (isset($_POST['TransactionTransferRequestDetail'])) {
            foreach ($_POST['TransactionTransferRequestDetail'] as $i => $item) {
                if (isset($transferRequest->details[$i]))
                    $transferRequest->details[$i]->attributes = $item;
                else {
                    $detail = new TransactionTransferRequestDetail();
                    $detail->attributes = $item;
                    $transferRequest->details[] = $detail;
                }
            }
            if (count($_POST['TransactionTransferRequestDetail']) < count($transferRequest->details))
                array_splice($transferRequest->details, $i + 1);
        }
        else
            $transferRequest->details = array();
    }
}
