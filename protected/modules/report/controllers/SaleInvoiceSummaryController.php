<?php

class SaleInvoiceSummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('saleInvoiceReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerId = isset($_GET['InvoiceHeader']['customer_id']) ? $_GET['InvoiceHeader']['customer_id'] : 0;
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $vehicleId = (isset($_GET['VehicleId'])) ? $_GET['VehicleId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

        $saleInvoiceSummary = new SaleInvoiceSummary($invoiceHeader->search());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
        );
        $saleInvoiceSummary->setupFilter($filters);

        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
        $customerDataProvider = $customer->search();

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate);
        }

        $this->render('summary', array(
            'invoiceHeader' => $invoiceHeader,
            'saleInvoiceSummary' => $saleInvoiceSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
            'customer'=>$customer,
            'customerDataProvider'=>$customerDataProvider,
            'vehicles' => $vehicles,
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

    protected function saveToExcel($saleInvoiceSummary, $startDate, $endDate) {
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
        $documentProperties->setTitle('Laporan Penjualan Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Penjualan Summary');

        $worksheet->mergeCells('A1:S1');
        $worksheet->mergeCells('A2:S2');
        $worksheet->mergeCells('A3:S3');
        $worksheet->mergeCells('A4:S4');
        
        $worksheet->getStyle('A1:S3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:S3')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Laporan Penjualan Summary');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A6:S6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:S6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A6:S6')->getFont()->setBold(true);
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
        $worksheet->setCellValue('M6', 'Payment In #');
        $worksheet->setCellValue('N6', 'Tanggal');
        $worksheet->setCellValue('O6', 'Jumlah');
        $worksheet->setCellValue('P6', 'Pph 21');
        $worksheet->setCellValue('Q6', 'Total');
        $worksheet->setCellValue('R6', 'Memo');
        $worksheet->setCellValue('S6', 'User');

        $counter = 7;

        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            if (!empty($header->paymentInDetails )){
                $totalPayment = 0; 
                foreach ($header->paymentInDetails as $paymentInDetail) {
                    $amount = CHtml::value($paymentInDetail, 'amount');
                    $total = CHtml::value($paymentInDetail, 'totalAmount'); 
                    
                    $worksheet->setCellValue("A{$counter}", $header->invoice_date);
                    $worksheet->setCellValue("B{$counter}", $header->invoice_number);
                    $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'due_date')));
                    $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.customer_type'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
                    $worksheet->setCellValue("H{$counter}", $header->total_price);
                    $worksheet->setCellValue("I{$counter}", $header->payment_amount);
                    $worksheet->setCellValue("J{$counter}", $header->payment_left);
                    $worksheet->setCellValue("K{$counter}", $header->status);
                    $worksheet->setCellValue("L{$counter}", $header->user->username);
                    $worksheet->setCellValue("M{$counter}", $paymentInDetail->paymentIn->payment_number);
                    $worksheet->setCellValue("N{$counter}", $paymentInDetail->paymentIn->payment_date);
                    $worksheet->setCellValue("O{$counter}", $amount);
                    $worksheet->setCellValue("P{$counter}", $paymentInDetail->tax_service_amount);
                    $worksheet->setCellValue("Q{$counter}", $total);
                    $worksheet->setCellValue("R{$counter}", $paymentInDetail->memo);
                    $worksheet->setCellValue("S{$counter}", $paymentInDetail->paymentIn->user->username);

                    $counter++;
                }
            }
        }

        $worksheet->getStyle("A{$counter}:U{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:U{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("H{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("F{$counter}", 'Total Penjualan');
        $worksheet->setCellValue("G{$counter}", 'Rp');
        $worksheet->setCellValue("H{$counter}", $this->reportGrandTotal($saleInvoiceSummary->dataProvider));

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
