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
            SELECT o.supplier_id, SUM(o.total_price - COALESCE(p.amount, 0)) AS remaining
            FROM " . TransactionPurchaseOrder::model()->tableName() . " o
            INNER JOIN " . TransactionReceiveItem::model()->tableName() . " r ON o.id = r.purchase_order_id
            LEFT OUTER JOIN (
                SELECT d.receive_item_id, SUM(d.amount) AS amount 
                FROM " . PayOutDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.receive_item_id
            ) p ON r.id = p.receive_item_id 
            WHERE o.supplier_id = t.id AND r.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date" . $branchConditionSql . " 
            GROUP BY o.supplier_id 
            HAVING remaining > 100
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $supplierId);
    }
}
