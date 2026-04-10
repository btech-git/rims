<?php

class VehicleSystemCheck extends CComponent {

    public $header;
    public $detailTires;
    public $detailComponents;

    public function __construct($header, array $detailTires, array $detailComponents) {
        $this->header = $header;
        $this->detailTires = $detailTires;
        $this->detailComponents = $detailComponents;
    }

    public function generateCodeNumber($currentMonth, $currentYear, $branchId) {
        $arr = array(1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        $cnYearCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', 1)";
        $cnMonthCondition = "substring_index(substring_index(substring_index(transaction_number, '/', 2), '/', -1), '.', -1)";
        $vehicleSystemCheckHeader = VehicleSystemCheckHeader::model()->find(array(
            'order' => ' id DESC',
            'condition' => "$cnYearCondition = :cn_year AND $cnMonthCondition = :cn_month AND branch_id = :branch_id",
            'params' => array(':cn_year' => $currentYear, ':cn_month' => $arr[$currentMonth], ':branch_id' => $branchId),
        ));

        if ($vehicleSystemCheckHeader == null) {
            $branchCode = Branch::model()->findByPk($branchId)->code;
        } else {
            $branchCode = $vehicleSystemCheckHeader->branch->code;
            $this->header->transaction_number = $vehicleSystemCheckHeader->transaction_number;
        }

        $this->header->setCodeNumberByNext('transaction_number', $branchCode, VehicleSystemCheckHeader::CONSTANT, $currentMonth, $currentYear);
    }

    public function addDetailTire() {
        $componentInspections = ComponentInspection::model()->findAllByAttributes(array('component_inspection_group_id' => 1));

        foreach ($componentInspections as $componentInspection) {
            $vehicleSystemCheckTireDetail = new VehicleSystemCheckTireDetail();
            $vehicleSystemCheckTireDetail->component_inspection_id = $componentInspection->id;
            $this->detailTires[] = $vehicleSystemCheckTireDetail;
        }
    }

    public function addDetailComponent() {
        $componentInspections = ComponentInspection::model()->findAll(array('condition' => 't.component_inspection_group_id NOT IN (1)'));

        foreach ($componentInspections as $componentInspection) {
            $vehicleSystemCheckComponentDetail = new VehicleSystemCheckComponentDetail();
            $vehicleSystemCheckComponentDetail->component_inspection_id = $componentInspection->id;
            $vehicleSystemCheckComponentDetail->component_inspection_group_id = $componentInspection->component_inspection_group_id;
            $this->detailComponents[$componentInspection->component_inspection_group_id][] = $vehicleSystemCheckComponentDetail;
        }
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

            foreach ($this->detailTires as $detail) {
                $valid = $valid && $detail->delete();
            }

            foreach ($this->detailComponents as $detail) {
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
        
//        if (count($this->detailTires) > 0) {
//            foreach ($this->detailTires as $detail) {
//                $fields = array('product_id_front_left_after_service', 'product_id_front_left_before_service', 'production_year_front_left_before_service', 'production_year_front_left_after_service');
//                $valid = $valid && $detail->validate($fields);
//            }
//        } else {
//            $valid = false;
//        }
//
//        if (count($this->detailComponents) > 0) {
//            foreach ($this->detailComponents as $detail) {
//                $fields = array('component_condition_before_service', 'component_condition_after_service', 'component_inspection_id');
//                $valid = $valid && $detail->validate($fields);
//            }
//        } else {
//            $valid = false;
//        }

        return $valid;
    }

    public function validateDetailsCount() {
        $valid = true;
        if (count($this->detailTires) === 0 && count($this->detailComponents) === 0) {
            $valid = false;
            $this->header->addError('error', 'Form tidak ada data untuk insert database. Minimal satu data detail untuk melakukan penyimpanan.');
        }

        return $valid;
    }

    public function flush() {
        $valid = $this->header->save(false);

        foreach ($this->detailTires as $detailTire) {
            $detailTire->vehicle_system_check_header_id = $this->header->id;
            $valid = $valid && $detailTire->save(false);
        }

        foreach ($this->detailComponents as $groupItem) {
            foreach ($groupItem as $detailComponent) {
                $detailComponent->vehicle_system_check_header_id = $this->header->id;
                $valid = $valid && $detailComponent->save(false);
            }
        }

        return $valid;
    }
}