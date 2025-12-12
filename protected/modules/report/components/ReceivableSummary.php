<?php

class ReceivableSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 50 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.code');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $endDate = (empty($filters['endDate'])) ? date('Y-m-d') : $filters['endDate'];
        $branchId = (empty($filters['branchId'])) ? '' : $filters['branchId'];
        $plateNumber = (empty($filters['plateNumber'])) ? '' : $filters['plateNumber'];
        $customerId = (empty($filters['customerId'])) ? '' : $filters['customerId'];
        
        $branchConditionSql = '';
        $plateConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        if (!empty($plateNumber)) {
            $plateConditionSql = ' AND v.plate_number LIKE :plate_number';
            $this->dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
        
        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.customer_id, i.total_price - COALESCE(p.amount, 0) - COALESCE(p.tax_service_amount, 0) - COALESCE(p.discount_amount, 0) - 
                COALESCE(p.bank_administration_fee, 0) - COALESCE(p.merimen_fee, 0) - COALESCE(p.downpayment_amount, 0) AS remaining
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            LEFT OUTER JOIN (
                SELECT d.invoice_header_id, SUM(d.amount) AS amount, SUM(d.tax_service_amount) AS tax_service_amount, SUM(d.discount_amount) AS discount_amount,
                    SUM(d.bank_administration_fee) AS bank_administration_fee, SUM(d.merimen_fee) AS merimen_fee, SUM(d.downpayment_amount) AS downpayment_amount
                FROM " . PaymentInDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.invoice_header_id
            ) p ON i.id = p.invoice_header_id 
            WHERE i.customer_id = t.id AND i.insurance_company_id IS NULL AND i.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date AND
                i.total_price - COALESCE(p.amount, 0) - COALESCE(p.tax_service_amount, 0) - COALESCE(p.discount_amount, 0) - 
                COALESCE(p.bank_administration_fee, 0) - COALESCE(p.merimen_fee, 0) - COALESCE(p.downpayment_amount, 0) > 100 " . $branchConditionSql . $plateConditionSql . " 
        )");
        
//        $this->dataProvider->criteria->addCondition("EXISTS (
//            SELECT i.coa_id, SUM(CASE WHEN debet_kredit = 'D' THEN total ELSE 0 END) AS debit, SUM(CASE WHEN debet_kredit = 'K' THEN total ELSE 0 END) AS credit
//            FROM " . JurnalUmum::model()->tableName() . " i
//            INNER JOIN " . Coa::model()->tableName() . " c ON c.id = i.coa_id
//            WHERE i.coa_id = t.id AND i.tanggal_transaksi BETWEEN '2025-01-01' AND :end_date AND t.coa_category_id = 15 AND t.coa_sub_category_id = 8" . 
//                $branchConditionSql . $coaConditionSql . " 
//            GROUP BY i.coa_id
//            HAVING debit - credit > 100
//        ) AND t.name NOT LIKE '%Asuransi%' AND t.name NOT LIKE '%Insurance%'");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $customerId);
    }
}
