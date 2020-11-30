<?php

class ConsignmentOutSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'customer',
            'branch',
            'user',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.date_posting', 't.branch_id');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branch) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.date_posting', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.branch_id', $branch);
    }

    public function reportTotalPrice() {
        $grandTotal = 0.00;

        foreach ($this->dataProvider->data as $data) {
            $grandTotal += $data->total_price;
        }

        return $grandTotal;
    }

    public function reportTotalQuantity() {
        $grandTotal = 0.00;

        foreach ($this->dataProvider->data as $data) {
            $grandTotal += $data->total_quantity;
        }

        return $grandTotal;
    }
}
