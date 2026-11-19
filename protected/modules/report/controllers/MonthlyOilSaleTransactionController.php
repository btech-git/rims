<?php

class MonthlyOilSaleTransactionController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail' || 
            $filterChain->action->id === 'redirectTransaction'
        ) {
            if (!(Yii::app()->user->checkAccess('saleOilDailyReport'))) {
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
        $month = (isset($_GET['Month'])) ? $_GET['Month'] : $monthNow;
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $subCategoryId = (isset($_GET['SubCategoryId'])) ? $_GET['SubCategoryId'] : '';
        $subMasterCategoryId = (isset($_GET['SubMasterCategoryId'])) ? $_GET['SubMasterCategoryId'] : '';
        $oilSaeId = isset($_GET['OilSaeId']) ? $_GET['OilSaeId'] : '';
        $convertToLitre = isset($_GET['ConvertToLitre']) ? $_GET['ConvertToLitre'] : '';
        
        $monthlyOilSaleTransactionReportData = array();
        $monthlyOilSaleTransactionReport = InvoiceDetail::getMonthlyOilSaleTransactionReport($year, $month, $productId, $productCode, $productName, $brandId, $subBrandId, $subBrandSeriesId, $subCategoryId, $subMasterCategoryId, $oilSaeId);
        foreach ($monthlyOilSaleTransactionReport as $reportItem) {
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['product_id'] = $reportItem['product_id'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['product_name'] = $reportItem['product_name'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['product_code'] = $reportItem['product_code'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['brand_name'] = $reportItem['brand_name'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['sub_brand_name'] = $reportItem['sub_brand_name'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['sub_brand_series_name'] = $reportItem['sub_brand_series_name'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['sub_category_name'] = $reportItem['sub_category_name'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['sub_master_category_name'] = $reportItem['sub_master_category_name'];
            $monthlyOilSaleTransactionReportData[$reportItem['product_id']]['totals'][$reportItem['branch_id']] = $reportItem['total_quantity'];
        }

        
        $productIds = array_map(function($reportItem) { return $reportItem['product_id']; }, $monthlyOilSaleTransactionReport);
        
        $inventoryAllBranchCurrentStocks = InventoryDetail::getInventoryAllBranchCurrentStocks($productIds);
        
        $inventoryAllBranchCurrentStockData = array();
        foreach ($inventoryAllBranchCurrentStocks as $inventoryAllBranchCurrentStockItem) {
            $inventoryAllBranchCurrentStockData[$inventoryAllBranchCurrentStockItem['product_id']][$inventoryAllBranchCurrentStockItem['branch_id']] = $inventoryAllBranchCurrentStockItem['total_stock'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $monthList =  array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        );

        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        $unitConversion = UnitConversion::model()->findByAttributes(array('unit_to_id' => $convertToLitre));
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyOilSaleTransactionReportData, $inventoryAllBranchCurrentStockData, $year, $month, $branches, $unitConversion);
        }
        
        $this->render('summary', array(
            'monthlyOilSaleTransactionReportData' => $monthlyOilSaleTransactionReportData,
            'inventoryAllBranchCurrentStockData' => $inventoryAllBranchCurrentStockData,
            'yearList' => $yearList,
            'year' => $year,
            'monthList' => $monthList,
            'month' => $month,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'subCategoryId' => $subCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
            'branches' => $branches,
            'convertToLitre' => $convertToLitre,
            'unitConversion' => $unitConversion,
            'oilSaeId' => $oilSaeId,
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

    public function actionTransactionInfo($productId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceDetail::model()->searchByTransactionInfo($productId, $startDate, $endDate, $branchId, $page);
        $product = Product::model()->findByPk($productId);
        $branch = Branch::model()->findByPk($branchId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'product' => $product,
            'branch' => $branch,
        ));
    }

    protected function saveToExcel($monthlyOilSaleTransactionReportData, $inventoryAllBranchCurrentStockData, $year, $month, $branches, $unitConversion) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Oli Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Oli Bulanan');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Penjualan Oli Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' - ' . $year);

        $columnHeaderStart = 'I';
        $columnHeaderEnd = 'M';
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year); 
        
        foreach ($branches as $branch) {
            $worksheet->mergeCells("{$columnHeaderStart}5:{$columnHeaderEnd}5");
            $worksheet->setCellValue("{$columnHeaderStart}5", CHtml::value($branch, 'code'));
            ++$columnHeaderStart; ++$columnHeaderStart; ++$columnHeaderStart; ++$columnHeaderStart; ++$columnHeaderStart;
            ++$columnHeaderEnd; ++$columnHeaderEnd; ++$columnHeaderEnd; ++$columnHeaderEnd; ++$columnHeaderEnd;
        }
        $worksheet->mergeCells("{$columnHeaderStart}5:{$columnHeaderEnd}5");
        $worksheet->setCellValue("{$columnHeaderStart}5", 'All Branch');
        
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Code');
        $worksheet->setCellValue('D6', 'Name');
        $worksheet->setCellValue('E6', 'SAE');
        $worksheet->setCellValue('F6', 'Brand');
        $worksheet->setCellValue('G6', 'Category');
        $worksheet->setCellValue('H6', 'Satuan');
        $columnHeader = 'I';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnHeader}6", 'Total Jual');
            $columnHeader++;
            $worksheet->setCellValue("{$columnHeader}6", 'Average Jual');
            $columnHeader++;
            $worksheet->setCellValue("{$columnHeader}6", 'Klasifikasi');
            $columnHeader++;
            $worksheet->setCellValue("{$columnHeader}6", 'Min Stok');
            $columnHeader++;
            $worksheet->setCellValue("{$columnHeader}6", 'Posisi Stok');
            $columnHeader++;
        }
        $worksheet->setCellValue("{$columnHeader}6", 'Total Jual');
        $columnHeader++;
        $worksheet->setCellValue("{$columnHeader}6", 'Average Jual');
        $columnHeader++;
        $worksheet->setCellValue("{$columnHeader}6", 'Klasifikasi');
        $columnHeader++;
        $worksheet->setCellValue("{$columnHeader}6", 'Min Stok');
        $columnHeader++;
        $worksheet->setCellValue("{$columnHeader}6", 'Posisi Stok');

        $worksheet->getStyle("A1:{$columnHeader}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:{$columnHeader}6")->getFont()->setBold(true);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnHeader}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $ordinal = 0;

        foreach ($monthlyOilSaleTransactionReportData as $productId => $monthlyOilSaleTransactionReportDataItem) {
            $product = Product::model()->findByPk($productId);
            $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1;
            $unitName = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->unitTo->name : $product->unit->name;
            $column = 'I'; 
            
            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", CHtml::value($product, 'id'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($product, 'manufacturer_code'));
            $worksheet->setCellValue("D{$counter}", $monthlyOilSaleTransactionReportDataItem['product_name']);
            $worksheet->setCellValue("E{$counter}", CHtml::value($product, 'oilSae.oilName'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($product, 'brand.name') . ' - ' . CHtml::value($product, 'subBrand.name') . ' - ' . CHtml::value($product, 'subBrandSeries.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($product, 'productMasterCategory.name') . ' - ' . CHtml::value($product, 'productSubMasterCategory.name') . ' - ' . CHtml::value($product, 'productSubCategory.name'));
            $worksheet->setCellValue("H{$counter}", $unitName);
            
            $invoiceTotals = array();
            $quantityStocks = array(); 
            foreach ($branches as $branch) {
                $minimumStock = $multiplier * $product->minimum_stock;
                $invoiceOriginal = isset($monthlyOilSaleTransactionReportDataItem['totals'][$branch->id]) ? $monthlyOilSaleTransactionReportDataItem['totals'][$branch->id] : '0.00';
                $invoiceTotal = $multiplier * $invoiceOriginal;
                $quantityStockOriginal = isset($inventoryAllBranchCurrentStockData[$productId][$branch->id]) ? $inventoryAllBranchCurrentStockData[$productId][$branch->id] : '0.00';
                $quantityStock = $multiplier * $quantityStockOriginal;
                
                $worksheet->setCellValue("{$column}{$counter}", $invoiceTotal);
                $column++;
                $worksheet->setCellValue("{$column}{$counter}", round($invoiceTotal / $numberOfDays, 2));
                $column++; $column++;
                $worksheet->setCellValue("{$column}{$counter}", $minimumStock);
                $column++;
                $worksheet->setCellValue("{$column}{$counter}", $quantityStock);
                $column++;

                $invoiceTotals[] = $invoiceTotal;
                $quantityStocks[] = $quantityStock;
            }
            $invoiceTotalSum = array_sum($invoiceTotals);
            $quantityStockSum = array_sum($quantityStocks);
            
            $worksheet->setCellValue("{$column}{$counter}", $invoiceTotalSum);
            $column++;
            $worksheet->setCellValue("{$column}{$counter}", round($invoiceTotalSum / $numberOfDays, 2));
            $column++; $column++;
            $worksheet->setCellValue("{$column}{$counter}", $minimumStock);
            $column++;
            $worksheet->setCellValue("{$column}{$counter}", $quantityStockSum);
            $column++; 
            $counter++;
        }
        
        for ($col = 'A'; $col !== 'BZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_oli_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
