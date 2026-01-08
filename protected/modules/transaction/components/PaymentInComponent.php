<?php

class PaymentInComponent extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(payment_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(payment_number, '/', 2), '/', -1), '.', -1)";
        
        $paymentInHeader = PaymentIn::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($paymentInHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $paymentInHeader->branch->code;
            $this->header->payment_number = $paymentInHeader->payment_number;
        }

        $this->header->setCodeNumberByNext('payment_number', $branchCode, PaymentIn::CONSTANT, $currentMonth, $currentYear);
    }

    public function addInvoice($invoiceId) {

        $invoiceHeader = InvoiceHeader::model()->findByPk($invoiceId);

        $exist = false;
        foreach ($this->details as $i => $detail) {
            if ($invoiceHeader->id === $detail->invoice_header_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new PaymentInDetail;
            $detail->invoice_header_id = $invoiceId;
            $detail->total_invoice = $invoiceHeader->total_price;
            $this->details[] = $detail;
        }
    }

    public function removeDetailAt($index) {
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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        $valid = $this->validatePaymentType() && $valid;
        $valid = $this->validateDetailsCount() && $valid;
        $valid = $this->validateDetailsUnique() && $valid;
        $valid = $this->validatePaymentAmount() && $valid;

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('memo', 'total_invoice');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function validatePaymentType() {
        $valid = true;
        if (empty($this->header->paymentType->coa_id) && empty($this->header->company_bank_id)) {
            $valid = false;
            $this->header->addError('error', 'Company Bank harus diisi dulu.');
        }

        return $valid;
    }

    public function validatePaymentAmount() {
        $valid = true;
        if (round($this->totalPayment) > round($this->totalInvoice)) {
            $valid = false;
            $this->header->addError('error', 'Pelunasan tidak dapat melebihi total invoice.');
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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j) {
                    continue;
                }

                if ($this->details[$i]->invoice_header_id === $this->details[$j]->invoice_header_id) {
                    $valid = false;
                    $this->header->addError('error', 'Invoice tidak boleh sama.');
                    break;
                } else {
                    $valid = true;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        $this->header->payment_type = $this->header->paymentType->name;
        $this->header->payment_amount = $this->totalDetail;
        $this->header->tax_service_amount = $this->totalServiceTax;
        $this->header->discount_product_amount = $this->totalDiscount;
        $this->header->bank_administration_fee = $this->totalBankAdminFee;
        $this->header->merimen_fee = $this->totalMerimenFee;
        $this->header->downpayment_amount = $this->totalDownpaymentAmount;
        $this->header->insurance_company_id = $this->details[0]->invoiceHeader->insurance_company_id;
        $valid = $this->header->save(false);

        $invoiceNumberList = array();
        $plateNumberList = array();
        foreach ($this->details as $i => $detail) {
            if ($detail->amount <= 0.00 && $detail->tax_service_amount <= 0.00 && $detail->discount_amount <= 0.00 && $detail->bank_administration_fee <= 0.00 && $detail->merimen_fee <= 0.00) {
                continue;
            }

            if ($detail->isNewRecord) {
                $detail->payment_in_id = $this->header->id;
            }
                
            $detail->tax_service_percentage = $detail->is_tax_service === 2 ? 0 : 0.02;
            $valid = $detail->save(false) && $valid;
            
            $invoiceNumberList[] = $detail->invoiceHeader->invoice_number;
            $plateNumberList[] = $detail->invoiceHeader->vehicle->plate_number;
        }
        $invoiceNumberUniqueList = array_unique(explode(', ', implode(', ', $invoiceNumberList)));
        $plateNumberUniqueList = array_unique(explode(', ', implode(', ', $plateNumberList)));
        $this->header->invoice_number_list = implode(', ', $invoiceNumberUniqueList);
        $this->header->plate_number_list = implode(', ', $plateNumberUniqueList);
        $this->header->update(array('invoice_number_list', 'plate_number_list'));

        $this->header->images = CUploadedFile::getInstances($this->header, 'images');
        foreach ($this->header->images as $file) {
            $contentImage = new PaymentInImages();
            $contentImage->payment_in_id = $this->header->id;
            $contentImage->is_inactive = PaymentIn::STATUS_ACTIVE;
            $contentImage->extension = $file->extensionName;
            $valid = $contentImage->save(false) && $valid;

            $originalPath = dirname(Yii::app()->request->scriptFile) . '/images/uploads/paymentIn/' . $contentImage->filename;
            $file->saveAs($originalPath);
        }

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->payment_number;
        $transactionLog->transaction_date = $this->header->payment_date;
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
        
        $newData['paymentInDetails'] = array();
        foreach($this->details as $detail) {
            $newData['paymentInDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
    
    public function getBankFeeAmount() {
        $bankFeeAmount = 0.00;
        
        if ($this->header->paymentType->bank_fee_type == 1) {
            $bankFeeAmount = $this->getTotalInvoice() * $this->header->paymentType->bank_fee_amount / 100;
        } elseif ($this->header->paymentType->bank_fee_type == 2) {
            $bankFeeAmount = $this->header->paymentType->bank_fee_amount;
        } else {
            $bankFeeAmount = '0.00';
        }
        
        return $bankFeeAmount;
    }
    
    public function getTotalInvoice() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->total_invoice;
        }
        
        return $total;
    }
    
    public function getTotalDetail() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->amount;
        }
        
        return $total;
    }
    
    public function getTotalServiceTax() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->tax_service_amount;
        }
        
        return $total;
    }
    
    public function getTotalDiscount() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->discount_amount;
        }
        
        return $total;
    }
    
    public function getTotalBankAdminFee() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->bank_administration_fee;
        }
        
        return $total;
    }
    
    public function getTotalMerimenFee() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->merimen_fee;
        }
        
        return $total;
    }
    
    public function getTotalDownpaymentAmount() {
        $total = 0.00;
        
        foreach ($this->details as $detail) {
            $total += $detail->downpayment_amount;
        }
        
        return $total;
    }
    
    public function getTotalPayment() {
        
        return $this->totalDetail + $this->totalServiceTax + $this->totalDiscount + $this->totalBankAdminFee + $this->totalMerimenFee + $this->getBankFeeAmount();
    }
}