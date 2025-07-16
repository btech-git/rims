<?php

class YearlyMultipleEmployeeSaleTransactionController extends Controller {

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
        
        $yearlyMultipleEmployeeSaleReport = InvoiceHeader::getYearlyMultipleEmployeeSaleReport($year);
        
        $employeeIds = array_map(function($yearlyMultipleEmployeeSaleReportItem) { return $yearlyMultipleEmployeeSaleReportItem['employee_id_sales_person']; }, $yearlyMultipleEmployeeSaleReport);
        
        $yearlyMultipleEmployeeSaleProductReport = InvoiceDetail::getYearlyMultipleEmployeeSaleProductReport($year, $employeeIds);
        
        $yearlyMultipleEmployeeSaleProductReportData = array();
        foreach ($yearlyMultipleEmployeeSaleProductReport as $yearlyMultipleEmployeeSaleProductReportItem) {
            $yearlyMultipleEmployeeSaleProductReportData[$yearlyMultipleEmployeeSaleProductReportItem['employee_id_sales_person']] = $yearlyMultipleEmployeeSaleProductReportItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMultipleEmployeeSaleReport, $yearlyMultipleEmployeeSaleProductReportData, $year);
        }
        
        $this->render('summary', array(
            'yearlyMultipleEmployeeSaleReport' => $yearlyMultipleEmployeeSaleReport,
            'yearlyMultipleEmployeeSaleProductReportData' => $yearlyMultipleEmployeeSaleProductReportData,
            'yearList' => $yearList,
            'year' => $year,
        ));
    }
    
    protected function saveToExcel($yearlyMultipleEmployeeSaleReport, $yearlyMultipleEmployeeSaleProductReportData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan All Front Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan All Front Tahunan');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');
        $worksheet->getStyle('A1:W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:W5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan All Front Tahunan');
        $worksheet->setCellValue('A3', $year);
        
        $worksheet->getStyle('A5:W5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Front Name');
        $worksheet->setCellValue('C5', 'Customer Total');
        $worksheet->setCellValue('D5', 'per Bulan');
        $worksheet->setCellValue('E5', 'Baru');
        $worksheet->setCellValue('F5', 'Repeat');
        $worksheet->setCellValue('G5', 'Retail');
        $worksheet->setCellValue('H5', 'Contract Service Unit');
        $worksheet->setCellValue('I5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('J5', 'per Bulan');
        $worksheet->setCellValue('K5', 'per Unit');
        $worksheet->setCellValue('L5', 'Jasa (Rp)');
        $worksheet->setCellValue('M5', 'Jasa / Unit');
        $worksheet->setCellValue('N5', 'Jasa / Bulan');
        $worksheet->setCellValue('O5', 'Parts (Rp)');
        $worksheet->setCellValue('P5', 'Parts / Unit');
        $worksheet->setCellValue('Q5', 'Parts / Bulan');
        $worksheet->setCellValue('R5', 'Total Ban');
        $worksheet->setCellValue('S5', 'Total Oli');
        $worksheet->setCellValue('T5', 'Total Aksesoris');
        $worksheet->setCellValue('U5', 'Average Ban');
        $worksheet->setCellValue('V5', 'Average Oli');
        $worksheet->setCellValue('W5', 'Average Aksesoris');
        $worksheet->getStyle('A6:W6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $customerQuantitySum = 0;
        $customerNewQuantitySum = 0;
        $customerRepeatQuantitySum = 0;
        $customerRetailQuantitySum = 0;
        $customerCompanyQuantitySum = 0;
        $grandTotalSum = '0.00';
        $totalServiceSum = '0.00';
        $totalProductSum = '0.00';
        $tireQuantitySum = 0;
        $oilQuantitySum = 0;
        $accessoriesQuantitySum = 0;
        $averageTireSum = '0.00';
        $averageOilSum = '0.00';
        $averageAccessoriesSum = '0.00';
        $customerAverageDailySum = '0.00';
        $totalInvoiceAverageDailySum = '0.00';
        $totalInvoicePerCustomerSum = '0.00';
        $totalServiceAverageDailySum = '0.00';
        $totalServicePerCustomerSum = '0.00';
        $totalPartsAverageDailySum = '0.00';
        $totalPartsPerCustomerSum = '0.00';
        
        foreach ($yearlyMultipleEmployeeSaleReport as $i => $dataItem) {
            $detailItem = $yearlyMultipleEmployeeSaleProductReportData[$dataItem['employee_id_sales_person']];
            $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00';
            $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00';
            $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00';
            $customerAverageDaily = round($dataItem['customer_quantity'] / 12, 2);
            $totalInvoiceAverageDaily = round($dataItem['grand_total'] / 12, 2);
            $totalInvoicePerCustomer = round($dataItem['grand_total'] / $dataItem['customer_quantity'], 2);
            $totalServiceAverageDaily = round($dataItem['total_service'] / 12, 2);
            $totalServicePerCustomer = round($dataItem['total_service'] / $dataItem['customer_quantity'], 2);
            $totalPartsAverageDaily = round($dataItem['total_product'] / 12, 2);
            $totalPartsPerCustomer = round($dataItem['total_product'] / $dataItem['customer_quantity'], 2);
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItem['employee_name']);
            $worksheet->setCellValue("C{$counter}", $dataItem['customer_quantity']);
            $worksheet->setCellValue("D{$counter}", $customerAverageDaily);
            $worksheet->setCellValue("E{$counter}", $dataItem['customer_new_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItem['customer_repeat_quantity']);
            $worksheet->setCellValue("G{$counter}", $dataItem['customer_retail_quantity']);
            $worksheet->setCellValue("H{$counter}", $dataItem['customer_company_quantity']);
            $worksheet->setCellValue("I{$counter}", $dataItem['grand_total']);
            $worksheet->setCellValue("J{$counter}", $totalInvoiceAverageDaily);
            $worksheet->setCellValue("K{$counter}", $totalInvoicePerCustomer);
            $worksheet->setCellValue("L{$counter}", $dataItem['total_service']);
            $worksheet->setCellValue("M{$counter}", $totalServiceAverageDaily);
            $worksheet->setCellValue("N{$counter}", $totalServicePerCustomer);
            $worksheet->setCellValue("O{$counter}", $dataItem['total_product']);
            $worksheet->setCellValue("P{$counter}", $totalPartsAverageDaily);
            $worksheet->setCellValue("Q{$counter}", $totalPartsPerCustomer);
            $worksheet->setCellValue("R{$counter}", $detailItem['tire_quantity']);
            $worksheet->setCellValue("S{$counter}", $detailItem['oil_quantity']);
            $worksheet->setCellValue("T{$counter}", $detailItem['accessories_quantity']);
            $worksheet->setCellValue("U{$counter}", $averageTire);
            $worksheet->setCellValue("V{$counter}", $averageOil);
            $worksheet->setCellValue("W{$counter}", $averageAccessories);
            
            $customerQuantitySum += $dataItem['customer_quantity'];
            $customerNewQuantitySum += $dataItem['customer_new_quantity'];
            $customerRepeatQuantitySum += $dataItem['customer_repeat_quantity'];
            $customerRetailQuantitySum += $dataItem['customer_retail_quantity'];
            $customerCompanyQuantitySum += $dataItem['customer_company_quantity'];
            $grandTotalSum += $dataItem['grand_total'];
            $totalServiceSum += $dataItem['total_service'];
            $totalProductSum += $dataItem['total_product'];
            $tireQuantitySum += $detailItem['tire_quantity'];
            $oilQuantitySum += $detailItem['oil_quantity'];
            $accessoriesQuantitySum += $detailItem['accessories_quantity'];
            $averageTireSum += $averageTire;
            $averageOilSum += $averageOil;
            $averageAccessoriesSum += $averageAccessories;
            $customerAverageDailySum += $customerAverageDaily;
            $totalInvoiceAverageDailySum += $totalInvoiceAverageDaily;
            $totalInvoicePerCustomerSum += $totalInvoicePerCustomer;
            $totalServiceAverageDailySum += $totalServiceAverageDaily;
            $totalServicePerCustomerSum += $totalServicePerCustomer;
            $totalPartsAverageDailySum += $totalPartsAverageDaily;
            $totalPartsPerCustomerSum += $totalPartsPerCustomer;

            $counter++;
        }

        $worksheet->getStyle("A{$counter}:W{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:W{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("B{$counter}", 'TOTAL');
        $worksheet->setCellValue("C{$counter}", $customerQuantitySum);
        $worksheet->setCellValue("D{$counter}", $customerAverageDailySum);
        $worksheet->setCellValue("E{$counter}", $customerNewQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerRepeatQuantitySum);
        $worksheet->setCellValue("G{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("H{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("I{$counter}", $grandTotalSum);
        $worksheet->setCellValue("J{$counter}", $totalInvoiceAverageDailySum);
        $worksheet->setCellValue("K{$counter}", $totalInvoicePerCustomerSum);
        $worksheet->setCellValue("L{$counter}", $totalServiceSum);
        $worksheet->setCellValue("M{$counter}", $totalServiceAverageDailySum);
        $worksheet->setCellValue("N{$counter}", $totalServicePerCustomerSum);
        $worksheet->setCellValue("O{$counter}", $totalProductSum);
        $worksheet->setCellValue("P{$counter}", $totalPartsAverageDailySum);
        $worksheet->setCellValue("Q{$counter}", $totalPartsPerCustomerSum);
        $worksheet->setCellValue("R{$counter}", $tireQuantitySum);
        $worksheet->setCellValue("S{$counter}", $oilQuantitySum);
        $worksheet->setCellValue("T{$counter}", $accessoriesQuantitySum);
        $worksheet->setCellValue("U{$counter}", $averageTireSum);
        $worksheet->setCellValue("V{$counter}", $averageOilSum);
        $worksheet->setCellValue("W{$counter}", $averageAccessoriesSum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_all_front_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}