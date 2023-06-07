<?php

class MaintenanceRequest extends CComponent {

    public $header;
    public $details;

    public function __construct($header, array $details) {
        $this->header = $header;
        $this->details = $details;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $maintenanceRequestHeader = MaintenanceRequestHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($maintenanceRequestHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $maintenanceRequestHeader->branch->code;
            $this->header->transaction_number = $maintenanceRequestHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, MaintenanceRequestHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetail() {
        $detail = new MaintenanceRequestDetail();

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

            foreach ($this->details as $detail) {
                $valid = $valid && $detail->delete();
            }

            $valid = $valid && $this->header->delete();

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
        
        if (!$valid) {
            $this->header->addError('error', 'Header Error');
        } else {
            $valid = $valid && $this->validateDetailsCount();
            if (!$valid) {
                $this->header->addError('error', 'Validate Details Error');
            }
        }
        
        if (count($this->details) > 0) {
            foreach ($this->details as $detail) {
                $fields = array('quantity', 'item_name', 'item_code');
                $valid = $valid && $detail->validate($fields);
            }
        } else {
            $valid = false;
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
        $valid = $this->header->save(false);

        foreach ($this->details as $detail) {
            
            if ($detail->quantity <= 0) {
                continue;
            }

            $detail->maintenance_request_header_id = $this->header->id;
            $valid = $valid && $detail->save(false);
        }

        return $valid;
    }
}
