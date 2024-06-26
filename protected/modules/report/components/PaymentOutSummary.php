<?php

class PaymentOutSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'purchaseOrder',
            'supplier',
            'companyBank',
            'paymentType',
            'branch',
            'user',
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
        $this->dataProvider->criteria->order = 't.payment_date DESC';
    }

    public function setupFilter($startDate, $endDate, $branch, $paymentType, $supplierId) {
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.branch_id', $branch);
        $this->dataProvider->criteria->compare('t.payment_type_id', $paymentType);
        $this->dataProvider->criteria->compare('t.supplier_id', $supplierId);
    }
}
