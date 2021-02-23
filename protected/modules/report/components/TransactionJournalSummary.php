<?php

class TransactionJournalSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'coa',
            'branch' => array(
                'with' => array(
                    'company',
                ),
            ),
        );
        $this->dataProvider->criteria->together = true;
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.tanggal_transaksi DESC', 't.kode_transaksi ASC');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $companyId, $branchId, $transactionType, $coaId) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.tanggal_transaksi', $startDate, $endDate);
//        $this->dataProvider->criteria->compare('t.branch_id', $branchId);
//        $this->dataProvider->criteria->compare('t.coa_id', $coaId);
//        $this->dataProvider->criteria->compare('branch.company_id', $companyId);        
//        $this->dataProvider->criteria->compare('t.transaction_type', $transactionType);
    }
}
