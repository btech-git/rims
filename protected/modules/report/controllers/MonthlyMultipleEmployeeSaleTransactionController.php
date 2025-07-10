<?php

class MonthlyMultipleEmployeeSaleTransactionController extends Controller {

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
        
        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $monthlyMultipleEmployeeSaleReport = InvoiceHeader::getMonthlyMultipleEmployeeSaleReport($year, $month);
        
        $employeeIds = array_map(function($monthlyMultipleEmployeeSaleReportItem) { return $monthlyMultipleEmployeeSaleReportItem['employee_id_sales_person']; }, $monthlyMultipleEmployeeSaleReport);
        
        $monthlyMultipleEmployeeSaleProductReport = InvoiceDetail::getMonthlyMultipleEmployeeSaleProductReport($year, $month, $employeeIds);
        
        $monthlyMultipleEmployeeSaleProductReportData = array();
        foreach ($monthlyMultipleEmployeeSaleProductReport as $monthlyMultipleEmployeeSaleProductReportItem) {
            $monthlyMultipleEmployeeSaleProductReportData[$monthlyMultipleEmployeeSaleProductReportItem['employee_id_sales_person']] = $monthlyMultipleEmployeeSaleProductReportItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyMultipleEmployeeSaleReport, $monthlyMultipleEmployeeSaleProductReportData, $month, $year);
        }
        
        $this->render('summary', array(
            'monthlyMultipleEmployeeSaleReport' => $monthlyMultipleEmployeeSaleReport,
            'monthlyMultipleEmployeeSaleProductReportData' => $monthlyMultipleEmployeeSaleProductReportData,
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
        ));
    }
    
    protected function saveToExcel($monthlyMultipleEmployeeSaleReport, $monthlyMultipleEmployeeSaleProductReportData, $month, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan All Front Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan All Front Bulanan');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');

        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan All Front Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:O5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Front Name');
        $worksheet->setCellValue('B5', 'Customer Total');
        $worksheet->setCellValue('C5', 'Baru');
        $worksheet->setCellValue('D5', 'Repeat');
        $worksheet->setCellValue('E5', 'Retail');
        $worksheet->setCellValue('F5', 'Contract Service Unit');
        $worksheet->setCellValue('G5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('H5', 'Jasa (Rp)');
        $worksheet->setCellValue('I5', 'Parts (Rp)');
        $worksheet->setCellValue('J5', 'Total Ban');
        $worksheet->setCellValue('K5', 'Total Oli');
        $worksheet->setCellValue('L5', 'Total Aksesoris');
        $worksheet->setCellValue('M5', 'Average Ban');
        $worksheet->setCellValue('N5', 'Average Oli');
        $worksheet->setCellValue('O5', 'Average Aksesoris');
        $worksheet->getStyle('A6:O6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
        foreach ($monthlyMultipleEmployeeSaleReport as $dataItem) {
            $detailItem = $monthlyMultipleEmployeeSaleProductReportData[$dataItem['employee_id_sales_person']];
            $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00';
            $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00';
            $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00';
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['employee_name']);
            $worksheet->setCellValue("B{$counter}", $dataItem['customer_quantity']);
            $worksheet->setCellValue("C{$counter}", $dataItem['customer_new_quantity']);
            $worksheet->setCellValue("D{$counter}", $dataItem['customer_repeat_quantity']);
            $worksheet->setCellValue("E{$counter}", $dataItem['customer_retail_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItem['customer_company_quantity']);
            $worksheet->setCellValue("G{$counter}", $dataItem['grand_total']);
            $worksheet->setCellValue("H{$counter}", $dataItem['total_service']);
            $worksheet->setCellValue("I{$counter}", $dataItem['total_product']);
            $worksheet->setCellValue("J{$counter}", $detailItem['tire_quantity']);
            $worksheet->setCellValue("K{$counter}", $detailItem['oil_quantity']);
            $worksheet->setCellValue("L{$counter}", $detailItem['accessories_quantity']);
            $worksheet->setCellValue("M{$counter}", $averageTire);
            $worksheet->setCellValue("N{$counter}", $averageOil);
            $worksheet->setCellValue("O{$counter}", $averageAccessories);
            
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
        }

        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("B{$counter}", $customerQuantitySum);
        $worksheet->setCellValue("C{$counter}", $customerNewQuantitySum);
        $worksheet->setCellValue("D{$counter}", $customerRepeatQuantitySum);
        $worksheet->setCellValue("E{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("G{$counter}", $grandTotalSum);
        $worksheet->setCellValue("H{$counter}", $totalServiceSum);
        $worksheet->setCellValue("I{$counter}", $totalProductSum);
        $worksheet->setCellValue("J{$counter}", $tireQuantitySum);
        $worksheet->setCellValue("K{$counter}", $oilQuantitySum);
        $worksheet->setCellValue("L{$counter}", $accessoriesQuantitySum);
        $worksheet->setCellValue("M{$counter}", $averageTireSum);
        $worksheet->setCellValue("N{$counter}", $averageOilSum);
        $worksheet->setCellValue("O{$counter}", $averageAccessoriesSum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_all_front_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}