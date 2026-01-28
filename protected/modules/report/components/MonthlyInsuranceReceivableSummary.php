<?php

class MonthlyInsuranceReceivableSummary extends CComponent {

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

    public function setupFilter($year, $month, $insuranceId) {
        $this->dataProvider->criteria->compare('t.id', $insuranceId);
        $this->dataProvider->criteria->compare('t.is_deleted', 0);
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT insurance_company_id
            FROM " . RegistrationTransaction::model()->tableName() . "
            WHERE insurance_company_id = t.id AND YEAR(transaction_date) = :year AND MONTH(transaction_date) = :month AND user_id_cancelled IS NULL
        )");

        $this->dataProvider->criteria->params[':year'] = $year;
        $this->dataProvider->criteria->params[':month'] = $month;
    }
}