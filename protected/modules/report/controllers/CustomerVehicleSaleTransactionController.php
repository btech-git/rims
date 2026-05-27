<?php

class CustomerVehicleSaleTransactionController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleCustomerReport'))) {
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

        $customerVehicleSaleTransactionSummary = new CustomerVehicleSaleTransactionSummary($registrationTransaction->searchReport());
        $customerVehicleSaleTransactionSummary->setupLoading();
        $customerVehicleSaleTransactionSummary->setupPaging($pageSize, $currentPage);
        $customerVehicleSaleTransactionSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionStatus' => $transactionStatus,
            'branchId' => $branchId,
            'customerId' => $customerId,
            'plateNumber' => $plateNumber,
        );
        $customerVehicleSaleTransactionSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($customerVehicleSaleTransactionSummary, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'registrationTransaction' => $registrationTransaction,
            'customerVehicleSaleTransactionSummary' => $customerVehicleSaleTransactionSummary,
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
        $documentProperties->setTitle('Penjualan Kendaraan Customer');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Penjualan Kendaraan Customer');

        $worksheet->mergeCells('A1:X1');
        $worksheet->mergeCells('A2:X2');
        $worksheet->mergeCells('A3:X3');
        
        $worksheet->getStyle('A1:X3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:X3')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Penjualan Kendaraan Customer');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:AC5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:AC5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:AC5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'RG #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Jam');
        $worksheet->setCellValue('E5', 'User RG');
        $worksheet->setCellValue('F5', 'Customer');
        $worksheet->setCellValue('G5', 'Asuransi');
        $worksheet->setCellValue('H5', 'Kendaraan');
        $worksheet->setCellValue('I5', 'Plat #');
        $worksheet->setCellValue('J5', 'Status');
        $worksheet->setCellValue('K5', 'Problem');
        $worksheet->setCellValue('L5', 'Salesman');
        $worksheet->setCellValue('M5', 'Mekanik');
        $worksheet->setCellValue('N5', 'KM Sebelum');
        $worksheet->setCellValue('O5', 'KM sekarang');
        $worksheet->setCellValue('P5', 'KM Service Selanjutnya');
        $worksheet->setCellValue('Q5', 'Rekomendasi Service Selanjutnya');
        $worksheet->setCellValue('R5', 'User Input');
        $worksheet->setCellValue('S5', 'Work Order');
        $worksheet->setCellValue('T5', 'Movement Out');
        $worksheet->setCellValue('U5', 'User Movement');
        $worksheet->setCellValue('V5', 'Invoice');
        $worksheet->setCellValue('W5', 'Tanggal Invoice');
        $worksheet->setCellValue('X5', 'Jam');
        $worksheet->setCellValue('Y5', 'User Invoice');
        $worksheet->setCellValue('Z5', 'Payment In');
        $worksheet->setCellValue('AA5', 'Tanggal Payment');
        $worksheet->setCellValue('AB5', 'Jam');
        $worksheet->setCellValue('AC5', 'User Payment');

        $counter = 6;

        foreach ($saleFlowSummary->dataProvider->data as $i => $header) {
            $movementOutHeaders = $header->movementOutHeaders;
            $movementOutHeaderCodeNumbers = array_map(function($movementOutHeader) { return $movementOutHeader->movement_out_no; }, $movementOutHeaders);
            $movementOutHeaderUsers = array_map(function($movementOutHeader) { return $movementOutHeader->user->username; }, $movementOutHeaders);
            $invoiceHeaders = $header->invoiceHeaders;
            $invoiceHeaderCodeNumbers = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_number; }, $invoiceHeaders);
            $invoiceHeaderTransactionDates = array_map(function($invoiceHeader) { return $invoiceHeader->invoice_date; }, $invoiceHeaders);
            $invoiceHeaderTransactionTimes = array_map(function($invoiceHeader) { return substr($invoiceHeader->created_datetime, -8); }, $invoiceHeaders);
            $invoiceHeaderUsers = array_map(function($invoiceHeader) { return $invoiceHeader->user->username; }, $invoiceHeaders);
            $paymentInDetails = array_reduce(array_map(function($invoiceHeader) { return $invoiceHeader->paymentInDetails; }, $invoiceHeaders), function($a, $b) { return in_array($b, $a) ? $a : array_merge($a, $b); }, array());
            $paymentInHeaderCodeNumbers = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_number; }, $paymentInDetails);
            $paymentInHeaderDates = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->payment_date; }, $paymentInDetails);
            $paymentInHeaderTimes = array_map(function($paymentInDetail) { return substr($paymentInDetail->paymentIn->created_datetime, -8); }, $paymentInDetails);
            $paymentInHeaderUsers = array_map(function($paymentInDetail) { return $paymentInDetail->paymentIn->user->username; }, $paymentInDetails);
            
            $worksheet->setCellValue("A{$counter}", CHtml::encode($i + 1));
            $worksheet->setCellValue("B{$counter}", $header->transaction_number);
            $worksheet->setCellValue("C{$counter}", CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($header, 'transaction_date'))));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(substr($header->created_datetime, -8)));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'user.username'));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'insuranceCompany.name')));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'problem'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'employeeIdSalesPerson.name'));
            $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'employeeIdAssignMechanic.name'));
            $worksheet->setCellValue("N{$counter}", CHtml::value($header, 'previous_mileage'));
            $worksheet->setCellValue("O{$counter}", CHtml::value($header, 'vehicle_mileage'));
            $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'next_mileage'));
            $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'next_service_recommendation'));
            $worksheet->setCellValue("R{$counter}", CHtml::value($header, 'user.username'));
            $worksheet->setCellValue("S{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("T{$counter}", CHtml::encode(implode(', ', $movementOutHeaderCodeNumbers)));
            $worksheet->setCellValue("U{$counter}", CHtml::encode(implode(', ', $movementOutHeaderUsers)));
            $worksheet->setCellValue("V{$counter}", CHtml::encode(implode(', ', $invoiceHeaderCodeNumbers)));
            $worksheet->setCellValue("W{$counter}", CHtml::encode(implode(', ', $invoiceHeaderTransactionDates)));
            $worksheet->setCellValue("X{$counter}", CHtml::encode(implode(', ', $invoiceHeaderTransactionTimes)));
            $worksheet->setCellValue("Y{$counter}", CHtml::encode(implode(', ', $invoiceHeaderUsers)));
            $worksheet->setCellValue("Z{$counter}", CHtml::encode(implode(', ', $paymentInHeaderCodeNumbers)));
            $worksheet->setCellValue("AA{$counter}", CHtml::encode(implode(', ', $paymentInHeaderDates)));
            $worksheet->setCellValue("AB{$counter}", CHtml::encode(implode(', ', $paymentInHeaderTimes)));
            $worksheet->setCellValue("AC{$counter}", CHtml::encode(implode(', ', $paymentInHeaderUsers)));
            $counter++;
        }

        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="penjualan_kendaraan_customer.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

}
