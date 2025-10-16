<?php

class DailyTransactionController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
//            if (!(Yii::app()->user->checkAccess('dailyTransactionReport'))) {
//                $this->redirect(array('/site/login'));
//            }
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
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

        list($movementInData, $movementOutData, $receiveItemData, $sentRequestData, $transferRequestData, $deliveryData) = $this->getWarehouseTabData($transactionDate, $branchId);
        list($registrationTransactionRetailData, $registrationTransactionCompanyData, $invoiceHeaderRetailData, $invoiceHeaderCompanyData, $paymentInRetailData, $paymentInCompanyData) = $this->getSaleTabData($transactionDate, $branchId);
        list($paymentOutData, $purchaseOrderData) = $this->getPurchaseTabData($transactionDate, $branchId);
        list($cashTransactionInData, $cashTransactionOutData) = $this->getCashTransactionTabData($transactionDate, $branchId);
        list($vehicleData, $registrationTransactionData) = $this->getVehicleTabData($transactionDate, $branchId);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['Confirmation'])) {
            $this->confirmDailyTransaction(array(
                'branchId' => $branchId,
                'transactionDate' => $transactionDate,
            ));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'cashTransactionInData' => $cashTransactionInData,
                'cashTransactionOutData' => $cashTransactionOutData,
                'invoiceHeaderRetailData' => $invoiceHeaderRetailData,
                'invoiceHeaderCompanyData' => $invoiceHeaderCompanyData,
                'paymentInRetailData' => $paymentInRetailData,
                'paymentInCompanyData' => $paymentInCompanyData,
                'paymentOutData' => $paymentOutData,
                'movementInData' => $movementInData,
                'movementOutData' => $movementOutData,
                'registrationTransactionData' => $registrationTransactionData,
                'registrationTransactionRetailData' => $registrationTransactionRetailData,
                'registrationTransactionCompanyData' => $registrationTransactionCompanyData,
                'deliveryData' => $deliveryData,
                'purchaseOrderData' => $purchaseOrderData,
                'receiveItemData' => $receiveItemData, 
                'sentRequestData' => $sentRequestData,
                'transferRequestData' => $transferRequestData,
                'vehicleData' => $vehicleData,
                'branchId' => $branchId,
                'transactionDate' => $transactionDate,
            ));
        }

        $this->render('summary', array(
            'cashTransactionInData' => $cashTransactionInData,
            'cashTransactionOutData' => $cashTransactionOutData,
            'invoiceHeaderRetailData' => $invoiceHeaderRetailData,
            'invoiceHeaderCompanyData' => $invoiceHeaderCompanyData,
            'paymentInRetailData' => $paymentInRetailData,
            'paymentInCompanyData' => $paymentInCompanyData,
            'paymentOutData' => $paymentOutData,
            'movementInData' => $movementInData,
            'movementOutData' => $movementOutData,
            'registrationTransactionData' => $registrationTransactionData,
            'registrationTransactionRetailData' => $registrationTransactionRetailData,
            'registrationTransactionCompanyData' => $registrationTransactionCompanyData,
            'deliveryData' => $deliveryData,
            'purchaseOrderData' => $purchaseOrderData,
            'receiveItemData' => $receiveItemData, 
            'sentRequestData' => $sentRequestData,
            'transferRequestData' => $transferRequestData,
            'vehicleData' => $vehicleData,
            'branchId' => $branchId,
            'transactionDate' => $transactionDate,
            'currentSort' => $currentSort,
            'pageSize' => $pageSize,
            'currentPage' => $currentPage,
        ));
    }
    
    public function getVehicleTabData($transactionDate, $branchId) {
    
        $condition = "substr(t.transaction_date, 1, 10) BETWEEN '" . AppParam::BEGINNING_TRANSACTION_DATE . "' AND :transaction_date AND vehicle.status_location = 'Masuk Bengkel'";
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $vehicleData = RegistrationTransaction::model()->with('vehicle')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.transaction_date, 1, 10) = :transaction_date';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $registrationTransactionData = RegistrationTransaction::model()->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        return array($vehicleData, $registrationTransactionData);
    }
    
    public function getCashTransactionTabData($transactionDate, $branchId) {
    
        $fieldValues = array(
            'transaction_date' => $transactionDate,
            'transaction_type' => 'In',
        );
        if (!empty($branchId)) {
            $fieldValues['branch_id'] = $branchId;
        }
        $cashTransactionInData = CashTransaction::model()->findAllByAttributes($fieldValues);
        
        $fieldValues = array(
            'transaction_date' => $transactionDate,
            'transaction_type' => 'Out',
        );
        if (!empty($branchId)) {
            $fieldValues['branch_id'] = $branchId;
        }
        $cashTransactionOutData = CashTransaction::model()->findAllByAttributes($fieldValues);
        
        return array($cashTransactionInData, $cashTransactionOutData);
    }
    public function getPurchaseTabData($transactionDate, $branchId) {
    
        $fieldValues = array(
            'payment_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $fieldValues['branch_id'] = $branchId;
        }
        $paymentOutData = PaymentOut::model()->findAllByAttributes($fieldValues);
        
        $condition = 'substr(t.purchase_order_date, 1, 10) = :transaction_date';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.main_branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $purchaseOrderData = TransactionPurchaseOrder::model()->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        return array($paymentOutData, $purchaseOrderData);
    }
    public function getSaleTabData($transactionDate, $branchId) {
    
        $condition = 'substr(t.transaction_date, 1, 10) = :transaction_date AND customer.customer_type = "Individual"';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $registrationTransactionRetailData = RegistrationTransaction::model()->with('customer')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.transaction_date, 1, 10) = :transaction_date AND customer.customer_type = "Company"';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $registrationTransactionCompanyData = RegistrationTransaction::model()->with('customer')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.invoice_date, 1, 10) = :transaction_date AND customer.customer_type = "Individual"';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $invoiceHeaderRetailData = InvoiceHeader::model()->with('customer')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.invoice_date, 1, 10) = :transaction_date AND customer.customer_type = "Company"';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $invoiceHeaderCompanyData = InvoiceHeader::model()->with('customer')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.payment_date, 1, 10) = :transaction_date AND customer.customer_type = "Individual"';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $paymentInRetailData = PaymentIn::model()->with('customer')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.payment_date, 1, 10) = :transaction_date AND customer.customer_type = "Company"';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $paymentInCompanyData = PaymentIn::model()->with('customer')->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        return array($registrationTransactionRetailData, $registrationTransactionCompanyData, $invoiceHeaderRetailData, $invoiceHeaderCompanyData, $paymentInRetailData, $paymentInCompanyData);
    }
    
    public function getWarehouseTabData($transactionDate, $branchId) {
        
        $condition = 'substr(t.date_posting, 1, 10) = :transaction_date';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $movementInData = MovementInHeader::model()->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $condition = 'substr(t.date_posting, 1, 10) = :transaction_date';
        $params = array(
            ':transaction_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $condition .= ' AND t.branch_id = :branch_id';
            $params['branch_id'] = $branchId;
        }
        $movementOutData = MovementOutHeader::model()->findAll(array(
            'condition' => $condition,
            'params' => $params,
        ));
        
        $fieldValues = array(
            'receive_item_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $fieldValues['recipient_branch_id'] = $branchId;
        }
        $receiveItemData = TransactionReceiveItem::model()->findAllByAttributes($fieldValues);
        
        $fieldValues = array(
            'sent_request_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $fieldValues['requester_branch_id'] = $branchId;
        }
        $sentRequestData = TransactionSentRequest::model()->findAllByAttributes($fieldValues);
        
        $fieldValues = array(
            'transfer_request_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $fieldValues['requester_branch_id'] = $branchId;
        }
        $transferRequestData = TransactionTransferRequest::model()->findAllByAttributes($fieldValues);
        
        $fieldValues = array(
            'delivery_date' => $transactionDate,
        );
        if (!empty($branchId)) {
            $fieldValues['sender_branch_id'] = $branchId;
        }
        $deliveryData = TransactionDeliveryOrder::model()->findAllByAttributes($fieldValues);
        
        return array($movementInData, $movementOutData, $receiveItemData, $sentRequestData, $transferRequestData, $deliveryData);
    }
    
    public function confirmDailyTransaction(array $options = array()) {
        
        $model = new DailyTransactionConfirmation();
        
        $model->branch_id = $options['branchId'];
        $model->transaction_date = $options['transactionDate'];
        $model->confirmation_date = date('Y-m-d');
        $model->confirmation_time = date('H:i:s');
        $model->user_id_confirm = Yii::app()->user->id;
        $model->save(false);
        
        $this->redirect(array('summary'));
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
        $invoiceHeaderRetailData = $options['invoiceHeaderRetailData'];
        $invoiceHeaderCompanyData = $options['invoiceHeaderCompanyData'];
        $paymentInRetailData = $options['paymentInRetailData'];
        $paymentInCompanyData = $options['paymentInCompanyData'];
        $paymentOutData = $options['paymentOutData'];
        $movementInData = $options['movementInData'];
        $movementOutData = $options['movementOutData'];
//        $registrationTransactionData = $options['registrationTransactionData'];
        $registrationTransactionRetailData = $options['registrationTransactionRetailData'];
        $registrationTransactionCompanyData = $options['registrationTransactionCompanyData'];
        $deliveryData = $options['deliveryData'];
        $purchaseOrderData = $options['purchaseOrderData'];
//        $receiveItemData = $options['receiveItemData'];
//        $sentRequestData = $options['sentRequestData'];
//        $transferRequestData = $options['transferRequestData'];
//        $vehicleData = $options['vehicleData'];
        $branchId = $options['branchId'];

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Transaksi Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Transaksi Harian');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        $worksheet->mergeCells('A4:G4');

        $worksheet->getStyle('A1:K6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:K6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A3', 'Laporan Transaksi Harian');
        $worksheet->setCellValue('A4', 'Tanggal: ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($transactionDate)));

        $worksheet->getStyle('A6:K6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A6", 'Registration Transaction #');
        $worksheet->setCellValue("B6", 'Tanggal');
        $worksheet->setCellValue("C6", 'Tipe');
        $worksheet->setCellValue("D6", 'Customer');
        $worksheet->setCellValue("E6", 'Kendaraan');
        $worksheet->setCellValue("F6", 'Status');
        $worksheet->setCellValue("G6", 'WO #');
        $worksheet->setCellValue('H6', 'Estimasi #');
        $worksheet->setCellValue('I6', 'Total Parts');
        $worksheet->setCellValue('J6', 'Total Jasa');
        $worksheet->setCellValue('K6', 'Total');
        $worksheet->getStyle('A7:K7')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($registrationTransactionRetailData as $header) {
            $worksheet->getStyle("I{$counter}:K{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('yyyy-MM-dd', strtotime($header->transaction_date))));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'repair_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'work_order_number')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'sales_order_number')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'subtotal_product')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'subtotal_service')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Invoice #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Jatuh Tempo');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Kendaraan');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($invoiceHeaderRetailData as $header) {
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment In #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($paymentInRetailData as $header) {
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:K{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:K{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Registration Transaction #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Kendaraan');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'WO #');
        $worksheet->setCellValue("H{$counter}", 'Estimasi #');
        $worksheet->setCellValue("I{$counter}", 'Total Parts');
        $worksheet->setCellValue("J{$counter}", 'Total Jasa');
        $worksheet->setCellValue("K{$counter}", 'Total');
        $worksheet->getStyle("A{$counter}:K{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter++;
        foreach ($registrationTransactionCompanyData as $header) {
            $worksheet->getStyle("I{$counter}:K{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('yyyy-MM-dd', strtotime($header->transaction_date))));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'repair_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'customer.name')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'vehicle.plate_number')));
            $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'work_order_number')));
            $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'sales_order_number')));
            $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'subtotal_product')));
            $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'subtotal_service')));
            $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($header, 'grand_total')));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Invoice #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Jatuh Tempo');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Kendaraan');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($invoiceHeaderCompanyData as $header) {
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment In #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Customer');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($paymentInCompanyData as $header) {
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Pembelian #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Supplier');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Total');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($purchaseOrderData as $header) {
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment Out #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Supplier');
        $worksheet->setCellValue("E{$counter}", 'Note');
        $worksheet->setCellValue("F{$counter}", 'Status');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Cash In #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Akun');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $worksheet->setCellValue("E{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($cashTransactionInData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'transaction_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'coa.name')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));
            $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'credit_amount')));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Cash Out #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Akun');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $worksheet->setCellValue("E{$counter}", 'Amount');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
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

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Movement In #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($movementInData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'movement_in_number')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('yyyy-MM-dd', strtotime($header->date_posting))));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getMovementType($header->movement_type)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Movement Out #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($movementOutData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'movement_out_no')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(Yii::app()->dateFormatter->format('yyyy-MM-dd', strtotime($header->date_posting))));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($header->getMovementType($header->movement_type)));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'status')));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Pengiriman #');
        $worksheet->setCellValue("B{$counter}", 'Tanggal');
        $worksheet->setCellValue("C{$counter}", 'Tipe');
        $worksheet->setCellValue("D{$counter}", 'Tujuan');
        $counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;

        foreach ($deliveryData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'delivery_order_no')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'delivery_date')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'request_type')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'destinationBranch.name')));

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
