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
        
        $yearlyCustomerReceivableReport = InvoiceHeader::getYearlyCustomerReceivableReport($year);
        
        $yearlyCustomerReceivableReportData = array();
        foreach ($yearlyCustomerReceivableReport as $yearlyCustomerReceivableReportItem) {
            $yearlyCustomerReceivableReportData[$yearlyCustomerReceivableReportItem['customer_id']][$yearlyCustomerReceivableReportItem['invoice_month']]['invoice_total'] = $yearlyCustomerReceivableReportItem['invoice_total'];
            $yearlyCustomerReceivableReportData[$yearlyCustomerReceivableReportItem['customer_id']][$yearlyCustomerReceivableReportItem['invoice_month']]['invoice_payment'] = $yearlyCustomerReceivableReportItem['invoice_payment'];
            $yearlyCustomerReceivableReportData[$yearlyCustomerReceivableReportItem['customer_id']][$yearlyCustomerReceivableReportItem['invoice_month']]['invoice_outstanding'] = $yearlyCustomerReceivableReportItem['invoice_outstanding'];
            $yearlyCustomerReceivableReportData[$yearlyCustomerReceivableReportItem['customer_id']]['customer_name'] = $yearlyCustomerReceivableReportItem['customer_name'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyCustomerReceivableReportData, $year);
        }
        
        $this->render('summary', array(
            'yearlyCustomerReceivableReportData' => $yearlyCustomerReceivableReportData,
            'yearList' => $yearList,
            'year' => $year,
        ));
    }
    
    public function actionTransactionInfo($customerId, $year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

//        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceHeader::model()->searchByYearlyCustomerReceivableInfo($customerId, $year, $month);
        $customer = Customer::model()->findByPk($customerId);
        
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

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'year' => $year,
            'month' => $month,
            'customer' => $customer,
            'monthList' => $monthList,
        ));
    }

    protected function saveToExcel($yearlyCustomerReceivableReportData, $year) {
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
        $columnCounter = 'C';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}6", 'Invoice Amount');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Outstanding');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Pelunasan');
            $columnCounter++;
            
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Invoice Amount');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Outstanding');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Pelunasan');
        $columnCounter++;
        
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $ordinal = 0;
        $invoiceTotalSums = array(); 
        $invoiceOutstandingSums = array();
        $invoicePaymentSums = array();
        
        foreach ($yearlyCustomerReceivableReportData as $customerId => $yearlyCustomerReceivableReportDataItem) {
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", $yearlyCustomerReceivableReportDataItem['customer_name']);
            
            $invoiceTotalSum = 0;
            $invoiceOutstandingSum = 0;
            $invoicePaymentSum = 0; 
            $columnCounter = 'C';
            
            for ($month = 1; $month <= 12; $month++) {
                $invoiceTotal = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_total']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_total'] : '';
                $invoiceOutstanding = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_outstanding']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_outstanding'] : '';
                $invoicePayment = isset($yearlyCustomerReceivableReportDataItem[$month]['invoice_payment']) ? $yearlyCustomerReceivableReportDataItem[$month]['invoice_payment'] : '';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceOutstanding);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoicePayment);
                $columnCounter++;
                
                $invoiceTotalSum += $invoiceTotal;
                $invoiceOutstandingSum += $invoiceOutstanding;
                $invoicePaymentSum += $invoicePayment;
                
                if (!isset($invoiceTotalSums[$month])) {
                    $invoiceTotalSums[$month] = 0;
                }
                $invoiceTotalSums[$month] += $invoiceTotal;
                
                if (!isset($invoiceOutstandingSums[$month])) {
                    $invoiceOutstandingSums[$month] = 0;
                }
                $invoiceOutstandingSums[$month] += $invoiceOutstanding;
                
                if (!isset($invoicePaymentSums[$month])) {
                    $invoicePaymentSums[$month] = 0;
                }
                $invoicePaymentSums[$month] += $invoicePayment;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceOutstandingSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoicePaymentSum);
            $columnCounter++;
            
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:AM{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:AM{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("B{$counter}", 'TOTAL');
        
        $grandTotalInvoice = 0;
        $grandTotalOutstanding = 0;
        $grandTotalPayment = 0;
        
        $columnCounter = 'C';
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($invoiceTotalSums[$month])) {
                $invoiceTotalSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSums[$month]);
            $columnCounter++;
            
            if (!isset($invoiceOutstandingSums[$month])) {
                $invoiceOutstandingSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceOutstandingSums[$month]);
            $columnCounter++;
            
            if (!isset($invoicePaymentSums[$month])) {
                $invoicePaymentSums[$month] = 0;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoicePaymentSums[$month]);
            $columnCounter++;
            
            $grandTotalInvoice += $invoiceTotalSums[$month];
            $grandTotalOutstanding += $invoiceOutstandingSums[$month];
            $grandTotalPayment += $invoicePaymentSums[$month];
        }
        
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalInvoice);
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotalOutstanding);
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
}