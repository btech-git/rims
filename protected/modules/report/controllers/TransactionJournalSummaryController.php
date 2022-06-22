<?php

class TransactionJournalSummaryController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('allAccountingReport')))
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

        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : $dateStart;
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $accountCategoryAssets = CoaCategory::model()->findAll(array('condition' => 't.id = 12'));
        $accountCategoryLiabilitiesEquities = CoaCategory::model()->findAll(array('condition' => 't.id = 13'));
        $accountProfitLossPrevious = Coa::model()->findByPk(1475);
        $accountProfitLoss = Coa::model()->findByPk(1476);
        $accountCategoryTypes = CoaCategory::model()->findAll(array('condition' => 't.id BETWEEN 6 AND 10'));

//        if (isset($_GET['SaveExcel']))
//            $this->saveToExcel($accountCategoryTypes, $endDate, $branchId);

        $this->render('summary', array(
            'accountCategoryAssets' => $accountCategoryAssets,
            'accountCategoryLiabilitiesEquities' => $accountCategoryLiabilitiesEquities,
            'accountProfitLoss' => $accountProfitLoss,
            'accountProfitLossPrevious' => $accountProfitLossPrevious,
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

        $balanceSheetSummary = new BalanceSheetSummary($coa->search());
        $balanceSheetSummary->setupLoading();
        $balanceSheetSummary->setupPaging(1000, 1);
        $balanceSheetSummary->setupSorting();
        $balanceSheetSummary->setupFilter($startDate, $endDate, $coaId, $branchId);

        $this->render('jurnalTransaction', array(
            'coa' => $coa,
            'balanceSheetSummary' => $balanceSheetSummary,
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
        $documentProperties->setCreator('Lanusa');
        $documentProperties->setTitle('Laporan Balance Sheet');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Balance Sheet');

        $worksheet->mergeCells('A1:B1');
        $worksheet->mergeCells('A2:B2');
        $worksheet->mergeCells('A3:B3');
        $worksheet->getStyle('A1:B3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:B3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A2', 'Laporan Balance Sheet');
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);


        $counter = 6;


        foreach ($accountCategoryTypes as $accountCategoryType) {
            $worksheet->getStyle("A{$counter}")->getFont()->setBold(true);
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategoryType, 'name')));

            $counter++;

            foreach ($accountCategoryType->accountCategories as $accountCategory) {
                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($accountCategory, 'name')));
                $worksheet->getStyle("B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategory->getBalanceTotal($startDate, $endDate, $branchId)));
                $counter++;
            }

            $worksheet->getStyle("A{$counter}:B{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
            $worksheet->getStyle("A{$counter}:B{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("A{$counter}", 'TOTAL ' . CHtml::encode(CHtml::value($accountCategoryType, 'name')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode($accountCategoryType->getBalanceTotal($startDate, $endDate, $branchId)));

            $counter++;
            $counter++;
        }



        for ($col = 'A'; $col !== 'H'; $col++) {
            $objPHPExcel->getActiveSheet()
                    ->getColumnDimension($col)
                    ->setAutoSize(true);
        }

        header('Content-Type: application/xlsx');
        header('Content-Disposition: attachment;filename="Laporan Balance Sheet.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
