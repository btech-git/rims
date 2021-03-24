<?php

class DeliveryOrders extends CComponent {

    public $header;
    public $details;

    // /public $detailApprovals;
    // public $picPhoneDetails;
    // public $picMobileDetails;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;

        //$this->detailApprovals = $detailApprovals;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(delivery_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(delivery_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionDeliveryOrder = TransactionDeliveryOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND sender_branch_id = :sender_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':sender_branch_id' => $requesterBranchId),
                ));

        if ($transactionDeliveryOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionDeliveryOrder->senderBranch->code;
            $this->header->delivery_order_no = $transactionDeliveryOrder->delivery_order_no;
        }

        $this->header->setCodeNumberByNext('delivery_order_no', $branchCode, TransactionDeliveryOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($requestType, $requestId) {
        $this->details = array();

        if ($requestType == 1) {
            $sales = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $requestId));
            foreach ($sales as $key => $sale) {
                $detail = new TransactionDeliveryOrderDetail();
                $detail->product_id = $sale->product_id;
                $detail->quantity_request = $sale->quantity;
                $detail->quantity_request_left = $sale->remainingQuantityDelivery;
                //added 20 july 10 pm
                $detail->sales_order_detail_id = $sale->id;
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($requestType == 2) {
            $sents = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $requestId));
            foreach ($sents as $key => $sent) {
                $detail = new TransactionDeliveryOrderDetail();
                $detail->product_id = $sent->product_id;
                $detail->quantity_request = $sent->quantity;
                $detail->quantity_request_left = $sent->remainingQuantityDelivery;
                //added 20 july 10 pm
                $detail->sent_request_detail_id = $sent->id;
                $this->details[] = $detail;
            }
        } elseif ($requestType == 3) {
            $consignments = ConsignmentOutDetail::model()->findAllByAttributes(array('consignment_out_id' => $requestId));
            foreach ($consignments as $key => $consignment) {
                $detail = new TransactionDeliveryOrderDetail();
                $detail->product_id = $consignment->product_id;
                $detail->quantity_request = $consignment->quantity;
                $detail->quantity_request_left = $consignment->remainingQuantityDelivery;
                //added 20 july 10 pm
                $detail->consignment_out_detail_id = $consignment->id;
                $this->details[] = $detail;
            }
        } elseif ($requestType == 4) {
            $transfers = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $requestId));
            foreach ($transfers as $key => $transfer) {
                $detail = new TransactionDeliveryOrderDetail();
                $detail->product_id = $transfer->product_id;
                $detail->quantity_request = $transfer->quantity;
                $detail->quantity_request_left = $transfer->remainingQuantityDelivery;
                $detail->transfer_request_detail_id = $transfer->id;
                $this->details[] = $detail;
            }
        }
    }

    public function removeDetailAt() {
        //array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
        $this->details = array();
    }

    public function removeDetail($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
        //$this->details = array();
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid) {
                $dbTransaction->commit();
                //print_r('1');
            } else {
                $dbTransaction->rollback();
                //print_r('2');
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            //print_r($e);
        }

        return $valid;
        //print_r('success');
    }

    public function validate() {
        $valid = $this->header->validate();

        if ($this->header->isNewRecord)
            $valid = $this->validateDetailsQuantityDifference() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('unit_price');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        //print_r($valid);
        return $valid;
    }

    public function validateDetailsQuantityDifference() {
        $valid = true;

        foreach ($this->details as $detail) {
            $quantityDiff = $detail->quantity_request_left - $detail->quantity_delivery;
            if ($quantityDiff < 0) {
                $valid = false;
                $this->header->addError('error', 'Quantity delivery must be equal or less than quantity remaining!');
            }
        }

        return $valid;
    }

    public function flush() {
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $this->header->delivery_order_no,
            'branch_id' => $this->header->sender_branch_id,
        ));

