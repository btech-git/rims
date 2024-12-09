<?php

class SaleTransactionSummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleServiceSummaryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $branchConditionSql = '';
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND branch_id = :branch_id';
        }

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());
        $registrationTransactionDataProvider = $registrationTransaction->searchReport();
        $registrationTransactionDataProvider->criteria->addCondition("substr(transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND user_id_cancelled is null" . $branchConditionSql);
        $registrationTransactionDataProvider->criteria->params[':start_date'] = $startDate;
        $registrationTransactionDataProvider->criteria->params[':end_date'] = $endDate;
        if (!empty($branchId)) {
            $registrationTransactionDataProvider->criteria->params[':branch_id'] = $branchId;
        }
            
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($saleRetailServiceReport, array('startDate' => $startDate, 'endDate' => $endDate, 'branchId' => $branchId));
//        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
        ));
    }
}