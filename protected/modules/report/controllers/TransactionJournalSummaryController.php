<?php

class TransactionJournalSummaryController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('journalSummaryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummaryPurchase() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'PO';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Pembelian';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryPurchase', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryPaymentOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'Pout';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Pelunasan Pembelian';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryPaymentOut', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummarySale() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'Invoice';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Penjualan';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summarySale', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryPaymentIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'Pin';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Penerimaan Penjualan';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryPaymentIn', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryMovementIn() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'MI';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Pemasukan Cabang - Barang';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryMovementIn', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryMovementOut() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'MO';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Pengeluaran Cabang - Barang';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryMovementOut', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryCash() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'CASH';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Kas';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryCash', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryWorkOrderExpense() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'WOE';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Sub Pekerjaan Luar';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryWorkOrderExpense', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

    public function actionSummaryMovementOutMaterial() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $transactionType = 'MOM';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionJournalData = JurnalUmum::getTransactionJournalData($startDate, $endDate, $branchId, $transactionType);
        $transactionTypeLiteral = 'Material';
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($transactionJournalData , $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral);
        }

        $this->render('summaryMovementOutMaterial', array(
            'transactionType' => $transactionType,
            'transactionTypeLiteral' => $transactionTypeLiteral,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'transactionJournalData' => $transactionJournalData,
        ));
    }

