<?php

class WorkingSheetController extends Controller {

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('yearlyMaterialServiceUsageReport'))) {
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
        
        $startDate = $year . '-01-01';
        $endDate = $year . '-12-31';
        
        $coas = Coa::model()->findAll(array(
            'with' => 'coaSubCategory', 
            'condition' => 'coaSubCategory.cashflow_position IS NOT NULL', 
            'order' => 'coaSubCategory.cashflow_position ASC, t.code ASC',
        )); 
        
        $coaIds = array_map(function($coa) { return $coa->id; }, $coas);
        $workingSheetBeginningBalances = JurnalUmum::getWorkingSheetBeginningBalances($coaIds, $startDate);
        $workingSheetBalances = JurnalUmum::getWorkingSheetBalances($coaIds, $startDate, $endDate);
        
        $workingSheetReportData = array();
        
        foreach ($workingSheetBeginningBalances as $workingSheetBeginningBalanceItem) {
            $workingSheetReportData[$workingSheetBeginningBalanceItem['coa_id']]['beginning_balance'] = $workingSheetBeginningBalanceItem['beginning_balance'];
        }
        
        foreach ($workingSheetBalances as $workingSheetBalanceItem) {
            $workingSheetReportData[$workingSheetBalanceItem['coa_id']]['debit_total'] = $workingSheetBalanceItem['debit_total'];
            $workingSheetReportData[$workingSheetBalanceItem['coa_id']]['credit_total'] = $workingSheetBalanceItem['credit_total'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($workingSheetReportData, $inventoryCurrentStockData, $year, $yearNow, $monthNow);
//        }
        
        $this->render('summary', array(
            'workingSheetReportData' => $workingSheetReportData,
            'yearList' => $yearList,
            'year' => $year,
            'yearNow' => $yearNow,
            'coas' => $coas,
        ));
    }
    
    protected function saveToExcel($yearlyMaterialServiceUsageReportData, $inventoryCurrentStockData, $year, $yearNow, $monthNow) {
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
        $documentProperties->setTitle('Pemakaian Material Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pemakaian Material Tahunan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->getStyle('A1:AZ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AZ6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Pemakaian Material Tahunan');
        $worksheet->setCellValue('A3', 'Periode Tahun: ' . $year);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Code');
        $worksheet->setCellValue('D5', 'Name');
        $worksheet->setCellValue('E5', 'Brand');
        $worksheet->setCellValue('F5', 'Category');
        $worksheet->setCellValue('G5', 'Satuan');
        $columnCounter = 'H';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}5", $monthList[$month]);
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Rata2 per Bulan');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Pakai Min');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Pakai Max');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Pakai Median');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Posisi Stok');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Minimum Stok');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Target Stok');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Stock Order Plan');
        $columnCounter++;
        
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $ordinal = 0;
        
        $maxMonthNum = (int) $year === (int) $yearNow ? $monthNow : 12;
        foreach ($yearlyMaterialServiceUsageReportData as $productId => $yearlyMaterialServiceUsageReportDataItem) {
            $worksheet->getStyle("G{$counter}:Z{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", $yearlyMaterialServiceUsageReportDataItem['product_id']);
            $worksheet->setCellValue("C{$counter}", $yearlyMaterialServiceUsageReportDataItem['product_code']);
            $worksheet->setCellValue("D{$counter}", $yearlyMaterialServiceUsageReportDataItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $yearlyMaterialServiceUsageReportDataItem['brand_name'] . ' - ' . $yearlyMaterialServiceUsageReportDataItem['sub_brand_name'] . ' - ' . $yearlyMaterialServiceUsageReportDataItem['sub_brand_series_name']);
            $worksheet->setCellValue("F{$counter}", $yearlyMaterialServiceUsageReportDataItem['master_category_name'] . ' - ' . $yearlyMaterialServiceUsageReportDataItem['sub_master_category_name'] . ' - ' . $yearlyMaterialServiceUsageReportDataItem['sub_category_name']);
            $worksheet->setCellValue("G{$counter}", $yearlyMaterialServiceUsageReportDataItem['unit_name']);
            
            $materialTotals = array();
            $columnCounter = 'H';
            
            for ($month = 1; $month <= 12; $month++) {
                $materialTotal = isset($yearlyMaterialServiceUsageReportDataItem['totals'][$month]) ? $yearlyMaterialServiceUsageReportDataItem['totals'][$month] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $month <= $maxMonthNum ? $materialTotal : '');
                $columnCounter++;
                $materialTotals[] = $materialTotal;
            }
            $materialTotalSum = array_sum($materialTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $materialTotalSum);
            $columnCounter++;
            $materialMean = $materialTotalSum / $maxMonthNum;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $materialMean);
            $columnCounter++;
            $materialMinAmount = min($materialTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $materialMinAmount);
            $columnCounter++;
            $materialMaxAmount = max($materialTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $materialMaxAmount);
            $columnCounter++;
            sort($materialTotals);
            $materialMedian = ($materialTotals[5] + $materialTotals[6]) / 2; 
            $worksheet->setCellValue("{$columnCounter}{$counter}", $materialMedian);
            $columnCounter++;
            $quantityStock = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00';
            $worksheet->setCellValue("{$columnCounter}{$counter}", $quantityStock);
            $columnCounter++;
            $product = Product::model()->findByPk($productId);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", round($materialMedian, 0));
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock - $quantityStock);
            $columnCounter++;
            
            $counter++;
        }

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="pemakaian_material_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}