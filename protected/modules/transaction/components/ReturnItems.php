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

    public function addDetail($requestType, $requestId) {
        $this->details = array();
        if ($requestType == 1) {
            //$purchaseOrder = TransactionPurchaseOrder::model()->findByPk($requestId);
            $sales = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $requestId));
            foreach ($sales as $key => $sale) {
                $detail = new TransactionReturnItemDetail();
                $detail->product_id = $sale->product_id;
                $detail->quantity_delivery = $sale->quantity;
                $detail->price = $sale->unit_price;
                // $detail->quantity_left = $sale->quantity;
                $this->details[] = $detail;
            } //endforeach
        }//end if
        elseif ($requestType == 2) {
            $sents = TransactionSentRequestDetail::model()->findAllByAttributes(array('sent_request_id' => $requestId));
            foreach ($sents as $key => $sent) {
                $detail = new TransactionReturnItemDetail();
                $detail->product_id = $sent->product_id;
                $detail->quantity_delivery = $sent->quantity;
                // $detail->quantity_left = $sent->quantity;
                $this->details[] = $detail;
            }
        } elseif ($requestType == 3) {
            $transfers = TransactionTransferRequestDetail::model()->findAllByAttributes(array('transfer_request_id' => $requestId));
            foreach ($transfers as $key => $transfer) {
                $detail = new TransactionReturnItemDetail();
                $detail->product_id = $transfer->product_id;
                $detail->quantity_delivery = $transfer->quantity;
                // $detail->quantity_left = $transfer->quantity;
                $this->details[] = $detail;
            }
        } elseif ($requestType == 4) {
            $consignments = ConsignmentOutDetail::model()->findAllByAttributes(array('consignment_out_id' => $requestId));
            foreach ($consignments as $key => $consignment) {
                $detail = new TransactionReturnItemDetail();
                $detail->product_id = $consignment->product_id;
                $detail->quantity_delivery = $consignment->qty_sent;
                $detail->price = $consignment->sale_price;
                // $detail->quantity_left = $sent->quantity;
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
            $valid = $this->validate() && $this->flush();
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
            print_r($e);
        }

        return $valid;
        //print_r('success');
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




        //print_r($valid);
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
        $valid = $this->header->save();
        //echo "valid";

        $requestDetails = TransactionReturnItemDetail::model()->findAllByAttributes(array('return_item_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->return_item_id = $this->header->id;

            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;


            //echo 'test';
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