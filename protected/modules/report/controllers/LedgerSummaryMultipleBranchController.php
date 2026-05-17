<?php

class LedgerSummaryMultipleBranchController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $coaCategoryList = (isset($_GET['CoaCategoryList'])) ? $_GET['CoaCategoryList'] : array();
        $coaSubCategoryList = (isset($_GET['CoaSubCategoryList'])) ? $_GET['CoaSubCategoryList'] : array();

        $ledgerSummaryMultipleBranchReport = JurnalUmum::getLedgerSummaryMultipleBranchReport($startDate, $endDate, $coaCategoryList, $coaSubCategoryList);
        
        $ledgerSummaryMultipleBranchReportData = array();
        foreach ($ledgerSummaryMultipleBranchReport as $ledgerSummaryMultipleBranchReportItem) {
            $ledgerSummaryMultipleBranchReportData[$ledgerSummaryMultipleBranchReportItem['coa_id']]['id'] = $ledgerSummaryMultipleBranchReportItem['coa_id'];
            $ledgerSummaryMultipleBranchReportData[$ledgerSummaryMultipleBranchReportItem['coa_id']]['code'] = $ledgerSummaryMultipleBranchReportItem['coa_code'];
            $ledgerSummaryMultipleBranchReportData[$ledgerSummaryMultipleBranchReportItem['coa_id']]['name'] = $ledgerSummaryMultipleBranchReportItem['coa_name'];
            $ledgerSummaryMultipleBranchReportData[$ledgerSummaryMultipleBranchReportItem['coa_id']]['amounts'][$ledgerSummaryMultipleBranchReportItem['branch_id']]['debit'] = $ledgerSummaryMultipleBranchReportItem['debit'];
            $ledgerSummaryMultipleBranchReportData[$ledgerSummaryMultipleBranchReportItem['coa_id']]['amounts'][$ledgerSummaryMultipleBranchReportItem['branch_id']]['credit'] = $ledgerSummaryMultipleBranchReportItem['credit'];
        }
        
        $branches = Branch::model()->findAllByAttributes(array('status' => 'Active'));
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($ledgerSummaryMultipleBranchReportData , $startDate, $endDate, $branches);
        }

        $this->render('summary', array(
            'ledgerSummaryMultipleBranchReportData' => $ledgerSummaryMultipleBranchReportData,
            'branches' => $branches,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaCategoryList' => $coaCategoryList,
            'coaSubCategoryList' => $coaSubCategoryList,
        ));
    }

    public function actionJournalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $debetKredit = (isset($_GET['DebetKredit'])) ? $_GET['DebetKredit'] : '';

        $jurnalUmums = JurnalUmum::model()->findAll(array(
            'condition' => 'coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND branch_id = :branch_id AND debet_kredit = :debet_kredit',
            'params' => array(
                ':coa_id' => $coaId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':branch_id' => $branchId,
                ':debet_kredit' => $debetKredit,
            )
        ));
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($startDate, $endDate, $coaId, $branchId, $debetKredit);
        }

        $this->render('journalTransaction', array(
            'jurnalUmums' => $jurnalUmums,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
            'debetKredit' => $debetKredit,
        ));
    }

    protected function saveToExcel($ledgerSummaryMultipleBranchReportData, $startDate, $endDate, $branches) {
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
        $documentProperties->setTitle('Ringkasan Buku Besar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Ringkasan Buku Besar');

        $worksheet->setCellValue('A1', 'Raperind Motor');
        $worksheet->setCellValue('A2', 'Ringkasan Buku Besar Semua Cabang');
        $worksheet->setCellValue('A3', 'Periode: ' . $startDateString . ' - ' . $endDateString);

        $columnBranchHeaderStart = 'C';
        $columnBranchHeaderEnd = 'D';
        foreach ($branches as $branch) {
            $worksheet->mergeCells("{$columnBranchHeaderStart}5:{$columnBranchHeaderEnd}5");
            $worksheet->setCellValue("{$columnBranchHeaderStart}5", CHtml::value($branch, 'code'));
            $columnBranchHeaderStart++;$columnBranchHeaderStart++;$columnBranchHeaderEnd++;$columnBranchHeaderEnd++;
        }
        $worksheet->setCellValue('A6', 'COA Code');
        $worksheet->setCellValue('B6', 'COA Name');
        $columnDebitHeader = 'C';
        $columnCreditHeader = 'D';
        foreach ($branches as $branch) {
            $worksheet->setCellValue("{$columnDebitHeader}6", 'Debit');
            $worksheet->setCellValue("{$columnCreditHeader}6", 'Credit');
            $columnDebitHeader++;$columnDebitHeader++;$columnCreditHeader++;$columnCreditHeader++;
        }

        $worksheet->mergeCells("A1:{$columnCreditHeader}1");
        $worksheet->mergeCells("A2:{$columnCreditHeader}2");
        $worksheet->mergeCells("A3:{$columnCreditHeader}3");
        
        $worksheet->getStyle("A1:{$columnCreditHeader}6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle("A1:{$columnCreditHeader}6")->getFont()->setBold(true);
        $worksheet->getStyle("A5:{$columnCreditHeader}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A6:{$columnCreditHeader}6")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;

        $debitSums = array();
        $creditSums = array();
        
        foreach ($ledgerSummaryMultipleBranchReportData as $ledgerSummaryMultipleBranchReportDataItem) {
            $worksheet->setCellValue("A{$counter}", $ledgerSummaryMultipleBranchReportDataItem['code']);
            $worksheet->setCellValue("B{$counter}", $ledgerSummaryMultipleBranchReportDataItem['name']);
            $columnDebitBody = 'C';
            $columnCreditBody = 'D';
            foreach ($branches as $branch) {
                $debit = isset($ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['debit']) ? $ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['debit'] : '0.00';
                $credit = isset($ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['credit']) ? $ledgerSummaryMultipleBranchReportDataItem['amounts'][$branch->id]['credit'] : '0.00';
                $worksheet->setCellValue("{$columnDebitBody}{$counter}", $debit);
                $worksheet->setCellValue("{$columnCreditBody}{$counter}", $credit);
                $columnDebitBody++;$columnDebitBody++;$columnCreditBody++;$columnCreditBody++;
                
                if (!isset($debitSums[$branch->id])) {
                    $debitSums[$branch->id] = '0.00';
                }
                if (!isset($creditSums[$branch->id])) {
                    $creditSums[$branch->id] = '0.00';
                }
                $debitSums[$branch->id] += $debit;
                $creditSums[$branch->id] += $credit;
            }
            
            $counter++;
        }
        
//        $worksheet->setCellValue("B{$counter}", 'TOTAL');
//        $columnDebitFooter = 'C';
//        $columnCreditFooter = 'D';
//        foreach ($branches as $branch) {
//            $debitSums = isset($debitSums[$branch->id]) ? $debitSums[$branch->id] : '0.00';
//            $creditSums = isset($creditSums[$branch->id]) ? $creditSums[$branch->id] : '0.00';
//            $worksheet->setCellValue("{$columnDebitFooter}{$counter}", $debitSums);
//            $worksheet->setCellValue("{$columnCreditFooter}{$counter}", $creditSums);
//            $columnDebitFooter++;$columnDebitFooter++;$columnCreditFooter++;$columnCreditFooter++;
//        }
//        
//        $worksheet->getStyle("A{$counter}:{$columnCreditFooter}{$counter}")->getFont()->setBold(true);
//        $worksheet->getStyle("A{$counter}:{$columnCreditFooter}{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="ringkasan_buku_besar_semua_cabang.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($startDate, $endDate, $coaId, $branchId, $debetKredit) {
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
        $documentProperties->setTitle('Journal Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Journal Transaction');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        
        $worksheet->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G5')->getFont()->setBold(true);

        $coa = Coa::model()->findByPk($coaId);
        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'code'));
        $worksheet->setCellValue('A2', 'Journal Transaction Detail ' . CHtml::encode(CHtml::value($coa, 'codeName')));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
        
        $worksheet->getStyle("A5:G5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Transaksi #');
        $worksheet->setCellValue('C5', 'Tanggal');
        $worksheet->setCellValue('D5', 'Description');
        $worksheet->setCellValue('E5', 'Memo');
        $worksheet->setCellValue('F5', 'Debet');
        $worksheet->setCellValue('G5', 'Kredit');
        
        $worksheet->getStyle("A5:G5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter = 6;

        $totalDebit = '0.00';
        $totalCredit = '0.00';
        $jurnalUmums = JurnalUmum::model()->findAll(array(
            'condition' => 'coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND branch_id = :branch_id AND debet_kredit = :debet_kredit',
            'params' => array(
                ':coa_id' => $coaId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':branch_id' => $branchId,
                ':debet_kredit' => $debetKredit,
            )
        ));
        
        foreach ($jurnalUmums as $i => $header) {
            $debitAmount = $header->debet_kredit == "D" ? CHtml::value($header, 'total') : 0;
            $creditAmount = $header->debet_kredit == "K" ? CHtml::value($header, 'total') : 0;
            
            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'kode_transaksi'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'tanggal_transaksi'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'transaction_subject'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'remark'));
            $worksheet->setCellValue("F{$counter}", $debitAmount);
            $worksheet->setCellValue("G{$counter}", $creditAmount);

            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount;
            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        
        $worksheet->setCellValue("E{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $totalDebit);
        $worksheet->setCellValue("G{$counter}", $totalCredit);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="jurnal_transaksi_ringkasan_buku_besar_cabang.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
