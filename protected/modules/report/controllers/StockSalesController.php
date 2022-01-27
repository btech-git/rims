<?php

class StockSalesController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('allAccountingReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $stockCardSummary = new StockSalesSummary($product->search());
        $stockCardSummary->setupLoading();
        $stockCardSummary->setupPaging($pageSize, $currentPage);
        $stockCardSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $stockCardSummary->setupFilter($filters);
        
        $this->render('summary', array(
            'product' => $product,
            'stockCardSummary' => $stockCardSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductStockTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productDataProvider = $product->searchByStockCheck($pageNumber);
            $branches = Branch::model()->findAll();

            $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
            ));
        }
    }

//    public function actionRedirectTransaction($codeNumber) {
//        list($leftPart,, ) = explode('/', $codeNumber);
//        list(, $codeNumberConstant) = explode('.', $leftPart);
//
//        if ($codeNumberConstant === 'PO') {
//            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
//            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
//        } else if ($codeNumberConstant === 'Pout') {
//            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
//            $this->redirect(array('/transaction/paymentOut/view', 'id' => $model->id));
//        }
//    }
}