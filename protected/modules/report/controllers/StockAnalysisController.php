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
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $productMasterCategoryId = (isset($_GET['ProductMasterCategoryId'])) ? $_GET['ProductMasterCategoryId'] : '';
        $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';
        $productSubCategoryId = (isset($_GET['ProductSubCategoryId'])) ? $_GET['ProductSubCategoryId'] : '';
        $productId = (isset($_GET['ProductId'])) ? $_GET['ProductId'] : '';
        $productCode = (isset($_GET['ProductCode'])) ? $_GET['ProductCode'] : '';
        $productName = (isset($_GET['ProductName'])) ? $_GET['ProductName'] : '';
        
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

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Stok Analisis');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Stok Analisis');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        $worksheet->mergeCells('A5:G5');

        $worksheet->getStyle('A1:G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'PT. Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Stok Analisis' . $branchId);
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Fast Moving Items ' . CHtml::value($branch, 'code'));
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Code');
        $worksheet->setCellValue('D6', 'Product Name');
        $worksheet->setCellValue('E6', 'Category');
        $worksheet->setCellValue('F6', 'Brand');
        $worksheet->setCellValue('G6', 'Quantity Sales');

        $worksheet->getStyle('A6:G6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        
        $fastMovingItems = $inventoryDetail->getFastMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId, $productId, $productCode, $productName);
        foreach ($fastMovingItems as $i => $fastMovingItem) {
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $fastMovingItem['id']);
            $worksheet->setCellValue("C{$counter}", $fastMovingItem['code']);
            $worksheet->setCellValue("D{$counter}", $fastMovingItem['product_name']);
            $worksheet->setCellValue("E{$counter}", $fastMovingItem['category']);
            $worksheet->setCellValue("F{$counter}", $fastMovingItem['brand'] . ' - ' . $fastMovingItem['sub_brand'] . ' - ' . $fastMovingItem['sub_brand_series']);
            $worksheet->setCellValue("G{$counter}", $fastMovingItem['total_sale']);
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
        header('Content-Disposition: attachment;filename="Laporan Stok Analisis.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
}