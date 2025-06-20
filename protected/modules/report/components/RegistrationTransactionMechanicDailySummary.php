<?php

class RegistrationTransactionMechanicDailySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'employeeIdAssignMechanic',
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
        $this->dataProvider->sort->attributes = array('employeeIdAssignMechanic.name');
        $this->dataProvider->criteria->order = 'employeeIdAssignMechanic.name'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $transactionDate = (empty($filters['transactionDate'])) ? date('Y-m-d') : $filters['transactionDate'];
        $this->dataProvider->criteria->addCondition('t.status NOT LIKE "%CANCELLED%" AND employee_id_assign_mechanic IS NOT NULL');
        $this->dataProvider->criteria->compare('DATE(t.transaction_date)', $transactionDate);
//        $this->dataProvider->criteria->compare('t.customer_id', FALSE);
//        $this->dataProvider->criteria->compare('vehicle.id', $filters['vehicleId']);
//        $this->dataProvider->criteria->compare('customer.customer_type', $filters['customerType'], false);
//        $this->dataProvider->criteria->compare('customer.id', $filters['customerId']);
    }
}
