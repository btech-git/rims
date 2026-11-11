<?php

class ReceivableOverviewController extends Controller {

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

        $yearNow = date('Y');
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $customerId = (isset($_GET['CustomerId'])) ? $_GET['CustomerId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';
            $branchId = (Yii::app()->user->checkAccess('director') ? '' : Yii::app()->user->branch_id);
            $customerId = '';
            $year = date('Y');
        }
        
        $customer = Search::bind(new Customer('search'), isset($_GET['Customer']) ? $_GET['Customer'] : array());

        $receivableOverviewSummary = new ReceivableOverviewSummary($customer->search());
        $receivableOverviewSummary->setupLoading();
        $receivableOverviewSummary->setupPaging($pageSize, $currentPage);
        $receivableOverviewSummary->setupSorting();
        $filters = array(
            'year' => $year,
            'branchId' => $branchId,
            'customerId' => $customerId,
        );
        $receivableOverviewSummary->setupFilter($filters);

        $customerIds = array_map(function($customer) { return $customer->id; }, $receivableOverviewSummary->dataProvider->data);
        $receivableReport = InvoiceHeader::getReceivableOverviewReport($year, $branchId, $customerIds);
        
        $receivableReportData = array();
        foreach ($receivableReport as $receivableReportItem) {
            if (!isset($receivableReportData[$receivableReportItem['customer_id']])) {
                $receivableReportData[$receivableReportItem['customer_id']] = array();
            }
            $receivableReportData[$receivableReportItem['customer_id']][] = $receivableReportItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($receivableOverviewSummary, $receivableReportData, $receivablePaymentReportData, $year, $branchId);
//        }

        $this->render('summary', array(
            'receivableOverviewSummary' => $receivableOverviewSummary,
            'receivableReportData' => $receivableReportData,
            'customerId' => $customerId,
            'branchId' => $branchId,
            'yearList' => $yearList,
            'year' => $year,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionTransactionInfo($customerId, $branchId, $year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $customer = Customer::model()->findByPk($customerId);
        $branchConditionSql = '';
        
        $params = array(
            ':year' => $year,
            ':customer_id' => $customerId,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND t.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $invoiceHeaders = InvoiceHeader::model()->findAll(array(
            'condition' => "YEAR(t.invoice_date) = :year AND t.customer_id = :customer_id AND t.user_id_cancelled IS NULL AND t.insurance_company_id IS NULL",
            'params' => $params,
            'order' => 't.invoice_date ASC, t.invoice_number ASC', 
        ));
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailTransaction($invoiceHeaders, $startDate, $year, $customer);
        }

        $this->render('transactionInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
            'customer' => $customer,
        ));
    }

    protected function saveToExcel($receivableSummary, $receivableReportData, $receivablePaymentReportData, $year, $branchId) {
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
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $year));

        $worksheet->getStyle("A5:F5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:F5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Name');
        $worksheet->setCellValue('C5', 'Akun');
        $worksheet->setCellValue('D5', 'Invoice');
        $worksheet->setCellValue('E5', 'Payment');
        $worksheet->setCellValue('F5', 'Remaining');
        $counter = 6;

        $totalReceivableIndividual = Customer::getTotalReceivableIndividual($year, $branchId);
        $totalPaymentIndividual = Customer::getTotalPaymentIndividual($year, $branchId);
        $totalRemainingIndividual = Customer::getTotalRemainingIndividual($year, $branchId);
        
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
                $revenue = $receivableReportItem['invoice_amount'];
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

    protected function saveToExcelDetailTransaction($invoiceHeaders, $startDate, $year, $customer) {
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

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        
        $worksheet->getStyle('A1:L5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Piutang Customer ' . CHtml::value($customer, 'name'));
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $year));

        $worksheet->getStyle("A5:L5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:L5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Invoice #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Jatuh Tempo');
        $worksheet->setCellValue('D5', 'TOP (hari)');
        $worksheet->setCellValue('E5', 'Umur (hari)');
        $worksheet->setCellValue('F5', 'Plat #');
        $worksheet->setCellValue('G5', 'Kendaraan');
        $worksheet->setCellValue('H5', 'Terkirim?');
        $worksheet->setCellValue('I5', 'Status Piutang');
        $worksheet->setCellValue('J5', 'Invoice');
        $worksheet->setCellValue('K5', 'Pembayaran');
        $worksheet->setCellValue('L5', 'Remaining');
        
        $counter = 6;

        $revenueSum = '0.00';
        $paymentAmountSum = '0.00';
        $paymentLeftSum = '0.00';
        
        foreach ($invoiceHeaders as $invoiceHeader) {
            $revenue = CHtml::value($invoiceHeader, 'total_price');
            $paymentAmount = '0.00';
            $paymentInDetails = PaymentInDetail::model()->with('paymentIn')->findAll(array(
                'condition' => 't.invoice_header_id = :invoice_id AND paymentIn.payment_date BETWEEN :start_date AND :end_date AND paymentIn.user_id_cancelled IS NULL',
                'params' => array(
                    ':start_date' => $startDate,
                    ':end_date' => $year,
                    ':invoice_id' => $invoiceHeader->id,
                )
            ));
            foreach ($paymentInDetails as $paymentInDetail) {
                $paymentAmount += $paymentInDetail->totalAmount;
            }
            $paymentLeft = $revenue - $paymentAmount; 
            $isReceivableOverdue = date('Y-m-d') > $invoiceHeader->due_date;
            $outstandingDays = date_diff(date_create($invoiceHeader->due_date), date_create(date('Y-m-d')));
            if ($isReceivableOverdue) {
                $worksheet->getStyle("I{$counter}:L{$counter}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            }
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($invoiceHeader, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($invoiceHeader, 'due_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($invoiceHeader, 'customer.tenor'));
            $worksheet->setCellValue("E{$counter}", $outstandingDays->format("%a days"));
            $worksheet->setCellValue("F{$counter}", CHtml::value($invoiceHeader, 'vehicle.plate_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($invoiceHeader, 'vehicle.carMake.name') . ' - ' . CHtml::value($invoiceHeader, 'vehicle.carModel.name') . ' - ' . CHtml::value($invoiceHeader, 'vehicle.carSubModel.name'));
            $worksheet->setCellValue("H{$counter}", $invoiceHeader->is_sent_to_customer === 1 ? 'Terkirim' : 'Belum');
            $worksheet->setCellValue("I{$counter}", $isReceivableOverdue ? 'Overdue' : 'Outstanding');
            $worksheet->setCellValue("J{$counter}", $revenue);
            $worksheet->setCellValue("K{$counter}", $paymentAmount);
            $worksheet->setCellValue("L{$counter}", $paymentLeft);
            
            $revenueSum += $revenue;
            $paymentAmountSum += $paymentAmount;
            $paymentLeftSum += $paymentLeft;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:L{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("I{$counter}", 'Total');
        $worksheet->setCellValue("J{$counter}", $revenueSum);
        $worksheet->setCellValue("K{$counter}", $paymentAmountSum);
        $worksheet->setCellValue("L{$counter}", $paymentLeftSum);

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
