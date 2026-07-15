<?php

class StockOilController extends Controller {

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
            if (!(Yii::app()->user->checkAccess('stockOilReport'))){
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionCheck() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $brandId = isset($_GET['BrandId']) ? $_GET['BrandId'] : '';
        $subBrandId = isset($_GET['SubBrandId']) ? $_GET['SubBrandId'] : '';
        $subBrandSeriesId = isset($_GET['SubBrandSeriesId']) ? $_GET['SubBrandSeriesId'] : '';
        $productId = isset($_GET['ProductId']) ? $_GET['ProductId'] : '';
        $productName = isset($_GET['ProductName']) ? $_GET['ProductName'] : '';
        $productCode = isset($_GET['ProductCode']) ? $_GET['ProductCode'] : '';
        $oilSaeId = isset($_GET['OilSaeId']) ? $_GET['OilSaeId'] : '';
        $convertToLitre = isset($_GET['ConvertToLitre']) ? $_GET['ConvertToLitre'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $endDate = date('Y-m-d');
            $brandId = '';
            $subBrandId = '';
            $subBrandSeriesId = '';
            $productId = '';
            $productName = '';
            $productCode = '';
            $oilSaeId = '';
            $convertToLitre = '';
        }
        
        $inventoryOilStockReport = InventoryDetail::getInventoryOilStockReport($endDate, $brandId, $subBrandId, $subBrandSeriesId, $productId, $productCode, $productName, $oilSaeId);
        
        $inventoryOilStockReportData = array();
        foreach ($inventoryOilStockReport as $inventoryOilStockReportItem) {
            $inventoryOilStockReportData[$inventoryOilStockReportItem['product_id']][$inventoryOilStockReportItem['branch_id']] = $inventoryOilStockReportItem['total_stock'];
        }
        
        $branches = Branch::model()->findAll();
        $unitConversion = UnitConversion::model()->findByAttributes(array('unit_to_id' => $convertToLitre));

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($inventoryOilStockReportData, $branches, $endDate, $convertToLitre, $unitConversion);
        }

        $this->render('check', array(
            'inventoryOilStockReportData' => $inventoryOilStockReportData,
            'endDate' => $endDate,
            'brandId' => $brandId,
            'subBrandId' => $subBrandId,
            'subBrandSeriesId' => $subBrandSeriesId,
            'productId' => $productId,
            'productCode' => $productCode,
            'productName' => $productName,
            'oilSaeId' => $oilSaeId,
            'branches' => $branches,
            'convertToLitre' => $convertToLitre,
            'unitConversion' => $unitConversion,
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

    protected function saveToExcel($inventoryOilStockReportData, $branches, $endDate, $convertToLitre, $unitConversion) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Stok Oli');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Stok Oli');

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Stok Oli');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $columnHeader = 'G'; 
        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Ukuran');
        $worksheet->setCellValue('E5', 'Brand');
        $worksheet->setCellValue('F5', 'Satuan');
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnHeader}5", CHtml::value($branch, 'code'));
            $columnHeader++;
        }
        $worksheet->setCellValue("{$columnHeader}5", 'Total');

        $worksheet->mergeCells("A1:{$columnHeader}1");
        $worksheet->mergeCells("A2:{$columnHeader}2");
        $worksheet->mergeCells("A3:{$columnHeader}3");
        
        $worksheet->getStyle("A1:{$columnHeader}5")->getFont()->setBold(true);
        $worksheet->getStyle("A1:{$columnHeader}5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($inventoryOilStockReportData as $productId => $inventoryOilStockReportItem) {

            $totalStockSum = '0.00';
            $product = Product::model()->findByPk($productId);
            $multiplier = $unitConversion !== null && $unitConversion->unit_from_id == $product->unit_id ? $unitConversion->multiplier : 1;
            $columnBody = 'G'; 
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($product, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($product, 'manufacturer_code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($product, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($product, 'oilSae.oilName'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($product, 'brand.name') . ' - ' . CHtml::value($product, 'subBrand.name') . ' - ' . CHtml::value($product, 'subBrandSeries.name'));
            $worksheet->setCellValue("F{$counter}", empty($convertToLitre) ? CHtml::value($product, 'unit.name') : 'Liter');
            foreach ($branches as $branch) {
                $originalStock = isset($inventoryOilStockReportItem[$branch->id]) ? $inventoryOilStockReportItem[$branch->id] : 0;
                $totalStock = $multiplier * $originalStock;
                $worksheet->setCellValue("{$columnBody}{$counter}", $totalStock);
                $totalStockSum += $totalStock;
                $columnBody++;
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
        header('Content-Disposition: attachment;filename="stok_oli.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}