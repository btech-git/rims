<?php

class ProfitLossSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->defaultOrder = 't.kode_transaksi ASC, t.tanggal_transaksi ASC';
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($yearMonth, $accountId, $branchId) {
        $this->dataProvider->criteria->addCondition("SUBSTRING_INDEX(t.tanggal_transaksi, '-', 2) = :year_month AND t.is_coa_category = 0");
        $this->dataProvider->criteria->params[':year_month'] = $yearMonth;
        $this->dataProvider->criteria->compare('t.coa_id', $accountId);
        $this->dataProvider->criteria->compare('t.branch_id', $branchId);
    }
}
