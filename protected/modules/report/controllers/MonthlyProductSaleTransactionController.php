<?php

class MonthlyProductSaleTransactionController extends Controller {

    public function filters() {
        return array(
//            'access',
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
        $monthNow = date('m');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $month = (isset($_GET['Month'])) ? $_GET['Month'] : $monthNow;
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $masterCategoryId = (isset($_GET['MasterCategoryId'])) ? $_GET['MasterCategoryId'] : '';
        $subCategoryId = (isset($_GET['SubCategoryId'])) ? $_GET['SubCategoryId'] : '';
        $subMasterCategoryId = (isset($_GET['SubMasterCategoryId'])) ? $_GET['SubMasterCategoryId'] : '';
        
        $monthlyProductSaleTransactionReportData = array();
        $monthlyProductSaleTransactionReport = InvoiceDetail::getMonthlyProductSaleTransactionReport($year, $month, $productId, $productCode, $productName, $brandId, $subBrandId, $subBrandSeriesId, $masterCategoryId, $subCategoryId, $subMasterCategoryId);
        foreach ($monthlyProductSaleTransactionReport as $reportItem) {
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['product_id'] = $reportItem['product_id'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['product_name'] = $reportItem['product_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['product_code'] = $reportItem['product_code'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['brand_name'] = $reportItem['brand_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_brand_name'] = $reportItem['sub_brand_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_brand_series_name'] = $reportItem['sub_brand_series_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['master_category_name'] = $reportItem['master_category_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_category_name'] = $reportItem['sub_category_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['sub_master_category_name'] = $reportItem['sub_master_category_name'];
            $monthlyProductSaleTransactionReportData[$reportItem['product_id']]['totals'][$reportItem['branch_id']] = $reportItem['total_quantity'];
        }

        
        $productIds = array_map(function($reportItem) { return $reportItem['product_id']; }, $monthlyProductSaleTransactionReport);
        
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
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyProductSaleTransactionReportData, $inventoryAllBranchCurrentStockData, $year);
        }
        
        $this->render('summary', array(
            'monthlyProductSaleTransactionReportData' => $monthlyProductSaleTransactionReportData,
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
            'masterCategoryId' => $masterCategoryId,
            'subCategoryId' => $subCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
            'branches' => $branches,
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

    protected function saveToExcel($yearlyProductSaleTransactionReportData, $inventoryCurrentStockData, $year) {
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
        $documentProperties->setTitle('Penjualan Parts Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Parts Tahunan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->getStyle('A1:AZ6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:AZ6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Penjualan Parts & Components Tahunan');
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
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Min');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Max');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Jual Median');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Type Product');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}5", 'Klasifikasi');
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
        
        foreach ($yearlyProductSaleTransactionReportData as $productId => $yearlyProductSaleTransactionReportDataItem) {
            $worksheet->getStyle("G{$counter}:Z{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", $yearlyProductSaleTransactionReportDataItem['product_id']);
            $worksheet->setCellValue("C{$counter}", $yearlyProductSaleTransactionReportDataItem['product_code']);
            $worksheet->setCellValue("D{$counter}", $yearlyProductSaleTransactionReportDataItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $yearlyProductSaleTransactionReportDataItem['brand_name'] . ' - ' . $yearlyProductSaleTransactionReportDataItem['sub_brand_name'] . ' - ' . $yearlyProductSaleTransactionReportDataItem['sub_brand_series_name']);
            $worksheet->setCellValue("F{$counter}", $yearlyProductSaleTransactionReportDataItem['master_category_name'] . ' - ' . $yearlyProductSaleTransactionReportDataItem['sub_master_category_name'] . ' - ' . $yearlyProductSaleTransactionReportDataItem['sub_category_name']);
            
            $invoiceTotals = array();
            $columnCounter = 'G';
            
            for ($month = 1; $month <= 12; $month++) {
                $invoiceTotal = isset($yearlyProductSaleTransactionReportDataItem['totals'][$month]) ? $yearlyProductSaleTransactionReportDataItem['totals'][$month] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal);
                $columnCounter++;
                $invoiceTotals[] = $invoiceTotal;
            }
            $invoiceTotalSum = array_sum($invoiceTotals);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum);
            $columnCounter++;
            $invoiceMean = $invoiceTotalSum / 12;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceMean);
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
            $columnCounter++;$columnCounter++;$columnCounter++;
            $quantityStock = isset($inventoryCurrentStockData[$productId]) ? $inventoryCurrentStockData[$productId] : '0.00';
            $worksheet->setCellValue("{$columnCounter}{$counter}", $quantityStock);
            $columnCounter++;
            $product = Product::model()->findByPk($productId);
            $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock);
            $columnCounter++;$columnCounter++;
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
        header('Content-Disposition: attachment;filename="penjualan_parts_components_tahunan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}