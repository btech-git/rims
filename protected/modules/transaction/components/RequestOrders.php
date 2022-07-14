<?php

class RequestOrders extends CComponent {

    public $header;
    public $details;
    public $transferDetails;

    // /public $detailApprovals;
    // public $picPhoneDetails;
    // public $picMobileDetails;

    public function __construct($header, array $details, array $transferDetails) {
        $this->header = $header;
        $this->details = $details;
        $this->transferDetails = $transferDetails;
        //$this->detailApprovals = $detailApprovals;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(request_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(request_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionRequestOrder = TransactionRequestOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :requester_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':requester_branch_id' => $requesterBranchId),
        ));

        if ($transactionRequestOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionRequestOrder->requesterBranch->code;
            $this->header->request_order_no = $transactionRequestOrder->request_order_no;
        }

        $this->header->setCodeNumberByNext('request_order_no', $branchCode, TransactionRequestOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail() {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $detail = new TransactionRequestOrderDetail();

        $this->details[] = $detail;

        //echo "5";
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function addDetailApproval() {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $detailApproval = new TransactionRequestOrderApproval();

        $this->detailApprovals[] = $detailApproval;

        //echo "5";
    }

    public function addTransferDetail() {
        $transferDetail = new TransactionRequestTransfer();
        $this->transferDetails[] = $transferDetail;
    }

    public function removeTransferDetailAt($index) {
        array_splice($this->transferDetails, $index, 1);
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
        }

        return $valid;
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
        if (count($this->transferDetails) > 0) {
            foreach ($this->transferDetails as $transferDetail) {

                $fields = array('quantity');
                $valid = $transferDetail->validate($fields) && $valid;
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
//        $isNewRecord = $this->header->isNewRecord;
        $this->header->total_items = $this->totalQuantity;
        $this->header->total_price = $this->subTotal;
        $valid = $this->header->save();
        //echo "valid";

        $requestDetails = TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->request_order_id = $this->header->id;
            $detail->request_order_quantity_rest = $detail->quantity;
            $detail->unit_price = $detail->unitPrice;
            $detail->total_price = $detail->subTotal;
            $detail->total_quantity = $detail->quantityAfterBonus;
            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
            //echo 'test';
        }


        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionRequestOrderDetail::model()->deleteAll($criteria);
        }

        //save transfer
        $requestTransfers = TransactionRequestTransfer::model()->findAllByAttributes(array('request_order_id' => $this->header->id));
        $transfer_id = array();
        foreach ($requestTransfers as $requestTransfer) {
            $transfer_id[] = $requestTransfer->id;
        }
        $new_transfer = array();

        //save request detail
        foreach ($this->transferDetails as $transferDetail) {
            $transferDetail->request_order_id = $this->header->id;

            $valid = $transferDetail->save(false) && $valid;
            $new_transfer[] = $transferDetail->id;
            //echo 'test';
        }


        //delete 
        $delete_transfer_array = array_diff($transfer_id, $new_transfer);
        if ($delete_transfer_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_transfer_array);
            TransactionRequestTransfer::model()->deleteAll($criteria);
        }
        return $valid;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->quantityAfterBonus;

        return $total;
    }

    public function getSubTotalDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->totalDiscount;

        return $total;
    }

    public function getSubTotalBeforeDiscount() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->totalBeforeDiscount;

        return $total;
    }

    public function getSubTotal() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->subTotal;

        return $total;
    }

}
