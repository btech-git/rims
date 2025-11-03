<?php

class YearlyMaterialServiceUsageController extends Controller {

    public function filters() {
        return array(
            'access',
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
        $monthNow = date('m');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $masterCategoryId = (isset($_GET['MasterCategoryId'])) ? $_GET['MasterCategoryId'] : '';
        $subCategoryId = (isset($_GET['SubCategoryId'])) ? $_GET['SubCategoryId'] : '';
        $subMasterCategoryId = (isset($_GET['SubMasterCategoryId'])) ? $_GET['SubMasterCategoryId'] : '';
        
        $yearlyMaterialServiceUsageReportData = array();
        $yearlyMaterialServiceUsageReport = MaterialRequestDetail::getYearlyMaterialServiceUsageReport($year, $productId, $productCode, $productName, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $masterCategoryId, $subCategoryId, $subMasterCategoryId);
        foreach ($yearlyMaterialServiceUsageReport as $reportItem) {
            $monthValue = intval($reportItem['material_month']);
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['product_id'] = $reportItem['product_id'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['product_name'] = $reportItem['product_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['product_code'] = $reportItem['product_code'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['brand_name'] = $reportItem['brand_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['sub_brand_name'] = $reportItem['sub_brand_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['sub_brand_series_name'] = $reportItem['sub_brand_series_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['master_category_name'] = $reportItem['master_category_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['sub_category_name'] = $reportItem['sub_category_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['sub_master_category_name'] = $reportItem['sub_master_category_name'];
            $yearlyMaterialServiceUsageReportData[$reportItem['product_id']]['totals'][$monthValue] = $reportItem['total_quantity'];
        }

        
        $productIds = array_map(function($reportItem) { return $reportItem['product_id']; }, $yearlyMaterialServiceUsageReport);
        
        $inventoryCurrentStocks = InventoryDetail::getInventoryCurrentStocks($productIds, $branchId);
        
        $inventoryCurrentStockData = array();
        foreach ($inventoryCurrentStocks as $inventoryCurrentStockItem) {
            $inventoryCurrentStockData[$inventoryCurrentStockItem['product_id']] = $inventoryCurrentStockItem['total_stock'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($yearlyMaterialServiceUsageReportData, $inventoryCurrentStockData, $year, $yearNow, $monthNow);
        }
        
        $this->render('summary', array(
            'yearlyMaterialServiceUsageReportData' => $yearlyMaterialServiceUsageReportData,
            'inventoryCurrentStockData' => $inventoryCurrentStockData,
            'yearList' => $yearList,
            'year' => $year,
            'yearNow' => $yearNow,
            'monthNow' => $monthNow,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'branchId' => $branchId,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'masterCategoryId' => $masterCategoryId,
            'subCategoryId' => $subCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
        ));
    }
    
    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
            $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
            $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $masterCategoryId = isset($_GET['MasterCategoryId']) ? $_GET['MasterCategoryId'] : '';
            $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'masterCategoryId' => $masterCategoryId,
                'subMasterCategoryId' => $subMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subMasterCategoryId = isset($_GET['SubMasterCategoryId']) ? $_GET['SubMasterCategoryId'] : '';
            $subCategoryId = isset($_GET['SubCategoryId']) ? $_GET['SubCategoryId'] : '';

            $this->renderPartial('_productSubCategorySelect', array(
                'subMasterCategoryId' => $subMasterCategoryId,
                'subCategoryId' => $subCategoryId,
            ));
        }
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
        $columnCounter = 'G';
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

        $counter = 7;
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
            
            $materialTotals = array();
            $columnCounter = 'G';
            
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

        for ($col = 'A'; $col !== 'AB'; $col++) {
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