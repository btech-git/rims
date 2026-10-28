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

        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : (Yii::app()->user->checkAccess('director') || Yii::app()->user->branch_id == 6 ? '' : Yii::app()->user->branch_id);
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
    
    public function actionVerifyCashTransaction($id, $branchId, $transactionDate) {
        $model = CashTransaction::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyPurchase($id, $branchId, $transactionDate) {
        $model = TransactionPurchaseOrder::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyPaymentOut($id, $branchId, $transactionDate) {
        $model = PaymentOut::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyRegistration($id, $branchId, $transactionDate) {
        $model = RegistrationTransaction::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyInvoice($id, $branchId, $transactionDate) {
        $model = InvoiceHeader::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyPaymentIn($id, $branchId, $transactionDate) {
        $model = PaymentIn::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifySent($id, $branchId, $transactionDate) {
        $model = TransactionSentRequest::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyTransfer($id, $branchId, $transactionDate) {
        $model = TransactionTransferRequest::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyDelivery($id, $branchId, $transactionDate) {
        $model = TransactionDeliveryOrder::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyMovementOut($id, $branchId, $transactionDate) {
        $model = MovementOutHeader::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyReceive($id, $branchId, $transactionDate) {
        $model = TransactionReceiveItem::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
    }

    public function actionVerifyMovementIn($id, $branchId, $transactionDate) {
        $model = MovementInHeader::model()->findByPk($id);
        $model->is_verified = 1; 
        $model->user_id_verified = Yii::app()->user->id;
        $model->verified_datetime = date('Y-m-d H:i:s');
        $model->update(array('is_verified', 'user_id_verified', 'verified_datetime'));

        $this->redirect(array('summary', 'BranchId' => $branchId, 'TransactionDate' => $transactionDate));
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
        $registrationTransactionRetailData = $options['registrationTransactionRetailData'];
        $registrationTransactionCompanyData = $options['registrationTransactionCompanyData'];
        $deliveryData = $options['deliveryData'];
        $purchaseOrderData = $options['purchaseOrderData'];
        $receiveItemData = $options['receiveItemData'];
        $sentRequestData = $options['sentRequestData'];
        $transferRequestData = $options['transferRequestData'];
//        $vehicleData = $options['vehicleData'];
        $branchId = $options['branchId'];

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Transaksi Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Transaksi Harian');

        $worksheet->mergeCells('A1:L1');
        $worksheet->mergeCells('A2:L2');
        $worksheet->mergeCells('A3:L3');
        $worksheet->mergeCells('A4:L4');

        $worksheet->getStyle('A1:L6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:L6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A3', 'Laporan Transaksi Harian');
        $worksheet->setCellValue('A4', 'Tanggal: ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($transactionDate)));

        $worksheet->getStyle('A6:L6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A6", 'Registration #');
        $worksheet->setCellValue("B6", 'Tipe');
        $worksheet->setCellValue("C6", 'Customer');
        $worksheet->setCellValue("D6", 'Kendaraan');
        $worksheet->setCellValue("E6", 'Status');
        $worksheet->setCellValue("F6", 'WO #');
        $worksheet->setCellValue('G6', 'Estimasi #');
        $worksheet->setCellValue('H6', 'Parts List');
        $worksheet->setCellValue('I6', 'Total Parts');
        $worksheet->setCellValue('J6', 'Total Jasa');
        $worksheet->setCellValue('K6', 'Total');
        $worksheet->setCellValue('L6', 'Verified By');

        $counter = 7;
        foreach ($registrationTransactionRetailData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'repair_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'sales_order_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'products'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'subtotal_product'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'subtotal_service'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'grand_total'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Invoice #');
        $worksheet->setCellValue("B{$counter}", 'Jatuh Tempo');
        $worksheet->setCellValue("C{$counter}", 'Customer');
        $worksheet->setCellValue("D{$counter}", 'Kendaraan');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'Parts List');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $worksheet->setCellValue("H{$counter}", 'Verified By');
        $counter++;

        foreach ($invoiceHeaderRetailData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'due_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment In #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Customer');
        $worksheet->setCellValue("D{$counter}", 'Note');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'Amount');
        $worksheet->setCellValue("G{$counter}", 'Verified By');
        $counter++;

        foreach ($paymentInRetailData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'payment_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'payment_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'notes'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'payment_amount'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:L{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:L{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:L{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Registration #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Customer');
        $worksheet->setCellValue("D{$counter}", 'Kendaraan');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'WO #');
        $worksheet->setCellValue("G{$counter}", 'Estimasi #');
        $worksheet->setCellValue("H{$counter}", 'Parts List');
        $worksheet->setCellValue("I{$counter}", 'Total Parts');
        $worksheet->setCellValue("J{$counter}", 'Total Jasa');
        $worksheet->setCellValue("K{$counter}", 'Total');
        $worksheet->setCellValue("L{$counter}", 'Verified By');

        $counter++;
        foreach ($registrationTransactionCompanyData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'repair_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'work_order_number'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'sales_order_number'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'products'));
            $worksheet->setCellValue("I{$counter}", CHtml::value($header, 'subtotal_product'));
            $worksheet->setCellValue("J{$counter}", CHtml::value($header, 'subtotal_service'));
            $worksheet->setCellValue("K{$counter}", CHtml::value($header, 'grand_total'));
            $worksheet->setCellValue("L{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Invoice #');
        $worksheet->setCellValue("B{$counter}", 'Jatuh Tempo');
        $worksheet->setCellValue("C{$counter}", 'Customer');
        $worksheet->setCellValue("D{$counter}", 'Kendaraan');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'Parts List');
        $worksheet->setCellValue("G{$counter}", 'Amount');
        $worksheet->setCellValue("H{$counter}", 'Verified By');
        $counter++;

        foreach ($invoiceHeaderCompanyData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'invoice_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'due_date'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'vehicle.plate_number'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment In #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Customer');
        $worksheet->setCellValue("D{$counter}", 'Note');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'Amount');
        $worksheet->setCellValue("G{$counter}", 'Verified By');
        $counter++;

        foreach ($paymentInCompanyData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'payment_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'payment_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'customer.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'notes'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'payment_amount'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Pembelian #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Supplier');
        $worksheet->setCellValue("D{$counter}", 'Note');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'Parts List');
        $worksheet->setCellValue("G{$counter}", 'Total');
        $worksheet->setCellValue("H{$counter}", 'Verified By');
        $counter++;

        foreach ($purchaseOrderData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'purchase_order_no'));
            $worksheet->setCellValue("B{$counter}", $header->getPurchaseStatus($header->purchase_type));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'note'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status_document'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'total_price'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Payment Out #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Supplier');
        $worksheet->setCellValue("D{$counter}", 'Note');
        $worksheet->setCellValue("E{$counter}", 'Status');
        $worksheet->setCellValue("F{$counter}", 'Amount');
        $worksheet->setCellValue("G{$counter}", 'Verified By');
        $counter++;

        foreach ($paymentOutData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'payment_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'paymentType.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'notes'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'payment_amount'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Cash In #');
        $worksheet->setCellValue("B{$counter}", 'Akun');
        $worksheet->setCellValue("C{$counter}", 'Status');
        $worksheet->setCellValue("D{$counter}", 'Amount');
        $worksheet->setCellValue("E{$counter}", 'Verified By');
        $counter++;

        foreach ($cashTransactionInData as $header) {
            $worksheet->getStyle("G{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'coa.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'credit_amount'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Cash Out #');
        $worksheet->setCellValue("B{$counter}", 'Akun');
        $worksheet->setCellValue("C{$counter}", 'Status');
        $worksheet->setCellValue("D{$counter}", 'Amount');
        $worksheet->setCellValue("E{$counter}", 'Verified By');
        $counter++;

        foreach ($cashTransactionOutData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_number'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'coa.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'debit_amount'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Sent Request #');
        $worksheet->setCellValue("B{$counter}", 'Tujuan');
        $worksheet->setCellValue("C{$counter}", 'Parts List');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $worksheet->setCellValue("E{$counter}", 'Verified By');
        $counter++;

        foreach ($sentRequestData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'sent_request_no'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'destinationBranch.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'status_document'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:E{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Transfer Request #');
        $worksheet->setCellValue("B{$counter}", 'Tujuan');
        $worksheet->setCellValue("C{$counter}", 'Parts List');
        $worksheet->setCellValue("D{$counter}", 'Status');
        $worksheet->setCellValue("E{$counter}", 'Verified By');
        $counter++;

        foreach ($transferRequestData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transfer_request_no'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'destinationBranch.name'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'status_document'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Pengiriman #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Tujuan');
        $worksheet->setCellValue("D{$counter}", 'Reference #');
        $worksheet->setCellValue("E{$counter}", 'Parts List');
        $worksheet->setCellValue("F{$counter}", 'Verified By');
        $counter++;

        foreach ($deliveryData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'delivery_order_no'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'request_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'destinationBranch.name'));
            if (!empty($header->sales_order_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'salesOrder.sale_order_no'));
            } elseif (!empty($header->sent_request_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'sentRequest.sent_request_no'));
            } elseif (!empty($header->consignment_out_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'consignmentOut.consignment_out_no'));
            } elseif (!empty($header->transfer_request_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'transferRequest.transfer_request_no'));
            } else {
                $worksheet->setCellValue("D{$counter}", '');
            }
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Movement Out #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Status');
        $worksheet->setCellValue("D{$counter}", 'Reference #');
        $worksheet->setCellValue("E{$counter}", 'Parts List');
        $worksheet->setCellValue("F{$counter}", 'Verified By');
        $counter++;

        foreach ($movementOutData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'movement_out_no'));
            $worksheet->setCellValue("B{$counter}", $header->getMovementType($header->movement_type));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'status'));
            if (!empty($header->delivery_order_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'deliveryOrder.delivery_order_no'));
            } elseif (!empty($header->return_order_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'returnOrder.return_order_no'));
            } elseif (!empty($header->registration_transaction_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'registrationTransaction.transaction_number'));
            } elseif (!empty($header->material_request_header_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'materialRequestHeader.transaction_number'));
            } else {
                $worksheet->setCellValue("D{$counter}", '');
            }
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:H{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Penerimaan #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Supplier');
        $worksheet->setCellValue("D{$counter}", 'ETA');
        $worksheet->setCellValue("E{$counter}", 'Tujuan');
        $worksheet->setCellValue("F{$counter}", 'Reference #');
        $worksheet->setCellValue("G{$counter}", 'Parts List');
        $worksheet->setCellValue("H{$counter}", 'Verified By');
        $counter++;

        foreach ($receiveItemData as $header) {
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'receive_item_no'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'request_type'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'supplier.name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'estimate_arrival_date'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'destinationBranch.name'));
            if (!empty($header->purchase_order_id)) {
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'purchaseOrder.purchase_order_no'));
            } elseif (!empty($header->transfer_request_id)) {
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'transferRequest.transfer_request_no'));
            } elseif (!empty($header->consignment_in_id)) {
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'consignmentIn.consignment_in_number'));
            } elseif (!empty($header->delivery_order_id)) {
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'deliveryOrder.delivery_order_no'));
            } elseif (!empty($header->movement_out_id)) {
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'movementOut.movement_out_no'));
            } else {
                $worksheet->setCellValue("F{$counter}", '');
            }
            $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'productLists'));
            $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        $counter++;$counter++;
        $worksheet->getStyle("A{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A{$counter}", 'Movement In #');
        $worksheet->setCellValue("B{$counter}", 'Tipe');
        $worksheet->setCellValue("C{$counter}", 'Status');
        $worksheet->setCellValue("D{$counter}", 'Reference #');
        $worksheet->setCellValue("E{$counter}", 'Parts List');
        $worksheet->setCellValue("F{$counter}", 'Verified By');
        $counter++;

        foreach ($movementInData as $header) {

            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'movement_in_number'));
            $worksheet->setCellValue("B{$counter}", $header->getMovementType($header->movement_type));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'status'));
            if (!empty($header->return_item_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'returnItem.return_item_no'));
            } elseif (!empty($header->receive_item_id)) {
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'receiveItem.receive_item_no'));
            } else {
                $worksheet->setCellValue("D{$counter}", '');
            }
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'status'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'userIdVerified.username'));

            $counter++;
        }

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_transaksi_harian.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
