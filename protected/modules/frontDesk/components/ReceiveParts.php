<?php

class ReceiveParts extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        
        $receivePartsHeader = ReceivePartsHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($receivePartsHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $receivePartsHeader->branch->code;
            $this->header->transaction_number = $receivePartsHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, ReceivePartsHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($registrationTransactionId) {
        $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $registrationTransactionId));

        foreach ($registrationProducts as $registrationProduct) {
            $receivePartsDetail = new ReceivePartsDetail();
            $receivePartsDetail->product_id = $registrationProduct->product_id;
            $receivePartsDetail->registration_product_id = $registrationProduct->id;
            $this->details[] = $receivePartsDetail;
        }
    }

    public function removeDetailAt($index) {
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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity, product_id, registration_product_id');
                $valid = $detail->validate($fields) && $valid;
                echo $valid;
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
        $valid = $this->header->save();
        
        foreach ($this->details as $detail) {
            $detail->receive_parts_header_id = $this->header->id;
            $detail->quantity_movement = $this->header->isNewRecord ? 0 : $detail->getQuantityMovement();
            $detail->quantity_movement_left = $this->header->isNewRecord ? $detail->quantity : $detail->getQuantityMovementLeft();
            $valid = $detail->save() && $valid;
        }

        return $valid;
    }
}