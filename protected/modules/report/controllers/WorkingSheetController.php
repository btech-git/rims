<?php

class WorkingSheetController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('yearlyMaterialServiceUsageReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
//        $yearNow = date('Y');
//        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $cashflowPosition = (isset($_GET['CashflowPosition'])) ? $_GET['CashflowPosition'] : '';
        $coaCategoryId = (isset($_GET['CoaCategoryId'])) ? $_GET['CoaCategoryId'] : '';
        $coaSubCategoryId = (isset($_GET['CoaSubCategoryId'])) ? $_GET['CoaSubCategoryId'] : '';
        
//        $startDate = $year . '-01-01';
//        $endDate = $year . '-12-31';
        
        $cashflowPositionConditionSql = '';
        $coaCategoryConditionSql = '';
        $coaSubCategoryConditionSql = '';
        
        $params = array();
        if (!empty($cashflowPosition)) {
            $cashflowPositionConditionSql = ' AND coaSubCategory.cashflow_position = :cashflow_position';
            $params[':cashflow_position'] = $cashflowPosition;
        }
        if (!empty($coaCategoryId)) {
            $coaCategoryConditionSql = ' AND t.coa_category_id = :coa_category_id';
            $params[':coa_category_id'] = $coaCategoryId;
        }
        if (!empty($coaSubCategoryId)) {
            $coaSubCategoryConditionSql = ' AND t.coa_sub_category_id = :coa_sub_category_id';
            $params[':coa_sub_category_id'] = $coaSubCategoryId;
        }
        
        $coas = Coa::model()->findAll(array(
            'with' => 'coaSubCategory', 
            'condition' => "coaSubCategory.cashflow_position IS NOT NULL" . $cashflowPositionConditionSql . $coaCategoryConditionSql . $coaSubCategoryConditionSql, 
            'params' => $params,
            'order' => 'coaSubCategory.cashflow_position ASC, t.code ASC',
        )); 
        
        $coaIds = array_map(function($coa) { return $coa->id; }, $coas);
        $workingSheetBeginningBalances = JurnalUmum::getWorkingSheetBeginningBalances($coaIds, $startDate);
        $workingSheetBalances = JurnalUmum::getWorkingSheetBalances($coaIds, $startDate, $endDate);
        
        $workingSheetReportData = array();
        
        foreach ($workingSheetBeginningBalances as $workingSheetBeginningBalanceItem) {
            $workingSheetReportData[$workingSheetBeginningBalanceItem['coa_id']]['beginning_balance'] = $workingSheetBeginningBalanceItem['beginning_balance'];
        }
        
        foreach ($workingSheetBalances as $workingSheetBalanceItem) {
            $workingSheetReportData[$workingSheetBalanceItem['coa_id']]['debit_total'] = $workingSheetBalanceItem['debit_total'];
            $workingSheetReportData[$workingSheetBalanceItem['coa_id']]['credit_total'] = $workingSheetBalanceItem['credit_total'];
        }

//        $yearList = array();
//        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
//            $yearList[$y] = $y;
//        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($workingSheetReportData, $startDate, $endDate, $coas);
        }
        
        $this->render('summary', array(
            'workingSheetReportData' => $workingSheetReportData,
//            'yearList' => $yearList,
//            'year' => $year,
//            'yearNow' => $yearNow,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coas' => $coas,
            'coaCategoryId' => $coaCategoryId,
            'coaSubCategoryId' => $coaSubCategoryId,
            'cashflowPosition' => $cashflowPosition,
        ));
    }
    
    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');
        
        $coaCode = (isset($_GET['CoaCode'])) ? $_GET['CoaCode'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $workingSheetSummary = new WorkingSheetSummary($jurnalUmum->search());
        $workingSheetSummary->setupLoading();
        $workingSheetSummary->setupPaging(5000, 1);
        $workingSheetSummary->setupSorting();
        $workingSheetSummary->setupFilter($startDate, $endDate, $coaCode);

//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelTransactionJournal($profitLossSummary, $coaCode, $startDate, $endDate);
//        }

        $this->render('jurnalTransaction', array(
            'workingSheetSummary' => $workingSheetSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaCode' => $coaCode,
        ));
    }

    protected function saveToExcel($workingSheetReportData, $startDate, $endDate, $coas) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $dateNumList = range(1, 31);
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Kertas Kerja');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Kertas Kerja');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        
        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Kertas Kerja');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->setCellValue('A5', 'Kode');
        $worksheet->setCellValue('B5', 'Nama Akun');
        $worksheet->setCellValue('C5', 'Category');
        $worksheet->setCellValue('D5', 'Sub Category');
        $worksheet->setCellValue('E5', 'Normal Balance');
        $worksheet->setCellValue('F5', 'Pos Arus Kas');
        $worksheet->setCellValue('G5', 'Saldo Awal');
        $worksheet->setCellValue('H5', 'Debit');
        $worksheet->setCellValue('I5', 'Kredit');
        $worksheet->setCellValue('J5', 'Saldo Akhir');
        $worksheet->setCellValue('K5', 'Pengaruh Kas');
        $worksheet->setCellValue('L5', 'Kontribusi Laba');
        
        $worksheet->getStyle("A5:L5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:L5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        foreach ($coas as $coa) {
            $beginningBalance = '0.00';
            if ($coa->coaSubCategory->cashflow_position !== 'Laba Bersih') {
                $beginningBalance = isset($workingSheetReportData[$coa->id]['beginning_balance']) ? $workingSheetReportData[$coa->id]['beginning_balance'] : '0.00';
            }
            $debitTotal = isset($workingSheetReportData[$coa->id]['debit_total']) ? $workingSheetReportData[$coa->id]['debit_total'] : '0.00';
            $positiveDebitTotal = abs($debitTotal);
            $creditTotal = isset($workingSheetReportData[$coa->id]['credit_total']) ? $workingSheetReportData[$coa->id]['credit_total'] : '0.00'; 
            $positiveCreditTotal = abs($creditTotal);
            $endingBalance = $beginningBalance + $debitTotal + $creditTotal;
            $balanceDifference = '0.00';
            if ($coa->coaSubCategory->cashflow_position !== 'Laba Bersih') {
                $balanceDifference = $endingBalance - $beginningBalance;
            }
            $profitLossBalance = '0.00';
            if ($coa->coaSubCategory->cashflow_position === 'Laba Bersih') {
                $profitLossBalance = $positiveCreditTotal - $positiveDebitTotal;
            }
            if ($beginningBalance != '0.00' || $debitTotal != '0.00' || $creditTotal != '0.00') {
                $worksheet->setCellValue("A{$counter}", CHtml::value($coa, 'code'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($coa, 'name'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($coa, 'coaCategory.name'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($coa, 'coaSubCategory.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($coa, 'normal_balance'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($coa, 'coaSubCategory.cashflow_position'));
                $worksheet->setCellValue("G{$counter}", $beginningBalance);
                if ($beginningBalance < 0) {
                    $worksheet->getStyle("G{$counter}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
                $worksheet->setCellValue("H{$counter}", $positiveDebitTotal);
                $worksheet->setCellValue("I{$counter}", $positiveCreditTotal);
                $worksheet->setCellValue("J{$counter}", $endingBalance);
                if ($endingBalance < 0) {
                    $worksheet->getStyle("J{$counter}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
                $worksheet->setCellValue("K{$counter}", $balanceDifference);
                if ($balanceDifference < 0) {
                    $worksheet->getStyle("K{$counter}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
                $worksheet->setCellValue("L{$counter}", $profitLossBalance);
                if ($profitLossBalance < 0) {
                    $worksheet->getStyle("L{$counter}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="kertas_kerja.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}