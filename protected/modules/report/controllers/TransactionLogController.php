<?php

class TransactionLogController extends Controller {

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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        
        $transactionLog = Search::bind(new TransactionLog('search'), isset($_GET['TransactionLog']) ? $_GET['TransactionLog'] : array());
        $transactionLogDataProvider = $transactionLog->search();
        $transactionLogDataProvider->criteria->addCondition("transaction_date BETWEEN :start_date AND :end_date");
        $transactionLogDataProvider->criteria->params[':start_date'] = $startDate;
        $transactionLogDataProvider->criteria->params[':end_date'] = $endDate;
        $transactionLogDataProvider->pagination->pageSize = 50;
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        $this->render('summary', array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionLog' => $transactionLog,
            'transactionLogDataProvider' => $transactionLogDataProvider,
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
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A2', 'Laporan Jurnal Umum Rekap ' . $transactionTypeLiteral);
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
            $valid = $valid || $transactionType === 'RCI' && (
                preg_match('/^134.+$/', $transactionJournalItem['coa_code']) === 1 ||
                preg_match('/^132.+$/', $transactionJournalItem['coa_code']) === 1
            );
            $valid = $valid || $transactionType === 'DO';
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

                $counter++;
            }
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
