<?php

class SaleFlowSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'customer',
            'vehicle',
            'branch',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 100 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.transaction_date', 't.transaction_number');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $transactionStatus = (empty($filters['transactionStatus'])) ? '' : $filters['transactionStatus'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $customerId = (empty($filters['customerId'])) ? '' : $filters['customerId'];
        $plateNumber = (empty($filters['plateNumber'])) ? '' : $filters['plateNumber'];
        
        $statusConditionSql = '';
        $branchConditionSql = '';
        $customerConditionSql = '';
        $plateNumberConditionSql = '';
        
        if (!empty($transactionStatus)) {
            $statusConditionSql = ' AND t.status = :status';
        }

        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.branch_id = :branch_id';
        }

        if (!empty($customerId)) {
            $customerConditionSql = ' AND t.customer_id = :customer_id';
        }

        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND vehicle.plate_number LIKE :plate_number';
        }

        $this->dataProvider->criteria->with = array(
            'customer',
            'vehicle',
        );
        $this->dataProvider->criteria->addCondition("substr(t.transaction_date, 1, 10) BETWEEN :start_date AND :end_date" . $statusConditionSql . $branchConditionSql . $customerConditionSql . $plateNumberConditionSql);
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($transactionStatus)) {
            $this->dataProvider->criteria->params[':status'] = $transactionStatus;
        }
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        if (!empty($customerId)) {
            $this->dataProvider->criteria->params[':customer_id'] = $customerId;
        }
        if (!empty($plateNumber)) {
            $this->dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
    }
}
