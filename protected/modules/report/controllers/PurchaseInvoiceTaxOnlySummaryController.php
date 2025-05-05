<?php

class PurchaseInvoiceTaxOnlySummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseTaxReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $purchaseOrderHeader = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
//        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';
//        $branchId = (isset($_GET['TransactionPurchaseOrder']['main_branch_id'])) ? $_GET['TransactionPurchaseOrder']['main_branch_id'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseInvoiceSummary = new PurchaseInvoiceTaxOnlySummary($purchaseOrderHeader->search());
        $purchaseInvoiceSummary->setupLoading();
        $purchaseInvoiceSummary->setupPaging($pageSize, $currentPage);
        $purchaseInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
//            'supplierName' => $supplierName,
        );
        $purchaseInvoiceSummary->setupFilter($filters);

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseInvoiceSummary, $purchaseOrderHeader, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchaseOrderHeader' => $purchaseOrderHeader,
            'purchaseInvoiceSummary' => $purchaseInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
//            'supplierName' => $supplierName,
            'supplier'=>$supplier,
            'supplierDataProvider'=>$supplierDataProvider,
        ));
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['TransactionPurchaseOrder']['supplier_id'])) ? $_POST['TransactionPurchaseOrder']['supplier_id'] : '';
            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'name'),
                'supplier_company' => CHtml::value($supplier, 'company'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($purchaseInvoiceSummary, $purchaseOrderHeader, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Faktur Pembelian PPn');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Pembelian PPn');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');
        $worksheet->mergeCells('A4:N4');
        
        $worksheet->getStyle('A1:N3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($purchaseOrderHeader, 'mainBranch.name')));
        $worksheet->setCellValue('A2', 'Laporan Faktur Pembelian PPn');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:N6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:N6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:N6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'PO #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('D6', 'Invoice #');
        $worksheet->setCellValue('E6', 'Tanggal Invoice');
        $worksheet->setCellValue('F6', 'Tanggal SJ');
        $worksheet->setCellValue('G6', 'SJ #');
        $worksheet->setCellValue('H6', 'Faktur Pajak #');
        $worksheet->setCellValue('I6', 'Ppn/Non');
        $worksheet->setCellValue('J6', 'Price Bruto (Rp)');
        $worksheet->setCellValue('K6', 'Disc (Rp)');
        $worksheet->setCellValue('L6', 'DPP (Rp)');
        $worksheet->setCellValue('M6', 'PPn (Rp)');
        $worksheet->setCellValue('N6', 'Total (Rp)');

        $counter = 7;

        foreach ($purchaseInvoiceSummary->dataProvider->data as $header) {
            $receiveItems = TransactionReceiveItem::model()->findAll(array(
                'condition' => 'purchase_order_id = :purchase_order_id AND invoice_date BETWEEN :start_date AND :end_date AND user_id_cancelled IS NULL',
                'params' => array(
                    ':purchase_order_id' => $header->id,
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                )
            ));
            foreach ($receiveItems as $receiveItem) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_no')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_date')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($receiveItem, 'invoice_number')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($receiveItem, 'invoice_date')) . ' ' . substr(CHtml::encode($receiveItem->created_datetime), -8));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($receiveItem, 'receive_item_date')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($receiveItem, 'supplier_delivery_number')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($receiveItem, 'invoice_tax_number')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'taxStatus')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($receiveItem, 'totalRetailPrice')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($receiveItem, 'totalPurchaseDiscount')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($receiveItem, 'subTotal')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($receiveItem, 'taxNominal')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($receiveItem, 'grandTotal')));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Faktur Pembelian PPn.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
