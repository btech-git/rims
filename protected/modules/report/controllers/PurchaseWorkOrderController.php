<?php

class PurchaseWorkOrderController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleSummaryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $transactionStatus = (isset($_GET['TransactionStatus'])) ? $_GET['TransactionStatus'] : '';
        
        $purchaseWorkOrderSummary = new PurchaseWorkOrderSummary($purchaseOrder->search());
        $purchaseWorkOrderSummary->setupLoading();
        $purchaseWorkOrderSummary->setupPaging($pageSize, $currentPage);
        $purchaseWorkOrderSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionStatus' => $transactionStatus,
        );
        $purchaseWorkOrderSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchaseWorkOrderSummary, $startDate, $endDate, $transactionStatus);
        }

        $this->render('summary', array(
            'purchaseOrder' => $purchaseOrder,
            'purchaseWorkOrderSummary' => $purchaseWorkOrderSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionStatus' => $transactionStatus,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplierId = (isset($_POST['TransactionPurchaseOrder']['supplier_id'])) ? $_POST['TransactionPurchaseOrder']['supplier_id'] : '';
            $supplier = Supplier::model()->findByPk($supplierId);

            $object = array(
                'supplier_id' => CHtml::value($supplier, 'id'),
                'supplier_name' => CHtml::value($supplier, 'name'),
            );
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($purchaseFlowSummary, $startDate, $endDate, $transactionStatus) {
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
        $documentProperties->setTitle('Laporan Pembelian Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Pembelian Summary');

        $worksheet->mergeCells('A1:R1');
        $worksheet->mergeCells('A2:R2');
        $worksheet->mergeCells('A3:R3');
        $worksheet->mergeCells('A4:R4');
        
        $worksheet->getStyle('A1:R3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:R3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Pembelian Summary');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:R6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:R6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:R6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'PO #');
        $worksheet->setCellValue('C6', 'Tanggal');
        $worksheet->setCellValue('D6', 'Jam');
        $worksheet->setCellValue('E6', 'Supplier');
        $worksheet->setCellValue('F6', 'Status');
        $worksheet->setCellValue('G6', 'Penerimaan');
        $worksheet->setCellValue('H6', 'Tanggal');
        $worksheet->setCellValue('I6', 'Jam');
        $worksheet->setCellValue('J6', 'Movement In');
        $worksheet->setCellValue('K6', 'Tanggal');
        $worksheet->setCellValue('L6', 'Jam');
        $worksheet->setCellValue('M6', 'WO');
        $worksheet->setCellValue('N6', 'Tanggal');
        $worksheet->setCellValue('O6', 'Jam');
        $worksheet->setCellValue('P6', 'Movement Out');
        $worksheet->setCellValue('Q6', 'Tanggal');
        $worksheet->setCellValue('R6', 'Jam');

        $counter = 7;
        foreach ($purchaseFlowSummary->dataProvider->data as $i => $header) {
            $receiveItems = $header->transactionReceiveItems;
            $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems); 
            $receiveItemInvoiceNumbers = array_map(function($receiveItem) { return $receiveItem->invoice_number; }, $receiveItems); 
            $invoiceDates = array_map(function($receiveItem) { return $receiveItem->invoice_date; }, $receiveItems); 
            $receiveItemDates = array_map(function($receiveItem) { return $receiveItem->receive_item_date; }, $receiveItems); 
            $receiveItemTimes = array_map(function($receiveItem) { return substr($receiveItem->created_datetime, -8); }, $receiveItems); 
            $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array()); 
            $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders); 
            $movementInDates = array_map(function($movementInHeader) { return substr($movementInHeader->date_posting, 0, 10); }, $movementInHeaders); 
            $movementInTimes = array_map(function($movementInHeader) { return substr($movementInHeader->date_posting, -8); }, $movementInHeaders); 
            $registrationTransaction = $header->registrationTransaction;
            $movementOutHeaders = $registrationTransaction->movementOutHeaders;
            $movementOutCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $movementOutDates = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, 0, 10); }, $movementOutHeaders);
            $movementOutTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->created_datetime, -8); }, $movementOutHeaders);
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $header->purchase_order_no);
            $worksheet->setCellValue("C{$counter}", substr($header->purchase_order_date, 0, 10));
            $worksheet->setCellValue("D{$counter}", substr($header->purchase_order_date, -8));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'supplier.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'status_document'));
            $worksheet->setCellValue("G{$counter}", implode(', ', $receiveItemCodeNumbers));
            $worksheet->setCellValue("H{$counter}", implode(', ', $receiveItemDates));
            $worksheet->setCellValue("I{$counter}", implode(', ', $receiveItemTimes));
            $worksheet->setCellValue("J{$counter}", implode(', ', $movementInHeaderCodeNumbers));
            $worksheet->setCellValue("K{$counter}", implode(', ', $movementInDates));
            $worksheet->setCellValue("L{$counter}", implode(', ', $movementInTimes));
            $worksheet->setCellValue("M{$counter}", CHtml::value($registrationTransaction, 'work_order_number'));
            $worksheet->setCellValue("N{$counter}", substr(CHtml::value($registrationTransaction, 'transaction_date'), 0, 10));
            $worksheet->setCellValue("O{$counter}", substr(CHtml::value($registrationTransaction, 'transaction_date'), -8));
            $worksheet->setCellValue("P{$counter}", implode(', ', $movementOutCodeNumbers));
            $worksheet->setCellValue("Q{$counter}", implode(', ', $movementOutDates));
            $worksheet->setCellValue("R{$counter}", implode(', ', $movementOutTimes));
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian Summary.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
