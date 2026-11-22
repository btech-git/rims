<?php

class PurchaseSummaryController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('purchaseSupplierSummaryReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $supplier = Search::bind(new Supplier('search'), isset($_GET['Supplier']) ? $_GET['Supplier'] : array());
        $supplierDataProvider = $supplier->search();
        $supplierDataProvider->pagination->pageVar = 'page_dialog';
        $supplierDataProvider->criteria->compare('t.status', 'Active');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);

        $purchasePerSupplierSummary = new PurchasePerSupplierSummary($supplier->search());
        $purchasePerSupplierSummary->setupLoading();
        $purchasePerSupplierSummary->setupPaging($pageSize, $currentPage);
        $purchasePerSupplierSummary->setupSorting();
        $purchasePerSupplierSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($purchasePerSupplierSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate, 'branchId' => $branchId));
        }

        $this->render('summary', array(
            'purchasePerSupplierSummary' => $purchasePerSupplierSummary,
            'supplier'=>$supplier,
            'supplierDataProvider'=>$supplierDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentPage' => $currentPage,
            'currentSort' => $currentSort,
            'branchId' => $branchId,
        ));
    }

    public function actionDetailPurchaseTransaction($supplierId, $startDate, $endDate) {
        $purchaseOrders = TransactionReceiveItem::model()->findall(array(
            'condition' => 'supplier_id = :supplier_id AND invoice_date BETWEEN :start_date AND :end_date',
            'params' => array(
                ':supplier_id' => $supplierId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            ),
        ));
        
        $supplier = Supplier::model()->findByPk($supplierId);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailInvoice($purchaseOrders, $startDate, $endDate, $supplier);
        }

        $this->render('detailPurchaseTransaction', array(
            'purchaseOrders' => $purchaseOrders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplierId' => $supplierId,
        ));
    }
    
    public function actionDetailWorkOrderExpenseTransaction($supplierId, $startDate, $endDate) {
        $workOrderExpenses = WorkOrderExpenseHeader::model()->findall(array(
            'condition' => 'supplier_id = :supplier_id AND transaction_date BETWEEN :start_date AND :end_date',
            'params' => array(
                ':supplier_id' => $supplierId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            ),
        ));
        
        $supplier = Supplier::model()->findByPk($supplierId);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailWorkOrder($workOrderExpenses, $startDate, $endDate, $supplier);
        }

        $this->render('detailWorkOrderExpenseTransaction', array(
            'workOrderExpenses' => $workOrderExpenses,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplier' => $supplier,
        ));
    }
    
    public function actionDetailPaymentTransaction($supplierId, $startDate, $endDate) {
        $paymentOuts = PaymentOut::model()->findall(array(
            'condition' => 'supplier_id = :supplier_id AND payment_date BETWEEN :start_date AND :end_date',
            'params' => array(
                ':supplier_id' => $supplierId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
            ),
        ));
        
        $supplier = Supplier::model()->findByPk($supplierId);
        
        if (isset($_GET['SaveExcelDetail'])) {
            $this->saveToExcelDetailPayment($paymentOuts, $startDate, $endDate, $supplier);
        }

        $this->render('detailPaymentTransaction', array(
            'paymentOuts' => $paymentOuts,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'supplier' => $supplier,
        ));
    }
    
    public function actionAjaxJsonSupplier($id) {
        if (Yii::app()->request->isAjaxRequest) {
            $supplier = Supplier::model()->findByPk($id);

            $object = array(
                'supplier_name' => CHtml::value($supplier, 'company'),
                'supplier_code' => CHtml::value($supplier, 'code'),
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
        $documentProperties->setTitle('Pembelian per Supplier Summary');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Pembelian per Supplier Summary');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->mergeCells('A4:E4');
        
        $worksheet->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Pembelian per Supplier Summary');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate));

        $worksheet->getStyle("A6:E6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:E5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:E5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Code');
        $worksheet->setCellValue('B5', 'Company');
        $worksheet->setCellValue('C5', 'Name');
        $worksheet->setCellValue('D5', 'Total Purchase');
        $worksheet->setCellValue('E5', 'Total Sub Pekerjaan Luar');

        $counter = 7;

        $totalPurchase = '0.00';
        $totalWorkOrderExpense = '0.00';
        foreach ($dataProvider->data as $header) {
            $purchasePrice = $header->getPurchasePriceReport($startDate, $endDate, $branchId);
            $workOrderExpensePrice = $header->getWorkOrderExpensePriceReport($startDate, $endDate, $branchId);
//            if ($purchasePrice > 0) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'code')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'company')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'name')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($purchasePrice));
                $worksheet->setCellValue("E{$counter}", CHtml::encode($workOrderExpensePrice));
                $totalPurchase += $purchasePrice;
                $totalWorkOrderExpense += $workOrderExpensePrice;
                $counter++;
//            }
        }

        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);

        $worksheet->getStyle("A{$counter}:D{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:D{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("A{$counter}", 'TOTAL PEMBELIAN');
        $worksheet->setCellValue("C{$counter}", 'Rp');
        $worksheet->setCellValue("D{$counter}", $totalPurchase);
        $worksheet->setCellValue("E{$counter}", $totalWorkOrderExpense);

        $counter++;

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="pembelian_per_supplier_summary.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelDetailInvoice($purchaseOrders, $startDate, $endDate, $supplier) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Pembelian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Pembelian');

        $worksheet->mergeCells('A1:K1');
        $worksheet->mergeCells('A2:K2');
        $worksheet->mergeCells('A3:K3');
        
        $worksheet->getStyle('A1:K5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Transaksi Pembelian ' . CHtml::value($supplier, 'name'));
        $worksheet->setCellValue('A3', 'Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle("A5:K5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:K5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Invoice #');
        $worksheet->setCellValue('C5', 'PO #');
        $worksheet->setCellValue('D5', 'Penerimaan #');
        $worksheet->setCellValue('E5', 'Tanggal');
        $worksheet->setCellValue('F5', 'Type');
        $worksheet->setCellValue('G5', 'Status Hutang');
        $worksheet->setCellValue('H5', 'Status Invoice');
        $worksheet->setCellValue('I5', 'Total');
        $worksheet->setCellValue('J5', 'Pembayaran');
        $worksheet->setCellValue('K5', 'Sisa');
        
        $counter = 6;

        $grandTotal = '0.00';
        $totalPayment = '0.00';
        $totalRemaining = '0.00';

        foreach ($purchaseOrders as $i => $purchaseOrder) {
            $totalPrice = CHtml::value($purchaseOrder, 'invoice_grand_total');
            $paymentAmount = CHtml::value($purchaseOrder, 'invoice_payment_amount');
            $paymentRemaining = CHtml::value($purchaseOrder, 'invoice_payment_remaining');
            
            $worksheet->setCellValue("A{$counter}", ++$i);
            $worksheet->setCellValue("B{$counter}", CHtml::value($purchaseOrder, 'invoice_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($purchaseOrder, 'purchaseOrder.purchase_order_no'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($purchaseOrder, 'receive_item_no'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($purchaseOrder, 'invoice_date'));
            $worksheet->setCellValue("F{$counter}", $purchaseOrder->purchaseOrder->getPurchaseStatus($purchaseOrder->purchaseOrder->purchase_type));
            $worksheet->setCellValue("G{$counter}", CHtml::value($purchaseOrder, 'purchaseOrder.payment_status'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($purchaseOrder, 'purchaseOrder.status_document'));
            $worksheet->setCellValue("I{$counter}", $totalPrice);
            $worksheet->setCellValue("J{$counter}", $paymentAmount);
            $worksheet->setCellValue("K{$counter}", $paymentRemaining);
            
            $grandTotal += $totalPrice;
            $totalPayment += $paymentAmount;
            $totalRemaining += $paymentRemaining;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("H{$counter}", 'Total');
        $worksheet->setCellValue("I{$counter}", $grandTotal);
        $worksheet->setCellValue("J{$counter}", $totalPayment);
        $worksheet->setCellValue("K{$counter}", $totalRemaining);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_pembelian_supplier.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelDetailWorkOrder($workOrderExpenses, $startDate, $endDate, $supplier) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Sub Pekerjaan Luar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Sub Pekerjaan Luar');

        $worksheet->mergeCells('A1:I1');
        $worksheet->mergeCells('A2:I2');
        $worksheet->mergeCells('A3:I3');
        
        $worksheet->getStyle('A1:I5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:I5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Transaksi Sub Pekerjaan Luar ' . CHtml::value($supplier, 'name'));
        $worksheet->setCellValue('A3', 'Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle("A5:I5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:I5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Sub Pekerjaan #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'RG #');
        $worksheet->setCellValue('E5', 'Note');
        $worksheet->setCellValue('F5', 'Status');
        $worksheet->setCellValue('G5', 'Total');
        $worksheet->setCellValue('H5', 'Pembayaran');
        $worksheet->setCellValue('I5', 'Sisa');
        
        $counter = 6;

        $grandTotal = '0.00';
        $totalPayment = '0.00';
        $totalRemaining = '0.00';

        foreach ($workOrderExpenses as $i => $workOrderExpense) {
            $totalPrice = CHtml::value($workOrderExpense, 'grand_total');
            $paymentAmount = CHtml::value($workOrderExpense, 'total_payment');
            $paymentRemaining = CHtml::value($workOrderExpense, 'payment_remaining');
            
            $worksheet->setCellValue("A{$counter}", ++$i);
            $worksheet->setCellValue("B{$counter}", CHtml::value($workOrderExpense, 'transaction_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($workOrderExpense, 'transaction_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($workOrderExpense, 'registrationTransaction.transaction_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($workOrderExpense, 'note'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($workOrderExpense, 'status'));
            $worksheet->setCellValue("G{$counter}", $totalPrice);
            $worksheet->setCellValue("H{$counter}", $paymentAmount);
            $worksheet->setCellValue("I{$counter}", $paymentRemaining);
            
            $grandTotal += $totalPrice;
            $totalPayment += $paymentAmount;
            $totalRemaining += $paymentRemaining;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:I{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:I{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("F{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", $grandTotal);
        $worksheet->setCellValue("H{$counter}", $totalPayment);
        $worksheet->setCellValue("I{$counter}", $totalRemaining);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_sub_pekerjaan_luar.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelDetailPayment($paymentOuts, $startDate, $endDate, $supplier) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Payment Out');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Payment Out');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Transaksi Payment Out ' . CHtml::value($supplier, 'name'));
        $worksheet->setCellValue('A3', 'Tanggal ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:G5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Payment #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Type');
        $worksheet->setCellValue('E5', 'Note');
        $worksheet->setCellValue('F5', 'Status');
        $worksheet->setCellValue('G5', 'Total');
        
        $counter = 6;

        $grandTotal = '0.00';
        foreach ($paymentOuts as $i => $paymentOut) {
            $totalPrice = CHtml::value($paymentOut, 'payment_amount');
            
            $worksheet->setCellValue("A{$counter}", ++$i);
            $worksheet->setCellValue("B{$counter}", CHtml::value($paymentOut, 'payment_number'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($paymentOut, 'payment_date'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($paymentOut, 'paymentType.name'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($paymentOut, 'notes'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($paymentOut, 'status'));
            $worksheet->setCellValue("G{$counter}", $totalPrice);
            
            $grandTotal += $totalPrice;

            $counter++;
        }
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("F{$counter}", 'Total');
        $worksheet->setCellValue("G{$counter}", $grandTotal);

        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_pelunasan_supplier.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}