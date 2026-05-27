<?php

class BalanceSheetNewController extends Controller {

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
            $this->saveToExcel($balanceSheetReportData, $netProfit, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'balanceSheetReportData' => $balanceSheetReportData,
            'netProfit' => $netProfit,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($balanceSheetReportData, $netProfit, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Neraca Induk');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Neraca Induk');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . ($branch === null) ? '' : $branch->name);
        $worksheet->setCellValue('A2', 'Neraca (Induk)');
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);

        $counter = 5;

        $balances = array();
        $coaParentCodes = array();
        $previousLevel = 0;
        $currentLevel = 0;
        
        foreach ($balanceSheetReportData as $coaCode => $balanceSheetReportItem) {
            $currentLevel = $balanceSheetReportItem['level'];
            $coaParentCodes[$currentLevel] = $balanceSheetReportItem['parent_code'];
            
            if ($coaCode === '303.00.001') {
                $balance = $netProfit;
            } else {
                $balance = isset($balanceSheetReportItem['balance']) ? $balanceSheetReportItem['balance'] : '';
            }
            $balances[$currentLevel]['amounts'][] = empty($balance) ? '0.00' : $balance;
            
            while ($previousLevel > $currentLevel) {
                $amountSum = array_sum($balances[$previousLevel]['amounts']);
                $balances[$previousLevel]['amounts'] = array();
                $balances[$previousLevel - 1]['amounts'][] = $amountSum;
                
                $worksheet->setCellValue("A{$counter}", $balanceSheetReportData[$coaParentCodes[$previousLevel]]['name']);
                $worksheet->setCellValue("B{$counter}", $amountSum === '' ? '' : $amountSum);
                
                $previousLevel--;
                $counter++;
            }
            
            $previousLevel = $currentLevel;
        }
        
        for ($i = $currentLevel - 1; $i > 0; $i--) {
            while ($previousLevel > $i) {
                $amountSum = array_sum($balances[$previousLevel]['amounts']);
                $balances[$previousLevel]['amounts'] = array();
                $balances[$previousLevel - 1]['amounts'][] = $amountSum;
                
                $worksheet->setCellValue("A{$counter}", $balanceSheetReportData[$coaParentCodes[$previousLevel]]['name']);
                $worksheet->setCellValue("B{$counter}", $amountSum === '' ? '' : $amountSum);
                
                $previousLevel--;
                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="neraca_induk.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}