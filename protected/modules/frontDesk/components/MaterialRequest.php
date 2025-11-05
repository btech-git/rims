<?php

class MaterialRequest extends CComponent {

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
        $materialRequestHeader = MaterialRequestHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($materialRequestHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $materialRequestHeader->branch->code;
            $this->header->transaction_number = $materialRequestHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, MaterialRequestHeader::CONSTANT, $currentMonth, $currentYear);
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
            $materialRequestDetail = new MaterialRequestDetail();
            $materialRequestDetail->product_id = $id;
            $this->details[] = $materialRequestDetail;
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
        $valid = $valid && $this->validateDetailsUnique();
        $valid = $valid && $this->validateDetailsUnit();
        
        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'unit_price', 'product_id', 'amount');
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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->product_id === $this->details[$j]->product_id) {
                    $valid = false;
                    $this->header->addError('error', 'Produk tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function validateDetailsUnit() {
        $valid = true;
        
        foreach ($this->details as $detail) {
            if ($detail->product->unit_id !== $detail->unit_id) {
                $unitConversion = UnitConversion::model()->findByAttributes(array(
                    'unit_from_id' => $detail->product->unit_id, 
                    'unit_to_id' => $detail->unit_id
                ));
                if ($unitConversion !== null) {
                    continue;
                }
                $unitConversion = UnitConversion::model()->findByAttributes(array(
                    'unit_from_id' => $detail->unit_id, 
                    'unit_to_id' => $detail->product->unit_id
                ));
                if ($unitConversion !== null) {
                    continue;
                }
                $valid = false;
                $detail->addError('unit_id', 'Unit harus ada.');
            }
        }
        
        return $valid;
    }
    
    public function flush() {
        $this->header->total_quantity = $this->getTotalQuantity();
        $this->header->total_quantity_movement_out = $this->getTotalQuantityMovementOut();
        $this->header->total_quantity_remaining = $this->header->total_quantity - $this->header->total_quantity_movement_out;
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            
            if ($detail->quantity < 0) {
                continue;
            }

            $detail->quantity_movement_out = ($this->header->isNewRecord) ? 0 : $detail->getTotalQuantityMovementOut();
            $detail->quantity_remaining = $detail->quantity - $detail->quantity_movement_out;
            $detail->material_request_header_id = $this->header->id;
            $valid = $valid && $detail->save(false);
        }

        return $valid;
    }

    public function getTotalQuantity() {
        $total = '0.00';

        foreach ($this->details as $detail) {
            $total += $detail->quantity;
        }
        
        return $total;
    }
    
    public function getTotalQuantityMovementOut() {
        $total = '0.00';

        foreach ($this->details as $detail) {
            $total += $detail->quantity_movement_out;
        }
        
        return $total;
    }
}
