<?php

class DailyMultipleMechanicTransactionController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('dailySaleAllMechanicReport'))) {
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
        $dailyMultipleMechanicTransactionReport = InvoiceHeader::getDailyMultipleMechanicTransactionReport($startDate, $endDate);
        
        $employeeIds = array_map(function($dailyMultipleMechanicTransactionItem) { return $dailyMultipleMechanicTransactionItem['employee_id_assign_mechanic']; }, $dailyMultipleMechanicTransactionReport);
        
        $dailyMultipleMechanicTransactionServiceReport = InvoiceDetail::getDailyMultipleMechanicTransactionServiceReport($startDate, $endDate, $employeeIds);
        
        $dailyMultipleMechanicTransactionServiceReportData = array();
        foreach ($dailyMultipleMechanicTransactionServiceReport as $dailyMultipleMechanicTransactionServiceReportItem) {
            $dailyMultipleMechanicTransactionServiceReportData[$dailyMultipleMechanicTransactionServiceReportItem['employee_id_assign_mechanic']] = $dailyMultipleMechanicTransactionServiceReportItem;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($dailyMultipleMechanicTransactionReport, $dailyMultipleMechanicTransactionServiceReportData, $startDate, $endDate);
        }
        
        $this->render('summary', array(
            'dailyMultipleMechanicTransactionReport' => $dailyMultipleMechanicTransactionReport,
            'dailyMultipleMechanicTransactionServiceReportData' => $dailyMultipleMechanicTransactionServiceReportData,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ));
    }
    
    public function actionTransactionInfo($mechanicId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByMechanicDatePeriodeTransactionInfo($mechanicId, $startDate, $endDate, $page);
        $employee = Employee::model()->findByPk($mechanicId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'employee' => $employee,
        ));
    }

    protected function saveToExcel($dailyMultipleMechanicTransactionReport, $dailyMultipleMechanicTransactionServiceReportData, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('All Mechanic Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('All Mechanic Harian');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan All Mechanic Harian');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));
        
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
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
        $worksheet->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $vehicleQuantitySum = 0;
        $workOrderQuantitySum = 0;
        $customerRetailQuantitySum = 0;
        $customerCompanyQuantitySum = 0;
        $quantityServiceSum = 0;
        $totalServiceSum = '0.00';
        foreach ($dailyMultipleMechanicTransactionReport as $dataItem) {
            $detailItem = $dailyMultipleMechanicTransactionServiceReportData[$dataItem['employee_id_assign_mechanic']];
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $dataItem['employee_name']);
            $worksheet->setCellValue("B{$counter}", $dataItem['vehicle_quantity']);
            $worksheet->setCellValue("C{$counter}", $dataItem['work_order_quantity']);
            $worksheet->setCellValue("E{$counter}", $dataItem['customer_retail_quantity']);
            $worksheet->setCellValue("F{$counter}", $dataItem['customer_company_quantity']);
            $worksheet->setCellValue("G{$counter}", $detailItem['service_quantity']);
            $worksheet->setCellValue("J{$counter}", $dataItem['total_service']);
            
            $vehicleQuantitySum += $dataItem['vehicle_quantity'];
            $workOrderQuantitySum += $dataItem['work_order_quantity'];
            $customerRetailQuantitySum += $dataItem['customer_retail_quantity'];
            $customerCompanyQuantitySum += $dataItem['customer_company_quantity'];
            $quantityServiceSum += $detailItem['service_quantity'];
            $totalServiceSum += $dataItem['total_service'];

            $counter++;
        }

        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("B{$counter}", $vehicleQuantitySum);
        $worksheet->setCellValue("C{$counter}", $workOrderQuantitySum);
        $worksheet->setCellValue("E{$counter}", $customerRetailQuantitySum);
        $worksheet->setCellValue("F{$counter}", $customerCompanyQuantitySum);
        $worksheet->setCellValue("G{$counter}", $quantityServiceSum);
        $worksheet->setCellValue("J{$counter}", $totalServiceSum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_mechanic_harian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}