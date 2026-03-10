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
        $documentProperties->setTitle('Faktur Pembelian PPn');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Pembelian PPn');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');
        
        $worksheet->getStyle('A1:O5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($purchaseOrderHeader, 'mainBranch.name'));
        $worksheet->setCellValue('A2', 'Faktur Pembelian PPn (Rincian & Detail)');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:O5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:O5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'PO #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Supplier');
        $worksheet->setCellValue('E5', 'Invoice #');
        $worksheet->setCellValue('F5', 'Tanggal Invoice');
        $worksheet->setCellValue('G5', 'Tanggal SJ');
        $worksheet->setCellValue('H5', 'SJ #');
        $worksheet->setCellValue('I5', 'Faktur Pajak #');
        $worksheet->setCellValue('J5', 'Ppn/Non');
        $worksheet->setCellValue('K5', 'Price Bruto (Rp)');
        $worksheet->setCellValue('L5', 'Disc (Rp)');
        $worksheet->setCellValue('M5', 'DPP (Rp)');
        $worksheet->setCellValue('N5', 'PPn (Rp)');
        $worksheet->setCellValue('O5', 'Total (Rp)');

        $counter = 6;
        $ordinalNumber = 1;

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
                $worksheet->setCellValue("A{$counter}", $ordinalNumber);
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'purchase_order_no'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'purchase_order_date'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'supplier.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($receiveItem, 'invoice_number'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($receiveItem, 'invoice_date') . ' ' . substr($receiveItem->created_datetime, -8));
                $worksheet->setCellValue("G{$counter}", CHtml::value($receiveItem, 'receive_item_date'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($receiveItem, 'supplier_delivery_number'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($receiveItem, 'invoice_tax_number'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'taxStatus'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($receiveItem, 'totalRetailPrice'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($receiveItem, 'totalPurchaseDiscount'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($receiveItem, 'subTotal'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($receiveItem, 'taxNominal'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($receiveItem, 'grandTotal'));

                $counter++; $ordinalNumber++;
            }
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=faktur_pembelian_ppn.xls");
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
