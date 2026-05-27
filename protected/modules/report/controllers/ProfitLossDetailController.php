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

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');
        
        $coaCode = (isset($_GET['CoaCode'])) ? $_GET['CoaCode'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $profitLossSummary = new ProfitLossSummary($jurnalUmum->search());
        $profitLossSummary->setupLoading();
        $profitLossSummary->setupPaging(1000, 1);
        $profitLossSummary->setupSorting();
        $profitLossSummary->setupFilter($startDate, $endDate, $coaCode, $branchId);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($profitLossSummary, $coaCode, $startDate, $endDate, $branchId);
        }

        $this->render('jurnalTransaction', array(
            'profitLossSummary' => $profitLossSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaCode' => $coaCode,
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
        $documentProperties->setTitle('Laba Rugi Standar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laba Rugi Standar');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laba / Rugi (Standar)');
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
                
                $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $worksheet->getStyle("A{$counter}:B{$counter}")->getFont()->setBold(true);
                $worksheet->setCellValue("A{$counter}", 'Total ' . $profitLossReportData[$coaParentCodes[$previousLevel]]['name']);
                $worksheet->setCellValue("B{$counter}", $amountSum === '' ? '' : $amountSum);

                $counter++;
                $previousLevel--;
            }
            
            if ((int) $coaCode === 600) {
                $grossProfit = $accountGroupSums[4] - $accountGroupSums[5]; 
                $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $worksheet->getStyle("A{$counter}:B{$counter}")->getFont()->setBold(true);
                $worksheet->setCellValue("A{$counter}", 'Laba Kotor');
                $worksheet->setCellValue("B{$counter}", $grossProfit === '' ? '' : $grossProfit);
                $counter++;
            }
            $worksheet->setCellValue("A{$counter}", $coaCode . ' - ' . $profitLossReportItem['name']);
            $worksheet->setCellValue("B{$counter}", $balance);
            $counter++;
            $previousLevel = $currentLevel;
        }

        for ($i = $currentLevel - 1; $i > 0; $i--) {
            while ($previousLevel > $i) {
                $amountSum = array_sum($balances[$previousLevel]['amounts']);
                $balances[$previousLevel]['amounts'] = array();
                $balances[$previousLevel - 1]['amounts'][] = $amountSum;

                $worksheet->setCellValue("A{$counter}", 'Total ' . $profitLossReportData[$coaParentCodes[$previousLevel]]['name']);
                $worksheet->setCellValue("B{$counter}", $amountSum === '' ? '' : $amountSum);
                $counter++;
                $previousLevel--;
            }
        }
        $netProfit = $accountGroupSums[4] - $accountGroupSums[5] - $accountGroupSums[6] + $accountGroupSums[7] - $accountGroupSums[8];
        $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:B{$counter}")->getFont()->setBold(true);
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
        header('Content-Disposition: attachment;filename="profit_loss_standar.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($profitLossSummary, $coaCode, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Transaction Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaction Detail');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $coa = Coa::model()->findByAttributes(array('code' => $coaCode));
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Transaction Detail ' . $coa->code . ' - ' . $coa->name);
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Transaction #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Deskripsi');
        $worksheet->setCellValue('E5', 'Memo');
        $worksheet->setCellValue('F5', 'Debit');
        $worksheet->setCellValue('G5', 'Credit');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;

        $totalDebet = '0.00';
        $totalCredit = '0.00';
        foreach ($profitLossSummary->dataProvider->data as $i => $header) { 
            $debitAmount = $header->debet_kredit == 'D' ? $header->total : '0.00';
            $creditAmount = $header->debet_kredit == 'K' ? $header->total : '0.00';
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'kode_transaksi'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'tanggal_transaksi'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'transaction_subject'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'transaction_type'));
            $worksheet->setCellValue("F{$counter}", $debitAmount);
            $worksheet->setCellValue("G{$counter}", $creditAmount);

            $totalDebet += $debitAmount;
            $totalCredit += $creditAmount;
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("E{$counter}", 'TOTAL ');
        $worksheet->setCellValue("F{$counter}", $totalDebet);
        $worksheet->setCellValue("G{$counter}", $totalCredit);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_detail_laba_rugi.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
