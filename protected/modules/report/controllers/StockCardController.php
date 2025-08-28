<?php

class StockCardController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('stockCardItemReport'))) {
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
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $stockCardSummary = new StockCardSummary($product->searchByStockCard());
        $stockCardSummary->setupLoading();
        $stockCardSummary->setupPaging($pageSize, $currentPage);
        $stockCardSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $stockCardSummary->setupFilter($filters);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($stockCardSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'product' => $product,
            'stockCardSummary' => $stockCardSummary,
            'startDate' => $startDate,
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
    protected function saveToExcel($stockCardSummary, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Kartu Stok');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Kartu Stok');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        $worksheet->mergeCells('A4:O4');
        $worksheet->getStyle('A1:O3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Kartu Stok');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:O6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:O6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:O6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'ID');
        $worksheet->setCellValue('C6', 'Produk');
        $worksheet->setCellValue('D6', 'Code');
        $worksheet->setCellValue('E6', 'Category');
        $worksheet->setCellValue('F6', 'Brand');
        $worksheet->setCellValue('G6', 'Tanggal');
        $worksheet->setCellValue('H6', 'Jenis Transaksi');
        $worksheet->setCellValue('I6', 'Transaksi #');
        $worksheet->setCellValue('J6', 'Keterangan');
        $worksheet->setCellValue('K6', 'Gudang');
        $worksheet->setCellValue('L6', 'Stok Awal');
        $worksheet->setCellValue('M6', 'Masuk');
        $worksheet->setCellValue('N6', 'Keluar');
        $worksheet->setCellValue('O6', 'Stok Akhir');

        $counter = 8;
        $incrementNumber = 1;
        
        foreach ($stockCardSummary->dataProvider->data as $header) {
            $stock = $header->getBeginningStockReport($startDate, $branchId); 
            $stockData = $header->getInventoryStockReport($startDate, $endDate, $branchId);
            $beginningStock = $stock;
            
            foreach ($stockData as $stockRow) {
                $stockIn = $stockRow['stock_in'];
                $stockOut = $stockRow['stock_out'];
                $stock += $stockIn + $stockOut;
                
                $worksheet->setCellValue("A{$counter}", $incrementNumber);
                $worksheet->setCellValue("B{$counter}", $header->id);
                $worksheet->setCellValue("C{$counter}", $header->name);
                $worksheet->setCellValue("D{$counter}", $header->manufacturer_code);
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'masterSubCategoryCode'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'brand.name') . ' - ' . CHtml::value($header, 'subBrand.name') . ' - ' . CHtml::value($header, 'subBrandSeries.name'));
                $worksheet->setCellValue("G{$counter}", $stockRow['transaction_date']);
                $worksheet->setCellValue("H{$counter}", $stockRow['transaction_type']);
                $worksheet->setCellValue("I{$counter}", $stockRow['transaction_number']);
                $worksheet->setCellValue("J{$counter}", $stockRow['notes']);
                $worksheet->setCellValue("K{$counter}", $stockRow['warehouse']);
                $worksheet->setCellValue("L{$counter}", $beginningStock);
                $worksheet->setCellValue("M{$counter}", $stockIn);
                $worksheet->setCellValue("N{$counter}", $stockOut);
                $worksheet->setCellValue("O{$counter}", $stock);
                
                $beginningStock = $stock;
                $counter++; $incrementNumber++;
            }       
            $counter++;     
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="kartu_stok.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}