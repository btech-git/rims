<?php

class ReceiveItems extends CComponent {

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
            print_r($e);
        }

        return $valid;
        //print_r('success');
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

        //print_r($valid);
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

//					$coaMasterGroupInventory = Coa::model()->findByAttributes(array('code'=> '104.00.000'));
//					$jurnalUmumMasterGroupPersediaan = new JurnalUmum;
//					$jurnalUmumMasterGroupPersediaan->kode_transaksi = $this->header->receive_item_no;
//					$jurnalUmumMasterGroupPersediaan->tanggal_transaksi = $this->header->receive_item_date;
//					$jurnalUmumMasterGroupPersediaan->coa_id = $coaMasterGroupInventory->id;
//					$jurnalUmumMasterGroupPersediaan->branch_id = $this->header->recipient_branch_id;
//					$jurnalUmumMasterGroupPersediaan->total = $jumlah;
//					$jurnalUmumMasterGroupPersediaan->debet_kredit = 'D';
//					$jurnalUmumMasterGroupPersediaan->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterGroupPersediaan->transaction_subject = $this->header->supplier->name;
//                    $jurnalUmumMasterGroupPersediaan->is_coa_category = 1;
//                    $jurnalUmumMasterGroupPersediaan->transaction_type = 'RCI';
//					$jurnalUmumMasterGroupPersediaan->save();
//                    
//                    //save coa product master category
//					$coaMasterInventory = Coa::model()->findByPk($detail->purchaseOrderDetail->product->productMasterCategory->coaPersediaanBarangDagang->id);
//					$getcoaMasterInventory = $coaMasterInventory->code;
//					$coaMasterInventoryWithCode = Coa::model()->findByAttributes(array('code'=>$getcoaMasterInventory));
//					$jurnalUmumPersediaanMaster = new JurnalUmum;
//					$jurnalUmumPersediaanMaster->kode_transaksi = $this->header->receive_item_no;
//					$jurnalUmumPersediaanMaster->tanggal_transaksi = $this->header->receive_item_date;
//					$jurnalUmumPersediaanMaster->coa_id = $coaMasterInventoryWithCode->id;
//					$jurnalUmumPersediaanMaster->branch_id = $this->header->recipient_branch_id;
//					$jurnalUmumPersediaanMaster->total = $jumlah;
//					$jurnalUmumPersediaanMaster->debet_kredit = 'D';
//					$jurnalUmumPersediaanMaster->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumPersediaanMaster->transaction_subject = $this->header->supplier->name;
//                    $jurnalUmumPersediaanMaster->is_coa_category = 1;
//                    $jurnalUmumPersediaanMaster->transaction_type = 'RCI';
//					$jurnalUmumPersediaanMaster->save();
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

                        //$jumlah = $detail->quantity_received * $poDetail->unit_price;
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
                    //}


                    /* $purchaseOrder = TransactionPurchaseOrder::model()->findByPk($this->header->purchase_order_id);
                      foreach($purchaseOrder->transactionPurchaseOrderDetails as $key =>$poDetail )
                      {
                      //$coa = $poDetail->product->productSubMasterCategory->coa->id;
                      $cPersediaan = CoaDetail::model()->findByAttributes(array('coa_id'=>$poDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->id,'branch_id'=>$poDetail->purchaseOrder->main_branch_id));
                      if(count($cPersediaan)!= 0){
                      if($poDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->normal_balance == "D"){
                      $cPersediaan->debit += $poDetail->subtotal;
                      }
                      else{
                      $cPersediaan->credit += $poDetail->subtotal;
                      }
                      //$cPersediaan->save(false);
                      }
                      else{
                      $cPersediaan = new CoaDetail;
                      $cPersediaan->coa_id = $poDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->id;
                      $cPersediaan->branch_id = $purchaseOrder->main_branch_id;
                      if($poDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->normal_balance == "D"){
                      $cPersediaan->debit += $poDetail->subtotal;
                      }
                      else{
                      $cPersediaan->credit += $poDetail->subtotal;
                      }

                      }
                      $cPersediaan->save(false);
                      $jurnalUmumPersediaan = new JurnalUmum;
                      $jurnalUmumPersediaan->kode_transaksi = $purchaseOrder->purchase_order_no;
                      $jurnalUmumPersediaan->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                      $jurnalUmumPersediaan->coa_id = $poDetail->product->productSubMasterCategory->coaPersediaanBarangDagang->id;
                      $jurnalUmumPersediaan->total = $poDetail->subtotal;
                      $jurnalUmumPersediaan->debet_kredit = 'D';
                      $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
                      $jurnalUmumPersediaan->save();

                      $cDiskon = CoaDetail::model()->findByAttributes(array('coa_id'=>$poDetail->product->productSubMasterCategory->coaDiskonPembelian->id,'branch_id'=>$purchaseOrder->main_branch_id));
                      if(count($cDiskon)!=0){
                      if($poDetail->product->productSubMasterCategory->coaDiskonPembelian->normal_balance == "D"){
                      $cDiskon->debit += $poDetail->discount;
                      }
                      else{
                      $cDiskon->credit += $poDetail->discount;
                      }

                      }
                      else{
                      $cDiskon = new CoaDetail;
                      $cDiskon->coa_id = $poDetail->product->productSubMasterCategory->coaDiskonPembelian->id;
                      $cDiskon->branch_id = $purchaseOrder->main_branch_id;
                      if($poDetail->product->productSubMasterCategory->coaDiskonPembelian->normal_balance == "D"){
                      $cDiskon->debit += $poDetail->discount;
                      }
                      else{
                      $cDiskon->credit += $poDetail->discount;
                      }

                      }
                      $cDiskon->save(false);
                      $jurnalUmumDiskon = new JurnalUmum;
                      $jurnalUmumDiskon->kode_transaksi = $purchaseOrder->purchase_order_no;
                      $jurnalUmumDiskon->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                      $jurnalUmumDiskon->coa_id = $poDetail->product->productSubMasterCategory->coaDiskonPembelian->id;
                      $jurnalUmumDiskon->total = $poDetail->discount;
                      $jurnalUmumDiskon->debet_kredit = 'D';
                      $jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
                      $jurnalUmumDiskon->save();


                      if($purchaseOrder->ppn == 1){
                      $coaPpn = Coa::model()->findByPk(184);
                      $cPpnMasukan = CoaDetail::model()->findByAttributes(array('coa_id'=>$coaPpn->id,'branch_id'=>$purchaseOrder->main_branch_id));
                      if(count($cPpnMasukan)!=0){
                      if($coaPpn->normal_balance == "D"){
                      $cPpnMasukan->debit += ($poDetail->subtotal - $poDetail->discount)*0.10;
                      }
                      else{
                      $cPpnMasukan->credit += ($poDetail->subtotal - $poDetail->discount)*0.10;
                      }
                      }
                      else{
                      $cPpnMasukan = new CoaDetail;
                      $cPpnMasukan->coa_id = 184;
                      $cPpnMasukan->branch_id = $purchaseOrder->main_branch_id;
                      if($coaPpn->normal_balance == "D"){
                      $cPpnMasukan->debit += ($poDetail->subtotal - $poDetail->discount)*0.10;
                      }
                      else{
                      $cPpnMasukan->credit += ($poDetail->subtotal - $poDetail->discount)*0.10;
                      }
                      }
                      $cPpnMasukan->save(false);

                      $jurnalUmumPpn = new JurnalUmum;
                      $jurnalUmumPpn->kode_transaksi = $purchaseOrder->purchase_order_no;
                      $jurnalUmumPpn->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                      $jurnalUmumPpn->coa_id = 184;
                      $jurnalUmumPpn->total = ($poDetail->subtotal - $poDetail->discount)*0.10;
                      $jurnalUmumPpn->debet_kredit = 'D';
                      $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                      $jurnalUmumPpn->save();
                      }


                      }
                      if($purchaseOrder->payment_type == 'Cash'){
                      $coaCash = CoaDetail::model()->findByAttributes(array('coa_id'=>1,'branch_id'=>$purchaseOrder->main_branch_id));
                      if(count($coaCash)!=0){
                      $coaCash->debit += $purchaseOrder->total_price;
                      }
                      else{
                      $coaCash = new CoaDetail;
                      $coaCash->coa_id = 3;
                      $coaCash->branch_id = $purchaseOrder->main_branch_id;
                      $coaCash->debit += $purchaseOrder->total_price;
                      }
                      $coaCash->save(false);
                      $jurnalUmum = new JurnalUmum;
                      $jurnalUmum->kode_transaksi = $purchaseOrder->purchase_order_no;
                      $jurnalUmum->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                      $jurnalUmum->coa_id = 3;
                      $jurnalUmum->total = $purchaseOrder->total_price;
                      $jurnalUmum->debet_kredit = 'K';
                      $jurnalUmum->tanggal_posting = date('Y-m-d');
                      $jurnalUmum->save();
                      }
                      else{
                      if($purchaseOrder->supplier->coa != "")
                      {
                      $coaCredit = CoaDetail::model()->findByAttributes(array('coa_id'=>$purchaseOrder->supplier->coa->id,'branch_id'=>$purchaseOrder->main_branch_id));
                      if(count($coaCredit)!=0){
                      $coaCredit->debit += $purchaseOrder->total_price;
                      }
                      else{
                      $coaCredit = new CoaDetail;
                      $coaCredit->coa_id = $purchaseOrder->supplier->coa->id;
                      $coaCredit->branch_id = $purchaseOrder->main_branch_id;
                      $coaCredit->debit += $purchaseOrder->total_price;
                      }
                      $coaCredit->save(false);
                      $jurnalUmum = new JurnalUmum;
                      $jurnalUmum->kode_transaksi = $purchaseOrder->purchase_order_no;
                      $jurnalUmum->tanggal_transaksi = $purchaseOrder->purchase_order_date;
                      $jurnalUmum->coa_id = $purchaseOrder->supplier->coa->id;
                      $jurnalUmum->total = $purchaseOrder->total_price;
                      $jurnalUmum->debet_kredit = 'K';
                      $jurnalUmum->tanggal_posting = date('Y-m-d');
                      $jurnalUmum->save();
                      }
                      } */
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

                        //save coa persediaan sub master category 
