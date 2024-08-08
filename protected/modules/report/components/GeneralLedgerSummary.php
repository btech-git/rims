<?php

class GeneralLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//        $this->dataProvider->criteria->together = true;
//        $this->dataProvider->criteria->with = array(
//            'jurnalUmums',
//        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->defaultOrder = 't.code ASC';
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($coaIds, $startDate, $endDate, $branchId) {
//        if (!empty($coaId)) {
            $this->dataProvider->criteria->addInCondition('t.id', $coaIds);
//        }
        $branchConditionSql = '';
        if (!empty($branchId)) {
            $branchConditionSql = ' AND j.branch_id = :branch_id';
        }
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT j.id
            FROM " . JurnalUmum::model()->tableName() . " j
            WHERE j.coa_id = t.id AND j.tanggal_transaksi BETWEEN :start_date AND :end_date" . $branchConditionSql . "
        ) OR (
            SELECT IF(a.normal_balance = 'Debit', COALESCE(SUM(j.amount), 0), COALESCE(SUM(j.amount), 0) * -1)
            FROM (
                SELECT coa_id, tanggal_transaksi, total AS amount, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'D' AND is_coa_category = 0 AND tanggal_transaksi > '2022-12-31'
                UNION ALL
                SELECT coa_id, tanggal_transaksi, total * -1 AS amount, branch_id
                FROM " . JurnalUmum::model()->tableName() . "
                WHERE debet_kredit = 'K' AND is_coa_category = 0 AND tanggal_transaksi > '2022-12-31'
            ) j
            INNER JOIN " . Coa::model()->tableName() . " a ON a.id = j.coa_id
            WHERE j.coa_id = t.id AND j.tanggal_transaksi < :start_date " . $branchConditionSql . " 
            GROUP BY j.coa_id
        ) > 0");
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
    }
}
