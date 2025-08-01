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
            $yearlyPurchaseSummaryData[$monthValue][$yearlyPurchaseSummaryItem['recipient_branch_id']] = $yearlyPurchaseSummaryItem['total_price'];
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
                $yearList,
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
    
    protected function saveToExcel($yearlyPurchaseSummaryData, $yearList, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pembelian Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian Tahunan');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Tahunan');
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
            $worksheet->setCellValue("{$columnCounter}5", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');

        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $amountTotals = array();
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($monthList[$month]));
            $amountSum = '0.00';
            $columnCounter = 'B';
            foreach ($branches as $branch) {
                $amount = isset($yearlyPurchaseSummaryData[$month][$branch->id]) ? $yearlyPurchaseSummaryData[$month][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amount));
                $amountSum += $amount;
                if (!isset($amountTotals[$branch->id])) {
                    $amountTotals[$branch->id] = '0.00';
                }
                $amountTotals[$branch->id] += $amount;
                $columnCounter++;
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountSum));

            $counter++;
        }
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $grandTotal = '0.00';
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($amountTotals[$branch->id]));
            $grandTotal += $amountTotals[$branch->id];
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($grandTotal));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=laporan_pembelian_ppn_summary_" . $year . ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}