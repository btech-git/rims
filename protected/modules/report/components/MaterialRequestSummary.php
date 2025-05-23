<?php

class MaterialRequestSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
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
        $this->dataProvider->sort->attributes = array('t.transaction_date', 't.branch_id');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branch) {

        $this->dataProvider->criteria->addBetweenCondition('t.transaction_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.branch_id', $branch);
    }
    
    public function reportTotalPrice() {
        $grandTotal = 0.00;

        foreach ($this->dataProvider->data as $data) {
            $grandTotal += $data->total_price;
        }

        return $grandTotal;
    }
}
