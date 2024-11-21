<?php

class SaleVehicleProductSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        
        $branchConditionSql = '';
        if (!empty($branchId)) {
            $branchConditionSql = ' AND r.branch_id = :branch_id';
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT r.id
            FROM " . Vehicle::model()->tableName() . " v
            INNER JOIN " . InvoiceHeader::model()->tableName() . " r ON v.id = r.vehicle_id
            INNER JOIN " . InvoiceDetail::model()->tableName() . " p ON r.id = p.invoice_id
            WHERE v.car_make_id = t.id AND substr(r.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND r.status NOT LIKE '%CANCEL%'" . $branchConditionSql . "
        )");
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
    }
}
