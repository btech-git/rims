<?php

class TransactionJournalSummaryController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
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

        $dateNow = date('Y-m-d');
        list($yearNow, , ) = explode('-', $dateNow);
        $dateStart = $yearNow . '-01-01';

        $transactionType = (isset($_GET['TransactionType'])) ? $_GET['TransactionType'] : '';
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $coaCategoryId = (isset($_GET['CoaCategoryId'])) ? $_GET['CoaCategoryId'] : '';

        $criteria = new CDbCriteria();
        $criteria->addCondition('t.coa_category_id = :coa_category_id');
        $criteria->params = array(':coa_category_id' => $coaCategoryId);
        $criteria->order = 't.code ASC';

        if (empty($coaCategoryId)) {
            $coaSubCategories = CoaSubCategory::model()->findAll(array('condition' => 't.coa_category_id NOT IN (11)', 'order' => 't.code ASC'));
        } else {
            $coaSubCategories = CoaSubCategory::model()->findAll($criteria);
        }
//        $accountCategoryLiabilitiesEquities = CoaCategory::model()->findAll(array('condition' => 't.id = 13'));
//        $accountProfitLossPrevious = Coa::model()->findByPk(1475);
//        $accountProfitLoss = Coa::model()->findByPk(1476);
//        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($coaSubCategories , $startDate, $endDate, $branchId, $transactionType);
        }

        $this->render('summary', array(
            'coaSubCategories' => $coaSubCategories,
//            'accountCategoryLiabilitiesEquities' => $accountCategoryLiabilitiesEquities,
//            'accountProfitLoss' => $accountProfitLoss,
//            'accountProfitLossPrevious' => $accountProfitLossPrevious,
            'transactionType' => $transactionType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'coaCategoryId' => $coaCategoryId,
        ));
    }

//    public function actionJurnalTransaction() {
//        set_time_limit(0);
//        ini_set('memory_limit', '1024M');
//
//        $coa = Search::bind(new Coa('search'), isset($_GET['Coa']) ? $_GET['Coa'] : array());
//
//        $coaId = (isset($_GET['CoaId'])) ? $_GET['CoaId'] : '';
//        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
//        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
//        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
//
//        $balanceSheetSummary = new BalanceSheetSummary($coa->search());
//        $balanceSheetSummary->setupLoading();
//        $balanceSheetSummary->setupPaging(1000, 1);
//        $balanceSheetSummary->setupSorting();
//        $balanceSheetSummary->setupFilter($startDate, $endDate, $coaId, $branchId);
//
//        $this->render('jurnalTransaction', array(
//            'coa' => $coa,
//            'balanceSheetSummary' => $balanceSheetSummary,
//            'startDate' => $startDate,
//            'endDate' => $endDate,
//            'coaId' => $coaId,
//            'branchId' => $branchId,
//        ));
//    }

    protected function saveToExcel($coaSubCategories, $startDate, $endDate, $branchId, $transactionType) {
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
        $worksheet->setCellValue('A1', CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A2', 'Laporan Jurnal Umum Rekap');
        $worksheet->setCellValue('A3', 'Periode: ' . $startDateString . ' - ' . $endDateString);

        $worksheet->getStyle("A5:J5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:J5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->getStyle('A5:J5')->getFont()->setBold(true);
        $worksheet->setCellValue('A5', 'Chart of Account');
        $worksheet->setCellValue('B5', 'Debit');
        $worksheet->setCellValue('C5', 'Credit');

        $counter = 6;

        $accountCategoryDebitBalance = 0.00;
        $accountCategoryCreditBalance = 0.00;
        foreach ($coaSubCategories as $coaSubCategory) {
            $coas = Coa::model()->findAllByAttributes(array('coa_sub_category_id' => $coaSubCategory->id), array('order' => 't.code ASC'));
            foreach ($coas as $coa) {
                $journalDebitBalance = $coa->getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType);
                $journalCreditBalance = $coa->getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType);
                if ($journalDebitBalance !== 0 || $journalCreditBalance !== 0) { //&& $journalDebitBalance !== $journalCreditBalance) {
                    $worksheet->setCellValue("A{$counter}", $coa->code . ' - ' . $coa->name);
                    if (empty($coa->coaIds)) {
                        $worksheet->setCellValue("B{$counter}", $journalDebitBalance);
                        $worksheet->setCellValue("C{$counter}", $journalCreditBalance);
                    }
                    $counter++;
            
                    $groupDebitBalance = 0;
                    $groupCreditBalance = 0;
                    if (!empty($coa->coaIds)) {
                        $coaIds = Coa::model()->findAllByAttributes(array('coa_id' => $coa->id), array('order' => 't.code ASC'));
                        foreach ($coaIds as $account) {
                            $journalDebitBalance = $account->getJournalDebitBalance($startDate, $endDate, $branchId, $transactionType);
                            $journalCreditBalance = $account->getJournalCreditBalance($startDate, $endDate, $branchId, $transactionType);
                            if (($journalDebitBalance !== 0 || $journalCreditBalance !== 0) && $journalDebitBalance !== $journalCreditBalance) {
                                $worksheet->setCellValue("A{$counter}", $coa->code . ' - ' . $coa->name);
                                if (empty($coa->coaIds)) {
                                    $worksheet->setCellValue("B{$counter}", $journalDebitBalance);
                                    $worksheet->setCellValue("C{$counter}", $journalCreditBalance);
                                }
                                $groupDebitBalance += $journalDebitBalance;
                                $groupCreditBalance += $journalCreditBalance;
                                
                                $counter++;
                                
                            }
                        }
                    }
                }
                $accountCategoryDebitBalance += $journalDebitBalance;
                $accountCategoryCreditBalance += $journalCreditBalance;
            }

            $counter++;
        }
        
        $worksheet->setCellValue("A{$counter}", "Total");
        $worksheet->setCellValue("B{$counter}", $accountCategoryDebitBalance);
        $worksheet->setCellValue("C{$counter}", $accountCategoryCreditBalance);

        for ($col = 'A'; $col !== 'D'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Jurnal Umum Rekap.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
