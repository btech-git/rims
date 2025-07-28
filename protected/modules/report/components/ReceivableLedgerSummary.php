<?php

class ReceivableLedgerSummary extends CComponent {

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
//        $this->dataProvider->sort->attributes = array('coa.code DESC');
        $this->dataProvider->criteria->order = 't.code ASC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branchId, $coaId) {
        $this->dataProvider->criteria->addCondition("t.code NOT LIKE '%.000'");
        $this->dataProvider->criteria->compare('t.coa_sub_category_id', 8);
        $this->dataProvider->criteria->compare('t.is_approved', 1);
        $this->dataProvider->criteria->compare('t.id', $coaId);
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.id 
            FROM " . InvoiceHeader::model()->tableName() . " i 
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            WHERE c.coa_id = t.id AND invoice_date BETWEEN :start_date AND :end_date" . $branchConditionSql . "
            UNION
            SELECT i.id 
            FROM " . PaymentIn::model()->tableName() . " i 
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            WHERE c.coa_id = t.id AND payment_date BETWEEN :start_date AND :end_date" . $branchConditionSql . "
        )");

        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
