<?php

class StockTireController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail'
        ) {
            if (!(Yii::app()->user->checkAccess('stockTireReport'))){
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCheck() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $yearNow = date('Y');
        
        $endYear = isset($_GET['EndYear']) ? $_GET['EndYear'] : date('Y');
        $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
        $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = isset($_GET['SubBrandSeriesId']) ? $_GET['SubBrandSeriesId'] : '';
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $tireSizeId = isset($_GET['TireSizeId']) ? $_GET['TireSizeId'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $endYear = date('Y');
            $brandId = '';
            $subBrandId = '';
            $subBrandSeriesId = '';
            $productId = '';
            $productName = '';
            $productCode = '';
            $tireSizeId = '';
        }
        
        $startYear = max(2024, $endYear - 2);
        
        $inventoryTireStockReport = InventoryDetail::getInventoryTireStockReport($startYear, $endYear, $brandId, $subBrandId, $subBrandSeriesId, $productId, $productCode, $productName, $tireSizeId);
        
        $inventoryTireStockReportData = array();
        foreach ($inventoryTireStockReport as $inventoryTireStockReportItem) {
            $inventoryTireStockReportData[$inventoryTireStockReportItem['product_id']][$inventoryTireStockReportItem['branch_id']][$inventoryTireStockReportItem['production_year']] = $inventoryTireStockReportItem['total_stock'];
        }
        
        $branches = Branch::model()->findAll();

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            if ($y >= 2024) {
                $yearList[$y] = $y;
            }
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($inventoryTireStockReportData, $startYear, $endYear, $branches);
        }

        $this->render('check', array(
            'inventoryTireStockReportData' => $inventoryTireStockReportData,
            'startYear' => $startYear,
            'endYear' => $endYear,
            'yearList' => $yearList,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'tireSizeId' => $tireSizeId,
            'branches' => $branches,
        ));
    }

    public function actionAjaxHtmlUpdateProductSubBrandSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';

            $this->renderPartial('_productSubBrandSelect', array(
                'brandId' => $brandId,
                'subBrandId' => $subBrandId,
            ));
        }
    }

    public function actionAjaxHtmlUpdateProductSubBrandSeriesSelect() {
        if (Yii::app()->request->isAjaxRequest) {
            $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
            $subBrandSeriesId = isset($_GET['SubBrandSeriesId']) ? $_GET['SubBrandSeriesId'] : '';

            $this->renderPartial('_productSubBrandSeriesSelect', array(
                'subBrandId' => $subBrandId,
                'subBrandSeriesId' => $subBrandSeriesId,
            ));
        }
    }

    protected function saveToExcel($inventoryTireStockReportData, $startYear, $endYear, $branches) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Stok Ban per Tahun Produksi');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Stok Ban per Tahun Produksi');

        $worksheet->getStyle("A1:A2")->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Stok Ban per Tahun Produksi');

        $columnHeaderStart = 'F';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnHeaderStart}4", CHtml::value($branch, 'code'));
            $columnHeaderStart++;$columnHeaderStart++;$columnHeaderStart++;
        }
        
        $columnHeader = 'F';
        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Ukuran');
        $worksheet->setCellValue('E5', 'Brand');
        foreach ($branches as $branch) {
            for ($year = $startYear; $year <= $endYear; $year++) {
                $worksheet->setCellValue("{$columnHeader}5", $year);
                $columnHeader++;
            }
        }
        $worksheet->setCellValue("{$columnHeader}5", 'Total');

        $worksheet->mergeCells("A1:{$columnHeader}1");
        $worksheet->mergeCells("A2:{$columnHeader}2");
        $worksheet->mergeCells("A3:{$columnHeader}3");
        
        $worksheet->getStyle("A1:{$columnHeader}5")->getFont()->setBold(true);
        $worksheet->getStyle("A1:{$columnHeader}5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A4:{$columnHeader}4")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($inventoryTireStockReportData as $productId => $inventoryTireStockReportItem) {
            $totalStockSum = 0;
            $product = Product::model()->findByPk($productId); 

            $worksheet->setCellValue("A{$counter}", CHtml::value($product, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($product, 'manufacturer_code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($product, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($product, 'tireSize.tireName'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($product, 'brand.name') . ' - ' . CHtml::value($product, 'subBrand.name') . ' - ' . CHtml::value($product, 'subBrandSeries.name'));
            foreach ($branches as $branch) {
                $columnBody = 'F'; 
                for ($year = $startYear; $year <= $endYear; $year++) {
                    $totalStock = isset($inventoryTireStockReportItem[$branch->id][$year]) ? $inventoryTireStockReportItem[$branch->id][$year] : '0';
                    $worksheet->setCellValue("{$columnBody}{$counter}", $totalStock);
                    $totalStockSum += $totalStock;
                    $columnBody++;
                }
            }
            
            $worksheet->setCellValue("{$columnBody}{$counter}", $totalStockSum);
            $counter++;

        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="stok_ban_tahun_produksi.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