//    public function actionSummary() {
//        set_time_limit(0);
//        ini_set('memory_limit', '1024M');
//
////        $dateNow = date('Y-m-d');
////        list($yearNow, , ) = explode('-', $dateNow);
////        $dateStart = $yearNow . '-01-01';
//
//        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
//        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
//        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
//        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
//        $coaCategoryList = (isset($_GET['CoaCategoryList'])) ? $_GET['CoaCategoryList'] : array();
//        $coaSubCategoryList = (isset($_GET['CoaSubCategoryList'])) ? $_GET['CoaSubCategoryList'] : array();
//
//        $criteria = new CDbCriteria();
//        $criteria->order = 't.code ASC';
//
//        if (!empty($coaCategoryList) && !empty($coaSubCategoryList)) {
//            $criteria->addCondition('t.coa_category_id IN (' . implode(',', $coaCategoryList) . ') OR t.id IN (' . implode(',', $coaSubCategoryList) . ')');
//            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
//        } elseif (!empty($coaCategoryList) && empty($coaSubCategoryList)) {
//            $criteria->addCondition('t.coa_category_id IN (' . implode(',', $coaCategoryList) . ')');
//            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
//        } elseif (empty($coaCategoryList) && !empty($coaSubCategoryList)) {
//            $criteria->addCondition('t.id IN (' . implode(',', $coaSubCategoryList) . ')');
//            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
//        } else {
//            $coaSubCategories = CoaSubCategory::model()->findAll(array(
//                'condition' => 't.coa_category_id NOT IN (11, 12, 13, 22, 1, 3)', 
//                'order' => 't.code ASC'
//            ));
//        }
//        
//        if (isset($_GET['ResetFilter'])) {
//            $this->redirect(array('summary'));
//        }
//        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($coaSubCategories , $startDate, $endDate, $branchId, $transactionType);
//        }
//
//        $this->render('summary', array(
//            'coaSubCategories' => $coaSubCategories,
//            'transactionType' => $transactionType,
//            'startDate' => $startDate,
//            'endDate' => $endDate,
//            'branchId' => $branchId,
//            'coaCategoryList' => $coaCategoryList,
//            'coaSubCategoryList' => $coaSubCategoryList,
//        ));
//    }

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';

        $transactionJournalSummary = new TransactionJournalSummary($jurnalUmum->search());
        $transactionJournalSummary->setupLoading();
        $transactionJournalSummary->setupPaging(10000, 1);
        $transactionJournalSummary->setupSorting();
        $transactionJournalSummary->setupFilterTransactionDetail($startDate, $endDate, $coaId, $branchId, $transactionType);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($transactionJournalSummary, $coaId, $startDate, $endDate);
        }

        $this->render('jurnalTransaction', array(
            'jurnalUmum' => $jurnalUmum,
            'transactionJournalSummary' => $transactionJournalSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
            'transactionType' => $transactionType,
        ));
    }

    protected function saveToExcel($transactionJournalData, $startDate, $endDate, $branchId, $transactionType, $transactionTypeLiteral) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Jurnal Umum Rekap');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Jurnal Umum Rekap');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A2', 'Laporan Jurnal Umum Rekap' . $transactionTypeLiteral);
        $worksheet->setCellValue('A3', 'Periode: ' . $startDateString . ' - ' . $endDateString);

        $worksheet->getStyle("A5:J5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:J5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:J5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Kode COA');
        $worksheet->setCellValue('B5', 'Nama COA');
        $worksheet->setCellValue('C5', 'Debit');
        $worksheet->setCellValue('D5', 'Credit');

        $counter = 6;

        $totalDebit = '0.00';
        $totalCredit = '0.00';
        foreach ($transactionJournalData as $transactionJournalItem) {
            $valid = false;
            $valid = $valid || $transactionType === 'PO';
            $valid = $valid || $transactionType === 'Pout';
            $valid = $valid || $transactionType === 'Invoice' && (
                $transactionJournalItem['coa_code'] === '224.00.001' ||
                preg_match('/^121\.00.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^411.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^412.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^421.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^422.+$/', $transactionJournalItem['coa_code']) === 1
            );
            $valid = $valid || $transactionType === 'Pin';
            $valid = $valid || $transactionType === 'MI' && (
                preg_match('/^131.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^132.+$/', $transactionJournalItem['coa_code']) === 1
            );
            $valid = $valid || $transactionType === 'MO' && (
                preg_match('/^131.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^132.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^134.+$/', $transactionJournalItem['coa_code']) === 1
            );
            $valid = $valid || $transactionType === 'CASH';
            $valid = $valid || $transactionType === 'WOE' && (
                $transactionJournalItem['coa_code'] === '502.00.001' ||
                preg_match('/^211\.00.+$/', $transactionJournalItem['coa_code']) === 1
            );
            $valid = $valid || $transactionType === 'MOM' && (
                preg_match('/^131\.07.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^132\.07.+$/', $transactionJournalItem['coa_code']) === 1
            );
            if ($valid){
                $worksheet->setCellValue("A{$counter}", CHtml::encode($transactionJournalItem['coa_code']));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($transactionJournalItem['coa_name']));
                $worksheet->setCellValue("C{$counter}", CHtml::encode($transactionJournalItem['debit']));
                $worksheet->setCellValue("D{$counter}", CHtml::encode($transactionJournalItem['credit']));
                $totalDebit += $transactionJournalItem['debit'];
                $totalCredit += $transactionJournalItem['credit'];
            }

            $counter++;
        }
        
        $worksheet->setCellValue("B{$counter}", "Total");
        $worksheet->setCellValue("C{$counter}", $totalDebit);
        $worksheet->setCellValue("D{$counter}", $totalCredit);

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Jurnal Umum Rekap ' . $transactionTypeLiteral . '.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($transactionJournalSummary, $coaId, $startDate, $endDate) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Journal Detail Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Journal Detail Transaction');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');
        $worksheet->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);

        $coa = Coa::model()->findByPk($coaId);
        $worksheet->setCellValue('A1', 'Journal Detail Transaction');
        $worksheet->setCellValue('A2', CHtml::encode(CHtml::value($coa, 'codeName')));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
        
        $worksheet->setCellValue('A5', 'Transaksi #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Description');
        $worksheet->setCellValue('D5', 'Memo');
        $worksheet->setCellValue('E5', 'Debet');
        $worksheet->setCellValue('F5', 'Kredit');
        $counter = 7;

        $totalDebit = '0.00';
        $totalCredit = '0.00';
        foreach ($transactionJournalSummary->dataProvider->data as $header) {
            $debitAmount = $header->debet_kredit == "D" ? CHtml::encode(CHtml::value($header, 'total')) : 0;
            $creditAmount = $header->debet_kredit == "K" ? CHtml::encode(CHtml::value($header, 'total')) : 0;
            
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'kode_transaksi')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'tanggal_transaksi')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transaction_subject')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'remark')));
            $worksheet->setCellValue("E{$counter}", $debitAmount);
            $worksheet->setCellValue("F{$counter}", $creditAmount);

            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount;
            $counter++;
        }
        
        $worksheet->setCellValue("D{$counter}", 'TOTAL');
        $worksheet->setCellValue("E{$counter}", $totalDebit);
        $worksheet->setCellValue("F{$counter}", $totalCredit);

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Journal Detail Transaction.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
