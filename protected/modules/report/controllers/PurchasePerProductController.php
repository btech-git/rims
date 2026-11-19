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
            if (!(Yii::app()->user->checkAccess('purchaseProductSummaryReport'))) {
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
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';

        $purchasePerProductSummary = new PurchasePerProductSummary($product->search());
        $purchasePerProductSummary->setupLoading();
        $purchasePerProductSummary->setupPaging($pageSize, $currentPage);
        $purchasePerProductSummary->setupSorting();
        $purchasePerProductSummary->setupFilter($startDate, $endDate, $branchId, $supplierId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchasePerProductSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'product' => $product,
            'productDataProvider' => $productDataProvider,
            'purchasePerProductSummary' => $purchasePerProductSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
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

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Pembelian per Parts Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian per Parts Summary');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');

        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Pembelian per Parts Summary');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:G5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Product Name');
        $worksheet->setCellValue('D5', 'Brand');
        $worksheet->setCellValue('E5', 'Category');
        $worksheet->setCellValue('F5', 'Quantity');
        $worksheet->setCellValue('G5', 'Price');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $totalPurchase = '0.00';
        $totalQuantity = 0;
        
        foreach ($dataProvider->data as $header) {
            $purchasePrice = $header->getPurchasePriceReport($startDate, $endDate, $branchId);
            $purchaseQuantity = $header->getTotalQuantityPurchase($startDate, $endDate, $branchId);

            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'manufacturer_code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'brand.name') . ' - ' . CHtml::value($header, 'subBrand.name') . ' - ' . CHtml::value($header, 'subBrandSeries.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'productMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubCategory.name'));
            $worksheet->setCellValue("F{$counter}", $purchaseQuantity);
            $worksheet->setCellValue("G{$counter}", $purchasePrice);
            
            $totalQuantity += $purchaseQuantity;
            $totalPurchase += $purchasePrice;
            $counter++;
        }
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);

        $worksheet->setCellValue("E{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $totalQuantity);
        $worksheet->setCellValue("G{$counter}", $totalPurchase);
        
        $counter++;
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="pembelian_per_parts_summary.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
