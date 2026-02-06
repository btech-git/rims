<?php

class YearlyOilSaleTransactionController extends Controller {

    public $layout = '//layouts/column1';
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
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $masterCategoryId = (isset($_GET['MasterCategoryId'])) ? $_GET['MasterCategoryId'] : 4;
        $subCategoryId = (isset($_GET['SubCategoryId'])) ? $_GET['SubCategoryId'] : '';
        $subMasterCategoryId = (isset($_GET['SubMasterCategoryId'])) ? $_GET['SubMasterCategoryId'] : '';
        $oilSaeId = isset($_GET['OilSaeId']) ? $_GET['OilSaeId'] : '';
        $convertToLitre = isset($_GET['ConvertToLitre']) ? $_GET['ConvertToLitre'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $year = $yearNow;
            $productId = '';
            $productCode = '';
            $productName = '';
            $branchId = '';
            $brandId = '';
            $subBrandId = '';
            $subBrandSeriesId = '';
            $masterCategoryId = 4;
            $subCategoryId = '';
            $subMasterCategoryId = '';
            $oilSaeId = '';
            $convertToLitre = '';
        }
        
        $invoiceOilInfo = array();
        $yearlySaleSummary = InvoiceDetail::getYearlyOilSaleTransactionData($year, $productId, $productCode, $productName, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $subCategoryId, $subMasterCategoryId, $oilSaeId);
        foreach ($yearlySaleSummary as $yearlySaleSummaryItem) {
            $monthValue = intval(substr($yearlySaleSummaryItem['year_month_value'], 4, 2));
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['product_id'] = $yearlySaleSummaryItem['product_id'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['product_name'] = $yearlySaleSummaryItem['product_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['product_code'] = $yearlySaleSummaryItem['product_code'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['brand_name'] = $yearlySaleSummaryItem['brand_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['sub_brand_name'] = $yearlySaleSummaryItem['sub_brand_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['sub_brand_series_name'] = $yearlySaleSummaryItem['sub_brand_series_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['master_category_name'] = $yearlySaleSummaryItem['master_category_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['sub_category_name'] = $yearlySaleSummaryItem['sub_category_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['sub_master_category_name'] = $yearlySaleSummaryItem['sub_master_category_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['oil_name'] = $yearlySaleSummaryItem['oil_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['unit_name'] = $yearlySaleSummaryItem['unit_name'];
            $invoiceOilInfo[$yearlySaleSummaryItem['product_id']]['totals'][$monthValue] = $yearlySaleSummaryItem['total_quantity'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $unitConversion = UnitConversion::model()->findByAttributes(array('unit_to_id' => $convertToLitre));
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($invoiceOilInfo, $year, $branchId, $unitConversion, $convertToLitre);
        }

        $this->render('summary', array(
            'yearList' => $yearList,
            'year' => $year,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'branchId' => $branchId,
            'invoiceOilInfo' => $invoiceOilInfo,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'masterCategoryId' => $masterCategoryId,
            'subCategoryId' => $subCategoryId,
            'subMasterCategoryId' => $subMasterCategoryId,
            'convertToLitre' => $convertToLitre,
            'unitConversion' => $unitConversion,
            'oilSaeId' => $oilSaeId,
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

    protected function saveToExcel($invoiceOilInfo, $year, $branchId, $unitConversion, $convertToLitre) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Tahunan Oli');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Tahunan Oli');

        $worksheet->mergeCells('A1:U1');
        $worksheet->mergeCells('A2:U2');
        $worksheet->mergeCells('A3:U3');
        
        $worksheet->getStyle('A1:U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:U3')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Tahunan Oli');
        $worksheet->setCellValue('A3', $year);

        $worksheet->getStyle("A5:U5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:U5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:U5')->getFont()->setBold(true);

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
        $worksheet->setCellValue("E5", 'SAE');
        $worksheet->setCellValue("F5", 'Brand');
        $worksheet->setCellValue("G5", 'Category');
        $worksheet->setCellValue("H5", 'Satuan');
        $columnCounter = 'I';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}5", CHtml::encode($monthList[$month]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');
        $counter = 6;

        $groupTotalSums = array();
        $autoNumber = 1;
        foreach ($invoiceOilInfo as $invoiceOilSaleInfo) {
            $totalSum = 0;
            $columnCounter = 'I';
            $product = Product::model()->findByPk($invoiceOilSaleInfo['product_id']);
            $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1;
            $worksheet->setCellValue("A{$counter}", $autoNumber);
            $worksheet->setCellValue("B{$counter}", $invoiceOilSaleInfo['product_id']);
            $worksheet->setCellValue("C{$counter}", $invoiceOilSaleInfo['product_code']);
            $worksheet->setCellValue("D{$counter}", $invoiceOilSaleInfo['product_name']);
            $worksheet->setCellValue("E{$counter}", $invoiceOilSaleInfo['oil_name']);
            $worksheet->setCellValue("F{$counter}", $invoiceOilSaleInfo['brand_name'] . ' - ' . $invoiceOilSaleInfo['sub_brand_name'] . ' - ' . $invoiceOilSaleInfo['sub_brand_series_name']);
            $worksheet->setCellValue("G{$counter}", $invoiceOilSaleInfo['master_category_name'] . ' - ' . $invoiceOilSaleInfo['sub_category_name'] . ' - ' . $invoiceOilSaleInfo['sub_master_category_name']);
            $worksheet->setCellValue("H{$counter}", empty($convertToLitre) ? $invoiceOilSaleInfo['unit_name'] : 'Liter');
            for ($month = 1; $month <= 12; $month++) {
                $originalQuantity = isset($invoiceOilSaleInfo['totals'][$month]) ? $invoiceOilSaleInfo['totals'][$month] : '';
                $total = $multiplier * $originalQuantity;
                $worksheet->setCellValue("{$columnCounter}{$counter}", $total);
                $totalSum += $total; 
                if (!isset($groupTotalSums[$month])) {
                    $groupTotalSums[$month] = 0;
                }
                $groupTotalSums[$month] += $total;
                $columnCounter++;
            }
            
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($totalSum));
            $counter++;
            $autoNumber++;
        }
        
        $worksheet->getStyle("A{$counter}:U{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:U{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("H{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'I';
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($groupTotalSums[$month])) {
                $groupTotalSums[$month] = 0;
            }
            $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($groupTotalSums[$month]));
            $grandTotal += $groupTotalSums[$month];
            $footerCounter++;
        }
        $worksheet->setCellValue("{$footerCounter}{$counter}", CHtml::encode($grandTotal));

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_tahunan_oli.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}