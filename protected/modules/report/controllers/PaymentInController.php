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
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
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
        $paymentInSummary->setupFilter($startDate, $endDate, $branchId, $customerType, $plateNumber, $customerId);

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
        $documentProperties->setTitle('Rincian Penerimaan Penjualan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rincian Penerimaan Penjualan');

        $worksheet->mergeCells('A1:X1');
        $worksheet->mergeCells('A2:X2');
        $worksheet->mergeCells('A3:X3');

        $worksheet->getStyle('A1:X5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:X5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Rincian Penerimaan Penjualan');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:X5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Payment #');
        $worksheet->setCellValue('B5', 'Tanggal Payment');
        $worksheet->setCellValue('C5', 'Customer');
        $worksheet->setCellValue('D5', 'Plat #');
        $worksheet->setCellValue('E5', 'Kendaraan');
        $worksheet->setCellValue('F5', 'Asuransi');
        $worksheet->setCellValue('G5', 'Status');
        $worksheet->setCellValue('H5', 'Bank');
        $worksheet->setCellValue('I5', 'Payment Type');
        $worksheet->setCellValue('J5', 'Note');
        $worksheet->setCellValue('K5', 'Admin');
        $worksheet->setCellValue('L5', 'Jumlah');
        $worksheet->setCellValue('M5', 'Pph 21');
        $worksheet->setCellValue('N5', 'Diskon');
        $worksheet->setCellValue('O5', 'Biaya Bank');
        $worksheet->setCellValue('P5', 'Biaya Merimen');
        $worksheet->setCellValue('Q5', 'Downpayment');
        $worksheet->setCellValue('R5', 'Own Risk');
        $worksheet->setCellValue('S5', 'Total Payment');
        $worksheet->setCellValue('T5', 'Memo');
        $worksheet->setCellValue('U5', 'Invoice #');
        $worksheet->setCellValue('V5', 'Tanggal Invoice');
        $worksheet->setCellValue('W5', 'Total Invoice');
        $worksheet->setCellValue('X5', 'Sisa Invoice');

        $worksheet->getStyle('A5:X5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $totalInvoice = '0.00';
        $totalTaxService = '0.00';
        $totalDiscount = '0.00';
        $totalBankFee = '0.00';
        $totalMerimenFee = '0.00';
        $totalDownpayment = '0.00';
        $totalOwnRiskAmount = '0.00';
        $totalAmount = '0.00';
        $totalPayment = '0.00';
        $totalRemaining = '0.00';
        foreach ($dataProvider->data as $header) {
            foreach ($header->paymentInDetails as $detail) {
                $invoiceAmount = CHtml::value($detail, 'total_invoice');
                $taxServiceAmount = CHtml::value($detail, 'tax_service_amount');
                $discountAmount = CHtml::value($detail, 'discount_amount');
                $bankAdminAmount = CHtml::value($detail, 'bank_administration_fee');
                $merimenAmount = CHtml::value($detail, 'merimen_fee');
                $downpaymentAmount = CHtml::value($detail, 'downpayment_amount');
                $ownRiskAmount = CHtml::value($detail, 'own_risk_amount');
                $receivedAmount = CHtml::value($detail, 'amount');
                $totalReceivedAmount = CHtml::value($detail, 'totalAmount');
                $remainingAmount = $invoiceAmount - $totalReceivedAmount;

                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'payment_number'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'payment_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($detail, 'registrationTransaction.vehicle.plate_number'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($detail, 'registrationTransaction.vehicle.carMake.name') . ' - ' . CHtml::value($detail, 'registrationTransaction.vehicle.carModel.name') . ' - ' . CHtml::value($detail, 'registrationTransaction.vehicle.carSubModel.name'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'insuranceCompany.name'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'status'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'companyBank.account_name'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'paymentType.name'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'notes'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'user.username'));
                $worksheet->setCellValue("L{$counter}", $receivedAmount);
                $worksheet->setCellValue("M{$counter}", $taxServiceAmount);
                $worksheet->setCellValue("N{$counter}", $discountAmount);
                $worksheet->setCellValue("O{$counter}", $bankAdminAmount);
                $worksheet->setCellValue("P{$counter}", $merimenAmount);
                $worksheet->setCellValue("Q{$counter}", $downpaymentAmount);
                $worksheet->setCellValue("R{$counter}", $ownRiskAmount);
                $worksheet->setCellValue("S{$counter}", $totalReceivedAmount);
                $worksheet->setCellValue("T{$counter}", CHtml::value($detail, 'memo'));
                if ($detail->invoice_header_id !== null) {
                    $worksheet->setCellValue("U{$counter}", CHtml::value($detail, 'invoiceHeader.invoice_number'));
                    $worksheet->setCellValue("V{$counter}", CHtml::value($detail, 'invoiceHeader.invoice_date'));
                } elseif ($detail->sale_invoice_insurance_own_risk_id !== null) {
                    $worksheet->setCellValue("U{$counter}", CHtml::value($detail, 'saleInvoiceInsuranceOwnRisk.transaction_number'));
                    $worksheet->setCellValue("V{$counter}", CHtml::value($detail, 'saleInvoiceInsuranceOwnRisk.transaction_date'));
                } else {
                    $worksheet->setCellValue("U{$counter}", CHtml::value($detail, 'registrationTransaction.downpayment_transaction_number'));
                    $worksheet->setCellValue("V{$counter}", CHtml::value($detail, 'registrationTransaction.downpayment_transaction_date'));
                }
                $worksheet->setCellValue("W{$counter}", $invoiceAmount);
                $worksheet->setCellValue("X{$counter}", $remainingAmount);

                $counter++;
                $totalInvoice += $invoiceAmount;
                $totalTaxService += $taxServiceAmount;
                $totalDiscount += $discountAmount;
                $totalBankFee += $bankAdminAmount;
                $totalMerimenFee += $merimenAmount;
                $totalDownpayment += $downpaymentAmount;
                $totalAmount += $receivedAmount;
                $totalPayment += $totalReceivedAmount;
                $totalOwnRiskAmount += $ownRiskAmount;
                $totalRemaining += $remainingAmount;
            }
        }
        
        $worksheet->mergeCells("A{$counter}:K{$counter}");
        $worksheet->getStyle("A{$counter}:X{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:X{$counter}")->getFont()->setBold(true);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("L{$counter}", $totalAmount);
        $worksheet->setCellValue("M{$counter}", $totalTaxService);
        $worksheet->setCellValue("N{$counter}", $totalDiscount);
        $worksheet->setCellValue("O{$counter}", $totalBankFee);
        $worksheet->setCellValue("P{$counter}", $totalMerimenFee);
        $worksheet->setCellValue("Q{$counter}", $totalDownpayment);
        $worksheet->setCellValue("R{$counter}", $totalOwnRiskAmount);
        $worksheet->setCellValue("S{$counter}", $totalPayment);
        $worksheet->setCellValue("W{$counter}", $totalInvoice);
        $worksheet->setCellValue("X{$counter}", $totalRemaining);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rincian_penerimaan_penjualan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
