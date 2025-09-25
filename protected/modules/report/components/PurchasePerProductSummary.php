<?php

class PurchasePerProductSummary extends CComponent {

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

    public function setupFilter($startDate, $endDate, $branchId, $supplierId) {
        $branchConditionSql = '';
        $supplierConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND h.main_branch_id = :branch_id';
        }

        if (!empty($supplierId)) {
            $supplierConditionSql = ' AND h.supplier_id = :supplier_id';
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT d.id FROM " . TransactionPurchaseOrderDetail::model()->tableName() . " d 
            INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " h ON h.id = d.purchase_order_id
            WHERE d.product_id = t.id AND substr(h.purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND h.status_document NOT LIKE '%CANCEL%'" . 
                $branchConditionSql . $supplierConditionSql . " 
        )");
        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        if (!empty($supplierId)) {
            $this->dataProvider->criteria->params[':supplier_id'] = $supplierId;
        }
    }
}
