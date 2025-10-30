<?php

class YearlyCustomerReceivableController extends Controller {

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
        
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $yearlyCustomerInvoiceReport = InvoiceHeader::getYearlyCustomerInvoiceReport($year);
        $yearlyCustomerPaymentReport = InvoiceHeader::getYearlyCustomerPaymentReport($year);
        $beginningCustomerInvoiceReport = InvoiceHeader::getBeginningCustomerInvoiceReport($year);
        $beginningCustomerPaymentReport = InvoiceHeader::getBeginningCustomerPaymentReport($year);
        
        $yearlyCustomerReportData = array();
        
        foreach ($yearlyCustomerInvoiceReport as $yearlyCustomerInvoiceReportItem) {
            $yearlyCustomerReportData[$yearlyCustomerInvoiceReportItem['customer_id']][$yearlyCustomerInvoiceReportItem['invoice_month']]['invoice_total'] = $yearlyCustomerInvoiceReportItem['invoice_total'];
            $yearlyCustomerReportData[$yearlyCustomerInvoiceReportItem['customer_id']]['customer_name'] = $yearlyCustomerInvoiceReportItem['customer_name'];
        }
        
        foreach ($yearlyCustomerPaymentReport as $yearlyCustomerPaymentReportItem) {
            $yearlyCustomerReportData[$yearlyCustomerPaymentReportItem['customer_id']][$yearlyCustomerPaymentReportItem['payment_month']]['payment_total'] = $yearlyCustomerPaymentReportItem['payment_total'];
            $yearlyCustomerReportData[$yearlyCustomerPaymentReportItem['customer_id']]['customer_name'] = $yearlyCustomerPaymentReportItem['customer_name'];
        }
        
        foreach ($beginningCustomerInvoiceReport as $beginningCustomerInvoiceReportItem) {
            $yearlyCustomerReportData[$beginningCustomerInvoiceReportItem['customer_id']]['beginning_invoice_total'] = $beginningCustomerInvoiceReportItem['beginning_invoice_total'];
            $yearlyCustomerReportData[$beginningCustomerInvoiceReportItem['customer_id']]['customer_name'] = $beginningCustomerInvoiceReportItem['customer_name'];
        }
        
        foreach ($beginningCustomerPaymentReport as $beginningCustomerPaymentReportItem) {
            $yearlyCustomerReportData[$beginningCustomerPaymentReportItem['customer_id']]['beginning_payment_total'] = $beginningCustomerPaymentReportItem['beginning_payment_total'];
            $yearlyCustomerReportData[$beginningCustomerPaymentReportItem['customer_id']]['customer_name'] = $beginningCustomerPaymentReportItem['customer_name'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyCustomerReportData, $year);
        }
        
