<?php

class ReceivableTransactionSummary extends CComponent {

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
        $pageSize = (empty($pageSize)) ? 500 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.name');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branchId, $customerType, $plateNumber, $customerId) {
        $branchConditionSql = '';
        $typeConditionSql = '';
        $plateNumberConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $this->dataProvider->criteria->params[':branch_id'] = $branchId;
        }
        
        if (!empty($customerType)) {
            $typeConditionSql = ' AND c.customer_type = :customer_type';
            $this->dataProvider->criteria->params[':customer_type'] = $customerType;
        }

        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND v.plate_number LIKE :plate_number';
            $this->dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }

        $this->dataProvider->criteria->addCondition("EXISTS (
            SELECT i.customer_id, SUM(i.total_price - COALESCE(p.amount, 0)) AS remaining
            FROM " . InvoiceHeader::model()->tableName() . " i
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            LEFT OUTER JOIN (
                SELECT d.invoice_header_id, SUM(d.amount) AS amount 
                FROM " . PaymentInDetail::model()->tableName() . " d 
                INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                WHERE h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                GROUP BY d.invoice_header_id
            ) p ON i.id = p.invoice_header_id 
            WHERE i.customer_id = t.id AND i.insurance_company_id IS NULL AND i.invoice_date BETWEEN :start_date AND :end_date " . $branchConditionSql . 
            $plateNumberConditionSql . $typeConditionSql . " 
            GROUP BY i.customer_id 
            HAVING remaining > 100
        )");

        $this->dataProvider->criteria->params[':start_date'] = $startDate;
        $this->dataProvider->criteria->params[':end_date'] = $endDate;
        $this->dataProvider->criteria->compare('t.id', $customerId);
    }
}
