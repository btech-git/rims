<?php

class SalesOrders extends CComponent {

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
        $cnYearCondition = "substring_index(substring_index(substring_index(sale_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(sale_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionSaleOrder = TransactionSalesOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :requester_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':requester_branch_id' => $requesterBranchId),
        ));

        if ($transactionSaleOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionSaleOrder->requesterBranch->code;
            $this->header->sale_order_no = $transactionSaleOrder->sale_order_no;
        }

        $this->header->setCodeNumberByNext('sale_order_no', $branchCode, TransactionSalesOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $detail = new TransactionSalesOrderDetail();
        $detail->product_id = $productId;
        $product = Product::model()->findByPK($productId);
        $detail->product_name = $product->name;
        $detail->unit_id = $product->unit_id;
//		if($product->ppn == 1)
//			$detail->retail_price = $product->retail_price / 1.1;
//		else
        $detail->retail_price = $product->retail_price;
        $detail->hpp = $product->hpp;
        $this->details[] = $detail;

        //echo "5";
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
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

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {

                $fields = array('quantity');
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
        $isNewRecord = $this->header->isNewRecord;
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->price_before_discount = $this->subTotalBeforeDiscount;
        $this->header->discount = $this->subTotalDiscount;
        $this->header->ppn_price = $this->taxAmount;
        $this->header->subtotal = $this->subTotal;
        $this->header->total_price = $this->grandTotal;
        $valid = $this->header->save();
        //echo "valid";

        $requestDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->sales_order_id = $this->header->id;
            $detail->unit_price = $detail->unitPrice;
            $detail->total_price = $detail->grandTotal;
            $detail->total_quantity = $detail->totalQuantity;
            $detail->discount = $detail->totalDiscount;

            if ($isNewRecord)
                $detail->sales_order_quantity_left = $detail->total_quantity;

            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
            //echo 'test';
        }


        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionSalesOrderDetail::model()->deleteAll($criteria);
        }


        return $valid;
    }