//        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();

        $requestDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $this->header->id));
        $detail_id = array();
        
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->delivery_order_id = $this->header->id;
            //echo $this->header->request_type;
            $left_quantity = 0;
            
            if ($this->header->request_type == 'Sales Order') {
                //echo $this->header->request_type;
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('deliveryOrder');
                $criteria->condition = "deliveryOrder.sales_order_id =" . $this->header->sales_order_id . " AND delivery_order_id != " . $this->header->id;
                //$criteria->condition="sales_order_detail_id =".$detail->sales_order_detail_id ." AND delivery_order_id != ".$this->header->id;
                $receiveItemDetails = TransactionDeliveryOrderDetail::model()->findAll($criteria);

                $quantity = 0;

                foreach ($receiveItemDetails as $receiveItemDetail)
                    $quantity += $receiveItemDetail->quantity_delivery;

                $salesOrderDetail = TransactionSalesOrderDetail::model()->findByAttributes(array('id' => $detail->sales_order_detail_id, 'sales_order_id' => $this->header->sales_order_id));
                $salesOrderDetail->sales_order_quantity_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
                $salesOrderDetail->delivery_quantity = $quantity + $detail->quantity_delivery;
                $left_quantity = $salesOrderDetail->sales_order_quantity_left;
                $salesOrderDetail->save(false);

                $salesOrder = TransactionSalesOrder::model()->findByPk($this->header->sales_order_id);
                $branch = Branch::model()->findByPk($this->header->sender_branch_id);
                $jumlah = $detail->quantity_delivery * $detail->salesOrderDetail->unit_price;
                
//                $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '105.00.000'));
//                $jurnalUmumMasterGroupInventory = new JurnalUmum;
//                $jurnalUmumMasterGroupInventory->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupInventory->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupInventory->coa_id = $coaMasterGroupInventory->id;
//                $jurnalUmumMasterGroupInventory->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupInventory->total = $jumlah;
//                $jurnalUmumMasterGroupInventory->debet_kredit = 'D';
//                $jurnalUmumMasterGroupInventory->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupInventory->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupInventory->is_coa_category = 1;
//                $jurnalUmumMasterGroupInventory->transaction_type = 'DO';
//                $jurnalUmumMasterGroupInventory->save();
                
                //save coa product master
                $coaMasterInventory = Coa::model()->findByPk($detail->salesOrderDetail->product->productMasterCategory->coa_inventory_in_transit);
                $getCoaMasterInventory = $coaMasterInventory->code;
                $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaMasterInventory));
                $jurnalUmumMasterInventory = new JurnalUmum;
                $jurnalUmumMasterInventory->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumMasterInventory->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumMasterInventory->coa_id = $coaMasterInventoryWithCode->id;
                $jurnalUmumMasterInventory->branch_id = $this->header->sender_branch_id;
                $jurnalUmumMasterInventory->total = $jumlah;
                $jurnalUmumMasterInventory->debet_kredit = 'K';
                $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterInventory->transaction_subject = 'Delivery Order';
                $jurnalUmumMasterInventory->is_coa_category = 1;
                $jurnalUmumMasterInventory->transaction_type = 'DO';
                $jurnalUmumMasterInventory->save();
                
                //save coa product sub master
                $coaInventory = Coa::model()->findByPk($detail->salesOrderDetail->product->productSubMasterCategory->coa_inventory_in_transit);
                $getCoaInventory = $coaInventory->code;
                $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                $jurnalUmumInventory = new JurnalUmum;
                $jurnalUmumInventory->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumInventory->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
                $jurnalUmumInventory->branch_id = $this->header->sender_branch_id;
                $jurnalUmumInventory->total = $jumlah;
                $jurnalUmumInventory->debet_kredit = 'K';
                $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumInventory->transaction_subject = 'Delivery Order';
                $jurnalUmumInventory->is_coa_category = 0;
                $jurnalUmumInventory->transaction_type = 'DO';
                $jurnalUmumInventory->save();

                //____________________________________________________________________________________
                
