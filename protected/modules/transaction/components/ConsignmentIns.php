<?php

class ConsignmentIns extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(consignment_in_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(consignment_in_number, '/', 2), '/', -1), '.', -1)";
        $consignmentInHeader = ConsignmentInHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND receive_branch = :receive_branch",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':receive_branch' => $requesterBranchId),
        ));

        if ($consignmentInHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $consignmentInHeader->receiveBranch->code;
            $this->header->consignment_in_number = $consignmentInHeader->consignment_in_number;
        }

        $this->header->setCodeNumberByNext('consignment_in_number', $branchCode, ConsignmentInHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {

        $product = Product::model()->findByPK($productId);
        
        $detail = new ConsignmentInDetail();
        $detail->product_id = $productId;
        $detail->barcode_product = $product->barcode;

        $this->details[] = $detail;
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
                //print_r('1');
            } else {
                $dbTransaction->rollback();
                //print_r('2');
            }
        } catch (Exception $e) {
            $dbTransaction->rollback();
            $valid = false;
            //print_r($e);
        }

        return $valid;
        //print_r('success');
    }

    public function validate() {
        $valid = $this->header->validate();


        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {

                $fields = array('price, quantity');
                $valid = $detail->validate($fields) && $valid;
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
        $this->header->total_price = $this->totalPrice;
        $this->header->total_quantity = $this->totalQuantity;
        $valid = $this->header->save();
        //echo "valid";

        $consignmentDetails = ConsignmentInDetail::model()->findAllByAttributes(array('consignment_in_id' => $this->header->id));
        $detail_id = array();
        foreach ($consignmentDetails as $consignmentDetail) {
            $detail_id[] = $consignmentDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->consignment_in_id = $this->header->id;
            $detail->total_price = $detail->total;
            $detail->qty_request_left = $detail->quantity;
            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
        }


        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            ConsignmentInDetail::model()->deleteAll($criteria);
        }


        return $valid;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->quantity;

        return $total;
    }

    public function getTotalPrice() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->total;

        return $total;
    }

}
