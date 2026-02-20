<?php

class YearlySingleEmployeeSaleTransactionController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('yearlySaleFrontReport'))) {
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
        $employeeId = (isset($_GET['EmployeeId'])) ? $_GET['EmployeeId'] : '';
        
        $yearlySingleEmployeeSaleReport = InvoiceHeader::getYearlySingleEmployeeSaleReport($year, $employeeId);
        
        $yearlySingleEmployeeSaleProductReport = InvoiceDetail::getYearlySingleEmployeeSaleProductReport($year, $employeeId);
        
        $yearlySingleEmployeeSaleReportData = array();
        foreach ($yearlySingleEmployeeSaleReport as $yearlySingleEmployeeSaleReportItem) {
            $yearlySingleEmployeeSaleReportData[$yearlySingleEmployeeSaleReportItem['month']] = $yearlySingleEmployeeSaleReportItem;
        }
        
        $yearlySingleEmployeeSaleProductReportData = array();
        foreach ($yearlySingleEmployeeSaleProductReport as $yearlySingleEmployeeSaleProductReportItem) {
            $yearlySingleEmployeeSaleProductReportData[$yearlySingleEmployeeSaleProductReportItem['month']] = $yearlySingleEmployeeSaleProductReportItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlySingleEmployeeSaleReportData, $yearlySingleEmployeeSaleProductReportData, $year, $employeeId);
        }
        
        $this->render('summary', array(
            'yearlySingleEmployeeSaleReportData' => $yearlySingleEmployeeSaleReportData,
            'yearlySingleEmployeeSaleProductReportData' => $yearlySingleEmployeeSaleProductReportData,
            'yearList' => $yearList,
            'year' => $year,
            'employeeId' => $employeeId,
        ));
    }
    
    protected function saveToExcel($yearlySingleEmployeeSaleReportData, $yearlySingleEmployeeSaleProductReportData, $year, $employeeId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan FO Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan FO Tahunan');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');

        $worksheet->getStyle('A1:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R5')->getFont()->setBold(true);

        $employee = Employee::model()->findByPk($employeeId);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Penjualan Tahunan ' . CHtml::value($employee, 'name'));
        $worksheet->setCellValue('A3', $year);
        
        $worksheet->getStyle('A5:R5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Bulan');
        $worksheet->setCellValue('B5', 'Customer Total');
        $worksheet->setCellValue('C5', 'Baru');
        $worksheet->setCellValue('D5', 'Repeat');
        $worksheet->setCellValue('E5', 'Retail');
        $worksheet->setCellValue('F5', 'Contract Service Unit');
        $worksheet->setCellValue('G5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('H5', 'Invoice per Unit');
        $worksheet->setCellValue('I5', 'Jasa (Rp)');
        $worksheet->setCellValue('J5', 'Jasa / Unit');
        $worksheet->setCellValue('K5', 'Parts (Rp)');
        $worksheet->setCellValue('L5', 'Parts / Unit');
        $worksheet->setCellValue('M5', 'Total Ban');
        $worksheet->setCellValue('N5', 'Total Oli');
        $worksheet->setCellValue('O5', 'Total Aksesoris');
        $worksheet->setCellValue('P5', 'Average Ban');
        $worksheet->setCellValue('Q5', 'Average Oli');
        $worksheet->setCellValue('R5', 'Average Aksesoris');
        $worksheet->getStyle('A6:R6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
        for ($i = 1; $i <= 12; $i++) {
            if (isset($yearlySingleEmployeeSaleReportData[$i]) && isset($yearlySingleEmployeeSaleProductReportData[$i])) {
                $dataItem = $yearlySingleEmployeeSaleReportData[$i];
                $detailItem = $yearlySingleEmployeeSaleProductReportData[$i];
                $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00';
                $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00';
                $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00';
                $totalInvoicePerCustomer = round($dataItem['grand_total'] / $dataItem['customer_quantity'], 2);
                $totalServicePerCustomer = round($dataItem['total_service'] / $dataItem['customer_quantity'], 2);
                $totalPartsPerCustomer = round($dataItem['total_product'] / $dataItem['customer_quantity'], 2);
                
                $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $dataItem['month']);
                $worksheet->setCellValue("B{$counter}", $dataItem['customer_quantity']);
                $worksheet->setCellValue("C{$counter}", $dataItem['customer_new_quantity']);
                $worksheet->setCellValue("D{$counter}", $dataItem['customer_repeat_quantity']);
                $worksheet->setCellValue("E{$counter}", $dataItem['customer_retail_quantity']);
                $worksheet->setCellValue("F{$counter}", $dataItem['customer_company_quantity']);
                $worksheet->setCellValue("G{$counter}", $dataItem['grand_total']);
                $worksheet->setCellValue("H{$counter}", $totalInvoicePerCustomer);
                $worksheet->setCellValue("I{$counter}", $dataItem['total_service']);
                $worksheet->setCellValue("J{$counter}", $totalServicePerCustomer);
                $worksheet->setCellValue("K{$counter}", $dataItem['total_product']);
                $worksheet->setCellValue("L{$counter}", $totalPartsPerCustomer);
                $worksheet->setCellValue("M{$counter}", $detailItem['tire_quantity']);
                $worksheet->setCellValue("N{$counter}", $detailItem['oil_quantity']);
                $worksheet->setCellValue("O{$counter}", $detailItem['accessories_quantity']);
                $worksheet->setCellValue("P{$counter}", $averageTire);
                $worksheet->setCellValue("Q{$counter}", $averageOil);
                $worksheet->setCellValue("R{$counter}", $averageAccessories);
                
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

                $counter++;
            } else {
                $worksheet->setCellValue("A{$counter}", $i);
                
                $counter++;                
            }
        }

        $worksheet->getStyle("A{$counter}:R{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:R{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("B{$counter}", $customerQuantitySum);
        $worksheet->setCellValue("C{$counter}", $customerNewQuantitySum);
        $worksheet->setCellValue("D{$counter}", $customerRepeatQuantitySum);
        $worksheet->setCellValue("E{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("G{$counter}", $grandTotalSum);
        $worksheet->setCellValue("I{$counter}", $totalServiceSum);
        $worksheet->setCellValue("K{$counter}", $totalProductSum);
        $worksheet->setCellValue("M{$counter}", $tireQuantitySum);
        $worksheet->setCellValue("N{$counter}", $oilQuantitySum);
        $worksheet->setCellValue("O{$counter}", $accessoriesQuantitySum);
        $worksheet->setCellValue("P{$counter}", $averageTireSum);
        $worksheet->setCellValue("Q{$counter}", $averageOilSum);
        $worksheet->setCellValue("R{$counter}", $averageAccessoriesSum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_tahunan_' . CHtml::value($employee, 'name') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}