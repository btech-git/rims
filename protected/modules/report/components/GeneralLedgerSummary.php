<?php

class GeneralLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = true;
        $this->dataProvider->criteria->with = array(
            'jurnalUmums',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 100000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->defaultOrder = 't.code ASC, jurnalUmums.tanggal_transaksi ASC';
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $accountId, $branchId) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $this->dataProvider->criteria->addBetweenCondition('jurnalUmums.tanggal_transaksi', $startDate, $endDate);

        if (!empty($accountId)) {
        	$this->dataProvider->criteria->compare('t.id', $accountId);
	}
        
        if (!empty($branchId)) {
            $this->dataProvider->criteria->compare('jurnalUmums.branch_id', $branchId);
        }
    }

    public function getSaldo($startDate) {
        foreach ($this->dataProvider->data as $data) {
//            if ($data->coa_category_id > 5 && $data->coa_category_id < 11) {
                $saldo = 0;
//            } else {
//                $saldo = $data->getBeginningBalanceLedger($startDate);
//            }

            foreach ($data->jurnalUmums as $detail) {
                $debitAmount = ($detail->debet_kredit === 'D') ? $detail->total : 0 ;
                $creditAmount = ($detail->debet_kredit === 'K') ? $detail->total : 0 ;
                $saldo += $debitAmount - $creditAmount;
                $detail->currentSaldo = $saldo;
            }
        }
    }
}
