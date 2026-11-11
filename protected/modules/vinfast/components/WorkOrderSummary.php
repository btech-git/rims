<?php

class WorkOrderSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'vehicle',
            'customer',
            'branch',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 50 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.transaction_date DESC');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate) {
        $this->dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

    }

    public function setupFilterOutstanding($startDate, $endDate) {
        $this->dataProvider->criteria->addCondition("NOT EXISTS (
            SELECT i.registration_transaction_id
            FROM " . InvoiceHeader::model()->tableName() . " i
            WHERE t.id = i.registration_transaction_id
        ) AND t.work_order_number IS NOT NULL AND t.status NOT LIKE '%CANCELLED%'");

        $this->dataProvider->criteria->addBetweenCondition('SUBSTRING(t.transaction_date, 1, 10)', $startDate, $endDate);

    }
}
