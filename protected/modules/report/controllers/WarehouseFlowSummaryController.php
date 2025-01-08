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
        
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
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
        $materialRequestFlowSummary->setupFilter($filters);

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
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate, $branchId);
//        }

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
        ));
    }

    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Laporan Faktur Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Faktur Penjualan');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        $worksheet->mergeCells('A4:L4');
        
        $worksheet->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Faktur Penjualan');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:L6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:L6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:L6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'Tanggal');
        $worksheet->setCellValue('B6', 'Faktur #');
        $worksheet->setCellValue('C6', 'Jatuh Tempo');
        $worksheet->setCellValue('D6', 'Customer');
        $worksheet->setCellValue('E6', 'Type');
        $worksheet->setCellValue('F6', 'Vehicle');
        $worksheet->setCellValue('H6', 'Grand Total');
        $worksheet->setCellValue('I6', 'Payment');
        $worksheet->setCellValue('J6', 'Remaining');
        $worksheet->setCellValue('K6', 'Status');
        $worksheet->setCellValue('L6', 'User');

        $counter = 7;

        $grandTotalSale = 0;
        $grandTotalPayment = 0;
        $grandTotalRemaining = 0;
        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            $totalPrice = $header->total_price; 
            $totalPayment = $header->payment_amount;
            $totalRemaining = $header->payment_left;
            $worksheet->setCellValue("A{$counter}", $header->invoice_date);
            $worksheet->setCellValue("B{$counter}", $header->invoice_number);
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'due_date')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.customer_type'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("H{$counter}", $totalPrice);
            $worksheet->setCellValue("I{$counter}", $totalPayment);
            $worksheet->setCellValue("J{$counter}", $totalRemaining);
            $worksheet->setCellValue("K{$counter}", $header->status);
            $worksheet->setCellValue("L{$counter}", $header->user->username);
            $grandTotalSale += $totalPrice;
            $grandTotalPayment += $totalPayment;
            $grandTotalRemaining += $totalRemaining;
            $counter++;
        }

        $worksheet->getStyle("A{$counter}:U{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:U{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("H{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("F{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", 'Rp');
        $worksheet->setCellValue("H{$counter}", $grandTotalSale);
        $worksheet->setCellValue("I{$counter}", $grandTotalPayment);
        $worksheet->setCellValue("J{$counter}", $grandTotalRemaining);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Faktur Penjualan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}