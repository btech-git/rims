<?php

class StockAnalysisController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail' || 
            $filterChain->action->id === 'redirectTransaction'
        ) {
            if (!(Yii::app()->user->checkAccess('inventoryHead')) || !(Yii::app()->user->checkAccess('consignmentOutEdit')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        $inventoryDetail = Search::bind(new InventoryDetail(), isset($_GET['InventoryDetail']) ? $_GET['InventoryDetail'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $brandId = (isset($_GET['BrandId'])) ? $_GET['BrandId'] : '';
        $subBrandId = (isset($_GET['SubBrandId'])) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = (isset($_GET['SubBrandSeriesId'])) ? $_GET['SubBrandSeriesId'] : '';
        $productMasterCategoryId = (isset($_GET['ProductMasterCategoryId'])) ? $_GET['ProductMasterCategoryId'] : '';
        $productSubMasterCategoryId = (isset($_GET['ProductSubMasterCategoryId'])) ? $_GET['ProductSubMasterCategoryId'] : '';
        $productSubCategoryId = (isset($_GET['ProductSubCategoryId'])) ? $_GET['ProductSubCategoryId'] : '';
        
        $dataProvider = $inventoryDetail->search();
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'brandId' => $brandId,
                'branchId' => $branchId,
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
                'productMasterCategoryId' => $productMasterCategoryId,
                'productSubMasterCategoryId' => $productSubMasterCategoryId,
                'productSubCategoryId' => $productSubCategoryId,
            ));
        }
        
        $this->render('summary', array(
            'inventoryDetail' => $inventoryDetail,
            'product' => $product,
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

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDate = (empty($options['startDate'])) ? date('Y-m-d') : $options['startDate'];
        $endDate = (empty($options['endDate'])) ? date('Y-m-d') : $options['endDate'];
        $branchId = (empty($options['branchId'])) ? $options['branchId'] : '';
        $brandId = (empty($options['brandId'])) ? $options['brandId'] : '';
        $subBrandId = (empty($options['subBrandId'])) ? $options['subBrandId'] : '';
        $subBrandSeriesId = (empty($options['subBrandSeriesId'])) ? $options['subBrandSeriesId'] : '';
        $productMasterCategoryId = (empty($options['productMasterCategoryId'])) ? $options['productMasterCategoryId'] : '';
        $productSubMasterCategoryId = (empty($options['productSubMasterCategoryId'])) ? $options['productSubMasterCategoryId'] : '';
        $productSubCategoryId = (empty($options['productSubCategoryId'])) ? $options['productSubCategoryId'] : '';
        $inventoryDetail = Search::bind(new InventoryDetail(), isset($_GET['InventoryDetail']) ? $_GET['InventoryDetail'] : '');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('PT. Raperind Motor');
        $documentProperties->setTitle('Laporan Stok Analisis');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Stok Analisis');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');

        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H6')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'PT. Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Stok Analisis');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Product Name');
        $worksheet->setCellValue('D5', 'Category');
        $worksheet->setCellValue('E5', 'Brand');
        $worksheet->setCellValue('F5', 'Sub Brand');
        $worksheet->setCellValue('G5', 'Sub Brand Series');
        $worksheet->setCellValue('H5', 'Total Sales');

        $worksheet->getStyle('A5:H5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        
        $fastMovingItems = $inventoryDetail->getFastMovingItems($startDate, $endDate, $brandId, $subBrandId, $subBrandSeriesId, $productMasterCategoryId, $productSubMasterCategoryId, $productSubCategoryId, $branchId);
        foreach ($fastMovingItems as $i => $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header['code']));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header['product_name']));
            $worksheet->setCellValue("D{$counter}", CHtml::encode($header['category']));
            $worksheet->setCellValue("E{$counter}", CHtml::encode($header['brand']));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($header['sub_brand']));
            $worksheet->setCellValue("G{$counter}", CHtml::encode($header['sub_brand_series']));
            $worksheet->setCellValue("H{$counter}", CHtml::encode($header['total_sale']));
            $counter++;

        }
        
        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Stok Analisis.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
}