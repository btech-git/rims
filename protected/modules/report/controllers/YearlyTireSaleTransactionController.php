<?php

class YearlyTireSaleTransactionController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleTireDailyReport'))) {
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
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $subCategoryId = (isset($_GET['SubCategoryId'])) ? $_GET['SubCategoryId'] : '';
        $subMasterCategoryId = (isset($_GET['SubMasterCategoryId'])) ? $_GET['SubMasterCategoryId'] : '';
        
        $yearlyTireSaleTransactionReportData = array();
        $yearlyTireSaleTransactionReport = InvoiceDetail::getYearlyTireSaleTransactionReport($year, $productId, $productCode, $productName, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $subCategoryId, $subMasterCategoryId);
        foreach ($yearlyTireSaleTransactionReport as $reportItem) {
            $monthValue = intval($reportItem['invoice_month']);
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['product_id'] = $reportItem['product_id'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['product_name'] = $reportItem['product_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['product_code'] = $reportItem['product_code'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['brand_name'] = $reportItem['brand_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['sub_brand_name'] = $reportItem['sub_brand_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['sub_brand_series_name'] = $reportItem['sub_brand_series_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['master_category_name'] = $reportItem['master_category_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['sub_category_name'] = $reportItem['sub_category_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['sub_master_category_name'] = $reportItem['sub_master_category_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['tire_name'] = $reportItem['tire_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['unit_name'] = $reportItem['unit_name'];
            $yearlyTireSaleTransactionReportData[$reportItem['product_id']]['totals'][$monthValue] = $reportItem['total_quantity'];
        }

        $productIds = array_map(function($reportItem) { return $reportItem['product_id']; }, $yearlyTireSaleTransactionReport);
        
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
            $this->saveToExcel($yearlyTireSaleTransactionReportData, $inventoryCurrentStockData, $year, $yearNow, $monthNow);
        }
        
        $this->render('summary', array(
            'yearlyTireSaleTransactionReportData' => $yearlyTireSaleTransactionReportData,
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
            'subCategoryId' => $subCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
        ));
    }
    
    public function actionTransactionInfo($productId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceDetail::model()->searchByTransactionInfo($productId, $startDate, $endDate, $branchId, $page);
        $product = Product::model()->findByPk($productId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'product' => $product,
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

    protected function saveToExcel($yearlyTireSaleTransactionReportData, $inventoryCurrentStockData, $year, $yearNow, $monthNow) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Ban Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Ban Tahunan');

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Penjualan Ban Tahunan');
        $worksheet->setCellValue('A3', $year);

        $maxMonthNum = (int) $year === (int) $yearNow ? $monthNow : 12;
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
        
        $worksheet->setCellValue("A5", 'No');
        $worksheet->setCellValue("B5", 'ID');
        $worksheet->setCellValue("C5", 'Code');
        $worksheet->setCellValue("D5", 'Name');
        $worksheet->setCellValue("E5", 'Ukuran');
        $worksheet->setCellValue("F5", 'Brand');
        $worksheet->setCellValue("G5", 'Category');
        $worksheet->setCellValue("H5", 'Satuan');
        $columnCounter = 'I';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}5", $monthList[$month]);
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Rata2');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Min');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Max');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Median');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Klasifikasi');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Stock');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Min');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Target');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Order Plan');
        
        $counter = 6;
        $ordinal = 0;
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A1:{$columnCounter}5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:{$columnCounter}5")->getFont()->setBold(true);

        foreach ($yearlyTireSaleTransactionReportData as $productId => $yearlyTireSaleTransactionReportDataItem) {
            $product = Product::model()->findByPk($productId);

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", CHtml::value($product, 'id'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($product, 'manufacturer_code'));
            $worksheet->setCellValue("D{$counter}", $yearlyTireSaleTransactionReportDataItem['product_name']);
            $worksheet->setCellValue("E{$counter}", CHtml::value($product, 'oilSae.oilName'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($product, 'brand.name') . ' - ' . CHtml::value($product, 'subBrand.name') . ' - ' . CHtml::value($product, 'subBrandSeries.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($product, 'productMasterCategory.name') . ' - ' . CHtml::value($product, 'productSubMasterCategory.name') . ' - ' . CHtml::value($product, 'productSubCategory.name'));
            $worksheet->setCellValue("H{$counter}", $product->unit->name);
            
            $invoiceTotals = array();
            $columnCounter = 'I';
            for ($month = 1; $month <= 12; $month++) {
                $invoiceTotal = isset($yearlyTireSaleTransactionReportDataItem['totals'][$month]) ? $yearlyTireSaleTransactionReportDataItem['totals'][$month] : '0.00';
                
                if ($month <= $maxMonthNum) {
                    $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal);
                } else {
                    $worksheet->setCellValue("{$columnCounter}{$counter}", '');
                }
                
                $invoiceTotals[] = $invoiceTotal;
                $columnCounter++;
            }
            
            $invoiceTotalSum = array_sum($invoiceTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum);
            $columnCounter++;
            $invoiceMean = ($invoiceTotalSum / $maxMonthNum);
            $worksheet->setCellValue("{$columnCounter}{$counter}", round($invoiceMean, 2));
            $columnCounter++;
            $invoiceMinAmount = min($invoiceTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceMinAmount);
            $columnCounter++;
            $invoiceMaxAmount = max($invoiceTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceMaxAmount);
            $columnCounter++;
            sort($invoiceTotals);
            $invoiceMedian = ($invoiceTotals[5] + $invoiceTotals[6]) / 2;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceMedian);
            $columnCounter++;$columnCounter++;
            $quantityStock = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00';
            $worksheet->setCellValue("{$columnCounter}{$counter}", $quantityStock);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceMedian);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock - $quantityStock);
            $columnCounter++;
            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_ban_tahunan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}