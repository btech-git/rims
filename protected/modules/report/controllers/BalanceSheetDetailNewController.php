<?php

class BalanceSheetDetailNewController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $dateNow = date('Y-m-d');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : $dateNow;
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : $dateNow;

        $balanceSheetCoaReport = Coa::getBalanceSheetCoaReport();
        $balanceSheetLedgerReport = JurnalUmum::getBalanceSheetLedgerReport($startDate, $endDate, $branchId);
        $profitLossLedgerReport = JurnalUmum::getProfitLossLedgerReport($startDate, $endDate, $branchId);
        
        $balanceSheetReportData = array();
        foreach ($balanceSheetCoaReport as $balanceSheetCoaReportItem) {
            $balanceSheetReportData[$balanceSheetCoaReportItem['code']]['id'] = $balanceSheetCoaReportItem['id'];
            $balanceSheetReportData[$balanceSheetCoaReportItem['code']]['name'] = $balanceSheetCoaReportItem['name'];
            $balanceSheetReportData[$balanceSheetCoaReportItem['code']]['parent_code'] = $balanceSheetCoaReportItem['parent_code'];
            $balanceSheetReportData[$balanceSheetCoaReportItem['code']]['level'] = 1;
        }
        foreach ($balanceSheetCoaReport as $balanceSheetCoaReportItem) {
            $coaCode = $balanceSheetCoaReportItem['code'];
            $currentCoaCode = $coaCode;
            while (isset($balanceSheetReportData[$currentCoaCode]) && $balanceSheetReportData[$currentCoaCode]['parent_code'] !== null) {
                $balanceSheetReportData[$coaCode]['level']++;
                $currentCoaCode = $balanceSheetReportData[$currentCoaCode]['parent_code'];
            }
        }
        foreach ($balanceSheetLedgerReport as $balanceSheetLedgerReportItem) {
            $balanceSheetReportData[$balanceSheetLedgerReportItem['coa_code']]['balance'] = $balanceSheetLedgerReportItem['balance'];
        }
        
        $netProfit = '0.00';
        foreach ($profitLossLedgerReport as $profitLossLedgerReportItem) {
            $coaStartDigitCode = intval($profitLossLedgerReportItem['coa_code'][0]);
            $balance = isset($profitLossLedgerReportItem['balance']) ? $profitLossLedgerReportItem['balance'] : '0.00';
            $netProfit += $coaStartDigitCode === 4 || $coaStartDigitCode === 7 ? +$balance : -$balance;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'balanceSheetReportData' => $balanceSheetReportData,
            'netProfit' => $netProfit,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }
}