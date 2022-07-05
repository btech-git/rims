<?php

class ProfitLossDetailController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
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

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

        if (isset($_GET['SaveExcel']))
            $this->saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId);

        $this->render('summary', array(
            'accountCategoryTypes' => $accountCategoryTypes,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    public function actionJurnalTransaction($coaId, $startDate, $endDate, $branchId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
//
////        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
////        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
////        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $profitLossSummary = new ProfitLossSummary($coa->search());
        $profitLossSummary->setupLoading();
//        $profitLossSummary->setupPaging($pageSize, $currentPage);
        $profitLossSummary->setupSorting();
        $profitLossSummary->setupFilter($startDate, $endDate, $coaId, $branchId);
        $profitLossSummary->getSaldo($startDate);

        $this->render('jurnalTransaction', array(
            'coa' => $coa,
            'profitLossSummary' => $profitLossSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'coaId' => $coaId,
            'branchId' => $branchId,
        ));
    }

    protected function saveToExcel($accountCategoryTypes, $startDate, $endDate, $branchId) {
        $startDate = (empty($startDate)) ? date('Y-m-d') : $startDate;
        $endDate = (empty($endDate)) ? date('Y-m-d') : $endDate;
        $startDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $startDate);
        $endDateString = Yii::app()->dateFormatter->format('d MMMM yyyy', $endDate);

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Profit Loss Standar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Profit Loss Standar');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Laporan Profit Loss Standar');
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
                $worksheet->getStyle("A{$counter}:B{$counter}")->getFont()->setBold(true);
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));

                $counter++;

                $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $accountCategory->id, 'is_approved' => 1, 'coa_id' => null), array('order' => 'code ASC'));
                foreach ($coas as $coa) {
                    $accountGroupBalance = 0.00;
                    $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($coa, 'code')));
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($coa, 'name')));
                    $counter++;
                    foreach ($coa->coaIds as $account) {
                        $accountBalance = $account->getProfitLossBalance($startDate, $endDate, $branchId);
                        if ((int) $accountBalance !== 0) {
                            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($account, 'code')));
                            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($account, 'name')));
                            $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            $worksheet->setCellValue("C{$counter}", CHtml::encode($accountBalance));
                            $counter++;
                            $accountGroupBalance += $accountBalance;
                        }
                    }
                    $worksheet->setCellValue("A{$counter}", 'Total');
                    $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($coa, 'name')));
                    $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("C{$counter}", CHtml::encode($accountGroupBalance));
                    $counter++; $counter++;
                    $accountCategoryBalance += $accountGroupBalance;
                }
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'code')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                $worksheet->getStyle("C{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("C{$counter}", CHtml::encode($accountCategoryBalance));
                $counter++;$counter++;
                
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

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Profit Loss Standar.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
