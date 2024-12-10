<?php

class SaleFlowSummary extends CComponent {

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
        $this->dataProvider->criteria->addCondition('t.status NOT LIKE "%CANCELLED%"');
        $this->dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
//        $this->dataProvider->criteria->compare('t.customer_id', FALSE);
//        $this->dataProvider->criteria->compare('vehicle.id', $filters['vehicleId']);
//        $this->dataProvider->criteria->compare('customer.customer_type', $filters['customerType'], false);
//        $this->dataProvider->criteria->compare('customer.id', $filters['customerId']);
    }
}
