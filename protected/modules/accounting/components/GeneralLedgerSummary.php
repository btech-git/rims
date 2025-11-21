<?php

class GeneralLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'jurnalUmums',
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
        $this->dataProvider->sort->defaultOrder = 't.code ASC, jurnalUmums.tanggal_transaksi ASC';
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($accountIdList, $startDate, $endDate, $branchId) {
        $inIdsSql = 'NULL';
        if (!empty($accountIdList)) {
            $inIdsSql = implode(',', $accountIdList);
        }
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addBetweenCondition('jurnalUmums.tanggal_transaksi', $startDate, $endDate);
        $this->dataProvider->criteria->addCondition("coa_id IN ({$inIdsSql})" . $branchConditionSql);
    }

    public function getSaldo($startDate) {
        foreach ($this->dataProvider->data as $data) {
            $saldo = $data->getBeginningBalanceLedger($data->id, $startDate);

            foreach ($data->jurnalUmums as $detail) {
                $saldo = $saldo + $detail->total - $detail->total;
                $detail->currentSaldo = $saldo;
            }
        }
    }

}
