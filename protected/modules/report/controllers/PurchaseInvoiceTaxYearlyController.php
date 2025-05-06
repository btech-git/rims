<?php

class PurchaseInvoiceTaxYearlyController extends Controller {

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
        
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        
        $yearlyPurchaseSummary = TransactionReceiveItem::getPurchaseInvoiceTaxYearlyReport($year, $branchId);
        
        $yearlyPurchaseQuantityOrderData = array();
        $yearlyPurchaseQuantityInvoiceData = array();
        $yearlyPurchaseSubTotalData = array();
        $yearlyPurchaseTotalTaxData = array();
        $yearlyPurchaseSummaryItem = array();
        foreach ($yearlyPurchaseSummary as $yearlyPurchaseSummaryItem) {
            $monthValue = intval(substr($yearlyPurchaseSummaryItem['year_month_value'], 4, 2));
            $yearlyPurchaseTotalPriceData[$monthValue] = $yearlyPurchaseSummaryItem['total_price'];
            $yearlyPurchaseQuantityOrderData[$monthValue] = $yearlyPurchaseSummaryItem['quantity_order'];
            $yearlyPurchaseQuantityInvoiceData[$monthValue] = $yearlyPurchaseSummaryItem['quantity_invoice'];
            $yearlyPurchaseSubTotalData[$monthValue] = $yearlyPurchaseSummaryItem['sub_total'];
            $yearlyPurchaseTotalTaxData[$monthValue] = $yearlyPurchaseSummaryItem['total_tax'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(
                $yearlyPurchaseTotalPriceData,
                $yearlyPurchaseQuantityInvoiceData,
                $yearlyPurchaseSubTotalData,
                $yearlyPurchaseTotalTaxData,
                $branchId,
                $year
            );
        }
        
        $this->render('summary', array(
            'yearlyPurchaseTotalPriceData' => $yearlyPurchaseTotalPriceData,
            'yearlyPurchaseQuantityOrderData' => $yearlyPurchaseQuantityOrderData,
            'yearlyPurchaseQuantityInvoiceData' => $yearlyPurchaseQuantityInvoiceData,
            'yearlyPurchaseSubTotalData' => $yearlyPurchaseSubTotalData,
            'yearlyPurchaseTotalTaxData' => $yearlyPurchaseTotalTaxData,
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
        ));
    }
    
    public function actionDetail($month, $year, $branchId) {
        
        $receiveItem = Search::bind(new TransactionReceiveItem('search'), isset($_GET['TransactionReceiveItem']) ? $_GET['TransactionReceiveItem'] : array());

        $purchaseInvoiceSummary = $receiveItem->searchByReport();
        $purchaseInvoiceSummary->criteria->compare('t.recipient_branch_id', $branchId);
        $purchaseInvoiceSummary->criteria->addCondition('YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND t.user_id_cancelled IS NULL AND t.invoice_tax_nominal > 0');
        $purchaseInvoiceSummary->criteria->params = array(':month' => $month, ':year' => $year);
        
        $this->render('detail', array(
            'purchaseInvoiceSummary' => $purchaseInvoiceSummary,
            'year' => $year,
            'month' => $month,
        ));
    }
    
    protected function saveToExcel($yearlyPurchaseTotalPriceData, $yearlyPurchaseQuantityInvoiceData,$yearlyPurchaseSubTotalData, $yearlyPurchaseTotalTaxData, $branchId, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        $branch = Branch::model()->findByPk($branchId);

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Pembelian Ppn  Recap Tahun');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian Ppn  Recap Tahun');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Ppn  Recap Tahun');
        $worksheet->setCellValue('A3', $year . ' ' . empty($branchId) ? 'All' : CHtml::encode(CHtml::value($branch, 'name')));
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
        
        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Bulan');
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
        for ($month = 1; $month <= 12; $month++) {
            $quantityInvoice = isset($yearlyPurchaseQuantityInvoiceData[$month]) ? $yearlyPurchaseQuantityInvoiceData[$month] : '0.00';
            $subTotal = isset($yearlyPurchaseSubTotalData[$month]) ? $yearlyPurchaseSubTotalData[$month] : '0.00';
            $totalTax = isset($yearlyPurchaseTotalTaxData[$month]) ? $yearlyPurchaseTotalTaxData[$month] : '0.00';
            $totalPrice = isset($yearlyPurchaseTotalPriceData[$month]) ? $yearlyPurchaseTotalPriceData[$month] : '0.00';
            
            $worksheet->getStyle("E{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $monthList[$month]);
            $worksheet->setCellValue("B{$counter}", $quantityInvoice);
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
        header('Content-Disposition: attachment;filename="Laporan Pembelian Ppn  Recap Tahun.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}