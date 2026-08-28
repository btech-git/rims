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
//        $supplierDataProvider = $supplier->search();
//        $supplierDataProvider->criteria->compare('t.status', 'Active');
//        $supplierDataProvider->pagination->pageVar = 'page_dialog';

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
            'condition' => "t.invoice_date BETWEEN :start_date AND :end_date AND t.supplier_id = :supplier_id AND t.user_id_cancelled IS NULL AND 
                t.invoice_grand_total - (
                    SELECT COALESCE(SUM(d.amount), 0)
                    FROM " . PayOutDetail::model()->tableName() . " d
                    INNER JOIN " . PaymentOut::model()->tableName() . " h ON h.id = d.payment_out_id
                    WHERE t.id = d.receive_item_id AND h.user_id_cancelled IS NULL AND h.payment_date BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :end_date
                ) > 100" . $branchConditionSql,
            'params' => $params,
        ));
        
//        if (isset($_GET['SaveExcelDetail'])) {
//            $this->saveToExcelDetailTransaction($dataProvider, $endDate, $coa);
//        }

        $this->render('transactionInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplier' => $supplier,
        ));
    }

//    public function actionAjaxJsonSupplier() {
//        if (Yii::app()->request->isAjaxRequest) {
//            $supplierId = (isset($_POST['SupplierId'])) ? $_POST['SupplierId'] : '';
//            $supplier = Supplier::model()->findByPk($supplierId);
//
//            $object = array(
//                'supplier_id' => CHtml::value($supplier, 'id'),
//                'supplier_name' => CHtml::value($supplier, 'name'),
//                'supplier_code' => CHtml::value($supplier, 'code'),
//                'supplier_mobile_phone' => CHtml::value($supplier, 'mobile_phone'),
//            );
//            echo CJSON::encode($object);
//        }
//    }

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
    
    protected function saveToExcelDetailTransaction($dataProvider, $endDate, $coa) {
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

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Hutang Supplier ' . CHtml::value($coa, 'name'));
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