<?php

class ReceivableCustomerSummary extends CComponent {

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
//        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = 't.name ASC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $coaId = (empty($filters['coaId'])) ? '' : $filters['coaId'];
        
        $this->dataProvider->criteria->compare('t.coa_sub_category_id', 8);
        $this->dataProvider->criteria->compare('t.is_approved', 1);
        $this->dataProvider->criteria->compare('t.id', $coaId);
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT coa_id 
            FROM " . JurnalUmum::model()->tableName() . "
            WHERE coa_id = t.id AND tanggal_transaksi BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date" . $branchConditionSql . "
        ) AND t.code NOT LIKE '%.000'");

        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}