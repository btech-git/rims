<?php

class ProfitLossNewController extends Controller {

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
            $this->saveToExcel($profitLossReportData, $accountGroupSums, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'profitLossReportData' => $profitLossReportData,
            'accountGroupSums' => $accountGroupSums,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($profitLossReportData, $accountGroupSums, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Laba Rugi Induk');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laba Rugi Induk');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laba / Rugi (Induk)');
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);

        $counter = 5;

        $balances = array();
        $coaParentCodes = array();
        $previousLevel = 0;
        $currentLevel = 0;
        foreach ($profitLossReportData as $coaCode => $profitLossReportItem) {
            $currentLevel = $profitLossReportItem['level'];
            $coaParentCodes[$currentLevel] = $profitLossReportItem['parent_code'];
            $balance = isset($profitLossReportItem['balance']) ? $profitLossReportItem['balance'] : ''; 
            $balances[$currentLevel]['amounts'][] = empty($balance) ? '0.00' : $balance;
            
            while ($previousLevel > $currentLevel) {
                $amountSum = array_sum($balances[$previousLevel]['amounts']);
                $balances[$previousLevel]['amounts'] = array();
                $balances[$previousLevel - 1]['amounts'][] = $amountSum;
                
                $worksheet->setCellValue("A{$counter}", $profitLossReportData[$coaParentCodes[$previousLevel]]['name']);
                $worksheet->setCellValue("B{$counter}", $amountSum === '' ? '' : $amountSum);

                $counter++;
                $previousLevel--;
            }
            
            if ((int) $coaCode === 600) {
                $grossProfit = $accountGroupSums[4] - $accountGroupSums[5]; 
                $worksheet->setCellValue("A{$counter}", 'Laba Kotor');
                $worksheet->setCellValue("B{$counter}", $grossProfit === '' ? '' : $grossProfit);
                $counter++;
            }
//            $worksheet->setCellValue("A{$counter}", $coaCode . ' - ' . $profitLossReportItem['name']);
//            $worksheet->setCellValue("B{$counter}", $balance);
//            $counter++;
            $previousLevel = $currentLevel;
        }

        for ($i = $currentLevel - 1; $i > 0; $i--) {
            while ($previousLevel > $i) {
                $amountSum = array_sum($balances[$previousLevel]['amounts']);
                $balances[$previousLevel]['amounts'] = array();
                $balances[$previousLevel - 1]['amounts'][] = $amountSum;

                $worksheet->setCellValue("A{$counter}", $profitLossReportData[$coaParentCodes[$previousLevel]]['name']);
                $worksheet->setCellValue("B{$counter}", $amountSum === '' ? '' : $amountSum);
                $counter++;
                $previousLevel--;
            }
        }
        $netProfit = $accountGroupSums[4] - $accountGroupSums[5] - $accountGroupSums[6] + $accountGroupSums[7] - $accountGroupSums[8];
        $worksheet->setCellValue("A{$counter}", 'Laba Bersih');
        $worksheet->setCellValue("B{$counter}", $netProfit === '' ? '' : $netProfit);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="profit_loss_induk.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
