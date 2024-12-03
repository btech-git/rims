<?php

class UserPerformanceSummary extends CComponent {

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

    public function setupFilter() {
        $this->dataProvider->criteria->compare('t.status', 1);
//        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
//        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
//        
//        $this->dataProvider->criteria->addCondition("EXISTS (
//            SELECT i.id 
//            FROM " . RegistrationTransaction::model()->tableName() . " r
//            INNER JOIN " . InvoiceHeader::model()->tableName() . " i ON r.id = i.registration_transaction_id
//            WHERE r.employee_id_sales_person = t.id AND substr(i.invoice_date, 1, 10) BETWEEN :start_date AND :end_date AND t.position_id = 2
//        )");
//        $this->dataProvider->criteria->params[':start_date'] = $startDate;
//        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
