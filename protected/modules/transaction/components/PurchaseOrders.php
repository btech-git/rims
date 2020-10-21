<?php

class PurchaseOrders extends CComponent {

    public $header;
    public $details;
    public $detailRequests;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
        $this->detailRequests = array();
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(purchase_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(purchase_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionPurchaseOrder = TransactionPurchaseOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND main_branch_id = :main_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':main_branch_id' => $requesterBranchId),
        ));

        if ($transactionPurchaseOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionPurchaseOrder->mainBranch->code;
            $this->header->purchase_order_no = $transactionPurchaseOrder->purchase_order_no;
        }

        $this->header->setCodeNumberByNext('purchase_order_no', $branchCode, TransactionPurchaseOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {
        $detail = new TransactionPurchaseOrderDetail();
        $detail->product_id = $productId;
        $product = Product::model()->findByPK($productId);
        $detail->unit_id = $product->unit_id;
        $detail->retail_price = $product->retail_price;
        $detail->hpp = $product->hpp;

        $this->details[] = $detail;
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function removeDetailSupplier() {
        $this->details = array();
    }

    public function updateTaxes() {
        foreach ($this->details as $detail)
            $detail->tax_amount = $detail->getTaxAmount($this->header->ppn);
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

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('price');
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
        $isNewRecord = $this->header->isNewRecord;
        
        if (!$isNewRecord) {
            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $this->header->purchase_order_no,
                'tanggal_transaksi' => $this->header->purchase_order_date,
                'branch_id' => $this->header->main_branch_id,
            ));
        }
        
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->price_before_discount = $this->subTotalBeforeDiscount;
        $this->header->discount = $this->subTotalDiscount;
        $this->header->ppn_price = $this->taxAmount;
        $this->header->subtotal = $this->subTotal;
        $this->header->total_price = $this->grandTotal;
        $this->header->payment_amount = 0;
        $this->header->payment_left = $this->grandTotal;
        $valid = $this->header->save();
        
        $purchaseDetails = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $this->header->id));

        $detail_id = array();
        foreach ($purchaseDetails as $purchaseDetail) {
            $detail_id[] = $purchaseDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->purchase_order_id = $this->header->id;
            $detail->unit_price = $detail->unitPrice;
            $detail->total_price = $detail->grandTotal;
            $detail->total_quantity = $detail->quantityAfterBonus;

            if ($isNewRecord)
                $detail->purchase_order_quantity_left = $detail->total_quantity;

            $valid = $detail->save(false) && $valid;

            if (isset($_POST['TransactionPurchaseOrderDetailRequest'][$detail->product_id])) {
                $allRequest = TransactionPurchaseOrderDetailRequest::model()->deleteAll('`purchase_order_detail_id` = :purchase_order_detail_id', array(':purchase_order_detail_id' => $detail->id,));
                $allOrdered = TransactionDetailOrder::model()->deleteAll('`purchase_order_detail_id` = :purchase_order_detail_id', array(':purchase_order_detail_id' => $detail->id,));
                foreach ($_POST['TransactionPurchaseOrderDetailRequest'][$detail->product_id] as $key => $detailOrder) {
                    $detailRequest = new TransactionPurchaseOrderDetailRequest();
                    $detailRequest->purchase_order_detail_id = $detail->id;
                    $detailRequest->purchase_request_id = $detailOrder['purchase_request_id'];
                    $detailRequest->purchase_request_detail_id = $detailOrder['purchase_request_detail_id'];
                    $detailRequest->purchase_request_quantity = $detailOrder['purchase_request_quantity'];
                    $detailRequest->estimate_date_arrival = $detailOrder['estimate_date_arrival'];
                    $detailRequest->purchase_request_branch_id = $detailOrder['purchase_request_branch_id'];
                    $detailRequest->purchase_order_quantity = $detailOrder['purchase_order_quantity'];
                    $detailRequest->notes = $detailOrder['notes'];
                    $detailRequest->save();

                    $criteria = new CDbCriteria;
                    $criteria->condition = "id =" . $detailRequest->id . " AND purchase_request_detail_id = " . $detailRequest->purchase_request_detail_id;
                    $detailOrders = TransactionPurchaseOrderDetailRequest::model()->findAll($criteria);
                    $quantity = 0;
                    
                    foreach ($detailOrders as $detailOrder) {
                        $quantity += $detailOrder->purchase_order_quantity;
                    }
                    
                    $purchaseRequestDetail = TransactionRequestOrderDetail::model()->findByPk($detailRequest->purchase_request_detail_id);
                    $purchaseRequestDetail->purchase_order_quantity = $quantity + $detailRequest->purchase_order_quantity;
                    $purchaseRequestDetail->request_order_quantity_rest = $purchaseRequestDetail->quantity - ($quantity + $detailRequest->purchase_order_quantity);
                    $purchaseRequestDetail->save(false);
                }
            }

            $new_detail[] = $detail->id;
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionPurchaseOrderDetail::model()->deleteAll($criteria);
        }
        
        if (!$isNewRecord) {
            if ($this->header->payment_type == "Cash") {
                $getCoaKas = '101.00.000';
                $coaKasWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKas));
                $jurnalUmumKas = new JurnalUmum;
                $jurnalUmumKas->kode_transaksi = $this->header->purchase_order_no;
                $jurnalUmumKas->tanggal_transaksi = $this->header->purchase_order_date;
                $jurnalUmumKas->coa_id = $coaKasWithCode->id;
                $jurnalUmumKas->branch_id = $this->header->main_branch_id;
                $jurnalUmumKas->total = $this->header->subtotal;
                $jurnalUmumKas->debet_kredit = 'K';
                $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                $jurnalUmumKas->transaction_subject = $this->header->supplier->name;
                $jurnalUmumKas->is_coa_category = 0;
                $jurnalUmumKas->transaction_type = 'PO';
                $jurnalUmumKas->save();
            } else {
                $getCoaPayableWithCode = Coa::model()->findByAttributes(array('code' => '201.00.000'));
                $jurnalUmumPayable = new JurnalUmum;
                $jurnalUmumPayable->kode_transaksi = $this->header->purchase_order_no;
                $jurnalUmumPayable->tanggal_transaksi = $this->header->purchase_order_date;
                $jurnalUmumPayable->coa_id = $getCoaPayableWithCode->id;
                $jurnalUmumPayable->branch_id = $this->header->main_branch_id;
                $jurnalUmumPayable->total = $this->header->subtotal;
                $jurnalUmumPayable->debet_kredit = 'D';
                $jurnalUmumPayable->tanggal_posting = date('Y-m-d');
                $jurnalUmumPayable->transaction_subject = $this->header->supplier->name;
                $jurnalUmumPayable->is_coa_category = 1;
                $jurnalUmumPayable->transaction_type = 'PO';
                $jurnalUmumPayable->save();

                $coaOutstanding = Coa::model()->findByPk($this->header->supplier->coaOutstandingOrder->id);
                $getCoaOutstanding = $coaOutstanding->code;
                $coaOutstandingWithCode = Coa::model()->findByAttributes(array('code' => $getCoaOutstanding));
                $jurnalUmumOutstanding = new JurnalUmum;
                $jurnalUmumOutstanding->kode_transaksi = $this->header->purchase_order_no;
                $jurnalUmumOutstanding->tanggal_transaksi = $this->header->purchase_order_date;
                $jurnalUmumOutstanding->coa_id = $coaOutstandingWithCode->id;
                $jurnalUmumOutstanding->branch_id = $this->header->main_branch_id;
                $jurnalUmumOutstanding->total = $this->header->subtotal;
                $jurnalUmumOutstanding->debet_kredit = 'D';
                $jurnalUmumOutstanding->tanggal_posting = date('Y-m-d');
                $jurnalUmumOutstanding->transaction_subject = $this->header->supplier->name;
                $jurnalUmumOutstanding->is_coa_category = 0;
                $jurnalUmumOutstanding->transaction_type = 'PO';
                $jurnalUmumOutstanding->save();

                $coaHutang = Coa::model()->findByPk($this->header->supplier->coa->id);
                $getcoaHutang = $coaHutang->code;
                $coaHutangWithCode = Coa::model()->findByAttributes(array('code' => $getcoaHutang));
                $jurnalUmumHutang = new JurnalUmum;
                $jurnalUmumHutang->kode_transaksi = $this->header->purchase_order_no;
                $jurnalUmumHutang->tanggal_transaksi = $this->header->purchase_order_date;
                $jurnalUmumHutang->coa_id = $coaHutangWithCode->id;
                $jurnalUmumHutang->branch_id = $this->header->main_branch_id;
                $jurnalUmumHutang->total = $this->header->subtotal;
                $jurnalUmumHutang->debet_kredit = 'K';
                $jurnalUmumHutang->tanggal_posting = date('Y-m-d');
                $jurnalUmumHutang->transaction_subject = $this->header->supplier->name;
                $jurnalUmumHutang->is_coa_category = 0;
                $jurnalUmumHutang->transaction_type = 'PO';
                $jurnalUmumHutang->save();
            }
            
            $receiveItems = $this->header->transactionReceiveItems;
            if (count($receiveItems) > 0) {
                foreach($receiveItems as $receiveItem){
                    
                    JurnalUmum::model()->deleteAllByAttributes(array(
                        'kode_transaksi' => $receiveItem->receive_item_no,
                        'tanggal_transaksi' => $receiveItem->receive_item_date,
                        'branch_id' => $receiveItem->recipient_branch_id,
                    ));
                    
                    foreach($receiveItem->transactionReceiveItemDetails as $detail) {
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
                }
            }
        }

        return $valid;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->quantityAfterBonus;

        return $total;
    }

    public function getSubTotalDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->totalDiscount;

        return $total;
    }

    public function getSubTotalBeforeDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->totalBeforeDiscount;

        return $total;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->subTotal;

        return $total;
    }

    public function getTaxAmount() {
        return ($this->header->ppn == 1) ? $this->subTotal * 10 / 100 : 0.00;
    }

    public function getGrandTotal() {
        return $this->subTotal + $this->taxAmount;
    }
}