//    public function validateInvoice() {
//        
//        $valid = $this->header->validate(array('payment_status'));
//
//        return $valid;
//    }

    public function saveInvoice($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->flushInvoice();
            
            if ($valid) {
                $dbTransaction->commit();
            } else {
                $dbTransaction->rollback();
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function flushInvoice() {
        
        $customer = Customer::model()->findByPk($this->header->customer_id);
        $duedate = $customer->tenor != "" ? date('Y-m-d', strtotime("+" . $customer->tenor . " days")) : date('Y-m-d', strtotime("+1 months"));

        $model = new InvoiceHeader();
        $model->generateCodeNumber(Yii::app()->dateFormatter->format('M', strtotime($model->invoice_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($model->invoice_date)), $this->header->requester_branch_id);
        $model->invoice_date = date('Y-m-d');
        $model->due_date = $duedate;
        $model->payment_date_estimate = $duedate;
        $model->coa_bank_id_estimate = 7;
        $model->reference_type = 1;
        $model->sales_order_id = $this->header->id;
        $model->customer_id = $this->header->customer_id;
        $model->branch_id = $this->header->requester_branch_id;
        $model->user_id = Yii::app()->user->getId();
        $model->status = "NOT PAID";
        $model->product_price = $this->header->subtotal;
        $model->total_price = $this->header->total_price;
        $model->payment_left = $this->header->total_price;
        $model->ppn = $this->header->ppn;
        $model->ppn_total = $this->header->ppn_price;
        $model->tax_percentage = $this->header->tax_percentage;
        $valid = $model->save(false);

        if ($valid) {
            if (count($this->details) > 0) {
                foreach ($this->details as $salesDetail) {
                    $modelDetail = new InvoiceDetail();
                    $modelDetail->invoice_id = $model->id;
                    $modelDetail->product_id = $salesDetail->product_id;
                    $modelDetail->quantity = $salesDetail->quantity;
                    $modelDetail->unit_price = $salesDetail->unit_price;
                    $modelDetail->total_price = $salesDetail->total_price;
                    $valid = $modelDetail->save(false) && $valid;
                }//end foreach
            } // end if count

            JurnalUmum::model()->deleteAllByAttributes(array(
                'kode_transaksi' => $this->header->sale_order_no,
                'branch_id' => $this->header->requester_branch_id,
            ));

            $transactionType = 'SO';
            $postingDate = date('Y-m-d');
            $transactionCode = $this->header->sale_order_no;
            $transactionDate = $this->header->sale_order_date;
            $branchId = $this->header->requester_branch_id;
            $transactionSubject = $this->header->note;

            $journalReferences = array();

            if ($this->header->payment_type == "Cash") {
                $getCoaKas = '121.00.002';
                $coaKasWithCode = Coa::model()->findByAttributes(array('code' => $getCoaKas));
                $jurnalUmumKas = new JurnalUmum;
                $jurnalUmumKas->kode_transaksi = $this->header->sale_order_no;
                $jurnalUmumKas->tanggal_transaksi = $this->header->sale_order_date;
                $jurnalUmumKas->coa_id = $coaKasWithCode->id;
                $jurnalUmumKas->branch_id = $this->header->requester_branch_id;
                $jurnalUmumKas->total = $this->header->total_price;
                $jurnalUmumKas->debet_kredit = 'D';
                $jurnalUmumKas->tanggal_posting = date('Y-m-d');
                $jurnalUmumKas->transaction_subject = $transactionSubject;
                $jurnalUmumKas->is_coa_category = 0;
                $jurnalUmumKas->transaction_type = 'SO';
                $valid = $jurnalUmumKas->save() && $valid;
            } else {
                //D
                $getCoaPiutang = '121.00.001';
                $coaPiutangWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPiutang));
                $jurnalUmumPiutang = new JurnalUmum;
                $jurnalUmumPiutang->kode_transaksi = $this->header->sale_order_no;
                $jurnalUmumPiutang->tanggal_transaksi = $this->header->sale_order_date;
                $jurnalUmumPiutang->coa_id = $coaPiutangWithCode->id;
                $jurnalUmumPiutang->branch_id = $this->header->requester_branch_id;
                $jurnalUmumPiutang->total = $this->header->total_price;
                $jurnalUmumPiutang->debet_kredit = 'D';
                $jurnalUmumPiutang->tanggal_posting = date('Y-m-d');
                $jurnalUmumPiutang->transaction_subject = $transactionSubject;
                $jurnalUmumPiutang->is_coa_category = 0;
                $jurnalUmumPiutang->transaction_type = 'SO';
                $valid = $jurnalUmumPiutang->save() && $valid;
            }

            foreach ($this->details as $key => $soDetail) {
                $coaId = $soDetail->product->productSubMasterCategory->coa_penjualan_barang_dagang;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 0;
                $journalReferences[$coaId]['values'][] = $soDetail->retail_price * $soDetail->quantity;
                
                if ($soDetail->discount > 0) {
                    $coaId = $soDetail->product->productSubMasterCategory->coa_diskon_penjualan;
                    $journalReferences[$coaId]['debet_kredit'] = 'D';
                    $journalReferences[$coaId]['is_coa_category'] = 0;
                    $journalReferences[$coaId]['values'][] = $soDetail->totalDiscount * $soDetail->quantity;
                }

//                $jurnalUmumPenjualan = new JurnalUmum;
//                $jurnalUmumPenjualan->kode_transaksi = $this->header->sale_order_no;
//                $jurnalUmumPenjualan->tanggal_transaksi = $this->header->sale_order_date;
//                $jurnalUmumPenjualan->coa_id = $soDetail->product->productSubMasterCategory->coa_penjualan_barang_dagang;
//                $jurnalUmumPenjualan->branch_id = $this->header->requester_branch_id;
//                $jurnalUmumPenjualan->total = $soDetail->retail_price * $soDetail->quantity;
//                $jurnalUmumPenjualan->debet_kredit = 'K';
//                $jurnalUmumPenjualan->tanggal_posting = date('Y-m-d');
//                $jurnalUmumPenjualan->transaction_subject = $this->header->customer->name;
//                $jurnalUmumPenjualan->is_coa_category = 0;
//                $jurnalUmumPenjualan->transaction_type = 'SO';
//                $valid = $jurnalUmumPenjualan->save() && $valid;
//
//                if ($soDetail->discount > 0) {
//                    $coaDiskon = Coa::model()->findByPk($soDetail->product->productSubMasterCategory->coaDiskonPenjualan->id);
//                    $getCoaDiskon = $coaDiskon->code;
//                    $coaDiskonWithCode = Coa::model()->findByAttributes(array('code' => $getCoaDiskon));
//
//                    $jurnalUmumDiskon = new JurnalUmum;
//                    $jurnalUmumDiskon->kode_transaksi = $this->header->sale_order_no;
//                    $jurnalUmumDiskon->tanggal_transaksi = $this->header->sale_order_date;
//                    $jurnalUmumDiskon->coa_id = $coaDiskonWithCode->id;
//                    $jurnalUmumDiskon->branch_id = $this->header->requester_branch_id;
//                    $jurnalUmumDiskon->total = $soDetail->totalDiscount * $soDetail->quantity;
//                    $jurnalUmumDiskon->debet_kredit = 'D';
//                    $jurnalUmumDiskon->tanggal_posting = date('Y-m-d');
//                    $jurnalUmumDiskon->transaction_subject = $this->header->customer->name;
//                    $jurnalUmumDiskon->is_coa_category = 0;
//                    $jurnalUmumDiskon->transaction_type = 'SO';
//                    $valid = $jurnalUmumDiskon->save() && $valid;
//                }

                if ($this->header->ppn_price > 0.00) {
                    $getCoaPpn = '224.00.001';
                    $coaPpnWithCode = Coa::model()->findByAttributes(array('code' => $getCoaPpn));
                    $jurnalUmumPpn = new JurnalUmum;
                    $jurnalUmumPpn->kode_transaksi = $this->header->sale_order_no;
                    $jurnalUmumPpn->tanggal_transaksi = $this->header->sale_order_date;
                    $jurnalUmumPpn->coa_id = $coaPpnWithCode->id;
                    $jurnalUmumPpn->branch_id = $this->header->requester_branch_id;
                    $jurnalUmumPpn->total = $this->header->ppn_price;
                    $jurnalUmumPpn->debet_kredit = 'K';
                    $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
                    $jurnalUmumPpn->transaction_subject = $transactionSubject;
                    $jurnalUmumPpn->is_coa_category = 0;
                    $jurnalUmumPpn->transaction_type = 'SO';
                    $valid = $jurnalUmumPpn->save() && $valid;
                }

                $product = Product::model()->findByPk($soDetail->product_id);
                $hppPrice = $product->hpp * $soDetail->quantity;

                $coaId = $soDetail->product->productSubMasterCategory->coa_hpp;
                $journalReferences[$coaId]['debet_kredit'] = 'D';
                $journalReferences[$coaId]['is_coa_category'] = 0;
                $journalReferences[$coaId]['values'][] = $hppPrice;
                
                $coaId = $soDetail->product->productMasterCategory->coa_outstanding_part_id;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 1;
                $journalReferences[$coaId]['values'][] = $hppPrice;
                
                $coaId = $soDetail->product->productSubMasterCategory->coa_outstanding_part_id;
                $journalReferences[$coaId]['debet_kredit'] = 'K';
                $journalReferences[$coaId]['is_coa_category'] = 0;
                $journalReferences[$coaId]['values'][] = $hppPrice;
                
                //D
//                $coaHpp = Coa::model()->findByPk($soDetail->product->productSubMasterCategory->coaHpp->id);
//                $getCoaHpp = $coaHpp->code;
//                $coaHppWithCode = Coa::model()->findByAttributes(array('code' => $getCoaHpp));
//
//                $jurnalUmumHpp = new JurnalUmum;
//                $jurnalUmumHpp->kode_transaksi = $this->header->sale_order_no;
//                $jurnalUmumHpp->tanggal_transaksi = $this->header->sale_order_date;
//                $jurnalUmumHpp->coa_id = $coaHppWithCode->id;
//                $jurnalUmumHpp->branch_id = $this->header->requester_branch_id;
//                $jurnalUmumHpp->total = $hppPrice;
//                $jurnalUmumHpp->debet_kredit = 'D';
//                $jurnalUmumHpp->tanggal_posting = date('Y-m-d');
//                $jurnalUmumHpp->transaction_subject = $this->header->customer->name;
//                $jurnalUmumHpp->is_coa_category = 0;
//                $jurnalUmumHpp->transaction_type = 'SO';
//                $valid = $jurnalUmumHpp->save() && $valid;
//
//                $jurnalUmumMasterOutstandingPart = new JurnalUmum;
//                $jurnalUmumMasterOutstandingPart->kode_transaksi = $this->header->sale_order_no;
//                $jurnalUmumMasterOutstandingPart->tanggal_transaksi = $this->header->sale_order_date;
//                $jurnalUmumMasterOutstandingPart->coa_id = $soDetail->product->productMasterCategory->coa_outstanding_part_id;
//                $jurnalUmumMasterOutstandingPart->branch_id = $this->header->requester_branch_id;
//                $jurnalUmumMasterOutstandingPart->total = $hppPrice;
//                $jurnalUmumMasterOutstandingPart->debet_kredit = 'K';
//                $jurnalUmumMasterOutstandingPart->tanggal_posting = date('Y-m-d');
//                $jurnalUmumMasterOutstandingPart->transaction_subject = $this->header->customer->name;
//                $jurnalUmumMasterOutstandingPart->is_coa_category = 1;
//                $jurnalUmumMasterOutstandingPart->transaction_type = 'SO';
//                $valid = $jurnalUmumMasterOutstandingPart->save() && $valid;
//
//                $jurnalUmumOutstandingPart = new JurnalUmum;
//                $jurnalUmumOutstandingPart->kode_transaksi = $this->header->sale_order_no;
//                $jurnalUmumOutstandingPart->tanggal_transaksi = $this->header->sale_order_date;
//                $jurnalUmumOutstandingPart->coa_id = $soDetail->product->productSubMasterCategory->coa_outstanding_part_id;
//                $jurnalUmumOutstandingPart->branch_id = $this->header->requester_branch_id;
//                $jurnalUmumOutstandingPart->total = $hppPrice;
//                $jurnalUmumOutstandingPart->debet_kredit = 'K';
//                $jurnalUmumOutstandingPart->tanggal_posting = date('Y-m-d');
//                $jurnalUmumOutstandingPart->transaction_subject = $this->header->customer->name;
//                $jurnalUmumOutstandingPart->is_coa_category = 0;
//                $jurnalUmumOutstandingPart->transaction_type = 'SO';
//                $valid = $jurnalUmumOutstandingPart->save() && $valid;
            }
            
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
            }
        }
        
        return $valid;
    }
    
    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->totalQuantity;
        }

        return $total;
    }

    public function getSubTotalDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->totalDiscount * $detail->quantity;
        }

        return $total;
    }

    public function getSubTotalBeforeDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->totalBeforeDiscount;
        }

        return $total;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->subTotal;
        }

        return $total;
    }

    public function getTaxAmount() {
        return ($this->header->ppn == 1) ? $this->subTotal * 11 / 100 : 0.00;
    }

    public function getGrandTotal() {
        return $this->subTotal + $this->taxAmount;
    }

}
