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

    public function addDetails($requestId, $requestType) {

        if ($requestType == 1) {
            $purchases = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $requestId));
            foreach ($purchases as $key => $purchase) {
                if ($purchase->purchase_order_quantity_left > 0) {
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
                }
            } //endforeach
        }//end if
        elseif ($requestType == 2) {
            $deliveries = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $requestId));
            foreach ($deliveries as $key => $delivery) {
                if ($delivery->quantity_receive_left > 0) {
                    $detail = new TransactionReceiveItemDetail();
                    $detail->product_id = $delivery->product_id;
                    $detail->qty_request = $delivery->quantity_delivery;
                    $detail->qty_request_left = $delivery->quantity_receive_left;
                    $detail->quantity_delivered = $delivery->quantity_delivery;
                    $detail->quantity_delivered_left = $delivery->quantity_request_left;
                    $detail->delivery_order_detail_id = $delivery->id;
                    $this->details[] = $detail;
                }
            }
        } elseif ($requestType == 3) {
            $consignments = ConsignmentInDetail::model()->findAllByAttributes(array('consignment_in_id' => $requestId));
            foreach ($consignments as $key => $consignment) {
                if ($consignment->qty_request_left > 0) {
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
        } elseif ($requestType == 4) {
            $movementOuts = MovementOutDetail::model()->findAllByAttributes(array('movement_out_header_id' => $requestId));
            foreach ($movementOuts as $key => $movementOut) {
//                if ($movementOut->quantity_receive_left > 0) {
                    $detail = new TransactionReceiveItemDetail();
                    $detail->product_id = $movementOut->product_id;
                    $detail->qty_request = $movementOut->quantity;
                    $detail->qty_request_left = $movementOut->quantity_receive_left;
                    $detail->movement_out_detail_id = $movementOut->id;
                    $detail->note = 'Movement Out';
                    $detail->barcode_product = null;
                    $this->details[] = $detail;
//                }
            }
        }
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
            $valid = $this->validate() && IdempotentManager::build()->save() && $this->flush();
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
        if ($this->header->request_type == 'Internal Delivery Order') {
            $this->header->invoice_sub_total = 0;
            $this->header->invoice_tax_nominal = 0;
            $this->header->invoice_grand_total = 0;
            $this->header->invoice_grand_total_rounded = 0;
        } else {
            $this->header->invoice_sub_total = $this->subTotal;
            $this->header->invoice_tax_nominal = $this->taxNominal;
            $this->header->invoice_grand_total = $this->grandTotal;
            $this->header->invoice_grand_total_rounded = $this->grandTotalAfterRounding;
        }
        $valid = $this->header->save();

        $requestDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id' => $this->header->id));
        $detail_id = array();

        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }

        $new_detail = array();

        $branch = Branch::model()->findByPk($this->header->recipient_branch_id);
        
        $transactionType = 'RCI';
        $postingDate = date('Y-m-d');
        $transactionCode = $this->header->receive_item_no;
        $transactionDate = $this->header->receive_item_date;
        $branchId = $this->header->recipient_branch_id;
        $transactionSubject = $this->header->note;
        
        if ($this->header->request_type == 'Purchase Order' || $this->header->request_type == 'Consignment In') {
            $transactionSubject = $this->header->supplier->name;
        } else if ($this->header->request_type == 'Internal Delivery Order') {
            $transactionSubject = $this->header->destinationBranch->name;
        }

        $journalReferences = array();
        
        //save request detail
        foreach ($this->details as $detail) {
            
            if ($detail->qty_received == 0) {
                continue;
            }
            
            $detail->receive_item_id = $this->header->id;
            $left_quantity = 0;
            
            if ($this->header->request_type == 'Purchase Order') {
                $left_quantity = $detail->qty_request_left - $detail->qty_received;
            } elseif ($this->header->request_type == 'Internal Delivery Order') {
                $left_quantity = $detail->qty_request - $detail->qty_received - $detail->deliveryOrderDetail->getTotalQuantityReceived();
                $detail->quantity_delivered_left = $left_quantity;
            } elseif ($this->header->request_type == 'Consignment In') {
                $left_quantity = $detail->consignmentInDetail->qty_request_left;
            } else {
                $left_quantity = 0;
            }
            $detail->qty_request_left = $left_quantity;
            $detail->quantity_movement = 0;
            $detail->quantity_movement_left = $detail->qty_received;
            $detail->total_price = $detail->totalPrice;

            $valid = $detail->save() && $valid;
            $new_detail[] = $detail->id;
            
            if ($detail->qty_received > 0) {
                if ($this->header->request_type == 'Purchase Order') {
                    $value = $detail->qty_received * $detail->purchaseOrderDetail->unit_price;
                    $coaId = $detail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $value;
                } else if ($this->header->request_type == 'Internal Delivery Order') {
                    $value = $detail->qty_received * $detail->product->hpp;
                    $coaIdTransit = $detail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaIdTransit]['debet_kredit'] = 'D';
                    $journalReferences[$coaIdTransit]['is_coa_category'] = 0;
                    $journalReferences[$coaIdTransit]['values'][] = $value;
                    $coaIdOutstandingMaster = $detail->product->productMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaIdOutstandingMaster]['debet_kredit'] = 'K';
                    $journalReferences[$coaIdOutstandingMaster]['is_coa_category'] = 1;
                    $journalReferences[$coaIdOutstandingMaster]['values'][] = $value;
                    $coaIdOutstandingSub = $detail->product->productSubMasterCategory->coa_outstanding_part_id;
                    $journalReferences[$coaIdOutstandingSub]['debet_kredit'] = 'K';
                    $journalReferences[$coaIdOutstandingSub]['is_coa_category'] = 0;
                    $journalReferences[$coaIdOutstandingSub]['values'][] = $value;
                } else if ($this->header->request_type == 'Consignment In') {
                    $value = $detail->qty_received * $detail->consignmentInDetail->price;
                    $coaIdTransit = $detail->product->productSubMasterCategory->coa_inventory_in_transit;
                    $journalReferences[$coaIdTransit]['debet_kredit'] = 'D';
                    $journalReferences[$coaIdTransit]['is_coa_category'] = 0;
                    $journalReferences[$coaIdTransit]['values'][] = $value;
                    $coaIdInventory = $detail->product->productSubMasterCategory->coa_consignment_inventory;
                    $journalReferences[$coaIdInventory]['debet_kredit'] = 'K';
                    $journalReferences[$coaIdInventory]['is_coa_category'] = 0;
                    $journalReferences[$coaIdInventory]['values'][] = $value;
                }
            }

            if ($this->header->request_type == 'Purchase Order') {
                $purchaseOrderDetail = TransactionPurchaseOrderDetail::model()->findByAttributes(array('id' => $detail->purchase_order_detail_id, 'purchase_order_id' => $this->header->purchase_order_id));
                $totalQuantityReceived = $purchaseOrderDetail->getTotalQuantityReceived();
                $purchaseOrderDetail->purchase_order_quantity_left = $purchaseOrderDetail->quantity - $totalQuantityReceived;
                $purchaseOrderDetail->receive_quantity = $totalQuantityReceived;

                $purchaseOrderDetail->save(false);

            } else if ($this->header->request_type == 'Internal Delivery Order') {
                $branch = Branch::Model()->findByPk($this->header->recipient_branch_id);

                $deliveryOrderDetail = $detail->deliveryOrderDetail; //TransactionDeliveryOrderDetail::model()->findByAttributes(array('id' => $detail->delivery_order_detail_id, 'delivery_order_id' => $this->header->delivery_order_id));
                $deliveryOrderDetail->quantity_receive_left = $detail->qty_request - $detail->qty_received; // - $deliveryOrderDetail->getTotalQuantityReceived();
                $deliveryOrderDetail->quantity_receive = $detail->qty_received + $deliveryOrderDetail->getTotalQuantityReceived();
                $deliveryOrderDetail->save(false);

            } else if ($this->header->request_type == 'Consignment In') {
                $consignmentDetail = ConsignmentInDetail::model()->findByAttributes(array('id' => $detail->consignment_in_detail_id, 'consignment_in_id' => $this->header->consignment_in_id));
                $consignmentDetail->qty_request_left = $detail->qty_request - $detail->qty_received - $consignmentDetail->getTotalQuantityReceived();
                $consignmentDetail->qty_received = $detail->qty_received + $consignmentDetail->getTotalQuantityReceived();
                $consignmentDetail->save(false);
            }
        }
        
        $totalJournal = 0;
        foreach ($journalReferences as $coaId => $journalReference) {
            $jurnalUmumPersediaan = new JurnalUmum();
            $jurnalUmumPersediaan->kode_transaksi = $transactionCode;
            $jurnalUmumPersediaan->tanggal_transaksi = $transactionDate;
            $jurnalUmumPersediaan->coa_id = $coaId;
            $jurnalUmumPersediaan->branch_id = $branchId;
            $jurnalUmumPersediaan->total = array_sum($journalReference['values']);
            $jurnalUmumPersediaan->debet_kredit = $journalReference['debet_kredit'];
            $jurnalUmumPersediaan->tanggal_posting = $postingDate;
            $jurnalUmumPersediaan->transaction_subject = $transactionSubject;
            $jurnalUmumPersediaan->is_coa_category = $journalReference['is_coa_category'];
            $jurnalUmumPersediaan->transaction_type = $transactionType;
            $jurnalUmumPersediaan->save();
            
            $totalJournal += array_sum($journalReference['values']);
        }

        if ($this->header->request_type == 'Purchase Order') {
            $coaOutstanding = Coa::model()->findByPk($this->header->supplier->coaOutstandingOrder->id);
            $jurnalUmumOutstanding = new JurnalUmum();
            $jurnalUmumOutstanding->kode_transaksi = $this->header->receive_item_no;
            $jurnalUmumOutstanding->tanggal_transaksi = $this->header->receive_item_date;
            $jurnalUmumOutstanding->coa_id = $coaOutstanding->id;
            $jurnalUmumOutstanding->branch_id = $this->header->recipient_branch_id;
            $jurnalUmumOutstanding->total = $totalJournal;
            $jurnalUmumOutstanding->debet_kredit = 'K';
            $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
            $jurnalUmumOutstanding->transaction_subject = $transactionSubject;
            $jurnalUmumOutstanding->is_coa_category = 0;
            $jurnalUmumOutstanding->transaction_type = 'RCI';
            $jurnalUmumOutstanding->save();
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
        return ((int)$this->header->purchaseOrder->ppn === 1) ? $this->subTotal * $this->header->purchaseOrder->tax_percentage / 100 : 0.00;
    }
    
    public function getGrandTotal() {
        return $this->subTotal + $this->taxNominal;
    }
    
    public function getGrandTotalAfterRounding() {
        return $this->header->getGrandTotal() + $this->header->invoice_rounding_nominal;
    }
}
