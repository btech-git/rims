<?php

class StockCardCategorySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//        $this->dataProvider->criteria->together = TRUE;
//        $this->dataProvider->criteria->with = array(
//            'inventoryDetails',
//        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 5000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $branchConditionSql = '';
        
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND w.branch_id = :branch_id';
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.id
            FROM " . InventoryDetail::model()->tableName() . " i
            INNER JOIN " . Warehouse::model()->tableName() . " w ON w.id = i.warehouse_id
            INNER JOIN " . Product::model()->tableName() . " p ON p.id = i.product_id
            WHERE p.product_sub_category_id = t.id AND i.transaction_date <= :end_date " . $branchConditionSql . "
        )");
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
    }
}