//                    $coaPersediaan = Coa::model()->findByPk($detail->product->productSubMasterCategory->coaPersediaanBarangDagang->id);
//                    $getCoaPersediaan = $coaPersediaan->code;
//                    $coaPersediaanWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPersediaan));
//                    $jurnalUmumPersediaan = new JurnalUmum;
//                    $jurnalUmumPersediaan->kode_transaksi = $this->header->receive_item_no;
//                    $jurnalUmumPersediaan->tanggal_transaksi = $this->header->receive_item_date;
//                    $jurnalUmumPersediaan->coa_id = $coaPersediaanWithCode->id;
//                    $jurnalUmumPersediaan->branch_id = $this->header->recipient_branch_id;
//                    $jurnalUmumPersediaan->total = $hppPrice;
//                    $jurnalUmumPersediaan->debet_kredit = 'D';
//                    $jurnalUmumPersediaan->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumPersediaan->transaction_subject = $this->header->destinationBranch->name;
//                    $jurnalUmumPersediaan->is_coa_category = 0;
//                    $jurnalUmumPersediaan->transaction_type = 'RCI';
//                    $jurnalUmumPersediaan->save();
//
//                    $coaMasterGroupInterbranch = Coa::model()->findByAttributes(array('code' => '107.00.000'));
//                    $jurnalUmumMasterGroupInterbranch = new JurnalUmum;
//                    $jurnalUmumMasterGroupInterbranch->kode_transaksi = $this->header->receive_item_no;
//                    $jurnalUmumMasterGroupInterbranch->tanggal_transaksi = $this->header->receive_item_date;
//                    $jurnalUmumMasterGroupInterbranch->coa_id = $coaMasterGroupInterbranch->coa_id;
//                    $jurnalUmumMasterGroupInterbranch->branch_id = $this->header->recipient_branch_id;
//                    $jurnalUmumMasterGroupInterbranch->total = $hppPrice;
//                    $jurnalUmumMasterGroupInterbranch->debet_kredit = 'K';
//                    $jurnalUmumMasterGroupInterbranch->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterGroupInterbranch->transaction_subject = $this->header->destinationBranch->name;
//                    $jurnalUmumMasterGroupInterbranch->is_coa_category = 1;
//                    $jurnalUmumMasterGroupInterbranch->transaction_type = 'RCI';
//                    $jurnalUmumMasterGroupInterbranch->save();
//                    
//                    $coaInterbranch = Coa::model()->findByPk($this->header->destinationBranch->coa_interbranch_inventory);
//                    $getCoaInterbranch = $coaInterbranch->code;
//                    $coaInterbranchWithCode = Coa::model()->findByAttributes(array('code' => $getCoaInterbranch));
//                    
//                    $jurnalUmumMasterInterbranch = new JurnalUmum;
//                    $jurnalUmumMasterInterbranch->kode_transaksi = $this->header->receive_item_no;
//                    $jurnalUmumMasterInterbranch->tanggal_transaksi = $this->header->receive_item_date;
//                    $jurnalUmumMasterInterbranch->coa_id = $coaInterbranchWithCode->coa_id;
//                    $jurnalUmumMasterInterbranch->branch_id = $this->header->recipient_branch_id;
//                    $jurnalUmumMasterInterbranch->total = $hppPrice;
//                    $jurnalUmumMasterInterbranch->debet_kredit = 'K';
//                    $jurnalUmumMasterInterbranch->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumMasterInterbranch->transaction_subject = $this->header->destinationBranch->name;
//                    $jurnalUmumMasterInterbranch->is_coa_category = 1;
//                    $jurnalUmumMasterInterbranch->transaction_type = 'RCI';
//                    $jurnalUmumMasterInterbranch->save();
//                    
//                    $jurnalUmumInterbranch = new JurnalUmum;
//                    $jurnalUmumInterbranch->kode_transaksi = $this->header->receive_item_no;
//                    $jurnalUmumInterbranch->tanggal_transaksi = $this->header->receive_item_date;
//                    $jurnalUmumInterbranch->coa_id = $coaInterbranchWithCode->id;
//                    $jurnalUmumInterbranch->branch_id = $this->header->recipient_branch_id;
//                    $jurnalUmumInterbranch->total = $hppPrice;
//                    $jurnalUmumInterbranch->debet_kredit = 'K';
//                    $jurnalUmumInterbranch->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumInterbranch->transaction_subject = $this->header->destinationBranch->name;
//                    $jurnalUmumInterbranch->is_coa_category = 0;
//                    $jurnalUmumInterbranch->transaction_type = 'RCI';
//                    $jurnalUmumInterbranch->save();
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
}