//                $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
//                $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
//                $jurnalUmumMasterGroupPersediaan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
//                $jurnalUmumMasterGroupPersediaan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupPersediaan->total = $jumlah;
//                $jurnalUmumMasterGroupPersediaan->debet_kredit = 'K';
//                $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
//                $jurnalUmumMasterGroupPersediaan->transaction_type = 'DO';
//                $jurnalUmumMasterGroupPersediaan->save();
                
                //save coa persediaan master
                $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumMasterOutstandingPart->coa_id = $detail->salesOrderDetail->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPart->branch_id = $this->header->sender_branch_id;
                $jurnalUmumMasterOutstandingPart->total = $jumlah;
                $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPart->transaction_subject = 'Delivery Order';
                $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPart->transaction_type = 'DO';
                $jurnalUmumMasterOutstandingPart->save();
                
                //save coa persediaan sub master
                $jurnalUmumOutstandingPart = new JurnalUmum;
                $jurnalUmumOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumOutstandingPart->coa_id = $detail->salesOrderDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPart->branch_id = $this->header->sender_branch_id;
                $jurnalUmumOutstandingPart->total = $jumlah;
                $jurnalUmumOutstandingPart->debet_kredit = 'D';
                $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPart->transaction_subject = 'Delivery Order';
                $jurnalUmumOutstandingPart->is_coa_category = 0;
                $jurnalUmumOutstandingPart->transaction_type = 'DO';
                $jurnalUmumOutstandingPart->save();

            } else if ($this->header->request_type == 'Sent Request') {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('deliveryOrder');
                $criteria->condition = "deliveryOrder.sent_request_id =" . $this->header->sent_request_id . " AND delivery_order_id != " . $this->header->id;
                $deliveryItemDetails = TransactionDeliveryOrderDetail::model()->findAll($criteria);

                $quantity = 0;
                foreach ($deliveryItemDetails as $deliveryItemDetail)
                    $quantity += $deliveryItemDetail->quantity_delivery;

                $sentRequestDetail = TransactionSentRequestDetail::model()->findByAttributes(array('id' => $detail->sent_request_detail_id, 'sent_request_id' => $this->header->sent_request_id));
                $sentRequestDetail->sent_request_quantity_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
                $sentRequestDetail->delivery_quantity = $quantity + $detail->quantity_delivery;

                $left_quantity = $sentRequestDetail->sent_request_quantity_left;
                $sentRequestDetail->save(false);
                $detail->quantity_receive_left = $detail->quantity_delivery;
                
                $transfer = TransactionTransferRequest::model()->findByPk($this->header->transfer_request_id);
                $branch = Branch::model()->findByPk($this->header->sender_branch_id);
                $hppPrice = $detail->product->hpp * $detail->quantity_delivery;

//                $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
//                $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
//                $jurnalUmumMasterGroupPersediaan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
//                $jurnalUmumMasterGroupPersediaan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupPersediaan->total = $hppPrice;
//                $jurnalUmumMasterGroupPersediaan->debet_kredit = 'D';
//                $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
//                $jurnalUmumMasterGroupPersediaan->transaction_type = 'DO';
//                $jurnalUmumMasterGroupPersediaan->save();

                //save coa persediaan product master
                $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPart->branch_id = $this->header->sender_branch_id;
                $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPart->transaction_subject = 'Delivery Order';
                $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPart->transaction_type = 'DO';
                $jurnalUmumMasterOutstandingPart->save();

                //save coa persedian product sub master
                $jurnalUmumOutstandingPart = new JurnalUmum;
                $jurnalUmumOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumOutstandingPart->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPart->branch_id = $this->header->sender_branch_id;
                $jurnalUmumOutstandingPart->total = $hppPrice;
                $jurnalUmumOutstandingPart->debet_kredit = 'D';
                $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPart->transaction_subject = 'Delivery Order';
                $jurnalUmumOutstandingPart->is_coa_category = 0;
                $jurnalUmumOutstandingPart->transaction_type = 'DO';
                $jurnalUmumOutstandingPart->save();
                
//                $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '105.00.000'));
//                $jurnalUmumMasterGroupInventory = new JurnalUmum;
//                $jurnalUmumMasterGroupInventory->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupInventory->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupInventory->coa_id = $coaMasterGroupInventory->id;
//                $jurnalUmumMasterGroupInventory->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupInventory->total = $hppPrice;
//                $jurnalUmumMasterGroupInventory->debet_kredit = 'K';
//                $jurnalUmumMasterGroupInventory->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupInventory->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupInventory->is_coa_category = 1;
//                $jurnalUmumMasterGroupInventory->transaction_type = 'DO';
//                $jurnalUmumMasterGroupInventory->save();

                //save product master category coa inventory in transit
                $coaMasterInventory = Coa::model()->findByPk($detail->product->productMasterCategory->coaInventoryInTransit->id);
                $getCoaMasterInventory = $coaMasterInventory->code;
                $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
                $jurnalUmumMasterInventory = new JurnalUmum;
                $jurnalUmumMasterInventory->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumMasterInventory->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumMasterInventory->coa_id = $coaMasterInventoryWithCode->id;
                $jurnalUmumMasterInventory->branch_id = $this->header->sender_branch_id;
                $jurnalUmumMasterInventory->total = $hppPrice;
                $jurnalUmumMasterInventory->debet_kredit = 'K';
                $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterInventory->transaction_subject = 'Delivery Order';
                $jurnalUmumMasterInventory->is_coa_category = 1;
                $jurnalUmumMasterInventory->transaction_type = 'DO';
                $jurnalUmumMasterInventory->save();

                //save product sub master category coa inventory in transit
                $coaInventory = Coa::model()->findByPk($detail->product->productSubMasterCategory->coaInventoryInTransit->id);
                $getCoaInventory = $coaInventory->code;
                $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                $jurnalUmumInventory = new JurnalUmum;
                $jurnalUmumInventory->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumInventory->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
                $jurnalUmumInventory->branch_id = $this->header->sender_branch_id;
                $jurnalUmumInventory->total = $hppPrice;
                $jurnalUmumInventory->debet_kredit = 'K';
                $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumInventory->transaction_subject = 'Delivery Order';
                $jurnalUmumInventory->is_coa_category = 0;
                $jurnalUmumInventory->transaction_type = 'DO';
                $jurnalUmumInventory->save();
                
            } else if ($this->header->request_type == 'Consignment Out') {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('deliveryOrder');
                $criteria->condition = "deliveryOrder.consignment_out_id =" . $this->header->consignment_out_id . " AND delivery_order_id != " . $this->header->id;
                $deliveryItemDetails = TransactionDeliveryOrderDetail::model()->findAll($criteria);

                $consignmentDetail = ConsignmentOutDetail::model()->findByAttributes(array('id' => $detail->consignment_out_detail_id, 'consignment_out_id' => $this->header->consignment_out_id));
                $consignmentDetail->qty_request_left = $detail->quantity_request - $detail->quantity_delivery - $consignmentDetail->getTotalQuantityDelivered();
                $consignmentDetail->qty_sent = $detail->quantity_delivery + $consignmentDetail->getTotalQuantityDelivered();
                $left_quantity = $consignmentDetail->qty_request_left;

                $consignmentDetail->save(false);
                $branch = Branch::model()->findByPk($this->header->sender_branch_id);

                //coa piutang ganti dengan consignment Inventory
                $salePrice = $detail->consignmentOutDetail->sale_price * $detail->quantity_delivery;
                $hppPrice = $detail->product->hpp * $detail->quantity_delivery;
                
//                $coaMasterGroupConsignment = Coa::model()->findByAttributes(array('code'=> '106.00.000'));
//                $jurnalUmumMasterGroupConsignment = new JurnalUmum;
//                $jurnalUmumMasterGroupConsignment->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupConsignment->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupConsignment->coa_id = $coaMasterGroupConsignment->id;
//                $jurnalUmumMasterGroupConsignment->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupConsignment->total = $salePrice;
//                $jurnalUmumMasterGroupConsignment->debet_kredit = 'D';
//                $jurnalUmumMasterGroupConsignment->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupConsignment->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupConsignment->is_coa_category = 1;
//                $jurnalUmumMasterGroupConsignment->transaction_type = 'DO';
//                $jurnalUmumMasterGroupConsignment->save();
                
                //save consignment product master category
                $coaMasterConsignment = Coa::model()->findByPk($detail->product->productMasterCategory->coa_consignment_inventory);
                $getCoaMasterConsignment = $coaMasterConsignment->code;
                $coaMasterConsignmentWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaMasterConsignment));
                $jurnalMasterUmumConsignment = new JurnalUmum;
                $jurnalMasterUmumConsignment->kode_transaksi = $this->header->delivery_order_no;
                $jurnalMasterUmumConsignment->tanggal_transaksi = $this->header->delivery_date;
                $jurnalMasterUmumConsignment->coa_id = $coaMasterConsignmentWithCode->id;
                $jurnalMasterUmumConsignment->branch_id = $this->header->sender_branch_id;
                $jurnalMasterUmumConsignment->total = $salePrice;
                $jurnalMasterUmumConsignment->debet_kredit = 'D';
                $jurnalMasterUmumConsignment->tanggal_posting = date('Y-m-d');
                $jurnalMasterUmumConsignment->transaction_subject = 'Delivery Order';
                $jurnalMasterUmumConsignment->is_coa_category = 1;
                $jurnalMasterUmumConsignment->transaction_type = 'DO';
                $jurnalMasterUmumConsignment->save();
                
                //save consignment product sub master category
                $coaConsignment = Coa::model()->findByPk($detail->product->productSubMasterCategory->coa_consignment_inventory);
                $getCoaConsignment = $coaConsignment->code;
                $coaConsignmentWithCode = Coa::model()->findByAttributes(array('code' => $getCoaConsignment));
                $jurnalUmumConsignment = new JurnalUmum;
                $jurnalUmumConsignment->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumConsignment->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumConsignment->coa_id = $coaConsignmentWithCode->id;
                $jurnalUmumConsignment->branch_id = $this->header->sender_branch_id;
                $jurnalUmumConsignment->total = $salePrice;
                $jurnalUmumConsignment->debet_kredit = 'D';
                $jurnalUmumConsignment->tanggal_posting = date('Y-m-d');
                $jurnalUmumConsignment->transaction_subject = 'Delivery Order';
                $jurnalUmumConsignment->is_coa_category = 0;
                $jurnalUmumConsignment->transaction_type = 'DO';
                $jurnalUmumConsignment->save();

                $jurnalMasterUmumInventoryInTransit = new JurnalUmum;
                $jurnalMasterUmumInventoryInTransit->kode_transaksi = $this->header->delivery_order_no;
                $jurnalMasterUmumInventoryInTransit->tanggal_transaksi = $this->header->delivery_date;
                $jurnalMasterUmumInventoryInTransit->coa_id = $detail->product->productMasterCategory->coa_inventory_in_transit;
                $jurnalMasterUmumInventoryInTransit->branch_id = $this->header->sender_branch_id;
                $jurnalMasterUmumInventoryInTransit->total = $salePrice;
                $jurnalMasterUmumInventoryInTransit->debet_kredit = 'D';
                $jurnalMasterUmumInventoryInTransit->tanggal_posting = date('Y-m-d');
                $jurnalMasterUmumInventoryInTransit->transaction_subject = 'Delivery Order';
                $jurnalMasterUmumInventoryInTransit->is_coa_category = 1;
                $jurnalMasterUmumInventoryInTransit->transaction_type = 'DO';
                $jurnalMasterUmumInventoryInTransit->save();
                
                //save consignment product sub master category
                $jurnalUmumInventoryInTransit = new JurnalUmum;
                $jurnalUmumInventoryInTransit->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumInventoryInTransit->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumInventoryInTransit->coa_id = $detail->product->productSubMasterCategory->coa_consignment_inventory;
                $jurnalUmumInventoryInTransit->branch_id = $this->header->sender_branch_id;
                $jurnalUmumInventoryInTransit->total = $salePrice;
                $jurnalUmumInventoryInTransit->debet_kredit = 'K';
                $jurnalUmumInventoryInTransit->tanggal_posting = date('Y-m-d');
                $jurnalUmumInventoryInTransit->transaction_subject = 'Delivery Order';
                $jurnalUmumInventoryInTransit->is_coa_category = 0;
                $jurnalUmumInventoryInTransit->transaction_type = 'DO';
                $jurnalUmumInventoryInTransit->save();
