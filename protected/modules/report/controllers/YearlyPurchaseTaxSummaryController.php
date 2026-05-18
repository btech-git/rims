<?php

class YearlyPurchaseTaxSummaryController extends Controller {

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
        
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $yearlyPurchaseSummary = TransactionReceiveItem::getYearlyPurchaseTaxSummary($year);
        
        $yearlyPurchaseSummaryData = array();
        foreach ($yearlyPurchaseSummary as $yearlyPurchaseSummaryItem) {
            $monthValue = intval(substr($yearlyPurchaseSummaryItem['year_month_value'], 4, 2));
            $yearlyPurchaseSummaryData[$monthValue][$yearlyPurchaseSummaryItem['main_branch_id']] = $yearlyPurchaseSummaryItem['total_price'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        $branches = Branch::model()->findAll();
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(
                $yearlyPurchaseSummaryData,
                $year
            );
        }
        
        $this->render('summary', array(
            'yearlyPurchaseSummaryData' => $yearlyPurchaseSummaryData,
            'yearList' => $yearList,
            'year' => $year,
            'branches' => $branches,
        ));
    }
    
    public function actionTransactionDetailInfo($year, $month, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = TransactionReceiveItem::model()->searchByTransactionDetailInfo($year, $month, $branchId, $page);
        $branch = Branch::model()->findByPk($branchId);
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionDetailInfo($dataProvider, $year, $month, $branch);
        }

        $this->render('transactionDetailInfo', array(
            'dataProvider' => $dataProvider,
            'year' => $year,
            'month' => $month,
            'branchId' => $branchId,
            'branch' => $branch,
        ));
    }

    protected function saveToExcel($yearlyPurchaseSummaryData, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Faktur Pembelian PPn');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Pembelian PPn');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Faktur Pembelian PPn Summary');
        $worksheet->setCellValue('A3', $year);
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
        $branches = Branch::model()->findAll();
        
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Bulan');
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}5", CHtml::value($branch, 'code'));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $amountTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", $monthList[$month]);
            $amountSum = '0.00';
            $columnCounter = 'B';
            foreach ($branches as $branch) {
                $amount = isset($yearlyPurchaseSummaryData[$month][$branch->id]) ? $yearlyPurchaseSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $amount);
                $amountSum += $amount;
                if (!isset($amountTotals[$branch->id])) {
                    $amountTotals[$branch->id] = '0.00';
                }
                $amountTotals[$branch->id] += $amount;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", $amountSum);

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
                
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotal = '0.00';
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", $amountTotals[$branch->id]);
            $grandTotal += $amountTotals[$branch->id];
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", $grandTotal);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=faktur_pembelian_ppn_summary_" . $year . ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    protected function saveToExcelTransactionDetailInfo($dataProvider, $year, $month, $branch) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Pembelian PPn');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Pembelian PPn');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Transaksi Detail Pembelian PPn');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:H5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'PO #');
        $worksheet->setCellValue('B5', 'Tanggal PO');
        $worksheet->setCellValue('C5', 'Penerimaan #');
        $worksheet->setCellValue('D5', 'Tanggal Penerimaan');
        $worksheet->setCellValue('E5', 'Invoice #');
        $worksheet->setCellValue('F5', 'Tanggal Invoice');
        $worksheet->setCellValue('G5', 'Supplier');
        $worksheet->setCellValue('H5', 'Total');

        $worksheet->getStyle('A5:H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $totalSum = '0.00';
        foreach ($dataProvider->data as $header) {
            $totalAmount = CHtml::value($header, 'invoice_grand_total');
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'purchaseOrder.purchase_order_no'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'purchaseOrder.purchase_order_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'receive_item_no'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'receive_item_date'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'supplier.name'));
            $worksheet->setCellValue("H{$counter}", $totalAmount);
            
            $totalSum += $totalAmount;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
                
        $worksheet->setCellValue("G{$counter}", 'TOTAL');
        $worksheet->setCellValue("H{$counter}", $totalSum);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=transaksi_pembelian_ppn_summary.xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}