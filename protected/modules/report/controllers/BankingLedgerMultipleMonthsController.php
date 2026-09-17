<?php

class BankingLedgerMultipleMonthsController extends Controller {

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
        
        $startMonth = isset($_GET['StartMonth']) ? $_GET['StartMonth'] : $monthNow;
        $startYear = isset($_GET['StartYear']) ? $_GET['StartYear'] : $yearNow;
        $endMonth = isset($_GET['EndMonth']) ? $_GET['EndMonth'] : $monthNow;
        $endYear = isset($_GET['EndYear']) ? $_GET['EndYear'] : $yearNow;
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        $coaId = isset($_GET['CoaId']) ? $_GET['CoaId'] : '';
        
        $coaList = Coa::model()->findAll(array('condition' => 't.coa_sub_category_id IN (1, 2, 3) AND t.status = "Approved"', 'order' => 't.name ASC'));
        
        $monthList = array(
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'May',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Aug',
            '09' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        );
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $yearMonths = array();
        $currentMonth = intval($startMonth);
        $currentYear = intval($startYear);
        $currentYearMonth = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
        while ($currentYearMonth <= $endYear . '-' . $endMonth) {
            $yearMonths[] = $currentYearMonth;
            $currentMonth++;
            if ((int) $currentMonth === 13) {
                $currentMonth = 1;
                $currentYear++;
            }
            $currentYearMonth = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
        }
        
