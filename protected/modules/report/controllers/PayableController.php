<?php

class PayableController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('accountingReport')) || !(Yii::app()->user->checkAccess('financeReport')))
                $this->redirect(array('/site/login'));
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
        $supplier_id = (isset($_GET['supplier_id'])) ? $_GET['supplier_id'] : '';

        $purchaseSummary = new PurchaseSummary($purchaseOrderHeader->search());
        $purchaseSummary->setupLoading();
        $purchaseSummary->setupPaging($pageSize, $currentPage);
        $purchaseSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
        );
        $purchaseSummary->setupFilter($filters);

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();

        if (isset($_POST['SaveToExcel'])) {
            $this->saveToExcel($purchaseSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'purchaseOrderHeader' => $purchaseOrderHeader,
            'purchaseSummary' => $purchaseSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'supplier_id' => $supplier_id,
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
                'supplier_code' => CHtml::value($supplier, 'code'),
                'supplier_mobile_phone' => CHtml::value($supplier, 'mobile_phone'),
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

    protected function saveToExcel($purchaseSummary, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Sinar Putra Metalindo');
        $documentProperties->setTitle('Laporan Faktur Penjualan Manual');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Penjualan Manual');

        $worksheet->mergeCells('A1:Y1');
        $worksheet->mergeCells('A2:Y2');
        $worksheet->mergeCells('A3:Y3');
        $worksheet->mergeCells('A4:Y4');
        $worksheet->getStyle('A1:Y3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Y3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Sinar Putra Metalindo');
        $worksheet->setCellValue('A2', 'Laporan Faktur Penjualan Manual');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->getStyle("A6:Y6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:Y6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:Y6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'No Pajak');
        $worksheet->setCellValue('D6', 'NPWP');
        $worksheet->setCellValue('E6', 'Code');
        $worksheet->setCellValue('F6', 'Customer');
        $worksheet->setCellValue('G6', 'Purchasesman');
//        $worksheet->setCellValue('H6', 'SPK #');
        $worksheet->setCellValue('I6', 'PO #');
        $worksheet->setCellValue('J6', 'Qty');
        $worksheet->setCellValue('K6', 'Berat');
        $worksheet->setCellValue('L6', 'Catatan');
        $worksheet->setCellValue('M6', 'Tanggal Tukar TT');
        $worksheet->setCellValue('N6', 'Tanggal TT');
        $worksheet->setCellValue('O6', 'Bulan');
        $worksheet->setCellValue('P6', 'Tahun');
        $worksheet->setCellValue('Q6', 'Jenis');
        $worksheet->setCellValue('R6', 'Tanggal Input');
        $worksheet->setCellValue('S6', 'DPP');
        $worksheet->setCellValue('T6', 'Discount');
        $worksheet->setCellValue('U6', 'Pembulatan');
        $worksheet->setCellValue('V6', 'PPn');
        $worksheet->setCellValue('W6', 'PPh');
        $worksheet->setCellValue('X6', 'Grand Total');
        $worksheet->setCellValue('Y6', 'User');

        $counter = 7;

        foreach ($purchaseSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->date);
            $worksheet->setCellValue("B{$counter}", $header->getCodeNumber($header::CN_CONSTANT));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'tax_number')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.tax_registration_number')));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.code'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'customer.company'));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'employeeIdPurchasesman.name')));
//            $worksheet->setCellValue("H{$counter}", $header->workOrderCuttingHeader->getCodeNumber(WorkOrderCuttingHeader::CN_CONSTANT));
            $worksheet->setCellValue("I{$counter}", empty($header->work_order_cutting_header_id) ? $header->purchase_order_number : $header->workOrderCuttingHeader->saleHeader->customer_order_number);
            $worksheet->setCellValue("J{$counter}", $header->totalQuantity);
            $worksheet->setCellValue("K{$counter}", $header->totalWeight);
            $worksheet->setCellValue("L{$counter}", $header->note);
            $worksheet->setCellValue("M{$counter}", CHtml::encode($header->date_receipt));
            $worksheet->setCellValue("M{$counter}", empty($header->saleReceiptDetails) ? "" : CHtml::encode($header->saleReceiptDetails[0]->saleReceiptHeader->date_receipt));
            $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($header, 'cn_month')));
            $worksheet->setCellValue("P{$counter}", CHtml::encode(CHtml::value($header, 'cn_year')));
            $worksheet->setCellValue("Q{$counter}", CHtml::encode($header->getServiceType($header->service_type)));
            $worksheet->setCellValue("R{$counter}", CHtml::encode($header->date_created));
            $worksheet->setCellValue("S{$counter}", CHtml::encode(CHtml::value($header, 'subTotal')));
            $worksheet->setCellValue("T{$counter}", CHtml::encode(CHtml::value($header, 'discount')));
            $worksheet->setCellValue("U{$counter}", CHtml::encode(CHtml::value($header, 'rounding_nominal')));
            $worksheet->setCellValue("V{$counter}", CHtml::encode(CHtml::value($header, 'calculatedTax')));
            $worksheet->setCellValue("W{$counter}", CHtml::encode(CHtml::value($header, 'calculatedTaxIncome')));
            $worksheet->setCellValue("X{$counter}", CHtml::encode(CHtml::value($header, 'grandTotal')));
            $worksheet->setCellValue("Y{$counter}", CHtml::encode(CHtml::value($header, 'admin.name')));

            $counter++;
        }

        $worksheet->getStyle("A{$counter}:Y{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:Y{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("S{$counter}:X{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("P{$counter}:V{$counter}");
        $worksheet->setCellValue("P{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("W{$counter}", 'Rp');
        $worksheet->setCellValue("X{$counter}", $this->reportGrandTotal($purchaseSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'X'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment;filename="Laporan Faktur Penjualan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
