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
            if (!(Yii::app()->user->checkAccess('accountingReport')))
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

        if (isset($_GET['SaveToExcel'])) {
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
            $grandTotal += $data->payment_amount;

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
        $startDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateFormatted = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Hutang Supplier');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Hutang Supplier');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        $worksheet->mergeCells('A4:M4');
        $worksheet->getStyle('A1:M3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Hutang Supplier');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:M6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:M6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:M6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal Faktur');
        $worksheet->setCellValue('B6', 'Jatuh Tempo');
        $worksheet->setCellValue('C6', 'PO #');
        $worksheet->setCellValue('D6', 'Supplier');
        $worksheet->setCellValue('E6', 'Branch');
        $worksheet->setCellValue('F6', 'Grand Total');
        $worksheet->setCellValue('G6', 'Payment');
        $worksheet->setCellValue('H6', 'Remaining');
        $worksheet->setCellValue('I6', 'Tanggal Bayar');
        $worksheet->setCellValue('J6', 'Payment In #');
        $worksheet->setCellValue('K6', 'Payment Type');
        $worksheet->setCellValue('L6', 'Jumlah (Rp)');
        $worksheet->setCellValue('M6', 'Notes');

        $counter = 7;

        foreach ($purchaseSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->purchase_order_date);
            $worksheet->setCellValue("B{$counter}", $header->payment_date_estimate);
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_no')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'mainBranch.code'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));
            $worksheet->setCellValue("H{$counter}", $header->payment_left);
            
            foreach ($header->paymentOuts as $detail) {
                $worksheet->setCellValue("I{$counter}", $detail->payment_date);
                $worksheet->setCellValue("J{$counter}", $detail->payment_number);
                $worksheet->setCellValue("K{$counter}", $detail->paymentType->name);
                $worksheet->setCellValue("L{$counter}", CHtml::encode($detail->payment_amount));
                $worksheet->setCellValue("M{$counter}", $detail->notes);

                $counter++;
            }
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:M{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:M{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:J{$counter}");
        $worksheet->setCellValue("A{$counter}", 'Total Hutang');
        $worksheet->setCellValue("K{$counter}", 'Rp');
        $worksheet->setCellValue("L{$counter}", $this->reportGrandTotal($purchaseSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'M'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Hutang Supplier.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
