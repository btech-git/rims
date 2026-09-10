<?php

class BankingLedgerMonthlyController extends Controller {

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
        $coaIds = isset($_GET['CoaIds']) ? $_GET['CoaIds'] : array();
        
        $coaList = Coa::model()->findAll(array('condition' => 't.coa_sub_category_id IN (1, 2, 3) AND t.status = "Approved"', 'order' => 't.name ASC'));
        
        $coaInSql = '= NULL';
        if (!empty($coaIds)) {
            $coaInSql = "IN (" . implode(',', $coaIds) . ")";
        }
        $selectedCoas = Coa::model()->findAll(array('condition' => 't.id ' . $coaInSql, 'order' => 't.name ASC'));
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        $startDate = $year . '-' . $month . '-01';
        $endDate = $year . '-' . $month . '-' . $numberOfDays;
        
        $transactionInDataProviders = array();
        $transactionOutDataProviders = array();
        foreach ($selectedCoas as $selectedCoa) {
            $transactionInDataProviders[$selectedCoa->id] = JurnalUmum::model()->searchByBankingLedgerInfo($selectedCoa->id, 'D', $startDate, $endDate, $branchId);
            $transactionOutDataProviders[$selectedCoa->id] = JurnalUmum::model()->searchByBankingLedgerInfo($selectedCoa->id, 'K', $startDate, $endDate, $branchId);
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($selectedCoas, $transactionInDataProviders, $transactionOutDataProviders, $month, $year, $branchId);
        }

        $this->render('summary', array(
            'transactionInDataProviders' => $transactionInDataProviders,
            'transactionOutDataProviders' => $transactionOutDataProviders,
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

    protected function saveToExcel($selectedCoas, $transactionInDataProviders, $transactionOutDataProviders, $month, $year, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Transaksi Bulanan Multi Bank');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Transaksi Bulanan Multi Bank');

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Rincian Transaksi Bulanan Multi Bank');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));

//        $columnCounterCoaIn = 'A';
//        $columnCounterLabelIn = 'A';
//        foreach ($selectedCoas as $coa) {
//            $worksheet->mergeCells("{$columnCounterCoaIn}6:E6");
//            $columnCounterCoaIn = $columnCounterLabelIn; $columnCounterCoaIn++;
//            $columnCounterLabelIn++;
//        }
//        
        $worksheet->mergeCells("A1:F1");
        $worksheet->mergeCells("A2:F2");
        $worksheet->mergeCells("A3:F3");
        $worksheet->mergeCells("A5:F5");

        $worksheet->getStyle("A1:F6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:F6")->getFont()->setBold(true);
        $worksheet->getStyle("A5:F5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:F6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Transaksi Bank Masuk');
        $worksheet->setCellValue("A6", 'Bank');
        $worksheet->setCellValue("B6", 'Transaction #');
        $worksheet->setCellValue("C6", 'Tanggal');
        $worksheet->setCellValue("D6", 'Keterangan');
        $worksheet->setCellValue("E6", 'Catatan');
        $worksheet->setCellValue("F6", 'Total');
        
        $counter = 7;
        foreach ($selectedCoas as $coa) {
            $paymentDailyTotal = '0.00';
            $dataProvider = $transactionInDataProviders[$coa->id];
            foreach ($dataProvider->data as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($coa, 'name'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($detail, 'kode_transaksi'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($detail, 'tanggal_transaksi'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($detail, 'transaction_subject'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($detail, 'remark'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($detail, 'total'));
                $counter++;

                $paymentDailyTotal += CHtml::value($detail, 'total');
            }
            
            $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
            
            $worksheet->setCellValue("E{$counter}", 'Total Monthly');
            $worksheet->setCellValue("F{$counter}", $paymentDailyTotal);
            $counter++; $counter++;
        }
        $counter++; $counter++;
        
        $worksheet->mergeCells("A{$counter}:F{$counter}");
        $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue("A{$counter}", 'Transaksi Bank Keluar');
        $counter++;
        $worksheet->setCellValue("A{$counter}", 'Bank');
        $worksheet->setCellValue("B{$counter}", 'Transaction #');
        $worksheet->setCellValue("C{$counter}", 'Tanggal');
        $worksheet->setCellValue("D{$counter}", 'Keterangan');
        $worksheet->setCellValue("E{$counter}", 'Catatan');
        $worksheet->setCellValue("F{$counter}", 'Total');
        
        $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
        $counter++;
        
        foreach ($selectedCoas as $coa) {
            $paymentDailyTotal = '0.00';
            $dataProvider = $transactionOutDataProviders[$coa->id];
            foreach ($dataProvider->data as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($coa, 'name'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($detail, 'kode_transaksi'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($detail, 'tanggal_transaksi'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($detail, 'transaction_subject'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($detail, 'remark'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($detail, 'total'));
                $counter++;

                $paymentDailyTotal += CHtml::value($detail, 'total');
            }
            
            $worksheet->getStyle("A{$counter}:F{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:F{$counter}")->getFont()->setBold(true);
            
            $worksheet->setCellValue("E{$counter}", 'Total Monthly');
            $worksheet->setCellValue("F{$counter}", $paymentDailyTotal);
            $counter++; $counter++;
        }
        
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
//        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
//        $worksheet->setCellValue('A2', 'Transaksi ' . $transactionInOut . ' Bank Bulanan');
//        $worksheet->setCellValue('A3', CHtml::value($coa, 'code') . ' - ' . CHtml::value($coa, 'name') . ' - ' . CHtml::value($coa, 'coaCategory.name') . ' - ' . CHtml::value($coa, 'coaSubCategory.name'));
//        $worksheet->setCellValue('A4', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));
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