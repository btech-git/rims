<?php

class PayableTransactionSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//        $this->dataProvider->criteria->together = TRUE;
//        $this->dataProvider->criteria->with = array(
//            'transactionPurchaseOrders',
//        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 500 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($supplierId, $startDate, $endDate, $branchId) {
        $branchConditionSql = '';
        
        $this->dataProvider->criteria->params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND main_branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT supplier_id
            FROM " . TransactionPurchaseOrder::model()->tableName() . "
            WHERE supplier_id = t.id AND substring(purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND status_document = 'Approved'" . $branchConditionSql . " 
        )");

        if (!empty($supplierId)) {
            $this->dataProvider->criteria->compare('t.id', $supplierId);
        }
    }
}
