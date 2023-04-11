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
            if (!(Yii::app()->user->checkAccess('standardProfitLossReport')))
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
        
        $profitLossInfo = array();
        $profitLossData = JurnalUmum::getProfitLossDataByTransactionYear($startYearMonth, $endYearMonth, $branchId);
        foreach ($profitLossData as $profitLossItem) {
            $profitLossInfo[$profitLossItem['category_id']]['code'] = $profitLossItem['category_code'];
            $profitLossInfo[$profitLossItem['category_id']]['name'] = $profitLossItem['category_name'];
            $profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['code'] = $profitLossItem['sub_category_code'];
            $profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['name'] = $profitLossItem['sub_category_name'];
            $profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['code'] = $profitLossItem['coa_code'];
            $profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['name'] = $profitLossItem['coa_name'];
            if (!isset($profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['totals'][$profitLossItem['transaction_month_year']])) {
                $profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['totals'][$profitLossItem['transaction_month_year']] = '0.00';
            }
            $amount = '0.00';
            if (strtoupper($profitLossItem['debet_kredit']) === 'D' && strtolower($profitLossItem['normal_balance']) === 'debit') {
                $amount = +$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'D' && strtolower($profitLossItem['normal_balance']) === 'kredit') {
                $amount = -$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'K' && strtolower($profitLossItem['normal_balance']) === 'debit') {
                $amount = -$profitLossItem['total'];
            } else if (strtoupper($profitLossItem['debet_kredit']) === 'K' && strtolower($profitLossItem['normal_balance']) === 'kredit') {
                $amount = +$profitLossItem['total'];
            }
            $profitLossInfo[$profitLossItem['category_id']]['sub_categories'][$profitLossItem['sub_category_id']]['accounts'][$profitLossItem['coa_id']]['totals'][$profitLossItem['transaction_month_year']] += $amount;
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
        
//        ob_start();

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Profit Loss per Periode');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Profit Loss per Periode');

        $worksheet->mergeCells('A1:E1');
        $worksheet->mergeCells('A2:E2');
        $worksheet->mergeCells('A3:E3');
        $worksheet->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:E3')->getFont()->setBold(true);

        $worksheet->setCellValue('A1', 'Profit Loss per Periode');
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

            foreach ($profitLossInfo as $categoryInfo) {
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
        header('Content-Disposition: attachment;filename="Profit Loss per Periode.xlsx"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}