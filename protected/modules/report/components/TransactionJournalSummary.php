<?php

class TransactionJournalSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->defaultOrder = 't.tanggal_transaksi ASC, t.kode_transaksi ASC';
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branchId) {
        $this->dataProvider->criteria->addBetweenCondition('t.tanggal_transaksi', $startDate, $endDate);
        $this->dataProvider->criteria->addCondition("t.is_coa_category = 0");
//        $this->dataProvider->criteria->compare('t.coa_id', $coaId);
        $this->dataProvider->criteria->compare('t.branch_id', $branchId);
    }
}
