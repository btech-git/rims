<?php

class YearlySaleSummaryController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('transactionJournalReport'))) {
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
        
        $yearlySaleSummary = InvoiceHeader::getYearlySaleSummary($year);
        
        $yearlySaleSummaryData = array();
        foreach ($yearlySaleSummary as $yearlySaleSummaryItem) {
            $monthValue = intval(substr($yearlySaleSummaryItem['year_month_value'], 4, 2));
            $yearlySaleSummaryData[$monthValue][$yearlySaleSummaryItem['branch_id']] = $yearlySaleSummaryItem['total_price'];
        }
        
        $yearlyCompanySaleSummary = InvoiceHeader::getYearlyCompanySaleSummary($year);
        
        $yearlyCompanySaleSummaryData = array();
        foreach ($yearlyCompanySaleSummary as $yearlyCompanySaleSummaryItem) {
            $monthValue = intval(substr($yearlyCompanySaleSummaryItem['year_month_value'], 4, 2));
            $yearlyCompanySaleSummaryData[$monthValue][$yearlyCompanySaleSummaryItem['branch_id']] = $yearlyCompanySaleSummaryItem['total_price'];
        }
        
        $yearlyIndividualSaleSummary = InvoiceHeader::getYearlyIndividualSaleSummary($year);
        
        $yearlyIndividualSaleSummaryData = array();
        foreach ($yearlyIndividualSaleSummary as $yearlyIndividualSaleSummaryItem) {
            $monthValue = intval(substr($yearlyIndividualSaleSummaryItem['year_month_value'], 4, 2));
            $yearlyIndividualSaleSummaryData[$monthValue][$yearlyIndividualSaleSummaryItem['branch_id']] = $yearlyIndividualSaleSummaryItem['total_price'];
        }
        
        $yearlyVehicleSaleSummary = InvoiceHeader::getYearlyVehicleSaleSummary($year);
        
        $yearlyVehicleSaleSummaryData = array();
        foreach ($yearlyVehicleSaleSummary as $yearlyVehicleSaleSummaryItem) {
            $monthValue = intval(substr($yearlyVehicleSaleSummaryItem['year_month_value'], 4, 2));
            $yearlyVehicleSaleSummaryData[$monthValue][$yearlyVehicleSaleSummaryItem['branch_id']] = $yearlyVehicleSaleSummaryItem['total_vehicle'];
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
                $yearlyVehicleSaleSummaryData,
                $year
            );
        }
        
        $this->render('summary', array(
            'yearlySaleSummaryData' => $yearlySaleSummaryData,
            'yearlyCompanySaleSummaryData' => $yearlyCompanySaleSummaryData,
            'yearlyIndividualSaleSummaryData' => $yearlyIndividualSaleSummaryData,
            'yearlyVehicleSaleSummaryData' => $yearlyVehicleSaleSummaryData,
            'yearList' => $yearList,
            'year' => $year,
            'branches' => $branches,
        ));
    }
    
    protected function saveToExcel($yearlySaleSummaryData, $yearlyCompanySaleSummaryData, $yearlyIndividualSaleSummaryData, $yearlyVehicleSaleSummaryData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penjualan Tahunan');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Tahunan');
        $worksheet->setCellValue('A3', $year);
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
        
        $worksheet->mergeCells('A5:J5');
        $worksheet->setCellValue('A5', 'Penjualan PT + Retail');
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A6', 'Bulan');
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $worksheet->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $amountTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountSum = '0.00';
            $columnCounter = 'B';
            foreach ($branches as $branch) {
                $amount = isset($yearlySaleSummaryData[$month][$branch->id]) ? $yearlySaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amount));
                $amountSum += $amount;
                if (!isset($amountTotals[$branch->id])) {
                    $amountTotals[$branch->id] = '0.00';
                }
                $amountTotals[$branch->id] += $amount;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountSum));

            $counter++;
        }
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotal = '0.00';
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountTotals[$branch->id]));
            $grandTotal += $amountTotals[$branch->id];
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($grandTotal));
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->mergeCells("A{$counter}:J{$counter}");
        $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Penjualan PT');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Bulan');
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", 'Total');
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;
        
        $amountCompanyTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountCompanySum = '0.00';
            $columnCounter = 'B';
            foreach ($branches as $branch) {
                $amountCompany = isset($yearlyCompanySaleSummaryData[$month][$branch->id]) ? $yearlyCompanySaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountCompany));
                $amountCompanySum += $amountCompany;
                if (!isset($amountCompanyTotals[$branch->id])) {
                    $amountCompanyTotals[$branch->id] = '0.00';
                }
                $amountCompanyTotals[$branch->id] += $amountCompany;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountCompanySum));

            $counter++;
        }
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotalCompany = '0.00';
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountCompanyTotals[$branch->id]));
            $grandTotalCompany += $amountCompanyTotals[$branch->id];
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($grandTotalCompany));
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->mergeCells("A{$counter}:J{$counter}");
        $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Penjualan Retail');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Bulan');
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", 'Total');
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;
        
        $amountIndividualTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountIndividualSum = '0.00';
            $columnCounter = 'B';
            foreach ($branches as $branch) {
                $amountIndividual = isset($yearlyIndividualSaleSummaryData[$month][$branch->id]) ? $yearlyIndividualSaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountIndividual));
                $amountIndividualSum += $amountIndividual;
                if (!isset($amountIndividualTotals[$branch->id])) {
                    $amountIndividualTotals[$branch->id] = '0.00';
                }
                $amountIndividualTotals[$branch->id] += $amountIndividual;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountIndividualSum));

            $counter++;
        }
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotalIndividual = '0.00';
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountIndividualTotals[$branch->id]));
            $grandTotalIndividual += $amountIndividualTotals[$branch->id];
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($grandTotalIndividual));
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->mergeCells("A{$counter}:J{$counter}");
        $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'Penjualan Total Kendaraan');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Bulan');
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", 'Total');
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;
        
        $amountVehicleTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountVehicleSum = '0.00';
            $columnCounter = 'B';
            foreach ($branches as $branch) {
                $amountVehicle = isset($yearlyVehicleSaleSummaryData[$month][$branch->id]) ? $yearlyVehicleSaleSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountVehicle));
                $amountVehicleSum += $amountVehicle;
                if (!isset($amountVehicleTotals[$branch->id])) {
                    $amountVehicleTotals[$branch->id] = '0.00';
                }
                $amountVehicleTotals[$branch->id] += $amountVehicle;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountVehicleSum));

            $counter++;
        }
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotalVehicle = '0.00';
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountVehicleTotals[$branch->id]));
            $grandTotalVehicle += $amountVehicleTotals[$branch->id];
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($grandTotalVehicle));
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounter}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_penjualan_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}