<?php

class SentRequest extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(sent_request_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(sent_request_no, '/', 2), '/', -1), '.', -1)";
        $transactionSentRequest = TransactionSentRequest::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :main_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':main_branch_id' => $requesterBranchId),
        ));
        
        if ($transactionSentRequest == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionSentRequest->requesterBranch->code;
            $this->header->sent_request_no = $transactionSentRequest->sent_request_no;
        }

        $this->header->setCodeNumberByNext('sent_request_no', $branchCode, TransactionSentRequest::CONSTANT, $currentMonth, $currentYear);
    }
	
    public function addDetail($id) {
        $product = Product::model()->findByPk($id);

        $exist = false;
        foreach ($this->details as $i => $detail) {
            if ($product->id === $detail->product_id) {
                $exist = true;
                break;
            }
        }

        if (!$exist) {
            $sentRequestDetail = new TransactionSentRequestDetail();
            $sentRequestDetail->product_id = $id;
            $this->details[] = $sentRequestDetail;
        }
    }

    public function removeDetailAt($index) {
        array_splice($this->details, $index, 1);
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
            $this->header->addError('error', $e->getMessage());
        }

        return $valid;
    }

    public function delete($dbConnection) {
        $dbTransaction = $dbConnection->beginTransaction();
        try {
            $valid = true;

            foreach ($this->details as $detail)
                $valid = $valid && $detail->delete();

            $valid = $valid && $this->header->delete();

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

    public function validate() {
        $valid = $this->header->validate();
        if (!$valid)
            $this->header->addError('error', 'Header Error');
        else {
            $valid = $valid && $this->validateDetailsCount();
            if (!$valid)
                $this->header->addError('error', 'Validate Details Error');
            else {
                $valid = $valid && $this->validateDetailsUnique();
                if (!$valid)
                    $this->header->addError('error', 'Validate Unique Error');
            }
        }
        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'unit_price', 'product_id', 'amount');
                $valid = $valid && $detail->validate($fields);
            }
        }
        else
            $valid = false;

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

    public function validateDetailsUnique() {
        $valid = true;

        $detailsCount = count($this->details);
        for ($i = 0; $i < $detailsCount; $i++) {
            for ($j = $i; $j < $detailsCount; $j++) {
                if ($i === $j)
                    continue;

                if ($this->details[$i]->product_id === $this->details[$j]->product_id) {
                    $valid = false;
                    $this->header->addError('error', 'Produk tidak boleh sama.');
                    break;
                }
            }
        }

        return $valid;
    }

    public function flush() {
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->total_price = $this->grandTotal;
        $this->header->sent_request_date = date('Y-m-d H:i:s');
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0)
                continue;

            $detail->sent_request_id = $this->header->id;
            $detail->amount = $detail->total;
            $detail->sent_request_quantity_left = $detail->quantity;
            $valid = $valid && $detail->save(false);
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