        $this->render('summary', array(
            'yearlyCustomerReportData' => $yearlyCustomerReportData,
            'yearList' => $yearList,
            'year' => $year,
        ));
    }
    
    public function actionTransactionInfo($customerId, $year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $customer = Customer::model()->findByPk($customerId);
        $dataProvider = JurnalUmum::model()->searchByYearlyCustomerReceivableInfo($customer->coa_id, $year, $month);
        $beginningBalance = JurnalUmum::model()->getYearlyCustomerReceivableBeginningBalance($customer->coa_id, $year, $month);
        
        $monthList =  array(
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        );

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcelTransactionInfo($dataProvider, $year, $month, $monthList, $customer);
        }
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'beginningBalance' => $beginningBalance,
            'year' => $year,
            'month' => $month,
            'customer' => $customer,
            'monthList' => $monthList,
        ));
    }

    protected function saveToExcel($yearlyCustomerReportData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $monthList = array(
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        );
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Tahunan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->getStyle('A1:AZ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AZ6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Piutang Customer Tahunan');
        $worksheet->setCellValue('A3', 'Periode Tahun: ' . $year);
        
        $columnCounterStart = 'C';
        $columnCounterEnd = 'E';
        
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->mergeCells("{$columnCounterStart}5:{$columnCounterEnd}5");
            $worksheet->setCellValue("{$columnCounterStart}5", $monthList[$month]);
            ++$columnCounterStart; ++$columnCounterStart; ++$columnCounterStart;
            ++$columnCounterEnd; ++$columnCounterEnd; ++$columnCounterEnd;
        }
        $worksheet->mergeCells("{$columnCounterStart}5:{$columnCounterEnd}5");
        $worksheet->setCellValue("{$columnCounterStart}5", 'TOTAL');
        
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'Customer');
        $worksheet->setCellValue('C6', 'Beginning');
        $columnCounter = 'D';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}6", 'Invoice');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Payment');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Outstanding');
            $columnCounter++;
            
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Invoice');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Payment');
        $columnCounter++;
        
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $ordinal = 0;
        $invoiceTotalSums = array(); 
        $paymentTotalSums = array();
        $outstandingSums = array();
        
        foreach ($yearlyCustomerReportData as $yearlyCustomerReportDataItem) {
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $beginningInvoiceTotal = isset($yearlyCustomerReportDataItem['beginning_invoice_total']) ? $yearlyCustomerReportDataItem['beginning_invoice_total'] : '0.00';
            $beginningPaymentTotal = isset($yearlyCustomerReportDataItem['beginning_payment_total']) ? $yearlyCustomerReportDataItem['beginning_payment_total'] : '0.00';
            $beginningOutstanding = $beginningInvoiceTotal - $beginningPaymentTotal; 
            
            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", $yearlyCustomerReportDataItem['customer_name']);
            $worksheet->setCellValue("C{$counter}", $beginningOutstanding);
            
            $invoiceTotalSum = 0;
            $paymentTotalSum = 0;
            $currentOutstanding = $beginningOutstanding;
            $columnCounter = 'D';
            
            for ($month = 1; $month <= 12; $month++) {
                $invoiceTotal = isset($yearlyCustomerReportDataItem[$month]['invoice_total']) ? $yearlyCustomerReportDataItem[$month]['invoice_total'] : '0.00';
                $paymentTotal = isset($yearlyCustomerReportDataItem[$month]['payment_total']) ? $yearlyCustomerReportDataItem[$month]['payment_total'] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $paymentTotal);
                $columnCounter++;
                $currentOutstanding += $invoiceTotal - $paymentTotal;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $currentOutstanding);
                $columnCounter++;
                
                $invoiceTotalSum += $invoiceTotal;
                $paymentTotalSum += $paymentTotal;
                
                if (!isset($invoiceTotalSums[$month])) {
                    $invoiceTotalSums[$month] = 0;
                }
                $invoiceTotalSums[$month] += $invoiceTotal;
                
                if (!isset($paymentTotalSums[$month])) {
                    $paymentTotalSums[$month] = 0;
                }
                $paymentTotalSums[$month] += $paymentTotal;
                
                if (!isset($outstandingSums[$month])) {
                    $outstandingSums[$month] = 0;
                }
                $outstandingSums[$month] += $currentOutstanding;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $paymentTotalSum);
            $columnCounter++;
            
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:AM{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:AM{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("B{$counter}", 'TOTAL');
        
        $grandTotalInvoice = 0;
        $grandTotalPayment = 0;
        
        $columnCounter = 'D';
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($invoiceTotalSums[$month])) {
                $invoiceTotalSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSums[$month]);
            $columnCounter++;
            
            if (!isset($paymentTotalSums[$month])) {
                $paymentTotalSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $paymentTotalSums[$month]);
            $columnCounter++;
            
            if (!isset($outstandingSums[$month])) {
                $outstandingSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $outstandingSums[$month]);
            $columnCounter++;
            
            $grandTotalInvoice += $invoiceTotalSums[$month];
            $grandTotalPayment += $paymentTotalSums[$month];
        }
        
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalInvoice);
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalPayment);
        $columnCounter++;

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    protected function saveToExcelTransactionInfo($dataProvider, $year, $month, $monthList, $customer) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer ' . $monthList[$month] . ' ' . $year);

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer ' . $monthList[$month] . ' ' . $year);

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->getStyle('A1:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Piutang Customer ' . CHtml::value($customer, 'name'));
        $worksheet->setCellValue('A3', $monthList[$month] . ' ' . $year);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Invoice #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Plat #');
        $worksheet->setCellValue('E5', 'Vehicle');
        $worksheet->setCellValue('F5', 'Status');
        $worksheet->setCellValue('G5', 'Total');
        $worksheet->setCellValue('H5', 'Payment');
        $worksheet->setCellValue('I5', 'Remaining');
        
        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $ordinal = 0;
        $totalPriceSum = '0.00';
        $totalPaymentSum = '0.00';
        $totalRemainingSum = '0.00';
        
        foreach ($dataProvider->data as $header) {
            $totalPrice = CHtml::value($header, 'total_price');
            $paymentAmount = CHtml::value($header, 'payment_amount'); 
            $paymentLeft = CHtml::value($header, 'payment_left'); 
            $worksheet->getStyle("G{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("G{$counter}", $totalPrice);
            $worksheet->setCellValue("H{$counter}", $paymentAmount);
            $worksheet->setCellValue("I{$counter}", $paymentLeft);
            
            $totalPriceSum += $totalPrice;
            $totalPaymentSum += $paymentAmount;
            $totalRemainingSum += $paymentLeft;
            
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("F{$counter}", 'TOTAL');
        $worksheet->setCellValue("G{$counter}", $totalPriceSum);
        $worksheet->setCellValue("H{$counter}", $totalPaymentSum);
        $worksheet->setCellValue("I{$counter}", $totalRemainingSum);
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_' . CHtml::value($customer, 'name') . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}