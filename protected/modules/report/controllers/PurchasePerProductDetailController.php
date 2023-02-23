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
            if (!(Yii::app()->user->checkAccess('purchaseOrderReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $product = Search::bind(new Product('search'), isset($_GET['Product']) ? $_GET['Product'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchasePerProductSummary = new PurchasePerProductSummary($product->search());
        $purchasePerProductSummary->setupLoading();
        $purchasePerProductSummary->setupPaging($pageSize, $currentPage);
        $purchasePerProductSummary->setupSorting();
        $purchasePerProductSummary->setupFilter($startDate, $endDate);

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchasePerProductSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'product' => $product,
            'purchasePerProductSummary' => $purchasePerProductSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pembelian per Barang Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian per Barang Detail');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');

        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);

        $worksheet->setCellValue('A2', 'Laporan Pembelian per Barang Detail');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:O5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'PO #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Supplier');
        $worksheet->setCellValue('D5', 'Product Name');
        $worksheet->setCellValue('E5', 'Code');
        $worksheet->setCellValue('F5', 'Brand');
        $worksheet->setCellValue('G5', 'Sub Brand');
        $worksheet->setCellValue('H5', 'Sub Brand Series');
        $worksheet->setCellValue('I5', 'Category');
        $worksheet->setCellValue('J5', 'Sub Master Category');
        $worksheet->setCellValue('K5', 'Sub Category ');
        $worksheet->setCellValue('L5', 'Quantity');
        $worksheet->setCellValue('M5', 'Price');
        $worksheet->setCellValue('N5', 'Discount');
        $worksheet->setCellValue('O5', 'Total');

        $worksheet->getStyle('A5:O5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        
        foreach ($dataProvider->data as $header) {
            $totalPurchase = 0.00;
            
            $purchaseOrderDetailCriteria = new CDbCriteria;
            $purchaseOrderDetailCriteria->join = 'INNER JOIN rims_transaction_purchase_order po ON po.id = t.purchase_order_id';
            $purchaseOrderDetailCriteria->addCondition("po.purchase_order_date BETWEEN :start_date AND :end_date AND t.product_id = :product_id");
            $purchaseOrderDetailCriteria->params = array(
                ':start_date' => $options['startDate'],
                ':end_date' => $options['endDate'],
                ':product_id' => $header->id,
            );
            $purchaseDetails = TransactionPurchaseOrderDetail::model()->findAll($purchaseOrderDetailCriteria);

            if (!empty($purchaseDetails)) {
                foreach ($purchaseDetails as $purchaseDetail) {
                    $totalPrice = CHtml::value($purchaseDetail, 'total_price');
                    $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.purchase_order_no')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.purchase_order_date')));
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($purchaseDetail, 'purchaseOrder.supplier.name')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                    $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'manufacturer_code')));
                    $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'brand.name')));
                    $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'subBrand.name')));
                    $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'subBrandSeries.name')));
                    $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'productMasterCategory.name')));
                    $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'productSubMasterCategory.name')));
                    $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'productSubCategory.name')));
                    $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($purchaseDetail, 'quantity')));
                    $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($purchaseDetail, 'unit_price')));
                    $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($purchaseDetail, 'discount')));
                    $worksheet->setCellValue("O{$counter}", CHtml::encode($totalPrice));
                    $totalPurchase += $totalPrice;

                    $counter++;
                }
            }
            $worksheet->setCellValue("N{$counter}", 'Total');
            $worksheet->setCellValue("O{$counter}", CHtml::encode($totalPurchase));
            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian per Barang Detail.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
