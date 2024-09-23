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

        $warehouse = Search::bind(new Warehouse('search'), isset($_GET['Warehouse']) ? $_GET['Warehouse'] : '');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $productId = (isset($_GET['ProductId'])) ? $_GET['ProductId'] : '';

        $stockCardSummary = new StockCardByWarehouseSummary($warehouse->search());
        $stockCardSummary->setupLoading();
        $stockCardSummary->setupPaging($pageSize, $currentPage);
        $stockCardSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'productId' => $productId,
        );
        $stockCardSummary->setupFilter($filters);
        
        $product = new Product('search');
        $product->unsetAttributes();  // clear any default values

        if (isset($_GET['Product'])) {
            $product->attributes = $_GET['Product'];
        }

        $productDataProvider = $product->search();
        $productDataProvider->criteria->compare('t.status', 'Active');

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($stockCardSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'warehouse' => $warehouse,
            'stockCardSummary' => $stockCardSummary,
            'productId' => $productId,
            'product' => $product,
            'productDataProvider' => $productDataProvider,
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
            $this->redirect(array('/transaction/transactionPurchaseOrder/view', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentOut/view', 'id' => $model->id));
        }
    }
    
    protected function saveToExcel($stockCardSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Mutasi per Gudang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Mutasi per Gudang');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        $worksheet->getStyle('A1:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Mutasi per Gudang');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:H5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Jenis Transaksi');
        $worksheet->setCellValue('C5', 'Transaksi #');
        $worksheet->setCellValue('D5', 'Product');
        $worksheet->setCellValue('E5', 'Masuk');
        $worksheet->setCellValue('F5', 'Keluar');
        $worksheet->setCellValue('G5', 'Stok');
        $worksheet->setCellValue('H5', 'Nilai');

        $counter = 7;

        foreach ($stockCardSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->code);
            $worksheet->setCellValue("B{$counter}", $header->name);
            $worksheet->setCellValue("C{$counter}", $header->description);
            $stock = $header->getBeginningStockReport($startDate);
            $worksheet->setCellValue("G{$counter}", CHtml::encode($stock));
            
            $counter++;
            
            $stockData = $header->getInventoryStockReport($startDate, $endDate);
            $totalStockIn = 0;
            $totalStockOut = 0;
            
            foreach ($stockData as $stockRow) {
                $stockIn = $stockRow['stock_in'];
                $stockOut = $stockRow['stock_out'];
                $stock += $stockIn + $stockOut;
                $inventoryValue = $stockRow['purchase_price'] * $stock;
                
                $worksheet->setCellValue("A{$counter}", CHtml::encode($stockRow['transaction_date']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($stockRow['transaction_type']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($stockRow['transaction_number']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($stockRow['product_name']));
                $worksheet->setCellValue("E{$counter}", $stockIn);
                $worksheet->setCellValue("F{$counter}", $stockOut);
                $worksheet->setCellValue("G{$counter}", $stock);
                $worksheet->setCellValue("H{$counter}", $inventoryValue);
                
                $totalStockIn += $stockIn;
                $totalStockOut += $stockOut;
                $counter++;
            
            }
            
            $worksheet->getStyle("D{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $worksheet->setCellValue("D{$counter}", 'TOTAL');
            $worksheet->setCellValue("E{$counter}", CHtml::encode($totalStockIn));
            $worksheet->setCellValue("F{$counter}", CHtml::encode($totalStockOut));
            
            $counter++;$counter++;
            
        }

        for ($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Mutasi per Gudang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}