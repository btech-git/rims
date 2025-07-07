<?php

class SaleInvoiceCustomerTaxMonthlyController extends Controller {

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
        
        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        
        $monthlySaleSummary = InvoiceHeader::getSaleInvoiceCustomerTaxMonthlyReport($year, $month, $branchId);
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlySaleSummary, $month, $year);
        }
        
        $this->render('summary', array(
            'monthlySaleSummary' => $monthlySaleSummary,
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
            'branchId' => $branchId,
        ));
    }
    
    public function actionDetail($month, $year, $branchId, $customerId) {
        
        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());

        $saleInvoiceSummary = $invoiceHeader->searchByReport();
        $saleInvoiceSummary->criteria->compare('t.branch_id', $branchId);
        $saleInvoiceSummary->criteria->addCondition('t.customer_id = :customer_id AND t.status NOT LIKE "%CANCELLED%" AND t.tax_percentage > 0 AND YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month');
        $saleInvoiceSummary->criteria->params = array(':month' => $month, ':year' => $year, ':customer_id' => $customerId);
        
        $this->render('detail', array(
            'saleInvoiceSummary' => $saleInvoiceSummary,
        ));
    }
    
    protected function saveToExcel($monthlySaleSummary, $month, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Ppn  Recap Bulan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Ppn  Recap Bulan');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Ppn  Recap Bulan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Customer');
        $worksheet->setCellValue('B5', '# INV');
        $worksheet->setCellValue('C5', '# FP');
        $worksheet->setCellValue('D5', '# Bupot');
        $worksheet->setCellValue('E5', 'Parts (Rp)');
        $worksheet->setCellValue('F5', 'Jasa (Rp)');
        $worksheet->setCellValue('G5', 'Total DPP');
        $worksheet->setCellValue('H5', 'Total PPn');
        $worksheet->setCellValue('I5', 'Total PPh');
        $worksheet->setCellValue('J5', 'Total Invoice');
        $worksheet->getStyle('A6:J6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $sumSubTotal = '0.00';
        $sumTotalTax = '0.00';
        $sumTotalTaxIncome = '0.00';
        $sumGrandTotal = '0.00';
        foreach ($monthlySaleSummary as $monthlySaleSummaryItem) {
            $subTotal = $monthlySaleSummaryItem['sub_total'];
            $totalTax = $monthlySaleSummaryItem['total_tax'];
            $totalTaxIncome = $monthlySaleSummaryItem['total_tax_income'];
            $totalPrice = $monthlySaleSummaryItem['total_price'];
            
            $worksheet->getStyle("E{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $monthlySaleSummaryItem['customer_name']);
            $worksheet->setCellValue("B{$counter}", $monthlySaleSummaryItem['quantity_invoice']);
            $worksheet->setCellValue("E{$counter}", $monthlySaleSummaryItem['product_price']);
            $worksheet->setCellValue("F{$counter}", $monthlySaleSummaryItem['service_price']);
            $worksheet->setCellValue("G{$counter}", $subTotal);
            $worksheet->setCellValue("H{$counter}", $totalTax);
            $worksheet->setCellValue("I{$counter}", $totalTaxIncome);
            $worksheet->setCellValue("J{$counter}", $totalPrice);

            $sumSubTotal += $subTotal;
            $sumTotalTax += $totalTax;
            $sumTotalTaxIncome += $totalTaxIncome;
            $sumGrandTotal += $totalPrice;
            
            $counter++;
        }
        $worksheet->setCellValue("F{$counter}", 'TOTAL');
        $worksheet->setCellValue("G{$counter}", $sumSubTotal);
        $worksheet->setCellValue("H{$counter}", $sumTotalTax);
        $worksheet->setCellValue("I{$counter}", $sumTotalTaxIncome);
        $worksheet->setCellValue("J{$counter}", $sumGrandTotal);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=laporan_penjualan_ppn_recap_" . strftime("%B",mktime(0,0,0,$month)) . '_' . $year . ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}