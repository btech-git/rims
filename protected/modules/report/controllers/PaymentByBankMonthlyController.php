<?php

class PaymentByBankMonthlyController extends Controller {

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
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $coaIds = isset($_GET['CoaIds']) ? $_GET['CoaIds'] : array();
        
        $coaList = Coa::model()->findAll(array('condition' => 't.coa_sub_category_id IN (1, 2, 3) AND t.status = "Approved"', 'order' => 't.name ASC'));
        
        $coaInSql = '= NULL';
        if (!empty($coaIds)) {
            $coaInSql = "IN (" . implode(',', $coaIds) . ")";
        }
        $selectedCoas = Coa::model()->findAll(array('condition' => 't.id ' . $coaInSql, 'order' => 't.name ASC'));
        
        $paymentInByBankList = JurnalUmum::getPaymentInByBankList($month, $year, $branchId, $coaIds);
        $paymentOutByBankList = JurnalUmum::getPaymentOutByBankList($month, $year, $branchId, $coaIds);
        
        $coaIdList = array();
        foreach ($coaList as $coa) {
            $coaIdList[] = $coa->id;
        }
        
        $paymentInList = array();
        $lastPaymentInDate = '';
        foreach ($paymentInByBankList as $paymentInByBankRow) {
            if ($lastPaymentInDate !== $paymentInByBankRow['tanggal_transaksi']) {
                $paymentInList[$paymentInByBankRow['tanggal_transaksi']][0] = $paymentInByBankRow['tanggal_transaksi'];
                foreach ($coaIdList as $coaId) {
                    $paymentInList[$paymentInByBankRow['tanggal_transaksi']][$coaId] = '0.00';
                }
            }
            $paymentInList[$paymentInByBankRow['tanggal_transaksi']][$paymentInByBankRow['coa_id']] = $paymentInByBankRow['total_amount'];
            $lastPaymentInDate = $paymentInByBankRow['tanggal_transaksi'];
        }
        
