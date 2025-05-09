<?php

class PayableSummary extends CComponent {

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

    public function setupFilter($filters) {
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $supplierId = (empty($filters['supplierId'])) ? '' : $filters['supplierId'];
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.main_branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT p.supplier_id, COALESCE(p.payment_left, 0) AS payment_left 
            FROM " . TransactionPurchaseOrder::model()->tableName() . " p 
            WHERE p.supplier_id = t.id AND payment_left > 100.00 AND purchase_order_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND p.status_document = 'Approved'" . $branchConditionSql . " 
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $supplierId);
    }
}
