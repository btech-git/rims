<?php

class PurchasePerProductController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseOrderReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchasePerProductSummary = new PurchasePerProductSummary($product->search());
        $purchasePerProductSummary->setupLoading();
        $purchasePerProductSummary->setupPaging($pageSize, $currentPage);
        $purchasePerProductSummary->setupSorting();
        $purchasePerProductSummary->setupFilter($startDate, $endDate);

        $productDataProvider = $product->search();

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchasePerProductSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'purchasePerProductSummary' => $purchasePerProductSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pembelian per Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian per Barang');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Laporan Pembelian per Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Product Name');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Brand');
        $worksheet->setCellValue('D5', 'Sub Brand');
        $worksheet->setCellValue('E5', 'Sub Brand Series');
        $worksheet->setCellValue('F5', 'Category');
        $worksheet->setCellValue('G5', 'Sub Master Category');
        $worksheet->setCellValue('H5', 'Sub Category ');
        $worksheet->setCellValue('I5', 'Price');

        $worksheet->getStyle('A5:T5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->name));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->manufacturer_code));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'brand.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'subBrand.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'subBrandSeries.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'productMasterCategory.name')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'productSubCategory.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode($header->getPurchasePriceReport($options['startDate'], $options['endDate'])));

            $counter++;
        }
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian per Barang.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
