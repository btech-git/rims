<?php

class BodyRepairYearlyTransactionController extends Controller {

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

        $yearNow = date('Y');
        
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $registrationTransactionYearlyCountData = RegistrationTransaction::getRegistrationTransactionYearlyCountData($year, $branchId);
        $registrationWorkOrderYearlyCountData = RegistrationTransaction::getRegistrationWorkOrderYearlyCountData($year, $branchId);
        $workOrderPaintingTransactionYearlyCountData = WorkOrderExpenseHeader::getPaintingTransactionYearlyCountData($year, $branchId);
        $workOrderOtherTransactionYearlyCountData = WorkOrderExpenseHeader::getOtherTransactionYearlyCountData($year, $branchId);
        $paymentOutTransactionYearlyCountData = PayOutDetail::getWorkOrderExpensePaymentYearlyCountData($year, $branchId);
        $invoiceTransactionYearlyCountData = InvoiceHeader::getInvoiceTransactionYearlyCountData($year, $branchId);
        $paymentInransactionYearlyCountData = PaymentInDetail::getPaymentTransactionYearlyCountData($year, $branchId);
        
        $bodyRepairTransactionInfoData = array();
        foreach ($registrationTransactionYearlyCountData as $registrationTransactionYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$registrationTransactionYearlyCountDataItem['transaction_month']]['transaction_count'] = $registrationTransactionYearlyCountDataItem['transaction_count'];
        }
        foreach ($registrationWorkOrderYearlyCountData as $registrationWorkOrderYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$registrationWorkOrderYearlyCountDataItem['transaction_month']]['work_order_count'] = $registrationWorkOrderYearlyCountDataItem['work_order_count'];
        }
        foreach ($workOrderPaintingTransactionYearlyCountData as $workOrderPaintingTransactionYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$workOrderPaintingTransactionYearlyCountDataItem['transaction_month']]['work_order_expense_painting_count'] = $workOrderPaintingTransactionYearlyCountDataItem['service_count'];
        }
        foreach ($workOrderOtherTransactionYearlyCountData as $workOrderOtherTransactionYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$workOrderOtherTransactionYearlyCountDataItem['transaction_month']]['work_order_expense_other_count'] = $workOrderOtherTransactionYearlyCountDataItem['service_count'];
        }
        foreach ($paymentOutTransactionYearlyCountData as $paymentOutTransactionYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$paymentOutTransactionYearlyCountDataItem['transaction_month']]['payment_out_count'] = $paymentOutTransactionYearlyCountDataItem['payment_count'];
        }
        foreach ($invoiceTransactionYearlyCountData as $invoiceTransactionYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$invoiceTransactionYearlyCountDataItem['transaction_month']]['invoice_count'] = $invoiceTransactionYearlyCountDataItem['invoice_count'];
        }
        foreach ($paymentInransactionYearlyCountData as $paymentInransactionYearlyCountDataItem) {
            $bodyRepairTransactionInfoData[$paymentInransactionYearlyCountDataItem['transaction_month']]['payment_in_count'] = $paymentInransactionYearlyCountDataItem['payment_count'];
        }
        
        $monthList = array(
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'bodyRepairTransactionInfoData' => $bodyRepairTransactionInfoData,
                'year' => $year,
                'monthList' => $monthList,
            ));
        }

        $this->render('summary', array(
            'bodyRepairTransactionInfoData' => $bodyRepairTransactionInfoData,
            'yearList' => $yearList,
            'year' => $year,
            'branchId' => $branchId,
            'monthList' => $monthList,
        ));
    }
    
    public function actionRegistrationTransactionYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(transaction_date) = :year AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year)
        ));
        
        $this->render('registrationTransactionYearlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
        ));
    }

    public function actionWorkOrderYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(transaction_date) = :year AND repair_type = "BR" AND user_id_cancelled IS NULL AND t.work_order_number IS NOT NULL',
            'params' => array(':year' => $year)
        ));
        
        $this->render('workOrderYearlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
        ));
    }

    public function actionWorkOrderExpensePaintingYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND 
                t.supplier_id = 250',
            'params' => array(':year' => $year)
        ));
        
        $this->render('workOrderExpensePaintingYearlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
        ));
    }

    public function actionWorkOrderExpenseOtherYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL AND 
                t.supplier_id NOT IN (250)',
            'params' => array(':year' => $year)
        ));
        
        $this->render('workOrderExpenseOtherYearlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
        ));
    }

    public function actionPaymentOutYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentOutDetails = PayOutDetail::model()->with(array('paymentOut'))->findAll(array(
            'condition' => 'YEAR(paymentOut.payment_date) = :year AND t.work_order_expense_header_id IS NOT NULL AND paymentOut.user_id_cancelled IS NULL',
            'params' => array(':year' => $year),
            'order' => 'paymentOut.payment_date ASC, paymentOut.payment_number ASC',
        ));
        
        $this->render('paymentOutYearlyInfo', array(
            'paymentOutDetails' => $paymentOutDetails,
            'year' => $year,
        ));
    }

    public function actionInvoiceTransactionYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year),
            'order' => 't.invoice_date ASC, t.invoice_number ASC',
        ));
        
        $this->render('invoiceTransactionYearlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
        ));
    }

    public function actionPaymentInYearlyInfo($year) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $criteria = new CDbCriteria;
        $criteria->together = 'true';
        $criteria->with = array(
            'invoiceHeader' => array(
                'with' => array(
                    'registrationTransaction'
                ),
            ), 
            'paymentIn', 
        );
        $criteria->condition = 'YEAR(paymentIn.payment_date) = :year AND registrationTransaction.repair_type = "BR" AND paymentIn.user_id_cancelled IS NULL';
        $criteria->params = array(':year' => $year);
        $criteria->order = 'paymentIn.payment_date ASC, paymentIn.payment_number ASC';

        $paymentInDetails = PaymentInDetail::model()->findAll($criteria);
        
        $this->render('paymentInYearlyInfo', array(
            'paymentInDetails' => $paymentInDetails,
            'year' => $year,
        ));
    }

    public function actionRegistrationTransactionMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND repair_type = "BR" AND user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('registrationTransactionMonthlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionWorkOrderMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $registrationTransactions = RegistrationTransaction::model()->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND repair_type = "BR" AND
                            t.work_order_number IS NOT NULL AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('workOrderMonthlyInfo', array(
            'registrationTransactions' => $registrationTransactions,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionWorkOrderExpensePaintingMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND registrationTransaction.repair_type = "BR" AND
                            t.supplier_id = 250 AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('workOrderExpensePaintingMonthlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionWorkOrderExpenseOtherMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpenses = WorkOrderExpenseHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.transaction_date) = :year AND MONTH(t.transaction_date) = :month AND registrationTransaction.repair_type = "BR" AND
                            t.supplier_id NOT IN (250) AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.transaction_date ASC, t.transaction_number ASC',
        ));
        
        $this->render('workOrderExpenseOtherMonthlyInfo', array(
            'workOrderExpenses' => $workOrderExpenses,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionPaymentOutMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $paymentOutDetails = PayOutDetail::model()->with(array('paymentOut'))->findAll(array(
            'condition' => 'YEAR(paymentOut.payment_date) = :year AND MONTH(paymentOut.payment_date) = :month AND t.work_order_expense_header_id IS NOT NULL AND
                            paymentOut.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 'paymentOut.payment_date ASC, paymentOut.payment_number ASC',
        ));
        
        $this->render('paymentOutMonthlyInfo', array(
            'paymentOutDetails' => $paymentOutDetails,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionInvoiceTransactionMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $invoiceHeaders = InvoiceHeader::model()->with(array('registrationTransaction'))->findAll(array(
            'condition' => 'YEAR(t.invoice_date) = :year AND MONTH(t.invoice_date) = :month AND registrationTransaction.repair_type = "BR" AND t.user_id_cancelled IS NULL',
            'params' => array(':year' => $year, ':month' => $month),
            'order' => 't.invoice_date ASC, t.invoice_number ASC',
        ));
        
        $this->render('invoiceTransactionMonthlyInfo', array(
            'invoiceHeaders' => $invoiceHeaders,
            'year' => $year,
            'month' => $month,
        ));
    }

    public function actionPaymentInMonthlyInfo($year, $month) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $criteria = new CDbCriteria;
        $criteria->together = 'true';
        $criteria->with = array(
            'invoiceHeader' => array(
                'with' => array(
                    'registrationTransaction'
                ),
            ), 
            'paymentIn', 
        );
        $criteria->condition = 'YEAR(paymentIn.payment_date) = :year AND MONTH(paymentIn.payment_date) = :month AND registrationTransaction.repair_type = "BR" AND paymentIn.user_id_cancelled IS NULL';
        $criteria->params = array(':year' => $year, ':month' => $month);
        $criteria->order = 'paymentIn.payment_date ASC, paymentIn.payment_number ASC';

        $paymentInDetails = PaymentInDetail::model()->findAll($criteria);
        
        $this->render('paymentInMonthlyInfo', array(
            'paymentInDetails' => $paymentInDetails,
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
        $monthList = $options['monthList'];
        $year = $options['year'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Body Repair Tahunan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Body Repair Tahunan');

        $worksheet->mergeCells("A1:H1");
        $worksheet->mergeCells("A2:H2");
        $worksheet->mergeCells("A3:H3");
        
        $worksheet->getStyle("A1:H5")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:H5")->getFont()->setBold(true);
        
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Body Repair Transaction Yearly');
        $worksheet->setCellValue('A3', $year);

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
        
        for ($i = 1; $i <= 12; $i++) {
            $registrationTransactionCount = isset($bodyRepairTransactionInfoData[$i]['transaction_count']) ? $bodyRepairTransactionInfoData[$i]['transaction_count'] : 0;
            $workOrderCount = isset($bodyRepairTransactionInfoData[$i]['work_order_count']) ? $bodyRepairTransactionInfoData[$i]['work_order_count'] : 0;
            $workOrderExpensePaintingCount = isset($bodyRepairTransactionInfoData[$i]['work_order_expense_painting_count']) ? $bodyRepairTransactionInfoData[$i]['work_order_expense_painting_count'] : 0;
            $workOrderExpenseOtherCount = isset($bodyRepairTransactionInfoData[$i]['work_order_expense_other_count']) ? $bodyRepairTransactionInfoData[$i]['work_order_expense_other_count'] : 0;
            $paymentOutTransactionCountData = isset($bodyRepairTransactionInfoData[$i]['payment_out_count']) ? $bodyRepairTransactionInfoData[$i]['payment_out_count'] : 0;
            $invoiceTransactionCount = isset($bodyRepairTransactionInfoData[$i]['invoice_count']) ? $bodyRepairTransactionInfoData[$i]['invoice_count'] : 0;
            $paymentInTransactionCountData = isset($bodyRepairTransactionInfoData[$i]['payment_in_count']) ? $bodyRepairTransactionInfoData[$i]['payment_in_count'] : 0;
                
            $worksheet->setCellValue("A{$counter}", $monthList[$i]);
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
        header('Content-Disposition: attachment;filename="body_repair_transaction_yearly.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}