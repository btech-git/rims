<?php

class PaymentInController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('paymentInReport') )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentIn = Search::bind(new PaymentIn('search'), isset($_GET['PaymentIn']) ? $_GET['PaymentIn'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $customerId = isset($_GET['CustomerId']) ? $_GET['CustomerId'] : '';
        $customerType = isset($_GET['CustomerType']) ? $_GET['CustomerType'] : '';
        $plateNumber = (isset($_GET['PlateNumber'])) ? $_GET['PlateNumber'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $paymentInSummary = new PaymentInSummary($paymentIn->search());
        $paymentInSummary->setupLoading();
        $paymentInSummary->setupPaging($pageSize, $currentPage);
        $paymentInSummary->setupSorting();
        $paymentInSummary->setupFilter($startDate, $endDate, $branchId, $customerType, $plateNumber);

        $customer = new Customer('search');
        $customer->unsetAttributes();  // clear any default values
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['Customer'])) {
            $customer->attributes = $_GET['Customer'];
        }
        
        $customerCriteria = new CDbCriteria;
        $customerCriteria->compare('t.name', $customer->name, true);
        $customerCriteria->compare('t.email', $customer->email, true);
        $customerDataProvider = new CActiveDataProvider('Customer', array(
            'criteria' => $customerCriteria,
        ));

        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($paymentInSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'paymentIn' => $paymentIn,
            'paymentInSummary' => $paymentInSummary,
            'customerId' => $customerId,
            'customer' => $customer,
            'customerDataProvider' => $customerDataProvider,
            'customerType' => $customerType,
            'plateNumber' => $plateNumber,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    public function actionAjaxJsonCustomer() {
        if (Yii::app()->request->isAjaxRequest) {
            $customerId = (isset($_POST['CustomerId'])) ? $_POST['CustomerId'] : '';
            $customer = Customer::model()->findByPk($customerId);

            $object = array(
                'customer_name' => CHtml::value($customer, 'name'),
            );
            
            echo CJSON::encode($object);
        }
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Penerimaan Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Payment In');

        $worksheet->mergeCells('A1:T1');
        $worksheet->mergeCells('A2:T2');
        $worksheet->mergeCells('A3:T3');

        $worksheet->getStyle('A1:T5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:T5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Laporan Penerimaan Penjualan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:T5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Asuransi');
        $worksheet->setCellValue('E5', 'Status');
        $worksheet->setCellValue('F5', 'Bank');
        $worksheet->setCellValue('G5', 'Payment Type');
        $worksheet->setCellValue('H5', 'Note');
        $worksheet->setCellValue('I5', 'Admin');
        $worksheet->setCellValue('J5', 'Invoice #');
        $worksheet->setCellValue('K5', 'Tanggal');
        $worksheet->setCellValue('L5', 'Kendaraan');
        $worksheet->setCellValue('M5', 'Invoice');
        $worksheet->setCellValue('N5', 'Pph 23');
        $worksheet->setCellValue('O5', 'Diskon');
        $worksheet->setCellValue('P5', 'Biaya Bank');
        $worksheet->setCellValue('Q5', 'Biaya Merimen');
        $worksheet->setCellValue('R5', 'DP');
        $worksheet->setCellValue('S5', 'Amount');
        $worksheet->setCellValue('T5', 'Total Payment');
        $worksheet->setCellValue('U5', 'Memo');

        $worksheet->getStyle('A5:T5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalInvoice = 0.00;
        $totalTaxService = 0.00;
        $totalDiscount = 0.00;
        $totalBankFee = 0.00;
        $totalMerimenFee = 0.00;
        $totalDownpayment = 0.00;
        $totalAmount = 0.00;
        $totalPayment = 0.00;
        foreach ($dataProvider->data as $header) {
            foreach ($header->paymentInDetails as $detail) {
                $invoiceAmount = CHtml::value($detail, 'total_invoice');
                $taxServiceAmount = CHtml::value($detail, 'tax_service_amount');
                $discountAmount = CHtml::value($detail, 'discount_amount');
                $bankAdminAmount = CHtml::value($detail, 'bank_administration_fee');
                $merimenAmount = CHtml::value($detail, 'merimen_fee');
                $downpaymentAmount = CHtml::value($detail, 'downpayment_amount');
                $receivedAmount = CHtml::value($detail, 'amount');
                $totalReceivedAmount = CHtml::value($detail, 'totalAmount');

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'payment_number'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'payment_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($detail, 'invoiceHeader.insuranceCompany.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'companyBank.bank.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'paymentType.name'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'notes'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'user.username'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'invoiceHeader.invoice_number'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'invoiceHeader.invoice_date'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'invoiceHeader.vehicle.plate_number'));
                $worksheet->setCellValue("M{$counter}", $invoiceAmount);
                $worksheet->setCellValue("N{$counter}", $taxServiceAmount);
                $worksheet->setCellValue("O{$counter}", $discountAmount);
                $worksheet->setCellValue("P{$counter}", $bankAdminAmount);
                $worksheet->setCellValue("Q{$counter}", $merimenAmount);
                $worksheet->setCellValue("R{$counter}", $downpaymentAmount);
                $worksheet->setCellValue("S{$counter}", $receivedAmount);
                $worksheet->setCellValue("T{$counter}", $totalReceivedAmount);
                $worksheet->setCellValue("U{$counter}", CHtml::value($detail, 'memo'));

                $counter++;
                $totalInvoice += $invoiceAmount;
                $totalTaxService += $taxServiceAmount;
                $totalDiscount += $discountAmount;
                $totalBankFee += $bankAdminAmount;
                $totalMerimenFee += $merimenAmount;
                $totalDownpayment += $downpaymentAmount;
                $totalAmount += $receivedAmount;
                $totalPayment += $totalReceivedAmount;
            }
        }
        
        $worksheet->mergeCells("A{$counter}:K{$counter}");
        $worksheet->getStyle("L{$counter}:S{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("M{$counter}", $totalInvoice);
        $worksheet->setCellValue("N{$counter}", $totalTaxService);
        $worksheet->setCellValue("O{$counter}", $totalDiscount);
        $worksheet->setCellValue("P{$counter}", $totalBankFee);
        $worksheet->setCellValue("Q{$counter}", $totalMerimenFee);
        $worksheet->setCellValue("R{$counter}", $totalDownpayment);
        $worksheet->setCellValue("S{$counter}", $totalAmount);
        $worksheet->setCellValue("T{$counter}", $totalPayment);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_penerimaan_penjualan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
