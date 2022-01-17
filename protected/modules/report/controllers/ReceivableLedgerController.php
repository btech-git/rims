<?php

class ReceivableLedgerController extends Controller {

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

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $receivableLedgerSummary = new ReceivableLedgerSummary($customer->search());
        $receivableLedgerSummary->setupLoading();
        $receivableLedgerSummary->setupPaging($pageSize, $currentPage);
        $receivableLedgerSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $receivableLedgerSummary->setupFilter($filters);
        
        $this->render('summary', array(
            'customer' => $customer,
            'receivableLedgerSummary' => $receivableLedgerSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/view', 'id' => $model->id));
        }
    }
}