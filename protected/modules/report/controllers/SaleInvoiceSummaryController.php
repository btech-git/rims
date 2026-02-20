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
            if (!(Yii::app()->user->checkAccess('saleSummaryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeader = Search::bind(new InvoiceHeader('search'), isset($_GET['InvoiceHeader']) ? $_GET['InvoiceHeader'] : array());

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $customerId = isset($_GET['InvoiceHeader']['customer_id']) ? $_GET['InvoiceHeader']['customer_id'] : null;
        $branchId = isset($_GET['InvoiceHeader']['branch_id']) ? $_GET['InvoiceHeader']['branch_id'] : null;
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
            $this->saveToExcel($saleInvoiceSummary, $startDate, $endDate, $branchId);
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

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->total_price;
        }

        return $grandTotal;
    }

    public function reportTotalPayment($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->payment_amount;
        }

        return $grandTotal;
    }

    public function reportTotalRemaining($dataProvider) {
        $grandTotal = 0.00;

        foreach ($dataProvider->data as $data) {
            $grandTotal += $data->payment_left;
        }

        return $grandTotal;
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
        $documentProperties->setTitle('Faktur Penjualan Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Faktur Penjualan Summary');

        $worksheet->mergeCells('A1:W1');
        $worksheet->mergeCells('A2:W2');
        $worksheet->mergeCells('A3:W3');
        
        $worksheet->getStyle('A1:W5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:W5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Faktur Penjualan Summary');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:W5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:W5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Faktur #');
        $worksheet->setCellValue('C5', 'Jatuh Tempo');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Type');
        $worksheet->setCellValue('F5', 'Asuransi');
        $worksheet->setCellValue('G5', 'Plat #');
        $worksheet->setCellValue('H5', 'Kendaraan');
        $worksheet->setCellValue('I5', 'Grand Total');
        $worksheet->setCellValue('J5', 'Payment');
        $worksheet->setCellValue('K5', 'Remaining');
        $worksheet->setCellValue('L5', 'Status');
        $worksheet->setCellValue('M5', 'User');
        $worksheet->setCellValue('N5', 'Payment #');
        $worksheet->setCellValue('O5', 'Tanggal');
        $worksheet->setCellValue('P5', 'Jumlah');
        $worksheet->setCellValue('Q5', 'PPh 21');
        $worksheet->setCellValue('R5', 'Diskon');
        $worksheet->setCellValue('S5', 'Biaya Bank');
        $worksheet->setCellValue('T5', 'Biaya Merimen');
        $worksheet->setCellValue('U5', 'DP');
        $worksheet->setCellValue('V5', 'Total');
        $worksheet->setCellValue('W5', 'Memo');

        $counter = 6;

        $grandTotalSale = '0.00';
        $grandTotalPayment = '0.00';
        $grandTotalRemaining = '0.00';
        $totalAmount = '0.00';
        $totalTaxServiceAmount = '0.00';
        $totalDiscountAmount = '0.00';
        $totalBankFee = '0.00';
        $totalMerimenFee = '0.00';
        $totalDownpaymentAmount = '0.00';
        $totalAmountSum = '0.00';
        
        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            foreach ($header->paymentInDetails as $paymentInDetail) {
                $totalPrice = CHtml::value($header, 'total_price'); 
                $totalPayment = CHtml::value($header, 'payment_amount');
                $totalRemaining = CHtml::value($header, 'payment_left');
                $amount = CHtml::value($paymentInDetail, 'amount');
                $taxServiceAmount = CHtml::value($paymentInDetail, 'tax_service_amount');
                $discountAmount = CHtml::value($paymentInDetail, 'discount_amount');
                $bankAdministrationFee = CHtml::value($paymentInDetail, 'bank_administration_fee');
                $merimenFee = CHtml::value($paymentInDetail, 'merimen_fee');
                $downpaymentAmount = CHtml::value($paymentInDetail, 'downpayment_amount');
                $totalAmount = CHtml::value($paymentInDetail, 'totalAmount');

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_date'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_number'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'due_date'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.customer_type'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'insuranceCompany.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.plate_number'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
                $worksheet->setCellValue("I{$counter}", $totalPrice);
                $worksheet->setCellValue("J{$counter}", $totalPayment);
                $worksheet->setCellValue("K{$counter}", $totalRemaining);
                $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'status'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($header, 'user.username'));
                $worksheet->setCellValue("N{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_number'));
                $worksheet->setCellValue("O{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_date'));
                $worksheet->setCellValue("P{$counter}", $amount);
                $worksheet->setCellValue("Q{$counter}", $taxServiceAmount);
                $worksheet->setCellValue("R{$counter}", $discountAmount);
                $worksheet->setCellValue("S{$counter}", $bankAdministrationFee);
                $worksheet->setCellValue("T{$counter}", $merimenFee);
                $worksheet->setCellValue("U{$counter}", $downpaymentAmount);
                $worksheet->setCellValue("V{$counter}", $totalAmount);
                $worksheet->setCellValue("W{$counter}", CHtml::value($paymentInDetail, 'memo'));

                $grandTotalSale += $totalPrice;
                $grandTotalPayment += $totalPayment;
                $grandTotalRemaining += $totalRemaining;
                $totalAmount += $amount;
                $totalTaxServiceAmount += $taxServiceAmount;
                $totalDiscountAmount += $discountAmount;
                $totalBankFee += $bankAdministrationFee;
                $totalMerimenFee += $merimenFee;
                $totalDownpaymentAmount += $downpaymentAmount;
                $totalAmountSum += $totalAmount;

                $counter++;
            }
        }

        $worksheet->getStyle("A{$counter}:W{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:W{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("G{$counter}", 'Total');
        $worksheet->setCellValue("H{$counter}", 'Rp');
        $worksheet->setCellValue("I{$counter}", $grandTotalSale);
        $worksheet->setCellValue("J{$counter}", $grandTotalPayment);
        $worksheet->setCellValue("K{$counter}", $grandTotalRemaining);
        $worksheet->setCellValue("P{$counter}", $totalAmount);
        $worksheet->setCellValue("Q{$counter}", $totalTaxServiceAmount);
        $worksheet->setCellValue("R{$counter}", $totalDiscountAmount);
        $worksheet->setCellValue("S{$counter}", $totalBankFee);
        $worksheet->setCellValue("T{$counter}", $totalMerimenFee);
        $worksheet->setCellValue("U{$counter}", $totalDownpaymentAmount);
        $worksheet->setCellValue("V{$counter}", $totalAmountSum);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="faktur_penjualan_summary.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}