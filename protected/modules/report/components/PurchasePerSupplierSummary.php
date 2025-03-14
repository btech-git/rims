<?php

class PurchasePerSupplierSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 100 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND main_branch_id = :branch_id';
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT id FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = t.id AND substr(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND status_document NOT LIKE '%CANCEL%'" . $branchConditionSql . " 
        )");
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
    }
}
