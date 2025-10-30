<?php

class ProductSubMasterCategoryStatisticsController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('productCategoryStatisticsReport'))) {
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
            
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['code'] = $yearlyStatisticsDataItem['product_code'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['name'] = $yearlyStatisticsDataItem['product_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['master_category'] = $yearlyStatisticsDataItem['master_category_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['sub_master_category'] = $yearlyStatisticsDataItem['sub_master_category_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['sub_category'] = $yearlyStatisticsDataItem['sub_category_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['brand'] = $yearlyStatisticsDataItem['brand_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['sub_brand'] = $yearlyStatisticsDataItem['sub_brand_name'];
            $yearlyStatistics[$yearlyStatisticsDataItem['product_id']]['sub_brand_series'] = $yearlyStatisticsDataItem['sub_brand_series_name'];
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
            $this->saveToExcel($yearlyStatistics, $year);
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

    protected function saveToExcel($yearlyStatistics, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Statistik Penjualan Parts');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Statistik Penjualan Parts');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');

        $worksheet->getStyle('A1:Z6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Z6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Statistik Penjualan Parts');
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

        $columnCounter = 'F';
        $mergeColumnCounter = 'I';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->mergeCells("{$columnCounter}5:{$mergeColumnCounter}5");
            $worksheet->setCellValue("{$columnCounter}5", $monthList[$month]);
            $columnCounter++;$columnCounter++;$columnCounter++;$columnCounter++;
            $mergeColumnCounter++;$mergeColumnCounter++;$mergeColumnCounter++;$mergeColumnCounter++;
        }
        
        $columnCounter = 'F';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}6", 'Qty Mean');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Qty Median');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Price Mean');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Price Median');
            $columnCounter++;
        }
        
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $ordinalNumber = 0;
        $counter = 8;
        
        foreach ($yearlyStatistics as $id => $yearlyStatisticsItem) {
            $worksheet->setCellValue("A{$counter}", ++$ordinalNumber);
            $worksheet->setCellValue("B{$counter}", $yearlyStatisticsItem['code']);
            $worksheet->setCellValue("C{$counter}", $yearlyStatisticsItem['name']);
            $worksheet->setCellValue("D{$counter}", $yearlyStatisticsItem['brand'] . ' - ' .$yearlyStatisticsItem['sub_brand'] . ' - ' . $yearlyStatisticsItem['sub_brand_series']);
            $worksheet->setCellValue("E{$counter}", $yearlyStatisticsItem['master_category'] . ' - ' .$yearlyStatisticsItem['sub_master_category'] . ' - ' . $yearlyStatisticsItem['sub_category']);
            $columnCounter = 'F';
            
            for ($month = 1; $month <= 12; $month++) {
                if (isset($yearlyStatisticsItem[$month])) {
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $yearlyStatisticsItem[$month]['quantityMean']);
                    $columnCounter++;
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $yearlyStatisticsItem[$month]['quantityMedian']);
                    $columnCounter++;
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $yearlyStatisticsItem[$month]['totalPriceMean']);
                    $columnCounter++;
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $yearlyStatisticsItem[$month]['totalPriceMedian']);
                    $columnCounter++;                    
                }
            }
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="statistik_penjualan_parts.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}