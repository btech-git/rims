<?php

class SaleFlowSummaryController extends Controller {

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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $plateNumber = isset($_GET['PlateNumber']) ? $_GET['PlateNumber'] : null;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : null;
        $transactionStatus = (isset($_GET['TransactionStatus'])) ? $_GET['TransactionStatus'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();
        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $saleFlowSummary = new SaleFlowSummary($registrationTransaction->search());
        $saleFlowSummary->setupLoading();
        $saleFlowSummary->setupPaging($pageSize, $currentPage);
        $saleFlowSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionStatus' => $transactionStatus,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'plateNumber' => $plateNumber,
        );
        $saleFlowSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleFlowSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'saleFlowSummary' => $saleFlowSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'transactionStatus' => $transactionStatus,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'plateNumber' => $plateNumber,
        ));
    }

    public function actionAjaxJsonCustomer($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['InvoiceHeader']['customer_id'])) ? $_POST['InvoiceHeader']['customer_id'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_id' => CHtml::value($customer, 'id'),
                'customer_name' => CHtml::value($customer, 'name'),
                'customer_type' => CHtml::value($customer, 'customer_type'),
                'customer_mobile_phone' => CHtml::value($customer, 'mobile_phone'),
            );
            echo CJSON::encode($object);
        }
    }

    public function actionAjaxHtmlUpdateVehicleList() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = isset($_GET['InvoiceHeader']['customer_id']) ? $_GET['InvoiceHeader']['customer_id'] : 0;
            $vehicleId = isset($_GET['VehicleId']) ? $_GET['VehicleId'] : '';
            $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

            $this->renderPartial('_vehicleList', array(
                'vehicles' => $vehicles,
                'vehicleId' => $vehicleId,
            ));
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

    protected function saveToExcel($saleFlowSummary, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Penjualan Retail Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Retail Summary');

        $worksheet->mergeCells('A1:P1');
        $worksheet->mergeCells('A2:P2');
        $worksheet->mergeCells('A3:P3');
        $worksheet->mergeCells('A4:P4');
        
        $worksheet->getStyle('A1:P3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:P3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Penjualan Retail Summary');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:P6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:P6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:P6')->getFont()->setBold(true);
        $worksheet->setCellValue('A6', 'No');
        $worksheet->setCellValue('B6', 'RG #');
        $worksheet->setCellValue('C6', 'Tanggal');
        $worksheet->setCellValue('D6', 'Jam');
        $worksheet->setCellValue('E6', 'Customer');
        $worksheet->setCellValue('F6', 'Vehicle');
        $worksheet->setCellValue('G6', 'Status');
        $worksheet->setCellValue('H6', 'Amount');
        $worksheet->setCellValue('I6', 'Work Order');
        $worksheet->setCellValue('J6', 'Movement Out');
        $worksheet->setCellValue('K6', 'Invoice');
        $worksheet->setCellValue('L6', 'Tanggal Invoice');
        $worksheet->setCellValue('M6', 'Jam');
        $worksheet->setCellValue('N6', 'Payment In');
        $worksheet->setCellValue('O6', 'Tanggal Payment');
        $worksheet->setCellValue('P6', 'Jam');

        $counter = 7;

        foreach ($saleFlowSummary->dataProvider->data as $i => $header) {
            $movementOutHeaders = $header->movementOutHeaders;
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $invoiceHeaders = $header->invoiceHeaders;
            $invoiceHeaderCodeNumbers = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_number; }, $invoiceHeaders);
            $invoiceHeaderTransactionDates = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_date; }, $invoiceHeaders);
            $invoiceHeaderTransactionTimes = array_map(function($invoiceHeader) { return Yii::app()->dateFormatter->format("HH:MM:ss", $invoiceHeader->created_datetime); }, $invoiceHeaders);
            $paymentInDetails = array_reduce(array_map(function($invoiceHeader) { return $invoiceHeader->paymentInDetails; }, $invoiceHeaders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $paymentInHeaderCodeNumbers = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_number; }, $paymentInDetails);
            $paymentInHeaderDates = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_date; }, $paymentInDetails);
            $paymentInHeaderTimes = array_map(function($paymentInDetail) { return Yii::app()->dateFormatter->format("HH:MM:ss", $paymentInDetail->paymentIn->created_datetime); }, $paymentInDetails);
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", $header->transaction_number);
            $worksheet->setCellValue("C{$counter}", CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($header, 'transaction_date'))));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(Yii::app()->dateFormatter->format("HH:MM:ss", CHtml::value($header, 'transaction_date'))));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'grand_total'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(implode(', ', $invoiceHeaderCodeNumbers)));
            $worksheet->setCellValue("L{$counter}", CHtml::encode(implode(', ', $invoiceHeaderTransactionDates)));
            $worksheet->setCellValue("M{$counter}", CHtml::encode(implode(', ', $invoiceHeaderTransactionTimes)));
            $worksheet->setCellValue("N{$counter}", CHtml::encode(implode(', ', $paymentInHeaderCodeNumbers)));
            $worksheet->setCellValue("O{$counter}", CHtml::encode(implode(', ', $paymentInHeaderDates)));
            $worksheet->setCellValue("P{$counter}", CHtml::encode(implode(', ', $paymentInHeaderTimes)));
            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Penjualan Retail Summary.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
