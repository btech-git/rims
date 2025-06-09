<?php

class BalanceSheetMonthlyController extends Controller {

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
        
        $yearMonthNow = date('Y-m');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startYearMonth = (isset($_GET['StartYearMonth'])) ? $_GET['StartYearMonth'] : $yearMonthNow;
        $endYearMonth = (isset($_GET['EndYearMonth'])) ? $_GET['EndYearMonth'] : $yearMonthNow;
        
        $balanceSheetInfo = array();
        $balanceSheetInfo['1'] = array();
        $balanceSheetInfo['2'] = array();
        $balanceSheetInfo['3'] = array();
        $balanceSheetInfo['3*'] = array();
        $beginningBalanceInfo = array();
        $balanceSheetData = JurnalUmum::getBalanceSheetDataByTransactionYear($startYearMonth, $endYearMonth, $branchId);
        $beginningBalanceData = JurnalUmum::getBeginningBalanceDataByTransactionYear($startYearMonth, $branchId);
        foreach ($balanceSheetData as $balanceSheetItem) {
            $elementNumber = substr($balanceSheetItem['coa_code'], 0, 1);
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['code'] = $balanceSheetItem['category_code'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['name'] = $balanceSheetItem['category_name'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['code'] = $balanceSheetItem['sub_category_code'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['name'] = $balanceSheetItem['sub_category_name'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['code'] = $balanceSheetItem['coa_code'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['name'] = $balanceSheetItem['coa_name'];
            if (!isset($balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['debits'][$balanceSheetItem['transaction_month_year']])) {
                $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['debits'][$balanceSheetItem['transaction_month_year']] = '0.00';
            }
            if (!isset($balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['credits'][$balanceSheetItem['transaction_month_year']])) {
                $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['credits'][$balanceSheetItem['transaction_month_year']] = '0.00';
            }
            if (!isset($balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['totals'][$balanceSheetItem['transaction_month_year']])) {
                $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['totals'][$balanceSheetItem['transaction_month_year']] = '0.00';
            }
            $debit = '0.00';
            $credit = '0.00';
            $amount = '0.00';
            if (strtoupper($balanceSheetItem['debet_kredit']) === 'D' && strtolower($balanceSheetItem['normal_balance']) === 'debit') {
                $debit = $balanceSheetItem['total'];
                $amount = +$balanceSheetItem['total'];
            } else if (strtoupper($balanceSheetItem['debet_kredit']) === 'D' && strtolower($balanceSheetItem['normal_balance']) === 'kredit') {
                $debit = $balanceSheetItem['total'];
                $amount = -$balanceSheetItem['total'];
            } else if (strtoupper($balanceSheetItem['debet_kredit']) === 'K' && strtolower($balanceSheetItem['normal_balance']) === 'debit') {
                $credit = $balanceSheetItem['total'];
                $amount = -$balanceSheetItem['total'];
            } else if (strtoupper($balanceSheetItem['debet_kredit']) === 'K' && strtolower($balanceSheetItem['normal_balance']) === 'kredit') {
                $credit = $balanceSheetItem['total'];
                $amount = +$balanceSheetItem['total'];
            }
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['debits'][$balanceSheetItem['transaction_month_year']] += $debit;
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['credits'][$balanceSheetItem['transaction_month_year']] += $credit;
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['totals'][$balanceSheetItem['transaction_month_year']] += $amount;
        }
        foreach ($beginningBalanceData as $beginningBalanceItem) {
            $beginningBalanceInfo[$beginningBalanceItem['coa_id']] = $beginningBalanceItem['total'];
        }

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($balanceSheetInfo, $beginningBalanceInfo, $startYearMonth, $endYearMonth, $branchId);
        }

        $this->render('summary', array(
            'yearMonthNow' => $yearMonthNow,
            'branchId' => $branchId,
            'startYearMonth' => $startYearMonth,
            'endYearMonth' => $endYearMonth,
            'balanceSheetInfo' => $balanceSheetInfo,
            'beginningBalanceInfo' => $beginningBalanceInfo,
        ));
    }

    protected function saveToExcel($balanceSheetInfo, $beginningBalanceInfo, $startYearMonth, $endYearMonth, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        list($startYearNow, $startMonthNow) = explode('-', $startYearMonth);
        list($endYearNow, $endMonthNow) = explode('-', $endYearMonth);
        $currentStartYear = intval($startYearNow);
        $currentStartMonth = intval($startMonthNow);
        $currentEndYear = intval($endYearNow);
        $currentEndMonth = intval($endMonthNow);
        $yearMonthList = array();
        $currentYear = $currentStartYear;
        $currentMonth = $currentStartMonth;
        while ($currentYear < $currentEndYear || $currentYear === $currentEndYear && $currentMonth <= $currentEndMonth){
            $month = str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
            $yearMonthList[$currentYear . '-' . $month] = date('M', mktime(null, null, null, $currentMonth)) . ' ' . date('y', mktime(null, null, null, $currentMonth, null, $currentYear));
            $currentMonth++;
            if ($currentMonth === 13) {
                $currentMonth = 1;
                $currentYear++;
            }
        }
        $branch = empty($branchId) ? '' : Branch::model()->findbyPk($branchId);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Balance Sheet Multi Periode');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Balance Sheet Multi Periode');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Balance Sheet Multi Periode');
        $worksheet->setCellValue('A2', $startYearMonth . ' - ' . $endYearMonth);
        if (!empty($branch)) {
            $worksheet->setCellValue('A3', $branch->name);
        }

        $column = 'C'; 
        if (count($yearMonthList) <= 12 && count($yearMonthList) >= 1) {
            $worksheet->setCellValue('A5', 'Account');
            $worksheet->setCellValue('B5', 'Saldo Awal');
            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                $worksheet->setCellValue($column . '4', $yearMonthFormatted . '- Debit');
                $column++;
                $worksheet->setCellValue($column . '4', $yearMonthFormatted . '- Credit');
                $column++;
                $worksheet->setCellValue($column . '4', $yearMonthFormatted . '- Saldo');
                $column++;
            }
            
            $counter = 7;

            $elementNames = array('1' => 'Aktiva', '2' => 'Kewajiban', '3' => 'Ekuitas');
            $elementsTotalSums = array();
            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                $elementsTotalSums['1'][$yearMonth] = '0.00';
                $elementsTotalSums['2'][$yearMonth] = '0.00';
                $elementsTotalSums['3'][$yearMonth] = '0.00';
            }
            foreach ($balanceSheetInfo as $elementNumber => $balanceSheetElementInfo) {
                if ($elementNumber === '3*') {
                    $column = 'C'; 
                    $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("A{$counter}", "Total Kewajiban & Ekuitas");
                    foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                        $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($elementsTotalSums['2'][$yearMonth] + $elementsTotalSums['3'][$yearMonth]));
                        $column++;$column++;$column++;
                    }
                    $counter++;
                } else {
                    foreach ($balanceSheetElementInfo as $categoryInfo) {
                        $worksheet->setCellValue("A{$counter}", $categoryInfo['code'] . " - " . $categoryInfo['name']);
                        $counter++;

                        $categoryTotalSums = array();
                        foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                            $categoryTotalSums[$yearMonth] = '0.00';
                        }
                        foreach ($categoryInfo['sub_categories'] as $subCategoryInfo) {
                            $worksheet->setCellValue("A{$counter}", $subCategoryInfo['code'] . " - " . $subCategoryInfo['name']);
                            $counter++;

                            $subCategoryTotalSums = array();
                            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                                $subCategoryTotalSums[$yearMonth] = '0.00';
                            }

                            foreach ($subCategoryInfo['accounts'] as $coaId => $accountInfo) {
                                $column = 'C'; 
                                $beginningBalance = isset($beginningBalanceInfo[$coaId]) ? $beginningBalanceInfo[$coaId] : '0.00'; 
                                $currentBalance = $beginningBalance;
                                $worksheet->setCellValue("A{$counter}", $accountInfo['code'] . " - " . $accountInfo['name']);
                                $worksheet->setCellValue("B{$counter}", $beginningBalance);
                                foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                                    $debit = isset($accountInfo['debits'][$yearMonth]) ? $accountInfo['debits'][$yearMonth] : ''; 
                                    $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($debit));
                                    $column++;
                                    $credit = isset($accountInfo['credits'][$yearMonth]) ? $accountInfo['credits'][$yearMonth] : '';
                                    $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($credit));
                                    $column++;
                                    $balance = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : '';
                                    $currentBalance += $balance;
                                    $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($currentBalance));
                                    $column++;
                                    $subCategoryTotalSums[$yearMonth] += $currentBalance;
                                }
                                $counter++;

                            }

                            $column = 'C'; 
                            $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            $worksheet->setCellValue("A{$counter}", "Total " . $subCategoryInfo['name']);
                            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                                $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($subCategoryTotalSums[$yearMonth]));
                                $column++;
                            }
                            $counter++;
                            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                                $categoryTotalSums[$yearMonth] += $subCategoryTotalSums[$yearMonth];
                            }
                        }

                        $column = 'C'; 
                        $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $worksheet->setCellValue("A{$counter}", "Total " . $categoryInfo['name']);
                        foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                            $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($categoryTotalSums[$yearMonth]));
                            $column++;
                        }
                        $counter++;

                        foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                            $elementsTotalSums[$elementNumber][$yearMonth] += $categoryTotalSums[$yearMonth];
                        }
                    }

                    $column = 'C'; 
                    $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("A{$counter}", "Total " . $elementNames[$elementNumber]);
                    foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                        $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($elementsTotalSums[$elementNumber][$yearMonth]));
                        $column++;
                    }
                    $counter++;
                }
            }
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Balance Sheet Multi Periode.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $yearMonth = (isset($_GET['YearMonth'])) ? $_GET['YearMonth'] : date('Y-m');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $balanceSheetSummary = new BalanceSheetSummary($jurnalUmum->search());
        $balanceSheetSummary->setupLoading();
        $balanceSheetSummary->setupPaging(1000, 1);
        $balanceSheetSummary->setupSorting();
        $balanceSheetSummary->setupFilter($yearMonth, $coaId, $branchId);

        if (isset($_GET['SaveToExcel'])) {
            $this->saveToExcelTransactionJournal($balanceSheetSummary, $coaId, $yearMonth, $branchId);
        }

        $this->render('jurnalTransaction', array(
            'jurnalUmum' => $jurnalUmum,
            'balanceSheetSummary' => $balanceSheetSummary,
            'yearMonth' => $yearMonth,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcelTransactionJournal($balanceSheetSummary, $coaId, $yearMonth, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $branch = Branch::model()->findbyPk($branchId);
        $coa = Coa::model()->findByPk($coaId);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));
        
        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Balance Sheet Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Balance Sheet Transaction');

        $worksheet->mergeCells('A1:G1');
        $worksheet->mergeCells('A2:G2');
        $worksheet->mergeCells('A3:G3');
        $worksheet->getStyle('A1:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:G3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Transaction Detail - ' . empty($branchId) ? 'All Branch' : $branch->code);
        $worksheet->setCellValue('A2', CHtml::encode($coa->code) . ' - ' . CHtml::encode($coa->name));
        $worksheet->setCellValue('A3', CHtml::encode(Yii::app()->dateFormatter->format('MMMM yyyy', strtotime($yearMonth))));
        
        $worksheet->getStyle('A5:G5')->getBorders()->gettOP()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'No');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Kode Transaksi');
        $worksheet->setCellValue('D5', 'Keterangan');
        $worksheet->setCellValue('E5', 'Memo');
        $worksheet->setCellValue('F5', 'Debit');
        $worksheet->setCellValue('G5', 'Kredit');

        $worksheet->getStyle('A5:G5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7; 
        
        $totalDebit = '0.00'; 
        $totalCredit = '0.00'; 
        foreach ($balanceSheetSummary->dataProvider->data as $i => $header) {
            $debitAmount = $header->debet_kredit == 'D' ? $header->total : 0;
            $creditAmount = $header->debet_kredit == 'K' ? $header->total : 0;

            $worksheet->setCellValue("A{$counter}", $i + 1);
            $worksheet->setCellValue("B{$counter}", $header->tanggal_transaksi);
            $worksheet->setCellValue("C{$counter}", $header->kode_transaksi);
            $worksheet->setCellValue("D{$counter}", $header->transaction_subject);
            $worksheet->setCellValue("E{$counter}", $header->transaction_type);
            $worksheet->setCellValue("F{$counter}", $debitAmount);
            $worksheet->setCellValue("G{$counter}", $creditAmount);

            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount;

            $counter++;

        }
        
        $worksheet->mergeCells("A{$counter}:E{$counter}");
        $worksheet->getStyle("A{$counter}:G{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $worksheet->getStyle("A{$counter}:G{$counter}")->getFont()->setBold(true);
        $worksheet->setCellValue("A{$counter}", 'TOTAL');
        $worksheet->setCellValue("F{$counter}", $totalDebit);
        $worksheet->setCellValue("G{$counter}", $totalCredit);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="balance_sheet_transaction.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}