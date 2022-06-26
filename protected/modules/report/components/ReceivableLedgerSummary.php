<?php

class ReceivableLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'invoiceHeaders',
            'paymentIns',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 30000 : $pageSize;
//        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $this->dataProvider->criteria->compare('t.name', $filters['customerName'], true);
//        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
//        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
//        
//        $this->dataProvider->criteria->addBetweenCondition('invoiceHeaders.invoice_date', $startDate, $endDate);
//        $this->dataProvider->criteria->addBetweenCondition('paymentIns.payment_date', $startDate, $endDate);
    }
}
