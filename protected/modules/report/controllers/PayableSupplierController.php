<?php

class PayableSupplierController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('payableReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
        $supplierId = (isset($_GET['SupplierId'])) ? $_GET['SupplierId'] : '';
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        
        if (isset($_GET['ResetFilter'])) {
            $pageSize = '';
            $currentPage = '';
            $currentSort = '';
            $branchId = (Yii::app()->user->checkAccess('director') ? '' : Yii::app()->user->branch_id);
            $supplierId = '';
            $endDate = date('Y-m-d');
        }
        
        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());

        $payableSummary = new PayableSupplierSummary($supplier->search());
        $payableSummary->setupLoading();
        $payableSummary->setupPaging($pageSize, $currentPage);
        $payableSummary->setupSorting();
        $filters = array(
            'endDate' => $endDate,
            'branchId' => $branchId,
            'supplierId' => $supplierId,
        );
        $payableSummary->setupFilter($filters);

        $supplierIds = array_map(function($supplier) { return $supplier->id; }, $payableSummary->dataProvider->data);
        $payableReport = TransactionReceiveItem::getPayableReport($endDate, $branchId, $supplierIds);
        $invoiceHeaderIds = array_map(function($payableReportItem) { return $payableReportItem['id']; }, $payableReport);
        $payablePaymentReport = PayOutDetail::getPayablePaymentReport($endDate, $invoiceHeaderIds);
        
        $payableReportData = array();
        foreach ($payableReport as $payableReportItem) {
            if (!isset($payableReportData[$payableReportItem['supplier_id']])) {
                $payableReportData[$payableReportItem['supplier_id']] = array();
            }
            $payableReportData[$payableReportItem['supplier_id']][] = $payableReportItem;
        }
        
        $payablePaymentReportData = array();
        foreach ($payablePaymentReport as $payablePaymentReportItem) {
            $payablePaymentReportData[$payablePaymentReportItem['receive_item_id']] = $payablePaymentReportItem['payment_amount'];
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($payableSummary, $payableReportData, $payablePaymentReportData, $endDate, $branchId);
        }

        $this->render('summary', array(
            'payableSummary' => $payableSummary,
            'payableReportData' => $payableReportData,
            'payablePaymentReportData' => $payablePaymentReportData,
//            'supplier' => $supplier,
//            'supplierDataProvider' => $supplierDataProvider,
            'supplierId' => $supplierId,
            'branchId' => $branchId,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
            'currentPage' => $currentPage,
        ));
    }

    public function actionTransactionInfo($supplierId, $branchId, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = AppParam::BEGINNING_TRANSACTION_DATE;
        $supplier = Supplier::model()->findByPk($supplierId);
        $branchConditionSql = '';
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':supplier_id' => $supplierId,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND purchaseOrder.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        $invoiceHeaders = TransactionReceiveItem::model()->with('purchaseOrder')->findAll(array(
            'condition' => "t.invoice_date BETWEEN :start_date AND :end_date AND t.supplier_id = :supplier_id AND t.user_id_cancelled IS NULL" . $branchConditionSql,
            'params' => $params,
        ));
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailTransaction($invoiceHeaders, $startDate, $endDate, $supplier);
        }

        $this->render('transactionInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplier' => $supplier,
        ));
    }

    protected function saveToExcel($payableSummary, $payableReportData, $payablePaymentReportData, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Hutang Supplier Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Hutang Supplier Summary');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');

        $worksheet->getStyle('A1:F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);
        
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Hutang Supplier Summary');
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
        
        $totalInvoiceSum = '0.00';
        $totalPaymentSum = '0.00';
        $totalRemainingSum = '0.00';
        
        foreach ($payableSummary->dataProvider->data as $i => $supplier) {
            $totalRevenue = '0.00';
            $totalPayment = '0.00';
            $totalReceivable = '0.00';
            
            foreach ($payableReportData[$supplier->id] as $payableReportItem) {
                $revenue = $payableReportItem['invoice_grand_total'];
                $paymentAmount = isset($payablePaymentReportData[$payableReportItem['id']]) ? $payablePaymentReportData[$payableReportItem['id']] : '0.00';
                $paymentLeft = $revenue - $paymentAmount;
                $totalRevenue += $revenue;
                $totalPayment += $paymentAmount;
                $totalReceivable += $paymentLeft;
            }
                
            $worksheet->setCellValue("A{$counter}", ++$i);
            $worksheet->setCellValue("B{$counter}", CHtml::value($supplier, 'name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($supplier, 'coa.name'));
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
        header('Content-Disposition: attachment;filename="hutang_supplier_summary.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelDetailTransaction($invoiceHeaders, $startDate, $endDate, $supplier) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Hutang Supplier Detail');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Hutang Supplier Detail');

        $worksheet->mergeCells('A1:H1');
        $worksheet->mergeCells('A2:H2');
        $worksheet->mergeCells('A3:H3');
        
        $worksheet->getStyle('A1:H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:H5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Transaksi Detail Hutang Supplier ' . CHtml::value($supplier, 'name'));
        $worksheet->setCellValue('A3', 'Per Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A5:H5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:H5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'Invoice #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Jatuh Tempo');
        $worksheet->setCellValue('D5', 'PO #');
        $worksheet->setCellValue('E5', 'Type');
        $worksheet->setCellValue('F5', 'Total');
        $worksheet->setCellValue('G5', 'Pembayaran');
        $worksheet->setCellValue('H5', 'Sisa');
        
        $counter = 6;

        $revenueSum = '0.00';
        $paymentAmountSum = '0.00';
        $paymentLeftSum = '0.00';

        foreach ($invoiceHeaders as $invoiceHeader) {
            $revenue = CHtml::value($invoiceHeader, 'invoice_grand_total');
            $paymentAmount = '0.00';
            $paymentOutDetails = PayOutDetail::model()->with('paymentOut')->findAll(array(
                'condition' => 't.receive_item_id = :invoice_id AND paymentOut.payment_date BETWEEN :start_date AND :end_date AND paymentOut.user_id_cancelled IS NULL',
                'params' => array(
                    ':start_date' => $startDate,
                    ':end_date' => $endDate,
                    ':invoice_id' => $invoiceHeader->id,
                )
            ));
            
            foreach ($paymentOutDetails as $paymentOutDetail) {
                $paymentAmount += $paymentOutDetail->amount;
            }
            $paymentLeft = $revenue - $paymentAmount;
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($invoiceHeader, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($invoiceHeader, 'invoice_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($invoiceHeader, 'invoice_due_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($invoiceHeader, 'purchaseOrder.purchase_order_no'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($invoiceHeader, 'invoice_due_date'));
            $worksheet->setCellValue("F{$counter}", $revenue);
            $worksheet->setCellValue("G{$counter}", $paymentAmount);
            $worksheet->setCellValue("H{$counter}", $paymentLeft);
            
            $revenueSum += $revenue;
            $paymentAmountSum += $paymentAmount;
            $paymentLeftSum += $paymentLeft;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("E{$counter}", 'Total');
        $worksheet->setCellValue("F{$counter}", $revenueSum);
        $worksheet->setCellValue("G{$counter}", $paymentAmountSum);
        $worksheet->setCellValue("H{$counter}", $paymentLeftSum);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_detail_hutang_supplier.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/accounting/paymentOut/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'PO') {
            $model = TransactionPurchaseOrder::model()->findByAttributes(array('purchase_order_no' => $codeNumber));
            $this->redirect(array('/transaction/transactionPurchaseOrder/show', 'id' => $model->id));
        }
    }
}