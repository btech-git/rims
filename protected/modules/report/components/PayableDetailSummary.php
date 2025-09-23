<?php

class PayableDetailSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 25000 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->criteria->order = 't.code ASC';
    }

    public function setupFilter($endDate, $branchId, $supplierId) {
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.main_branch_id = :branch_id';
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT r.supplier_id 
            FROM " . TransactionReceiveItem::model()->tableName() . " r 
            INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " p ON p.id = r.purchase_order_id
            WHERE r.supplier_id = t.id AND r.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . " ' AND :end_date AND
                p.status_document = 'Approved'" . $branchConditionSql . "
        )");

        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        $this->dataProvider->criteria->compare('t.id', $supplierId);
    }
}