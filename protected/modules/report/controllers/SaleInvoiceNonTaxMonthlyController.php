<?php

class SaleInvoiceNonTaxMonthlyController extends Controller {

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
        
        $monthlySaleSummary = InvoiceHeader::getSaleInvoiceNonTaxMonthlyReport($year, $month, $branchId);
        
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
        $documentProperties->setTitle('Penjualan Non PPn Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Non PPn Bulanan');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Faktur Penjualan Non PPn Rekap Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Customer');
        $worksheet->setCellValue('C5', '# INV');
        $worksheet->setCellValue('D5', '# FP');
        $worksheet->setCellValue('E5', '# Bupot');
        $worksheet->setCellValue('F5', 'Parts (Rp)');
        $worksheet->setCellValue('G5', 'Jasa (Rp)');
        $worksheet->setCellValue('H5', 'Total DPP');
        $worksheet->setCellValue('I5', 'Total PPn');
        $worksheet->setCellValue('J5', 'Total PPh');
        $worksheet->setCellValue('K5', 'Total Invoice');
        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $sumProductPrice = '0.00';
        $sumServicePrice = '0.00';
        $sumSubTotal = '0.00';
        $sumTotalTax = '0.00';
        $sumTotalTaxIncome = '0.00';
        $sumGrandTotal = '0.00';
        foreach ($monthlySaleSummary as $i => $monthlySaleSummaryItem) {
            $productPrice = $monthlySaleSummaryItem['product_price'];
            $servicePrice = $monthlySaleSummaryItem['service_price'];
            $subTotal = $monthlySaleSummaryItem['sub_total'];
            $totalTax = $monthlySaleSummaryItem['total_tax'];
            $totalTaxIncome = $monthlySaleSummaryItem['total_tax_income'];
            $totalPrice = $monthlySaleSummaryItem['total_price'];
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $monthlySaleSummaryItem['customer_name']);
            $worksheet->setCellValue("C{$counter}", $monthlySaleSummaryItem['quantity_invoice']);
            $worksheet->setCellValue("F{$counter}", $productPrice);
            $worksheet->setCellValue("G{$counter}", $servicePrice);
            $worksheet->setCellValue("H{$counter}", $subTotal);
            $worksheet->setCellValue("I{$counter}", $totalTax);
            $worksheet->setCellValue("J{$counter}", $totalTaxIncome);
            $worksheet->setCellValue("K{$counter}", $totalPrice);

            $sumProductPrice += $productPrice;
            $sumServicePrice += $servicePrice;
            $sumSubTotal += $subTotal;
            $sumTotalTax += $totalTax;
            $sumTotalTaxIncome += $totalTaxIncome;
            $sumGrandTotal += $totalPrice;
            
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("E{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $sumProductPrice);
        $worksheet->setCellValue("G{$counter}", $sumServicePrice);
        $worksheet->setCellValue("H{$counter}", $sumSubTotal);
        $worksheet->setCellValue("I{$counter}", $sumTotalTax);
        $worksheet->setCellValue("J{$counter}", $sumTotalTaxIncome);
        $worksheet->setCellValue("K{$counter}", $sumGrandTotal);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=faktur_penjualan_non_ppn_rekap_" . strftime("%B",mktime(0,0,0,$month)) . '_' . $year . ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}