//                $coaMasterGroupHpp = Coa::model()->findByAttributes(array('code'=> '520.00.000'));
//                $jurnalUmumMasterGroupHpp = new JurnalUmum;
//                $jurnalUmumMasterGroupHpp->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupHpp->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupHpp->coa_id = $coaMasterGroupHpp->id;
//                $jurnalUmumMasterGroupHpp->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupHpp->total = $hppPrice;
//                $jurnalUmumMasterGroupHpp->debet_kredit = 'D';
//                $jurnalUmumMasterGroupHpp->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupHpp->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupHpp->is_coa_category = 1;
//                $jurnalUmumMasterGroupHpp->transaction_type = 'DO';
//                $jurnalUmumMasterGroupHpp->save();
                
                //save coa hpp product master category
//                $coaMasterHpp = Coa::model()->findByPk($detail->product->productMasterCategory->coa_hpp);
//                $getCoaMasterHpp = $coaMasterHpp->code;
//                $coaMasterHppWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaMasterHpp));
//                $jurnalUmumMasterHpp = new JurnalUmum;
//                $jurnalUmumMasterHpp->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterHpp->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterHpp->coa_id = $coaMasterHppWithCode->id;
//                $jurnalUmumMasterHpp->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterHpp->total = $hppPrice;
//                $jurnalUmumMasterHpp->debet_kredit = 'D';
//                $jurnalUmumMasterHpp->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterHpp->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterHpp->is_coa_category = 1;
//                $jurnalUmumMasterHpp->transaction_type = 'DO';
//                $jurnalUmumMasterHpp->save();
//                
//                //save coa hpp product sub master category
//                $coaHpp = Coa::model()->findByPk($detail->product->productSubMasterCategory->coa_hpp);
//                $getCoaHpp = $coaHpp->code;
//                $coaHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHpp));
//                $jurnalUmumHpp = new JurnalUmum;
//                $jurnalUmumHpp->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumHpp->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumHpp->coa_id = $coaHppWithCode->id;
//                $jurnalUmumHpp->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumHpp->total = $hppPrice;
//                $jurnalUmumHpp->debet_kredit = 'D';
//                $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
//                $jurnalUmumHpp->transaction_subject = 'Delivery Order';
//                $jurnalUmumHpp->is_coa_category = 0;
//                $jurnalUmumHpp->transaction_type = 'DO';
//                $jurnalUmumHpp->save();

                //K 
