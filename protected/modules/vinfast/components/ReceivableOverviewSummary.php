<?php

class ReceivableOverviewSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = 't.name ASC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $year = (empty($filters['year'])) ? date('Y') : $filters['year'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $customerId = (empty($filters['customerId'])) ? '' : $filters['customerId'];
        
        $this->dataProvider->criteria->compare('t.status', 'Active');
        $this->dataProvider->criteria->compare('t.customer_type', 'Company');
        $this->dataProvider->criteria->compare('t.id', $customerId);
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("t.id IN (60849, 60926, 63482) AND EXISTS (
            SELECT i.id FROM " . InvoiceHeader::model()->tableName() . " i
            WHERE t.id = i.customer_id AND i.user_id_cancelled IS NULL AND i.insurance_company_id IS NULL AND
                YEAR(i.invoice_date) = :year" . $branchConditionSql . "
        )");
        
        $this->dataProvider->criteria->params[':year'] = $year;
    }
}