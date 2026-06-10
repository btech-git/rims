<?php

class BodyRepairMonthlyTransactionController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director') )) {
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
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $registrationVehicleTransactionCountData = RegistrationTransaction::getVehicleTransactionCountData($year, $month, $branchId);
        $registrationServiceTransactionCountData = RegistrationService::getServiceTransactionCountData($year, $month, $branchId);
        $invoiceVehicleTransactionCountData = InvoiceHeader::getVehicleTransactionCountData($year, $month, $branchId);
        $invoiceServiceTransactionCountDate = InvoiceDetail::getServiceTransactionCountData($year, $month, $branchId);
        $workOrderServiceTransactionCountData = WorkOrderExpenseHeader::getServiceTransactionCountData($year, $month, $branchId);
        $workOrderTotalTransactionSumData = WorkOrderExpenseHeader::getTotalTransactionSumData($year, $month, $branchId);
        
        $bodyRepairTransactionInfoData = array();
        foreach ($registrationVehicleTransactionCountData as $registrationVehicleTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$registrationVehicleTransactionCountDataItem['transaction_date']]['registration_vehicle_count'] = $registrationVehicleTransactionCountDataItem['vehicle_count'];
        }
        foreach ($registrationServiceTransactionCountData as $registrationServiceTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$registrationServiceTransactionCountDataItem['transaction_date']]['registration_service_count'] = $registrationServiceTransactionCountDataItem['service_count'];
        }
        foreach ($invoiceVehicleTransactionCountData as $invoiceVehicleTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$invoiceVehicleTransactionCountDataItem['transaction_date']]['invoice_vehicle_count'] = $invoiceVehicleTransactionCountDataItem['vehicle_count'];
        }
        foreach ($invoiceServiceTransactionCountDate as $invoiceServiceTransactionCountDateItem) {
            $bodyRepairTransactionInfoData[$invoiceServiceTransactionCountDateItem['transaction_date']]['invoice_service_count'] = $invoiceServiceTransactionCountDateItem['service_count'];
        }
        foreach ($workOrderServiceTransactionCountData as $workOrderServiceTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$workOrderServiceTransactionCountDataItem['transaction_date']]['work_order_service_count'] = $workOrderServiceTransactionCountDataItem['service_count'];
        }
        foreach ($workOrderTotalTransactionSumData as $workOrderTotalTransactionSumDataItem) {
            $bodyRepairTransactionInfoData[$workOrderTotalTransactionSumDataItem['transaction_date']]['work_order_total'] = $workOrderTotalTransactionSumDataItem['total'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'bodyRepairTransactionInfoData' => $bodyRepairTransactionInfoData,
                'month' => $month,
                'year' => $year,
                'numberOfDays' => $numberOfDays,
            ));
        }

        $this->render('summary', array(
            'bodyRepairTransactionInfoData' => $bodyRepairTransactionInfoData,
            'yearList' => $yearList,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
        ));
    }
    
    public function actionRegistrationVehicleInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'DATE(transaction_date) = :transaction_date AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('registrationVehicleInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionRegistrationServiceInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'DATE(transaction_date) = :transaction_date AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('registrationServiceInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionInvoiceVehicleInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'DATE(t.invoice_date) = :invoice_date AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':invoice_date' => $transactionDate)
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('invoiceVehicleInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionInvoiceServiceInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'DATE(t.invoice_date) = :invoice_date AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':invoice_date' => $transactionDate)
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('invoiceServiceInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionWorkOrderExpenseInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'DATE(t.transaction_date) = :transaction_date AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND t.supplier_id = 250',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('workOrderExpenseInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionRegistrationVehicleMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('registrationVehicleMonthlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionRegistrationServiceMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('registrationServiceMonthlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionInvoiceVehicleMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.invoice_date ASC, t.invoice_number ASC',
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('invoiceVehicleMonthlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionInvoiceServiceMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.invoice_date ASC, t.invoice_number ASC',
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('invoiceServiceMonthlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionWorkOrderExpenseMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND registrationTransaction.repair_type = "BR" AND
                            w.supplier_id = 250 AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelDailyTransactionInfo(array(
//                'dataProvider' => $dataProvider,
//                'date' => $date,
//                'coa' => $coa,
//                'branch' => $branch,
//                'inOut' => $inOut,
//            ));
//        }

        $this->render('workOrderExpenseMonthlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
            'month' => $month,
        ));
    }

    protected function saveToExcel(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $bodyRepairTransactionInfoData = $options['bodyRepairTransactionInfoData'];
        $month = $options['month'];
        $year = $options['year'];
        $numberOfDays = $options['numberOfDays'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Body Repair Panel');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Body Repair Panel');

        $worksheet->mergeCells("A1:G1");
        $worksheet->mergeCells("A2:G2");
        $worksheet->mergeCells("A3:G3");
        
        $worksheet->getStyle("A1:G5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:G5")->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Body Repair - Panel Report - Monthly');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));

        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("A5", 'Tanggal');
        $worksheet->setCellValue("B5", 'Unit Register In');
        $worksheet->setCellValue("C5", 'Panel Register In');
        $worksheet->setCellValue("D5", 'Unit Invoiced Out');
        $worksheet->setCellValue("E5", 'Panel Invoiced Out');
        $worksheet->setCellValue("F5", 'Sub Pekerjaan Luar Panel');
        $worksheet->setCellValue("G5", 'Total Sub Pekerjaan Luar');
        
        $worksheet->getStyle("A5:G5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $registrationVehicleCountSum = 0;
        $registrationServiceCountSum = 0;
        $invoiceVehicleCountSum = 0;
        $invoiceServiceCountSum = 0;
        $workOrderCountSum = 0;
        $workOrderTotalSum = '0.00';
        
        for ($i = 1; $i <= $numberOfDays; $i++) {
            $transactionDate = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $registrationVehicleCount = isset($bodyRepairTransactionInfoData[$transactionDate]['registration_vehicle_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['registration_vehicle_count'] : 0;
            $registrationServiceCount = isset($bodyRepairTransactionInfoData[$transactionDate]['registration_service_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['registration_service_count'] : 0;
            $invoiceVehicleCount = isset($bodyRepairTransactionInfoData[$transactionDate]['invoice_vehicle_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['invoice_vehicle_count'] : 0;
            $invoiceServiceCount = isset($bodyRepairTransactionInfoData[$transactionDate]['invoice_service_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['invoice_service_count'] : 0;
            $workOrderCount = isset($bodyRepairTransactionInfoData[$transactionDate]['service_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['service_count'] : 0;
            $workOrderTotal = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_total']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_total'] : '0.00';
                
            $worksheet->setCellValue("A{$counter}", $transactionDate);
            $worksheet->setCellValue("B{$counter}", $registrationVehicleCount);
            $worksheet->setCellValue("C{$counter}", $registrationServiceCount);
            $worksheet->setCellValue("D{$counter}", $invoiceVehicleCount);
            $worksheet->setCellValue("E{$counter}", $invoiceServiceCount);
            $worksheet->setCellValue("F{$counter}", $workOrderCount);
            $worksheet->setCellValue("G{$counter}", $workOrderTotal);
            
            $registrationVehicleCountSum += $registrationVehicleCount;
            $registrationServiceCountSum += $registrationServiceCount;
            $invoiceVehicleCountSum += $invoiceVehicleCount;
            $invoiceServiceCountSum += $invoiceServiceCount;
            $workOrderCountSum += $workOrderCount;
            $workOrderTotalSum += $workOrderTotal;
            
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("B{$counter}", $registrationVehicleCountSum);
        $worksheet->setCellValue("C{$counter}", $registrationServiceCountSum);
        $worksheet->setCellValue("D{$counter}", $invoiceVehicleCountSum);
        $worksheet->setCellValue("E{$counter}", $invoiceServiceCountSum);
        $worksheet->setCellValue("F{$counter}", $workOrderCountSum);
        $worksheet->setCellValue("G{$counter}", $workOrderTotalSum);
                
        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="body_repair_panel_monthly.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}