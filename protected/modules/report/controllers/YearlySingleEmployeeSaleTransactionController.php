<?php

class YearlySingleEmployeeSaleTransactionController extends Controller {

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
        $documentProperties->setTitle('Penjualan Front Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Front Tahunan');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');

        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);

        $employee = Employee::model()->findByPk($employeeId);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Tahunan ' . CHtml::value($employee, 'name'));
        $worksheet->setCellValue('A3', $year);
        
        $worksheet->getStyle('A5:O5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Bulan');
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
        for ($i = 1; $i <= 12; $i++) {
            if (isset($yearlySingleEmployeeSaleReportData[$i]) && isset($yearlySingleEmployeeSaleProductReportData[$i])) {
                $dataItem = $yearlySingleEmployeeSaleReportData[$i];
                $detailItem = $yearlySingleEmployeeSaleProductReportData[$i];
                $averageTire = $detailItem['tire_quantity'] > 0 ? $detailItem['tire_price'] / $detailItem['tire_quantity'] : '0.00';
                $averageOil = $detailItem['oil_quantity'] > 0 ? $detailItem['oil_price'] / $detailItem['oil_quantity'] : '0.00';
                $averageAccessories = $detailItem['accessories_quantity'] > 0 ? $detailItem['accessories_price'] / $detailItem['accessories_quantity'] : '0.00';
                
                $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $dataItem['month']);
                $worksheet->setCellValue("B{$counter}", $dataItem['customer_quantity']);
                $worksheet->setCellValue("C{$counter}", $dataItem['customer_new_quantity']);
                $worksheet->setCellValue("D{$counter}", $dataItem['customer_repeat_quantity']);
                $worksheet->setCellValue("E{$counter}", $dataItem['customer_retail_quantity']);
                $worksheet->setCellValue("G{$counter}", $dataItem['grand_total']);
                $worksheet->setCellValue("H{$counter}", $dataItem['total_service']);
                $worksheet->setCellValue("I{$counter}", $dataItem['total_product']);
                $worksheet->setCellValue("J{$counter}", $detailItem['tire_quantity']);
                $worksheet->setCellValue("K{$counter}", $detailItem['oil_quantity']);
                $worksheet->setCellValue("L{$counter}", $detailItem['accessories_quantity']);
                $worksheet->setCellValue("M{$counter}", $averageTire);
                $worksheet->setCellValue("N{$counter}", $averageOil);
                $worksheet->setCellValue("O{$counter}", $averageAccessories);
                
                $counter++;
            } else {
                $worksheet->setCellValue("A{$counter}", $i);
                $worksheet->setCellValue("B{$counter}", '0.00');
                $worksheet->setCellValue("C{$counter}", '0.00');
                $worksheet->setCellValue("D{$counter}", '0.00');
                $worksheet->setCellValue("E{$counter}", '0.00');
                $worksheet->setCellValue("G{$counter}", '0.00');
                $worksheet->setCellValue("H{$counter}", '0.00');
                $worksheet->setCellValue("I{$counter}", '0.00');
                $worksheet->setCellValue("J{$counter}", '0.00');
                $worksheet->setCellValue("K{$counter}", '0.00');
                $worksheet->setCellValue("L{$counter}", '0.00');
                $worksheet->setCellValue("M{$counter}", '0.00');
                $worksheet->setCellValue("N{$counter}", '0.00');
                $worksheet->setCellValue("O{$counter}", '0.00');
                
                $counter++;                
            }
            
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_front_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}