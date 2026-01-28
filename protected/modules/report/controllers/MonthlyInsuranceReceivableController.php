<?php

class MonthlyInsuranceReceivableController extends Controller {

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
        $insuranceId = (isset($_GET['InsuranceId'])) ? $_GET['InsuranceId'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';

        $insuranceCompany = Search::bind(new InsuranceCompany('search'), isset($_GET['InsuranceCompany']) ? $_GET['InsuranceCompany'] : array());
        $insuranceDataProvider = $insuranceCompany->search();
        $insuranceDataProvider->pagination->pageVar = 'page_dialog';

        $monthlyInsuranceReceivableSummary = new MonthlyInsuranceReceivableSummary($insuranceDataProvider);
        $monthlyInsuranceReceivableSummary->setupLoading();
        $monthlyInsuranceReceivableSummary->setupPaging(100, $currentPage);
        $monthlyInsuranceReceivableSummary->setupSorting();
        $monthlyInsuranceReceivableSummary->setupFilter($year, $month, $insuranceId);
        
        $insuranceIds = array_map(function($insurance) { return $insurance->id; }, $monthlyInsuranceReceivableSummary->dataProvider->data);
        
        $monthlyInsuranceReceivableReport = RegistrationTransaction::getMonthlyInsuranceReceivableData($year, $month, $insuranceIds);
        
        $monthlyInsuranceReceivableReportData = array();
        foreach ($monthlyInsuranceReceivableReport as $monthlyInsuranceReceivableReportItem) {
            $monthlyInsuranceReceivableReportData[$monthlyInsuranceReceivableReportItem['insurance_company_id']][] = $monthlyInsuranceReceivableReportItem;
        }
        
        $registrationTransactionIds = array_map(function($reportDataItem) { return $reportDataItem['id']; }, $monthlyInsuranceReceivableReport);
        
        $monthlyInsuranceMovementReport = MovementOutHeader::getMonthlyCustomerMovementReport($registrationTransactionIds);
        
        $monthlyInsuranceMovementReportData = array();
        foreach ($monthlyInsuranceMovementReport as $monthlyInsuranceMovementReportItem) {
            $monthlyInsuranceMovementReportData[$monthlyInsuranceMovementReportItem['registration_transaction_id']] = $monthlyInsuranceMovementReportItem['movement_transaction_info'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyInsuranceReceivableSummary, $monthlyInsuranceReceivableReportData, $month, $year);
        }
        
        $this->render('summary', array(
            'monthlyInsuranceReceivableSummary' => $monthlyInsuranceReceivableSummary,
            'monthlyInsuranceReceivableReportData' => $monthlyInsuranceReceivableReportData,
            'monthlyInsuranceMovementReportData' => $monthlyInsuranceMovementReportData,
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
            'insuranceId' => $insuranceId,
        ));
    }
    
    protected function saveToExcel($monthlyInsuranceReceivableSummary, $monthlyInsuranceReceivableReportData, $month, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Asuransi Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Asuransi Bulanan');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');

        $worksheet->getStyle('A1:AG6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AG6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Piutang Asuransi Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
       
        $worksheet->getStyle('A5:AG5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells('D5:F5');
        $worksheet->setCellValue('D5', 'Insurance PO');
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
        $worksheet->setCellValue('B6', 'Insurance');
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
        $ordinal = 1;
        foreach ($monthlyInsuranceReceivableSummary->dataProvider->data as $insurance) {
            foreach ($monthlyInsuranceReceivableReportData[$insurance->id] as $i => $dataItem) {
                $worksheet->setCellValue("A{$counter}", $ordinal);
                $worksheet->setCellValue("B{$counter}", CHtml::value($insurance, 'name'));
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
                
                $counter++; $ordinal++;
            }
        }

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_asuransi_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}