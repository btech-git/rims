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
        
        $invoiceTireInfo = array();
        $yearlySaleSummary = InvoiceDetail::getYearlyTireSaleTransactionData($year, $productId, $productCode, $productName, $branchId, $brandId, $subBrandId, $subBrandSeriesId, $subCategoryId, $subMasterCategoryId);
        foreach ($yearlySaleSummary as $yearlySaleSummaryItem) {
            $monthValue = intval(substr($yearlySaleSummaryItem['year_month_value'], 4, 2));
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['product_id'] = $yearlySaleSummaryItem['product_id'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['product_name'] = $yearlySaleSummaryItem['product_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['product_code'] = $yearlySaleSummaryItem['product_code'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['brand_name'] = $yearlySaleSummaryItem['brand_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['sub_brand_name'] = $yearlySaleSummaryItem['sub_brand_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['sub_brand_series_name'] = $yearlySaleSummaryItem['sub_brand_series_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['master_category_name'] = $yearlySaleSummaryItem['master_category_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['sub_category_name'] = $yearlySaleSummaryItem['sub_category_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['sub_master_category_name'] = $yearlySaleSummaryItem['sub_master_category_name'];
            $invoiceTireInfo[$yearlySaleSummaryItem['product_id']]['totals'][$monthValue] = $yearlySaleSummaryItem['total_quantity'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($invoiceTireInfo, $year, $branchId);
        }

        $this->render('summary', array(
            'yearList' => $yearList,
            'year' => $year,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'branchId' => $branchId,
            'invoiceTireInfo' => $invoiceTireInfo,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'masterCategoryId' => $masterCategoryId,
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
            $productBrandId = isset($_GET['Product']['brand_id']) ? $_GET['Product']['brand_id'] : 0;

            $this->renderPartial('_productSubBrandSelect', array(
                'productBrandId' => $productBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubBrandId = isset($_GET['Product']['sub_brand_id']) ? $_GET['Product']['sub_brand_id'] : 0;

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'productSubBrandId' => $productSubBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = isset($_GET['Product']['product_master_category_id']) ? $_GET['Product']['product_master_category_id'] : 0;

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = isset($_GET['Product']['product_sub_master_category_id']) ? $_GET['Product']['product_sub_master_category_id'] : 0;

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    protected function saveToExcel($invoiceTireInfo, $year, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penjualan Tahunan Tire');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Tahunan Tire');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        
        $worksheet->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S3')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Tahunan Tire');
        $worksheet->setCellValue('A3', $year);

        $worksheet->getStyle("A5:S5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:S5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:S5')->getFont()->setBold(true);

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
        $worksheet->setCellValue("E5", 'Brand');
        $worksheet->setCellValue("F5", 'Category');
        $columnCounter = 'G';
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnCounter}5", CHtml::encode($monthList[$month]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}5", 'Total');
        $counter = 7;

        $groupTotalSums = array();
        $autoNumber = 1;
        foreach ($invoiceTireInfo as $invoiceTireSaleInfo) {
            $worksheet->setCellValue("A{$counter}", $autoNumber);
            $worksheet->setCellValue("B{$counter}", $invoiceTireSaleInfo['product_id']);
            $worksheet->setCellValue("C{$counter}", $invoiceTireSaleInfo['product_code']);
            $worksheet->setCellValue("D{$counter}", $invoiceTireSaleInfo['product_name']);
            $worksheet->setCellValue("E{$counter}", $invoiceTireSaleInfo['brand_name'] . ' - ' . $invoiceTireSaleInfo['sub_brand_name'] . ' - ' . $invoiceTireSaleInfo['sub_brand_series_name']);
            $worksheet->setCellValue("F{$counter}", $invoiceTireSaleInfo['master_category_name'] . ' - ' . $invoiceTireSaleInfo['sub_category_name'] . ' - ' . $invoiceTireSaleInfo['sub_master_category_name']);
            $totalSum = 0;
            $columnCounter = 'G';
            for ($month = 1; $month <= 12; $month++) {
                $total = isset($invoiceTireSaleInfo['totals'][$month]) ? $invoiceTireSaleInfo['totals'][$month] : '';
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
        
        $worksheet->getStyle("A{$counter}:S{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:S{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("F{$counter}", 'Total');
        $grandTotal = 0;
        $footerCounter = 'G';
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
        header('Content-Disposition: attachment;filename="penjualan_tahunan_ban.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}