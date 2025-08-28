<?php

class StockCardByWarehouseController extends Controller {

    public $layout = '//layouts/column3';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockCardWarehouseReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $warehouseId = (isset($_GET['WarehouseId'])) ? $_GET['WarehouseId'] : 5;

        $stockCardSummary = new StockCardByWarehouseSummary($product->searchByStockCard());
        $stockCardSummary->setupLoading();
        $stockCardSummary->setupPaging($pageSize, $currentPage);
        $stockCardSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'warehouseId' => $warehouseId,
        );
        $stockCardSummary->setupFilter($filters);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($stockCardSummary, $startDate, $endDate, $warehouseId);
        }

        $this->render('summary', array(
            'stockCardSummary' => $stockCardSummary,
            'warehouseId' => $warehouseId,
            'product' => $product,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
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

    public function actionAjaxJsonProduct() {
        if (Yii::app()->request->isAjaxRequest) {
            $productId = (isset($_POST['ProductId'])) ? $_POST['ProductId'] : '';
            $product = Product::model()->findByPk($productId);

            $object = array(
                'product_name' => CHtml::value($product, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentOut/show', 'id' => $model->id));
        }
    }
    
    protected function saveToExcel($stockCardSummary, $startDate, $endDate, $warehouseId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);
        $warehouse = Warehouse::model()->findByPk($warehouseId);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Mutasi per Gudang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Mutasi per Gudang');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        $worksheet->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Mutasi per Gudang ' . CHtml::value($warehouse, 'name'));
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:S5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:S5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:S5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'ID');
        $worksheet->setCellValue('C5', 'Produk');
        $worksheet->setCellValue('D5', 'Code');
        $worksheet->setCellValue('E5', 'Category');
        $worksheet->setCellValue('F5', 'Brand');
        $worksheet->setCellValue('G5', 'Tanggal');
        $worksheet->setCellValue('H5', 'Jenis Transaksi');
        $worksheet->setCellValue('I5', 'Transaksi #');
        $worksheet->setCellValue('J5', 'Gudang');
        $worksheet->setCellValue('K5', 'Stok Awal');
        $worksheet->setCellValue('L5', 'Nilai Awal');
        $worksheet->setCellValue('M5', 'Masuk');
        $worksheet->setCellValue('N5', 'Nilai Masuk');
        $worksheet->setCellValue('O5', 'Keluar');
        $worksheet->setCellValue('P5', 'Nilai Keluar');
        $worksheet->setCellValue('Q5', 'Nilai (+/-)');
        $worksheet->setCellValue('R5', 'Stok Akhir');
        $worksheet->setCellValue('S5', 'Nilai Akhir');

        $counter = 7;
        $incrementNumber = 1;

        foreach ($stockCardSummary->dataProvider->data as $header) {
            $stock = $header->getBeginningStockReport($startDate, $warehouse->branch_id);
            $beginningValue = $header->getBeginningValueReport($startDate, $warehouse->branch_id);
            $stockData = $header->getInventoryStockReport($startDate, $endDate, $warehouse->branch_id);
            $totalStockIn = 0;
            $totalStockOut = 0;
            $beginningStock = $stock;
            $beginningStockValue = $beginningValue;
            
            foreach ($stockData as $stockRow) {
                $stockIn = $stockRow['stock_in'];
                $stockOut = $stockRow['stock_out'];
                $stock += $stockIn + $stockOut;
                $currentValue = ($stockIn + $stockOut) * $stockRow['purchase_price'];
                $inventoryInValue = $stockRow['purchase_price'] * $stockIn;
                $inventoryOutValue = $stockRow['purchase_price'] * $stockOut;
                $inventoryValue = $stockRow['purchase_price'] * $stock;
                
                $worksheet->setCellValue("A{$counter}", $incrementNumber);
                $worksheet->setCellValue("B{$counter}", $header->id);
                $worksheet->setCellValue("C{$counter}", $header->name);
                $worksheet->setCellValue("D{$counter}", $header->code);
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'productMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubCategory.name'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'brand.name') . ' - ' . CHtml::value($header, 'subBrand.name') . ' - ' . CHtml::value($header, 'subBrandSeries.name'));
                $worksheet->setCellValue("G{$counter}", $stockRow['transaction_date']);
                $worksheet->setCellValue("H{$counter}", $stockRow['transaction_type']);
                $worksheet->setCellValue("I{$counter}", $stockRow['transaction_number']);
                $worksheet->setCellValue("J{$counter}", $stockRow['warehouse']);
                $worksheet->setCellValue("K{$counter}", $beginningStock);
                $worksheet->setCellValue("L{$counter}", $beginningStockValue);
                $worksheet->setCellValue("M{$counter}", $stockIn);
                $worksheet->setCellValue("N{$counter}", $inventoryInValue);
                $worksheet->setCellValue("O{$counter}", $stockOut);
                $worksheet->setCellValue("P{$counter}", $inventoryOutValue);
                $worksheet->setCellValue("Q{$counter}", $currentValue);
                $worksheet->setCellValue("R{$counter}", $stock);
                $worksheet->setCellValue("S{$counter}", $inventoryValue);
                
                $totalStockIn += $stockIn;
                $totalStockOut += $stockOut;
                $counter++;
            
            }
            
            $worksheet->getStyle("A{$counter}:Q{$counter}")->getFont()->setBold(true);
            $worksheet->getStyle("K{$counter}:Q{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $worksheet->setCellValue("L{$counter}", 'TOTAL');
            $worksheet->setCellValue("M{$counter}", $totalStockIn);
            $worksheet->setCellValue("N{$counter}", $totalStockOut);
            
            $counter++;$counter++;
            
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_mutasi_per_gudang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}