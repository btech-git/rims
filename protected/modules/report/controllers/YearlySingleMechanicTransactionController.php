<?php

class YearlySingleMechanicTransactionController extends Controller {

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
        $employeeId = (isset($_GET['EmployeeId'])) ? $_GET['EmployeeId'] : '';
        
        $yearlySingleMechanicTransactionReport = InvoiceHeader::getYearlySingleMechanicTransactionReport($year, $employeeId);
        
        $yearlySingleMechanicTransactionServiceReport = InvoiceDetail::getYearlySingleMechanicTransactionServiceReport($year, $employeeId);
        
        $yearlySingleMechanicTransactionReportData = array();
        foreach ($yearlySingleMechanicTransactionReport as $yearlySingleMechanicTransactionReportItem) {
            $yearlySingleMechanicTransactionReportData[$yearlySingleMechanicTransactionReportItem['month']] = $yearlySingleMechanicTransactionReportItem;
        }
        
        $yearlySingleMechanicTransactionServiceReportData = array();
        foreach ($yearlySingleMechanicTransactionServiceReport as $yearlySingleMechanicTransactionServiceReportItem) {
            $yearlySingleMechanicTransactionServiceReportData[$yearlySingleMechanicTransactionServiceReportItem['month']] = $yearlySingleMechanicTransactionServiceReportItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlySingleMechanicTransactionReportData, $yearlySingleMechanicTransactionServiceReportData, $year, $employeeId);
        }
        
        $this->render('summary', array(
            'yearlySingleMechanicTransactionReportData' => $yearlySingleMechanicTransactionReportData,
            'yearlySingleMechanicTransactionServiceReportData' => $yearlySingleMechanicTransactionServiceReportData,
            'yearList' => $yearList,
            'year' => $year,
            'employeeId' => $employeeId,
        ));
    }
    
    protected function saveToExcel($yearlySingleMechanicTransactionReportData, $yearlySingleMechanicTransactionServiceReportData, $year, $employeeId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Mechanic Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Mechanic Tahunan');

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
        $worksheet->getStyle('A6:O6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        for ($i = 1; $i <= 12; $i++) {
            if (isset($yearlySingleMechanicTransactionReportData[$i]) && isset($yearlySingleMechanicTransactionServiceReportData[$i])) {
                $dataItem = $yearlySingleMechanicTransactionReportData[$i];
                $detailItem = $yearlySingleMechanicTransactionServiceReportData[$i];
                $averageService = $detailItem['service_quantity'] > 0 ? $dataItem['total_service'] / $detailItem['service_quantity'] : '0.00';
                
                $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", $dataItem['month']);
                $worksheet->setCellValue("B{$counter}", $dataItem['vehicle_quantity']);
                $worksheet->setCellValue("C{$counter}", $dataItem['work_order_quantity']);
                $worksheet->setCellValue("E{$counter}", $dataItem['customer_retail_quantity']);
                $worksheet->setCellValue("F{$counter}", $dataItem['customer_company_quantity']);
                $worksheet->setCellValue("G{$counter}", $detailItem['service_quantity']);
                $worksheet->setCellValue("J{$counter}", $dataItem['total_service']);
                $worksheet->setCellValue("K{$counter}", $averageService);
                
                $counter++;
            } else {
                $worksheet->setCellValue("A{$counter}", $i);
                
                $counter++;                
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_mechanic_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}