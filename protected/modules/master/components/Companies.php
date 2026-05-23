<?php

class Companies extends CComponent {

    public $header;
    public $bankDetails;
    public $branchDetails;

    public function __construct($header, array $bankDetails, array $branchDetails) {
        $this->header = $header;
        $this->bankDetails = $bankDetails;
        $this->branchDetails = $branchDetails;
    }

    public function addBranchDetail($branchId) {
        $branchDetail = new CompanyBranch();
        $branchDetail->branch_id = $branchId;
        $branchData = Branch::model()->findByPk($branchDetail->branch_id);
        $branchDetail->branch_name = $branchData->name;
        $this->branchDetails[] = $branchDetail;
        //print_r($this->details);
    }

    public function addBankDetail($bankId) {

        $bankDetail = new CompanyBank();
        $bankDetail->bank_id = $bankId;
        $bank = Bank::model()->findByPk($bankDetail->bank_id);
        $bankDetail->bank_name = $bank->name;
        $this->bankDetails[] = $bankDetail;
    }

    public function removeBranchDetailAt($index) {
        array_splice($this->branchDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removeBankDetailAt($index) {
        array_splice($this->bankDetails, $index, 1);
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

        if (count($this->bankDetails) > 0) {
            foreach ($this->bankDetails as $bankDetail) {
                $fields = array('account_no', 'account_name');
                $valid = $bankDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->bankDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        if (count($this->branchDetails) > 0) {
            foreach ($this->branchDetails as $branchDetail) {
                $fields = array('branch_id');
                $valid = $branchDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save();

        $company_banks = CompanyBank::model()->findAllByAttributes(array('company_id' => $this->header->id));
        $bankId = array();
        foreach ($company_banks as $company_bank) {
            $bankId[] = $company_bank->id;
        }
        $new_bank = array();

        $company_branches = CompanyBranch::model()->findAllByAttributes(array('company_id' => $this->header->id));
        $branchId = array();
        foreach ($company_branches as $company_branch) {
            $branchId[] = $company_branch->id;
        }
        $new_branch = array();

        //Bank
        foreach ($this->bankDetails as $bankDetail) {
            $bankDetail->company_id = $this->header->id;
            $valid = $bankDetail->save(false) && $valid;
            $new_bank[] = $bankDetail->id;
        }

        //branch
        foreach ($this->branchDetails as $branchDetail) {
            $branchDetail->company_id = $this->header->id;

            $valid = $branchDetail->save(false) && $valid;
            $new_branch[] = $branchDetail->id;
        }


        //delete Bank
        $delete_bank = array_diff($bankId, $new_bank);
        if ($delete_bank != NULL) {
            $bank_criteria = new CDbCriteria;
            $bank_criteria->addInCondition('id', $delete_bank);
            CompanyBank::model()->deleteAll($bank_criteria);
        }

        //delete branch
        $delete_branch_array = array_diff($branchId, $new_branch);
        if ($delete_branch_array != NULL) {
            $branchcriteria = new CDbCriteria;
            $branchcriteria->addInCondition('id', $delete_branch_array);
            CompanyBranch::model()->deleteAll($branchcriteria);
        }

        $this->saveMasterLog();
        
        return $valid;
    }
    
    public function saveMasterLog() {
        $masterLog = new MasterLog();
        $masterLog->name = $this->header->name;
        $masterLog->log_date = date('Y-m-d');
        $masterLog->log_time = date('H:i:s');
        $masterLog->table_name = $this->header->tableName();
        $masterLog->table_id = $this->header->id;
        $masterLog->user_id = Yii::app()->user->id;
        $masterLog->username = Yii::app()->user->username;
        $masterLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $masterLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        $masterLog->new_data = json_encode($newData);

        $masterLog->save();
    }
}