        $transactionInDataProviders = array();
        $transactionOutDataProviders = array();
        foreach ($yearMonths as $yearMonth) {
            list($year, $month) = explode('-', $yearMonth);
            $numberOfDays = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
            $startDate = $year . '-' . $month . '-01';
            $endDate = $year . '-' . $month . '-' . $numberOfDays;
            $finalCoaId = empty($coaId) ? 0 : $coaId;
            $transactionInDataProviders[$yearMonth] = JurnalUmum::model()->searchByBankingLedgerInfo($finalCoaId, 'D', $startDate, $endDate, $branchId);
            $transactionOutDataProviders[$yearMonth] = JurnalUmum::model()->searchByBankingLedgerInfo($finalCoaId, 'K', $startDate, $endDate, $branchId);
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionInDataProviders, $transactionOutDataProviders, $yearMonths, $coaId, $monthList);
        }

        $this->render('summary', array(
            'transactionInDataProviders' => $transactionInDataProviders,
            'transactionOutDataProviders' => $transactionOutDataProviders,
            'yearList' => $yearList,
            'monthList' => $monthList,
            'coaList' => $coaList,
            'startMonth' => $startMonth,
            'startYear' => $startYear,
            'endMonth' => $endMonth,
            'endYear' => $endYear,
            'branchId' => $branchId,
            'coaId' => $coaId,
            'yearMonths' => $yearMonths,
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
        } else if ($codeNumberConstant === 'JAD') {
            $model = JournalAdjustmentHeader::model()->findByAttributes(array('transaction_number' => $codeNumber));
            $this->redirect(array('/accounting/journalAdjustment/show', 'id' => $model->id));
        }
    }

    protected function saveToExcel($transactionInDataProviders, $transactionOutDataProviders, $yearMonths, $coaId, $monthList) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Bank Multi Bulan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Bank Masuk');
        
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Rincian Transaksi Bank Multi Bulan');
        $coa = Coa::model()->findByPk($coaId);
        $worksheet->setCellValue('A3', CHtml::value($coa, 'name'));

        $worksheet->mergeCells("A1:E1");
        $worksheet->mergeCells("A2:E2");
        $worksheet->mergeCells("A3:E3");
        
        $worksheet->getStyle("A1:E3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:E3")->getFont()->setBold(true);
        
        $firstColumn = 'A';
        $penultimateColumn = $firstColumn;
        $lastColumn = $firstColumn;
        for ($i = 0; $i < 4; $i++) {
            if ($i === 3) {
                $penultimateColumn = $lastColumn;
            }
            $lastColumn++;
        }
        $currentColumn = $firstColumn;
        foreach ($yearMonths as $yearMonth) {
            list($year, $month) = explode('-', $yearMonth);
            $formattedYearMonth = $monthList[$month] . ' ' . $year;
            
            $worksheet->getStyle("{$firstColumn}5:{$lastColumn}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $worksheet->getStyle("{$firstColumn}5:{$lastColumn}6")->getFont()->setBold(true);
            $worksheet->getStyle("{$firstColumn}5:{$lastColumn}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("{$firstColumn}6:{$lastColumn}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

            $worksheet->mergeCells("{$firstColumn}5:{$lastColumn}5");
            $worksheet->setCellValue("{$firstColumn}5", $formattedYearMonth);
            
            $worksheet->setCellValue("{$currentColumn}6", 'Transaction #');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Tanggal');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Keterangan');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Catatan');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Total');
            
            $currentColumn = $firstColumn;
            
            $currentRow = 7;
            
            $paymentDailyTotal = '0.00';
            $dataProvider = $transactionInDataProviders[$yearMonth];
            foreach ($dataProvider->data as $detail) {
                $totalAmount = CHtml::value($detail, 'total');
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'kode_transaksi'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'tanggal_transaksi'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'transaction_subject'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'remark'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", $totalAmount);
                if ($totalAmount < 0) {
                    $worksheet->getStyle("{$currentColumn}{$currentRow}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
                $currentColumn = $firstColumn;
                $currentRow++;

                $paymentDailyTotal += $totalAmount;
            }
            
            $worksheet->getStyle("{$firstColumn}{$currentRow}:{$lastColumn}{$currentRow}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("{$firstColumn}{$currentRow}:{$lastColumn}{$currentRow}")->getFont()->setBold(true);
            
            $worksheet->setCellValue("{$penultimateColumn}{$currentRow}", 'Total');
            $worksheet->setCellValue("{$lastColumn}{$currentRow}", $paymentDailyTotal);
            if ($paymentDailyTotal < 0) {
                $worksheet->getStyle("{$lastColumn}{$currentRow}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            }
            
            $currentColumn = $lastColumn;
            $currentColumn++;
            $currentColumn++;
            
            $firstColumn = $currentColumn;
            $penultimateColumn = $firstColumn;
            $lastColumn = $firstColumn;
            for ($i = 0; $i < 4; $i++) {
                if ($i === 3) {
                    $penultimateColumn = $lastColumn;
                }
                $lastColumn++;
            }
        }
        
        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }        
        
        $worksheet = $objPHPExcel->createSheet(1);
        $worksheet->setTitle('Transaksi Bank Keluar');

        $worksheet->setCellValue('A1', 'RAPERIND MOTOR');
        $worksheet->setCellValue('A2', 'Rincian Transaksi Bank Multi Bulan');
        $coa = Coa::model()->findByPk($coaId);
        $worksheet->setCellValue('A3', CHtml::value($coa, 'name'));

        $worksheet->mergeCells("A1:E1");
        $worksheet->mergeCells("A2:E2");
        $worksheet->mergeCells("A3:E3");
        
        $worksheet->getStyle("A1:E3")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:E3")->getFont()->setBold(true);
        
        $firstColumn = 'A';
        $penultimateColumn = $firstColumn;
        $lastColumn = $firstColumn;
        for ($i = 0; $i < 4; $i++) {
            if ($i === 3) {
                $penultimateColumn = $lastColumn;
            }
            $lastColumn++;
        }
        $currentColumn = $firstColumn;
        foreach ($yearMonths as $yearMonth) {
            list($year, $month) = explode('-', $yearMonth);
            $formattedYearMonth = $monthList[$month] . ' ' . $year;
            
            $worksheet->getStyle("{$firstColumn}5:{$lastColumn}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $worksheet->getStyle("{$firstColumn}5:{$lastColumn}6")->getFont()->setBold(true);
            $worksheet->getStyle("{$firstColumn}5:{$lastColumn}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("{$firstColumn}6:{$lastColumn}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

            $worksheet->mergeCells("{$firstColumn}5:{$lastColumn}5");
            $worksheet->setCellValue("{$firstColumn}5", $formattedYearMonth);
            
            $worksheet->setCellValue("{$currentColumn}6", 'Transaction #');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Tanggal');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Keterangan');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Catatan');
            $currentColumn++;
            $worksheet->setCellValue("{$currentColumn}6", 'Total');
            
            $currentColumn = $firstColumn;
            
            $currentRow = 7;
            
            $paymentDailyTotal = '0.00';
            $dataProvider = $transactionOutDataProviders[$yearMonth];
            foreach ($dataProvider->data as $detail) {
                $totalAmount = CHtml::value($detail, 'total');
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'kode_transaksi'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'tanggal_transaksi'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'transaction_subject'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", CHtml::value($detail, 'remark'));
                $currentColumn++;
                $worksheet->setCellValue("{$currentColumn}{$currentRow}", $totalAmount);
                if ($totalAmount < 0) {
                    $worksheet->getStyle("{$currentColumn}{$currentRow}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
                $currentColumn = $firstColumn;
                $currentRow++;

                $paymentDailyTotal += $totalAmount;
            }
            
            $worksheet->getStyle("{$firstColumn}{$currentRow}:{$lastColumn}{$currentRow}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("{$firstColumn}{$currentRow}:{$lastColumn}{$currentRow}")->getFont()->setBold(true);
            
            $worksheet->setCellValue("{$penultimateColumn}{$currentRow}", 'Total');
            $worksheet->setCellValue("{$lastColumn}{$currentRow}", $paymentDailyTotal);
            if ($paymentDailyTotal < 0) {
                $worksheet->getStyle("{$lastColumn}{$currentRow}")->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            }
            
            $currentColumn = $lastColumn;
            $currentColumn++;
            $currentColumn++;
            
            $firstColumn = $currentColumn;
            $penultimateColumn = $firstColumn;
            $lastColumn = $firstColumn;
            for ($i = 0; $i < 4; $i++) {
                if ($i === 3) {
                    $penultimateColumn = $lastColumn;
                }
                $lastColumn++;
            }
        }
        
        for ($col = 'A'; $col !== 'AZ'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        $objPHPExcel->setActiveSheetIndex(0);
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="transaksi_bank_multi_bulan.xls"');
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
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Transaksi ' . $transactionInOut . ' Bank Harian');
        $worksheet->setCellValue('A3', CHtml::value($coa, 'code') . ' - ' . CHtml::value($coa, 'name') . ' - ' . CHtml::value($coa, 'coaCategory.name') . ' - ' . CHtml::value($coa, 'coaSubCategory.name'));
        $worksheet->setCellValue('A4', Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($date)));

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
        header('Content-Disposition: attachment;filename="transaksi_bank_' . $transactionInOut . '_harian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
//    protected function saveToExcelMonthlyTransactionInfo(array $options = array()) {
//        set_time_limit(0);
//        ini_set('memory_limit', '1024M');
//
//        spl_autoload_unregister(array('YiiBase', 'autoload'));
//        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
//        spl_autoload_register(array('YiiBase', 'autoload'));
//
//        $objPHPExcel = new PHPExcel();
//        
//        $dataProvider = $options['dataProvider'];
//        $month = $options['month'];
//        $year = $options['year'];
//        $branch = $options['branch'];
//        $coa = $options['coa'];
//        $inOut = $options['inOut'];
//        
//        $documentProperties = $objPHPExcel->getProperties();
//        $documentProperties->setCreator('Raperind Motor');
//        $documentProperties->setTitle('Transaksi Bank Bulanan');
//
//        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
//        $worksheet->setTitle('Transaksi Bank Bulanan');
//
//        $worksheet->mergeCells('A1:E1');
//        $worksheet->mergeCells('A2:E2');
//        $worksheet->mergeCells('A3:E3');
//        $worksheet->mergeCells('A4:E4');
//
//        $worksheet->getStyle('A1:E6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//        $worksheet->getStyle('A1:E6')->getFont()->setBold(true);
//
//        $transactionInOut = $inOut == 'In' ? 'Masuk' : 'Keluar';
//        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::value($branch, 'name')));
//        $worksheet->setCellValue('A2', 'Transaksi ' . $transactionInOut . ' Bank Bulanan');
//        $worksheet->setCellValue('A3', CHtml::value($coa, 'code') . ' - ' . CHtml::value($coa, 'name') . ' - ' . CHtml::value($coa, 'coaCategory.name') . ' - ' . CHtml::value($coa, 'coaSubCategory.name'));
//        $worksheet->setCellValue('A4', strftime("%B",mktime(0,0,0,$month))) . ' ' . $year));
//
//        $worksheet->getStyle('A6:E6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $worksheet->setCellValue("A6", 'Transaksi #');
//        $worksheet->setCellValue("B6", 'Tanggal');
//        $worksheet->setCellValue("C6", 'Note');
//        $worksheet->setCellValue("D6", 'Memo');
//        $worksheet->setCellValue("E6", 'Jumlah');
//        $worksheet->getStyle('A6:E6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//
//        $counter = 7;
//        $totalSum = '0.00';
//        foreach ($dataProvider->data as $header) {
//            $totalAmount = CHtml::value($header, 'total');
//            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'kode_transaksi'));
//            $worksheet->setCellValue("B{$counter}", Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($header->tanggal_transaksi)));
//            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'transaction_subject'));
//            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'remark'));
//            $worksheet->setCellValue("E{$counter}", $totalAmount);
//            $totalSum += $totalAmount;
//
//            $counter++;
//        }
//        
//        $worksheet->getStyle("A{$counter}:E{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
//        $worksheet->getStyle("A{$counter}:E{$counter}")->getFont()->setBold(true);
//        $worksheet->setCellValue("D{$counter}", 'Total');
//        $worksheet->setCellValue("E{$counter}", $totalSum);
//        
//        for ($col = 'A'; $col !== 'Z'; $col++) {
//            $objPHPExcel->getActiveSheet()
//            ->getColumnDimension($col)
//            ->setAutoSize(true);
//        }
//        
//        ob_end_clean();
//
//        header('Content-type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename="transaksi_bank_bulanan.xls"');
//        header('Cache-Control: max-age=0');
//
//        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save('php://output');
//
//        Yii::app()->end();
//    }
}