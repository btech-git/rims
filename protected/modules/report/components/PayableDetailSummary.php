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
        $branchPurchaseConditionSql = '';
        $branchWorkOrderConditionSql = '';
        
        if (!empty($branchId)) {
            $branchPurchaseConditionSql = ' AND p.main_branch_id = :branch_id';
            $branchWorkOrderConditionSql = ' AND branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT r.supplier_id 
            FROM " . TransactionReceiveItem::model()->tableName() . " r 
            INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " p ON p.id = r.purchase_order_id
            LEFT OUTER JOIN (
                SELECT receive_item_id, SUM(amount) as payment  
                FROM " . PayOutDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                WHERE h.status NOT LIKE '%CANCEL%'
                GROUP BY receive_item_id 
            ) p ON r.id = p.receive_item_id
            WHERE r.supplier_id = t.id AND r.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . " ' AND :end_date AND r.user_id_cancelled IS NULL AND
                r.invoice_grand_total - COALESCE(p.payment, 0) > 100" . $branchPurchaseConditionSql . "
        ) OR EXISTS (
            SELECT supplier_id
            FROM " . WorkOrderExpenseHeader::model()->tableName() . "
            WHERE supplier_id = t.id AND substring(transaction_date, 1, 10) BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE ."' AND :end_date AND
                status = 'Approved'" . $branchWorkOrderConditionSql . " 
        )");

        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $supplierId);
    }
}