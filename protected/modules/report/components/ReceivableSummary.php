<?php

class ReceivableSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
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
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $insuranceCompanyId = (empty($filters['insuranceCompanyId'])) ? '' : $filters['insuranceCompanyId'];
        $plateNumber = (empty($filters['plateNumber'])) ? '' : $filters['plateNumber'];
        
        $branchConditionSql = '';
        $insuranceConditionSql = '';
        $plateConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        if (!empty($insuranceCompanyId)) {
            $insuranceConditionSql = ' AND p.insurance_company_id = :insurance_company_id';
            $this->dataProvider->criteria->params[':insurance_company_id'] = $insuranceCompanyId;
        }
        
        if (!empty($plateNumber)) {
            $plateConditionSql = ' AND v.plate_number LIKE :plate_number';
            $this->dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT p.customer_id, SUM(p.payment_left) AS remaining
            FROM " . InvoiceHeader::model()->tableName() . " p 
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = p.customer_id
            LEFT OUTER JOIN " . Vehicle::model()->tableName() . " v ON v.id = p.vehicle_id
            WHERE p.customer_id = t.id AND p.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date" . $branchConditionSql . $insuranceConditionSql . $plateConditionSql . " 
            GROUP BY p.customer_id 
            HAVING remaining > 100
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.customer_type', 'Company');
    }
}
