<?php

class LedgerSummaryMultipleCompanyController extends Controller {

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

        $ledgerSummaryMultipleCompanyReport = JurnalUmum::getLedgerSummaryMultipleCompanyReport($startDate, $endDate, $coaCategoryList, $coaSubCategoryList);
        
        $ledgerSummaryMultipleCompanyReportData = array();
        foreach ($ledgerSummaryMultipleCompanyReport as $ledgerSummaryMultipleCompanyReportItem) {
            $ledgerSummaryMultipleCompanyReportData[$ledgerSummaryMultipleCompanyReportItem['coa_id']]['id'] = $ledgerSummaryMultipleCompanyReportItem['coa_id'];
            $ledgerSummaryMultipleCompanyReportData[$ledgerSummaryMultipleCompanyReportItem['coa_id']]['code'] = $ledgerSummaryMultipleCompanyReportItem['coa_code'];
            $ledgerSummaryMultipleCompanyReportData[$ledgerSummaryMultipleCompanyReportItem['coa_id']]['name'] = $ledgerSummaryMultipleCompanyReportItem['coa_name'];
            $ledgerSummaryMultipleCompanyReportData[$ledgerSummaryMultipleCompanyReportItem['coa_id']]['amounts'][$ledgerSummaryMultipleCompanyReportItem['company_id']]['debit'] = $ledgerSummaryMultipleCompanyReportItem['debit'];
            $ledgerSummaryMultipleCompanyReportData[$ledgerSummaryMultipleCompanyReportItem['coa_id']]['amounts'][$ledgerSummaryMultipleCompanyReportItem['company_id']]['credit'] = $ledgerSummaryMultipleCompanyReportItem['credit'];
        }
        
