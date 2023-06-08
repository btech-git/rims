<?php

class TransactionDeliveryOrderController extends Controller {

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
        if ($filterChain->action->id === 'create') {
            if (!(Yii::app()->user->checkAccess('deliveryCreate')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'delete' ||
            $filterChain->action->id === 'update'
        ) {
            if (!(Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }

        if (
            $filterChain->action->id === 'admin' || 
            $filterChain->action->id === 'index' || 
            $filterChain->action->id === 'view'
        ) {
            if (!(Yii::app()->user->checkAccess('deliveryCreate')) || !(Yii::app()->user->checkAccess('deliveryEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $id));
        
        if (isset($_POST['Process'])) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $model->delivery_order_no,
                'branch_id' => $model->sender_branch_id,
            ));
            $transactionSubject = $model->request_type;

            foreach ($deliveryDetails as $detail) {
                if ($model->request_type == 'Sales Order') {
                    $jumlah = $detail->quantity_delivery * $detail->salesOrderDetail->unit_price;

                    //save coa product master
                    $coaMasterInventory = Coa::model()->findByPk($detail->salesOrderDetail->product->productMasterCategory->coa_inventory_in_transit);
                    $jurnalUmumMasterInventory = new JurnalUmum;
                    $jurnalUmumMasterInventory->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumMasterInventory->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumMasterInventory->coa_id = $coaMasterInventory->id;
                    $jurnalUmumMasterInventory->branch_id = $model->sender_branch_id;
                    $jurnalUmumMasterInventory->total = $jumlah;
                    $jurnalUmumMasterInventory->debet_kredit = 'K';
                    $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterInventory->transaction_subject = $transactionSubject;
                    $jurnalUmumMasterInventory->is_coa_category = 1;
                    $jurnalUmumMasterInventory->transaction_type = 'DO';
                    $jurnalUmumMasterInventory->save();

                    //save coa product sub master
                    $coaInventory = Coa::model()->findByPk($detail->salesOrderDetail->product->productSubMasterCategory->coa_inventory_in_transit);
                    $jurnalUmumInventory = new JurnalUmum;
                    $jurnalUmumInventory->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumInventory->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumInventory->coa_id = $coaInventory->id;
                    $jurnalUmumInventory->branch_id = $model->sender_branch_id;
                    $jurnalUmumInventory->total = $jumlah;
                    $jurnalUmumInventory->debet_kredit = 'K';
                    $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInventory->transaction_subject = $transactionSubject;
                    $jurnalUmumInventory->is_coa_category = 0;
                    $jurnalUmumInventory->transaction_type = 'DO';
                    $jurnalUmumInventory->save();

                    //save coa persediaan master
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->salesOrderDetail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPart->branch_id = $model->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $jumlah;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = $transactionSubject;
                    $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                    $jurnalUmumMasterOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumMasterOutstandingPart->save();

                    //save coa persediaan sub master
                    $jurnalUmumOutstandingPart = new JurnalUmum;
                    $jurnalUmumOutstandingPart->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumOutstandingPart->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumOutstandingPart->coa_id = $detail->salesOrderDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumOutstandingPart->branch_id = $model->sender_branch_id;
                    $jurnalUmumOutstandingPart->total = $jumlah;
                    $jurnalUmumOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumOutstandingPart->transaction_subject = $transactionSubject;
                    $jurnalUmumOutstandingPart->is_coa_category = 0;
                    $jurnalUmumOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumOutstandingPart->save();

                } else if ($model->request_type == 'Sent Request') {
                    $hppPrice = $detail->product->hpp * $detail->quantity_delivery;

                    //save coa persediaan product master
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPart->branch_id = $model->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = $transactionSubject;
                    $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                    $jurnalUmumMasterOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumMasterOutstandingPart->save();

                    //save coa persedian product sub master
                    $jurnalUmumOutstandingPart = new JurnalUmum;
                    $jurnalUmumOutstandingPart->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumOutstandingPart->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumOutstandingPart->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumOutstandingPart->branch_id = $model->sender_branch_id;
                    $jurnalUmumOutstandingPart->total = $hppPrice;
                    $jurnalUmumOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumOutstandingPart->transaction_subject = $transactionSubject;
                    $jurnalUmumOutstandingPart->is_coa_category = 0;
                    $jurnalUmumOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumOutstandingPart->save();

                    //save product master category coa inventory in transit
                    $coaMasterInventory = Coa::model()->findByPk($detail->product->productMasterCategory->coaInventoryInTransit->id);
                    $jurnalUmumMasterInventory = new JurnalUmum;
                    $jurnalUmumMasterInventory->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumMasterInventory->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumMasterInventory->coa_id = $coaMasterInventory->id;
                    $jurnalUmumMasterInventory->branch_id = $model->sender_branch_id;
                    $jurnalUmumMasterInventory->total = $hppPrice;
                    $jurnalUmumMasterInventory->debet_kredit = 'K';
                    $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterInventory->transaction_subject = $transactionSubject;
                    $jurnalUmumMasterInventory->is_coa_category = 1;
                    $jurnalUmumMasterInventory->transaction_type = 'DO';
                    $jurnalUmumMasterInventory->save();

                    //save product sub master category coa inventory in transit
                    $coaInventory = Coa::model()->findByPk($detail->product->productSubMasterCategory->coaInventoryInTransit->id);
                    $jurnalUmumInventory = new JurnalUmum;
                    $jurnalUmumInventory->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumInventory->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumInventory->coa_id = $coaInventory->id;
                    $jurnalUmumInventory->branch_id = $model->sender_branch_id;
                    $jurnalUmumInventory->total = $hppPrice;
                    $jurnalUmumInventory->debet_kredit = 'K';
                    $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInventory->transaction_subject = $transactionSubject;
                    $jurnalUmumInventory->is_coa_category = 0;
                    $jurnalUmumInventory->transaction_type = 'DO';
                    $jurnalUmumInventory->save();

                } else if ($model->request_type == 'Consignment Out') {
                    //coa piutang ganti dengan consignment Inventory
                    $salePrice = $detail->consignmentOutDetail->sale_price * $detail->quantity_delivery;
//                    $hppPrice = $detail->product->hpp * $detail->quantity_delivery;

                    //save consignment product master category
                    $coaMasterConsignment = Coa::model()->findByPk($detail->product->productMasterCategory->coa_consignment_inventory);
                    $jurnalMasterUmumConsignment = new JurnalUmum;
                    $jurnalMasterUmumConsignment->kode_transaksi = $model->delivery_order_no;
                    $jurnalMasterUmumConsignment->tanggal_transaksi = $model->delivery_date;
                    $jurnalMasterUmumConsignment->coa_id = $coaMasterConsignment->id;
                    $jurnalMasterUmumConsignment->branch_id = $model->sender_branch_id;
                    $jurnalMasterUmumConsignment->total = $salePrice;
                    $jurnalMasterUmumConsignment->debet_kredit = 'D';
                    $jurnalMasterUmumConsignment->tanggal_posting = date('Y-m-d');
                    $jurnalMasterUmumConsignment->transaction_subject = $transactionSubject;
                    $jurnalMasterUmumConsignment->is_coa_category = 1;
                    $jurnalMasterUmumConsignment->transaction_type = 'DO';
                    $jurnalMasterUmumConsignment->save();

                    //save consignment product sub master category
                    $coaConsignment = Coa::model()->findByPk($detail->product->productSubMasterCategory->coa_consignment_inventory);
                    $jurnalUmumConsignment = new JurnalUmum;
                    $jurnalUmumConsignment->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumConsignment->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumConsignment->coa_id = $coaConsignment->id;
                    $jurnalUmumConsignment->branch_id = $model->sender_branch_id;
                    $jurnalUmumConsignment->total = $salePrice;
                    $jurnalUmumConsignment->debet_kredit = 'D';
                    $jurnalUmumConsignment->tanggal_posting = date('Y-m-d');
                    $jurnalUmumConsignment->transaction_subject = $transactionSubject;
                    $jurnalUmumConsignment->is_coa_category = 0;
                    $jurnalUmumConsignment->transaction_type = 'DO';
                    $jurnalUmumConsignment->save();

                    $jurnalMasterUmumInventoryInTransit = new JurnalUmum;
                    $jurnalMasterUmumInventoryInTransit->kode_transaksi = $model->delivery_order_no;
                    $jurnalMasterUmumInventoryInTransit->tanggal_transaksi = $model->delivery_date;
                    $jurnalMasterUmumInventoryInTransit->coa_id = $detail->product->productMasterCategory->coa_inventory_in_transit;
                    $jurnalMasterUmumInventoryInTransit->branch_id = $model->sender_branch_id;
                    $jurnalMasterUmumInventoryInTransit->total = $salePrice;
                    $jurnalMasterUmumInventoryInTransit->debet_kredit = 'D';
                    $jurnalMasterUmumInventoryInTransit->tanggal_posting = date('Y-m-d');
                    $jurnalMasterUmumInventoryInTransit->transaction_subject = $transactionSubject;
                    $jurnalMasterUmumInventoryInTransit->is_coa_category = 1;
                    $jurnalMasterUmumInventoryInTransit->transaction_type = 'DO';
                    $jurnalMasterUmumInventoryInTransit->save();

                    //save consignment product sub master category
                    $jurnalUmumInventoryInTransit = new JurnalUmum;
                    $jurnalUmumInventoryInTransit->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumInventoryInTransit->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumInventoryInTransit->coa_id = $detail->product->productSubMasterCategory->coa_consignment_inventory;
                    $jurnalUmumInventoryInTransit->branch_id = $model->sender_branch_id;
                    $jurnalUmumInventoryInTransit->total = $salePrice;
                    $jurnalUmumInventoryInTransit->debet_kredit = 'K';
                    $jurnalUmumInventoryInTransit->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInventoryInTransit->transaction_subject = $transactionSubject;
                    $jurnalUmumInventoryInTransit->is_coa_category = 0;
                    $jurnalUmumInventoryInTransit->transaction_type = 'DO';
                    $jurnalUmumInventoryInTransit->save();

                } else if ($model->request_type == 'Transfer Request') {
                    $hppPrice = $detail->product->hpp * $detail->quantity_delivery;

                    //save coa persediaan product master
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPart->branch_id = $model->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = $transactionSubject;
                    $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                    $jurnalUmumMasterOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumMasterOutstandingPart->save();

                    //save coa persedian product sub master
                    $jurnalUmumOutstandingPart = new JurnalUmum;
                    $jurnalUmumOutstandingPart->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumOutstandingPart->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumOutstandingPart->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumOutstandingPart->branch_id = $model->sender_branch_id;
                    $jurnalUmumOutstandingPart->total = $hppPrice;
                    $jurnalUmumOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumOutstandingPart->transaction_subject = $transactionSubject;
                    $jurnalUmumOutstandingPart->is_coa_category = 0;
                    $jurnalUmumOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumOutstandingPart->save();

                    //save product master category coa inventory in transit
                    $coaMasterInventory = Coa::model()->findByPk($detail->product->productMasterCategory->coaInventoryInTransit->id);
                    $jurnalUmumMasterInventory = new JurnalUmum;
                    $jurnalUmumMasterInventory->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumMasterInventory->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumMasterInventory->coa_id = $coaMasterInventory->id;
                    $jurnalUmumMasterInventory->branch_id = $model->sender_branch_id;
                    $jurnalUmumMasterInventory->total = $hppPrice;
                    $jurnalUmumMasterInventory->debet_kredit = 'K';
                    $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterInventory->transaction_subject = $transactionSubject;
                    $jurnalUmumMasterInventory->is_coa_category = 1;
                    $jurnalUmumMasterInventory->transaction_type = 'DO';
                    $jurnalUmumMasterInventory->save();

                    //save product sub master category coa inventory in transit
                    $coaInventory = Coa::model()->findByPk($detail->product->productSubMasterCategory->coaInventoryInTransit->id);
                    $jurnalUmumInventory = new JurnalUmum;
                    $jurnalUmumInventory->kode_transaksi = $model->delivery_order_no;
                    $jurnalUmumInventory->tanggal_transaksi = $model->delivery_date;
                    $jurnalUmumInventory->coa_id = $coaInventory->id;
                    $jurnalUmumInventory->branch_id = $model->sender_branch_id;
                    $jurnalUmumInventory->total = $hppPrice;
                    $jurnalUmumInventory->debet_kredit = 'K';
                    $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                    $jurnalUmumInventory->transaction_subject = $transactionSubject;
                    $jurnalUmumInventory->is_coa_category = 0;
                    $jurnalUmumInventory->transaction_type = 'DO';
                    $jurnalUmumInventory->save();
                }
            }
        }
        
        $this->render('view', array(
            'model' => $model,
            'deliveryDetails' => $deliveryDetails,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($transactionId, $movementType) {
        
        $deliveryOrder = $this->instantiate(null);
        $deliveryOrder->header->posting_date = date('Y-m-d');
        $deliveryOrder->header->created_datetime = date('Y-m-d H:i:s');
        $deliveryOrder->header->estimate_arrival_date = null;
        $deliveryOrder->header->sender_branch_id = $deliveryOrder->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $deliveryOrder->header->sender_branch_id;
        $this->performAjaxValidation($deliveryOrder->header);

        if ($movementType == 1) {
            $saleOrder = TransactionSalesOrder::model()->findByPk($transactionId);
            $deliveryOrder->header->sales_order_id = $transactionId;
            $deliveryOrder->header->sent_request_id = null;
            $deliveryOrder->header->consignment_out_id = null;
            $deliveryOrder->header->transfer_request_id = null;
            $deliveryOrder->header->customer_id = $saleOrder->customer_id;
            $deliveryOrder->header->request_type = 'Sales Order';
            $deliveryOrder->header->destination_branch = null;
            $deliveryOrder->header->estimate_arrival_date = null;
            $deliveryOrder->header->request_date = $saleOrder->sale_order_date;
            
        } else if ($movementType == 2) {
            $sentRequest = TransactionSentRequest::model()->findByPk($transactionId);
            $deliveryOrder->header->sales_order_id = null;
            $deliveryOrder->header->sent_request_id = $transactionId;
            $deliveryOrder->header->consignment_out_id = null;
            $deliveryOrder->header->transfer_request_id = null;
            $deliveryOrder->header->customer_id = null;
            $deliveryOrder->header->request_type = 'Sent Request';
            $deliveryOrder->header->destination_branch = $sentRequest->destination_branch_id;
            $deliveryOrder->header->estimate_arrival_date = $sentRequest->estimate_arrival_date;
            $deliveryOrder->header->request_date = $sentRequest->sent_request_date;
            
        }  else if ($movementType == 3) {
            $consignmentOut = ConsignmentOutHeader::model()->findByPk($transactionId);
            $deliveryOrder->header->sales_order_id = null;
            $deliveryOrder->header->sent_request_id = null;
            $deliveryOrder->header->consignment_out_id = $transactionId;
            $deliveryOrder->header->transfer_request_id = null;
            $deliveryOrder->header->customer_id = $consignmentOut->customer_id;
            $deliveryOrder->header->request_type = 'Consignment Out';
            $deliveryOrder->header->destination_branch = null;
            $deliveryOrder->header->estimate_arrival_date = null;
            $deliveryOrder->header->request_date = $consignmentOut->date_posting;
            
        }  else if ($movementType == 4) {
            $transferRequest = TransactionTransferRequest::model()->findByPk($transactionId);
            $deliveryOrder->header->sales_order_id = null;
            $deliveryOrder->header->sent_request_id = null;
            $deliveryOrder->header->consignment_out_id = null;
            $deliveryOrder->header->transfer_request_id = $transactionId;
            $deliveryOrder->header->customer_id = null;
            $deliveryOrder->header->request_type = 'Transfer Request';
            $deliveryOrder->header->destination_branch = $transferRequest->requester_branch_id;
            $deliveryOrder->header->estimate_arrival_date = $transferRequest->estimate_arrival_date;
            $deliveryOrder->header->request_date = $transferRequest->transfer_request_date;
            
        } else {
            $this->redirect(array('admin'));
        }
        
        $deliveryOrder->addDetails($transactionId, $movementType);
        
        if (isset($_POST['Cancel'])) {
            $this->redirect(array('admin'));
        }

        if (isset($_POST['TransactionDeliveryOrder']) && IdempotentManager::check()) {
            $this->loadState($deliveryOrder);
            $deliveryOrder->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($deliveryOrder->header->delivery_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($deliveryOrder->header->delivery_date)), $deliveryOrder->header->sender_branch_id);
            
            if ($deliveryOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $deliveryOrder->header->id));
            }
        }

        $this->render('create', array(
            'deliveryOrder' => $deliveryOrder,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $deliveryOrder = $this->instantiate($id);
        $this->performAjaxValidation($deliveryOrder->header);

        $transfer = new TransactionTransferRequest('search');
        $transfer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionTransferRequest']))
            $transfer->attributes = $_GET['TransactionTransferRequest'];

        $transferCriteria = new CDbCriteria;
        $transferCriteria->compare('transfer_request_no', $transfer->transfer_request_no . '%', true, 'AND', false);
        $transferCriteria->addCondition("status_document = 'Approved'");
        $transferDataProvider = new CActiveDataProvider('TransactionTransferRequest', array(
            'criteria' => $transferCriteria,
        ));

        $sent = new TransactionSentRequest('search');
        $sent->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionSentRequest']))
            $sent->attributes = $_GET['TransactionSentRequest'];

        $sentCriteria = new CDbCriteria;
        $sentCriteria->compare('sent_request_no', $sent->sent_request_no . '%', true, 'AND', false);
        $sentCriteria->addCondition("status_document = 'Approved'");
        $sentDataProvider = new CActiveDataProvider('TransactionSentRequest', array(
            'criteria' => $sentCriteria,
        ));
        
        $sales = new TransactionSalesOrder('search');
        $sales->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionSalesOrder']))
            $sales->attributes = $_GET['TransactionSalesOrder'];

        $salesCriteria = new CDbCriteria;
        $salesCriteria->compare('sale_order_no', $sales->sale_order_no . '%', true, 'AND', false);
        $salesCriteria->addCondition("status_document = 'Approved'");
        $salesDataProvider = new CActiveDataProvider('TransactionSalesOrder', array(
            'criteria' => $salesCriteria,
        ));

        $consignment = new ConsignmentOutHeader('search');
        $consignment->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ConsignmentOutHeader']))
            $consignment->attributes = $_GET['ConsignmentOutHeader'];

        $consignmentCriteria = new CDbCriteria;
        $consignmentCriteria->compare('consignment_out_no', $consignment->consignment_out_no . '%', true, 'AND', false);
        $consignmentCriteria->addCondition("status = 'Approved'");
        $consignmentDataProvider = new CActiveDataProvider('ConsignmentOutHeader', array(
            'criteria' => $consignmentCriteria,
        ));

        if (isset($_POST['Cancel']))
            $this->redirect(array('admin'));

        if (isset($_POST['TransactionDeliveryOrder']) && IdempotentManager::check()) {
            $this->loadState($deliveryOrder);
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $deliveryOrder->header->delivery_order_no,
                'branch_id' => $deliveryOrder->header->sender_branch_id,
            ));

            $deliveryOrder->header->setCodeNumberByRevision('delivery_order_no');

            if ($deliveryOrder->save(Yii::app()->db)) {
                $this->redirect(array('view', 'id' => $deliveryOrder->header->id));
            }
        }

        $this->render('update', array(
            'deliveryOrder' => $deliveryOrder,
            'sent' => $sent,
            'sentDataProvider' => $sentDataProvider,
            'sales' => $sales,
            'salesDataProvider' => $salesDataProvider,
            'consignment' => $consignment,
            'consignmentDataProvider' => $consignmentDataProvider,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
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
        $dataProvider = new CActiveDataProvider('TransactionDeliveryOrder');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new TransactionDeliveryOrder('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionDeliveryOrder']))
            $model->attributes = $_GET['TransactionDeliveryOrder'];
        
        $dataProvider = $model->search();
        $dataProvider->criteria->addInCondition('sender_branch_id', Yii::app()->user->branch_ids);

        $transfer = new TransactionTransferRequest('search');
        $transfer->unsetAttributes();  // clear any default values
        if (isset($_GET['TransactionTransferRequest']))
            $transfer->attributes = $_GET['TransactionTransferRequest'];

        $transferDataProvider = $transfer->searchByPendingDelivery();
        $transferDataProvider->criteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);

        $sent = new TransactionSentRequest('search');
        $sent->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionSentRequest']))
            $sent->attributes = $_GET['TransactionSentRequest'];

        $sentDataProvider = $sent->searchByPendingDelivery();
        $sentDataProvider->criteria->addInCondition('requester_branch_id', Yii::app()->user->branch_ids);
        $sentDataProvider->criteria->addCondition("t.sent_request_date > '2021-12-31'");

        $sales = new TransactionSalesOrder('search');
        $sales->unsetAttributes();  // clear any default values
        
        if (isset($_GET['TransactionSalesOrder']))
            $sales->attributes = $_GET['TransactionSalesOrder'];

        $salesDataProvider = $sales->searchByPendingDelivery();
        $salesDataProvider->criteria->addCondition("status_document = 'Approved' AND t.sale_order_date > '2021-12-31'");
        $salesDataProvider->criteria->addInCondition('requester_branch_id', Yii::app()->user->branch_ids);

        $consignment = new ConsignmentOutHeader('search');
        $consignment->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ConsignmentOutHeader']))
            $consignment->attributes = $_GET['ConsignmentOutHeader'];

        $consignmentDataProvider = $consignment->searchByPendingDelivery();
        $consignmentDataProvider->criteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
        $consignmentDataProvider->criteria->addCondition("t.date_posting > '2021-12-31'");

        $this->render('admin', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'sent' => $sent,
            'sentDataProvider' => $sentDataProvider,
            'sales' => $sales,
            'salesDataProvider' => $salesDataProvider,
            'consignment' => $consignment,
            'consignmentDataProvider' => $consignmentDataProvider,
            'transfer' => $transfer,
            'transferDataProvider' => $transferDataProvider,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return TransactionDeliveryOrder the loaded model
     * @throws CHttpException
     */
    //Add Detail
    public function actionAjaxHtmlAddDetail($id, $requestType, $requestId) {
        if (Yii::app()->request->isAjaxRequest) {

            $deliveryOrder = $this->instantiate($id);
            $this->loadState($deliveryOrder);

            $deliveryOrder->addDetail($requestType, $requestId);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('deliveryOrder' => $deliveryOrder), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetailRequest($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $deliveryOrder = $this->instantiate($id);
            $this->loadState($deliveryOrder);

            $deliveryOrder->removeDetailAt();
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('deliveryOrder' => $deliveryOrder), false, true);
        }
    }

    public function actionAjaxHtmlRemoveDetail($id, $index) {
        if (Yii::app()->request->isAjaxRequest) {
            $deliveryOrder = $this->instantiate($id);
            $this->loadState($deliveryOrder);

            $deliveryOrder->removeDetail($index);
            Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
            Yii::app()->clientscript->scriptMap['jquery.js'] = false;
            $this->renderPartial('_detail', array('deliveryOrder' => $deliveryOrder), false, true);
        }
    }

    public function actionAjaxSales($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer_name = "";
            $sales = TransactionSalesOrder::model()->findByPk($id);
            if ($sales->customer_id != "") {
                $customer = Customer::model()->findByPk($sales->customer_id);
                $customer_name = $customer->name;
            }

            $object = array(
                'id' => $sales->id,
                'no' => $sales->sale_order_no,
                'date' => $sales->sale_order_date,
                'eta' => $sales->estimate_arrival_date,
                'customer' => $sales->customer_id,
                'customer_name' => $customer->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxSent($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $sent = TransactionSentRequest::model()->findByPk($id);
            $branch = Branch::model()->findByPk($sent->destination_branch_id);

            $object = array(
                'id' => $sent->id,
                'no' => $sent->sent_request_no,
                'date' => $sent->sent_request_date,
                'eta' => $sent->estimate_arrival_date,
                'branch' => $sent->destination_branch_id,
                'branch_name' => $branch->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer = Customer::model()->findByPk($id);

            $object = array(
                'id' => $customer->id,
                'name' => $customer->name,
            );

            echo CJSON::encode($object);
        }
    }

    public function instantiate($id) {
        if (empty($id)) {
            $deliveryOrder = new DeliveryOrders(new TransactionDeliveryOrder(), array());
        } else {
            $deliveryOrderModel = $this->loadModel($id);
            $deliveryOrder = new DeliveryOrders($deliveryOrderModel, $deliveryOrderModel->transactionDeliveryOrderDetails);
        }
        
        return $deliveryOrder;
    }

    public function loadState($deliveryOrder) {
        if (isset($_POST['TransactionDeliveryOrder'])) {
            $deliveryOrder->header->attributes = $_POST['TransactionDeliveryOrder'];
        }

        if (isset($_POST['TransactionDeliveryOrderDetail'])) {
            foreach ($_POST['TransactionDeliveryOrderDetail'] as $i => $item) {
                if (isset($deliveryOrder->details[$i])) {
                    $deliveryOrder->details[$i]->attributes = $item;
                } else {
                    $detail = new TransactionDeliveryOrderDetail();
                    $detail->attributes = $item;
                    $deliveryOrder->details[] = $detail;
                }
            }
            
            if (count($_POST['TransactionDeliveryOrderDetail']) < count($deliveryOrder->details))
                array_splice($deliveryOrder->details, $i + 1);
        }
        else {
            $deliveryOrder->details = array();
        }
    }

    public function actionPdf($id) {
        $do = $this->loadModel($id);
        $supplier = '0'; //Supplier::model()->find('id=:id', array(':id'=>$po->supplier_id));
        $branch = '0'; //Branch::model()->find('id=:id', array(':id'=>$po->main_branch_id));
        $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $id));
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('', 'A4-L');
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/css/pdf.css');
        $mPDF1->WriteHTML($stylesheet, 1);
        $mPDF1->WriteHTML($this->renderPartial('pdf', array('model' => $do, 'deliveryDetails' => $deliveryDetails), true));
        $mPDF1->Output();
    }

    public function loadModel($id) {
        $model = TransactionDeliveryOrder::model()->findByPk($id);
        
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param TransactionDeliveryOrder $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'transaction-delivery-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxConsignment($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customer_name = "";
            $consigment = ConsignmentOutHeader::model()->findByPk($id);
            
            if ($consigment->customer_id != "") {
                $customer = Customer::model()->findByPk($consigment->customer_id);
                $customer_name = $customer->name;
            }

            $object = array(
                'id' => $consigment->id,
                'no' => $consigment->consignment_out_no,
                'date' => $consigment->date_posting,
                'eta' => $consigment->delivery_date,
                'customer' => $consigment->customer_id,
                'customer_name' => $customer_name,
            );

            echo CJSON::encode($object);
        }
    }

    public function actionAjaxTransfer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $branch_name = "";
            $transfer = TransactionTransferRequest::model()->findByPk($id);
            
            if ($transfer->destination_branch_id != "") {
                $branch = Branch::model()->findByPk($transfer->requester_branch_id);
                $branch_name = $branch->name;
            }

            $object = array(
                'id' => $transfer->id,
                'no' => $transfer->transfer_request_no,
                'date' => $transfer->transfer_request_date,
                'eta' => $transfer->estimate_arrival_date,
                'branch' => $transfer->requester_branch_id,
                'branch_name' => $branch_name,
            );

            echo CJSON::encode($object);
        }
    }
}