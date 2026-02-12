<?php

class SaleRetailProductController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleProductSummaryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        $productDataProvider = $product->search();
        $productDataProvider->pagination->pageVar = 'page_dialog';
        $productDataProvider->criteria->compare('t.status', 'Active');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';

        $saleRetailProductSummary = new SaleRetailProductSummary($product->search());
        $saleRetailProductSummary->setupLoading();
        $saleRetailProductSummary->setupPaging($pageSize, $currentPage);
        $saleRetailProductSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerType' => $customerType,
        );
        $saleRetailProductSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleRetailProductSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
                'customerType' => $customerType,
            ));
        }

        $this->render('summary', array(
            'saleRetailProductSummary' => $saleRetailProductSummary,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
            'customerType' => $customerType,
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

    public function actionAjaxJsonProduct() {
        if (Yii::app()->request->isAjaxRequest) {
            $productId = (isset($_POST['Product']['id'])) ? $_POST['Product']['id'] : '';
            $product = Product::model()->findByPk($productId);

            $object = array(
                'product_name' => CHtml::value($product, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = $options['startDate'];
        $endDate = $options['endDate'];
        $branchId = $options['branchId'];
        $customerType = $options['customerType'];
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Penjualan Retail Product');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail Product');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');

        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan Retail Product');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:K5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Brand');
        $worksheet->setCellValue('E5', 'Sub Brand');
        $worksheet->setCellValue('F5', 'Master Category');
        $worksheet->setCellValue('G5', 'Sub Master Category');
        $worksheet->setCellValue('H5', 'Sub Category');
        $worksheet->setCellValue('I5', 'Quantity');
        $worksheet->setCellValue('J5', 'Satuan');
        $worksheet->setCellValue('K5', 'Total');

        $worksheet->getStyle('A5:K5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalSale = '0.00';
        $totalQuantity = '0.00';
        foreach ($dataProvider->data as $header) {
            $totalQuantitySales = $header->getTotalQuantitySales($startDate, $endDate, $branchId, $customerType);
            $totalAmountSales = $header->getTotalSales($startDate, $endDate, $branchId, $customerType);

            $worksheet->setCellValue("A{$counter}", CHtml::encode($header->id));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->manufacturer_code));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'brand.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'subBrand.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'productMasterCategory.name')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'productSubCategory.name')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode($totalQuantitySales));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'unit.name')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode($totalAmountSales));

            $totalQuantity += $totalQuantitySales;
            $totalSale += $totalAmountSales;
            $counter++;
        }
        
        $worksheet->setCellValue("H{$counter}", 'TOTAL');
        $worksheet->setCellValue("I{$counter}", CHtml::encode($totalQuantity));
        $worksheet->setCellValue("I{$counter}", CHtml::encode($totalSale));
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Retail Product.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