//                $coaMasterGroupPenjualan = Coa::model()->findByAttributes(array('code'=> '411.00.000'));
//                $jurnalUmumMasterGroupPenjualan = new JurnalUmum;
//                $jurnalUmumMasterGroupPenjualan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupPenjualan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupPenjualan->coa_id = $coaMasterGroupPenjualan->id;
//                $jurnalUmumMasterGroupPenjualan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupPenjualan->total = $salePrice;
//                $jurnalUmumMasterGroupPenjualan->debet_kredit = 'K';
//                $jurnalUmumMasterGroupPenjualan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupPenjualan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupPenjualan->is_coa_category = 1;
//                $jurnalUmumMasterGroupPenjualan->transaction_type = 'DO';
//                $jurnalUmumMasterGroupPenjualan->save();

                //save coa penjualan barang product master
//                $coaMasterPenjualan = Coa::model()->findByPk($detail->product->productMasterCategory->coa_penjualan_barang_dagang);
//                $getCoaMasterPenjualan = $coaMasterPenjualan->code;
//                $coaMasterPenjualanWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaMasterPenjualan));
//                $jurnalUmumMasterPenjualan = new JurnalUmum;
//                $jurnalUmumMasterPenjualan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterPenjualan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterPenjualan->coa_id = $coaMasterPenjualanWithCode->id;
//                $jurnalUmumMasterPenjualan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterPenjualan->total = $salePrice;
//                $jurnalUmumMasterPenjualan->debet_kredit = 'K';
//                $jurnalUmumMasterPenjualan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterPenjualan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterPenjualan->is_coa_category = 1;
//                $jurnalUmumMasterPenjualan->transaction_type = 'DO';
//                $jurnalUmumMasterPenjualan->save();
//                
//                //save coa penjualan barang product sub master
//                $coaPenjualan = Coa::model()->findByPk($detail->product->productSubMasterCategory->coa_penjualan_barang_dagang);
//                $getCoaPenjualan = $coaPenjualan->code;
//                $coaPenjualanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPenjualan));
//                $jurnalUmumPenjualan = new JurnalUmum;
//                $jurnalUmumPenjualan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumPenjualan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumPenjualan->coa_id = $coaPenjualanWithCode->id;
//                $jurnalUmumPenjualan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumPenjualan->total = $salePrice;
//                $jurnalUmumPenjualan->debet_kredit = 'K';
//                $jurnalUmumPenjualan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumPenjualan->transaction_subject = 'Delivery Order';
//                $jurnalUmumPenjualan->is_coa_category = 0;
//                $jurnalUmumPenjualan->transaction_type = 'DO';
//                $jurnalUmumPenjualan->save();

