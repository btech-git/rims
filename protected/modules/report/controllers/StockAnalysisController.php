<?php

class StockAnalysisController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockAnalysisReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        $inventoryDetail = Search::bind(new InventoryDetail(), isset($_GET['InventoryDetail']) ? $_GET['InventoryDetail'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $productMasterCategoryId = (isset($_GET['ProductMasterCategoryId'])) ? $_GET['ProductMasterCategoryId'] : '';
        $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';
        $productSubCategoryId = (isset($_GET['ProductSubCategoryId'])) ? $_GET['ProductSubCategoryId'] : '';
        $productId = (isset($_GET['ProductId'])) ? $_GET['ProductId'] : '';
        $productCode = (isset($_GET['ProductCode'])) ? $_GET['ProductCode'] : '';
        $productName = (isset($_GET['ProductName'])) ? $_GET['ProductName'] : '';
        
        $monthNow = date('m');
        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $numberOfDays = 0;
        for ($month = 1; $month <= 12; $month++) {
            if ($year < $yearNow) {
                $numberOfDays += cal_days_in_month(CAL_GREGORIAN, $month, $year);
            } elseif ($year == $yearNow) {
                if ($month < $monthNow) {
                    $numberOfDays += cal_days_in_month(CAL_GREGORIAN, $month, $year);
                }
            }
        }
        
        $fastMovingItems = $inventoryDetail->getFastMovingItems($year, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName);
        
        $fastMovingItemsData = array();
        foreach ($fastMovingItems as $fastMovingItem) {
            $fastMovingItemsData[$fastMovingItem['product_id']]['product_name'] = $fastMovingItem['product_name'];
            $fastMovingItemsData[$fastMovingItem['product_id']]['code'] = $fastMovingItem['code'];
            $fastMovingItemsData[$fastMovingItem['product_id']]['category'] = $fastMovingItem['category'];
            $fastMovingItemsData[$fastMovingItem['product_id']]['brand'] = $fastMovingItem['brand'];
            $fastMovingItemsData[$fastMovingItem['product_id']]['sub_brand'] = $fastMovingItem['sub_brand'];
            $fastMovingItemsData[$fastMovingItem['product_id']]['sub_brand_series'] = $fastMovingItem['sub_brand_series'];
            $fastMovingItemsData[$fastMovingItem['product_id']]['total_sale'][$fastMovingItem['month']] = $fastMovingItem['total_sale'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $monthList = array(
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        );
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($numberOfDays, $year, $monthList, $fastMovingItemsData);
        }
        
        $this->render('summary', array(
            'inventoryDetail' => $inventoryDetail,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'productMasterCategoryId' => $productMasterCategoryId,
            'productSubMasterCategoryId' => $productSubMasterCategoryId,
            'productSubCategoryId' => $productSubCategoryId,
            'numberOfDays' => $numberOfDays,
            'fastMovingItemsData' => $fastMovingItemsData,
            'yearList' => $yearList,
            'year' => $year,
            'monthList' => $monthList,
        ));
    }
    
    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
            $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubMasterCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productMasterCategoryId = (isset($_GET['ProductMasterCategoryId'])) ? $_GET['ProductMasterCategoryId'] : '';
            $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';

            $this->renderPartial('_productSubMasterCategorySelect', array(
                'productMasterCategoryId' => $productMasterCategoryId,
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubCategorySelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';
            $productSubCategoryId = (isset($_GET['ProductSubCategoryId'])) ? $_GET['ProductSubCategoryId'] : '';

            $this->renderPartial('_productSubCategorySelect', array(
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
                'productSubCategoryId' => $productSubCategoryId,
            ));
        }
    }

    protected function saveToExcel($numberOfDays, $year, $monthList, $fastMovingItemsData) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        $productId = (empty($options['productId'])) ? '' : $options['productId'];
        $productCode = (empty($options['productCode'])) ? '' : $options['productCode'];
        $productName = (empty($options['productName'])) ? '' : $options['productName'];
        $branchId = (!empty($options['branchId'])) ? $options['branchId'] : '';
        $brandId = (!empty($options['brandId'])) ? $options['brandId'] : '';
        $subBrandId = (!empty($options['subBrandId'])) ? $options['subBrandId'] : '';
        $subBrandSeriesId = (!empty($options['subBrandSeriesId'])) ? $options['subBrandSeriesId'] : '';
        $productMasterCategoryId = (!empty($options['productMasterCategoryId'])) ? $options['productMasterCategoryId'] : '';
        $productSubMasterCategoryId = (!empty($options['productSubMasterCategoryId'])) ? $options['productSubMasterCategoryId'] : '';
        $productSubCategoryId = (!empty($options['productSubCategoryId'])) ? $options['productSubCategoryId'] : '';

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Analisa Penjualan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Analisa Penjualan Barang');

        $worksheet->getStyle('A1:V5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:V5')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Analisa Penjualan Barang');
        $worksheet->setCellValue('A3', $year);

        $columnHeaderCounter = 'G';
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Code');
        $worksheet->setCellValue('D5', 'Product Name');
        $worksheet->setCellValue('E5', 'Category');
        $worksheet->setCellValue('F5', 'Brand');
        for ($month = 1; $month <= 12; $month++) {
            $worksheet->setCellValue("{$columnHeaderCounter}5", $monthList[$month]);
            $columnHeaderCounter++;
        }
        $worksheet->setCellValue("{$columnHeaderCounter}5", 'Total Sales');
        $columnHeaderCounter++;
        $worksheet->setCellValue("{$columnHeaderCounter}5", 'Average per Month');
        $columnHeaderCounter++;
        $worksheet->setCellValue("{$columnHeaderCounter}5", 'Average per Week');
        $columnHeaderCounter++;

        $worksheet->mergeCells("A1:{$columnHeaderCounter}1");
        $worksheet->mergeCells("A2:{$columnHeaderCounter}2");
        $worksheet->mergeCells("A3:{$columnHeaderCounter}3");

        $worksheet->getStyle("A5:{$columnHeaderCounter}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnHeaderCounter}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6; 
        
        $numberOfMonths = floor($numberOfDays / 30);
        $numberOfWeeks = floor($numberOfDays / 7);
        $i = 0;
        
        foreach ($fastMovingItemsData as $productId => $fastMovingItem) {
            $worksheet->setCellValue("A{$counter}", ++$i);
            $worksheet->setCellValue("B{$counter}", $productId);
            $worksheet->setCellValue("C{$counter}", $fastMovingItem['code']);
            $worksheet->setCellValue("D{$counter}", $fastMovingItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $fastMovingItem['category']);
            $worksheet->setCellValue("F{$counter}", $fastMovingItem['brand'] . ' - ' . $fastMovingItem['sub_brand'] . ' - ' . $fastMovingItem['sub_brand_series']);
            $totalSaleSum = '0.00';
            $columnBodyCounter = 'G';
            for ($month = 1; $month <= 12; $month++) {
                $totalSale = isset($fastMovingItem['total_sale'][$month]) ? $fastMovingItem['total_sale'][$month] : ''; 
                $worksheet->setCellValue("{$columnBodyCounter}{$counter}", $totalSale);
                $totalSaleSum += $totalSale;
                $columnBodyCounter++;
            }
            $worksheet->setCellValue("{$columnBodyCounter}{$counter}", $totalSaleSum);
            $columnBodyCounter++;
            $worksheet->setCellValue("{$columnBodyCounter}{$counter}", round($totalSaleSum / $numberOfMonths, 2));
            $columnBodyCounter++;
            $worksheet->setCellValue("{$columnBodyCounter}{$counter}", round($totalSaleSum / $numberOfWeeks, 2));
            $columnBodyCounter++;
            
            $counter++;
        }
        $counter++;
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_stok_analisis.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
}