<?php

class RegistrationCompletedByServiceController extends Controller {

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
        
        $dateNow = date('Y-m-d');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : $dateNow;
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : $dateNow;
        
        $registrationCompletedInfo = array();
        $registrationCompletedData = RegistrationService::getCompletedTaskByTransactionDate($startDate, $endDate, $branchId);
        foreach ($registrationCompletedData as $registrationCompletedItem) {
            $registrationCompletedInfo[$registrationCompletedItem['service_type_id']]['service_type_name'] = $registrationCompletedItem['service_type_name'];
            
            if (!isset($registrationCompletedInfo[$registrationCompletedItem['service_type_id']]['totals'][$registrationCompletedItem['transaction_date']])) {
                $registrationCompletedInfo[$registrationCompletedItem['service_type_id']]['totals'][$registrationCompletedItem['transaction_date']] = '0.00';
            }
            $amount = '0.00';
            $registrationCompletedInfo[$registrationCompletedItem['service_type_id']]['totals'][$registrationCompletedItem['transaction_date']] += $amount;
        }

//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($registrationCompletedInfo, $startYearMonth, $endYearMonth, $branchId);
//        }

        $this->render('summary', array(
            'branchId' => $branchId,
            'dateNow' => $dateNow,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'registrationCompletedInfo' => $registrationCompletedInfo,
        ));
    }

    protected function saveToExcel($registrationCompletedInfo, $startYearMonth, $endYearMonth, $branchId) {
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

            foreach ($registrationCompletedInfo as $categoryInfo) {
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
        header('Content-Disposition: attachment;filename="Profit Loss Multi Periode.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}