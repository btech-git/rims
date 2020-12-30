<?php

class ReceiveItems extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;

    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(receive_item_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(receive_item_no, '/', 2), '/', -1), '.', -1)";
        $transactionReceiveItem = TransactionReceiveItem::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND recipient_branch_id = :recipient_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':recipient_branch_id' => $requesterBranchId),
        ));

        if ($transactionReceiveItem == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionReceiveItem->recipientBranch->code;
            $this->header->receive_item_no = $transactionReceiveItem->receive_item_no;
        }

        $this->header->setCodeNumberByNext('receive_item_no', $branchCode, TransactionReceiveItem::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($requestType, $requestId) {

        if ($requestType == 1) {
            //$purchaseOrder = TransactionPurchaseOrder::model()->findByPk($requestId);
            $purchases = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $requestId));
            foreach ($purchases as $key => $purchase) {
                $detail = new TransactionReceiveItemDetail();
                $detail->product_id = $purchase->product_id;
                $receiveDetail = TransactionReceiveItemDetail::model()->findAllByAttributes(array('purchase_order_detail_id' => $requestId, 'receive_item_id' => $this->header->id));
                if (count($receiveDetail) == 0) {
                    $detail->qty_request = $purchase->total_quantity;
                } else {
                    $detail->qty_request = $purchase->purchase_order_quantity_left;
                }

                $detail->qty_request_left = $purchase->purchase_order_quantity_left;
                $detail->purchase_order_detail_id = $purchase->id;
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($requestType == 2) {
            //$transferRequest = TransactionTransferRequest::model()->findByPk($requestId);
            /* $transfers = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id'=>$requestId));
              foreach ($transfers as $key => $transfer) {
              $detail = new TransactionReceiveItemDetail();
              $detail->product_id = $transfer->product_id;
              $detail->qty_request = $transfer->quantity;
              $detail->qty_request_left = $transfer->transfer_request_quantity_left;
              $detail->transfer_request_detail_id = $transfer->id;
              $this->details[] = $detail;
              } */
            $deliveries = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $requestId));
            foreach ($deliveries as $key => $delivery) {
                $detail = new TransactionReceiveItemDetail();
                $detail->product_id = $delivery->product_id;
                $detail->qty_request = $delivery->quantity_delivery;
                $detail->qty_request_left = $delivery->quantity_receive_left;
                $detail->quantity_delivered = $delivery->quantity_delivery;
                $detail->quantity_delivered_left = $delivery->quantity_request_left;
                $detail->delivery_order_detail_id = $delivery->id;
                $this->details[] = $detail;
            }
        } elseif ($requestType == 3) {
            //$transferRequest = TransactionTransferRequest::model()->findByPk($requestId);
            $consignments = ConsignmentInDetail::model()->findAllByAttributes(array('consignment_in_id' => $requestId));
            foreach ($consignments as $key => $consignment) {
                $detail = new TransactionReceiveItemDetail();
                $detail->product_id = $consignment->product_id;
                $detail->qty_request = $consignment->quantity;
                $detail->qty_request_left = $consignment->qty_request_left;
                $detail->consignment_in_detail_id = $consignment->id;
                $detail->note = $consignment->note;
                $detail->barcode_product = $consignment->barcode_product;
                $this->details[] = $detail;
            }
        }
        //echo "5";
    }

    public function removeDetailAt() {
        $this->details = array();
    }

    public function removeDetail($index) {
        array_splice($this->details, $index, 1);
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
            print_r($e);
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

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

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->details) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $this->header->receive_item_no,
            'branch_id' => $this->header->recipient_branch_id,
        ));

        $isNewRecord = $this->header->isNewRecord;
        $this->header->invoice_sub_total = $this->subTotal;
        $this->header->invoice_tax_nominal = $this->taxNominal;
        $this->header->invoice_grand_total = $this->grandTotal;
        $this->header->invoice_grand_total_rounded = $this->grandTotalAfterRounding;
        $valid = $this->header->save();

        $requestDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id' => $this->header->id));
        $detail_id = array();

        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }

        $new_detail = array();

        $branch = Branch::model()->findByPk($this->header->recipient_branch_id);
        //save request detail
        foreach ($this->details as $detail) {
            $detail->receive_item_id = $this->header->id;
            $left_quantity = 0;

            if ($detail->qty_received > 0) {
                if ($this->header->request_type == 'Purchase Order') {
                    $criteria = new CDbCriteria;
                    $criteria->together = 'true';
                    $criteria->with = array('receiveItem');
                    $criteria->condition = "receiveItem.purchase_order_id =" . $this->header->purchase_order_id . " AND receive_item_id != " . $this->header->id;
                    $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);

                    $purchaseOrderDetail = TransactionPurchaseOrderDetail::model()->findByAttributes(array('id' => $detail->purchase_order_detail_id, 'purchase_order_id' => $this->header->purchase_order_id));
                    $purchaseOrderDetail->purchase_order_quantity_left = $detail->qty_request - $detail->qty_received - $purchaseOrderDetail->getTotalQuantityReceived();
                    $purchaseOrderDetail->receive_quantity = $detail->qty_received + $purchaseOrderDetail->getTotalQuantityReceived();

                    $left_quantity = $purchaseOrderDetail->purchase_order_quantity_left;
                    $purchaseOrderDetail->save(false);
                    $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($this->header->purchase_order_id);

                    //foreach ($purchaseOrder->transactionPurchaseOrderDetails as $key => $poDetail) {

                    if ($detail->qty_received > 0) {
                        $jumlah = $detail->qty_received * $detail->purchaseOrderDetail->unit_price;

                        //save coa product sub master category
                        $coaInventory = Coa::model()->findByPk($detail->purchaseOrderDetail->product->productSubMasterCategory->coa_inventory_in_transit);
                        $getCoaInventory = $coaInventory->code;
                        $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                        $jurnalUmumPersediaan = new JurnalUmum;
                        $jurnalUmumPersediaan->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumPersediaan->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumPersediaan->coa_id = $coaInventoryWithCode->id;
                        $jurnalUmumPersediaan->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumPersediaan->total = $jumlah;
                        $jurnalUmumPersediaan->debet_kredit = 'D';
                        $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPersediaan->transaction_subject = $this->header->supplier->name;
                        $jurnalUmumPersediaan->is_coa_category = 0;
                        $jurnalUmumPersediaan->transaction_type = 'RCI';
                        $jurnalUmumPersediaan->save();

                        $coaOutstanding = Coa::model()->findByPk($this->header->supplier->coaOutstandingOrder->id);
                        $getCoaOutstanding = $coaOutstanding->code;
                        $coaOutstandingWithCode = Coa::model()->findByAttributes(array('code' => $getCoaOutstanding));
                        $jurnalUmumOutstanding = new JurnalUmum;
                        $jurnalUmumOutstanding->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumOutstanding->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumOutstanding->coa_id = $coaOutstandingWithCode->id;
                        $jurnalUmumOutstanding->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumOutstanding->total = $jumlah;
                        $jurnalUmumOutstanding->debet_kredit = 'K';
                        $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
                        $jurnalUmumOutstanding->transaction_subject = $this->header->supplier->name;
                        $jurnalUmumOutstanding->is_coa_category = 0;
                        $jurnalUmumOutstanding->transaction_type = 'RCI';
                        $jurnalUmumOutstanding->save();
                    }
                } else if ($this->header->request_type == 'Internal Delivery Order') {
                    $criteria = new CDbCriteria;
                    $criteria->together = 'true';
                    $criteria->with = array('receiveItem');
                    $criteria->condition = "receiveItem.delivery_order_id =" . $this->header->delivery_order_id . " AND receive_item_id != " . $this->header->id;
                    $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);
                    $branch = Branch::Model()->findByPk($this->header->recipient_branch_id);

                    $deliveryOrderDetail = TransactionDeliveryOrderDetail::model()->findByAttributes(array('id' => $detail->delivery_order_detail_id, 'delivery_order_id' => $this->header->delivery_order_id));
                    $deliveryOrderDetail->quantity_receive_left = $detail->qty_request - $detail->qty_received - $deliveryOrderDetail->getTotalQuantityReceived();
                    $deliveryOrderDetail->quantity_receive = $detail->qty_received + $deliveryOrderDetail->getTotalQuantityReceived();
                    $left_quantity = $detail->qty_request - $detail->qty_received - $deliveryOrderDetail->getTotalQuantityReceived();
                    $deliveryOrderDetail->save(false);

                    $detail->quantity_delivered_left = $deliveryOrderDetail->quantity_receive_left;
                    $hppPrice = $detail->product->hpp * $detail->qty_received;

                    if ($detail->qty_received > 0) {
                        $jurnalUmumInventoryInTransit = new JurnalUmum;
                        $jurnalUmumInventoryInTransit->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumInventoryInTransit->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumInventoryInTransit->coa_id = $detail->product->productSubMasterCategory->coa_inventory_in_transit;
                        $jurnalUmumInventoryInTransit->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumInventoryInTransit->total = $hppPrice;
                        $jurnalUmumInventoryInTransit->debet_kredit = 'D';
                        $jurnalUmumInventoryInTransit->tanggal_posting = date('Y-m-d');
                        $jurnalUmumInventoryInTransit->transaction_subject = $this->header->destinationBranch->name;
                        $jurnalUmumInventoryInTransit->is_coa_category = 0;
                        $jurnalUmumInventoryInTransit->transaction_type = 'RCI';
                        $jurnalUmumInventoryInTransit->save();

                        $coaOutstandingOrder = Coa::model()->findByAttributes(array('code' => '202.00.000'));
                        $jurnalUmumOutstandingOrder = new JurnalUmum;
                        $jurnalUmumOutstandingOrder->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumOutstandingOrder->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumOutstandingOrder->coa_id = $coaOutstandingOrder->id;
                        $jurnalUmumOutstandingOrder->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumOutstandingOrder->total = $hppPrice;
                        $jurnalUmumOutstandingOrder->debet_kredit = 'K';
                        $jurnalUmumOutstandingOrder->tanggal_posting = date('Y-m-d');
                        $jurnalUmumOutstandingOrder->transaction_subject = $this->header->destinationBranch->name;
                        $jurnalUmumOutstandingOrder->is_coa_category = 0;
                        $jurnalUmumOutstandingOrder->transaction_type = 'RCI';
                        $jurnalUmumOutstandingOrder->save();

                    }
                } else if ($this->header->request_type == 'Consignment In') {
                    $criteria = new CDbCriteria;
                    $criteria->together = 'true';
                    $criteria->with = array('receiveItem');
                    $criteria->condition = "receiveItem.consignment_in_id =" . $this->header->consignment_in_id . " AND receive_item_id != " . $this->header->id;
                    $receiveItemDetails = TransactionReceiveItemDetail::model()->findAll($criteria);

                    $consignmentDetail = ConsignmentInDetail::model()->findByAttributes(array('id' => $detail->consignment_in_detail_id, 'consignment_in_id' => $this->header->consignment_in_id));

                    $consignmentDetail->qty_request_left = $detail->qty_request - $detail->qty_received - $consignmentDetail->getTotalQuantityReceived();
                    $consignmentDetail->qty_received = $detail->qty_received + $consignmentDetail->getTotalQuantityReceived();
                    $left_quantity = $consignmentDetail->qty_request_left;
                    $consignmentDetail->save(false);
                    $consignment = ConsignmentInHeader::model()->findByPk($this->header->consignment_in_id);

                    $jumlah = $detail->qty_received * $detail->consignmentInDetail->price;

                    if ($detail->qty_received > 0) {
                        $coaMasterGroupInventory = Coa::model()->findByAttributes(array('code' => '104.00.000'));
                        $jurnalUmumMasterGroupPersediaan = new JurnalUmum;
                        $jurnalUmumMasterGroupPersediaan->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupInventory->id;
                        $jurnalUmumMasterGroupPersediaan->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumMasterGroupPersediaan->total = $jumlah;
                        $jurnalUmumMasterGroupPersediaan->debet_kredit = 'D';
                        $jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterGroupPersediaan->transaction_subject = $this->header->supplier->name;
                        $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
                        $jurnalUmumMasterGroupPersediaan->transaction_type = 'RCI';
                        $jurnalUmumMasterGroupPersediaan->save();

                        //save coa product master category
                        $coaMasterInventory = Coa::model()->findByPk($detail->consignmentInDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->id);
                        $getCoaMasterInventory = $coaMasterInventory->code;
                        $coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaMasterInventory));
                        $jurnalUmumMasterPersediaan = new JurnalUmum;
                        $jurnalUmumMasterPersediaan->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumMasterPersediaan->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumMasterPersediaan->coa_id = $coaMasterInventoryWithCode->id;
                        $jurnalUmumMasterPersediaan->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumMasterPersediaan->total = $jumlah;
                        $jurnalUmumMasterPersediaan->debet_kredit = 'D';
                        $jurnalUmumMasterPersediaan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumMasterPersediaan->transaction_subject = $this->header->supplier->name;
                        $jurnalUmumMasterPersediaan->is_coa_category = 1;
                        $jurnalUmumMasterPersediaan->transaction_type = 'RCI';
                        $jurnalUmumMasterPersediaan->save();

                        //save coa sub master category
                        $coaInventory = Coa::model()->findByPk($detail->consignmentInDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->id);
                        $getCoaInventory = $coaInventory->code;
                        $coaInventoryWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInventory));
                        $jurnalUmumPersediaan = new JurnalUmum;
                        $jurnalUmumPersediaan->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumPersediaan->tanggal_transaksi = $this->header->receive_item_date;
                        $jurnalUmumPersediaan->coa_id = $coaInventoryWithCode->id;
                        $jurnalUmumPersediaan->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumPersediaan->total = $jumlah;
                        $jurnalUmumPersediaan->debet_kredit = 'D';
                        $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
                        $jurnalUmumPersediaan->transaction_subject = $this->header->supplier->name;
                        $jurnalUmumPersediaan->is_coa_category = 0;
                        $jurnalUmumPersediaan->transaction_type = 'RCI';
                        $jurnalUmumPersediaan->save();

                        //$jumlah = $detail->quantity_received * $poDetail->unit_price;
                        $coaOutstanding = Coa::model()->findByPk($consignment->supplier->coaOutstandingOrder->id);
                        $getCoaOutstanding = $coaOutstanding->code;
                        $coaOutstandingWithCode = Coa::model()->findByAttributes(array('code' => $getCoaOutstanding));
                        $jurnalUmumOutstanding = new JurnalUmum;
                        $jurnalUmumOutstanding->kode_transaksi = $this->header->receive_item_no;
                        $jurnalUmumOutstanding->tanggal_transaksi = $this->header->receive_item_date;
                        // $jurnalUmumOutstanding->coa_id = $purchaseOrder->supplier->coaOutstandingOrder->id==""?6:7;
                        $jurnalUmumOutstanding->coa_id = $coaOutstandingWithCode->id;
                        $jurnalUmumOutstanding->branch_id = $this->header->recipient_branch_id;
                        $jurnalUmumOutstanding->total = $jumlah;
                        $jurnalUmumOutstanding->debet_kredit = 'K';
                        $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
                        $jurnalUmumOutstanding->transaction_subject = $this->header->supplier->name;
                        $jurnalUmumOutstanding->is_coa_category = 0;
                        $jurnalUmumMasterGroupInventory->transaction_type = 'RCI';
                        $jurnalUmumOutstanding->save();
                    }
                }
                
                $detail->qty_request_left = $left_quantity;
                $detail->quantity_movement = 0;
                $detail->quantity_movement_left = $detail->qty_received;
                $detail->total_price = $detail->totalPrice;

                $valid = $detail->save() && $valid;
                $new_detail[] = $detail->id;
            }
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionReceiveItemDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
    
    public function getSubTotal() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->totalPrice;
        }
        
        return $total;
    }
    
    public function getTaxNominal() {
        return ((int)$this->header->purchaseOrder->ppn === 1) ? $this->subTotal * .1 : 0.00;
    }
    
    public function getGrandTotal() {
        return $this->subTotal + $this->taxNominal;
    }
    
    public function getGrandTotalAfterRounding() {
        return $this->header->getGrandTotal() + $this->header->invoice_rounding_nominal;
    }
}
