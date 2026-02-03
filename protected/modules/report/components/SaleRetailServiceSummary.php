<?php

class SaleRetailServiceSummary extends CComponent {

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
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $serviceTypeId = (empty($filters['serviceTypeId'])) ? '' : $filters['serviceTypeId'];
        $serviceCategoryId = (empty($filters['serviceCategoryId'])) ? '' : $filters['serviceCategoryId'];
        $customerType = (empty($filters['customerType'])) ? '' : $filters['customerType'];
        
        $branchConditionSql = '';
        $customerTypeConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }

        if (!empty($customerType)) {
            $customerTypeConditionSql = ' AND c.customer_type = :customer_type';
            $this->dataProvider->criteria->params[':customer_type'] = $customerType;
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT d.id FROM " . InvoiceDetail::model()->tableName() . " d 
            INNER JOIN " . InvoiceHeader::model()->tableName() . " h ON h.id = d.invoice_id
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = h.customer_id
            WHERE d.service_id = t.id AND substr(h.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND h.status NOT LIKE '%CANCEL%'" . 
                $branchConditionSql . $customerTypeConditionSql . " 
        )");
        
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.service_type_id', $serviceTypeId);
        $this->dataProvider->criteria->compare('t.service_category_id', $serviceCategoryId);
    }
}