<?php

class PayableSupplierSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 1000 : $pageSize;
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
        $supplierId = (empty($filters['supplierId'])) ? '' : $filters['supplierId'];
        
        $this->dataProvider->criteria->compare('t.status', 'Active');
        $this->dataProvider->criteria->compare('t.is_approved', 1);
        $this->dataProvider->criteria->compare('t.id', $supplierId);
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND p.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.id 
            FROM " . TransactionReceiveItem::model()->tableName() . " i
            INNER JOIN " . TransactionPurchaseOrder::model()->tableName() . " p ON p.id = i.purchase_order_id
            WHERE t.id = i.supplier_id AND i.user_id_cancelled IS NULL AND i.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND 
                i.invoice_grand_total - (
                    SELECT COALESCE(SUM(d.amount), 0)
                    FROM " . PayOutDetail::model()->tableName() . " d
                    INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                    WHERE i.id = d.receive_item_id AND h.user_id_cancelled IS NULL AND h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                ) > 100" . $branchConditionSql . "
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
