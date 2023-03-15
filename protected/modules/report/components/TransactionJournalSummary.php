<?php

class TransactionJournalSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'coa',
            'branch' => array(
                'with' => array(
                    'company',
                ),
            ),
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 5000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
//        $this->dataProvider->sort->attributes = array('t.tanggal_transaksi DESC', 't.kode_transaksi ASC', 't.coa_id ASC');
//        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
        $this->dataProvider->criteria->order = 't.tanggal_transaksi DESC, t.kode_transaksi ASC, t.coa_id ASC';
    }

    public function setupFilter($startDate, $endDate, $branchId, $companyId) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('t.tanggal_transaksi', $startDate, $endDate);
        $this->dataProvider->criteria->addCondition("is_coa_category = 0");
        
        if (!empty($branchId) && empty($companyId) || !empty($branchId) && !empty($companyId)) {
            $this->dataProvider->criteria->addColumnCondition(array('t.branch_id' => $branchId));
        } else if (empty($branchId) && !empty($companyId)) {
            $this->dataProvider->criteria->addCondition("t.branch_id IN (SELECT id FROM " . Branch::model()->tableName() . " WHERE company_id = :company_id)");
            $this->dataProvider->criteria->params[':company_id'] = $companyId;
        }
    }
}
