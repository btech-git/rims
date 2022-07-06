<?php

class SentRequests extends CComponent {

    public $header;
    public $details;

    // /public $detailApprovals;
    // public $picPhoneDetails;
    // public $picMobileDetails;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;

        //$this->detailApprovals = $detailApprovals;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(sent_request_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(sent_request_no, '/', 2), '/', -1), '.', -1)";
        $transactionSentRequest = TransactionSentRequest::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :requester_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':requester_branch_id' => $requesterBranchId),
                ));

        if ($transactionSentRequest == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionSentRequest->requesterBranch->code;
            $this->header->sent_request_no = $transactionSentRequest->sent_request_no;
        }

        $this->header->setCodeNumberByNext('sent_request_no', $branchCode, TransactionSentRequest::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {
        $product = Product::model()->findByPK($productId);
        
        $exist = false;
        foreach ($this->details as $i => $detail) {
            if ($product->id === $detail->product_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $detail = new TransactionSentRequestDetail();
            $detail->product_id = $productId;
            $detail->unit_id = $product->unit_id;
            $detail->unit_price = $product->hpp;
            $this->details[] = $detail;
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
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {

                $fields = array('quantity');
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
        $isNewRecord = $this->header->isNewRecord;
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->total_price = $this->grandTotal;
        $valid = $this->header->save();

        $requestDetails = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            if ($isNewRecord) {
                $detail->sent_request_quantity_left = $detail->quantity;
            }
            
            $detail->sent_request_id = $this->header->id;
            $detail->amount = $detail->total;
            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
        }


        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionSentRequestDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
    
    public function getGrandTotal() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->total;

        return $total;
    }
    
    public function getTotalQuantity() {
        $total = 0.00;
        
        foreach ($this->details as $detail)
            $total += $detail->quantity;

        return $total;
    }
}