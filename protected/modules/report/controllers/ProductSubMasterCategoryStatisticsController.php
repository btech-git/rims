<?php

class ProductSubMasterCategoryStatisticsController extends Controller {

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
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
        $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = isset($_GET['SubBrandSeriesId']) ? $_GET['SubBrandSeriesId'] : '';
        $masterCategoryId = isset($_GET['MasterCategoryId']) ? $_GET['MasterCategoryId'] : '';
        $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';
        $subCategoryId = isset($_GET['SubCategoryId']) ? $_GET['SubCategoryId'] : '';
        
        $yearlyStatisticsData = InvoiceDetail::getYearlyStatisticsData($year, $branchId, $masterCategoryId, $subMasterCategoryId, $subCategoryId, $brandId, $subBrandId, $subBrandSeriesId);
        
        $yearlyStatistics = array();
        foreach ($yearlyStatisticsData as $yearlyStatisticsDataItem) {
            $sortedQuantities = explode(',', $yearlyStatisticsDataItem['quantities']);
            sort($sortedQuantities, SORT_NUMERIC);
            $sortedQuantitiesCount = count($sortedQuantities);
            $quantitiesMiddleBottomIndex = ceil($sortedQuantitiesCount / 2);
            $quantitiesMiddleTopIndex = ceil(($sortedQuantitiesCount + 1) / 2);
            $quantitiesMedian = ($sortedQuantities[$quantitiesMiddleBottomIndex - 1] + $sortedQuantities[$quantitiesMiddleTopIndex - 1]) / 2;
            $sortedQuantitiesSum = array_sum($sortedQuantities);
            $quantitiesMean = $sortedQuantitiesSum / $sortedQuantitiesCount;
            
            $sortedTotalPrices = explode(',', $yearlyStatisticsDataItem['total_prices']);
            sort($sortedTotalPrices, SORT_NUMERIC);
            $sortedTotalPricesCount = count($sortedTotalPrices);
            $totalPricesMiddleBottomIndex = ceil($sortedTotalPricesCount / 2);
            $totalPricesMiddleTopIndex = ceil(($sortedTotalPricesCount + 1) / 2);
            $totalPricesMedian = ($sortedTotalPrices[$totalPricesMiddleBottomIndex - 1] + $sortedTotalPrices[$totalPricesMiddleTopIndex - 1]) / 2;
            $sortedTotalPricesSum = array_sum($sortedTotalPrices);
            $totalPricesMean = $sortedTotalPricesSum / $sortedTotalPricesCount;
            
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['name'] = $yearlyStatisticsDataItem['product_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']][$yearlyStatisticsDataItem['invoice_month']]['quantityMean'] = $quantitiesMean;
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']][$yearlyStatisticsDataItem['invoice_month']]['quantityMedian'] = $quantitiesMedian;
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']][$yearlyStatisticsDataItem['invoice_month']]['totalPriceMean'] = $totalPricesMean;
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']][$yearlyStatisticsDataItem['invoice_month']]['totalPriceMedian'] = $totalPricesMedian;
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
                $yearList,
                $year
            );
        }
        
        $this->render('summary', array(
            'yearlyStatistics' => $yearlyStatistics,
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'masterCategoryId' => $masterCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
            'subCategoryId' => $subCategoryId,
        ));
    }
    
    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $masterCategoryId = isset($_GET['MasterCategoryId']) ? $_GET['MasterCategoryId'] : '';

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'masterCategoryId' => $masterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';

            $this->renderPartial('_productSubCategorySelect', array(
                'subMasterCategoryId' => $subMasterCategoryId,
            ));
        }
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
        $documentProperties->setTitle('Laporan Penjualan Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penjualan Tahunan');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');

        $worksheet->getStyle('A1:Q5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Tahunan');
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
        
        $worksheet->getStyle('A5:Q5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Bulan');
        $columnCounter = 'B';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}5", CHtml::encode(CHtml::value($branch, 'code')));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');

        $worksheet->getStyle('A5:Q5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

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
        header('Content-Disposition: attachment;filename="Laporan Penjualan Tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}