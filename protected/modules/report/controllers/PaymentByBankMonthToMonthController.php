<?php

class PaymentByBankMonthToMonthController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('monthlyBankingReport') )) {
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
        
        $monthStart = isset($_GET['MonthStart']) ? $_GET['MonthStart'] : $monthNow;
        $monthEnd = isset($_GET['MonthEnd']) ? $_GET['MonthEnd'] : $monthNow;
        $yearStart = isset($_GET['YearStart']) ? $_GET['YearStart'] : $yearNow;
        $yearEnd = isset($_GET['YearEnd']) ? $_GET['YearEnd'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $coaIds = isset($_GET['CoaIds']) ? $_GET['CoaIds'] : array();
        
        $coaList = Coa::model()->findAll(array('condition' => 't.coa_sub_category_id IN (1, 2, 3) AND t.status = "Approved"', 'order' => 't.name ASC'));
        
        $coaInSql = '= NULL';
        if (!empty($coaIds)) {
            $coaInSql = "IN (" . implode(',', $coaIds) . ")";
        }
        $selectedCoas = Coa::model()->findAll(array('condition' => 't.id ' . $coaInSql, 'order' => 't.name ASC'));
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd);
        
        $startDate = $yearStart . '-' . $monthStart . '-01';
        $endDate = $yearEnd . '-' . $monthEnd . '-' . str_pad($numberOfDays, 2, '0', STR_PAD_LEFT);
        
        $paymentInMonthlyByBankList = JurnalUmum::getPaymentInMonthlyByBankList($startDate, $endDate, $branchId, $coaIds);
        $paymentOutMonthlyByBankList = JurnalUmum::getPaymentOutMonthlyByBankList($startDate, $endDate, $branchId, $coaIds);
        
        $coaIdList = array();
        foreach ($coaList as $coa) {
            $coaIdList[] = $coa->id;
        }
        
        $paymentInMonthlyList = array();
        foreach ($paymentInMonthlyByBankList as $paymentInMonthlyByBankRow) {
            $month = str_pad($paymentInMonthlyByBankRow['month'], 2, '0', STR_PAD_LEFT);
            $paymentInMonthlyList[$paymentInMonthlyByBankRow['coa_id']]['name'] = $paymentInMonthlyByBankRow['coa_name'];
            $paymentInMonthlyList[$paymentInMonthlyByBankRow['coa_id']]['amounts'][$paymentInMonthlyByBankRow['year'] . '-' . $month] = $paymentInMonthlyByBankRow['total_amount'];
        }
        
        $paymentOutMonthlyList = array();
        foreach ($paymentOutMonthlyByBankList as $paymentOutMonthlyByBankRow) {
            $month = str_pad($paymentOutMonthlyByBankRow['month'], 2, '0', STR_PAD_LEFT);
            $paymentOutMonthlyList[$paymentOutMonthlyByBankRow['coa_id']]['name'] = $paymentOutMonthlyByBankRow['coa_name'];
            $paymentOutMonthlyList[$paymentOutMonthlyByBankRow['coa_id']]['amounts'][$paymentOutMonthlyByBankRow['year'] . '-' . $month] = $paymentOutMonthlyByBankRow['total_amount'];
        }
        
        $monthYearLimit = $yearEnd * 12 + $monthEnd;

        $yearMonthList = array();
        $yearMonthNames = array();
        
