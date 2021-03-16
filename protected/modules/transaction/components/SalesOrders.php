<?php

class SalesOrders extends CComponent {

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
        $cnYearCondition = "substring_index(substring_index(substring_index(sale_order_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(sale_order_no, '/', 2), '/', -1), '.', -1)";
        $transactionSaleOrder = TransactionSalesOrder::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :requester_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':requester_branch_id' => $requesterBranchId),
        ));

        if ($transactionSaleOrder == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionSaleOrder->requesterBranch->code;
            $this->header->sale_order_no = $transactionSaleOrder->sale_order_no;
        }

        $this->header->setCodeNumberByNext('sale_order_no', $branchCode, TransactionSalesOrder::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail($productId) {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
        $detail = new TransactionSalesOrderDetail();
        $detail->product_id = $productId;
        $product = Product::model()->findByPK($productId);
        $detail->product_name = $product->name;
        $detail->unit_id = $product->unit_id;
//		if($product->ppn == 1)
//			$detail->retail_price = $product->retail_price / 1.1;
//		else
        $detail->retail_price = $product->retail_price;
        $detail->hpp = $product->hpp;
        $this->details[] = $detail;

        //echo "5";
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
        //var_dump(CJSON::encode($this->details));
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
            //print_r($e);
        }

        return $valid;
        //print_r('success');
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
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->price_before_discount = $this->subTotalBeforeDiscount;
        $this->header->discount = $this->subTotalDiscount;
        $this->header->ppn_price = $this->taxAmount;
        $this->header->subtotal = $this->subTotal;
        $this->header->total_price = $this->grandTotal;
        $valid = $this->header->save();
        //echo "valid";

        $requestDetails = TransactionSalesOrderDetail::model()->findAllByAttributes(array('sales_order_id' => $this->header->id));
        $detail_id = array();
        foreach ($requestDetails as $requestDetail) {
            $detail_id[] = $requestDetail->id;
        }
        $new_detail = array();

        //save request detail
        foreach ($this->details as $detail) {
            $detail->sales_order_id = $this->header->id;
            $detail->unit_price = $detail->unitPrice;
            $detail->total_price = $detail->grandTotal;
            $detail->total_quantity = $detail->totalQuantity;
            $detail->discount = $detail->totalDiscount;

            if ($isNewRecord)
                $detail->sales_order_quantity_left = $detail->total_quantity;

            $valid = $detail->save(false) && $valid;
            $new_detail[] = $detail->id;
            //echo 'test';
        }


        //delete pricelist
        $delete_array = array_diff($detail_id, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            TransactionSalesOrderDetail::model()->deleteAll($criteria);
        }


        return $valid;
    }

    public function getTotalQuantity() {
        $total = 0.00;

        foreach ($this->details as $detail)
            $total += $detail->totalQuantity;

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

    public function getTaxAmount() {
        return ($this->header->ppn == 1) ? $this->subTotal * 10 / 100 : 0.00;
    }

    public function getGrandTotal() {
        return $this->subTotal + $this->taxAmount;
    }

}
