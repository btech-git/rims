<?php

class MovementOutService extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(movement_out_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(movement_out_no, '/', 2), '/', -1), '.', -1)";
        
        $movementOutHeader = MovementOutHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($movementOutHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $movementOutHeader->branch->code;
            $this->header->movement_out_no = $movementOutHeader->movement_out_no;
        }

        $this->header->setCodeNumberByNext('movement_out_no', $branchCode, MovementOutHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($id) {
        $product = Product::model()->findByPk($id);

        $exist = false;
        foreach ($this->details as $i => $detail) {
            if ($product->id === $detail->product_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $movementOutDetail = new MovementOutDetail();
            $movementOutDetail->product_id = $id;
            $this->details[] = $movementOutDetail;
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
                $fields = array('quantity, product_id, warehouse_id');
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
//        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();
        
        foreach ($this->details as $detail) {
            $detail->movement_out_header_id = $this->header->id;
            $detail->delivery_order_detail_id = null;
            $detail->return_order_detail_id = null;
            $detail->material_request_detail_id = null;
            $detail->registration_product_id = null;
            $detail->quantity_transaction = $detail->quantity;
            $detail->quantity_receive = null;
            $detail->quantity_receive_left = null;
            
            $valid = $detail->save() && $valid;
        }

        return $valid;
    }
}