<?php

class DailyTransactionController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('deliveryReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $transactionDate = (isset($_GET['TransactionDate'])) ? $_GET['TransactionDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $cashTransactionInData = CashTransaction::model()->findAllByAttributes(array(
            'transaction_date' => $transactionDate,
            'transaction_type' => 'In',
            'branch_id' => $branchId,
        ));
        
        $cashTransactionOutData = CashTransaction::model()->findAllByAttributes(array(
            'transaction_date' => $transactionDate,
            'transaction_type' => 'Out',
            'branch_id' => $branchId,
        ));
        
        $invoiceHeaderData = InvoiceHeader::model()->findAllByAttributes(array(
            'invoice_date' => $transactionDate,
            'branch_id' => $branchId,
        ));
        
        $paymentInData = PaymentIn::model()->findAllByAttributes(array(
            'payment_date' => $transactionDate,
            'branch_id' => $branchId,
        ));
        
        $paymentOutData = PaymentOut::model()->findAllByAttributes(array(
            'payment_date' => $transactionDate,
            'branch_id' => $branchId,
        ));
        
        $movementInData = MovementInHeader::model()->findAll(array(
            'condition' => 'substr(t.date_posting, 1, 10) = :transaction_date AND t.branch_id = :branch_id',
            'params' => array(
                ':transaction_date' => $transactionDate, 
                ':branch_id' => $branchId
            ),
        ));
        
        $movementOutData = MovementOutHeader::model()->findAll(array(
            'condition' => 'substr(t.date_posting, 1, 10) = :transaction_date AND t.branch_id = :branch_id',
            'params' => array(
                ':transaction_date' => $transactionDate, 
                ':branch_id' => $branchId
            ),
        ));
        
        $registrationTransactionData = RegistrationTransaction::model()->findAll(array(
            'condition' => 'substr(t.transaction_date, 1, 10) = :transaction_date AND t.branch_id = :branch_id',
            'params' => array(
                ':transaction_date' => $transactionDate, 
                ':branch_id' => $branchId
            ),
        ));
        
        $deliveryData = TransactionDeliveryOrder::model()->findAllByAttributes(array(
            'delivery_date' => $transactionDate,
            'sender_branch_id' => $branchId,
        ));
        
        $purchaseOrderData = TransactionPurchaseOrder::model()->findAll(array(
            'condition' => 'substr(t.purchase_order_date, 1, 10) = :transaction_date AND t.main_branch_id = :branch_id',
            'params' => array(
                ':transaction_date' => $transactionDate, 
                ':branch_id' => $branchId
            ),
        ));
        
        $receiveItemData = TransactionReceiveItem::model()->findAllByAttributes(array(
            'receive_item_date' => $transactionDate,
            'recipient_branch_id' => $branchId,
        ));
        
        $sentRequestData = TransactionSentRequest::model()->findAllByAttributes(array(
            'sent_request_date' => $transactionDate,
            'requester_branch_id' => $branchId,
        ));
        
        $transferRequestData = TransactionTransferRequest::model()->findAllByAttributes(array(
            'transfer_request_date' => $transactionDate,
            'requester_branch_id' => $branchId,
        ));
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'cashTransactionInData' => $cashTransactionInData,
                'cashTransactionOutData' => $cashTransactionOutData,
                'invoiceHeaderData' => $invoiceHeaderData,
                'paymentInData' => $paymentInData,
                'paymentOutData' => $paymentOutData,
                'movementInData' => $movementInData,
                'movementOutData' => $movementOutData,
                'registrationTransactionData' => $registrationTransactionData,
                'deliveryData' => $deliveryData,
                'purchaseOrderData' => $purchaseOrderData,
                'receiveItemData' => $receiveItemData, 
                'sentRequestData' => $sentRequestData,
                'transferRequestData' => $transferRequestData,
                'branchId' => $branchId,
                'transactionDate' => $transactionDate,
            ));
        }

        $this->render('summary', array(
            'cashTransactionInData' => $cashTransactionInData,
            'cashTransactionOutData' => $cashTransactionOutData,
            'invoiceHeaderData' => $invoiceHeaderData,
            'paymentInData' => $paymentInData,
            'paymentOutData' => $paymentOutData,
            'movementInData' => $movementInData,
            'movementOutData' => $movementOutData,
            'registrationTransactionData' => $registrationTransactionData,
            'deliveryData' => $deliveryData,
            'purchaseOrderData' => $purchaseOrderData,
            'receiveItemData' => $receiveItemData, 
            'sentRequestData' => $sentRequestData,
            'transferRequestData' => $transferRequestData,
            'branchId' => $branchId,
            'transactionDate' => $transactionDate,
            'currentSort' => $currentSort,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
        ));
    }

    protected function saveToExcel(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        
        $transactionDate = $options['transactionDate'];
        $cashTransactionInData = $options['cashTransactionInData'];
        $cashTransactionOutData = $options['cashTransactionOutData'];
        $invoiceHeaderData = $options['invoiceHeaderData'];
        $paymentInData = $options['paymentInData'];
        $paymentOutData = $options['paymentOutData'];
        $movementInData = $options['movementInData'];
        $movementOutData = $options['movementOutData'];
        $registrationTransactionData = $options['registrationTransactionData'];
        $deliveryData = $options['deliveryData'];
        $purchaseOrderData = $options['purchaseOrderData'];
        $receiveItemData = $options['receiveItemData'];
        $sentRequestData = $options['sentRequestData'];
        $transferRequestData = $options['transferRequestData'];
        $branchId = $options['branchId'];

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Transaksi Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Transaksi Harian');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');
        $worksheet->mergeCells('A4:J4');

        $worksheet->getStyle('A1:J6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A3', 'Laporan Transaksi Harian');
        $worksheet->setCellValue('A4', 'Tanggal: ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($transactionDate)));

        $worksheet->getStyle('A6:J6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A6', 'Cash In #');
        $worksheet->setCellValue('B6', 'Tanggal');
        $worksheet->setCellValue('C6', 'Akun');
        $worksheet->setCellValue('D6', 'Status');
        $worksheet->setCellValue('E6', 'Amount');
        $worksheet->getStyle('A7:J7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($cashTransactionInData as $header) {
            $worksheet->getStyle("E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'transaction_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'coa.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'credit_amount')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Cash Out #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Akun');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $worksheet->setCellValue("E{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($cashTransactionOutData as $header) {
            $worksheet->getStyle("E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'transaction_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'coa.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'debit_amount')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Invoice #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Jatuh Tempo');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Kendaraan');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($invoiceHeaderData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'invoice_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'invoice_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'due_date')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment In #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($paymentInData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'payment_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'payment_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'payment_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment Out #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Supplier');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($paymentOutData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'payment_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'payment_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'notes')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'payment_amount')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Movement In #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($movementInData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'movement_in_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'date_posting')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getMovementType($header->movement_type)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Movement Out #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($movementOutData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'movement_out_no')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'date_posting')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getMovementType($header->movement_type)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Registration Transaction #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Kendaraan');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Total');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($registrationTransactionData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'transaction_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'repair_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Pengiriman #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Tujuan');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($deliveryData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'delivery_order_no')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'delivery_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'request_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'destinationBranch.name')));

            $counter++;
        }

        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Pembelian #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Supplier');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Total');
        $counter++;
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($registrationTransactionData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_no')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'purchase_order_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getPurchaseStatus($header->purchase_type)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'supplier.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'note')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status_document')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'total_price')));

            $counter++;
        }

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Transaksi Harian.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
