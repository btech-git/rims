<?php

class SaleReceipt extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        
        $saleReceiptHeader = SaleReceiptHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($saleReceiptHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $saleReceiptHeader->branch->code;
            $this->header->transaction_number = $saleReceiptHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, SaleReceiptHeader::CONSTANT, $currentMonth, $currentYear);
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
            $detail = new SaleReceiptDetail();
            $detail->invoice_header_id = $invoiceId;
            $detail->invoice_amount = $invoiceHeader->subTotal;
            $detail->insurance_own_risk_amount = $invoiceHeader->insurance_own_risk_amount;
            $detail->downpayment_amount = $invoiceHeader->downpayment_amount;
            $detail->receivable_amount = $invoiceHeader->subTotal;
            $this->details[] = $detail;
            
            $this->header->total_invoice_amount = $this->getTotalInvoiceAmount();
            $this->header->total_downpayment_amount = $this->getTotalDownpaymentAmount();
            $this->header->total_own_risk_amount = $this->getTotalOwnRiskAmount();
            $this->header->tax_item_amount = $this->getTaxItemAmount();
            $this->header->tax_service_amount = $this->getTaxServiceAmount();
            $this->header->total_receivable_amount = $this->getTotalReceivableAmount();
            $this->header->tax_item_percentage = 11;
            $this->header->tax_service_percentage = 2;
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
        $valid = $this->header->save(false);

        foreach ($this->details as $i => $detail) {
//            if ($this->header->isNewRecord) {
                $detail->sale_receipt_header_id = $this->header->id;
//            }
                
            $valid = $detail->save(false) && $valid;
            
            if (!$this->header->isNewRecord && $this->header->delivery_receipt_number !== '') {
                $detail->invoiceHeader->is_sent_to_customer = 1;
                $detail->invoiceHeader->delivery_receipt_number = $this->header->delivery_receipt_number;
                $detail->invoiceHeader->update(array('is_sent_to_customer', 'delivery_receipt_number'));
            }            
        }
        
        $this->saveTransactionLog();
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->transaction_number;
        $transactionLog->transaction_date = $this->header->transaction_date;
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
        
        $newData['saleReceiptDetails'] = array();
        foreach($this->details as $detail) {
            $newData['saleReceiptDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
    
    public function getTotalInvoiceAmount() {
        $total = '0.00';
        
        foreach ($this->details as $detail) {
            $total += $detail->invoice_amount;
        }
        
        return $total;
    }
    
    public function getTotalDownpaymentAmount() {
        $total = '0.00';
        
        foreach ($this->details as $detail) {
            $total += $detail->downpayment_amount;
        }
        
        return $total;
    }
    
    public function getTotalOwnRiskAmount() {
        $total = '0.00';
        
        foreach ($this->details as $detail) {
            $total += $detail->insurance_own_risk_amount;
        }
        
        return $total;
    }
    
    public function getTotalPartsAmount() {
        $total = '0.00';
        
        foreach ($this->details as $detail) {
            $total += $detail->invoiceHeader->product_price;
        }
        
        return $total;
    }
    
    public function getTotalServiceAmount() {
        $total = '0.00';
        
        foreach ($this->details as $detail) {
            $total += $detail->invoiceHeader->service_price;
        }
        
        return $total;
    }
    
    public function getTaxItemAmount() {
        
        return $this->header->total_invoice_amount * $this->header->tax_item_percentage / 100;
    }
    
    public function getTaxServiceAmount() {
        
        return $this->header->total_invoice_amount * $this->header->tax_service_percentage / 100;
    }
    
    public function getTotalReceivableAmount() {
        return $this->header->total_invoice_amount + $this->header->tax_item_amount - $this->header->tax_service_amount;
    }
}