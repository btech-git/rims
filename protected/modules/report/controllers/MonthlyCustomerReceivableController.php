<?php

class MonthlyCustomerReceivableController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('customerReceivableReport'))) {
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
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $monthlyCustomerReceivableSummary = new MonthlyCustomerReceivableSummary($customerDataProvider);
        $monthlyCustomerReceivableSummary->setupLoading();
        $monthlyCustomerReceivableSummary->setupPaging(100, $currentPage);
        $monthlyCustomerReceivableSummary->setupSorting();
        $monthlyCustomerReceivableSummary->setupFilter($year, $month, $customerId);
        
        $customerIds = array_map(function($customer) { return $customer->id; }, $monthlyCustomerReceivableSummary->dataProvider->data);
        
        $monthlyCustomerReceivableReport = RegistrationTransaction::getMonthlyCustomerReceivableData($year, $month, $customerIds);
        
        $monthlyCustomerReceivableReportData = array();
        foreach ($monthlyCustomerReceivableReport as $monthlyCustomerReceivableReportItem) {
            $monthlyCustomerReceivableReportData[$monthlyCustomerReceivableReportItem['customer_id']][] = $monthlyCustomerReceivableReportItem;
        }
        
        $registrationTransactionIds = array_map(function($reportDataItem) { return $reportDataItem['id']; }, $monthlyCustomerReceivableReport);
        
        $monthlyCustomerMovementReport = MovementOutHeader::getMonthlyCustomerMovementReport($registrationTransactionIds);
        
        $monthlyCustomerMovementReportData = array();
        foreach ($monthlyCustomerMovementReport as $monthlyCustomerMovementReportItem) {
            $monthlyCustomerMovementReportData[$monthlyCustomerMovementReportItem['registration_transaction_id']] = $monthlyCustomerMovementReportItem['movement_transaction_info'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyCustomerReceivableSummary, $monthlyCustomerReceivableReportData, $month, $year);
        }
        
