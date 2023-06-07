<?php

class ReturnItems extends CComponent {

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
        $cnYearCondition = "substring_index(substring_index(substring_index(return_item_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(return_item_no, '/', 2), '/', -1), '.', -1)";
        $transactionReturnItem = TransactionReturnItem::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND recipient_branch_id = :recipient_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':recipient_branch_id' => $requesterBranchId),
                ));

        if ($transactionReturnItem == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionReturnItem->recipientBranch->code;
            $this->header->return_item_no = $transactionReturnItem->return_item_no;
        }

        $this->header->setCodeNumberByNext('return_item_no', $branchCode, TransactionReturnItem::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetails($transactionId, $returnType) {
        $this->details = array();
        
        if ($returnType == 1) {
            $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $transactionId));
            foreach ($deliveryDetails as $key => $deliveryDetail) {
                $detail = new TransactionReturnItemDetail();
                $detail->product_id = $deliveryDetail->product_id;
                $detail->quantity_delivery = $deliveryDetail->quantity_delivery;
                $detail->price = $deliveryDetail->product->hpp;
                $detail->return_type = 'Delivery Order';
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($returnType == 2) {
            $registrationProducts = RegistrationProduct::model()->findAllByAttributes(array('registration_transaction_id' => $transactionId));
            foreach ($registrationProducts as $key => $registrationProduct) {
                $detail = new TransactionReturnItemDetail();
                $detail->product_id = $registrationProduct->product_id;
                $detail->quantity_delivery = $registrationProduct->quantity;
                $detail->price = $registrationProduct->total_price;
                $detail->return_type = 'Retail Sales';
                $this->details[] = $detail;
            }
        } else {
            $this->details[] = array();
        }
    }

    public function removeDetailAt() {
        $this->details = array();
    }

    public function removeDetail($index) {
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
            print_r($e);
        }

        return $valid;
    }

    public function validate() {
        $valid = $this->header->validate();

        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {

                $fields = array('unit_price');
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
        $valid = $this->header->save();

        $requestDetails = TransactionReturnItemDetail::model()->findAllByAttributes(array('return_item_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->return_item_id = $this->header->id;
            $detail->price = $detail->product->hpp;
            $detail->quantity_movement = 0;
            $detail->quantity_movement_left = $detail->quantity;

            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionReturnItemDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }
}