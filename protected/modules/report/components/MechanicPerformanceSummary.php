<?php

class MechanicPerformanceSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'customer',
                    'vehicle',
                    'branch',
                ),
            ),
            'service',
            'startMechanic',
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
//        $this->dataProvider->sort->attributes = array('registrationTransaction.transaction_date');
        $this->dataProvider->criteria->order = 'registrationTransaction.transaction_date';
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $this->dataProvider->criteria->addBetweenCondition('registrationTransaction.transaction_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('registrationTransaction.branch_id', $filters['branchId']);
        $this->dataProvider->criteria->compare('startMechanic.name', $filters['mechanicName'], true);
        $this->dataProvider->criteria->compare('service.name', $filters['serviceName'], true);
        $this->dataProvider->criteria->compare('t.status', 'Finished');
    }
}
