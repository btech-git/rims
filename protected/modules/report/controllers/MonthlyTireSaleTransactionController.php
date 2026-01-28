<?php

class MonthlyTireSaleTransactionController extends Controller {

    public $layout = '//layouts/column1';

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if (
            $filterChain->action->id === 'check' || 
            $filterChain->action->id === 'detail' || 
            $filterChain->action->id === 'redirectTransaction'
        ) {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        
        $product = Search::bind(new Product(), isset($_GET['Product']) ? $_GET['Product'] : '');
        $productDataProvider = $product->searchByTireSaleReport($currentPage, $year, $month);
        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $product->unsetAttributes();
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($productDataProvider, $branches, $year, $month);
        }

        $this->render('summary', array(
            'yearList' => $yearList,
            'year' => $year,
            'yearNow' => $yearNow,
            'month' => $month,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'currentPage' => $currentPage,
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

    public function actionTransactionInfo($productId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = InvoiceDetail::model()->searchByTransactionInfo($productId, $startDate, $endDate, $branchId, $page);
        $product = Product::model()->findByPk($productId);
        $branch = Branch::model()->findByPk($branchId);
        
        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'product' => $product,
            'branch' => $branch,
        ));
    }

    protected function saveToExcel($productDataProvider, $branches, $year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Ban Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Ban Bulanan');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');
        
        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:P5")->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Penjualan Ban Bulanan');
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' - ' . $year);

        $columnHeader = 'H';
        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Size');
        $worksheet->setCellValue('E5', 'Brand');
        $worksheet->setCellValue('F5', 'Category');
        $worksheet->setCellValue('G5', 'Satuan');
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnHeader}5", CHtml::value($branch, 'code'));
            $columnHeader++;
        }
        $worksheet->setCellValue("{$columnHeader}5", 'Total');

        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$columnHeader}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($productDataProvider->data as $product) {
            $tireSaleTotalQuantities = $product->getTireSaleTotalQuantitiesReport($year, $month);
            $totalQuantity = 0;
            $column = 'H'; 
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($product, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($product, 'manufacturer_code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($product, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($product, 'tireSize.tireName'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($product, 'brand.name') . ' - ' . CHtml::value($product, 'subBrand.name') . ' - ' . CHtml::value($product, 'subBrandSeries.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($product, 'productMasterCategory.name') . ' - ' . CHtml::value($product, 'productSubMasterCategory.name') . ' - ' . CHtml::value($product, 'productSubCategory.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($product, 'unit.name'));
            
            foreach ($branches as $branch) {
                $saleQuantity = 0; 
                foreach ($tireSaleTotalQuantities as $i => $tireSaleTotalQuantity) {
                    if ($tireSaleTotalQuantity['branch_id'] == $branch->id) {
                        $saleQuantity = CHtml::value($tireSaleTotalQuantities[$i], 'total_quantity');
                        break;
                    }
                }
                $worksheet->setCellValue("{$column}{$counter}", $saleQuantity);
                $column++;

                $totalQuantity += $saleQuantity;
            }
            
            $worksheet->setCellValue("{$column}{$counter}", $totalQuantity);
            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_ban_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
