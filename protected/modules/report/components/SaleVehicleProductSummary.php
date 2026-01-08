<?php

class SaleVehicleProductSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'carMake',
            'carModel',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('carMake.name ASC, carModel.name ASC, t.name ASC');
//        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $carMakeId = (empty($filters['carMakeId'])) ? '' : $filters['carMakeId'];
        $carModelId = (empty($filters['carModelId'])) ? '' : $filters['carModelId'];
        $carSubModelId = (empty($filters['carSubModelId'])) ? '' : $filters['carSubModelId'];
        
        $branchConditionSql = '';
        $carMakeConditionSql = '';
        $carModelConditionSql = '';
        $carSubModelConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        if (!empty($carMakeId)) {
            $carMakeConditionSql = ' AND v.car_make_id = :car_make_id';
            $this->dataProvider->criteria->params[':car_make_id'] = $carMakeId;
        }
        
        if (!empty($carModelId)) {
            $carModelConditionSql = ' AND v.car_model_id = :car_model_id';
            $this->dataProvider->criteria->params[':car_model_id'] = $carModelId;
        }
        
        if (!empty($carSubModelId)) {
            $carSubModelConditionSql = ' AND v.car_sub_model_id = :car_sub_model_id';
            $this->dataProvider->criteria->params[':car_sub_model_id'] = $carSubModelId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT v.car_sub_model_id
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            WHERE t.id = v.car_sub_model_id AND i.user_id_cancelled IS NULL AND i.invoice_date BETWEEN :start_date AND :end_date" . $branchConditionSql . 
                $carMakeConditionSql . $carModelConditionSql . $carSubModelConditionSql . "
        )");
        
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
