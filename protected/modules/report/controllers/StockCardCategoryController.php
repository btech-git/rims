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
            if (!(Yii::app()->user->checkAccess('stockPositionReport'))) {
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

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        $worksheet->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L3')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Posisi Stok');
        $worksheet->setCellValue('A3', 'Periode: ' . $endDateFormatted);

        $worksheet->getStyle("A5:L5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:L5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:L5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Category');
        $worksheet->setCellValue('C5', 'ID');
        $worksheet->setCellValue('D5', 'Code');
        $worksheet->setCellValue('E5', 'Name');
        $worksheet->setCellValue('F5', 'Nilai Awal');
        $worksheet->setCellValue('G5', 'Stok Awal');
        $worksheet->setCellValue('H5', 'Masuk');
        $worksheet->setCellValue('I5', 'Keluar');
        $worksheet->setCellValue('J5', 'Stok Akhir');
        $worksheet->setCellValue('K5', 'Nilai (+/-)');
        $worksheet->setCellValue('L5', 'Nilai Akhir');

        $counter = 7;
        $incrementNumber = 1;
        $grandTotalStock = '0.00';
        $grandTotalValue = '0.00';
        
        foreach ($stockCardSummary->dataProvider->data as $header) {
            $totalStock = '0.00';
            $totalValue = '0.00';
            $stockData = $header->getInventoryStockReport($endDate, $branchId); 
            
            foreach ($stockData as $stockRow) {
                $product = Product::model()->findByPk($stockRow['id']);
                $averageCogs = $product->getAverageCogs();
                $stockBegin = $product->getBeginningStockCardReport($branchId);
                $stockIn = $stockRow['stock_in'];
                $stockOut = $stockRow['stock_out'];
                $stokEnd = $stockBegin + $stockIn + $stockOut;
                $valueDifference = ($stockIn + $stockOut) * $averageCogs;
                $inventoryValue = $averageCogs * $stokEnd;
            
                $worksheet->setCellValue("A{$counter}", $incrementNumber);
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'productMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubMasterCategory.name'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'id'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'code'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'name'));
//                $worksheet->setCellValue("F{$counter}", $stockBegin);
//                $worksheet->setCellValue("G{$counter}", $stockBegin);
                $worksheet->setCellValue("H{$counter}", $stockIn);
                $worksheet->setCellValue("I{$counter}", $stockOut);
                $worksheet->setCellValue("J{$counter}", $stokEnd);
                $worksheet->setCellValue("K{$counter}", $valueDifference);
                $worksheet->setCellValue("L{$counter}", $inventoryValue);
                
                $totalStock += $stokEnd;
                $totalValue += $inventoryValue;
                
                $counter++;
            }
            $grandTotalStock += $totalStock;
            $grandTotalValue += $totalValue;
            
            $worksheet->getStyle("F{$counter}:L{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("I{$counter}", 'TOTAL');
            $worksheet->setCellValue("J{$counter}", $totalStock);
            $worksheet->setCellValue("L{$counter}", $totalValue);
            $counter++;$counter++;
        }
            
        $worksheet->getStyle("F{$counter}:L{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("I{$counter}", 'GRAND TOTAL');
        $worksheet->setCellValue("J{$counter}", $grandTotalStock);
        $worksheet->setCellValue("L{$counter}", $grandTotalValue);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_posisi_stok.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}