<?php

class DeliverySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'sender',
            'senderBranch',
            'salesOrder',
            'sentRequest',
            'consignmentOut',
            'customer',
            'transferRequest',
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
        $this->dataProvider->sort->attributes = array('t.delivery_date', 't.sender_branch_id');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branch) {
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.delivery_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.sender_branch_id', $branch);
    }
}
