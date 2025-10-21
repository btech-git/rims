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
            $this->saveToExcel($monthlyProductSaleTransactionReportData, $inventoryAllBranchCurrentStockData, $year, $monthList, $month, $branches);
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

    protected function saveToExcel($monthlyProductSaleTransactionReportData, $inventoryAllBranchCurrentStockData, $year, $monthList, $month, $branches) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Parts Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Parts Bulanan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->getStyle('A1:BG6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:BG6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Penjualan Parts & Components Bulanan');
        $worksheet->setCellValue('A3', 'Periode Tahun: ' . $monthList[$month] . ' ' . $year);
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        $columnStart = 'G';
        $columnEnd = 'K';
        
        foreach ($branches as $branch) {
            $worksheet->mergeCells("{$columnStart}5:{$columnEnd}5");
            $worksheet->setCellValue("{$columnStart}5", CHtml::value($branch, 'code'));
            ++$columnStart; ++$columnStart; ++$columnStart; ++$columnStart; ++$columnStart;
            ++$columnEnd; ++$columnEnd; ++$columnEnd; ++$columnEnd; ++$columnEnd;
            $worksheet->setCellValue("{$columnStart}5", '');
            ++$columnStart; ++$columnEnd;
        }
        $worksheet->mergeCells("{$columnStart}5:{$columnEnd}5");
        $worksheet->setCellValue("{$columnStart}5", 'All Cabang');

        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Code');
        $worksheet->setCellValue('D6', 'Name');
        $worksheet->setCellValue('E6', 'Brand');
        $worksheet->setCellValue('F6', 'Category');
        
        $columnCounter = 'G';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnCounter}6", 'Total Jual');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Average Jual');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Klasifikasi');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Min Stok');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}6", 'Posisi Stok');
            $columnCounter++;$columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}6", 'Total Jual');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Average Jual');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Klasifikasi');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Min Stok');
        $columnCounter++;
        $worksheet->setCellValue("{$columnCounter}6", 'Posisi Stok');
        
        $worksheet->getStyle("A5:{$columnCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounter}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        $ordinal = 0;
        
        foreach ($monthlyProductSaleTransactionReportData as $productId => $monthlyProductSaleTransactionReportDataItem) {
            $worksheet->getStyle("G{$counter}:Z{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $product = Product::model()->findByPk($productId); 

            $worksheet->setCellValue("A{$counter}", ++$ordinal);
            $worksheet->setCellValue("B{$counter}", $monthlyProductSaleTransactionReportDataItem['product_id']);
            $worksheet->setCellValue("C{$counter}", $monthlyProductSaleTransactionReportDataItem['product_code']);
            $worksheet->setCellValue("D{$counter}", $monthlyProductSaleTransactionReportDataItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $monthlyProductSaleTransactionReportDataItem['brand_name'] . ' - ' . $monthlyProductSaleTransactionReportDataItem['sub_brand_name'] . ' - ' . $monthlyProductSaleTransactionReportDataItem['sub_brand_series_name']);
            $worksheet->setCellValue("F{$counter}", $monthlyProductSaleTransactionReportDataItem['master_category_name'] . ' - ' . $monthlyProductSaleTransactionReportDataItem['sub_master_category_name'] . ' - ' . $monthlyProductSaleTransactionReportDataItem['sub_category_name']);
            
            $invoiceTotals = array();
            $quantityStocks = array();
            $columnCounter = 'G';
            
            foreach ($branches as $branch) {
                $invoiceTotal = isset($monthlyProductSaleTransactionReportDataItem['totals'][$branch->id]) ? $monthlyProductSaleTransactionReportDataItem['totals'][$branch->id] : '0.00';
                $quantityStock = isset($inventoryAllBranchCurrentStockData[$productId][$branch->id]) ? $inventoryAllBranchCurrentStockData[$productId][$branch->id] : '0.00';
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotal / $numberOfDays);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", '');
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock);
                $columnCounter++;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $quantityStock);
                $columnCounter++;$columnCounter++;
                $invoiceTotals[] = $invoiceTotal;
                $quantityStocks[] = $quantityStock;
            }
            $invoiceTotalSum = array_sum($invoiceTotals);
            $quantityStockSum = array_sum($quantityStocks); 
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $invoiceTotalSum / $numberOfDays);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", '');
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $product->minimum_stock);
            $columnCounter++;
            $worksheet->setCellValue("{$columnCounter}{$counter}", $quantityStockSum);
            $columnCounter++;
            
            $counter++;
        }

        for ($col = 'A'; $col !== 'BG'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_parts_components_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}