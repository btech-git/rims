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
            $this->saveToExcel($purchasePerProductSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate, 
                'branchId' => $branchId,
                'supplierId' => $supplierId,
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
        $supplierId = $options['supplierId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pembelian per Barang Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian per Barang Detail');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');

        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Pembelian per Barang Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:L5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Product Name');
        $worksheet->setCellValue('B5', 'Code');
        $worksheet->setCellValue('C5', 'Brand');
        $worksheet->setCellValue('D5', 'Category');
        $worksheet->setCellValue('E5', 'PO #');
        $worksheet->setCellValue('F5', 'Tanggal');
        $worksheet->setCellValue('G5', 'Supplier');
        $worksheet->setCellValue('H5', 'Quantity');
        $worksheet->setCellValue('I5', 'Retail Price');
        $worksheet->setCellValue('J5', 'Discount');
        $worksheet->setCellValue('K5', 'Unit Price');
        $worksheet->setCellValue('L5', 'Total');

        $worksheet->getStyle('A5:L5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        $grandTotalPurchase = '0.00';
        foreach ($dataProvider->data as $header) {
            $totalPurchase = '0.00';
            $totalQuantity = '0.00';
            $purchaseOrderData = $header->getPurchasePerProductReport($startDate, $endDate, $branchId, $supplierId);
            if (!empty($purchaseOrderData)) {
                foreach ($purchaseOrderData as $purchaseOrderItem) {
                    $totalPrice = $purchaseOrderItem['total_price'];
                    $quantity = $purchaseOrderItem['quantity'];
                    $worksheet->getStyle("H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $worksheet->getStyle("I{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'name'));
                    $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'manufacturer_code'));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'brand.name') . ' - ' . CHtml::value($header, 'subBrand.name') . ' - ' . CHtml::value($header, 'subBrandSeries.name'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'productMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubMasterCategory.name') . ' - ' . CHtml::value($header, 'productSubCategory.name'));
                    $worksheet->setCellValue("E{$counter}", $purchaseOrderItem['purchase_order_no']);
                    $worksheet->setCellValue("F{$counter}", $purchaseOrderItem['purchase_order_date']);
                    $worksheet->setCellValue("G{$counter}", $purchaseOrderItem['company']);
                    $worksheet->setCellValue("H{$counter}", $quantity);
                    $worksheet->setCellValue("I{$counter}", $purchaseOrderItem['retail_price']);
                    $worksheet->setCellValue("J{$counter}", $purchaseOrderItem['discount']);
                    $worksheet->setCellValue("K{$counter}", $purchaseOrderItem['unit_price']);
                    $worksheet->setCellValue("L{$counter}", $totalPrice);
                    
                    $totalPurchase += $totalPrice;
                    $totalQuantity += $quantity;

                    $counter++;
                }
            
                $worksheet->getStyle("G{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->getStyle("H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $worksheet->getStyle("L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->getStyle("G{$counter}:L{$counter}")->getFont()->setBold(true);
                
                $worksheet->setCellValue("G{$counter}", 'Total');
                $worksheet->setCellValue("H{$counter}", $totalQuantity);
                $worksheet->setCellValue("L{$counter}", $totalPurchase);
                $grandTotalPurchase += $totalPurchase;
                $counter++;$counter++;
            }
        }
            
        $worksheet->setCellValue("K{$counter}", 'TOTAL PEMBELIAN');
        $worksheet->setCellValue("L{$counter}", $grandTotalPurchase);
        $counter++;$counter++;
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="pembelian_per_barang_rincian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
