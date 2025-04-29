<?php

class PurchaseInvoiceSupplierTaxMonthlyController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
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
        
        $monthlyPurchaseSummary = TransactionReceiveItem::getPurchaseInvoiceSupplierTaxMonthlyReport($year, $month, $branchId);
        
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
    
    protected function saveToExcel($monthlyPurchaseSummary, $month, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Pembelian Ppn  Recap Bulan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian Ppn  Recap Bulan');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Ppn  Recap Bulan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Supplier');
        $worksheet->setCellValue('B5', '# INV');
        $worksheet->setCellValue('C5', '# FP');
        $worksheet->setCellValue('D5', '# Bupot');
        $worksheet->setCellValue('E5', 'Total DPP');
        $worksheet->setCellValue('F5', 'Total PPn');
        $worksheet->setCellValue('G5', 'Total Invoice');
        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $sumSubTotal = '0.00';
        $sumTotalTax = '0.00';
        $sumGrandTotal = '0.00';
        foreach ($monthlyPurchaseSummary as $monthlyPurchaseSummaryItem) {
            $subTotal = $monthlyPurchaseSummaryItem['sub_total'];
            $totalTax = $monthlyPurchaseSummaryItem['total_tax'];
            $totalPrice = $monthlyPurchaseSummaryItem['total_price'];
            
            $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $monthlyPurchaseSummaryItem['supplier_name']);
            $worksheet->setCellValue("B{$counter}", $monthlyPurchaseSummaryItem['quantity_invoice']);
            $worksheet->setCellValue("E{$counter}", $subTotal);
            $worksheet->setCellValue("F{$counter}", $totalTax);
            $worksheet->setCellValue("G{$counter}", $totalPrice);

            $sumSubTotal += $subTotal;
            $sumTotalTax += $totalTax;
            $sumGrandTotal += $totalPrice;

            $counter++;
        }
        $worksheet->setCellValue("D{$counter}", 'TOTAL');
        $worksheet->setCellValue("E{$counter}", $sumSubTotal);
        $worksheet->setCellValue("F{$counter}", $sumTotalTax);
        $worksheet->setCellValue("G{$counter}", $sumGrandTotal);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian Ppn  Recap Bulan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}