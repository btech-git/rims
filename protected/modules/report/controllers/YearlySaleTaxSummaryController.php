<?php

class YearlySaleTaxSummaryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleTaxReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $yearlySaleSummary = InvoiceHeader::getYearlySaleTaxSummary($year);
        
        $yearlySaleSummaryData = array();
        foreach ($yearlySaleSummary as $yearlySaleSummaryItem) {
            $monthValue = intval(substr($yearlySaleSummaryItem['year_month_value'], 4, 2));
            $yearlySaleSummaryData[$monthValue][$yearlySaleSummaryItem['branch_id']] = $yearlySaleSummaryItem['total_price'];
        }
        
        $yearlyCompanySaleSummary = InvoiceHeader::getYearlyCompanySaleTaxSummary($year);
        
        $yearlyCompanySaleSummaryData = array();
        foreach ($yearlyCompanySaleSummary as $yearlyCompanySaleSummaryItem) {
            $monthValue = intval(substr($yearlyCompanySaleSummaryItem['year_month_value'], 4, 2));
            $yearlyCompanySaleSummaryData[$monthValue][$yearlyCompanySaleSummaryItem['branch_id']] = $yearlyCompanySaleSummaryItem['total_price'];
        }
        
        $yearlyIndividualSaleSummary = InvoiceHeader::getYearlyIndividualSaleTaxSummary($year);
        
        $yearlyIndividualSaleSummaryData = array();
        foreach ($yearlyIndividualSaleSummary as $yearlyIndividualSaleSummaryItem) {
            $monthValue = intval(substr($yearlyIndividualSaleSummaryItem['year_month_value'], 4, 2));
            $yearlyIndividualSaleSummaryData[$monthValue][$yearlyIndividualSaleSummaryItem['branch_id']] = $yearlyIndividualSaleSummaryItem['total_price'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        $branches = Branch::model()->findAll();
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(
                $yearlySaleSummaryData,
                $yearlyCompanySaleSummaryData,
                $yearlyIndividualSaleSummaryData,
                $year
            );
        }
        
        $this->render('summary', array(
            'yearlySaleSummaryData' => $yearlySaleSummaryData,
            'yearlyCompanySaleSummaryData' => $yearlyCompanySaleSummaryData,
            'yearlyIndividualSaleSummaryData' => $yearlyIndividualSaleSummaryData,
            'yearList' => $yearList,
            'year' => $year,
            'branches' => $branches,
        ));
    }
    
    protected function saveToExcel($yearlySaleSummaryData, $yearlyCompanySaleSummaryData, $yearlyIndividualSaleSummaryData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Faktur Penjualan Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Penjualan Tahunan');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        $worksheet->mergeCells('A5:J5');

        $worksheet->getStyle('A1:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Faktur Penjualan PPn Summary');
        $worksheet->setCellValue('A3', $year);
        $worksheet->setCellValue('A5', 'Penjualan Total');
        $monthList = array(
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        );
        $branches = Branch::model()->findAll();
        
        $worksheet->getStyle('A6:J6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A6', 'Bulan');
        $columnAllCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnAllCounter}6", CHtml::encode(CHtml::value($branch, 'code')));
            $columnAllCounter++;
        }
        $worksheet->setCellValue("{$columnAllCounter}6", 'Total');
        $worksheet->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $amountAllTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountSum = '0.00';
            $columnAllCounter = 'B';
            foreach ($branches as $branch) {
                $amount = isset($yearlySaleSummaryData[$month][$branch->id]) ? $yearlySaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnAllCounter}{$counter}", CHtml::encode($amount));
                $amountSum += $amount;
                if (!isset($amountAllTotals[$branch->id])) {
                    $amountAllTotals[$branch->id] = '0.00';
                }
                $amountAllTotals[$branch->id] += $amount;
                $columnAllCounter++;
            }
            $worksheet->setCellValue("{$columnAllCounter}{$counter}", CHtml::encode($amountSum));

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotalAll = '0.00';
        $columnAllTotalCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnAllTotalCounter}{$counter}", CHtml::encode($amountAllTotals[$branch->id]));
            $grandTotalAll += $amountAllTotals[$branch->id];
            $columnAllTotalCounter++;
        }
        $worksheet->setCellValue("{$columnAllCounter}{$counter}", CHtml::encode($grandTotalAll));
        
        $counter++;$counter++;
        
        $worksheet->mergeCells("A{$counter}:J{$counter}");
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $worksheet->setCellValue("A{$counter}", 'Penjualan PT');
        $counter++;
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'Bulan');
        $columnCompanyCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCompanyCounter}{$counter}", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCompanyCounter++;
        }
        $worksheet->setCellValue("{$columnCompanyCounter}{$counter}", 'Total');
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        $amountCompanyTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountSum = '0.00';
            $columnCompanyCounter = 'B';
            foreach ($branches as $branch) {
                $amount = isset($yearlyCompanySaleSummaryData[$month][$branch->id]) ? $yearlyCompanySaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCompanyCounter}{$counter}", CHtml::encode($amount));
                $amountSum += $amount;
                if (!isset($amountCompanyTotals[$branch->id])) {
                    $amountCompanyTotals[$branch->id] = '0.00';
                }
                $amountCompanyTotals[$branch->id] += $amount;
                $columnCompanyCounter++;
            }
            $worksheet->setCellValue("{$columnCompanyCounter}{$counter}", CHtml::encode($amountSum));

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotalCompany = '0.00';
        $columnCompanyTotalCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCompanyTotalCounter}{$counter}", CHtml::encode($amountCompanyTotals[$branch->id]));
            $grandTotalCompany += $amountCompanyTotals[$branch->id];
            $columnCompanyTotalCounter++;
        }
        $worksheet->setCellValue("{$columnCompanyTotalCounter}{$counter}", CHtml::encode($grandTotalCompany));
        
        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:J{$counter}");
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $worksheet->setCellValue("A{$counter}", 'Penjualan Retail');
        $counter++;
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'Bulan');
        $columnRetailCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnRetailCounter}{$counter}", CHtml::encode(CHtml::value($branch, 'code')));
            $columnRetailCounter++;
        }
        $worksheet->setCellValue("{$columnRetailCounter}{$counter}", 'Total');
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        $amountRetailTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountSum = '0.00';
            $columnRetailCounter = 'B';
            foreach ($branches as $branch) {
                $amount = isset($yearlyIndividualSaleSummaryData[$month][$branch->id]) ? $yearlyIndividualSaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnRetailCounter}{$counter}", CHtml::encode($amount));
                $amountSum += $amount;
                if (!isset($amountRetailTotals[$branch->id])) {
                    $amountRetailTotals[$branch->id] = '0.00';
                }
                $amountRetailTotals[$branch->id] += $amount;
                $columnRetailCounter++;
            }
            $worksheet->setCellValue("{$columnRetailCounter}{$counter}", CHtml::encode($amountSum));

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotalRetail = '0.00';
        $columnRetailTotalCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnRetailTotalCounter}{$counter}", CHtml::encode($amountRetailTotals[$branch->id]));
            $grandTotalRetail += $amountRetailTotals[$branch->id];
            $columnRetailTotalCounter++;
        }
        $worksheet->setCellValue("{$columnRetailTotalCounter}{$counter}", CHtml::encode($grandTotalRetail));
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=faktur_penjualan_ppn_summary_" . $year . ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}