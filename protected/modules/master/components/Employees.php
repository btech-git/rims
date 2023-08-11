<?php

class Employees extends CComponent {

    public $header;
    public $phoneDetails;
    public $mobileDetails;
    public $bankDetails;
    public $incentiveDetails;
    public $deductionDetails;
    public $divisionDetails;

    public function __construct($header, array $phoneDetails, array $mobileDetails, array $bankDetails, array $incentiveDetails, array $deductionDetails, array $divisionDetails) {
        $this->header = $header;
        $this->phoneDetails = $phoneDetails;
        $this->mobileDetails = $mobileDetails;
        $this->bankDetails = $bankDetails;
        $this->incentiveDetails = $incentiveDetails;
        $this->deductionDetails = $deductionDetails;
        $this->divisionDetails = $divisionDetails;
    }

    public function addDetail() {
        $phoneDetail = new EmployeePhone();
        $this->phoneDetails[] = $phoneDetail;
    }

    public function addMobileDetail() {
        $mobileDetail = new EmployeeMobile();

        $this->mobileDetails[] = $mobileDetail;
    }

    public function addBankDetail($bankId) {
        $bankDetail = new EmployeeBank();
        $bankDetail->bank_id = $bankId;
        $bank = Bank::model()->findByPk($bankDetail->bank_id);
        //$bankDetail->bank_name = $bank->name;
        $this->bankDetails[] = $bankDetail;
    }

    public function addIncentiveDetail($incentivesId) {
        $incentiveDetail = new EmployeeIncentives();
        $incentiveDetail->incentive_id = $incentivesId;
        $incentive = Incentive::model()->findByPk($incentiveDetail->incentive_id);
        //print_r($incentive);///exit;
        //$incentiveDetail->incentive_name = $incentive->name;
        $this->incentiveDetails[] = $incentiveDetail;
    }

    public function addDeductionDetail($deductionId) {
        $deductionDetail = new EmployeeDeductions();
        $deductionDetail->deduction_id = $deductionId;
        $deduction = Deduction::model()->findByPk($deductionDetail->deduction_id);
        $this->deductionDetails[] = $deductionDetail;
    }

    public function addDivisionDetail($branchId) {
        $divisionDetail = new EmployeeBranchDivisionPositionLevel();
        $divisionDetail->branch_id = $branchId;
        $this->divisionDetails[] = $divisionDetail;
    }

    public function removeDetailAt($index) {
        array_splice($this->phoneDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
    }

    public function removeMobileDetailAt($index) {
        array_splice($this->mobileDetails, $index, 1);
        //var_dump(CJSON::encode($this->details));
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

    public function removeDivisionDetailAt($index) {
        array_splice($this->divisionDetails, $index, 1);
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

        if (count($this->phoneDetails) > 0) {
            foreach ($this->phoneDetails as $phoneDetail) {
                $fields = array('phone_no');
                $valid = $phoneDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->mobileDetails) > 0) {
            foreach ($this->mobileDetails as $mobileDetail) {
                $fields = array('mobile_no');
                $valid = $mobileDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        //commmented on 13 Oct 
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

        if (count($this->divisionDetails) > 0) {
            foreach ($this->divisionDetails as $divisionDetail) {
                $fields = array('position_id');
                $valid = $divisionDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        //print_r($valid);
        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->phoneDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
//        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();

        //Update code after saving header
//        $employee = Employee::model()->findByPk($this->header->id);
//        $this->header->code = 'E-' . $this->header->id;
//        $this->header->update(array('code'));

        $employee_phones = EmployeePhone::model()->findAllByAttributes(array('employee_id' => $this->header->id));
        $phoneId = array();
        foreach ($employee_phones as $employee_phone) {
            $phoneId[] = $employee_phone->id;
        }
        $new_detail = array();

        $employee_mobiles = EmployeeMobile::model()->findAllByAttributes(array('employee_id' => $this->header->id));
        $mobileId = array();
        foreach ($employee_mobiles as $employee_mobile) {
            $mobileId[] = $employee_mobile->id;
        }
        $new_mobile = array();

        //Commented on 13 Oct
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

        /*$employee_divisions = EmployeeBranchDivisionPositionLevel::model()->findAllByAttributes(array('employee_id' => $this->header->id));
        $divisionId = array();
        foreach ($employee_divisions as $employee_division) {
            $divisionId[] = $employee_division->id;
        }
        $new_division = array();*/

        //phone
        foreach ($this->phoneDetails as $phoneDetail) {
            $phoneDetail->employee_id = $this->header->id;

            $valid = $phoneDetail->save(false) && $valid;
            $new_detail[] = $phoneDetail->id;
            //echo 'test phone added';
        }

        //mobile
        foreach ($this->mobileDetails as $mobileDetail) {
            $mobileDetail->employee_id = $this->header->id;
            $valid = $mobileDetail->save(false) && $valid;
            $new_mobile[] = $mobileDetail->id;
            //echo 'test mobile added';
        }

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

        //Division
        foreach ($this->divisionDetails as $divisionDetail) {
            $divisionDetail->employee_id = $this->header->id;
            $divisionDetail->branch_id = $_POST['Employee']['branch_id'];
            $valid = $divisionDetail->save(false) && $valid;
            $new_division[] = $divisionDetail->id;
        }
        //var_dump(CJSON::encode($this->phoneDetails));
        //delete phone
        $delete_array = array_diff($phoneId, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            EmployeePhone::model()->deleteAll($criteria);
        }

        //delete mobile
        $delete_mobile = array_diff($mobileId, $new_mobile);
        if ($delete_mobile != NULL) {
            $mobile_criteria = new CDbCriteria;
            $mobile_criteria->addInCondition('id', $delete_mobile);
            EmployeeMobile::model()->deleteAll($mobile_criteria);
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

        //delete Divisions
        /*$delete_division = array_diff($divisionId, $new_division);
        if ($delete_division != NULL) {
            $division_criteria = new CDbCriteria;
            $division_criteria->addInCondition('id', $delete_division);
            EmployeeBranchDivisionPositionLevel::model()->deleteAll($division_criteria);
        }*/

        return $valid;
    }

}
