<?php

class DailyMultipleBranchSaleTransactionController extends Controller {

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
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $dailyMultipleBranchSaleReport = InvoiceHeader::getDailyMultipleBranchSaleReport($startDate, $endDate);
        
        if (isset($_GET['ResetFilter'])) {
            $startDate = date('Y-m-d');
            $endDate = date('Y-m-d');
        }
        
        $branchIds = array_map(function($dailyMultipleBranchSaleReportItem) { return $dailyMultipleBranchSaleReportItem['branch_id']; }, $dailyMultipleBranchSaleReport);
        $dailyMultipleBranchSaleProductReport = InvoiceDetail::getDailyMultipleBranchSaleProductReport($startDate, $endDate, $branchIds);
        $dailyMultipleBranchSaleProductReportData = array();
        foreach ($dailyMultipleBranchSaleProductReport as $dailyMultipleBranchSaleProductReportItem) {
            $dailyMultipleBranchSaleProductReportData[$dailyMultipleBranchSaleProductReportItem['branch_id']] = $dailyMultipleBranchSaleProductReportItem;
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($dailyMultipleBranchSaleReport, $dailyMultipleBranchSaleProductReportData, $startDate, $endDate);
        }
        
        $this->render('summary', array(
            'dailyMultipleBranchSaleReport' => $dailyMultipleBranchSaleReport,
            'dailyMultipleBranchSaleProductReportData' => $dailyMultipleBranchSaleProductReportData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    protected function saveToExcel($dailyMultipleBranchSaleReport, $dailyMultipleBranchSaleProductReportData, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('All Cabang Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('All Cabang Harian');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:S5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan All Cabang Harian');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:S5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Branch');
        $worksheet->setCellValue('C5', 'Customer Total');
        $worksheet->setCellValue('D5', 'Baru');
        $worksheet->setCellValue('E5', 'Repeat');
        $worksheet->setCellValue('F5', 'Retail');
        $worksheet->setCellValue('G5', 'Contract Service Unit');
        $worksheet->setCellValue('H5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('I5', 'Jasa (Rp)');
        $worksheet->setCellValue('J5', 'Parts (Rp)');
        $worksheet->setCellValue('K5', 'Invoice per Unit (Rp)');
        $worksheet->setCellValue('L5', 'Jasa per Unit (Rp)');
        $worksheet->setCellValue('M5', 'Parts per Unit (Rp)');
        $worksheet->setCellValue('N5', 'Total Ban');
        $worksheet->setCellValue('O5', 'Total Oli');
        $worksheet->setCellValue('P5', 'Total Aksesoris');
        $worksheet->setCellValue('Q5', 'Average Ban (Rp)');
        $worksheet->setCellValue('R5', 'Average Oli (Rp)');
        $worksheet->setCellValue('S5', 'Average Aksesoris(Rp)');
        $worksheet->getStyle('A5:S5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
        foreach ($dailyMultipleBranchSaleReport as $i => $dataItem) {
            $detailItem = $dailyMultipleBranchSaleProductReportData[$dataItem['branch_id']];
            $totalInvoicePerCustomer = round($dataItem['grand_total'] / $dataItem['customer_quantity'], 2);
            $totalServicePerCustomer = round($dataItem['total_service'] / $dataItem['customer_quantity'], 2);
            $totalPartsPerCustomer = round($dataItem['total_product'] / $dataItem['customer_quantity'], 2);
            $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00';
            $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00';
            $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00';
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItem['branch_name']);
            $worksheet->setCellValue("C{$counter}", $dataItem['customer_quantity']);
            $worksheet->setCellValue("D{$counter}", $dataItem['customer_new_quantity']);
            $worksheet->setCellValue("E{$counter}", $dataItem['customer_repeat_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItem['customer_retail_quantity']);
            $worksheet->setCellValue("G{$counter}", $dataItem['customer_company_quantity']);
            $worksheet->setCellValue("H{$counter}", $dataItem['grand_total']);
            $worksheet->setCellValue("I{$counter}", $dataItem['total_service']);
            $worksheet->setCellValue("J{$counter}", $dataItem['total_product']);
            $worksheet->setCellValue("K{$counter}", $totalInvoicePerCustomer);
            $worksheet->setCellValue("L{$counter}", $totalServicePerCustomer);
            $worksheet->setCellValue("M{$counter}", $totalPartsPerCustomer);
            $worksheet->setCellValue("N{$counter}", $detailItem['tire_quantity']);
            $worksheet->setCellValue("O{$counter}", $detailItem['oil_quantity']);
            $worksheet->setCellValue("P{$counter}", $detailItem['accessories_quantity']);
            $worksheet->setCellValue("Q{$counter}", $averageTire);
            $worksheet->setCellValue("R{$counter}", $averageOil);
            $worksheet->setCellValue("S{$counter}", $averageAccessories);
            
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

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:S{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:S{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("B{$counter}", 'TOTAL');
        $worksheet->setCellValue("C{$counter}", $customerQuantitySum);
        $worksheet->setCellValue("D{$counter}", $customerNewQuantitySum);
        $worksheet->setCellValue("E{$counter}", $customerRepeatQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("G{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("H{$counter}", $grandTotalSum);
        $worksheet->setCellValue("I{$counter}", $totalServiceSum);
        $worksheet->setCellValue("J{$counter}", $totalProductSum);
        $worksheet->setCellValue("N{$counter}", $tireQuantitySum);
        $worksheet->setCellValue("O{$counter}", $oilQuantitySum);
        $worksheet->setCellValue("P{$counter}", $accessoriesQuantitySum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_cabang_harian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}