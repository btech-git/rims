<?php

class ProfitLossDetailController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('standardProfitLossReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

//        if (isset($_GET['SaveExcel']))
//            $this->saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId);

        $this->render('summary', array(
            'accountCategoryTypes' => $accountCategoryTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    public function actionJurnalTransaction($coaId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());

//        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
//        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
//        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $profitLossSummary = new ProfitLossSummary($coa->search());
        $profitLossSummary->setupLoading();
        $profitLossSummary->setupPaging($pageSize, $currentPage);
        $profitLossSummary->setupSorting();
        $profitLossSummary->setupFilter($startDate, $endDate, $coaId, $branchId);
        $profitLossSummary->getSaldo($startDate);

        $this->render('jurnalTransaction', array(
            'coa' => $coa,
            'profitLossSummary' => $profitLossSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }
}