        $this->render('summary', array(
            'monthlyCustomerReceivableSummary' => $monthlyCustomerReceivableSummary,
            'monthlyCustomerReceivableReportData' => $monthlyCustomerReceivableReportData,
            'monthlyCustomerMovementReportData' => $monthlyCustomerMovementReportData,
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
            'customerId' => $customerId,
        ));
    }
    
    protected function saveToExcel($monthlyCustomerReceivableSummary, $monthlyCustomerReceivableReportData, $month, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Bulanan');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');

        $worksheet->getStyle('A1:AG6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AG6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Piutang Customer Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
       
        $worksheet->getStyle('A5:AG5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells('D5:F5');
        $worksheet->setCellValue('D5', 'Customer PO');
        $worksheet->mergeCells('G5:I5');
        $worksheet->setCellValue('G5', 'Kendaraan');
        $worksheet->mergeCells('J5:L5');
        $worksheet->setCellValue('J5', 'Nota - Sales Order(SO)');
        $worksheet->mergeCells('M5:U5');
        $worksheet->setCellValue('M5', 'Invoice');
        $worksheet->mergeCells('V5:W5');
        $worksheet->setCellValue('V5', 'Faktur Pajak');
        $worksheet->mergeCells('X5:AA5');
        $worksheet->setCellValue('X5', 'Doc Status');
        $worksheet->mergeCells('AB5:AG5');
        $worksheet->setCellValue('AB5', 'Payment Status');
        
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Customer');
        $worksheet->setCellValue('C6', 'Cabang');
        $worksheet->setCellValue('D6', 'PO Date');
        $worksheet->setCellValue('E6', 'No PO');
        $worksheet->setCellValue('F6', 'PO Amount');
        $worksheet->setCellValue('G6', 'Brand');
        $worksheet->setCellValue('H6', 'Jenis');
        $worksheet->setCellValue('I6', 'Plat #');
        $worksheet->setCellValue('J6', 'Tanggal Pasang');
        $worksheet->setCellValue('K6', 'No Nota - SO');
        $worksheet->setCellValue('L6', 'Jumlah Nota');
        $worksheet->setCellValue('M6', 'Parts');
        $worksheet->setCellValue('N6', 'Jasa');
        $worksheet->setCellValue('O6', 'Total');
        $worksheet->setCellValue('P6', 'PPn');
        $worksheet->setCellValue('Q6', 'Materai');
        $worksheet->setCellValue('R6', 'PPh');
        $worksheet->setCellValue('S6', 'Amount');
        $worksheet->setCellValue('T6', 'Date');
        $worksheet->setCellValue('U6', 'Number');
        $worksheet->setCellValue('V6', 'FP #');
        $worksheet->setCellValue('W6', 'FP Date');
        $worksheet->setCellValue('X6', 'pdf');
        $worksheet->setCellValue('Y6', 'print');
        $worksheet->setCellValue('Z6', 'Done Sent');
        $worksheet->setCellValue('AA6', 'Tanggal Kirim');
        $worksheet->setCellValue('AB6', 'No Resi');
        $worksheet->setCellValue('AC6', 'Jatuh Tempo');
        $worksheet->setCellValue('AD6', 'Outstanding');
        $worksheet->setCellValue('AE6', 'Pelunasan');
        $worksheet->setCellValue('AF6', 'Done');
        $worksheet->setCellValue('AG6', 'Tanggal Bayar');
        $worksheet->getStyle('A6:AG6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($monthlyCustomerReceivableSummary->dataProvider->data as $customer) {
            foreach ($monthlyCustomerReceivableReportData[$customer->id] as $i => $dataItem) {
//                $movementTransactionInfo = isset($monthlyCustomerMovementReportData[$dataItem['id']]) ? $monthlyCustomerMovementReportData[$dataItem['id']] : '';
                $worksheet->setCellValue("A{$counter}", $i + 1);
                $worksheet->setCellValue("B{$counter}", CHtml::value($customer, 'name'));
                $worksheet->setCellValue("C{$counter}", $dataItem['branch_name']);
                $worksheet->setCellValue("D{$counter}", $dataItem['transaction_date']);
                $worksheet->setCellValue("E{$counter}", $dataItem['transaction_number']);
                $worksheet->setCellValue("F{$counter}", $dataItem['grand_total']);
                $worksheet->setCellValue("G{$counter}", $dataItem['car_make']);
                $worksheet->setCellValue("H{$counter}", $dataItem['car_model'] . ' - ' . $dataItem['car_sub_model']);
                $worksheet->setCellValue("I{$counter}", $dataItem['plate_number']);
                $worksheet->setCellValue("M{$counter}", $dataItem['product_price']);
                $worksheet->setCellValue("N{$counter}", $dataItem['service_price']);
                $worksheet->setCellValue("O{$counter}", $dataItem['product_price'] + $dataItem['service_price']);
                $worksheet->setCellValue("P{$counter}", $dataItem['ppn_total']);
                $worksheet->setCellValue("S{$counter}", $dataItem['total_price']);
                $worksheet->setCellValue("T{$counter}", $dataItem['invoice_date']);
                $worksheet->setCellValue("U{$counter}", $dataItem['invoice_number']);
                $worksheet->setCellValue("V{$counter}", $dataItem['transaction_tax_number']);
                $worksheet->setCellValue("AA{$counter}", $dataItem['invoice_date']);
                $worksheet->setCellValue("AB{$counter}", $dataItem['payment_number']);
                $worksheet->setCellValue("AC{$counter}", $dataItem['due_date']);
                $worksheet->setCellValue("AD{$counter}", $dataItem['payment_left']);
                $worksheet->setCellValue("AE{$counter}", $dataItem['payment_amount']);
                $worksheet->setCellValue("AG{$counter}", $dataItem['payment_date']);
                
                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}