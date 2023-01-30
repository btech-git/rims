<?php

class PurchaseSummaryController extends Controller {

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

        $purchaseOrderHeader = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

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

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDate = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Pembelian Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian Summary');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        $worksheet->mergeCells('A4:J4');
        $worksheet->getStyle('A1:J3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Summary');
        $worksheet->setCellValue('A3', $startDate . ' - ' . $endDate);

        $worksheet->getStyle("A6:J6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:J6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:J6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'PO #');
        $worksheet->setCellValue('C6', 'Supplier');
        $worksheet->setCellValue('D6', 'Payment Type');
        $worksheet->setCellValue('E6', 'Branch');
        $worksheet->setCellValue('F6', 'Grand Total');
        $worksheet->setCellValue('G6', 'Payment');
        $worksheet->setCellValue('H6', 'Remaining');
        $worksheet->setCellValue('I6', 'Approved By');

        $counter = 7;

        foreach ($purchaseSummary->dataProvider->data as $header) {
            $worksheet->setCellValue("A{$counter}", $header->purchase_order_date);
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_no')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'payment_type'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'mainBranch.code'));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));
            $worksheet->setCellValue("G{$counter}", $header->payment_amount);
            $worksheet->setCellValue("H{$counter}", $header->payment_left);
            $worksheet->setCellValue("I{$counter}", $header->approval->username);

            $counter++;
        }

        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("F{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//        $worksheet->mergeCells("P{$counter}:V{$counter}");
        $worksheet->setCellValue("E{$counter}", 'Total Pembelian');
        $worksheet->setCellValue("F{$counter}", 'Rp');
        $worksheet->setCellValue("G{$counter}", $this->reportGrandTotal($purchaseSummary->dataProvider));

        $counter++;

        for ($col = 'A'; $col !== 'I'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian Summary.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
