<?php

class ReceivableSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 10 : $pageSize;
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
        $customerType = (empty($filters['customerType'])) ? '' : $filters['customerType'];
        $customerId = (empty($filters['customerId'])) ? '' : $filters['customerId'];
        
        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.id FROM " . InvoiceHeader::model()->tableName() . " i
            WHERE t.id = i.customer_id AND i.user_id_cancelled IS NULL AND i.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND 
            i.total_price - (
                SELECT COALESCE(SUM(d.amount + d.tax_service_amount + d.discount_amount + d.bank_administration_fee + d.merimen_fee + d.downpayment_amount), 0)
                FROM " . PaymentInDetail::model()->tableName() . " d
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE i.id = d.invoice_header_id AND h.user_id_cancelled IS NULL AND h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
            ) > 0" . $branchConditionSql . "
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $customerId);
        $this->dataProvider->criteria->compare('t.customer_type', $customerType);
    }
}
