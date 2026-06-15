<?php

class BodyRepairMonthlyTransactionController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director') )) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $registrationTransactionCountData = RegistrationTransaction::getRegistrationTransactionCountData($year, $month, $branchId);
        $registrationWorkOrderCountData = RegistrationTransaction::getRegistrationWorkOrderCountData($year, $month, $branchId);
        $workOrderPaintingTransactionCountData = WorkOrderExpenseHeader::getPaintingTransactionCountData($year, $month, $branchId);
        $workOrderOtherTransactionCountData = WorkOrderExpenseHeader::getOtherTransactionCountData($year, $month, $branchId);
        $paymentOutTransactionCountData = PayOutDetail::getWorkOrderExpensePaymentCountData($year, $month, $branchId);
        $invoiceTransactionCountData = InvoiceHeader::getInvoiceTransactionCountData($year, $month, $branchId);
        $paymentInransactionCountData = PaymentInDetail::getPaymentTransactionCountData($year, $month, $branchId);
        
        $bodyRepairTransactionInfoData = array();
        foreach ($registrationTransactionCountData as $registrationTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$registrationTransactionCountDataItem['transaction_date']]['transaction_count'] = $registrationTransactionCountDataItem['transaction_count'];
        }
        foreach ($registrationWorkOrderCountData as $registrationWorkOrderCountDataItem) {
            $bodyRepairTransactionInfoData[$registrationWorkOrderCountDataItem['transaction_date']]['work_order_count'] = $registrationWorkOrderCountDataItem['work_order_count'];
        }
        foreach ($workOrderPaintingTransactionCountData as $workOrderPaintingTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$workOrderPaintingTransactionCountDataItem['transaction_date']]['work_order_expense_painting_count'] = $workOrderPaintingTransactionCountDataItem['transaction_count'];
        }
        foreach ($workOrderOtherTransactionCountData as $workOrderOtherTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$workOrderOtherTransactionCountDataItem['transaction_date']]['work_order_expense_other_count'] = $workOrderOtherTransactionCountDataItem['transaction_count'];
        }
        foreach ($paymentOutTransactionCountData as $paymentOutTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$paymentOutTransactionCountDataItem['transaction_date']]['payment_out_count'] = $paymentOutTransactionCountDataItem['payment_count'];
        }
        foreach ($invoiceTransactionCountData as $invoiceTransactionCountDataItem) {
            $bodyRepairTransactionInfoData[$invoiceTransactionCountDataItem['transaction_date']]['invoice_count'] = $invoiceTransactionCountDataItem['invoice_count'];
        }
        foreach ($paymentInransactionCountData as $paymentInransactionCountData) {
            $bodyRepairTransactionInfoData[$paymentInransactionCountData['transaction_date']]['payment_in_count'] = $paymentInransactionCountData['payment_count'];
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'bodyRepairTransactionInfoData' => $bodyRepairTransactionInfoData,
                'month' => $month,
                'year' => $year,
                'numberOfDays' => $numberOfDays,
            ));
        }

        $this->render('summary', array(
            'bodyRepairTransactionInfoData' => $bodyRepairTransactionInfoData,
            'yearList' => $yearList,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
        ));
    }
    
    public function actionRegistrationTransactionInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'DATE(transaction_date) = :transaction_date AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
        $this->render('registrationTransactionInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionWorkOrderInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'DATE(transaction_date) = :transaction_date AND repair_type = "BR" AND user_id_cancelled IS NULL AND t.work_order_number IS NOT NULL',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
        $this->render('workOrderInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionWorkOrderExpensePaintingInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'DATE(t.transaction_date) = :transaction_date AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND 
                t.supplier_id = 250',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
        $this->render('workOrderExpensePaintingInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionWorkOrderExpenseOtherInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'DATE(t.transaction_date) = :transaction_date AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND 
                t.supplier_id NOT IN (250)',
            'params' => array(':transaction_date' => $transactionDate)
        ));
        
        $this->render('workOrderExpenseOtherInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionPaymentOutInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentOutDetails = PayOutDetail::model()->with(array('paymentOut'))->findAll(array(
            'condition' => 'DATE(paymentOut.payment_date) = :payment_date AND t.work_order_expense_header_id IS NOT NULL AND paymentOut.user_id_cancelled IS NULL',
            'params' => array(':payment_date' => $transactionDate)
        ));
        
        $this->render('paymentOutInfo', array(
            'paymentOutDetails' => $paymentOutDetails,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionInvoiceServiceInfo($transactionDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'DATE(t.invoice_date) = :invoice_date AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':invoice_date' => $transactionDate)
        ));
        
        $this->render('invoiceServiceInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'transactionDate' => $transactionDate,
        ));
    }

    public function actionRegistrationVehicleMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('registrationVehicleMonthlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionRegistrationServiceMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('registrationServiceMonthlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionInvoiceVehicleMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.invoice_date ASC, t.invoice_number ASC',
        ));
        
        $this->render('invoiceVehicleMonthlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionInvoiceServiceMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.invoice_date ASC, t.invoice_number ASC',
        ));
        
        $this->render('invoiceServiceMonthlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionWorkOrderExpenseMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND registrationTransaction.repair_type = "BR" AND
                            w.supplier_id = 250 AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('workOrderExpenseMonthlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
            'month' => $month,
        ));
    }

    protected function saveToExcel(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $bodyRepairTransactionInfoData = $options['bodyRepairTransactionInfoData'];
        $month = $options['month'];
        $year = $options['year'];
        $numberOfDays = $options['numberOfDays'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Body Repair Panel');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Body Repair Panel');

        $worksheet->mergeCells("A1:H1");
        $worksheet->mergeCells("A2:H2");
        $worksheet->mergeCells("A3:H3");
        
        $worksheet->getStyle("A1:H5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:H5")->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Body Repair Transaction Monthly');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));

        $worksheet->getStyle("A5:H5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("A5", 'Tanggal');
        $worksheet->setCellValue("B5", 'Registration');
        $worksheet->setCellValue("C5", 'WO');
        $worksheet->setCellValue("D5", 'Sub Pekerjaan Cat');
        $worksheet->setCellValue("E5", 'Sub Pekerjaan Lain');
        $worksheet->setCellValue("F5", 'Payment Sub Pekerjaan');
        $worksheet->setCellValue("G5", 'Invoice');
        $worksheet->setCellValue("H5", 'Payment In');
        
        $worksheet->getStyle("A5:H5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $registrationTransactionCountSum = 0;
        $workOrderCountSum = 0;
        $workOrderExpensePaintingCountSum = 0;
        $workOrderExpenseOtherCountSum = 0;
        $paymentOutTransactionCountSum = 0;
        $invoiceTransactionCountSum = 0;
        $paymentInTransactionCountSum = 0;
        
        for ($i = 1; $i <= $numberOfDays; $i++) {
            $transactionDate = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $registrationTransactionCount = isset($bodyRepairTransactionInfoData[$transactionDate]['transaction_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['transaction_count'] : 0;
            $workOrderCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_count'] : 0;
            $workOrderExpensePaintingCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_painting_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_painting_count'] : 0;
            $workOrderExpenseOtherCount = isset($bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_other_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['work_order_expense_other_count'] : 0;
            $paymentOutTransactionCountData = isset($bodyRepairTransactionInfoData[$transactionDate]['payment_out_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['payment_out_count'] : 0;
            $invoiceTransactionCount = isset($bodyRepairTransactionInfoData[$transactionDate]['invoice_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['invoice_count'] : 0;
            $paymentInTransactionCountData = isset($bodyRepairTransactionInfoData[$transactionDate]['payment_in_count']) ? $bodyRepairTransactionInfoData[$transactionDate]['payment_in_count'] : 0;
                
            $worksheet->setCellValue("A{$counter}", $transactionDate);
            $worksheet->setCellValue("B{$counter}", $registrationTransactionCount);
            $worksheet->setCellValue("C{$counter}", $workOrderCount);
            $worksheet->setCellValue("D{$counter}", $workOrderExpensePaintingCount);
            $worksheet->setCellValue("E{$counter}", $workOrderExpenseOtherCount);
            $worksheet->setCellValue("F{$counter}", $paymentOutTransactionCountData);
            $worksheet->setCellValue("G{$counter}", $invoiceTransactionCount);
            $worksheet->setCellValue("H{$counter}", $paymentInTransactionCountData);
            
            $registrationTransactionCountSum += $registrationTransactionCount;
            $workOrderCountSum += $workOrderCount;
            $workOrderExpensePaintingCountSum += $workOrderExpensePaintingCount;
            $workOrderExpenseOtherCountSum += $workOrderExpenseOtherCount;
            $paymentOutTransactionCountSum += $paymentOutTransactionCountData;
            $invoiceTransactionCountSum += $invoiceTransactionCount;
            $paymentInTransactionCountSum += $paymentInTransactionCountData; 
            
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:H{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:H{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("B{$counter}", $registrationTransactionCountSum);
        $worksheet->setCellValue("C{$counter}", $workOrderCountSum);
        $worksheet->setCellValue("D{$counter}", $workOrderExpensePaintingCountSum);
        $worksheet->setCellValue("E{$counter}", $workOrderExpenseOtherCountSum);
        $worksheet->setCellValue("F{$counter}", $paymentOutTransactionCountSum);
        $worksheet->setCellValue("G{$counter}", $invoiceTransactionCountSum);
        $worksheet->setCellValue("H{$counter}", $paymentInTransactionCountSum);
                
        $counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="body_repair_transaction_monthly.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}