<?php

class DeliveryOrders extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
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

    public function addDetails($requestId, $requestType) {
        $this->details = array();

        if ($requestType == 1) {
            $sales = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $requestId));
            foreach ($sales as $key => $sale) {
                if ($sale->remainingQuantityDelivery > 0) {
                    $detail = new TransactionDeliveryOrderDetail();
                    $detail->product_id = $sale->product_id;
                    $detail->quantity_request = $sale->quantity;
                    $detail->quantity_request_left = $sale->remainingQuantityDelivery;
                    $detail->sales_order_detail_id = $sale->id;
                    $this->details[] = $detail;
                }
            } //endforeach
        }//end if
        elseif ($requestType == 2) {
            $sents = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $requestId));
            foreach ($sents as $key => $sent) {
                if ($sent->remainingQuantityDelivery > 0) {
                    $detail = new TransactionDeliveryOrderDetail();
                    $detail->product_id = $sent->product_id;
                    $detail->quantity_request = $sent->quantity;
                    $detail->quantity_request_left = $sent->remainingQuantityDelivery;
                    $detail->sent_request_detail_id = $sent->id;
                    $this->details[] = $detail;
                }
            }
        } elseif ($requestType == 3) {
            $consignments = ConsignmentOutDetail::model()->findAllByAttributes(array('consignment_out_id' => $requestId));
            foreach ($consignments as $key => $consignment) {
                if ($consignment->remainingQuantityDelivery > 0) {
                    $detail = new TransactionDeliveryOrderDetail();
                    $detail->product_id = $consignment->product_id;
                    $detail->quantity_request = $consignment->quantity;
                    $detail->quantity_request_left = $consignment->remainingQuantityDelivery;
                    $detail->consignment_out_detail_id = $consignment->id;
                    $this->details[] = $detail;
                }
            }
        } elseif ($requestType == 4) {
            $transfers = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $requestId));
            foreach ($transfers as $key => $transfer) {
                if ($transfer->quantity_delivery_left > 0) {
                    $detail = new TransactionDeliveryOrderDetail();
                    $detail->product_id = $transfer->product_id;
                    $detail->quantity_request = $transfer->quantity;
                    $detail->quantity_request_left = $transfer->quantity_delivery_left;
                    $detail->transfer_request_detail_id = $transfer->id;
                    $this->details[] = $detail;
                }
            }
        }
    }

    public function removeDetailAt() {
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
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if ($this->header->isNewRecord) {
            $valid = $this->validateDetailsQuantityDifference() && $valid;
        }

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('unit_price');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

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
            if ($detail->quantity_delivery > 0) {
                $detail->delivery_order_id = $this->header->id;
                $detail->quantity_movement = 0;
                $detail->quantity_movement_left = $detail->quantity_delivery;
                $left_quantity = 0;

                if ($this->header->request_type == 'Sales Order') {
                    $criteria = new CDbCriteria;
                    $criteria->together = 'true';
                    $criteria->with = array('deliveryOrder');
                    $criteria->condition = "deliveryOrder.sales_order_id =" . $this->header->sales_order_id . " AND delivery_order_id != " . $this->header->id;
                    $receiveItemDetails = TransactionDeliveryOrderDetail::model()->findAll($criteria);

                    $quantity = 0;

                    foreach ($receiveItemDetails as $receiveItemDetail) {
                        $quantity += $receiveItemDetail->quantity_delivery;
                    }

                    $salesOrderDetail = TransactionSalesOrderDetail::model()->findByAttributes(array('id' => $detail->sales_order_detail_id, 'sales_order_id' => $this->header->sales_order_id));
                    $salesOrderDetail->sales_order_quantity_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
                    $salesOrderDetail->delivery_quantity = $quantity + $detail->quantity_delivery;
                    $left_quantity = $salesOrderDetail->sales_order_quantity_left;
                    $salesOrderDetail->save(false);

                    $branch = Branch::model()->findByPk($this->header->sender_branch_id);
                    $jumlah = $detail->quantity_delivery * $detail->salesOrderDetail->unit_price;

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
                    $jurnalUmumMasterInventory->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumInventory->transaction_subject = $this->header->request_type;
                    $jurnalUmumInventory->is_coa_category = 0;
                    $jurnalUmumInventory->transaction_type = 'DO';
                    $jurnalUmumInventory->save();

                    //save coa persediaan master
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->salesOrderDetail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPart->branch_id = $this->header->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $jumlah;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumOutstandingPart->transaction_subject = $this->header->request_type;
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
                    foreach ($deliveryItemDetails as $deliveryItemDetail) {
                        $quantity += $deliveryItemDetail->quantity_delivery;
                    }

                    $sentRequestDetail = TransactionSentRequestDetail::model()->findByAttributes(array('id' => $detail->sent_request_detail_id, 'sent_request_id' => $this->header->sent_request_id));
                    $sentRequestDetail->sent_request_quantity_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
                    $sentRequestDetail->delivery_quantity = $quantity + $detail->quantity_delivery;

                    $left_quantity = $sentRequestDetail->sent_request_quantity_left;
                    $sentRequestDetail->save(false);
                    $detail->quantity_receive_left = $detail->quantity_delivery;

                    $transfer = TransactionTransferRequest::model()->findByPk($this->header->transfer_request_id);
                    $branch = Branch::model()->findByPk($this->header->sender_branch_id);
                    $hppPrice = $sentRequestDetail->unit_price * $detail->quantity_delivery;

                    //save coa persediaan product master
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPart->branch_id = $this->header->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumOutstandingPart->transaction_subject = $this->header->request_type;
                    $jurnalUmumOutstandingPart->is_coa_category = 0;
                    $jurnalUmumOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumOutstandingPart->save();

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
                    $jurnalUmumMasterInventory->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumInventory->transaction_subject = $this->header->request_type;
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
                    $jurnalMasterUmumConsignment->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumConsignment->transaction_subject = $this->header->request_type;
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
                    $jurnalMasterUmumInventoryInTransit->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumInventoryInTransit->transaction_subject = $this->header->request_type;
                    $jurnalUmumInventoryInTransit->is_coa_category = 0;
                    $jurnalUmumInventoryInTransit->transaction_type = 'DO';
                    $jurnalUmumInventoryInTransit->save();

                } else if ($this->header->request_type == 'Transfer Request') {
                    $criteria = new CDbCriteria;
                    $criteria->together = 'true';
                    $criteria->with = array('deliveryOrder');
                    $criteria->condition = "deliveryOrder.transfer_request_id =" . $this->header->transfer_request_id . " AND delivery_order_id != " . $this->header->id;
                    $deliveryItemDetails = TransactionDeliveryOrderDetail::model()->findAll($criteria);

                    $quantity = 0;

                    foreach ($deliveryItemDetails as $deliveryItemDetail) {
                        $quantity += $deliveryItemDetail->quantity_delivery;
                    }

                    $transferRequestDetail = TransactionTransferRequestDetail::model()->findByAttributes(array('id' => $detail->transfer_request_detail_id, 'transfer_request_id' => $this->header->transfer_request_id));
                    $transferRequestDetail->quantity_delivery_left = $detail->quantity_request - ($detail->quantity_delivery + $quantity);
                    $transferRequestDetail->quantity_delivery = $quantity + $detail->quantity_delivery;
                    $left_quantity = $transferRequestDetail->quantity_delivery_left;
                    $transferRequestDetail->save(false);
                    $detail->quantity_receive_left = $detail->quantity_delivery;

                    $transfer = TransactionTransferRequest::model()->findByPk($this->header->transfer_request_id);
                    $branch = Branch::model()->findByPk($this->header->sender_branch_id);
                    $hppPrice = $transferRequestDetail->unit_price * $detail->quantity_delivery;

                    //save coa persediaan product master
                    $jurnalUmumMasterOutstandingPart = new JurnalUmum;
                    $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->delivery_order_no;
                    $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->delivery_date;
                    $jurnalUmumMasterOutstandingPart->coa_id = $detail->product->productMasterCategory->coa_outstanding_part_id;
                    $jurnalUmumMasterOutstandingPart->branch_id = $this->header->sender_branch_id;
                    $jurnalUmumMasterOutstandingPart->total = $hppPrice;
                    $jurnalUmumMasterOutstandingPart->debet_kredit = 'D';
                    $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
                    $jurnalUmumMasterOutstandingPart->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumOutstandingPart->transaction_subject = $this->header->request_type;
                    $jurnalUmumOutstandingPart->is_coa_category = 0;
                    $jurnalUmumOutstandingPart->transaction_type = 'DO';
                    $jurnalUmumOutstandingPart->save();

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
                    $jurnalUmumMasterInventory->transaction_subject = $this->header->request_type;
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
                    $jurnalUmumInventory->transaction_subject = $this->header->request_type;
                    $jurnalUmumInventory->is_coa_category = 0;
                    $jurnalUmumInventory->transaction_type = 'DO';
                    $jurnalUmumInventory->save();
                }

                $detail->quantity_request_left = $left_quantity;
                $valid = $detail->save() && $valid;
                $new_detail[] = $detail->id;

                //delete pricelist
                $delete_array = array_diff($detail_id, $new_detail);
                if ($delete_array != NULL) {
                    $criteria = new CDbCriteria;
                    $criteria->addInCondition('id', $delete_array);
                    TransactionDeliveryOrderDetail::model()->deleteAll($criteria);
                }
            }
        }
        $this->saveTransactionLog();

        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->delivery_order_no;
        $transactionLog->transaction_date = $this->header->delivery_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $this->actionType;
        
        $newData = $this->header->attributes;
        
        $newData['transactionDeliveryOrderDetails'] = array();
        foreach($this->details as $detail) {
            $newData['transactionDeliveryOrderDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}