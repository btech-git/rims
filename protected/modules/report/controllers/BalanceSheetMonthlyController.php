<?php

class BalanceSheetMonthlyController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('summaryBalanceSheetReport')))
                $this->redirect(array('/site/login'));
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
        $balanceSheetData = JurnalUmum::getBalanceSheetDataByTransactionYear($startYearMonth, $endYearMonth, $branchId);
        foreach ($balanceSheetData as $balanceSheetItem) {
            $elementNumber = substr($balanceSheetItem['coa_code'], 0, 1);
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['code'] = $balanceSheetItem['category_code'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['name'] = $balanceSheetItem['category_name'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['code'] = $balanceSheetItem['sub_category_code'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['name'] = $balanceSheetItem['sub_category_name'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['code'] = $balanceSheetItem['coa_code'];
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['name'] = $balanceSheetItem['coa_name'];
            if (!isset($balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['totals'][$balanceSheetItem['transaction_month_year']])) {
                $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['totals'][$balanceSheetItem['transaction_month_year']] = '0.00';
            }
            $amount = '0.00';
            if (strtoupper($balanceSheetItem['debet_kredit']) === 'D' && strtolower($balanceSheetItem['normal_balance']) === 'debit') {
                $amount = +$balanceSheetItem['total'];
            } else if (strtoupper($balanceSheetItem['debet_kredit']) === 'D' && strtolower($balanceSheetItem['normal_balance']) === 'kredit') {
                $amount = -$balanceSheetItem['total'];
            } else if (strtoupper($balanceSheetItem['debet_kredit']) === 'K' && strtolower($balanceSheetItem['normal_balance']) === 'debit') {
                $amount = -$balanceSheetItem['total'];
            } else if (strtoupper($balanceSheetItem['debet_kredit']) === 'K' && strtolower($balanceSheetItem['normal_balance']) === 'kredit') {
                $amount = +$balanceSheetItem['total'];
            }
            $balanceSheetInfo[$elementNumber][$balanceSheetItem['category_id']]['sub_categories'][$balanceSheetItem['sub_category_id']]['accounts'][$balanceSheetItem['coa_id']]['totals'][$balanceSheetItem['transaction_month_year']] += $amount;
        }

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($balanceSheetInfo, $startYearMonth, $endYearMonth, $branchId);
        }

        $this->render('summary', array(
            'yearMonthNow' => $yearMonthNow,
            'branchId' => $branchId,
            'startYearMonth' => $startYearMonth,
            'endYearMonth' => $endYearMonth,
            'balanceSheetInfo' => $balanceSheetInfo,
        ));
    }

    protected function saveToExcel($balanceSheetInfo, $startYearMonth, $endYearMonth, $branchId) {
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

        $column = 'B'; 
        if (count($yearMonthList) <= 12 && count($yearMonthList) >= 1) {
            $worksheet->setCellValue('A5', 'Account');
            foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                $worksheet->setCellValue($column . '4', $yearMonthFormatted);
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
                    $column = 'B'; 
                    $worksheet->getStyle("A{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("A{$counter}", "Total Kewajiban & Ekuitas");
                    foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                        $worksheet->setCellValue("{$column}{$counter}", CHtml::encode($elementsTotalSums['2'][$yearMonth] + $elementsTotalSums['3'][$yearMonth]));
                        $column++;
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

                            foreach ($subCategoryInfo['accounts'] as $accountInfo) {
                                $column = 'B'; 
                                $worksheet->setCellValue("A{$counter}", $accountInfo['code'] . " - " . $accountInfo['name']);
                                foreach ($yearMonthList as $yearMonth => $yearMonthFormatted) {
                                    $balance = isset($accountInfo['totals'][$yearMonth]) ? $accountInfo['totals'][$yearMonth] : 0;
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

                    $column = 'B'; 
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
        
        for ($col = 'A'; $col !== 'H'; $col++) {
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
}