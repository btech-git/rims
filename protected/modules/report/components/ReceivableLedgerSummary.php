<?php

class ReceivableLedgerSummary extends CComponent {

    public $dataProvider;

    public function __construct($dataProvider) {
        $this->dataProvider = $dataProvider;
    }

    public function setupLoading() {
        $this->dataProvider->criteria->together = TRUE;
        $this->dataProvider->criteria->with = array(
            'coa',
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
        $this->dataProvider->criteria->order = 'coa.code ASC'; //$this->dataProvider->sort->orderBy;
    }

    public function setupFilter() {
        $this->dataProvider->criteria->addCondition("coa.code NOT LIKE '%.000'");
        $this->dataProvider->criteria->compare('coa.coa_sub_category_id', 8);
        $this->dataProvider->criteria->compare('coa.is_approved', 1);
    }
}
