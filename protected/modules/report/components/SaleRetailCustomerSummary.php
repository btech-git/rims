<?php

class SaleRetailCustomerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//        $this->dataProvider->criteria->together = TRUE;
//        $this->dataProvider->criteria->with = array(
//            'registrationTransactions',
//        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 100 : $pageSize;
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
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
        }

        $this->dataProvider->criteria->addCondition('EXISTS (
            SELECT id FROM rims_registration_transaction
            WHERE customer_id = t.id AND transaction_date BETWEEN :start_date AND :end_date' . $branchConditionSql . '
        )');
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $params[':branch_id'] = $branchId;
        }
        $this->dataProvider->criteria->compare('t.customer_type', 'Company');
//        $this->dataProvider->criteria->addBetweenCondition('substr(registrationTransactions.transaction_date, 1, 10)', $startDate, $endDate);
//        if (!empty($branchId)) {
//            $this->dataProvider->criteria->compare('registrationTransactions.branch_id', $branchId);
//        }
    }
}
