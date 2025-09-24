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
            $branchConditionSql = ' AND o.main_branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT o.supplier_id
            FROM " . TransactionPurchaseOrder::model()->tableName() . " o
            INNER JOIN " . TransactionReceiveItem::model()->tableName() . " r ON o.id = r.purchase_order_id
            LEFT OUTER JOIN (
                SELECT d.receive_item_id, SUM(d.amount) AS amount 
                FROM " . PayOutDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND h.status NOT LIKE '%CANCEL%'
                GROUP BY d.receive_item_id
            ) p ON r.id = p.receive_item_id 
            WHERE o.supplier_id = t.id AND (r.invoice_grand_total - COALESCE(p.amount, 0)) > 100.00 AND 
                r.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND o.status_document NOT LIKE '%CANCEL%' AND
                r.user_id_cancelled IS NULL" . $branchConditionSql . " 
        ) OR EXISTS (
            SELECT w.supplier_id
            FROM " . WorkOrderExpenseHeader::model()->tableName() . " w
            INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = w.registration_transaction_id
            LEFT OUTER JOIN (
                SELECT d.work_order_expense_header_id, SUM(d.amount) AS amount 
                FROM " . PayOutDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND h.status NOT LIKE '%CANCEL%'
                GROUP BY d.work_order_expense_header_id
            ) p ON w.id = p.work_order_expense_header_id 
            WHERE w.supplier_id = t.id AND (w.grand_total - COALESCE(p.amount, 0)) > 100.00 AND 
                w.transaction_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND w.status = 'Approved' AND
                w.user_id_cancelled IS NULL" . $branchConditionSql . " 
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $supplierId);
    }
}
