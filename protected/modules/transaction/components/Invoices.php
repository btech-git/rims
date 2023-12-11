<?php

class Invoices extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(invoice_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(invoice_number, '/', 2), '/', -1), '.', -1)";
        $invoiceHeader = InvoiceHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($invoiceHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $invoiceHeader->branch->code;
            $this->header->invoice_number = $invoiceHeader->invoice_number;
        }

        $this->header->setCodeNumberByNext('invoice_number', $branchCode, InvoiceHeader::CONSTANT, $currentMonth, $currentYear);
    }
    
    public function addDetails($requestType, $requestId) {

        if ($requestType == 1) {
            $saleOrders = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $requestId));
            foreach ($saleOrders as $key => $saleOrder) {
                $detail = new InvoiceDetail();
                $detail->product_id = $saleOrder->product_id;
                $detail->quantity = $saleOrder->quantity;
                $detail->unit_price = $saleOrder->unit_price;
                $detail->total_price = $saleOrder->total_price;
                $detail->discount = 0.00;
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($requestType == 2) {

            $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $requestId));
            if (count($registrationProducts) != 0) {
                foreach ($registrationProducts as $key => $registrationProduct) {
                    $detail = new InvoiceDetail();
                    $detail->product_id = $registrationProduct->product_id;
                    $detail->quantity = $registrationProduct->quantity;
                    $detail->unit_price = $registrationProduct->sale_price;
//                    $detail->discount = $registrationProduct->discountAmount;
                    $detail->total_price = $registrationProduct->total_price;
                    $this->details[] = $detail;
                }
            }
            $registrationServices = RegistrationService::model()->findAllByAttributes(array('registration_transaction_id' => $requestId));
            if (count($registrationServices) != 0) {
                foreach ($registrationServices as $key => $registrationService) {
                    $detail = new InvoiceDetail();
                    $detail->service_id = $registrationService->service_id;
                    $detail->quantity = 1;
                    $detail->unit_price = $registrationService->price;
//                    $detail->discount = $registrationService->discountAmount;
                    $detail->total_price = $registrationService->total_price;
                    $this->details[] = $detail;
                }
            }
            $registrationQuickServices = RegistrationQuickService::model()->findAllByAttributes(array('registration_transaction_id' => $requestId));
            if (count($registrationQuickServices) != 0) {
                foreach ($registrationQuickServices as $registrationQuickService) {
                    $detail = new InvoiceDetail();
                    $detail->quick_service_id = $registrationQuickService->quick_service_id;
                    $detail->quantity = 1;
                    $detail->unit_price = $registrationQuickService->price;
                    $detail->total_price = $registrationQuickService->price;
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
        $this->header->payment_date_estimate = $this->header->due_date;
        $valid = $this->header->save();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->invoice_id = $this->header->id;
            $valid = $detail->save(false) && $valid;
        }

        $registrationTransaction = RegistrationTransaction::model()->findByPk($this->header->registration_transaction_id);
        $registrationTransaction->payment_status = 'INVOICING';
        $valid = $registrationTransaction->update(array('payment_status'));
        
        JurnalUmum::model()->deleteAllByAttributes(array(
            'kode_transaksi' => $this->header->invoice_number,
        ));

        $transactionType = 'Invoice'; //$this->header->registrationTransaction->repair_type == 'GR' ? 'Invoice GR' : 'Invoice BR';
        $postingDate = date('Y-m-d');
        $transactionCode = $this->header->invoice_number;
        $transactionDate = $this->header->invoice_date;
        $branchId = $this->header->branch_id;
        $transactionSubject = $this->header->customer->name;
        $remark = $this->header->vehicle->plate_number;

        if ($this->header->registrationTransaction->repair_type == 'GR') {
            $coaReceivableId = ($this->header->customer->customer_type == 'Company') ? $this->header->customer->coa_id : 1449;
        } else {
            $coaReceivableId = (empty($this->header->registrationTransaction->insurance_company_id)) ? $this->header->customer->coa_id : $this->header->registrationTransaction->insuranceCompany->coa_id;
        }

        $journalReferences = array();
        $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array(
            'registration_transaction_id' => $this->header->registration_transaction_id
        ));
        $registrationServices = RegistrationService::model()->findAllByAttributes(array(
            'registration_transaction_id' => $this->header->registration_transaction_id,
            'is_quick_service' => 0
        ));
        
        $jurnalUmumReceivable = new JurnalUmum;
        $jurnalUmumReceivable->kode_transaksi = $transactionCode;
        $jurnalUmumReceivable->tanggal_transaksi = $transactionDate;
        $jurnalUmumReceivable->coa_id = $coaReceivableId;
        $jurnalUmumReceivable->branch_id = $this->header->branch_id;
        $jurnalUmumReceivable->total = $this->header->registrationTransaction->subtotal_product + $this->header->registrationTransaction->subtotal_service + $this->header->registrationTransaction->ppn_price;
        $jurnalUmumReceivable->debet_kredit = 'D';
        $jurnalUmumReceivable->tanggal_posting = date('Y-m-d');
        $jurnalUmumReceivable->transaction_subject = $transactionSubject;
        $jurnalUmumReceivable->remark = $remark;
        $jurnalUmumReceivable->is_coa_category = 0;
        $jurnalUmumReceivable->transaction_type = $transactionType;
        $valid = $jurnalUmumReceivable->save() && $valid;

        if ($this->header->registrationTransaction->ppn_price > 0.00) {
            $coaPpn = Coa::model()->findByAttributes(array('code' => '224.00.001'));
            $jurnalUmumPpn = new JurnalUmum;
            $jurnalUmumPpn->kode_transaksi = $transactionCode;
            $jurnalUmumPpn->tanggal_transaksi = $transactionDate;
            $jurnalUmumPpn->coa_id = $coaPpn->id;
            $jurnalUmumPpn->branch_id = $this->header->branch_id;
            $jurnalUmumPpn->total = $this->header->registrationTransaction->ppn_price;
            $jurnalUmumPpn->debet_kredit = 'K';
            $jurnalUmumPpn->tanggal_posting = date('Y-m-d');
            $jurnalUmumPpn->transaction_subject = $transactionSubject;
            $jurnalUmumPpn->remark = $remark;
            $jurnalUmumPpn->is_coa_category = 0;
            $jurnalUmumPpn->transaction_type = $transactionType;
            $valid = $jurnalUmumPpn->save() && $valid;
        }

        if (count($registrationProducts) > 0) {
            foreach ($registrationProducts as $key => $rProduct) {
                $jurnalUmumHpp = $rProduct->product->productSubMasterCategory->coa_hpp;
                $journalReferences[$jurnalUmumHpp]['debet_kredit'] = 'D';
                $journalReferences[$jurnalUmumHpp]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumHpp]['values'][] = $rProduct->product->averageCogs * $rProduct->quantity;

                $jurnalUmumPenjualan = $rProduct->product->productSubMasterCategory->coa_penjualan_barang_dagang;
                $journalReferences[$jurnalUmumPenjualan]['debet_kredit'] = 'K';
                $journalReferences[$jurnalUmumPenjualan]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumPenjualan]['values'][] = $rProduct->sale_price * $rProduct->quantity;

                $jurnalUmumOutstandingPart = $rProduct->product->productSubMasterCategory->coa_outstanding_part_id;
                $journalReferences[$jurnalUmumOutstandingPart]['debet_kredit'] = 'K';
                $journalReferences[$jurnalUmumOutstandingPart]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumOutstandingPart]['values'][] = $rProduct->product->averageCogs * $rProduct->quantity;

                if ($rProduct->discount > 0.00) {
                    $jurnalUmumDiskon = $rProduct->product->productSubMasterCategory->coa_diskon_penjualan;
                    $journalReferences[$jurnalUmumDiskon]['debet_kredit'] = 'D';
                    $journalReferences[$jurnalUmumDiskon]['is_coa_category'] = 0;
                    $journalReferences[$jurnalUmumDiskon]['values'][] = $rProduct->discountAmount;
                }
            }
        }

        if ($registrationServices > 0) {
            foreach ($registrationServices as $key => $rService) {
                $jurnalUmumPendapatanJasa = $rService->service->serviceCategory->coa_id;
                $journalReferences[$jurnalUmumPendapatanJasa]['debet_kredit'] = 'K';
                $journalReferences[$jurnalUmumPendapatanJasa]['is_coa_category'] = 0;
                $journalReferences[$jurnalUmumPendapatanJasa]['values'][] = $rService->price;

                if ($rService->discount_price > 0.00) {
                    $jurnalUmumDiscountPendapatanJasa = $rService->service->serviceCategory->coa_diskon_service;
                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['debet_kredit'] = 'D';
                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['is_coa_category'] = 0;
                    $journalReferences[$jurnalUmumDiscountPendapatanJasa]['values'][] = $rService->discountAmount;
                }
            }
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
            $jurnalUmumPersediaan->remark = $remark;
            $jurnalUmumPersediaan->is_coa_category = $journalReference['is_coa_category'];
            $jurnalUmumPersediaan->transaction_type = $transactionType;
            $jurnalUmumPersediaan->save();
        }
            
        $real = new RegistrationRealizationProcess();
        $real->registration_transaction_id = $this->header->id;
        $real->name = 'Invoice';
        $real->checked = 1;
        $real->checked_date = date('Y-m-d');
        $real->checked_by = Yii::app()->user->getId();
        $real->detail = 'Generate Invoice with number #' . $this->header->invoice_number;
        $real->save();
        
        return $valid;
    }
}
