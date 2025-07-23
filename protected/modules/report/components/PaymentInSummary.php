<?php

class PaymentInSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'customer',
        );
    }

    public function setupPaging($pageSize, $currentPage) {
        $pageSize = (empty($pageSize)) ? 100 : $pageSize;
        $pageSize = ($pageSize <= 0) ? 1 : $pageSize;
        $this->dataProvider->pagination->pageSize = $pageSize;

        $currentPage = (empty($currentPage)) ? 0 : $currentPage - 1;
        $this->dataProvider->pagination->currentPage = $currentPage;
    }

    public function setupSorting() {
        $this->dataProvider->sort->attributes = array('t.payment_date', 't.branch_id');
        $this->dataProvider->criteria->order = $this->dataProvider->sort->orderBy;
    }

    public function setupFilter($startDate, $endDate, $branch, $customerType, $plateNumber) {
        
        $this->dataProvider->criteria->addBetweenCondition('t.payment_date', $startDate, $endDate);
        $this->dataProvider->criteria->compare('t.branch_id', $branch);
        $this->dataProvider->criteria->addCondition("t.user_id_cancelled is null");
        
        if (!empty($customerType)) {
            $this->dataProvider->criteria->compare('customer.customer_type', $customerType);
        }

        if (!empty($plateNumber)) {
            $this->dataProvider->criteria->addCondition("EXISTS (
                SELECT p.payment_in_id
                FROM " . PaymentInDetail::model()->tableName() . " p 
                INNER JOIN " . InvoiceHeader::model()->tableName() . " i ON i.id = p.invoice_header_id
                INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
                WHERE v.plate_number LIKE :plate_number
            ) AND t.status = 'Approved'");
            
            $this->dataProvider->criteria->params[':plate_number'] = "%{$plateNumber}%";
        }
    }
}
