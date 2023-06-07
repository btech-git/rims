<?php

class ReturnOrders extends CComponent {

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
        $cnYearCondition = "substring_index(substring_index(substring_index(return_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(return_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionReturnOrder = TransactionReturnOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND recipient_branch_id = :recipient_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':recipient_branch_id' => $requesterBranchId),
        ));

        if ($transactionReturnOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionReturnOrder->recipientBranch->code;
            $this->header->return_order_no = $transactionReturnOrder->return_order_no;
        }

        $this->header->setCodeNumberByNext('return_order_no', $branchCode, TransactionReturnOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($requestType, $requestId) {
        $this->details = array();
        if ($requestType == 1) {
            //$purchaseOrder = TransactionPurchaseOrder::model()->findByPk($requestId);
            $purchases = TransactionPurchaseOrderDetail::model()->findAllByAttributes(array('purchase_order_id' => $requestId));
            foreach ($purchases as $key => $purchase) {
                $detail = new TransactionReturnOrderDetail();
                $detail->product_id = $purchase->product_id;
                $detail->qty_request = $purchase->quantity;
                $detail->price = $purchase->unit_price;
                //$detail->qty_request_left = $purchase->quantity;
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($requestType == 2) {
            $sents = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id' => $requestId));
            foreach ($sents as $key => $sent) {
                $detail = new TransactionReturnOrderDetail();
                $detail->product_id = $sent->product_id;
                $detail->qty_request = $sent->quantity_delivery;
                //$detail->qty_request_left = $sent->quantity;
                $this->details[] = $detail;
            }
        } elseif ($requestType == 3) {
            $consignments = ConsignmentInDetail::model()->findAllByAttributes(array('consignment_in_id' => $requestId));
            foreach ($consignments as $key => $consignment) {
                $detail = new TransactionReturnOrderDetail();
                $detail->product_id = $consignment->product_id;
                $detail->qty_request = $consignment->quantity;
                //$detail->qty_request_left = $sent->quantity;
                $this->details[] = $detail;
            }
        }


        //echo "5";
    }

    public function removeDetailAt() {
        //array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
        $this->details = array();
    }

    public function removeDetail($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
        //$this->details = array();
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
        $this->header->estimate_arrival_date = ($this->header->estimate_arrival_date == '0000-00-00') ? date('Y-m-d', strtotime('+ 1month', strtotime($this->header->return_order_date))) : $this->header->estimate_arrival_date;
        $valid = $this->header->save();

        $requestDetails = TransactionReturnOrderDetail::model()->findAllByAttributes(array('return_order_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->return_order_id = $this->header->id;
            $detail->price = $detail->product->hpp;
            $detail->quantity_movement = 0;
            $detail->quantity_movement_left = $detail->qty_reject;

            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
        }

        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionReturnOrderDetail::model()->deleteAll($criteria);
        }

        return $valid;
    }

}
