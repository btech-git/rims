<?php

class SaleInvoiceMarketingDailySummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->with = array(
            'registrationTransaction' => array(
                'with' => array(
                    'employeeIdSalesPerson',
                )
            ),
            'customer',
            'vehicle',
            'branch',
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
        $this->dataProvider->sort->attributes = array('employeeIdSalesPerson.name');
        $this->dataProvider->criteria->order = 'employeeIdSalesPerson.name'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter($filters) {
        $invoiceDate = (empty($filters['invoiceDate'])) ? date('Y-m-d') : $filters['invoiceDate'];
        $this->dataProvider->criteria->addCondition('t.status NOT LIKE "%CANCELLED%" AND registrationTransaction.employee_id_sales_person IS NOT NULL');
        $this->dataProvider->criteria->compare('t.invoice_date', $invoiceDate);
//        $this->dataProvider->criteria->compare('t.customer_id', FALSE);
//        $this->dataProvider->criteria->compare('vehicle.id', $filters['vehicleId']);
//        $this->dataProvider->criteria->compare('customer.customer_type', $filters['customerType'], false);
//        $this->dataProvider->criteria->compare('customer.id', $filters['customerId']);
    }
}
