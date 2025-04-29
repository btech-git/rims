<?php

class SaleInvoiceTaxYearlyController extends Controller {

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
        
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        
        $yearlySaleSummary = InvoiceHeader::getSaleInvoiceTaxYearlyReport($year, $branchId);
        
        $yearlySaleTotalPriceData = array();
        $yearlySaleQuantityInvoiceData = array();
        $yearlySaleServicePriceData = array();
        $yearlySalePartsPriceData = array();
        $yearlySaleSubTotalData = array();
        $yearlySaleTotalTaxData = array();
        $yearlySaleTotalTaxIncomeData = array();
        foreach ($yearlySaleSummary as $yearlySaleSummaryItem) {
            $monthValue = intval(substr($yearlySaleSummaryItem['year_month_value'], 4, 2));
            $yearlySaleTotalPriceData[$monthValue] = $yearlySaleSummaryItem['total_price'];
            $yearlySaleQuantityInvoiceData[$monthValue] = $yearlySaleSummaryItem['quantity_invoice'];
            $yearlySaleServicePriceData[$monthValue] = $yearlySaleSummaryItem['service_price'];
            $yearlySalePartsPriceData[$monthValue] = $yearlySaleSummaryItem['product_price'];
            $yearlySaleSubTotalData[$monthValue] = $yearlySaleSummaryItem['sub_total'];
            $yearlySaleTotalTaxData[$monthValue] = $yearlySaleSummaryItem['total_tax'];
            $yearlySaleTotalTaxIncomeData[$monthValue] = $yearlySaleSummaryItem['total_tax_income'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(
                $yearlySaleTotalPriceData,
                $yearlySaleQuantityInvoiceData,
                $yearlySaleServicePriceData,
                $yearlySalePartsPriceData,
                $yearlySaleSubTotalData,
                $yearlySaleTotalTaxData,
                $yearlySaleTotalTaxIncomeData,
                $branchId,
                $year
            );
        }
        
        $this->render('summary', array(
            'yearlySaleTotalPriceData' => $yearlySaleTotalPriceData,
            'yearlySaleQuantityInvoiceData' => $yearlySaleQuantityInvoiceData,
            'yearlySaleServicePriceData' => $yearlySaleServicePriceData,
            'yearlySalePartsPriceData' => $yearlySalePartsPriceData,
            'yearlySaleSubTotalData' => $yearlySaleSubTotalData,
            'yearlySaleTotalTaxData' => $yearlySaleTotalTaxData,
            'yearlySaleTotalTaxIncomeData' => $yearlySaleTotalTaxIncomeData,
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
        ));
    }
    
    protected function saveToExcel($yearlySaleTotalPriceData, $yearlySaleQuantityInvoiceData, $yearlySaleServicePriceData, $yearlySalePartsPriceData, $yearlySaleSubTotalData, $yearlySaleTotalTaxData, $yearlySaleTotalTaxIncomeData, $branchId, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        $branch = Branch::model()->findByPk($branchId);

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Ppn  Recap Tahun');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Ppn  Recap Tahun');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Ppn  Recap Tahun');
        $worksheet->setCellValue('A3', $year . ' - ' . empty($branchId) ? 'All' : CHtml::encode(CHtml::value($branch, 'name')));
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
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Bulan');
        $worksheet->setCellValue('B5', '# INV');
        $worksheet->setCellValue('C5', '# FP');
        $worksheet->setCellValue('D5', '# Bupot');
        $worksheet->setCellValue('E5', 'Parts (Rp)');
        $worksheet->setCellValue('F5', 'Jasa (Rp)');
        $worksheet->setCellValue('G5', 'Total DPP');
        $worksheet->setCellValue('H5', 'Total PPn');
        $worksheet->setCellValue('I5', 'Total PPh');
        $worksheet->setCellValue('J5', 'Total Invoice');
        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $sumSubTotal = '0.00';
        $sumTotalTax = '0.00';
        $sumTotalTaxIncome = '0.00';
        $sumGrandTotal = '0.00';
        for ($month = 1; $month <= 12; $month++) {
            $quantityInvoice = isset($yearlySaleQuantityInvoiceData[$month]) ? $yearlySaleQuantityInvoiceData[$month] : '0.00';
            $totalParts = isset($yearlySalePartsPriceData[$month]) ? $yearlySalePartsPriceData[$month] : '0.00';
            $totalService = isset($yearlySaleServicePriceData[$month]) ? $yearlySaleServicePriceData[$month] : '0.00';
            $subTotal = isset($yearlySaleSubTotalData[$month]) ? $yearlySaleSubTotalData[$month] : '0.00';
            $totalTax = isset($yearlySaleTotalTaxData[$month]) ? $yearlySaleTotalTaxData[$month] : '0.00';
            $totalTaxIncome = isset($yearlySaleTotalTaxIncomeData[$month]) ? $yearlySaleTotalTaxIncomeData[$month] : '0.00';
            $totalPrice = isset($yearlySaleTotalPriceData[$month]) ? $yearlySaleTotalPriceData[$month] : '0.00';
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $monthList[$month]);
            $worksheet->setCellValue("B{$counter}", $quantityInvoice);
            $worksheet->setCellValue("E{$counter}", $totalParts);
            $worksheet->setCellValue("F{$counter}", $totalService);
            $worksheet->setCellValue("G{$counter}", $subTotal);
            $worksheet->setCellValue("H{$counter}", $totalTax);
            $worksheet->setCellValue("I{$counter}", $totalTaxIncome);
            $worksheet->setCellValue("J{$counter}", $totalPrice);

            $sumSubTotal += $subTotal;
            $sumTotalTax += $totalTax;
            $sumTotalTaxIncome += $totalTaxIncome;
            $sumGrandTotal += $totalPrice;

            $counter++;
        }
        $worksheet->setCellValue("F{$counter}", 'TOTAL');
        $worksheet->setCellValue("G{$counter}", $sumSubTotal);
        $worksheet->setCellValue("H{$counter}", $sumTotalTax);
        $worksheet->setCellValue("I{$counter}", $sumTotalTaxIncome);
        $worksheet->setCellValue("J{$counter}", $sumGrandTotal);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Penjualan Ppn  Recap Tahun.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}