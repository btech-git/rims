<?php

class PayableSupplierSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 500 : $pageSize;
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
        
        $branchPurchaseConditionSql = '';
        $branchWorkOrderConditionSql = '';
        
        if (!empty($branchId)) {
            $branchPurchaseConditionSql = ' AND p.main_branch_id = :branch_id';
            $branchWorkOrderConditionSql = ' AND branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT p.supplier_id
            FROM " . TransactionPurchaseOrder::model()->tableName() . " p 
            WHERE p.supplier_id = t.id AND substr(p.purchase_order_date, 1, 10) BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE ."' AND :end_date AND
                status_document = 'Approved'" . $branchPurchaseConditionSql . " 
        ) OR EXISTS (
            SELECT supplier_id
            FROM " . WorkOrderExpenseHeader::model()->tableName() . "
            WHERE supplier_id = t.id AND substring(transaction_date, 1, 10) BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE ."' AND :end_date AND
                status = 'Approved'" . $branchWorkOrderConditionSql . " 
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