        $paymentOutList = array();
        $lastPaymentOutDate = '';
        foreach ($paymentOutByBankList as $paymentOutByBankRow) {
            if ($lastPaymentOutDate !== $paymentOutByBankRow['tanggal_transaksi']) {
                $paymentOutList[$paymentOutByBankRow['tanggal_transaksi']][0] = $paymentOutByBankRow['tanggal_transaksi'];
                foreach ($coaIdList as $coaId) {
                    $paymentOutList[$paymentOutByBankRow['tanggal_transaksi']][$coaId] = '0.00';
                }
            }
            $paymentOutList[$paymentOutByBankRow['tanggal_transaksi']][$paymentOutByBankRow['coa_id']] = $paymentOutByBankRow['total_amount'];
            $lastPaymentOutDate = $paymentOutByBankRow['tanggal_transaksi'];
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
                'paymentInList' => $paymentInList,
                'paymentOutList' => $paymentOutList,
                'selectedCoas' => $selectedCoas,
                'month' => $month,
                'year' => $year,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'paymentInList' => $paymentInList,
            'paymentOutList' => $paymentOutList,
            'yearList' => $yearList,
            'coaList' => $coaList,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
            'coaIds' => $coaIds,
            'selectedCoas' => $selectedCoas,
        ));
    }
    
    public function actionTransactionInfo($coaId, $debitCredit, $date, $branchId, $inOut) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $page = (isset($_GET['page'])) ? $_GET['page'] : 1;
        
        $dataProvider = JurnalUmum::model()->searchByTransactionInfo($coaId, $debitCredit, $date, $branchId, $page);
        $coa = Coa::model()->findByPk($coaId);
        $branch = Branch::model()->findByPk($branchId);
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelDailyTransactionInfo(array(
                'dataProvider' => $dataProvider,
                'date' => $date,
                'coa' => $coa,
                'branch' => $branch,
                'inOut' => $inOut,
            ));
        }

        $this->render('transactionInfo', array(
            'dataProvider' => $dataProvider,
            'debitCredit' => $debitCredit,
            'date' => $date,
            'coa' => $coa,
            'coaId' => $coaId,
            'branch' => $branch,
            'branchId' => $branchId,
            'inOut' => $inOut,
        ));
    }

    public function actionMonthlyTransactionInfo($coaId, $debitCredit, $year, $month, $branchId, $inOut) {
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

        $this->render('monthlyTransactionInfo', array(
            'dataProvider' => $dataProvider,
            'year' => $year,
            'month' => $month,
            'coa' => $coa,
            'branch' => $branch,
            'coaId' => $coaId,
            'debitCredit' => $debitCredit,
            'year' => $year,
            'month' => $month,
            'branchId' => $branchId,
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

        $paymentInList = $options['paymentInList'];
        $paymentOutList = $options['paymentOutList'];
        $selectedCoas = $options['selectedCoas'];
        $month = $options['month'];
        $year = $options['year'];
        $branchId = $options['branchId'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Bank Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Bank Bulanan');

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Bank Bulanan');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));
        $worksheet->setCellValue('A5', 'Transaksi Bank Masuk');

        $paymentInDailyTotals = array();
        $columnCounterIn = 'B';
        foreach ($selectedCoas as $coa) {
            $worksheet->setCellValue("{$columnCounterIn}6", CHtml::encode(CHtml::value($coa, 'name')));
            $paymentInDailyTotals[$coa->id] = '0.00'; 
            $columnCounterIn++;
        }
        $dailyInTotal = '0.00';
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
        $daysInMonthTransactionIn = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $yearMonth = str_pad($year, 2, '0', STR_PAD_LEFT) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        for ($day = 1; $day <= $daysInMonthTransactionIn; $day++) {
            $columnCounterIn = 'B';
            $date = $yearMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            if (isset($paymentInList[$date])) {
                $paymentInItem = $paymentInList[$date];
                $totalPerDate = '0.00';
                $worksheet->setCellValue("A{$counter}", CHtml::encode($date));
                
                foreach ($selectedCoas as $coa) {
                    $paymentInRetail = $paymentInItem[$coa->id];
                    $worksheet->setCellValue("{$columnCounterIn}{$counter}", CHtml::encode($paymentInRetail));
                    $paymentInDailyTotals[$coa->id] += $paymentInRetail;
                    $totalPerDate += $paymentInRetail;
                    $columnCounterIn++;
                }
                $worksheet->setCellValue("{$columnCounterIn}{$counter}", CHtml::encode($totalPerDate));
                $dailyInTotal += $totalPerDate;
            } else {
                $worksheet->setCellValue("A{$counter}", CHtml::encode($date));
                foreach ($selectedCoas as $coa) {
                    $worksheet->setCellValue("{$columnCounterIn}{$counter}", 0);
                }
                $worksheet->setCellValue("{$columnCounterIn}{$counter}", 0);
                
            }
            
            $counter++;
        }
        
        $columnCounterInTotal = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly');
        foreach ($selectedCoas as $coa) {
            $worksheet->setCellValue("{$columnCounterInTotal}{$counter}", CHtml::encode($paymentInDailyTotals[$coa->id]));
            $columnCounterInTotal++;
        }
        $worksheet->setCellValue("{$columnCounterInTotal}{$counter}", CHtml::encode($dailyInTotal));
        
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:{$columnCounterInTotal}{$counter}");
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterInTotal}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Transaksi Bank Keluar');
        $counter++;

        $paymentOutDailyTotals = array();
        $columnCounterOut = 'B';
        foreach ($selectedCoas as $coa) {
            $worksheet->setCellValue("{$columnCounterOut}{$counter}", CHtml::encode(CHtml::value($coa, 'name')));
            $paymentOutDailyTotals[$coa->id] = '0.00'; 
            $columnCounterOut++;
        }
        $dailyOutTotal = '0.00';
        $worksheet->setCellValue("{$columnCounterOut}{$counter}", 'Total');
        
        $worksheet->getStyle("A{$counter}:{$columnCounterOut}{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:{$columnCounterOut}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:{$columnCounterOut}{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        $daysInMonthTransactionOut = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $yearMonth = str_pad($year, 2, '0', STR_PAD_LEFT) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
        for ($day = 1; $day <= $daysInMonthTransactionOut; $day++) {
            $columnCounterOut = 'B';
            $date = $yearMonth . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
            if (isset($paymentOutList[$date])) {
                $paymentOutItem = $paymentOutList[$date];
                $totalPerDate = '0.00';
                $worksheet->setCellValue("A{$counter}", CHtml::encode($date));
                
                foreach ($selectedCoas as $coa) {
                    $paymentOutRetail = $paymentOutItem[$coa->id];
                    $worksheet->setCellValue("{$columnCounterOut}{$counter}", CHtml::encode($paymentOutRetail));
                    $paymentOutDailyTotals[$coa->id] += $paymentOutRetail;
                    $totalPerDate += $paymentOutRetail;
                    $columnCounterOut++;
                }
                $worksheet->setCellValue("{$columnCounterOut}{$counter}", CHtml::encode($totalPerDate));
                $dailyOutTotal += $totalPerDate;
            } else {
                $worksheet->setCellValue("A{$counter}", CHtml::encode($date));
                foreach ($selectedCoas as $coa) {
                    $worksheet->setCellValue("{$columnCounterOut}{$counter}", 0);
                }
                $worksheet->setCellValue("{$columnCounterOut}{$counter}", 0);
                
            }
            
            $counter++;
        }

        $columnCounterOutTotal = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly');
        foreach ($selectedCoas as $coa) {
            $worksheet->getStyle("{$columnCounterOutTotal}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("{$columnCounterOutTotal}{$counter}", CHtml::encode($paymentOutDailyTotals[$coa->id]));
            $columnCounterOutTotal++;
        }
        $worksheet->setCellValue("{$columnCounterOutTotal}{$counter}", CHtml::encode($dailyOutTotal));
                
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
        header('Content-Disposition: attachment;filename="bank_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelDailyTransactionInfo(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();
        
        $dataProvider = $options['dataProvider'];
        $date = $options['date'];
        $branch = $options['branch'];
        $coa = $options['coa'];
        $inOut = $options['inOut'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Bank Harian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Bank Harian');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->mergeCells('A4:E4');

        $worksheet->getStyle('A1:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E6')->getFont()->setBold(true);

        $transactionInOut = $inOut == 'In' ? 'Masuk' : 'Keluar';
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Transaksi ' . $transactionInOut . ' Bank Harian');
        $worksheet->setCellValue('A3', CHtml::value($coa, 'code') . ' - ' . CHtml::value($coa, 'name') . ' - ' . CHtml::value($coa, 'coaCategory.name') . ' - ' . CHtml::value($coa, 'coaSubCategory.name'));
        $worksheet->setCellValue('A4', CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($date))));

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
        header('Content-Disposition: attachment;filename="transaksi_bank_bulanan.xls"');
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
        header('Content-Disposition: attachment;filename="transaksi_bank_bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}