        $currentMonth = $monthStart;
        $currentYear = $yearStart;
        while ($currentYear * 12 + $currentMonth <= $monthYearLimit) {
            $yearMonth = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
            $yearMonthList[] = $yearMonth;
            $yearMonthNames[$yearMonth] = date("M", mktime(0, 0, 0, $currentMonth, 1)) . ' ' . $currentYear;
            if ((int) $currentMonth < 12) {
                $currentMonth++;
            } else {
                $currentMonth = 1;
                $currentYear++;
            }
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'paymentInMonthlyList' => $paymentInMonthlyList,
                'paymentOutMonthlyList' => $paymentOutMonthlyList,
                'monthStart' => $monthStart,
                'monthEnd' => $monthEnd,
                'yearStart' => $yearStart,
                'yearEnd' => $yearEnd,
                'branchId' => $branchId,
                'yearMonthList' => $yearMonthList,
                'yearMonthNames' => $yearMonthNames,
            ));
        }

        $this->render('summary', array(
            'paymentInMonthlyList' => $paymentInMonthlyList,
            'paymentOutMonthlyList' => $paymentOutMonthlyList,
            'yearList' => $yearList,
            'coaList' => $coaList,
            'monthStart' => $monthStart,
            'monthEnd' => $monthEnd,
            'yearStart' => $yearStart,
            'yearEnd' => $yearEnd,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
            'coaIds' => $coaIds,
            'selectedCoas' => $selectedCoas,
            'yearMonthList' => $yearMonthList,
            'yearMonthNames' => $yearMonthNames,
        ));
    }
    
    public function actionTransactionInfo($coaId, $debitCredit, $year, $month, $branchId, $inOut) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = JurnalUmum::model()->searchByMonthlyTransactionInfo($coaId, $debitCredit, $year, $month, $branchId, $page);
        $coa = Coa::model()->findByPk($coaId);
        $branch = Branch::model()->findByPk($branchId);
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelMonthlyTransactionInfo(array(
                'dataProvider' => $dataProvider,
                'year' => $year,
                'month' => $month,
                'coa' => $coa,
                'branch' => $branch,
                'inOut' => $inOut,
            ));
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'debitCredit' => $debitCredit,
            'year' => $year,
            'month' => $month,
            'coa' => $coa,
            'coaId' => $coaId,
            'branchId' => $branchId,
            'branch' => $branch,
            'inOut' => $inOut,
        ));
    }

    public function actionRedirectTransaction($codeNumber) {
        list($leftPart,, ) = explode('/', $codeNumber);
        list(, $codeNumberConstant) = explode('.', $leftPart);

        if ($codeNumberConstant === 'Pin') {
            $model = PaymentIn::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/transaction/paymentIn/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'Pout') {
            $model = PaymentOut::model()->findByAttributes(array('payment_number' => $codeNumber));
            $this->redirect(array('/accounting/paymentOut/show', 'id' => $model->id));
        } else if ($codeNumberConstant === 'CASH') {
            $model = CashTransaction::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/transaction/cashTransaction/show', 'id' => $model->id));
        }
    }

    protected function saveToExcel(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $paymentInMonthlyList = $options['paymentInMonthlyList'];
        $paymentOutMonthlyList = $options['paymentOutMonthlyList'];
        $monthStart = $options['monthStart'];
        $yearStart = $options['yearStart'];
        $monthEnd = $options['monthEnd'];
        $yearEnd = $options['yearEnd'];
        $branchId = $options['branchId'];
        $yearMonthList = $options['yearMonthList'];
        $yearMonthNames = $options['yearMonthNames'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Bank Multi Bulan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Bank Multi Bulan');

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Bank Multi Bulan');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$monthStart))) . ' ' . CHtml::encode($yearStart) . ' - ' . CHtml::encode(strftime("%B",mktime(0,0,0,$monthEnd))) . ' ' . CHtml::encode($yearEnd));
        $worksheet->setCellValue('A5', 'Transaksi Bank Masuk');

        $amountInTotals = array();
        $columnCounterIn = 'B';
        foreach ($yearMonthList as $yearMonth) {
            $worksheet->setCellValue("{$columnCounterIn}6", CHtml::encode($yearMonthNames[$yearMonth]));
            $amountInTotals[$yearMonth] = '0.00'; 
            $columnCounterIn++;
        }
        $worksheet->setCellValue("{$columnCounterIn}6", 'Total');
        
        $worksheet->mergeCells("A1:{$columnCounterIn}1");
        $worksheet->mergeCells("A2:{$columnCounterIn}2");
        $worksheet->mergeCells("A3:{$columnCounterIn}3");
        $worksheet->mergeCells("A5:{$columnCounterIn}5");

        $worksheet->getStyle("A1:{$columnCounterIn}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:{$columnCounterIn}6")->getFont()->setBold(true);
        $worksheet->getStyle("A6:{$columnCounterIn}6")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCounterIn}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $grandTotal = '0.00';
        foreach ($paymentInMonthlyList as $coaId => $paymentInMonthlyRow) {
            $columnCounterIn = 'B';
            $amountTotal = '0.00';
            $worksheet->setCellValue("A{$counter}", $paymentInMonthlyRow['name']);
            
            foreach ($yearMonthList as $yearMonth) {
                $amount = isset($paymentInMonthlyRow['amounts'][$yearMonth]) ? $paymentInMonthlyRow['amounts'][$yearMonth] : '0.00';
                $worksheet->setCellValue("{$columnCounterIn}{$counter}", $amount);
                $amountInTotals[$yearMonth] += $amount;
                $amountTotal += $amount;
                $columnCounterIn++;
            }
            
            $worksheet->setCellValue("{$columnCounterIn}{$counter}", $amountTotal);
            $grandTotal += $amountTotal;
            $counter++;
        }
        
        $columnCounterInTotal = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly');
        foreach ($yearMonthList as $yearMonth) {
            $worksheet->setCellValue("{$columnCounterInTotal}{$counter}", $amountInTotals[$yearMonth]);
            $columnCounterInTotal++;
        }
        $worksheet->setCellValue("{$columnCounterInTotal}{$counter}", CHtml::encode($grandTotal));
        
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:{$columnCounterInTotal}{$counter}");
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Transaksi Bank Keluar');
        $counter++;

        $amountOutTotals = array();
        $columnCounterOut = 'B';
        foreach ($yearMonthList as $yearMonth) {
            $worksheet->setCellValue("{$columnCounterOut}6", CHtml::encode($yearMonthNames[$yearMonth]));
            $amountOutTotals[$yearMonth] = '0.00'; 
            $columnCounterOut++;
        }
        $worksheet->setCellValue("{$columnCounterOut}6", 'Total');
        
        $worksheet->getStyle("A{$counter}:{$columnCounterOut}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterOut}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:{$columnCounterOut}{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        $grandTotalOut = '0.00';
        foreach ($paymentOutMonthlyList as $coaId => $paymentOutMonthlyRow) {
            $columnCounterOut = 'B';
            $amountTotal = '0.00';
            $worksheet->setCellValue("A{$counter}", $paymentOutMonthlyRow['name']);
            
            foreach ($yearMonthList as $yearMonth) {
                $amount = isset($paymentOutMonthlyRow['amounts'][$yearMonth]) ? $paymentOutMonthlyRow['amounts'][$yearMonth] : '0.00';
                $worksheet->setCellValue("{$columnCounterOut}{$counter}", $amount);
                $amountOutTotals[$yearMonth] += $amount;
                $amountTotal += $amount;
                $columnCounterOut++;
            }
            
            $worksheet->setCellValue("{$columnCounterOut}{$counter}", $amountTotal);
            $grandTotalOut += $amountTotal;
            $counter++;
        }
        
        $columnCounterOutTotal = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly');
        foreach ($yearMonthList as $yearMonth) {
            $worksheet->setCellValue("{$columnCounterOutTotal}{$counter}", $amountOutTotals[$yearMonth]);
            $columnCounterOutTotal++;
        }
        $worksheet->setCellValue("{$columnCounterOutTotal}{$counter}", CHtml::encode($grandTotalOut));
        
        $worksheet->getStyle("A{$counter}:{$columnCounterOutTotal}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterOutTotal}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:{$columnCounterOutTotal}{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="laporan_bank_multi_bulan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelMonthlyTransactionInfo(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        
        $dataProvider = $options['dataProvider'];
        $month = $options['month'];
        $year = $options['year'];
        $branch = $options['branch'];
        $coa = $options['coa'];
        $inOut = $options['inOut'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Bank Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Bank Bulanan');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->mergeCells('A4:E4');

        $worksheet->getStyle('A1:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E6')->getFont()->setBold(true);

        $transactionInOut = $inOut == 'In' ? 'Masuk' : 'Keluar';
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Transaksi ' . $transactionInOut . ' Bank Bulanan');
        $worksheet->setCellValue('A3', CHtml::value($coa, 'code') . ' - ' . CHtml::value($coa, 'name') . ' - ' . CHtml::value($coa, 'coaCategory.name') . ' - ' . CHtml::value($coa, 'coaSubCategory.name'));
        $worksheet->setCellValue('A4', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));

        $worksheet->getStyle('A6:E6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue("A6", 'Transaksi #');
        $worksheet->setCellValue("B6", 'Tanggal');
        $worksheet->setCellValue("C6", 'Note');
        $worksheet->setCellValue("D6", 'Memo');
        $worksheet->setCellValue("E6", 'Jumlah');
        $worksheet->getStyle('A6:E6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        $totalSum = '0.00';
        foreach ($dataProvider->data as $header) {
            $totalAmount = CHtml::value($header, 'total');
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'kode_transaksi'));
            $worksheet->setCellValue("B{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi)));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'transaction_subject'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'remark'));
            $worksheet->setCellValue("E{$counter}", $totalAmount);
            $totalSum += $totalAmount;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("D{$counter}", 'Total');
        $worksheet->setCellValue("E{$counter}", $totalSum);
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_bank_' . $transactionInOut . '_multi_bulan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}