<?php

class OutstandingRegistrationTransactionSummary extends CComponent {

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
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
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
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $customerId = (empty($filters['customerId'])) ? '' : $filters['customerId'];
        $plateNumber = (empty($filters['plateNumber'])) ? '' : $filters['plateNumber'];
        
        $branchConditionSql = '';
        $customerConditionSql = '';
        $plateNumberConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }

        if (!empty($customerId)) {
            $customerConditionSql = ' AND t.customer_id = :customer_id';
            $this->dataProvider->criteria->params[':customer_id'] = $customerId;
        }

        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND vehicle.plate_number LIKE :plate_number';
            $this->dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }

        $this->dataProvider->criteria->with = array(
            'customer',
            'vehicle',
        );
        
        $this->dataProvider->criteria->addCondition("substr(t.transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND t.sales_order_number IS NULL AND
                t.work_order_number IS NULL AND t.user_id_cancelled IS NULL" . 
        $branchConditionSql . $customerConditionSql . $plateNumberConditionSql);
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
