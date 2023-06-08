<?php

class TransferRequestController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('transferRequestCreate')))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'update') {
            if (!Yii::app()->user->checkAccess('transferRequestEdit'))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'updateApproval') {
            if (!Yii::app()->user->checkAccess('transferRequestApproval'))
                $this->redirect(array('/site/login'));
        }
        
        if ($filterChain->action->id === 'view'
            || $filterChain->action->id === 'admin'
            || $filterChain->action->id === 'memo'
        ) {
            if (!(Yii::app()->user->checkAccess('transferRequestCreate')) || !(Yii::app()->user->checkAccess('transferRequestEdit')) || !(Yii::app()->user->checkAccess('transferRequestEdit')))
                $this->redirect(array('/site/login'));
        }
        
        $filterChain->run();
    }

    public function actionCreate() {
        $transferRequest = $this->instantiate(null);
        $transferRequest->header->requester_id = Yii::app()->user->id;
        $transferRequest->header->transfer_request_date = date('Y-m-d');
        $transferRequest->header->created_datetime = date('Y-m-d H:i:s');
        $transferRequest->header->requester_branch_id = Users::model()->findByPk(Yii::app()->user->id)->branch_id;
        $transferRequest->header->status_document = 'Draft';
        $transferRequest->header->total_quantity =  0;
        $transferRequest->header->total_price = 0;

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
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

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();

        $details = array();
        foreach ($transferRequest->details as $detail) {
            $details[] = $detail;
        }
        $transferRequest->details = $details;

        if (isset($_POST['Submit']) && IdempotentManager::check()) {
            $this->loadState($transferRequest);

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $transferRequest->header->transfer_request_no,
            ));

            $transferRequest->header->setCodeNumberByRevision('transfer_request_no');
        
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

        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $transferRequest->transfer_request_no,
            ));

            $coaInterbranchRequester = BranchCoaInterbranch::model()->findByAttributes(array(
                'branch_id_from' => $transferRequest->requester_branch_id, 
                'branch_id_to' => $transferRequest->destination_branch_id,
            ));

            $jurnalUmumInterbranchRequester = new JurnalUmum;
            $jurnalUmumInterbranchRequester->kode_transaksi = $transferRequest->transfer_request_no;
            $jurnalUmumInterbranchRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
            $jurnalUmumInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
            $jurnalUmumInterbranchRequester->branch_id = $transferRequest->requester_branch_id;
            $jurnalUmumInterbranchRequester->total = $transferRequest->total_price;
            $jurnalUmumInterbranchRequester->debet_kredit = 'D';
            $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
            $jurnalUmumInterbranchRequester->transaction_subject = 'Transfer Request Main';
            $jurnalUmumInterbranchRequester->is_coa_category = 0;
            $jurnalUmumInterbranchRequester->transaction_type = 'TR';
            $jurnalUmumInterbranchRequester->save();

            foreach ($transferRequest->transactionTransferRequestDetails as $detail) {
                $hppPrice = $detail->unit_price * $detail->quantity;

                //save coa persediaan product master
                $jurnalUmumMasterOutstandingPartRequester = new JurnalUmum;
                $jurnalUmumMasterOutstandingPartRequester->kode_transaksi = $transferRequest->transfer_request_no;
                $jurnalUmumMasterOutstandingPartRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
                $jurnalUmumMasterOutstandingPartRequester->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPartRequester->branch_id = $transferRequest->requester_branch_id;
                $jurnalUmumMasterOutstandingPartRequester->total = $hppPrice;
                $jurnalUmumMasterOutstandingPartRequester->debet_kredit = 'K';
                $jurnalUmumMasterOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPartRequester->transaction_subject = 'Transfer Request Main';
                $jurnalUmumMasterOutstandingPartRequester->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPartRequester->transaction_type = 'TR';
                $jurnalUmumMasterOutstandingPartRequester->save();

                //save coa persedian product sub master
                $jurnalUmumOutstandingPartRequester = new JurnalUmum;
                $jurnalUmumOutstandingPartRequester->kode_transaksi = $transferRequest->transfer_request_no;
                $jurnalUmumOutstandingPartRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
                $jurnalUmumOutstandingPartRequester->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPartRequester->branch_id = $transferRequest->requester_branch_id;
                $jurnalUmumOutstandingPartRequester->total = $hppPrice;
                $jurnalUmumOutstandingPartRequester->debet_kredit = 'K';
                $jurnalUmumOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPartRequester->transaction_subject = 'Transfer Request Main';
                $jurnalUmumOutstandingPartRequester->is_coa_category = 0;
                $jurnalUmumOutstandingPartRequester->transaction_type = 'TR';
                $jurnalUmumOutstandingPartRequester->save();

            }

            $coaInterbranchDestination = BranchCoaInterbranch::model()->findByAttributes(array(
                'branch_id_from' => $transferRequest->destination_branch_id, 
                'branch_id_to' => $transferRequest->requester_branch_id,
            ));

            $jurnalUmumInterbranchDestination = new JurnalUmum;
            $jurnalUmumInterbranchDestination->kode_transaksi = $transferRequest->transfer_request_no;
            $jurnalUmumInterbranchDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
            $jurnalUmumInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
            $jurnalUmumInterbranchDestination->branch_id = $transferRequest->destination_branch_id;
            $jurnalUmumInterbranchDestination->total = $transferRequest->total_price;
            $jurnalUmumInterbranchDestination->debet_kredit = 'K';
            $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
            $jurnalUmumInterbranchDestination->transaction_subject = 'Transfer Request Destination';
            $jurnalUmumInterbranchDestination->is_coa_category = 0;
            $jurnalUmumInterbranchDestination->transaction_type = 'TR';
            $jurnalUmumInterbranchDestination->save();

            foreach ($transferRequest->transactionTransferRequestDetails as $detail) {
                $hppPrice = $detail->unit_price * $detail->quantity;

                //save coa persediaan product master
                $jurnalUmumMasterOutstandingPartDestination = new JurnalUmum;
                $jurnalUmumMasterOutstandingPartDestination->kode_transaksi = $transferRequest->transfer_request_no;
                $jurnalUmumMasterOutstandingPartDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
                $jurnalUmumMasterOutstandingPartDestination->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPartDestination->branch_id = $transferRequest->destination_branch_id;
                $jurnalUmumMasterOutstandingPartDestination->total = $hppPrice;
                $jurnalUmumMasterOutstandingPartDestination->debet_kredit = 'D';
                $jurnalUmumMasterOutstandingPartDestination->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPartDestination->transaction_subject = 'Transfer Request Destination';
                $jurnalUmumMasterOutstandingPartDestination->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPartDestination->transaction_type = 'TR';
                $jurnalUmumMasterOutstandingPartDestination->save();

                //save coa persedian product sub master
                $jurnalUmumOutstandingPartDestination = new JurnalUmum;
                $jurnalUmumOutstandingPartDestination->kode_transaksi = $transferRequest->transfer_request_no;
                $jurnalUmumOutstandingPartDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
                $jurnalUmumOutstandingPartDestination->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPartDestination->branch_id = $transferRequest->destination_branch_id;
                $jurnalUmumOutstandingPartDestination->total = $hppPrice;
                $jurnalUmumOutstandingPartDestination->debet_kredit = 'D';
                $jurnalUmumOutstandingPartDestination->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPartDestination->transaction_subject = 'Transfer Request Destination';
                $jurnalUmumOutstandingPartDestination->is_coa_category = 0;
                $jurnalUmumOutstandingPartDestination->transaction_type = 'TR';
                $jurnalUmumOutstandingPartDestination->save();
            }

            $this->redirect(array('view', 'id' => $id));
        }

        $this->render('view', array(
            'transferRequest' => $transferRequest,
            'transferDetails' => $transferDetails,
        ));
    }

    public function actionUpdateApproval($headerId)
    {
        $transferRequest = TransactionTransferRequest::model()->findByPk($headerId);
        $historis = TransactionTransferRequestApproval::model()->findAllByAttributes(array('transfer_request_id' => $headerId));
        $model = new TransactionTransferRequestApproval;
        $model->date = date('Y-m-d H:i:s');

        if (isset($_POST['TransactionTransferRequestApproval'])) {
            $model->attributes = $_POST['TransactionTransferRequestApproval'];

            if ($model->save()) {
                
                JurnalUmum::model()->deleteAllByAttributes(array(
                    'kode_transaksi' => $transferRequest->transfer_request_no,
                ));

                $transferRequest->status_document = $model->approval_type;

                if ($model->approval_type == 'Approved') {
                    $transferRequest->approved_by = $model->supervisor_id;

                    $coaInterbranchRequester = BranchCoaInterbranch::model()->findByAttributes(array(
                        'branch_id_from' => $transferRequest->requester_branch_id, 
                        'branch_id_to' => $transferRequest->destination_branch_id,
                    ));

                    $jurnalUmumInterbranchRequester = new JurnalUmum;
                    $jurnalUmumInterbranchRequester->kode_transaksi = $transferRequest->transfer_request_no;
                    $jurnalUmumInterbranchRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
                    $jurnalUmumInterbranchRequester->coa_id = $coaInterbranchRequester->coa_id;
                    $jurnalUmumInterbranchRequester->branch_id = $transferRequest->requester_branch_id;
                    $jurnalUmumInterbranchRequester->total = $transferRequest->total_price;
                    $jurnalUmumInterbranchRequester->debet_kredit = 'D';
                    $jurnalUmumInterbranchRequester->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInterbranchRequester->transaction_subject = 'Transfer Request Main';
                    $jurnalUmumInterbranchRequester->is_coa_category = 0;
                    $jurnalUmumInterbranchRequester->transaction_type = 'TR';
                    $jurnalUmumInterbranchRequester->save();

                    foreach ($transferRequest->transactionTransferRequestDetails as $detail) {
                        $transferRequestDetail = TransactionTransferRequestDetail::model()->findByAttributes(array('id' => $detail->id, 'transfer_request_id' => $transferRequest->id));
                        $transferRequestDetail->quantity_delivery_left = $detail->quantity - $detail->quantity_delivery;
                        $transferRequestDetail->quantity_delivery = $detail->quantity_delivery;
                        $transferRequestDetail->save(false);

                        $hppPrice = $detail->unit_price * $detail->quantity;

                        //save coa persediaan product master
                        $jurnalUmumMasterOutstandingPartRequester = new JurnalUmum;
                        $jurnalUmumMasterOutstandingPartRequester->kode_transaksi = $transferRequest->transfer_request_no;
                        $jurnalUmumMasterOutstandingPartRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
                        $jurnalUmumMasterOutstandingPartRequester->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                        $jurnalUmumMasterOutstandingPartRequester->branch_id = $transferRequest->requester_branch_id;
                        $jurnalUmumMasterOutstandingPartRequester->total = $hppPrice;
                        $jurnalUmumMasterOutstandingPartRequester->debet_kredit = 'K';
                        $jurnalUmumMasterOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterOutstandingPartRequester->transaction_subject = 'Transfer Request Main';
                        $jurnalUmumMasterOutstandingPartRequester->is_coa_category = 1;
                        $jurnalUmumMasterOutstandingPartRequester->transaction_type = 'TR';
                        $jurnalUmumMasterOutstandingPartRequester->save();

                        //save coa persedian product sub master
                        $jurnalUmumOutstandingPartRequester = new JurnalUmum;
                        $jurnalUmumOutstandingPartRequester->kode_transaksi = $transferRequest->transfer_request_no;
                        $jurnalUmumOutstandingPartRequester->tanggal_transaksi = $transferRequest->transfer_request_date;
                        $jurnalUmumOutstandingPartRequester->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                        $jurnalUmumOutstandingPartRequester->branch_id = $transferRequest->requester_branch_id;
                        $jurnalUmumOutstandingPartRequester->total = $hppPrice;
                        $jurnalUmumOutstandingPartRequester->debet_kredit = 'K';
                        $jurnalUmumOutstandingPartRequester->tanggal_posting = date('Y-m-d');
                        $jurnalUmumOutstandingPartRequester->transaction_subject = 'Transfer Request Main';
                        $jurnalUmumOutstandingPartRequester->is_coa_category = 0;
                        $jurnalUmumOutstandingPartRequester->transaction_type = 'TR';
                        $jurnalUmumOutstandingPartRequester->save();

                    }
                    
                    foreach ($transferRequest->transactionTransferRequestDetails as $detail) {
                        $transferRequestDetail = TransactionTransferRequestDetail::model()->findByAttributes(array('id' => $detail->id, 'transfer_request_id' => $transferRequest->id));
                        $transferRequestDetail->quantity_delivery_left = $detail->quantity - $detail->quantity_delivery;
                        $transferRequestDetail->quantity_delivery = $detail->quantity_delivery;
                        $transferRequestDetail->save(false);

                        $hppPrice = $detail->product->hpp * $detail->quantity;
                    }
                }

                $transferRequest->save(false);

                $this->redirect(array('view', 'id' => $headerId));
            }
        }

        $this->render('updateApproval', array(
            'model' => $model,
            'transferRequest' => $transferRequest,
            'historis' => $historis,
        ));
    }

    public function actionUpdateApprovalDestination($id)
    {
        $transferRequest = TransactionTransferRequest::model()->findByPk($id);
        $transferRequest->destination_approval_status = 1;
        $transferRequest->destination_approved_by = Yii::app()->user->id;
        $transferRequest->status_document = 'Approved by Destination Branch';
        $transferRequest->update(array('destination_approval_status', 'destination_approved_by', 'status_document'));

        $coaInterbranchDestination = BranchCoaInterbranch::model()->findByAttributes(array(
            'branch_id_from' => $transferRequest->destination_branch_id, 
            'branch_id_to' => $transferRequest->requester_branch_id,
        ));

        $jurnalUmumInterbranchDestination = new JurnalUmum;
        $jurnalUmumInterbranchDestination->kode_transaksi = $transferRequest->transfer_request_no;
        $jurnalUmumInterbranchDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
        $jurnalUmumInterbranchDestination->coa_id = $coaInterbranchDestination->coa_id;
        $jurnalUmumInterbranchDestination->branch_id = $transferRequest->destination_branch_id;
        $jurnalUmumInterbranchDestination->total = $transferRequest->total_price;
        $jurnalUmumInterbranchDestination->debet_kredit = 'K';
        $jurnalUmumInterbranchDestination->tanggal_posting = date('Y-m-d');
        $jurnalUmumInterbranchDestination->transaction_subject = 'Transfer Request Destination';
        $jurnalUmumInterbranchDestination->is_coa_category = 0;
        $jurnalUmumInterbranchDestination->transaction_type = 'TR';
        $jurnalUmumInterbranchDestination->save();

        foreach ($transferRequest->transactionTransferRequestDetails as $detail) {
            $hppPrice = $detail->unit_price * $detail->quantity;

            //save coa persediaan product master
            $jurnalUmumMasterOutstandingPartDestination = new JurnalUmum;
            $jurnalUmumMasterOutstandingPartDestination->kode_transaksi = $transferRequest->transfer_request_no;
            $jurnalUmumMasterOutstandingPartDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
            $jurnalUmumMasterOutstandingPartDestination->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
            $jurnalUmumMasterOutstandingPartDestination->branch_id = $transferRequest->destination_branch_id;
            $jurnalUmumMasterOutstandingPartDestination->total = $hppPrice;
            $jurnalUmumMasterOutstandingPartDestination->debet_kredit = 'D';
            $jurnalUmumMasterOutstandingPartDestination->tanggal_posting = date('Y-m-d');
            $jurnalUmumMasterOutstandingPartDestination->transaction_subject = 'Transfer Request Destination';
            $jurnalUmumMasterOutstandingPartDestination->is_coa_category = 1;
            $jurnalUmumMasterOutstandingPartDestination->transaction_type = 'TR';
            $jurnalUmumMasterOutstandingPartDestination->save();

            //save coa persedian product sub master
            $jurnalUmumOutstandingPartDestination = new JurnalUmum;
            $jurnalUmumOutstandingPartDestination->kode_transaksi = $transferRequest->transfer_request_no;
            $jurnalUmumOutstandingPartDestination->tanggal_transaksi = $transferRequest->transfer_request_date;
            $jurnalUmumOutstandingPartDestination->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
            $jurnalUmumOutstandingPartDestination->branch_id = $transferRequest->destination_branch_id;
            $jurnalUmumOutstandingPartDestination->total = $hppPrice;
            $jurnalUmumOutstandingPartDestination->debet_kredit = 'D';
            $jurnalUmumOutstandingPartDestination->tanggal_posting = date('Y-m-d');
            $jurnalUmumOutstandingPartDestination->transaction_subject = 'Transfer Request Destination';
            $jurnalUmumOutstandingPartDestination->is_coa_category = 0;
            $jurnalUmumOutstandingPartDestination->transaction_type = 'TR';
            $jurnalUmumOutstandingPartDestination->save();
        }

        $this->redirect(array('admin'));
    }

    public function actionAdmin() {
        $model = new TransactionTransferRequest('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionTransferRequest'])) {
            $model->attributes = $_GET['TransactionTransferRequest'];
        }

        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('requester_branch_id', Yii::app()->user->branch_ids);
        
        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAdminDestination() {
        $model = new TransactionTransferRequest('search');
        $model->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionTransferRequest'])) {
            $model->attributes = $_GET['TransactionTransferRequest'];
        }

        $destinationBranchDataProvider = $model->search();
        $destinationBranchDataProvider->criteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);
        $destinationBranchDataProvider->criteria->compare('t.status_document', "Approved");
        $destinationBranchDataProvider->criteria->compare('t.destination_approved_by', null);
        
        $this->render('adminDestination', array(
            'model' => $model,
            'destinationBranchDataProvider' => $destinationBranchDataProvider,
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
