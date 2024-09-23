<?php

class Adjustment extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function addDetail($productId, $branchId) {
        $product = Product::model()->findByPk($productId);
        
        if ($product !== null) {
            $exist = false;

            foreach ($this->details as $i => $detail) {
                if ($product->id === $detail->product_id) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $detail = new StockAdjustmentDetail();
                $detail->product_id = $product->id;
                $detail->warehouse_id = $detail->getWarehouseId($branchId);
                $detail->quantity_current = $detail->getCurrentStock($productId, $branchId);
                $this->details[] = $detail;
            }
        }
    }

    public function removeProductAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function updateProducts() {
        foreach ($this->details as $detail) {
            $detail->quantity_current = $detail->getCurrentStock($detail->product_id, $this->header->branch_id);
        }
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity_current', 'quantity_adjustment', 'product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        } else {
            $valid = false;
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {

            $detail->stock_adjustment_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
        }

        return $valid;
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

}
