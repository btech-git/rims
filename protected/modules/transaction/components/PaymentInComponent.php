<?php

class PaymentInComponent extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($detail, $currentMonth, $currentYear, $requesterBranchId) {
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
            $detail->payment_number = $paymentInHeader->payment_number;
        }

        $detail->setCodeNumberByNext('payment_number', $branchCode, PaymentIn::CONSTANT, $currentMonth, $currentYear);
    }

    public function addInvoice($invoiceId) {

        $invoiceHeader = InvoiceHeader::model()->findByPk($invoiceId);

        $exist = false;
        foreach ($this->details as $i => $detail) {
            if ($invoiceHeader->id === $detail->invoice_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $paymentIn = new PaymentIn();
            $paymentIn->invoice_id = $invoiceId;
            $paymentIn->vehicle_id = $invoiceHeader->vehicle_id;
            $this->details[] = $paymentIn;
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
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate(array('payment_date', 'branch_id', 'company_bank_id', 'payment_type_id'));

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('payment_amount', 'notes', 'nomor_giro', 'tax_service_amount');
                $valid = $detail->validate($fields) && $valid;
                if ($detail->payment_amount > $detail->invoice->payment_left) {
                    $valid = false; 
                    $detail->addError('error', 'Payment tidak bisa lebih besar dari jumlah invoice.');
                }
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function flush() {
        $valid = true; 
        foreach ($this->details as $detail) {
            $this->generateCodeNumber($detail, Yii::app()->dateFormatter->format('M', strtotime($this->header->payment_date)), Yii::app()->dateFormatter->format('yyyy', strtotime($this->header->payment_date)), $this->header->branch_id);
            $detail->customer_id = $this->header->customer_id;
            $detail->payment_time = $this->header->payment_time;
            $detail->created_datetime = $this->header->created_datetime;
            $detail->branch_id = $this->header->branch_id;
            $detail->status = $this->header->status;
            $detail->user_id = $this->header->user_id;
            $detail->payment_date = $this->header->payment_date;
            $detail->branch_id = $this->header->branch_id;
            $detail->company_bank_id = $this->header->company_bank_id;
            $detail->payment_type_id = $this->header->payment_type_id;
            $valid = $detail->save() && $valid;

            $invoiceHeader = InvoiceHeader::model()->findByPk($detail->invoice_id);
            $registrationTransaction = RegistrationTransaction::model()->findByPk($invoiceHeader->registration_transaction_id);
            if (!empty($registrationTransaction)) {
                $registrationTransaction->payment_status = 'CLEAR';
                $valid = $registrationTransaction->update(array('payment_status')) && $valid;
            }

            //update Invoice
            $invoiceHeader->payment_amount = $invoiceHeader->getTotalPayment();
            $invoiceHeader->payment_left = $invoiceHeader->getTotalRemaining();
            $valid = $invoiceHeader->update(array('payment_amount', 'payment_left')) && $valid;
        }

        return $valid;
    }
}