<?php

class ProfitLossController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director')))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'accountCategoryTypes' => $accountCategoryTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    public function actionJurnalTransaction() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $jurnalUmum = new JurnalUmum('search');

        $accountCategoryId = (isset($_GET['AccountCategoryId'])) ? $_GET['AccountCategoryId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';

        $profitLossSummary = new ProfitLossSummary($jurnalUmum->search());
        $profitLossSummary->setupLoading();
        $profitLossSummary->setupPaging(1000, 1);
        $profitLossSummary->setupSorting();
        $profitLossSummary->setupFilter($startDate, $endDate, $accountCategoryId, $branchId);

//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelTransactionJournal($profitLossSummary, $coaId, $startDate, $endDate, $branchId);
//        }

        $this->render('jurnalTransaction', array(
            'jurnalUmum' => $jurnalUmum,
            'profitLossSummary' => $profitLossSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'accountCategoryId' => $accountCategoryId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Laporan Profit Loss Induk');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Profit Loss Induk');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Laporan Profit Loss Induk');
        $worksheet->setCellValue('A2', CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);

        $counter = 5;

        $profitLossAmount = 0.00;
        foreach ($accountCategoryTypes as $accountCategoryType) {
            $accountCategoryTypeBalance = 0.00;
            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'code')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'name')));

            $counter++;

            $coaSubCategories = CoaSubCategory::model()->findAllByAttributes(array('coa_category_id' => $accountCategoryType->id), array('order' => 'code ASC'));
            foreach ($coaSubCategories as $accountCategory) {
                $accountCategoryBalance = 0.00;
                $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null), array('order' => 'code ASC'));
                foreach ($coas as $coa) {
                    $coaBalance = (empty($coa->coaIds)) ? $coa->getProfitLossBalance($startDate, $endDate, $branchId) : 0;
                    $accountGroupBalance = 0.00;
                    foreach ($coa->coaIds as $account) {
                        $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId);
                        $accountGroupBalance += $accountBalance;
                    }
                    $accountCategoryBalance += (empty($coa->coaIds)) ? $coaBalance : $accountGroupBalance;
                }
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryBalance));
                $counter++;
                
                if ((int)$accountCategory->id === 28 || (int)$accountCategory->id === 30 || (int)$accountCategory->id === 31){
                     $accountCategoryTypeBalance -= $accountCategoryBalance;
                } else {
                     $accountCategoryTypeBalance += $accountCategoryBalance;
                }
            }

            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryType, 'name')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryTypeBalance));

            $counter++;
            $counter++;
            
            if ($accountCategoryType->id == 7 || $accountCategoryType->id == 8 || $accountCategoryType->id == 10) {
                $profitLossAmount -= $accountCategoryTypeBalance;
            } else {
                $profitLossAmount += $accountCategoryTypeBalance;
            }
        }

        $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        $worksheet->setCellValue("A{$counter}", 'PROFIT / LOSS ');
        $worksheet->setCellValue("C{$counter}", CHtml::encode($profitLossAmount));

        for ($col = 'A'; $col !== 'E'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Profit Loss Induk.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
