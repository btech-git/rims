<?php

class ProfitLossController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('accounting')))
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

        $accountCategoryTypes = CoaCategory::model()->with(array(
            'coaSubCategories' => array(
                'with' => array(
                    'coas' 
                ),
            ),
        ))->findAll("t.id IN (6, 7)");

        if (isset($_GET['SaveExcel']))
            $this->saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId);


        $this->render('summary', array(
            'accountCategoryTypes' => $accountCategoryTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

}
