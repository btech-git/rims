<?php

class BodyRepairPanelYearlyTransactionController extends Controller {

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
        
        $registrationVehicleYearlyTransactionCountData = RegistrationTransaction::getVehicleYearlyTransactionCountData($year, $branchId);
        $registrationServiceYearlyTransactionCountData = RegistrationService::getServiceYearlyTransactionCountData($year, $branchId);
        $invoiceVehicleYearlyTransactionCountData = InvoiceHeader::getVehicleYearlyTransactionCountData($year, $branchId);
        $invoiceServiceYearlyTransactionCountData = InvoiceDetail::getServiceYearlyTransactionCountData($year, $branchId);
        $workOrderServiceYearlyTransactionCountData = WorkOrderExpenseHeader::getServiceYearlyTransactionCountData($year, $branchId);
        $workOrderTotalYearlyTransactionSumData = WorkOrderExpenseHeader::getTotalYearlyTransactionSumData($year, $branchId);
        
        $bodyRepairYearlyTransactionInfoData = array();
        foreach ($registrationVehicleYearlyTransactionCountData as $registrationVehicleYearlyTransactionCountDataItem) {
            $bodyRepairYearlyTransactionInfoData[$registrationVehicleYearlyTransactionCountDataItem['transaction_month']]['registration_vehicle_count'] = $registrationVehicleYearlyTransactionCountDataItem['vehicle_count'];
        }
        foreach ($registrationServiceYearlyTransactionCountData as $registrationServiceYearlyTransactionCountDataItem) {
            $bodyRepairYearlyTransactionInfoData[$registrationServiceYearlyTransactionCountDataItem['transaction_month']]['registration_service_count'] = $registrationServiceYearlyTransactionCountDataItem['service_count'];
        }
        foreach ($invoiceVehicleYearlyTransactionCountData as $invoiceVehicleYearlyTransactionCountDataItem) {
            $bodyRepairYearlyTransactionInfoData[$invoiceVehicleYearlyTransactionCountDataItem['transaction_month']]['invoice_vehicle_count'] = $invoiceVehicleYearlyTransactionCountDataItem['vehicle_count'];
        }
        foreach ($invoiceServiceYearlyTransactionCountData as $invoiceServiceYearlyTransactionCountDataItem) {
            $bodyRepairYearlyTransactionInfoData[$invoiceServiceYearlyTransactionCountDataItem['transaction_month']]['invoice_service_count'] = $invoiceServiceYearlyTransactionCountDataItem['service_count'];
        }
        foreach ($workOrderServiceYearlyTransactionCountData as $workOrderServiceYearlyTransactionCountDataItem) {
            $bodyRepairYearlyTransactionInfoData[$workOrderServiceYearlyTransactionCountDataItem['transaction_month']]['work_order_service_count'] = $workOrderServiceYearlyTransactionCountDataItem['service_count'];
        }
        foreach ($workOrderTotalYearlyTransactionSumData as $workOrderTotalYearlyTransactionSumDataItem) {
            $bodyRepairYearlyTransactionInfoData[$workOrderTotalYearlyTransactionSumDataItem['transaction_month']]['work_order_total'] = $workOrderTotalYearlyTransactionSumDataItem['total'];
        }
        
        $monthList = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'bodyRepairYearlyTransactionInfoData' => $bodyRepairYearlyTransactionInfoData,
                'monthList' => $monthList,
                'year' => $year,
            ));
        }

        $this->render('summary', array(
            'bodyRepairYearlyTransactionInfoData' => $bodyRepairYearlyTransactionInfoData,
            'yearList' => $yearList,
            'month' => $month,
            'year' => $year,
            'branchId' => $branchId,
            'monthList' => $monthList,
        ));
    }
    
    public function actionRegistrationVehicleYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(transaction_date) = :year AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year)
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

        $this->render('registrationVehicleYearlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
        ));
    }

    public function actionRegistrationServiceYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(transaction_date) = :year AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year)
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

        $this->render('registrationServiceYearlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
        ));
    }

    public function actionInvoiceVehicleYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year)
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

        $this->render('invoiceVehicleYearlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
        ));
    }

    public function actionInvoiceServiceYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year)
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

        $this->render('invoiceServiceYearlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
        ));
    }

    public function actionWorkOrderExpensePanelYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND t.supplier_id = 250',
            'params' => array(':year' => $year)
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

        $this->render('workOrderExpensePanelYearlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
        ));
    }

    public function actionWorkOrderExpenseAmountYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND t.supplier_id = 250',
            'params' => array(':year' => $year)
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

        $this->render('workOrderExpenseAmountYearlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
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

    public function actionWorkOrderExpensePanelMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND registrationTransaction.repair_type = "BR" AND
                            t.supplier_id = 250 AND t.user_id_cancelled IS NULL',
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

        $this->render('workOrderExpensePanelMonthlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionWorkOrderExpenseAmountMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND registrationTransaction.repair_type = "BR" AND
                            t.supplier_id = 250 AND t.user_id_cancelled IS NULL',
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

        $this->render('workOrderExpenseAmountMonthlyInfo', array(
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

        $bodyRepairYearlyTransactionInfoData = $options['bodyRepairYearlyTransactionInfoData'];
        $monthList = $options['monthList'];
        $year = $options['year'];
        
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
        $worksheet->setCellValue('A2', 'Body Repair - Panel Report - Yearly');
        $worksheet->setCellValue('A3', $year);

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
        
        for ($i = 1; $i <= 12; $i++) {
            $registrationVehicleCount = isset($bodyRepairYearlyTransactionInfoData[$i]['registration_vehicle_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['registration_vehicle_count'] : 0;
            $registrationServiceCount = isset($bodyRepairYearlyTransactionInfoData[$i]['registration_service_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['registration_service_count'] : 0;
            $invoiceVehicleCount = isset($bodyRepairYearlyTransactionInfoData[$i]['invoice_vehicle_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['invoice_vehicle_count'] : 0;
            $invoiceServiceCount = isset($bodyRepairYearlyTransactionInfoData[$i]['invoice_service_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['invoice_service_count'] : 0;
            $workOrderCount = isset($bodyRepairYearlyTransactionInfoData[$i]['work_order_service_count']) ? $bodyRepairYearlyTransactionInfoData[$i]['work_order_service_count'] : 0;
            $workOrderTotal = isset($bodyRepairYearlyTransactionInfoData[$i]['work_order_total']) ? $bodyRepairYearlyTransactionInfoData[$i]['work_order_total'] : '0.00';
                
            $worksheet->setCellValue("A{$counter}", $monthList[$i]);
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
        header('Content-Disposition: attachment;filename="body_repair_panel_yearly.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}