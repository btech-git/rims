<?php

class DailyMultipleEmployeeSaleTransactionController extends Controller {

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
        
        $date = isset($_GET['Date']) ? $_GET['Date'] : date('Y-m-d');
        
        $dailyMultipleEmployeeSaleReport = InvoiceHeader::getDailyMultipleEmployeeSaleReport($date);
        
        $employeeIds = array_map(function($dailyMultipleEmployeeSaleReportItem) { return $dailyMultipleEmployeeSaleReportItem['employee_id_sales_person']; }, $dailyMultipleEmployeeSaleReport);
        
        $dailyMultipleEmployeeSaleProductReport = InvoiceDetail::getDailyMultipleEmployeeSaleProductReport($date, $employeeIds);
        
        $dailyMultipleEmployeeSaleProductReportData = array();
        foreach ($dailyMultipleEmployeeSaleProductReport as $dailyMultipleEmployeeSaleProductReportItem) {
            $dailyMultipleEmployeeSaleProductReportData[$dailyMultipleEmployeeSaleProductReportItem['employee_id_sales_person']] = $dailyMultipleEmployeeSaleProductReportItem;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($dailyMultipleEmployeeSaleReport, $dailyMultipleEmployeeSaleProductReportData, $date);
        }
        
        $this->render('summary', array(
            'dailyMultipleEmployeeSaleReport' => $dailyMultipleEmployeeSaleReport,
            'dailyMultipleEmployeeSaleProductReportData' => $dailyMultipleEmployeeSaleProductReportData,
            'date' => $date,
        ));
    }
    
    protected function saveToExcel($dailyMultipleEmployeeSaleReport, $dailyMultipleEmployeeSaleProductReportData, $date) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('All Front Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('All Front Harian');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan All Front Harian');
        $worksheet->setCellValue('A3', $date);
        
        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
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
        $worksheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dailyMultipleEmployeeSaleReport as $dataItem) {
            $detailItem = $dailyMultipleEmployeeSaleProductReportData[$dataItem['employee_id_sales_person']];
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['employee_name']);
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
            
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_front_harian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}