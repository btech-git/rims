<?php

class MonthlyCustomerReceivableSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 25000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->criteria->order = 't.name ASC';
    }

    public function setupFilter($year, $month, $customerId) {
        $this->dataProvider->criteria->compare('t.id', $customerId);
        $this->dataProvider->criteria->compare('t.status', 'Active');
        $this->dataProvider->criteria->compare('t.customer_type', 'Company');
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT customer_id
            FROM " . RegistrationTransaction::model()->tableName() . "
            WHERE YEAR(transaction_date) = :year AND MONTH(transaction_date) = :month AND customer_id = t.id AND user_id_cancelled IS NULL
        )");

        $this->dataProvider->criteria->params[':year'] = $year;
        $this->dataProvider->criteria->params[':month'] = $month;
    }

}
