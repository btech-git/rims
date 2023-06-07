<?php

class ConsignmentOuts extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(consignment_out_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(consignment_out_no, '/', 2), '/', -1), '.', -1)";
        $consignmentOutHeader = ConsignmentOutHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $requesterBranchId),
        ));

        if ($consignmentOutHeader == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $consignmentOutHeader->branch->code;
            $this->header->consignment_out_no = $consignmentOutHeader->consignment_out_no;
        }

        $this->header->setCodeNumberByNext('consignment_out_no', $branchCode, ConsignmentOutHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {

        $detail = new ConsignmentOutDetail();
        $detail->product_id = $productId;
        $product = Product::model()->findByPK($productId);

        $this->details[] = $detail;
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
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

                $fields = array('price');
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
        $valid = $this->header->save();
        //echo "valid";

        $consignmentDetails = ConsignmentOutDetail::model()->findAllByAttributes(array('consignment_out_id' => $this->header->id));
        $detail_id = array();
        foreach ($consignmentDetails as $consignmentDetail) {
            $detail_id[] = $consignmentDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->consignment_out_id = $this->header->id;
            //if($isNewRecord)
            $detail->qty_request_left = $detail->quantity;
            //$detail->request_order_quantity_rest = $detail->quantity;
            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
            //echo 'test';
        }


        //delete details
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            ConsignmentOutDetail::model()->deleteAll($criteria);
        }


        return $valid;
    }

}
