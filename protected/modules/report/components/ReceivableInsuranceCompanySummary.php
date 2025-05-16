<?php

class ReceivableInsuranceCompanySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
//        $this->dataProvider->criteria->together = TRUE;
//        $this->dataProvider->criteria->with = array(
//            'invoiceHeaders',
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
        $plateNumber = (empty($filters['plateNumber'])) ? '' : $filters['plateNumber'];
        
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
            SELECT i.insurance_company_id, SUM(i.total_price - p.amount) AS remaining
            FROM " . InvoiceHeader::model()->tableName() . " i
            LEFT OUTER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            LEFT OUTER JOIN (
                SELECT d.invoice_header_id, SUM(d.amount) AS amount 
                FROM " . PaymentInDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.invoice_header_id
            ) p ON i.id = p.invoice_header_id 
            WHERE i.insurance_company_id = t.id AND i.insurance_company_id IS NOT NULL AND i.invoice_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date" . 
            $branchConditionSql . $plateConditionSql . " 
            GROUP BY i.insurance_company_id 
            HAVING remaining > 100
        )");
        
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
    }
}
