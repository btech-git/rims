<?php

class SaleRetailProductDetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleProductReport'))) {
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
        $documentProperties->setTitle('Rincian Penjualan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penjualan Barang');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');

        $worksheet->getStyle('A1:N5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Rincian Penjualan per Barang');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:N5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Brand');
        $worksheet->setCellValue('E5', 'Category');
        $worksheet->setCellValue('F5', 'Penjualan #');
        $worksheet->setCellValue('G5', 'Tanggal');
        $worksheet->setCellValue('H5', 'Customer');
        $worksheet->setCellValue('I5', 'Asuransi');
        $worksheet->setCellValue('J5', 'Plat #');
        $worksheet->setCellValue('K5', 'Kendaraan');
        $worksheet->setCellValue('L5', 'Quantity');
        $worksheet->setCellValue('M5', 'Harga');
        $worksheet->setCellValue('N5', 'Total');

        $worksheet->getStyle('A5:N5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $header) {
            $saleRetailData = $header->getSaleRetailProductDetailReport($startDate, $endDate, $branchId, $customerType);
            $totalSale = '0.00';
            
            foreach ($saleRetailData as $saleRetailRow) {
                $total = $saleRetailRow['total_price'];

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'id'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'manufacturer_code'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'name'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'brand.name') . ' - ' . CHtml::value($header, 'subBrand.name') . ' - ' . CHtml::value($header, 'subBrandSeries.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'productMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubCategory.name'));
                $worksheet->setCellValue("F{$counter}", $saleRetailRow['invoice_number']);
                $worksheet->setCellValue("G{$counter}", $saleRetailRow['invoice_date']);
                $worksheet->setCellValue("H{$counter}", $saleRetailRow['customer']);
                $worksheet->setCellValue("I{$counter}", $saleRetailRow['insurance']);
                $worksheet->setCellValue("J{$counter}", $saleRetailRow['plate_number']);
                $worksheet->setCellValue("K{$counter}", $saleRetailRow['car_make'] . ' - ' . $saleRetailRow['car_model'] . ' - ' . $saleRetailRow['car_sub_model']);
                $worksheet->setCellValue("L{$counter}", $saleRetailRow['quantity']);
                $worksheet->setCellValue("M{$counter}", $saleRetailRow['unit_price']);
                $worksheet->setCellValue("N{$counter}", $total);

                $totalSale += $total;
                $counter++;
            }

            $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);

            $worksheet->setCellValue("M{$counter}", 'TOTAL');
            $worksheet->setCellValue("N{$counter}", $totalSale);
            $counter++;$counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_penjualan_per_barang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
