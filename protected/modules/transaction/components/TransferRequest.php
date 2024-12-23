<?php

class TransferRequest extends CComponent {

    public $actionType;
    public $header;
    public $details;

    public function __construct($actionType, $header, array $details) {
        $this->actionType = $actionType;
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $requesterBranchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transfer_request_no, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transfer_request_no, '/', 2), '/', -1), '.', -1)";
        $transactionTransferRequest = TransactionTransferRequest::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND requester_branch_id = :main_branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':main_branch_id' => $requesterBranchId),
        ));
        
        if ($transactionTransferRequest == null) {
            $branchCode = Branch::model()->findByPk($requesterBranchId)->code;
        } else {
            $branchCode = $transactionTransferRequest->requesterBranch->code;
            $this->header->transfer_request_no = $transactionTransferRequest->transfer_request_no;
        }

        $this->header->setCodeNumberByNext('transfer_request_no', $branchCode, TransactionTransferRequest::CONSTANT, $currentMonth, $currentYear);
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
            $transferRequestDetail = new TransactionTransferRequestDetail();
            $transferRequestDetail->product_id = $id;
            $transferRequestDetail->unit_id = $product->unit_id;
            $transferRequestDetail->unit_price = $product->hpp;
            $this->details[] = $transferRequestDetail;
        }
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
            } else {
                $dbTransaction->rollback();
            }
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
        
        if (!$valid) {
            $this->header->addError('error', 'Header Error');
        } elseif ($this->header->requester_branch_id === $this->header->destination_branch_id) {
            $valid = false;
            $this->header->addError('error', 'Requester and destination branch must be different!!');
        } else {
            $valid = $valid && $this->validateDetailsCount();
            if (!$valid) {
                $this->header->addError('error', 'Validate Details Error');
            } else {
                $valid = $valid && $this->validateDetailsUnique();
                if (!$valid) {
                    $this->header->addError('error', 'Validate Unique Error');
                }
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
        $this->header->transfer_request_time = date('H:i:s');
        $this->header->total_quantity = $this->totalQuantity;
        $this->header->total_price = $this->grandTotal;
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            if ($detail->quantity <= 0 && $this->header->isNewRecord) {
                continue;
            }

            $detail->transfer_request_id = $this->header->id;
            $detail->amount = $detail->total;
            $detail->quantity_delivery_left = $detail->quantity;
            $valid = $valid && $detail->save(false);
        }

        $this->saveTransactionLog();
        
        return $valid;
    }

    public function saveTransactionLog() {
        $transactionLog = new TransactionLog();
        $transactionLog->transaction_number = $this->header->transfer_request_no;
        $transactionLog->transaction_date = $this->header->transfer_request_date;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        $transactionLog->action_type = $this->actionType;
        
        $newData = $this->header->attributes;
        
        $newData['transactionTransferRequestDetails'] = array();
        foreach($this->details as $detail) {
            $newData['transactionTransferRequestDetails'][] = $detail->attributes;
        }
        
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
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
