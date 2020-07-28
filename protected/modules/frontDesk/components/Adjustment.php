<?php

class Adjustment extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

//    public function generateCodeNumber($currentMonth, $currentYear) {
//        $adjustmentHeader = StockAdjustmentHeader::model()->find(array(
//            'order' => 'id DESC',
//                ));
//
//        if ($adjustmentHeader !== null)
//            $this->header->setCodeNumber($adjustmentHeader->cn_ordinal, $adjustmentHeader->cn_month, $adjustmentHeader->cn_year);
//
//        $this->header->setCodeNumberByNext($currentMonth, $currentYear);
//    }

    public function removeProductAt($index) {
        array_splice($this->details, $index, 1);
    }

    public function updateProducts() {
        foreach ($this->details as $detail)
            $detail->quantity_current = $detail->getCurrentStock($this->header->warehouse_id);
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity_current', 'quantity_adjustment', 'product_id');
                $valid = $detail->validate($fields) && $valid;
            }
        }
        else
            $valid = false;

        return $valid;
    }

    public function addDetail($id) {
        $product = Product::model()->findByPk($id);

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
                $detail->quantity_current = $detail->getCurrentStock($this->header->warehouse_id);
                $this->details[] = $detail;
            }
        }
    }

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->quantity_adjustment <= 0)
                continue;

            if ($detail->isNewRecord)
                $detail->stock_adjustment_header_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
        }

        return $valid;
    }

    public function save($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = $this->validate() && $this->flush();
            if ($valid)
                $dbTransaction->commit();
            else
                $dbTransaction->rollback();
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
        }

        return $valid;
    }

}
