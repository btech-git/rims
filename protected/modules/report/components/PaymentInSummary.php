<?php

class PaymentInSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'customer',
            'vehicle',
            'paymentType',
            'invoice',
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
        $this->dataProvider->sort->attributes = array('t.payment_date', 't.branch_id');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branch, $customerType, $customerId) {
//        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
//        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.branch_id', $branch);
        $this->dataProvider->criteria->compare('t.customer_id', $customerId);
        if (!empty($customerType)) {
            $this->dataProvider->criteria->compare('customer.customer_type', $customerType);
        }
    }
}