        $companies = Company::model()->findAllByAttributes(array('is_deleted' => 0));
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($ledgerSummaryMultipleCompanyReportData , $startDate, $endDate, $companies);
        }

        $this->render('summary', array(
            'ledgerSummaryMultipleCompanyReportData' => $ledgerSummaryMultipleCompanyReportData,
            'companies' => $companies,
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
        $companyId = (isset($_GET['CompanyId'])) ? $_GET['CompanyId'] : '';
        $debetKredit = (isset($_GET['DebetKredit'])) ? $_GET['DebetKredit'] : '';

        $jurnalUmums = JurnalUmum::model()->findAll(array(
            'condition' => "coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND branch_id IN (
                SELECT id FROM " . Branch::model()->tableName() . " WHERE company_id = " . $companyId . "
            ) AND debet_kredit = :debet_kredit",
            'params' => array(
                ':coa_id' => $coaId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':debet_kredit' => $debetKredit,
            )
        ));
        
        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($coaId, $startDate, $endDate, $companyId, $debetKredit);
        }

        $this->render('journalTransaction', array(
            'jurnalUmums' => $jurnalUmums,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'companyId' => $companyId,
            'debetKredit' => $debetKredit,
        ));
    }

    protected function saveToExcel($ledgerSummaryMultipleCompanyReportData , $startDate, $endDate, $companies) {
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
        $worksheet->setCellValue('A2', 'Ringkasan Buku Besar Semua PT');
        $worksheet->setCellValue('A3', 'Periode: ' . $startDateString . ' - ' . $endDateString);

        $columnCompanyHeaderStart = 'C';
        $columnCompanyHeaderEnd = 'D';
        foreach ($companies as $company) {
            $worksheet->mergeCells("{$columnCompanyHeaderStart}5:{$columnCompanyHeaderEnd}5");
            $worksheet->setCellValue("{$columnCompanyHeaderStart}5", CHtml::value($company, 'code'));
            $columnCompanyHeaderStart++;$columnCompanyHeaderStart++;$columnCompanyHeaderEnd++;$columnCompanyHeaderEnd++;
        }
        $worksheet->setCellValue('A6', 'COA Code');
        $worksheet->setCellValue('B6', 'COA Name');
        $columnDebitHeader = 'C';
        $columnCreditHeader = 'D';
        foreach ($companies as $company) {
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
        
        foreach ($ledgerSummaryMultipleCompanyReportData as $ledgerSummaryMultipleCompanyReportDataItem) {
            $worksheet->setCellValue("A{$counter}", $ledgerSummaryMultipleCompanyReportDataItem['code']);
            $worksheet->setCellValue("B{$counter}", $ledgerSummaryMultipleCompanyReportDataItem['name']);
            $columnDebitBody = 'C';
            $columnCreditBody = 'D';
            foreach ($companies as $company) {
                $debit = isset($ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['debit']) ? $ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['debit'] : '0.00';
                $credit = isset($ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['credit']) ? $ledgerSummaryMultipleCompanyReportDataItem['amounts'][$company->id]['credit'] : '0.00';
                $worksheet->setCellValue("{$columnDebitBody}{$counter}", $debit);
                $worksheet->setCellValue("{$columnCreditBody}{$counter}", $credit);
                $columnDebitBody++;$columnDebitBody++;$columnCreditBody++;$columnCreditBody++;
                
                if (!isset($debitSums[$company->id])) {
                    $debitSums[$company->id] = '0.00';
                }
                if (!isset($creditSums[$company->id])) {
                    $creditSums[$company->id] = '0.00';
                }
                $debitSums[$company->id] += $debit;
                $creditSums[$company->id] += $credit;
            }
            
            $counter++;
        }
        
//        $worksheet->setCellValue("B{$counter}", 'TOTAL');
//        $columnDebitFooter = 'C';
//        $columnCreditFooter = 'D';
//        foreach ($companies as $company) {
//            $debitSums = isset($debitSums[$company->id]) ? $debitSums[$company->id] : '0.00';
//            $creditSums = isset($creditSums[$company->id]) ? $creditSums[$company->id] : '0.00';
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
        header('Content-Disposition: attachment;filename="ringkasan_buku_besar_semua_pt.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($coaId, $startDate, $endDate, $companyId, $debetKredit) {
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

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');
        $worksheet->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);

        $coa = Coa::model()->findByPk($coaId);
        $company = Company::model()->findByPk($companyId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($company, 'name'));
        $worksheet->setCellValue('A2', 'Journal Transaction Detail ' . CHtml::encode(CHtml::value($coa, 'codeName')));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
        
        $worksheet->setCellValue('A5', 'Transaksi #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Description');
        $worksheet->setCellValue('D5', 'Memo');
        $worksheet->setCellValue('E5', 'Debet');
        $worksheet->setCellValue('F5', 'Kredit');
        $counter = 7;

        $jurnalUmums = JurnalUmum::model()->findAll(array(
            'condition' => "coa_id = :coa_id AND tanggal_transaksi BETWEEN :start_date AND :end_date AND branch_id IN (
                SELECT id FROM " . Branch::model()->tableName() . " WHERE company_id = " . $companyId . "
            ) AND debet_kredit = :debet_kredit",
            'params' => array(
                ':coa_id' => $coaId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':debet_kredit' => $debetKredit,
            )
        ));
        
        $totalDebit = '0.00';
        $totalCredit = '0.00';
        foreach ($jurnalUmums as $header) {
            $debitAmount = $header->debet_kredit == "D" ? CHtml::value($header, 'total') : 0;
            $creditAmount = $header->debet_kredit == "K" ? CHtml::value($header, 'total') : 0;
            
            $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'kode_transaksi'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'tanggal_transaksi'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'transaction_subject'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'remark'));
            $worksheet->setCellValue("E{$counter}", $debitAmount);
            $worksheet->setCellValue("F{$counter}", $creditAmount);

            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount;
            $counter++;
        }
        
        $worksheet->setCellValue("D{$counter}", 'TOTAL');
        $worksheet->setCellValue("E{$counter}", $totalDebit);
        $worksheet->setCellValue("F{$counter}", $totalCredit);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="jurnal_transaksi_ringkasan_buku_besar_perusahaan.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
