<?php

class EmployeePayroll extends CComponent {

    public $header;
    public $bankDetails;
    public $incentiveDetails;
    public $deductionDetails;

    public function __construct($header, array $bankDetails, array $incentiveDetails, array $deductionDetails) {
        $this->header = $header;
        $this->bankDetails = $bankDetails;
        $this->incentiveDetails = $incentiveDetails;
        $this->deductionDetails = $deductionDetails;
    }

    public function addBankDetail($bankId) {
        $bankDetail = new EmployeeBank();
        $bankDetail->bank_id = $bankId;
        $this->bankDetails[] = $bankDetail;
    }

    public function addIncentiveDetail($incentivesId) {
        $incentiveDetail = new EmployeeIncentives();
        $incentiveDetail->incentive_id = $incentivesId;
        $this->incentiveDetails[] = $incentiveDetail;
    }

    public function addDeductionDetail($deductionId) {
        $deductionDetail = new EmployeeDeductions();
        $deductionDetail->deduction_id = $deductionId;
        $this->deductionDetails[] = $deductionDetail;
    }

    public function removeBankDetailAt($index) {
        array_splice($this->bankDetails, $index, 1);
    }

    public function removeIncentiveDetailAt($index) {
        array_splice($this->incentiveDetails, $index, 1);
    }

    public function removeDeductionDetailAt($index) {
        array_splice($this->deductionDetails, $index, 1);
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
        $valid = true;

        if (count($this->bankDetails) > 0) {
            foreach ($this->bankDetails as $bankDetail) {
                $fields = array('account_no', 'account_name');
                $valid = $bankDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->incentiveDetails) > 0) {
            foreach ($this->incentiveDetails as $incentiveDetail) {
                $fields = array('amount');
                $valid = $incentiveDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->deductionDetails) > 0) {
            foreach ($this->deductionDetails as $deductionDetail) {
                $fields = array('amount');
                $valid = $deductionDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function flush() {

        $valid = true; 
        $employee_banks = EmployeeBank::model()->findAllByAttributes(array('employee_id' => $this->header->id));
        $bankId = array();
        foreach ($employee_banks as $employee_bank) {
            $bankId[] = $employee_bank->id;
        }
        $new_bank = array();

        $employee_incentives = EmployeeIncentives::model()->findAllByAttributes(array('employee_id' => $this->header->id));
        $incentiveId = array();
        foreach ($employee_incentives as $employee_incentive) {
            $incentiveId[] = $employee_incentive->id;
        }
        $new_incentive = array();

        $employee_deductions = EmployeeDeductions::model()->findAllByAttributes(array('employee_id' => $this->header->id));
        $deductionId = array();
        foreach ($employee_deductions as $employee_deduction) {
            $deductionId[] = $employee_deduction->id;
        }
        $new_deduction = array();

        //Bank
        foreach ($this->bankDetails as $bankDetail) {
            $bankDetail->employee_id = $this->header->id;
            $valid = $bankDetail->save(false) && $valid;
            $new_bank[] = $bankDetail->id;
        }

        //Incentive
        foreach ($this->incentiveDetails as $incentiveDetail) {
            $incentiveDetail->employee_id = $this->header->id;
            $valid = $incentiveDetail->save(false) && $valid;
            $new_incentive[] = $incentiveDetail->id;
            //echo 'test incentiveDetail added'; exit;
        }

        //Deduction
        foreach ($this->deductionDetails as $deductionDetail) {
            $deductionDetail->employee_id = $this->header->id;
            $valid = $deductionDetail->save(false) && $valid;
            $new_deduction[] = $deductionDetail->id;
            //print_r($new_deduction);
            //echo 'test deduction added';
            //exit;
        }

        //delete Bank
        $delete_bank = array_diff($bankId, $new_bank);
        if ($delete_bank != NULL) {
            $bank_criteria = new CDbCriteria;
            $bank_criteria->addInCondition('id', $delete_bank);
            EmployeeBank::model()->deleteAll($bank_criteria);
        }

        //delete Incentive
        $delete_incentive = array_diff($incentiveId, $new_incentive);
        if ($delete_incentive != NULL) {
            $incentive_criteria = new CDbCriteria;
            $incentive_criteria->addInCondition('id', $delete_incentive);
            EmployeeIncentives::model()->deleteAll($incentive_criteria);
        }

        //delete Deductions
        $delete_deduction = array_diff($deductionId, $new_deduction);
        if ($delete_deduction != NULL) {
            $deduction_criteria = new CDbCriteria;
            $deduction_criteria->addInCondition('id', $delete_deduction);
            EmployeeDeductions::model()->deleteAll($deduction_criteria);
        }

        return $valid;
    }
}