<?php

class ProfitLossDetailNewController extends Controller {

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

        $profitLossCoaReport = Coa::getProfitLossCoaReport();
        $profitLossLedgerReport = JurnalUmum::getProfitLossLedgerReport($startDate, $endDate, $branchId);
        
        $profitLossReportData = array();
        foreach ($profitLossCoaReport as $profitLossCoaReportItem) {
            $profitLossReportData[$profitLossCoaReportItem['code']]['id'] = $profitLossCoaReportItem['id'];
            $profitLossReportData[$profitLossCoaReportItem['code']]['name'] = $profitLossCoaReportItem['name'];
            $profitLossReportData[$profitLossCoaReportItem['code']]['parent_code'] = $profitLossCoaReportItem['parent_code'];
            $profitLossReportData[$profitLossCoaReportItem['code']]['level'] = 1;
        }
        foreach ($profitLossCoaReport as $profitLossCoaReportItem) {
            $coaCode = $profitLossCoaReportItem['code'];
            $currentCoaCode = $coaCode;
            while (isset($profitLossReportData[$currentCoaCode]) && $profitLossReportData[$currentCoaCode]['parent_code'] !== null) {
                $profitLossReportData[$coaCode]['level']++;
                $currentCoaCode = $profitLossReportData[$currentCoaCode]['parent_code'];
            }
        }
        foreach ($profitLossLedgerReport as $profitLossLedgerReportItem) {
            $profitLossReportData[$profitLossLedgerReportItem['coa_code']]['balance'] = $profitLossLedgerReportItem['balance'];
        }
        
        $accountGroupSums = array();
        foreach ($profitLossReportData as $coaCode => $profitLossReportDataItem) {
            if (!isset($accountGroupSums[$coaCode[0]])) {
                $accountGroupSums[$coaCode[0]] = '0.00';
            }
            $balance = isset($profitLossReportDataItem['balance']) ? $profitLossReportDataItem['balance'] : '0.00';
            $accountGroupSums[$coaCode[0]] += $balance;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'profitLossReportData' => $profitLossReportData,
            'accountGroupSums' => $accountGroupSums,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }
}
