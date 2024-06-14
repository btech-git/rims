<?php

class ProfitLossMonthlyController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('standardProfitLossReport'))) {
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
        
        $profitLossInfo = array();
        $profitLossInfo['4'] = array();
        $profitLossInfo['5'] = array();
        $profitLossInfo['5*'] = array();
        $profitLossInfo['6'] = array(); 
        $profitLossInfo['7'] = array();
        $profitLossInfo['8'] = array();
        $profitLossInfo['8*'] = array();
        $profitLossData = JurnalUmum::getProfitLossDataByTransactionYear($startYearMonth, $endYearMonth, $branchId);
        foreach ($profitLossData as $profitLossItem) {
            $elementNumber = substr($profitLossItem['coa_code'], 0, 1);
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['code'] = $profitLossItem['category_code'];
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['name'] = $profitLossItem['category_name'];
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['code'] = $profitLossItem['sub_category_code'];
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['name'] = $profitLossItem['sub_category_name'];
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['code'] = $profitLossItem['coa_code'];
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['name'] = $profitLossItem['coa_name'];
            if (!isset($profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['totals'][$profitLossItem['transaction_month_year']])) {
                $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['totals'][$profitLossItem['transaction_month_year']] = '0.00';
            }
            $amount = '0.00';
            $codePrefix = substr($profitLossItem['coa_code'], 0, 3);
            if ($codePrefix === '412' || $codePrefix === '422') {
                $amount = -$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'D' && strtolower($profitLossItem['normal_balance']) === 'debit') {
                $amount = +$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'D' && strtolower($profitLossItem['normal_balance']) === 'kredit') {
                $amount = -$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'K' && strtolower($profitLossItem['normal_balance']) === 'debit') {
                $amount = -$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'K' && strtolower($profitLossItem['normal_balance']) === 'kredit') {
                $amount = +$profitLossItem['total'];
            }
            $profitLossInfo[$elementNumber][$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['totals'][$profitLossItem['transaction_month_year']] += $amount;
        }

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($profitLossInfo, $startYearMonth, $endYearMonth, $branchId);
        }

        $this->render('summary', array(
            'yearMonthNow' => $yearMonthNow,
            'branchId' => $branchId,
            'startYearMonth' => $startYearMonth,
            'endYearMonth' => $endYearMonth,
            'profitLossInfo' => $profitLossInfo,
        ));
    }

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');

        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
        $yearMonth = (isset($_GET['YearMonth'])) ? $_GET['YearMonth'] : date('Y-m');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $profitLossSummary = new ProfitLossSummary($jurnalUmum->search());
        $profitLossSummary->setupLoading();
        $profitLossSummary->setupPaging(1000, 1);
        $profitLossSummary->setupSorting();
        $profitLossSummary->setupFilter($yearMonth, $coaId, $branchId);

//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelTransactionJournal($profitLossSummary, $coaId, $startDate, $endDate, $branchId);
//        }

        $this->render('jurnalTransaction', array(
            'jurnalUmum' => $jurnalUmum,
            'profitLossSummary' => $profitLossSummary,
            'yearMonth' => $yearMonth,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($profitLossInfo, $startYearMonth, $endYearMonth, $branchId) {
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
        $documentProperties->setTitle('Profit Loss Multi Periode');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Profit Loss Multi Periode');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Profit Loss Multi Periode');
        $worksheet->setCellValue('A2', $startYearMonth . ' - ' . $endYearMonth);
        if (!empty($branch)) {
            $worksheet->setCellValue('A3', $branch->name);
        }

        $column = 'B'; 
        if (count($yearMonthList) <= 12 && count($yearMonthList) >= 1) {
            $worksheet->setCellValue('A4', 'Account');
            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                $worksheet->setCellValue($column . '4', $yearMonthFormatted);
                $column++;                
            }
            
            $counter = 6;

            $elementNames = array('4' => 'Pendapatan', '5' => 'Harga Pokok Penjualan', '6' => 'Beban', '7' => 'Pendapatan Lain-lain', '8' => 'Beban Lain-lain');
            $elementsTotalSums = array();
            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                $elementsTotalSums['4'][$yearMonth] = '0.00';
                $elementsTotalSums['5'][$yearMonth] = '0.00';
                $elementsTotalSums['6'][$yearMonth] = '0.00';
                $elementsTotalSums['7'][$yearMonth] = '0.00';
                $elementsTotalSums['8'][$yearMonth] = '0.00';
            }
            foreach ($profitLossInfo as $elementNumber => $profitLossElementInfo) {
                if ($elementNumber === '5*') {
                    $column = 'B'; 
                    $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("A{$counter}", "Profit / Loss Bruto");
                    foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                        $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($elementsTotalSums['4'][$yearMonth] - $elementsTotalSums['5'][$yearMonth]));
                        $column++;
                    }
                    $counter++;
                    
                } elseif ($elementNumber === '8*') {
                    $column = 'B'; 
                    $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("A{$counter}", "Profit / Loss Net");
                    foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                        $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($elementsTotalSums['4'][$yearMonth] - $elementsTotalSums['5'][$yearMonth] - $elementsTotalSums['6'][$yearMonth] + $elementsTotalSums['7'][$yearMonth] - $elementsTotalSums['8'][$yearMonth]));
                        $column++;
                    }
                    $counter++;
                } else {
                    foreach ($profitLossElementInfo as $categoryInfo) {
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

                            foreach ($subCategoryInfo['accounts'] as $accountInfo) {
                                $column = 'B'; 
                                $worksheet->setCellValue("A{$counter}", $accountInfo['code'] . " - " . $accountInfo['name']);
                                foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                                    $balance = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : '';
                                    $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($balance));
                                    $column++;
                                    $subCategoryTotalSums[$yearMonth] += $balance;
                                }
                                $counter++;

                            }

                            $column = 'B'; 
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

                        $column = 'B'; 
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
//                    $column = 'B'; 
//                    $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
//                    $worksheet->setCellValue("A{$counter}", "Total " . $elementNames[$elementNumber]);
//                    foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
//                        $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($elementsTotalSums[$elementNumber][$yearMonth]));
//                        $column++;
//                    }
//                    $counter++;
                }
            }
        }
        
        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Profit Loss Multi Periode.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}