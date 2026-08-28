<?php

class ReceivableCustomerController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('customerReceivableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';
            $branchId = (Yii::app()->user->checkAccess('director') ? '' : Yii::app()->user->branch_id);
            $customerId = '';
            $endDate = date('Y-m-d');
        }
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());
//        $customerDataProvider = $customer->search();
//        $customerDataProvider->criteria->compare('t.status', 'Active');
//        $customerDataProvider->criteria->compare('t.customer_type', 'Company');
//        $customerDataProvider->pagination->pageVar = 'page_dialog';

        $receivableSummary = new ReceivableCustomerSummary($customer->search());
        $receivableSummary->setupLoading();
        $receivableSummary->setupPaging($pageSize, $currentPage);
        $receivableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
            'customerId' => $customerId,
        );
        $receivableSummary->setupFilter($filters);

        $customerIds = array_map(function($customer) { return $customer->id; }, $receivableSummary->dataProvider->data);
        $receivableReport = InvoiceHeader::getReceivableReport($endDate, $branchId, $customerIds);
        $invoiceHeaderIds = array_map(function($receivableReportItem) { return $receivableReportItem['id']; }, $receivableReport);
        $receivablePaymentReport = PaymentInDetail::getReceivablePaymentReport($endDate, $invoiceHeaderIds);
        
        $receivableReportData = array();
        foreach ($receivableReport as $receivableReportItem) {
            if (!isset($receivableReportData[$receivableReportItem['customer_id']])) {
                $receivableReportData[$receivableReportItem['customer_id']] = array();
            }
            $receivableReportData[$receivableReportItem['customer_id']][] = $receivableReportItem;
        }
        
        $receivablePaymentReportData = array();
        foreach ($receivablePaymentReport as $receivablePaymentReportItem) {
            $receivablePaymentReportData[$receivablePaymentReportItem['invoice_header_id']] = $receivablePaymentReportItem['payment_amount'];
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($receivableSummary, $receivableReportData, $receivablePaymentReportData, $endDate, $branchId);
        }

        $this->render('summary', array(
            'receivableSummary' => $receivableSummary,
            'receivableReportData' => $receivableReportData,
            'receivablePaymentReportData' => $receivablePaymentReportData,
//            'customer' => $customer,
//            'customerDataProvider' => $customerDataProvider,
            'customerId' => $customerId,
            'branchId' => $branchId,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionTransactionInfo($customerId, $branchId, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = AppParam::BEGINNING_TRANSACTION_DATE;
        $customer = Customer::model()->findByPk($customerId);
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':customer_id' => $customerId,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $invoiceHeaders = InvoiceHeader::model()->findAll(array(
            'condition' => "t.invoice_date BETWEEN :start_date AND :end_date AND t.customer_id = :customer_id AND t.user_id_cancelled IS NULL AND
                t.insurance_company_id IS NULL AND t.total_price - (
                    SELECT COALESCE(SUM(d.amount + d.tax_service_amount + d.discount_amount + d.bank_administration_fee + d.merimen_fee + d.downpayment_amount + d.own_risk_amount), 0)
                    FROM " . PaymentInDetail::model()->tableName() . " d
                    INNER JOIN " . PaymentIn::model()->tableName() . " h ON h.id = d.payment_in_id
                    WHERE t.id = d.invoice_header_id AND h.user_id_cancelled IS NULL AND h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                ) > 0",
            'params' => $params,
        ));
        
//        if (isset($_GET['SaveExcelDetail'])) {
//            $this->saveToExcelDetailTransaction($dataProvider, $endDate, $customer);
//        }

        $this->render('transactionInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'customer' => $customer,
        ));
    }

    public function actionTransactionRetailInfo($branchId, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = AppParam::BEGINNING_TRANSACTION_DATE;
        $dataProvider = InvoiceHeader::model()->searchByReport();
        $dataProvider->criteria->addBetweenCondition('t.invoice_date', $startDate, $endDate);
        $dataProvider->criteria->addCondition("t.user_id_cancelled IS NULL AND t.payment_left > 100 AND t.insurance_company_id IS NULL");
        $dataProvider->criteria->together = 'true';
        $dataProvider->criteria->with = array('customer');
        $dataProvider->criteria->addSearchCondition('customer.customer_type', 'Individual');
        $dataProvider->criteria->compare('t.branch_id', $branchId);
        
        if (isset($_GET['SaveExcelRetail'])) {
            $this->saveToExcelRetailTransaction($dataProvider, $endDate);
        }

        $this->render('transactionRetailInfo', array(
            'dataProvider' => $dataProvider,
            'endDate' => $endDate,
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

    protected function saveToExcel($receivableSummary, $receivableReportData, $receivablePaymentReportData, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Summary');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');
        
        $worksheet->getStyle('A1:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Piutang Customer Summary');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:F5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:F5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Name');
        $worksheet->setCellValue('C5', 'Akun');
        $worksheet->setCellValue('D5', 'Invoice');
        $worksheet->setCellValue('E5', 'Payment');
        $worksheet->setCellValue('F5', 'Remaining');
        $counter = 6;

        $totalReceivableIndividual = Customer::getTotalReceivableIndividual($endDate, $branchId);
        $totalPaymentIndividual = Customer::getTotalPaymentIndividual($endDate, $branchId);
        $totalRemainingIndividual = Customer::getTotalRemainingIndividual($endDate, $branchId);
        
        $worksheet->mergeCells("A{$counter}:C{$counter}");
        $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
        $worksheet->setCellValue("A{$counter}", 'Individual');
        $worksheet->setCellValue("D{$counter}", $totalReceivableIndividual);
        $worksheet->setCellValue("E{$counter}", $totalPaymentIndividual);
        $worksheet->setCellValue("F{$counter}", $totalRemainingIndividual);

        $counter++;

        $totalInvoiceSum = '0.00';
        $totalPaymentSum = '0.00';
        $totalRemainingSum = '0.00';
        
        foreach ($receivableSummary->dataProvider->data as $i => $customer) {
            $totalRevenue = '0.00';
            $totalPayment = '0.00';
            $totalReceivable = '0.00';
            
            foreach ($receivableReportData[$customer->id] as $receivableReportItem) {
                $revenue = $receivableReportItem['total_price'];
                $paymentAmount = isset($receivablePaymentReportData[$receivableReportItem['id']]) ? $receivablePaymentReportData[$receivableReportItem['id']] : '0.00';
                $paymentLeft = $revenue - $paymentAmount;
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
                
            $worksheet->setCellValue("A{$counter}", ++$i);
            $worksheet->setCellValue("B{$counter}", CHtml::value($customer, 'name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($customer, 'coa.name'));
            $worksheet->setCellValue("D{$counter}", $totalRevenue);
            $worksheet->setCellValue("E{$counter}", $totalPayment);
            $worksheet->setCellValue("F{$counter}", $totalReceivable);

            $totalInvoiceSum += $totalRevenue;
            $totalPaymentSum += $totalPayment;
            $totalRemainingSum += $totalReceivable;
            
            $counter++;

        }
        
        $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->mergeCells("A{$counter}:C{$counter}");
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("D{$counter}", $totalInvoiceSum);
        $worksheet->setCellValue("E{$counter}", $totalPaymentSum);
        $worksheet->setCellValue("F{$counter}", $totalRemainingSum);

        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="piutang_customer_summary.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }

    protected function saveToExcelDetailTransaction($dataProvider, $endDate, $coa) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Detail');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Piutang Customer ' . CHtml::value($coa, 'name'));
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:G5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Transaksi #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Keterangan');
        $worksheet->setCellValue('D5', 'Note');
        $worksheet->setCellValue('E5', 'Invoice');
        $worksheet->setCellValue('F5', 'Pembayaran');
        $worksheet->setCellValue('G5', 'Saldo');
        
        $counter = 6;

        $totalDebit = '0.00';
        $totalCredit = '0.00';
        $balanceAmount = '0.00';

        foreach ($dataProvider->data as $header) {
            if ($header->debet_kredit == 'D') {
                $amountDebit = $header->total;
                $amountCredit = '0.00';
            } else {
                $amountDebit = '0.00';
                $amountCredit = $header->total;
            }
            $balanceAmount += $amountDebit - $amountCredit;
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'kode_transaksi'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'tanggal_transaksi'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'remark'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'transaction_subject'));
            $worksheet->setCellValue("E{$counter}", $amountDebit);
            $worksheet->setCellValue("F{$counter}", $amountCredit);
            $worksheet->setCellValue("G{$counter}", $balanceAmount);
            
            $totalDebit += $amountDebit;
            $totalCredit += $amountCredit;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->mergeCells("A{$counter}:D{$counter}");
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("E{$counter}", $totalDebit);
        $worksheet->setCellValue("F{$counter}", $totalCredit);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_detail_piutang_customer.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelRetailTransaction($dataProvider, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Piutang Customer Retail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Piutang Customer Retail');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        
        $worksheet->getStyle('A1:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I5')->getFont()->setBold(true);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Piutang Customer Retail');
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Invoice #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Jatuh Tempo');
        $worksheet->setCellValue('D5', 'Customer');
        $worksheet->setCellValue('E5', 'Plat #');
        $worksheet->setCellValue('F5', 'Kendaraan');
        $worksheet->setCellValue('G5', 'Total');
        $worksheet->setCellValue('H5', 'Payment');
        $worksheet->setCellValue('I5', 'Remaining');
        
        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $counter = 6;

        $totalPriceSum = '0.00';
        $paymentTotalSum = '0.00';
        $paymentLeftSum = '0.00'; 

        foreach ($dataProvider->data as $header) {
            $totalPrice = CHtml::value($header, 'total_price'); 
            $paymentTotal = CHtml::value($header, 'payment_amount');
            $paymentLeft = CHtml::value($header, 'payment_left');
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'due_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'vehicle.carMake.name') . ' ' . CHtml::value($header, 'vehicle.carModel.name') . ' ' . CHtml::value($header, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("G{$counter}", $totalPrice);
            $worksheet->setCellValue("H{$counter}", $paymentTotal);
            $worksheet->setCellValue("I{$counter}", $paymentLeft);
            
            $totalPriceSum += $totalPrice;
            $paymentTotalSum += $paymentTotal;
            $paymentLeftSum += $paymentLeft;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->mergeCells("A{$counter}:F{$counter}");
        
        $worksheet->setCellValue("A{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", $totalPriceSum);
        $worksheet->setCellValue("H{$counter}", $paymentTotalSum);
        $worksheet->setCellValue("I{$counter}", $paymentLeftSum);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_piutang_customer_retail.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'INV') {
            $model = InvoiceHeader::model()->findByAttributes(array('invoice_number' => $codeNumber));
            $this->redirect(array('/transaction/invoiceHeader/show', 'id' => $model->id));
        }
    }
}
