<?php

class PurchaseInvoiceSummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseSummaryReport'))) {
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
        $supplierName = (isset($_GET['SupplierName'])) ? $_GET['SupplierName'] : '';
        $branchId = (isset($_GET['TransactionPurchaseOrder']['main_branch_id'])) ? $_GET['TransactionPurchaseOrder']['main_branch_id'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $purchaseInvoiceSummary = new PurchaseInvoiceSummary($purchaseOrderHeader->search());
        $purchaseInvoiceSummary->setupLoading();
        $purchaseInvoiceSummary->setupPaging($pageSize, $currentPage);
        $purchaseInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierName' => $supplierName,
        );
        $purchaseInvoiceSummary->setupFilter($filters);

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseInvoiceSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'purchaseOrderHeader' => $purchaseOrderHeader,
            'purchaseInvoiceSummary' => $purchaseInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplierName' => $supplierName,
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

    public function reportGrandTotal($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->total_price;

        return $grandTotal;
    }

    public function reportTotalPayment($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->payment_amount;

        return $grandTotal;
    }

    public function reportTotalRemaining($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data)
            $grandTotal += $data->payment_left;

        return $grandTotal;
    }

    protected function saveToExcel($purchaseInvoiceSummary, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Laporan Faktur Pembelian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Pembelian');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        
        $worksheet->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Faktur Pembelian');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:M5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:M5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:M5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Faktur #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Type');
        $worksheet->setCellValue('D5', 'Supplier');
        $worksheet->setCellValue('E5', 'Parts');
        $worksheet->setCellValue('F5', 'Grand Total');
        $worksheet->setCellValue('G5', 'Payment');
        $worksheet->setCellValue('H5', 'Remaining');
        $worksheet->setCellValue('I5', 'Status');
        $worksheet->setCellValue('J5', 'Payment #');
        $worksheet->setCellValue('K5', 'Tanggal');
        $worksheet->setCellValue('L5', 'Jumlah');
        $worksheet->setCellValue('M5', 'Memo');

        $counter = 7;

        foreach ($purchaseInvoiceSummary->dataProvider->data as $header) {
            foreach ($header->transactionReceiveItems as $receiveItem) {
                if (!empty($receiveItem->payOutDetails )) {
                    foreach ($receiveItem->payOutDetails as $paymentOutDetail) {
                        $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'purchase_order_no'));
                        $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'purchase_order_date'));
                        $worksheet->setCellValue("C{$counter}", $header->getPurchaseStatus($header->purchase_type));
                        $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'supplier.company'));
                        $worksheet->setCellValue("E{$counter}", $header->getProductLists());
                        $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'total_price'));
                        $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'payment_amount'));
                        $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'payment_left'));
                        $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'status_document'));
                        $worksheet->setCellValue("J{$counter}", CHtml::value($paymentOutDetail, 'paymentOut.payment_number'));
                        $worksheet->setCellValue("K{$counter}", CHtml::value($paymentOutDetail, 'paymentOut.payment_date'));
                        $worksheet->setCellValue("L{$counter}", CHtml::value($paymentOutDetail, 'amount'));
                        $worksheet->setCellValue("M{$counter}", CHtml::value($paymentOutDetail, 'memo'));

                        $counter++;
                    }
                }
            }
        }

        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("H{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:C{$counter}");
        $worksheet->setCellValue("A{$counter}", 'Total Pembelian');
        $worksheet->setCellValue("D{$counter}", 'Rp');
        $worksheet->setCellValue("E{$counter}", $this->reportGrandTotal($purchaseInvoiceSummary->dataProvider));
        $worksheet->setCellValue("F{$counter}", $this->reportTotalPayment($purchaseInvoiceSummary->dataProvider));
        $worksheet->setCellValue("G{$counter}", $this->reportTotalRemaining($purchaseInvoiceSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_faktur_pembelian.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
