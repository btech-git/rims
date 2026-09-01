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
            $this->saveToExcel($inventoryDetail, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
                'productId' => $productId,
                'productCode' => $productCode,
                'productName' => $productName,
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
                'productMasterCategoryId' => $productMasterCategoryId,
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
                'productSubCategoryId' => $productSubCategoryId,
                'numberOfDays' => $numberOfDays,
                'fastMovingItems' => $fastMovingItems,
            ));
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

    protected function saveToExcel($inventoryDetail, array $options = array()) {
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
        $numberOfDays = (empty($options['numberOfDays'])) ? '' : $options['numberOfDays'];

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Stok Analisis');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Stok Analisis');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->mergeCells('A5:I5');

        $worksheet->getStyle('A1:I6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'PT. Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Stok Analisis' . $branchId);
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:I5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Fast Moving Items ' . CHtml::value($branch, 'code'));
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Code');
        $worksheet->setCellValue('D6', 'Product Name');
        $worksheet->setCellValue('E6', 'Category');
        $worksheet->setCellValue('F6', 'Brand');
        $worksheet->setCellValue('G6', 'Quantity Sales');
        $worksheet->setCellValue('H6', 'Average per Month');
        $worksheet->setCellValue('I6', 'Average per Week');

        $worksheet->getStyle('A6:I6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        
        $numberOfMonths = floor($numberOfDays / 30);
        $numberOfWeeks = floor($numberOfDays / 7);
        $fastMovingItems = $inventoryDetail->getFastMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName);
        
        foreach ($fastMovingItems as $i => $fastMovingItem) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $fastMovingItem['id']);
            $worksheet->setCellValue("C{$counter}", $fastMovingItem['code']);
            $worksheet->setCellValue("D{$counter}", $fastMovingItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $fastMovingItem['category']);
            $worksheet->setCellValue("F{$counter}", $fastMovingItem['brand'] . ' - ' . $fastMovingItem['sub_brand'] . ' - ' . $fastMovingItem['sub_brand_series']);
            $worksheet->setCellValue("G{$counter}", $fastMovingItem['total_sale']);
            $worksheet->setCellValue("H{$counter}", round($fastMovingItem['total_sale'] / $numberOfMonths, 2));
            $worksheet->setCellValue("I{$counter}", round($fastMovingItem['total_sale'] / $numberOfWeeks, 2));
            
            $counter++;
        }
        $counter++;
        
        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        $worksheet->mergeCells("A{$counter}:I{$counter}");

        $worksheet->setCellValue("A{$counter}", 'Slow Moving Items ' . CHtml::value($branch, 'code'));
        $counter++;
        
        $worksheet->setCellValue("A{$counter}", 'No');
        $worksheet->setCellValue("B{$counter}", 'ID');
        $worksheet->setCellValue("C{$counter}", 'Code');
        $worksheet->setCellValue("D{$counter}", 'Product Name');
        $worksheet->setCellValue("E{$counter}", 'Category');
        $worksheet->setCellValue("F{$counter}", 'Brand');
        $worksheet->setCellValue("G{$counter}", 'Quantity Sales');
        $worksheet->setCellValue("H{$counter}", 'Average per Month');
        $worksheet->setCellValue("I{$counter}", 'Average per Week');

        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        $counter++;
        
        $slowMovingItems = $inventoryDetail->getSlowMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName);
        
        foreach ($slowMovingItems as $i => $slowMovingItem) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $slowMovingItem['id']);
            $worksheet->setCellValue("C{$counter}", $slowMovingItem['code']);
            $worksheet->setCellValue("D{$counter}", $slowMovingItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $slowMovingItem['category']);
            $worksheet->setCellValue("F{$counter}", $slowMovingItem['brand'] . ' - ' . $slowMovingItem['sub_brand'] . ' - ' . $slowMovingItem['sub_brand_series']);
            $worksheet->setCellValue("G{$counter}", $slowMovingItem['total_sale']);
            $worksheet->setCellValue("H{$counter}", round($slowMovingItem['total_sale'] / $numberOfMonths, 2));
            $worksheet->setCellValue("I{$counter}", round($slowMovingItem['total_sale'] / $numberOfWeeks, 2));
            
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