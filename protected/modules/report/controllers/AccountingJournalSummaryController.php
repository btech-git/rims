<?php

class AccountingJournalSummaryController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('journalSummaryReport')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

//        $dateNow = date('Y-m-d');
//        list($yearNow, , ) = explode('-', $dateNow);
//        $dateStart = $yearNow . '-01-01';

        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $coaCategoryList = (isset($_GET['CoaCategoryList'])) ? $_GET['CoaCategoryList'] : array();
        $coaSubCategoryList = (isset($_GET['CoaSubCategoryList'])) ? $_GET['CoaSubCategoryList'] : array();

        $criteria = new CDbCriteria();
        $criteria->order = 't.code ASC';

        if (!empty($coaCategoryList) && !empty($coaSubCategoryList)) {
            $criteria->addCondition('t.coa_category_id IN (' . implode(',', $coaCategoryList) . ') OR t.id IN (' . implode(',', $coaSubCategoryList) . ')');
            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
        } elseif (!empty($coaCategoryList) && empty($coaSubCategoryList)) {
            $criteria->addCondition('t.coa_category_id IN (' . implode(',', $coaCategoryList) . ')');
            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
        } elseif (empty($coaCategoryList) && !empty($coaSubCategoryList)) {
            $criteria->addCondition('t.id IN (' . implode(',', $coaSubCategoryList) . ')');
            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
        } else {
            $coaSubCategories = CoaSubCategory::model()->findAll(array(
                'condition' => 't.coa_category_id NOT IN (11)', 
                'order' => 't.code ASC'
            ));
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($coaSubCategories , $startDate, $endDate, $branchId, $transactionType);
        }

        $this->render('summary', array(
            'coaSubCategories' => $coaSubCategories,
            'transactionType' => $transactionType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'coaCategoryList' => $coaCategoryList,
            'coaSubCategoryList' => $coaSubCategoryList,
        ));
    }

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $transactionJournalSummary = new AccountingJournalSummary($jurnalUmum->search());
        $transactionJournalSummary->setupLoading();
        $transactionJournalSummary->setupPaging(10000, 1);
        $transactionJournalSummary->setupSorting();
        $transactionJournalSummary->setupFilterTransactionDetail($startDate, $endDate, $coaId, $branchId);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($transactionJournalSummary, $coaId, $startDate, $endDate, $branchId);
        }

        $this->render('jurnalTransaction', array(
            'jurnalUmum' => $jurnalUmum,
            'transactionJournalSummary' => $transactionJournalSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($coaSubCategories, $startDate, $endDate, $branchId, $transactionType) {
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
        $worksheet->setCellValue('A2', 'Laporan Jurnal Umum Rekap');
        $worksheet->setCellValue('A3', 'Periode: ' . $startDateString . ' - ' . $endDateString);

        $worksheet->getStyle("A5:J5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:J5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:J5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Chart of Account');
        $worksheet->setCellValue('B5', 'Debit');
        $worksheet->setCellValue('C5', 'Credit');

        $counter = 6;

        $accountCategoryDebitBalance = 0.00;
        $accountCategoryCreditBalance = 0.00;
        foreach ($coaSubCategories as $coaSubCategory) {
            $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $coaSubCategory->id), array('order' => 't.code ASC'));
            foreach ($coas as $coa) {
                $journalDebitBalance = $coa->getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType);
                $journalCreditBalance = $coa->getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType);
                if ($journalDebitBalance !== 0 || $journalCreditBalance !== 0) { //&& $journalDebitBalance !== $journalCreditBalance) {
                    $worksheet->setCellValue("A{$counter}", $coa->code . ' - ' . $coa->name);
                    if (empty($coa->coaIds)) {
                        $worksheet->setCellValue("B{$counter}", $journalDebitBalance);
                        $worksheet->setCellValue("C{$counter}", $journalCreditBalance);
                    }
                    $counter++;
            
                    $groupDebitBalance = 0;
                    $groupCreditBalance = 0;
                    if (!empty($coa->coaIds)) {
                        $coaIds = Coa::model()->findAllByAttributes(array('coa_id' => $coa->id), array('order' => 't.code ASC'));
                        foreach ($coaIds as $account) {
                            $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType);
                            $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType);
                            if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance) {
                                $worksheet->setCellValue("A{$counter}", $coa->code . ' - ' . $coa->name);
                                if (empty($coa->coaIds)) {
                                    $worksheet->setCellValue("B{$counter}", $journalDebitBalance);
                                    $worksheet->setCellValue("C{$counter}", $journalCreditBalance);
                                }
                                $groupDebitBalance += $journalDebitBalance;
                                $groupCreditBalance += $journalCreditBalance;
                                
                                $counter++;
                                
                            }
                        }
                    }
                }
                $accountCategoryDebitBalance += $journalDebitBalance;
                $accountCategoryCreditBalance += $journalCreditBalance;
            }

            $counter++;
        }
        
        $worksheet->setCellValue("A{$counter}", "Total");
        $worksheet->setCellValue("B{$counter}", $accountCategoryDebitBalance);
        $worksheet->setCellValue("C{$counter}", $accountCategoryCreditBalance);

        for ($col = 'A'; $col !== 'D'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Jurnal Umum Rekap.xls"');
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
