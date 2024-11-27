<?php

class PaymentInComponent extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
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
        $this->header->insurance_company_id = $this->details[0]->invoiceHeader->insurance_company_id;
        $valid = $this->header->save(false);

        foreach ($this->details as $i => $detail) {
            if ($detail->amount <= 0.00) {
                continue;
            }

            if ($detail->isNewRecord) {
                $detail->payment_in_id = $this->header->id;
            }
                
            $detail->tax_service_percentage = $detail->is_tax_service === 2 ? 0 : 0.02;
            $valid = $detail->save(false) && $valid;

            if (!empty($detail->invoice_header_id)) {
                $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_header_id);
                $paymentAmount = $invoiceHeader->getTotalPayment() + $this->header->downpayment_amount + $this->header->discount_product_amount + $this->header->bank_administration_fee + $this->header->merimen_fee;
                $invoiceHeader->payment_amount = $i == 0 ? $paymentAmount : $invoiceHeader->getTotalPayment();
                $invoiceHeader->payment_left = $invoiceHeader->getTotalRemaining();
                $invoiceHeader->status = $invoiceHeader->payment_left > 0 ? 'PARTIALLY PAID' : 'PAID';
                $valid = $invoiceHeader->update(array('payment_amount', 'payment_left', 'status')) && $valid;
                
                $registrationTransaction = RegistrationTransaction::model()->findByPk($invoiceHeader->registration_transaction_id);
                $registrationTransaction->payment_status = $invoiceHeader->payment_left > 0 ? 'PARTIALLY PAID' : 'PAID';
                $valid = $valid && $registrationTransaction->update(array('payment_status'));

            }
        }

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

        return $valid;
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
    
    public function getTotalPayment() {
        
        return $this->totalDetail + $this->totalServiceTax + $this->header->downpayment_amount + $this->header->discount_product_amount + $this->header->discount_service_amount + $this->header->bank_administration_fee + $this->header->merimen_fee;
    }
    
}