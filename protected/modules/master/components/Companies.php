<?php

class Companies extends CComponent {

    public $header;
    public $bankDetails;
    public $branchDetails;

    // public $picPhoneDetails;
    // public $picMobileDetails;

    public function __construct($header, array $bankDetails, array $branchDetails) {
        $this->header = $header;
        $this->bankDetails = $bankDetails;
        $this->branchDetails = $branchDetails;
        // $this->picPhoneDetails = $picPhoneDetails;
        // $this->picMobileDetails = $picMobileDetails;
    }

    public function addBranchDetail($branchId) {
        //$jenis_persediaan = MasterJenisPersediaan::model()->findAllByAttributes(array('kelompok_persediaan_id' => $id));
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

        //$valid = $this->validateDetailsCount() && $valid;

        if (count($this->bankDetails) > 0) {
            foreach ($this->bankDetails as $bankDetail) {
                $fields = array('account_no', 'account_name');
                $valid = $bankDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        //print_r($valid);
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
        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();
        //echo $valid;


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

        $this->saveTransactionLog();
        
        return $valid;
    }
    
    public function saveTransactionLog() {
        $transactionLog = new MasterLog();
        $transactionLog->name = $this->header->name;
        $transactionLog->log_date = date('Y-m-d');
        $transactionLog->log_time = date('H:i:s');
        $transactionLog->table_name = $this->header->tableName();
        $transactionLog->table_id = $this->header->id;
        $transactionLog->user_id = Yii::app()->user->id;
        $transactionLog->username = Yii::app()->user->username;
        $transactionLog->controller_class = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id;
        $transactionLog->action_name = Yii::app()->controller->action->id;
        
        $newData = $this->header->attributes;
        $transactionLog->new_data = json_encode($newData);

        $transactionLog->save();
    }
}
