<?php

class PayableLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'coaCategory',
            'coaSubCategory',
        );
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

    public function setupFilter($startDate, $endDate, $branchId, $coaId) {
        $this->dataProvider->criteria->addCondition("t.code NOT LIKE '%.000'");
        $this->dataProvider->criteria->compare('t.coa_sub_category_id', 15);
        $this->dataProvider->criteria->compare('t.is_approved', 1);
        $this->dataProvider->criteria->compare('t.id', $coaId);
        
        $branchPurchaseConditionSql = '';
        $branchPaymentConditionSql = '';
        
        if (!empty($branchId)) {
            $branchPurchaseConditionSql = ' AND i.main_branch_id = :branch_id';
            $branchPaymentConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.id 
            FROM " . TransactionPurchaseOrder::model()->tableName() . " i 
            INNER JOIN " . Supplier::model()->tableName() . " c ON c.id = i.supplier_id
            WHERE c.coa_id = t.id AND i.purchase_order_date BETWEEN :start_date AND :end_date" . $branchPurchaseConditionSql . "
            UNION
            SELECT i.id 
            FROM " . PaymentOut::model()->tableName() . " i 
            INNER JOIN " . Supplier::model()->tableName() . " c ON c.id = i.supplier_id
            WHERE c.coa_id = t.id AND payment_date BETWEEN :start_date AND :end_date" . $branchPaymentConditionSql . "
        )");

        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }

}
