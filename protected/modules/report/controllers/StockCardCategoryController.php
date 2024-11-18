<?php

class StockCardCategoryController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockCardReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $productSubCategory = Search::bind(new ProductSubCategory('search'), isset($_GET['ProductSubCategory']) ? $_GET['ProductSubCategory'] : '');

        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $stockCardCategorySummary = new StockCardCategorySummary($productSubCategory->search());
        $stockCardCategorySummary->setupLoading();
        $stockCardCategorySummary->setupPaging($pageSize, $currentPage);
        $stockCardCategorySummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $stockCardCategorySummary->setupFilter($filters);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($stockCardCategorySummary, $endDate, $branchId);
        }

        $this->render('summary', array(
            'productSubCategory' => $productSubCategory,
            'stockCardCategorySummary' => $stockCardCategorySummary,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
            'branchId' => $branchId,
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

    public function actionAjaxHtmlUpdateProductStockTable() {
        if (Yii::app()->request->isAjaxRequest) {
            $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;
            $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');
            $productDataProvider = $product->searchByStockCheck($pageNumber);
            $branches = Branch::model()->findAll();

            $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
            ));
        }
    }

    protected function saveToExcel($stockCardSummary, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Posisi Stok');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Posisi Stok');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->mergeCells('A4:I4');
        $worksheet->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Posisi Stok');
        $worksheet->setCellValue('A3', 'Periode: ' . $endDateFormatted);

        $worksheet->getStyle("A6:I6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:I6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:H6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Code');
        $worksheet->setCellValue('B6', 'Name');
        $worksheet->setCellValue('C6', 'Keterangan');
        $worksheet->setCellValue('D6', 'Awal');
        $worksheet->setCellValue('E6', 'Masuk');
        $worksheet->setCellValue('F6', 'Keluar');
        $worksheet->setCellValue('G6', 'Akhir');
        $worksheet->setCellValue('H6', 'Nilai');

        $counter = 8;

        foreach ($stockCardSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->id);
            $worksheet->setCellValue("B{$counter}", $header->code);
            $worksheet->setCellValue("C{$counter}", $header->name);
            $worksheet->getStyle("A{$counter}:C{$counter}")->getFont()->setBold(true);
            $counter++;
                
            $totalStock = '0.00';
            $totalValue = '0.00';
            $stockData = $header->getInventoryStockReport($endDate, $branchId); 
            foreach ($stockData as $stockRow) {
                $product = Product::model()->findByPk($stockRow['id']);
                $stockBegin = $product->getBeginningStockCardReport($branchId);
                $stockIn = $stockRow['stock_in'];
                $stockOut = $stockRow['stock_out'];
                $stokEnd = $stockBegin + $stockIn + $stockOut;
                $inventoryValue = $product->getAverageCogs() * $stokEnd;
            
                $worksheet->setCellValue("A{$counter}", $stockRow['id']);
                $worksheet->setCellValue("B{$counter}", $stockRow['name']);
                $worksheet->setCellValue("C{$counter}", $stockRow['manufacturer_code']);
                $worksheet->setCellValue("D{$counter}", $stockBegin);
                $worksheet->setCellValue("E{$counter}", $stockIn);
                $worksheet->setCellValue("F{$counter}", $stockOut);
                $worksheet->setCellValue("G{$counter}", $stokEnd);
                $worksheet->setCellValue("H{$counter}", $inventoryValue);
                $totalStock += $stokEnd;
                $totalValue += $inventoryValue;
                
                $counter++;
            }
            
            $worksheet->getStyle("F{$counter}:H{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("F{$counter}", 'TOTAL');
            $worksheet->setCellValue("G{$counter}", $totalStock);
            $worksheet->setCellValue("H{$counter}", $totalValue);
            $counter++;$counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Posisi Stok.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}