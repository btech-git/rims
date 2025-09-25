<?php

class PurchasePerProductDetailController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseProductReport'))) {
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
        
        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';
        $supplierDataProvider->criteria->compare('t.status', 'Active');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
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
            $this->saveToExcel($purchasePerProductSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate, 'branchId' => $branchId));
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
            'supplierId' => $supplierId,
            'supplier' => $supplier,
            'supplierDataProvider' => $supplierDataProvider,
        ));
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
        $documentProperties->setTitle('Laporan Pembelian per Barang Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian per Barang Detail');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');

        $worksheet->getStyle('A1:P5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Pembelian per Barang Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:P5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Product Name');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Brand');
        $worksheet->setCellValue('D5', 'Sub Brand');
        $worksheet->setCellValue('E5', 'Sub Brand Series');
        $worksheet->setCellValue('F5', 'Category');
        $worksheet->setCellValue('G5', 'Sub Master Category');
        $worksheet->setCellValue('H5', 'Sub Category ');
        $worksheet->setCellValue('I5', 'PO #');
        $worksheet->setCellValue('J5', 'Tanggal');
        $worksheet->setCellValue('K5', 'Supplier');
        $worksheet->setCellValue('L5', 'Quantity');
        $worksheet->setCellValue('M5', 'Retail Price');
        $worksheet->setCellValue('N5', 'Discount');
        $worksheet->setCellValue('O5', 'Unit Price');
        $worksheet->setCellValue('P5', 'Total');

        $worksheet->getStyle('A5:P5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        $grandTotalPurchase = 0.00;
        foreach ($dataProvider->data as $header) {
            
            $purchaseOrderDetailCriteria = new CDbCriteria;
            $purchaseOrderDetailCriteria->join = 'INNER JOIN rims_transaction_purchase_order po ON po.id = t.purchase_order_id';
            $purchaseOrderDetailCriteria->addCondition("substr(po.purchase_order_date, 1, 10) BETWEEN :start_date AND :end_date AND t.product_id = :product_id AND po.status_document NOT LIKE '%CANCEL%'");
            $purchaseOrderDetailCriteria->params = array(
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':product_id' => $header->id,
            );
            $purchaseDetails = TransactionPurchaseOrderDetail::model()->findAll($purchaseOrderDetailCriteria);

            if (!empty($purchaseDetails)) {
                $totalPurchase = 0.00;
                foreach ($purchaseDetails as $purchaseDetail) {
                    $totalPrice = CHtml::value($purchaseDetail, 'total_price');
                    $quantity = $purchaseOrderItem['quantity'];
                    $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'name'));
                    $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'manufacturer_code'));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'brand.name'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'subBrand.name'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'subBrandSeries.name'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'productMasterCategory.name'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'productSubMasterCategory.name'));
                    $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'productSubCategory.name'));
                    $worksheet->setCellValue("I{$counter}", CHtml::value($purchaseDetail, 'purchaseOrder.purchase_order_no'));
                    $worksheet->setCellValue("J{$counter}", CHtml::value($purchaseDetail, 'purchaseOrder.purchase_order_date'));
                    $worksheet->setCellValue("K{$counter}", CHtml::value($purchaseDetail, 'purchaseOrder.supplier.name'));
                    $worksheet->setCellValue("L{$counter}", CHtml::value($purchaseDetail, 'quantity'));
                    $worksheet->setCellValue("M{$counter}", CHtml::value($purchaseDetail, 'unit_price'));
                    $worksheet->setCellValue("N{$counter}", CHtml::value($purchaseDetail, 'discount'));
                    $worksheet->setCellValue("O{$counter}", $totalPrice);
                    $totalPurchase += $totalPrice;

                    $counter++;
                }
            
                $worksheet->setCellValue("N{$counter}", 'Total');
                $worksheet->setCellValue("O{$counter}", $totalPurchase);
                $grandTotalPurchase += $totalPurchase;
                $counter++;$counter++;
            }
        }
            
        $worksheet->setCellValue("N{$counter}", 'TOTAL PEMBELIAN');
        $worksheet->setCellValue("O{$counter}", $grandTotalPurchase);
        $counter++;$counter++;
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian per Barang Detail.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
