<?php

class WarehouseFlowSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//        $this->dataProvider->criteria->with = array(
//            'customer',
//            'vehicle',
//            'branch',
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
        $this->dataProvider->sort->attributes = array('t.transaction_date');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addCondition('substr(t.transaction_date, 1, 10) BETWEEN :start_date AND :end_date');
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }

    public function setupFilterTransfer($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addCondition('substr(t.transfer_request_date, 1, 10) BETWEEN :start_date AND :end_date');
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }

    public function setupFilterSent($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addCondition('substr(t.sent_request_date, 1, 10) BETWEEN :start_date AND :end_date');
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }

    public function setupFilterPurchase($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addCondition('substr(t.purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date');
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
