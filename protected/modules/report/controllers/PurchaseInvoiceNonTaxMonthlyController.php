<?php

class PurchaseInvoiceNonTaxMonthlyController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseTaxReport'))) {
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
        
        $monthlyPurchaseSummary = TransactionReceiveItem::getPurchaseInvoiceNonTaxMonthlyReport($year, $month, $branchId);
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(
                $monthlyPurchaseSummary,
                $month,
                $year
            );
        }
        
        $this->render('summary', array(
            'monthlyPurchaseSummary' => $monthlyPurchaseSummary,
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
            'branchId' => $branchId,
        ));
    }
    
    public function actionDetail($month, $year, $branchId, $supplierId) {
        
        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());

        $purchaseInvoiceSummary = $receiveItem->searchByReport();
        $purchaseInvoiceSummary->criteria->compare('t.recipient_branch_id', $branchId);
        $purchaseInvoiceSummary->criteria->addCondition('t.supplier_id = :supplier_id AND YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND t.user_id_cancelled IS NULL AND t.invoice_tax_nominal > 0');
        $purchaseInvoiceSummary->criteria->params = array(':month' => $month, ':year' => $year, ':supplier_id' => $supplierId);
        
        $this->render('detail', array(
            'purchaseInvoiceSummary' => $purchaseInvoiceSummary,
            'year' => $year,
            'month' => $month,
        ));
    }
    
    protected function saveToExcel($monthlyPurchaseSummary, $month, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Pembelian NON Ppn Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian NON Ppn Bulanan');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Faktur Pembelian Non PPn  Rekap Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:H5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Supplier');
        $worksheet->setCellValue('C5', '# INV');
        $worksheet->setCellValue('D5', '# FP');
        $worksheet->setCellValue('E5', '# Bupot');
        $worksheet->setCellValue('F5', 'Total DPP');
        $worksheet->setCellValue('G5', 'Total PPn');
        $worksheet->setCellValue('H5', 'Total Invoice');
        $worksheet->getStyle('A5:H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $sumSubTotal = '0.00';
        $sumTotalTax = '0.00';
        $sumGrandTotal = '0.00';
        foreach ($monthlyPurchaseSummary as $i => $monthlyPurchaseSummaryItem) {
            $subTotal = $monthlyPurchaseSummaryItem['sub_total'];
            $totalTax = $monthlyPurchaseSummaryItem['total_tax'];
            $totalPrice = $monthlyPurchaseSummaryItem['total_price'];
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $monthlyPurchaseSummaryItem['supplier_name']);
            $worksheet->setCellValue("C{$counter}", $monthlyPurchaseSummaryItem['quantity_invoice']);
            $worksheet->setCellValue("F{$counter}", $subTotal);
            $worksheet->setCellValue("G{$counter}", $totalTax);
            $worksheet->setCellValue("H{$counter}", $totalPrice);

            $sumSubTotal += $subTotal;
            $sumTotalTax += $totalTax;
            $sumGrandTotal += $totalPrice;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("E{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $sumSubTotal);
        $worksheet->setCellValue("G{$counter}", $sumTotalTax);
        $worksheet->setCellValue("H{$counter}", $sumGrandTotal);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=faktur_pembelian_non_ppn_" . strftime("%B",mktime(0,0,0,$month)) . ' ' . $year. ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}