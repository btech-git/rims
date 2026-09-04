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
        $documentProperties->setTitle('Penjualan Semua Cabang Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Semua Cabang Harian');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:V5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Penjualan Semua Cabang Harian');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:V5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Branch');
        $worksheet->setCellValue('C5', 'Vehicle Total');
        $worksheet->setCellValue('D5', 'Vehicle Baru');
        $worksheet->setCellValue('E5', 'Vehicle Repeat');
        $worksheet->setCellValue('F5', 'Customer Total');
        $worksheet->setCellValue('G5', 'Baru');
        $worksheet->setCellValue('H5', 'Repeat');
        $worksheet->setCellValue('I5', 'Retail');
        $worksheet->setCellValue('J5', 'Contract Service Unit');
        $worksheet->setCellValue('K5', 'Total Invoice (Rp)');
        $worksheet->setCellValue('L5', 'Jasa (Rp)');
        $worksheet->setCellValue('M5', 'Parts (Rp)');
        $worksheet->setCellValue('N5', 'Invoice per Unit (Rp)');
        $worksheet->setCellValue('O5', 'Jasa per Unit (Rp)');
        $worksheet->setCellValue('P5', 'Parts per Unit (Rp)');
        $worksheet->setCellValue('Q5', 'Total Ban');
        $worksheet->setCellValue('R5', 'Total Oli');
        $worksheet->setCellValue('S5', 'Total Aksesoris');
        $worksheet->setCellValue('T5', 'Average Ban (Rp)');
        $worksheet->setCellValue('U5', 'Average Oli (Rp)');
        $worksheet->setCellValue('V5', 'Average Aksesoris(Rp)');
        $worksheet->getStyle('A5:V5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $vehicleQuantitySum = 0;
        $vehicleNewQuantitySum = 0;
        $vehicleRepeatQuantitySum = 0;
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
            $totalInvoicePerCustomer = round($dataItem['sub_total'] / $dataItem['customer_quantity'], 2);
            $totalServicePerCustomer = round($dataItem['total_service'] / $dataItem['customer_quantity'], 2);
            $totalPartsPerCustomer = round($dataItem['total_product'] / $dataItem['customer_quantity'], 2);
            $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00';
            $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00';
            $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00';
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $dataItem['branch_name']);
            $worksheet->setCellValue("C{$counter}", $dataItem['vehicle_quantity']);
            $worksheet->setCellValue("D{$counter}", $dataItem['vehicle_new_quantity']);
            $worksheet->setCellValue("E{$counter}", $dataItem['vehicle_repeat_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItem['customer_quantity']);
            $worksheet->setCellValue("G{$counter}", $dataItem['customer_new_quantity']);
            $worksheet->setCellValue("H{$counter}", $dataItem['customer_repeat_quantity']);
            $worksheet->setCellValue("I{$counter}", $dataItem['customer_retail_quantity']);
            $worksheet->setCellValue("J{$counter}", $dataItem['customer_company_quantity']);
            $worksheet->setCellValue("K{$counter}", $dataItem['sub_total']);
            $worksheet->setCellValue("L{$counter}", $dataItem['total_service']);
            $worksheet->setCellValue("M{$counter}", $dataItem['total_product']);
            $worksheet->setCellValue("N{$counter}", $totalInvoicePerCustomer);
            $worksheet->setCellValue("O{$counter}", $totalServicePerCustomer);
            $worksheet->setCellValue("P{$counter}", $totalPartsPerCustomer);
            $worksheet->setCellValue("Q{$counter}", $detailItem['tire_quantity']);
            $worksheet->setCellValue("R{$counter}", $detailItem['oil_quantity']);
            $worksheet->setCellValue("S{$counter}", $detailItem['accessories_quantity']);
            $worksheet->setCellValue("T{$counter}", $averageTire);
            $worksheet->setCellValue("U{$counter}", $averageOil);
            $worksheet->setCellValue("V{$counter}", $averageAccessories);
            
            $vehicleQuantitySum += $dataItem['vehicle_quantity'];
            $vehicleNewQuantitySum += $dataItem['vehicle_new_quantity'];
            $vehicleRepeatQuantitySum += $dataItem['vehicle_repeat_quantity'];
            $customerQuantitySum += $dataItem['customer_quantity'];
            $customerNewQuantitySum += $dataItem['customer_new_quantity'];
            $customerRepeatQuantitySum += $dataItem['customer_repeat_quantity'];
            $customerRetailQuantitySum += $dataItem['customer_retail_quantity'];
            $customerCompanyQuantitySum += $dataItem['customer_company_quantity'];
            $grandTotalSum += $dataItem['sub_total'];
            $totalServiceSum += $dataItem['total_service'];
            $totalProductSum += $dataItem['total_product'];
            $tireQuantitySum += $detailItem['tire_quantity'];
            $oilQuantitySum += $detailItem['oil_quantity'];
            $accessoriesQuantitySum += $detailItem['accessories_quantity'];

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:V{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:V{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("B{$counter}", 'TOTAL');
        $worksheet->setCellValue("C{$counter}", $vehicleQuantitySum);
        $worksheet->setCellValue("D{$counter}", $vehicleNewQuantitySum);
        $worksheet->setCellValue("E{$counter}", $vehicleRepeatQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerQuantitySum);
        $worksheet->setCellValue("G{$counter}", $customerNewQuantitySum);
        $worksheet->setCellValue("H{$counter}", $customerRepeatQuantitySum);
        $worksheet->setCellValue("I{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("J{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("K{$counter}", $grandTotalSum);
        $worksheet->setCellValue("L{$counter}", $totalServiceSum);
        $worksheet->setCellValue("M{$counter}", $totalProductSum);
        $worksheet->setCellValue("Q{$counter}", $tireQuantitySum);
        $worksheet->setCellValue("R{$counter}", $oilQuantitySum);
        $worksheet->setCellValue("S{$counter}", $accessoriesQuantitySum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_semua_cabang_harian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}