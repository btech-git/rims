<?php

class WarehouseFlowSummaryController extends Controller {

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

        $registrationTransaction = Search::bind(new RegistrationTransaction('search'), isset($_GET['RegistrationTransaction']) ? $_GET['RegistrationTransaction'] : array());
        $materialRequest = Search::bind(new MaterialRequestHeader('search'), isset($_GET['MaterialRequestHeader']) ? $_GET['MaterialRequestHeader'] : array());
        $transferRequest = Search::bind(new TransactionTransferRequest('search'), isset($_GET['TransactionTransferRequest']) ? $_GET['TransactionTransferRequest'] : array());
        $sentRequest = Search::bind(new TransactionSentRequest('search'), isset($_GET['TransactionSentRequest']) ? $_GET['TransactionSentRequest'] : array());
        $purchaseOrder = Search::bind(new TransactionPurchaseOrder('search'), isset($_GET['TransactionPurchaseOrder']) ? $_GET['TransactionPurchaseOrder'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $transactionStatus = (isset($_GET['TransactionStatus'])) ? $_GET['TransactionStatus'] : '';
        
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionStatus' => $transactionStatus,
        );
        
        $saleFlowSummary = new WarehouseFlowSummary($registrationTransaction->search());
        $saleFlowSummary->setupLoading();
        $saleFlowSummary->setupPaging($pageSize, $currentPage);
        $saleFlowSummary->setupSorting();
        $saleFlowSummary->setupFilter($filters);

        $materialRequestFlowSummary = new WarehouseFlowSummary($materialRequest->search());
        $materialRequestFlowSummary->setupLoading();
        $materialRequestFlowSummary->setupPaging($pageSize, $currentPage);
        $materialRequestFlowSummary->setupSorting();
        $materialRequestFlowSummary->setupFilterMaterial($filters);

        $transferRequestFlowSummary = new WarehouseFlowSummary($transferRequest->search());
        $transferRequestFlowSummary->setupLoading();
        $transferRequestFlowSummary->setupPaging($pageSize, $currentPage);
        $transferRequestFlowSummary->setupSorting();
        $transferRequestFlowSummary->setupFilterTransfer($filters);

        $sentRequestFlowSummary = new WarehouseFlowSummary($sentRequest->search());
        $sentRequestFlowSummary->setupLoading();
        $sentRequestFlowSummary->setupPaging($pageSize, $currentPage);
        $sentRequestFlowSummary->setupSorting();
        $sentRequestFlowSummary->setupFilterSent($filters);

        $purchaseOrderFlowSummary = new WarehouseFlowSummary($purchaseOrder->search());
        $purchaseOrderFlowSummary->setupLoading();
        $purchaseOrderFlowSummary->setupPaging($pageSize, $currentPage);
        $purchaseOrderFlowSummary->setupSorting();
        $purchaseOrderFlowSummary->setupFilterPurchase($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(
                $registrationTransaction,
                $saleFlowSummary,
                $materialRequest,
                $materialRequestFlowSummary,
                $transferRequest,
                $transferRequestFlowSummary,
                $sentRequest,
                $sentRequestFlowSummary,
                $purchaseOrder,
                $purchaseOrderFlowSummary, 
                $startDate, 
                $endDate,
                $transactionStatus
            );
        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'saleFlowSummary' => $saleFlowSummary,
            'materialRequest' => $materialRequest,
            'materialRequestFlowSummary' => $materialRequestFlowSummary,
            'transferRequest' => $transferRequest,
            'transferRequestFlowSummary' => $transferRequestFlowSummary,
            'sentRequest' => $sentRequest,
            'sentRequestFlowSummary' => $sentRequestFlowSummary,
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderFlowSummary' => $purchaseOrderFlowSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'transactionStatus' => $transactionStatus,
        ));
    }

    protected function saveToExcel($registrationTransaction, $saleFlowSummary, $materialRequest, $materialRequestFlowSummary, $transferRequest, $transferRequestFlowSummary, $sentRequest, $sentRequestFlowSummary, $purchaseOrder, $purchaseOrderFlowSummary, $startDate, $endDate, $transactionStatus) {
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
        $documentProperties->setTitle('Laporan Perpindahan Barang');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Perpindahan Barang');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');
        $worksheet->mergeCells('A4:H4');
        $worksheet->mergeCells('A5:H5');
        
        $worksheet->getStyle('A1:H3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Laporan Perpindahan Barang');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:H5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:H6')->getFont()->setBold(true);
        $worksheet->getStyle('A5:H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue('A5', 'Penjualan');
        $worksheet->getStyle("A6:H6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'RG #');
        $worksheet->setCellValue('C6', 'Tanggal');
        $worksheet->setCellValue('D6', 'Jam');
        $worksheet->setCellValue('E6', 'Customer');
        $worksheet->setCellValue('F6', 'Vehicle');
        $worksheet->setCellValue('G6', 'Sales Order');
        $worksheet->setCellValue('H6', 'Work Order');
        $worksheet->setCellValue('I6', 'Movement Out');
        $worksheet->setCellValue('J6', 'Tanggal');
        $worksheet->setCellValue('K6', 'Jam');

        $counter = 7;

        foreach ($saleFlowSummary->dataProvider->data as $i => $header) {
            $movementOutHeaders = $header->movementOutHeaders;
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $movementOutHeaderDates = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, 0, 10); }, $movementOutHeaders);
            $movementOutHeaderTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, -8); }, $movementOutHeaders);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transaction_number));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(substr(CHtml::value($header, 'transaction_date'), 0, 10)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(substr(CHtml::value($header, 'transaction_date'), -8)));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'sales_order_number')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'work_order_number')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(implode(', ', $movementOutHeaderDates)));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(implode(', ', $movementOutHeaderTimes)));
            $counter++;
        }

        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:H{$counter}");
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Material Request');
        $counter++;

        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'No');
        $worksheet->setCellValue("B{$counter}", 'Request #');
        $worksheet->setCellValue("C{$counter}", 'Tanggal');
        $worksheet->setCellValue("D{$counter}", 'Jam');
        $worksheet->setCellValue("E{$counter}", 'RG #');
        $worksheet->setCellValue("F{$counter}", 'Tanggal');
        $worksheet->setCellValue("G{$counter}", 'Jam');
        $worksheet->setCellValue("H{$counter}", 'Customer');
        $worksheet->setCellValue("I{$counter}", 'Sales Order');
        $worksheet->setCellValue("J{$counter}", 'Work Order');
        $worksheet->setCellValue("K{$counter}", 'Movement Out');
        $worksheet->setCellValue("L{$counter}", 'Tanggal');
        $worksheet->setCellValue("M{$counter}", 'Jam');

        $counter++;

        foreach ($materialRequestFlowSummary->dataProvider->data as $i => $header) {
            $movementOutHeaders = $header->movementOutHeaders;
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $movementOutHeaderDates = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, 0, 10); }, $movementOutHeaders);
            $movementOutHeaderTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, -8); }, $movementOutHeaders);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transaction_number));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transaction_date')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'transaction_time')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.transaction_number')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(substr(CHtml::value($header, 'registrationTransaction.transaction_date'), 0, 10)));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(substr(CHtml::value($header, 'registrationTransaction.transaction_date'), -8)));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'registrationTransaction.customer.name'));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.sales_order_number')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'registrationTransaction.work_order_number')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(implode(', ', $movementOutHeaderDates)));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(implode(', ', $movementOutHeaderTimes)));
            $counter++;
        }

        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:H{$counter}");
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Transfer Request');
        $counter++;

        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'No');
        $worksheet->setCellValue("B{$counter}", 'Transfer Request #');
        $worksheet->setCellValue("C{$counter}", 'Tanggal');
        $worksheet->setCellValue("D{$counter}", 'Jam');
        $worksheet->setCellValue("E{$counter}", 'Pengiriman #');
        $worksheet->setCellValue("F{$counter}", 'Tanggal');
        $worksheet->setCellValue("G{$counter}", 'Jam');
        $worksheet->setCellValue("H{$counter}", 'Movement Out #');
        $worksheet->setCellValue("I{$counter}", 'Tanggal');
        $worksheet->setCellValue("J{$counter}", 'Jam');
        $worksheet->setCellValue("K{$counter}", 'Penerimaan #');
        $worksheet->setCellValue("L{$counter}", 'Tanggal');
        $worksheet->setCellValue("M{$counter}", 'Jam');
        $worksheet->setCellValue("N{$counter}", 'Movement In #');
        $worksheet->setCellValue("O{$counter}", 'Tanggal');
        $worksheet->setCellValue("P{$counter}", 'Jam');

        $counter++;

        foreach ($transferRequestFlowSummary->dataProvider->data as $i => $header) {
            $deliveryOrders = $header->transactionDeliveryOrders;
            $deliveryOrderCodeNumbers = array_map(function($deliveryOrder) { return $deliveryOrder->delivery_order_no; }, $deliveryOrders);
            $deliveryOrderDates = array_map(function($deliveryOrder) { return Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($deliveryOrder->delivery_date)); }, $deliveryOrders);
            $deliveryTimes = array_map(function($deliveryOrder) { return substr($deliveryOrder->created_datetime, -8); }, $deliveryOrders);
            $movementOutHeaders = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->movementOutHeaders; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $movementOutHeaderDates = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, 0, 10); }, $movementOutHeaders);
            $movementOutHeaderTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, -8); }, $movementOutHeaders);
            $receiveItems = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->transactionReceiveItems; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems);
            $receiveItemDates = array_map(function($receiveItem) { return substr($receiveItem->receive_item_date, 0, 10); }, $receiveItems);
            $receiveItemTimes = array_map(function($receiveItem) { return substr($receiveItem->created_datetime, -8); }, $receiveItems);
            $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders);
            $movementInDates = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, 0, 10)); }, $movementInHeaders);
            $movementInTimes = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, -8)); }, $movementInHeaders);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transfer_request_no));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transfer_request_date')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'transfer_request_time')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(implode(', ', $deliveryOrderCodeNumbers)));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(implode(', ', $deliveryOrderDates)));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(implode(', ', $deliveryTimes)));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(implode(', ', $movementOutHeaderDates)));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(implode(', ', $movementOutHeaderTimes)));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(implode(', ', $receiveItemCodeNumbers)));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(implode(', ', $receiveItemDates)));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(implode(', ', $receiveItemTimes)));
            $worksheet->setCellValue("N{$counter}", CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)));
            $worksheet->setCellValue("O{$counter}", CHtml::encode(implode(', ', $movementInDates)));
            $worksheet->setCellValue("P{$counter}", CHtml::encode(implode(', ', $movementInTimes)));
            $counter++;
        }

        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:H{$counter}");
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Sent Request');
        $counter++;

        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'No');
        $worksheet->setCellValue("B{$counter}", 'Sent Request #');
        $worksheet->setCellValue("C{$counter}", 'Tanggal');
        $worksheet->setCellValue("D{$counter}", 'Jam');
        $worksheet->setCellValue("E{$counter}", 'Pengiriman #');
        $worksheet->setCellValue("F{$counter}", 'Tanggal');
        $worksheet->setCellValue("G{$counter}", 'Jam');
        $worksheet->setCellValue("H{$counter}", 'Movement Out #');
        $worksheet->setCellValue("I{$counter}", 'Tanggal');
        $worksheet->setCellValue("J{$counter}", 'Jam');
        $worksheet->setCellValue("K{$counter}", 'Penerimaan #');
        $worksheet->setCellValue("L{$counter}", 'Tanggal');
        $worksheet->setCellValue("M{$counter}", 'Jam');
        $worksheet->setCellValue("N{$counter}", 'Movement In #');
        $worksheet->setCellValue("O{$counter}", 'Tanggal');
        $worksheet->setCellValue("P{$counter}", 'Jam');

        $counter++;

        foreach ($sentRequestFlowSummary->dataProvider->data as $i => $header) {
            $deliveryOrders = $header->transactionDeliveryOrders;
            $deliveryOrderCodeNumbers = array_map(function($deliveryOrder) { return $deliveryOrder->delivery_order_no; }, $deliveryOrders);
            $deliveryOrderDates = array_map(function($deliveryOrder) { return Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($deliveryOrder->delivery_date)); }, $deliveryOrders);
            $deliveryTimes = array_map(function($deliveryOrder) { return substr($deliveryOrder->created_datetime, -8); }, $deliveryOrders);
            $movementOutHeaders = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->movementOutHeaders; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $movementOutHeaderDates = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, 0, 10); }, $movementOutHeaders);
            $movementOutHeaderTimes = array_map(function($movementOutHeader) { return substr($movementOutHeader->date_posting, -8); }, $movementOutHeaders);
            $receiveItems = array_reduce(array_map(function($deliveryOrder) { return $deliveryOrder->transactionReceiveItems; }, $deliveryOrders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems);
            $receiveItemDates = array_map(function($receiveItem) { return substr($receiveItem->receive_item_date, 0, 10); }, $receiveItems);
            $receiveItemTimes = array_map(function($receiveItem) { return substr($receiveItem->created_datetime, -8); }, $receiveItems);
            $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders);
            $movementInDates = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, 0, 10)); }, $movementInHeaders);
            $movementInTimes = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, -8)); }, $movementInHeaders);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->sent_request_no));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'sent_request_date')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'sent_request_time')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(implode(', ', $deliveryOrderCodeNumbers)));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(implode(', ', $deliveryOrderDates)));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(implode(', ', $deliveryTimes)));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(implode(', ', $movementOutHeaderDates)));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(implode(', ', $movementOutHeaderTimes)));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(implode(', ', $receiveItemCodeNumbers)));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(implode(', ', $receiveItemDates)));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(implode(', ', $receiveItemTimes)));
            $worksheet->setCellValue("N{$counter}", CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)));
            $worksheet->setCellValue("O{$counter}", CHtml::encode(implode(', ', $movementInDates)));
            $worksheet->setCellValue("P{$counter}", CHtml::encode(implode(', ', $movementInTimes)));
            $counter++;
        }

        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:H{$counter}");
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Pembelian');
        $counter++;

        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'No');
        $worksheet->setCellValue("B{$counter}", 'Purchase #');
        $worksheet->setCellValue("C{$counter}", 'Tanggal');
        $worksheet->setCellValue("D{$counter}", 'Jam');
        $worksheet->setCellValue("E{$counter}", 'Penerimaan #');
        $worksheet->setCellValue("F{$counter}", 'Tanggal');
        $worksheet->setCellValue("G{$counter}", 'Jam');
        $worksheet->setCellValue("H{$counter}", 'Movement In #');
        $worksheet->setCellValue("I{$counter}", 'Tanggal');
        $worksheet->setCellValue("J{$counter}", 'Jam');

        $counter++;

        foreach ($purchaseOrderFlowSummary->dataProvider->data as $i => $header) {
            $receiveItems = $header->transactionReceiveItems;
            $receiveItemCodeNumbers = array_map(function($receiveItem) { return $receiveItem->receive_item_no; }, $receiveItems);
            $receiveItemDates = array_map(function($receiveItem) { return substr($receiveItem->receive_item_date, 0, 10); }, $receiveItems);
            $receiveItemTimes = array_map(function($receiveItem) { return substr($receiveItem->created_datetime, -8); }, $receiveItems);
            $movementInHeaders = array_reduce(array_map(function($receiveItem) { return $receiveItem->movementInHeaders; }, $receiveItems), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $movementInHeaderCodeNumbers = array_map(function($movementInHeader) { return $movementInHeader->movement_in_number; }, $movementInHeaders);
            $movementInDates = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, 0, 10)); }, $movementInHeaders);
            $movementInTimes = array_map(function($movementInHeader) { return CHtml::encode(substr($movementInHeader->date_posting, -8)); }, $movementInHeaders);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($header->purchase_order_no));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(substr(CHtml::value($header, 'purchase_order_date'), 0, 10)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(substr(CHtml::value($header, 'purchase_order_date'), -8)));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(implode(', ', $receiveItemCodeNumbers)));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(implode(', ', $receiveItemDates)));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(implode(', ', $receiveItemTimes)));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(implode(', ', $movementInHeaderCodeNumbers)));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(implode(', ', $movementInDates)));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(implode(', ', $movementInTimes)));
            $counter++;
        }

        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Perpindahan Barang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}