//                $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
//                $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
//                $jurnalUmumMasterGroupPersediaan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
//                $jurnalUmumMasterGroupPersediaan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupPersediaan->total = $hppPrice;
//                $jurnalUmumMasterGroupPersediaan->debet_kredit = 'K';
//                $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
//                $jurnalUmumMasterGroupPersediaan->transaction_type = 'DO';
//                $jurnalUmumMasterGroupPersediaan->save();
                
                //save coa persediaan product master
//                $coaMasterPersediaan = Coa::model()->findByPk($detail->product->productMasterCategory->coa_persediaan_barang_dagang);
//                $getCoaMasterPersediaan = $coaMasterPersediaan->code;
//                $coaMasterPersediaanWithCode = Coa::model()->findByAttributes(array('code'=>$getCoaMasterPersediaan));
//                $jurnalUmumMasterPersediaan = new JurnalUmum;
//                $jurnalUmumMasterPersediaan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterPersediaan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterPersediaan->coa_id = $coaMasterPersediaanWithCode->id;
//                $jurnalUmumMasterPersediaan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterPersediaan->total = $hppPrice;
//                $jurnalUmumMasterPersediaan->debet_kredit = 'K';
//                $jurnalUmumMasterPersediaan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterPersediaan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterPersediaan->is_coa_category = 1;
//                $jurnalUmumMasterPersediaan->transaction_type = 'DO';
//                $jurnalUmumMasterPersediaan->save();
//                    
//                //save coa persedian product sub master
//                $coaPersediaan = Coa::model()->findByPk($detail->product->productSubMasterCategory->coa_persediaan_barang_dagang);
//                $getCoaPersediaan = $coaPersediaan->code;
//                $coaPersediaanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPersediaan));
//                $jurnalUmumPersediaan = new JurnalUmum;
//                $jurnalUmumPersediaan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumPersediaan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumPersediaan->coa_id = $coaPersediaanWithCode->id;
//                $jurnalUmumPersediaan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumPersediaan->total = $hppPrice;
//                $jurnalUmumPersediaan->debet_kredit = 'K';
//                $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumPersediaan->transaction_subject = 'Delivery Order';
//                $jurnalUmumPersediaan->is_coa_category = 0;
//                $jurnalUmumPersediaan->transaction_type = 'DO';
//                $jurnalUmumPersediaan->save();
            } else if ($this->header->request_type == 'Transfer Request') {
                $criteria = new CDbCriteria;
                $criteria->together = 'true';
                $criteria->with = array('deliveryOrder');
                $criteria->condition = "deliveryOrder.transfer_request_id =" . $this->header->transfer_request_id . " AND delivery_order_id != " . $this->header->id;
                $deliveryItemDetails = TransactionDeliveryOrderDetail::model()->findAll($criteria);

                $quantity = 0;
                
                foreach ($deliveryItemDetails as $deliveryItemDetail)
                    $quantity += $deliveryItemDetail->quantity_delivery;

                $this->headerDetail = TransactionTransferRequestDetail::model()->findByAttributes(array('id' => $detail->transfer_request_detail_id, 'transfer_request_id' => $this->header->transfer_request_id));
                $this->headerDetail->quantity_delivery_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
                $this->headerDetail->quantity_delivery = $quantity + $detail->quantity_delivery;
                $left_quantity = $this->headerDetail->quantity_delivery_left;
                $this->headerDetail->save(false);
                $detail->quantity_receive_left = $detail->quantity_delivery;

                $transfer = TransactionTransferRequest::model()->findByPk($this->header->transfer_request_id);
                $branch = Branch::model()->findByPk($this->header->sender_branch_id);
                $hppPrice = $detail->product->hpp * $detail->quantity_delivery;

//                $coaMasterGroupPersediaan = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
//                $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
//                $jurnalUmumMasterGroupPersediaan->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupPersediaan->id;
//                $jurnalUmumMasterGroupPersediaan->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupPersediaan->total = $hppPrice;
//                $jurnalUmumMasterGroupPersediaan->debet_kredit = 'D';
//                $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupPersediaan->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
//                $jurnalUmumMasterGroupPersediaan->transaction_type = 'DO';
//                $jurnalUmumMasterGroupPersediaan->save();

                //save coa persediaan product master
                $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                $jurnalUmumMasterOutstandingPart->branch_id = $this->header->sender_branch_id;
                $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterOutstandingPart->transaction_subject = 'Delivery Order';
                $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
                $jurnalUmumMasterOutstandingPart->transaction_type = 'DO';
                $jurnalUmumMasterOutstandingPart->save();

                //save coa persedian product sub master
                $jurnalUmumOutstandingPart = new JurnalUmum;
                $jurnalUmumOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumOutstandingPart->coa_id = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                $jurnalUmumOutstandingPart->branch_id = $this->header->sender_branch_id;
                $jurnalUmumOutstandingPart->total = $hppPrice;
                $jurnalUmumOutstandingPart->debet_kredit = 'D';
                $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstandingPart->transaction_subject = 'Delivery Order';
                $jurnalUmumOutstandingPart->is_coa_category = 0;
                $jurnalUmumOutstandingPart->transaction_type = 'DO';
                $jurnalUmumOutstandingPart->save();
                
//                $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '105.00.000'));
//                $jurnalUmumMasterGroupInventory = new JurnalUmum;
//                $jurnalUmumMasterGroupInventory->kode_transaksi = $this->header->delivery_order_no;
//                $jurnalUmumMasterGroupInventory->tanggal_transaksi = $this->header->delivery_date;
//                $jurnalUmumMasterGroupInventory->coa_id = $coaMasterGroupInventory->id;
//                $jurnalUmumMasterGroupInventory->branch_id = $this->header->sender_branch_id;
//                $jurnalUmumMasterGroupInventory->total = $hppPrice;
//                $jurnalUmumMasterGroupInventory->debet_kredit = 'K';
//                $jurnalUmumMasterGroupInventory->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterGroupInventory->transaction_subject = 'Delivery Order';
//                $jurnalUmumMasterGroupInventory->is_coa_category = 1;
//                $jurnalUmumMasterGroupInventory->transaction_type = 'DO';
//                $jurnalUmumMasterGroupInventory->save();

                //save product master category coa inventory in transit
                $coaMasterInventory = Coa::model()->findByPk($detail->product->productMasterCategory->coaInventoryInTransit->id);
                $getCoaMasterInventory = $coaMasterInventory->code;
                $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
                $jurnalUmumMasterInventory = new JurnalUmum;
                $jurnalUmumMasterInventory->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumMasterInventory->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumMasterInventory->coa_id = $coaMasterInventoryWithCode->id;
                $jurnalUmumMasterInventory->branch_id = $this->header->sender_branch_id;
                $jurnalUmumMasterInventory->total = $hppPrice;
                $jurnalUmumMasterInventory->debet_kredit = 'K';
                $jurnalUmumMasterInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumMasterInventory->transaction_subject = 'Delivery Order';
                $jurnalUmumMasterInventory->is_coa_category = 1;
                $jurnalUmumMasterInventory->transaction_type = 'DO';
                $jurnalUmumMasterInventory->save();

                //save product sub master category coa inventory in transit
                $coaInventory = Coa::model()->findByPk($detail->product->productSubMasterCategory->coaInventoryInTransit->id);
                $getCoaInventory = $coaInventory->code;
                $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                $jurnalUmumInventory = new JurnalUmum;
                $jurnalUmumInventory->kode_transaksi = $this->header->delivery_order_no;
                $jurnalUmumInventory->tanggal_transaksi = $this->header->delivery_date;
                $jurnalUmumInventory->coa_id = $coaInventoryWithCode->id;
                $jurnalUmumInventory->branch_id = $this->header->sender_branch_id;
                $jurnalUmumInventory->total = $hppPrice;
                $jurnalUmumInventory->debet_kredit = 'K';
                $jurnalUmumInventory->tanggal_posting = date('Y-m-d');
                $jurnalUmumInventory->transaction_subject = 'Delivery Order';
                $jurnalUmumInventory->is_coa_category = 0;
                $jurnalUmumInventory->transaction_type = 'DO';
                $jurnalUmumInventory->save();

            }
            $detail->quantity_request_left = $left_quantity;
            $valid = $detail->save() && $valid;
            $new_detail[] = $detail->id;
            //echo 'test';
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionDeliveryOrderDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
}