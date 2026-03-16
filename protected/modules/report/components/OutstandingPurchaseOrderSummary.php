<?php

class OutstandingPurchaseOrderSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'supplier',
            'branch',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.purchase_order_date', 't.purchase_order_no');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $startDate = (empty($filters['startDate'])) ? date('Y-m-d') : $filters['startDate'];
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $supplierId = (empty($filters['supplierId'])) ? '' : $filters['supplierId'];
        
        $branchConditionSql = '';
        $supplierConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.main_branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }

        if (!empty($supplierId)) {
            $supplierConditionSql = ' AND t.supplier_id = :supplier_id';
            $this->dataProvider->criteria->params[':supplier_id'] = $supplierId;
        }

        $this->dataProvider->criteria->with = array(
            'supplier',
            'mainBranch',
        );
        
        $this->dataProvider->criteria->addCondition("substr(t.purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND 
            t.payment_left > 0 AND t.user_id_cancelled IS NULL" . $branchConditionSql . $supplierConditionSql);
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
