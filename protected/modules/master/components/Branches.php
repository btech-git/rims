<?php

class Branches extends CComponent {

    public $header;
    public $warehouseDetails;
    public $divisionDetails;
    public $phoneDetails;
    public $faxDetails;
    public $interbranchDetails;

    public function __construct($header, array $divisionDetails, array $warehouseDetails, array $phoneDetails, array $faxDetails, array $interbranchDetails) {
        $this->header = $header;
        $this->warehouseDetails = $warehouseDetails;
        $this->divisionDetails = $divisionDetails;
        $this->phoneDetails = $phoneDetails;
        $this->faxDetails = $faxDetails;
        $this->interbranchDetails = $interbranchDetails;
    }

    public function addDetail($warehouseId) {
        $warehouseDetail = Warehouse::model()->findByPk($warehouseId);
        $warehouseDetail->id = $warehouseId;

        $warehouseDetail->name = $warehouseDetail->name;
        $this->warehouseDetails[] = $warehouseDetail;
    }

    public function removeDetailAt($index) {
        array_splice($this->warehouseDetails, $index, 1);
    }

    public function addDivisionDetail($divisionId) {
        $divisionDetail = new DivisionBranch();
        $divisionDetail->division_id = $divisionId;
        $divisionData = Division::model()->findByPk($divisionDetail->division_id);
        $divisionDetail->division_name = $divisionData->name;
        $this->divisionDetails[] = $divisionDetail;
    }

    public function removeDivisionDetailAt($index) {
        array_splice($this->divisionDetails, $index, 1);
    }

    public function addPhoneDetail() {
        $phoneDetail = new BranchPhone();

        $this->phoneDetails[] = $phoneDetail;
    }

    public function removePhoneDetailAt($index) {
        array_splice($this->phoneDetails, $index, 1);
    }

    public function addFaxDetail() {
        $faxDetail = new BranchFax();

        $this->faxDetails[] = $faxDetail;
    }

    public function removeFaxDetailAt($index) {
        array_splice($this->faxDetails, $index, 1);
    }

    public function addInterbranch($interbranchId) {
        $exist = FALSE;
        $interbranch = Branch::model()->findByPk($interbranchId);

        if ($interbranch != null) {
            foreach ($this->interbranchDetails as $detail) {
                if ($detail->branch_id_to == $interbranch->id) {
                    $exist = TRUE;
                    break;
                }
            }

            if (!$exist) {
                $detail = new BranchCoaInterbranch();
                $detail->branch_id_to = $interbranchId;
                $this->interbranchDetails[] = $detail;
            }
        }
        else
            $this->header->addError('error', 'Branch tujuan tidak ada di dalam detail');
    }

    public function removeCoaDetailAt($index) {
        array_splice($this->interbranchDetails, $index, 1);
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

        if (count($this->warehouseDetails) > 0) {
            foreach ($this->warehouseDetails as $warehouseDetail) {
                $fields = array('warehouse_id');
                $valid = $warehouseDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->divisionDetails) > 0) {
            foreach ($this->divisionDetails as $divisionDetail) {
                $fields = array('division_id');
                $valid = $divisionDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->phoneDetails) > 0) {
            foreach ($this->phoneDetails as $phoneDetail) {
                $fields = array('phone_no');
                $valid = $phoneDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        if (count($this->faxDetails) > 0) {
            foreach ($this->faxDetails as $faxDetail) {
                $fields = array('fax_no');
                $valid = $faxDetail->validate($fields) && $valid;
            }
        } else {
            $valid = true;
        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        
        if (count($this->warehouseDetails) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
//        $isNewRecord = $this->header->isNewRecord;
        $valid = $this->header->save();

        $warehouseBranches = BranchWarehouse::model()->findAllByAttributes(array('branch_id' => $this->header->id));
        $wareId = array();
        foreach ($warehouseBranches as $warehouseBranch) {
            $wareId[] = $warehouseBranch->id;
        }
        $new_detail = array();

        $divisionBranchs = DivisionBranch::model()->findAllByAttributes(array('branch_id' => $this->header->id));
        $divisionId = array();
        foreach ($divisionBranchs as $divisionBranch) {
            $divisionId[] = $divisionBranch->id;
        }
        $new_division = array();

        $branchPhones = BranchPhone::model()->findAllByAttributes(array('branch_id' => $this->header->id));
        $phoneId = array();
        foreach ($branchPhones as $branchPhone) {
            $phoneId[] = $branchPhone->id;
        }
        $new_phone = array();

        $branchFaxes = BranchFax::model()->findAllByAttributes(array('branch_id' => $this->header->id));
        $faxId = array();
        foreach ($branchFaxes as $branchFax) {
            $phoneId[] = $branchFax->id;
        }
        $new_fax = array();

        //position
        foreach ($this->warehouseDetails as $warehouseDetail) {
            $warehouseDetail->branch_id = $this->header->id;

            $valid = $warehouseDetail->save(false) && $valid;
            $new_detail[] = $warehouseDetail->id;
        }

        //Division
        foreach ($this->divisionDetails as $divisionDetail) {
            $divisionDetail->branch_id = $this->header->id;

            $valid = $divisionDetail->save(false) && $valid;
            $new_division[] = $divisionDetail->id;
        }

        //Phone
        foreach ($this->phoneDetails as $phoneDetail) {
            $phoneDetail->branch_id = $this->header->id;

            $valid = $phoneDetail->save(false) && $valid;
            $new_phone[] = $phoneDetail->id;
        }

        //Fax
        foreach ($this->faxDetails as $faxDetail) {
            $faxDetail->branch_id = $this->header->id;

            $valid = $faxDetail->save(false) && $valid;
            $new_fax[] = $faxDetail->id;
        }

        //Interbranch
        foreach ($this->interbranchDetails as $interbranchDetail) {
            $interbranchDetail->branch_id_from = $this->header->id;

            $valid = $valid && $interbranchDetail->save(false);
        }

        //delete position
        $delete_array = array_diff($wareId, $new_detail);
        if ($delete_array != NULL) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $delete_array);
            BranchWarehouse::model()->deleteAll($criteria);
        }

        //delete division
        $delete_division_array = array_diff($divisionId, $new_division);
        if ($delete_division_array != NULL) {
            $divisioncriteria = new CDbCriteria;
            $divisioncriteria->addInCondition('id', $delete_division_array);
            DivisionBranch::model()->deleteAll($divisioncriteria);
        }

        //delete phone
        $delete_phone_array = array_diff($phoneId, $new_phone);
        if ($delete_phone_array != NULL) {
            $phonecriteria = new CDbCriteria;
            $phonecriteria->addInCondition('id', $delete_phone_array);
            BranchPhone::model()->deleteAll($phonecriteria);
        }

        //delete fax
        $delete_fax_array = array_diff($faxId, $new_fax);
        if ($delete_fax_array != NULL) {
            $faxcriteria = new CDbCriteria;
            $faxcriteria->addInCondition('id', $delete_fax_array);
            BranchFax::model()->deleteAll($faxcriteria);
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
