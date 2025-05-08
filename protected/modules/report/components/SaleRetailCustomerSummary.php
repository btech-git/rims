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
        $taxValue = (empty($filters['taxValue'])) ? '' : $filters['taxValue'];
        
        $taxValueConditionSql = '';
        
        if (!empty($taxValue)) {
            $taxValueConditionSql = ' AND t.ppn = :tax_value';
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT id FROM " . InvoiceHeader::model()->tableName() . "
            WHERE customer_id = t.id AND substr(invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND t.status NOT LIKE '%CANCELLED%'" . $taxValueConditionSql . " 
        )");
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($taxValue)) {
            $this->dataProvider->criteria->params[':tax_value'] = $taxValue;
        }
        $this->dataProvider->criteria->compare('t.customer_type', 'Company');
    }
}
