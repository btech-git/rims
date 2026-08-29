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
        $customerType = (isset($_GET['CustomerType'])) ? $_GET['CustomerType'] : '';
        $vehicleId = (isset($_GET['VehicleId'])) ? $_GET['VehicleId'] : '';
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        $vehicles = Vehicle::model()->findAllByAttributes(array('customer_id' => $customerId), array('order' => 'id DESC', 'limit' => 100));

        $saleInvoiceSummary = new SaleInvoiceSummary($invoiceHeader->searchByReport());
        $saleInvoiceSummary->setupLoading();
        $saleInvoiceSummary->setupPaging($pageSize, $currentPage);
        $saleInvoiceSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'vehicleId' => $vehicleId,
            'customerId' => $customerId,
            'customerType' => $customerType,
            'branchId' => $branchId,
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
            'branchId' => $branchId,
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

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        
        $worksheet->getStyle('A1:Z5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Z5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Faktur Penjualan Summary');
        $worksheet->setCellValue('A3', $startDateFormatted . ' - ' . $endDateFormatted);

        $worksheet->getStyle("A5:Z5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:Z5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Faktur #');
        $worksheet->setCellValue('C5', 'Jatuh Tempo');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Type');
        $worksheet->setCellValue('F5', 'Plat #');
        $worksheet->setCellValue('G5', 'Kendaraan');
        $worksheet->setCellValue('H5', 'Total Parts');
        $worksheet->setCellValue('I5', 'Total Jasa');
        $worksheet->setCellValue('J5', 'DPP');
        $worksheet->setCellValue('K5', 'PPn');
        $worksheet->setCellValue('L5', 'PPh');
        $worksheet->setCellValue('M5', 'Grand Total');
        $worksheet->setCellValue('N5', 'Payment');
        $worksheet->setCellValue('O5', 'Remaining');
        $worksheet->setCellValue('P5', 'Status');
        $worksheet->setCellValue('Q5', 'User');
        $worksheet->setCellValue('R5', 'Payment #');
        $worksheet->setCellValue('S5', 'Tanggal');
        $worksheet->setCellValue('T5', 'Jumlah');
        $worksheet->setCellValue('U5', 'PPh 21');
        $worksheet->setCellValue('V5', 'Diskon');
        $worksheet->setCellValue('W5', 'Biaya Bank');
        $worksheet->setCellValue('X5', 'Biaya Merimen');
        $worksheet->setCellValue('Y5', 'Downpayment');
        $worksheet->setCellValue('Z5', 'Own Risk');
        $worksheet->setCellValue('AA5', 'Total Payment');
        $worksheet->setCellValue('AB5', 'Memo');

        $counter = 6;

        $totalParts = '0.00';
        $totalService = '0.00';
        $totalTax = '0.00';
        $totalServiceTax = '0.00';
        $subTotalSum ='0.00';
        $grandTotalSale = '0.00';
        $grandTotalPayment = '0.00';
        $grandTotalRemaining = '0.00';
        $paymentAmountSum = '0.00';
        $totalTaxServiceAmount = '0.00';
        $totalDiscountAmount = '0.00';
        $totalBankFee = '0.00';
        $totalMerimenFee = '0.00';
        $totalDownpaymentAmount = '0.00';
        $totalOwnRiskAmount = '0.00';
        $totalAmountSum = '0.00';
        
        foreach ($saleInvoiceSummary->dataProvider->data as $header) {
            $partsAmount = CHtml::value($header, 'product_price'); 
            $serviceAmount= CHtml::value($header, 'service_price'); 
            $subTotalAmount = CHtml::value($header, 'subTotal'); 
            $taxAmount = CHtml::value($header, 'ppn_total'); 
            $invoiceTaxService = CHtml::value($header, 'pph_total'); 
            $totalPrice = CHtml::value($header, 'total_price'); 
            $totalPayment = CHtml::value($header, 'payment_amount');
            $totalRemaining = CHtml::value($header, 'payment_left');
            
            if (!empty($header->paymentInDetails)) {
                foreach ($header->paymentInDetails as $paymentInDetail) {
                    $amount = CHtml::value($paymentInDetail, 'amount');
                    $taxServiceAmount = CHtml::value($paymentInDetail, 'tax_service_amount');
                    $discountAmount = CHtml::value($paymentInDetail, 'discount_amount');
                    $bankAdministrationFee = CHtml::value($paymentInDetail, 'bank_administration_fee');
                    $merimenFee = CHtml::value($paymentInDetail, 'merimen_fee');
                    $downpaymentAmount = CHtml::value($paymentInDetail, 'downpayment_amount');
                    $ownRiskAmount = CHtml::value($paymentInDetail, 'own_risk_amount');
                    $totalAmount = CHtml::value($paymentInDetail, 'totalAmount');

                    $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_date'));
                    $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_number'));
                    $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'due_date'));
                    $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
                    $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.customer_type'));
                    $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
                    $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
                    $worksheet->setCellValue("H{$counter}", $partsAmount);
                    $worksheet->setCellValue("I{$counter}", $serviceAmount);
                    $worksheet->setCellValue("J{$counter}", $subTotalAmount);
                    $worksheet->setCellValue("K{$counter}", $taxAmount);
                    $worksheet->setCellValue("L{$counter}", $invoiceTaxService);
                    $worksheet->setCellValue("M{$counter}", $totalPrice);
                    $worksheet->setCellValue("N{$counter}", $totalPayment);
                    $worksheet->setCellValue("O{$counter}", $totalRemaining);
                    $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'status'));
                    $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'user.username'));
                    $worksheet->setCellValue("R{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_number'));
                    $worksheet->setCellValue("S{$counter}", CHtml::value($paymentInDetail, 'paymentIn.payment_date'));
                    $worksheet->setCellValue("T{$counter}", $amount);
                    $worksheet->setCellValue("U{$counter}", $taxServiceAmount);
                    $worksheet->setCellValue("V{$counter}", $discountAmount);
                    $worksheet->setCellValue("W{$counter}", $bankAdministrationFee);
                    $worksheet->setCellValue("X{$counter}", $merimenFee);
                    $worksheet->setCellValue("Y{$counter}", $downpaymentAmount);
                    $worksheet->setCellValue("Z{$counter}", $ownRiskAmount);
                    $worksheet->setCellValue("AA{$counter}", $totalAmount);
                    $worksheet->setCellValue("AB{$counter}", CHtml::value($paymentInDetail, 'memo'));

                    $paymentAmountSum += $amount;
                    $totalTaxServiceAmount += $taxServiceAmount;
                    $totalDiscountAmount += $discountAmount;
                    $totalBankFee += $bankAdministrationFee;
                    $totalMerimenFee += $merimenFee;
                    $totalDownpaymentAmount += $downpaymentAmount;
                    $totalOwnRiskAmount += $ownRiskAmount;
                    $totalAmountSum += $totalAmount;

                    $counter++;
                }
            } else {
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_date'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_number'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'due_date'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'customer.customer_type'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.plate_number'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' - ' . CHtml::value($header, 'vehicle.carModel.name') . ' - ' . CHtml::value($header, 'vehicle.carSubModel.name'));
                $worksheet->setCellValue("H{$counter}", $partsAmount);
                $worksheet->setCellValue("I{$counter}", $serviceAmount);
                $worksheet->setCellValue("J{$counter}", $subTotalAmount);
                $worksheet->setCellValue("K{$counter}", $taxAmount);
                $worksheet->setCellValue("L{$counter}", $invoiceTaxService);
                $worksheet->setCellValue("M{$counter}", $totalPrice);
                $worksheet->setCellValue("N{$counter}", $totalPayment);
                $worksheet->setCellValue("O{$counter}", $totalRemaining);
                $worksheet->setCellValue("P{$counter}", CHtml::value($header, 'status'));
                $worksheet->setCellValue("Q{$counter}", CHtml::value($header, 'user.username'));
                
                $counter++;
            }

            $totalParts += $partsAmount;
            $totalService += $serviceAmount;
            $totalTax += $taxAmount;
            $totalServiceTax += $invoiceTaxService;
            $subTotalSum += $subTotalAmount;
            $grandTotalSale += $totalPrice;
            $grandTotalPayment += $totalPayment;
            $grandTotalRemaining += $totalRemaining;
        }

        $worksheet->getStyle("A{$counter}:AC{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:AB{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("F{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", 'Rp');
        $worksheet->setCellValue("H{$counter}", $totalParts);
        $worksheet->setCellValue("I{$counter}", $totalService);
        $worksheet->setCellValue("J{$counter}", $subTotalSum);
        $worksheet->setCellValue("K{$counter}", $totalTax);
        $worksheet->setCellValue("L{$counter}", $totalServiceTax);
        $worksheet->setCellValue("M{$counter}", $grandTotalSale);
        $worksheet->setCellValue("N{$counter}", $grandTotalPayment);
        $worksheet->setCellValue("O{$counter}", $grandTotalRemaining);
        $worksheet->setCellValue("T{$counter}", $paymentAmountSum);
        $worksheet->setCellValue("U{$counter}", $totalTaxServiceAmount);
        $worksheet->setCellValue("V{$counter}", $totalDiscountAmount);
        $worksheet->setCellValue("W{$counter}", $totalBankFee);
        $worksheet->setCellValue("X{$counter}", $totalMerimenFee);
        $worksheet->setCellValue("Y{$counter}", $totalDownpaymentAmount);
        $worksheet->setCellValue("Z{$counter}", $totalOwnRiskAmount);
        $worksheet->setCellValue("AA{$counter}", $totalAmountSum);

        $counter++;

        for ($col = 'A'; $col !== 'AZ'; $col++) {
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