<?php

class YearlyMultipleMechanicTransactionController extends Controller {

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
        
        $yearlyMultipleMechanicTransactionReport = InvoiceHeader::getYearlyMultipleMechanicTransactionReport($year);
        
        $employeeIds = array_map(function($yearlyMultipleMechanicTransactionReportItem) { return $yearlyMultipleMechanicTransactionReportItem['employee_id_assign_mechanic']; }, $yearlyMultipleMechanicTransactionReport);
        
        $yearlyMultipleMechanicTransactionServiceReport = InvoiceDetail::getYearlyMultipleMechanicTransactionServiceReport($year, $employeeIds);
        
        $yearlyMultipleMechanicTransactionServiceReportData = array();
        foreach ($yearlyMultipleMechanicTransactionServiceReport as $yearlyMultipleMechanicTransactionServiceReportItem) {
            $yearlyMultipleMechanicTransactionServiceReportData[$yearlyMultipleMechanicTransactionServiceReportItem['employee_id_assign_mechanic']] = $yearlyMultipleMechanicTransactionServiceReportItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMultipleMechanicTransactionReport, $yearlyMultipleMechanicTransactionServiceReportData, $year);
        }
        
        $this->render('summary', array(
            'yearlyMultipleMechanicTransactionReport' => $yearlyMultipleMechanicTransactionReport,
            'yearlyMultipleMechanicTransactionServiceReportData' => $yearlyMultipleMechanicTransactionServiceReportData,
            'yearList' => $yearList,
            'year' => $year,
        ));
    }
    
    protected function saveToExcel($yearlyMultipleMechanicTransactionReport, $yearlyMultipleMechanicTransactionServiceReportData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan All Mechanic Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan All Mechanic Tahunan');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan All Mechanic Tahunan');
        $worksheet->setCellValue('A3', $year);
        
        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Mechanic');
        $worksheet->setCellValue('B5', 'Total Car');
        $worksheet->setCellValue('C5', 'Total WO');
        $worksheet->setCellValue('D5', 'Vehicle System Check');
        $worksheet->setCellValue('E5', 'Retail Customer');
        $worksheet->setCellValue('F5', 'Contract Service Unit');
        $worksheet->setCellValue('G5', 'Total Service');
        $worksheet->setCellValue('H5', 'Total Standard Service Time');
        $worksheet->setCellValue('I5', 'Total Service Time');
        $worksheet->setCellValue('J5', 'Total Service (Rp)');
        $worksheet->setCellValue('K5', 'Average Service (Rp)');
        $worksheet->getStyle('A6:K6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $vehicleQuantitySum = 0;
        $workOrderQuantitySum = 0;
        $customerRetailQuantitySum = 0;
        $customerCompanyQuantitySum = 0;
        $quantityServiceSum = 0;
        $totalServiceSum = '0.00';
        $averageServiceSum = '0.00';
        foreach ($yearlyMultipleMechanicTransactionReport as $dataItem) {
            $detailItem = $yearlyMultipleMechanicTransactionServiceReportData[$dataItem['employee_id_assign_mechanic']];
            $averageService = $detailItem['service_quantity'] > 0 ? $dataItem['total_service'] / $detailItem['service_quantity'] : '0.00';
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['employee_name']);
            $worksheet->setCellValue("B{$counter}", $dataItem['vehicle_quantity']);
            $worksheet->setCellValue("C{$counter}", $dataItem['work_order_quantity']);
            $worksheet->setCellValue("E{$counter}", $dataItem['customer_retail_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItem['customer_company_quantity']);
            $worksheet->setCellValue("G{$counter}", $detailItem['service_quantity']);
            $worksheet->setCellValue("J{$counter}", $dataItem['total_service']);
            $worksheet->setCellValue("K{$counter}", $averageService);
            
            $vehicleQuantitySum += $dataItem['vehicle_quantity'];
            $workOrderQuantitySum += $dataItem['work_order_quantity'];
            $customerRetailQuantitySum += $dataItem['customer_retail_quantity'];
            $customerCompanyQuantitySum += $dataItem['customer_company_quantity'];
            $quantityServiceSum += $detailItem['service_quantity'];
            $totalServiceSum += $dataItem['total_service'];
            $averageServiceSum += $averageService;

            $counter++;
        }

        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("B{$counter}", $vehicleQuantitySum);
        $worksheet->setCellValue("C{$counter}", $workOrderQuantitySum);
        $worksheet->setCellValue("E{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("G{$counter}", $quantityServiceSum);
        $worksheet->setCellValue("J{$counter}", $totalServiceSum);
        $worksheet->setCellValue("K{$counter}", $averageServiceSum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_all_mechanic_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}