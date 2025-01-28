<?php

class ItemRequest extends CComponent {

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
        $itemRequestHeader = ItemRequestHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($itemRequestHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $itemRequestHeader->branch->code;
            $this->header->transaction_number = $itemRequestHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, ItemRequestHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($id) {
        $itemRequestDetail = new ItemRequestDetail();
        $this->details[] = $itemRequestDetail;
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

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail) {
                $valid = $valid && $detail->delete();
            }

            $valid = $valid && $this->header->delete();

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
        $valid = $valid && $this->validateDetailsCount();
        
        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'unit_price', 'item_name', 'description');
                $valid = $valid && $detail->validate($fields);
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

    public function flush() {
        $this->header->total_quantity = $this->getTotalQuantity();
        $this->header->total_price = $this->getTotalPrice();
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            
            if ($detail->quantity <= 0) {
                continue;
            }

            $detail->item_request_header_id = $this->header->id;
            $detail->total_price = $detail->totalPrice;
            $valid = $valid && $detail->save(false);
        }

        return $valid;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }
    
    public function getTotalPrice() {
        $total = 0.00;

        foreach ($this->details as $detail) {
            $total += $detail->totalPrice;
        }
        
        return $total;
    }
}
