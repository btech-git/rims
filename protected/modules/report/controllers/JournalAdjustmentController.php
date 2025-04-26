<?php

class JournalAdjustmentController extends Controller {

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

        $journalAdjustmentHeader = Search::bind(new JournalAdjustmentHeader('search'), isset($_GET['JournalAdjustmentHeader']) ? $_GET['JournalAdjustmentHeader'] : array());
        
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = (isset($_GET['BranchId'])) ? $_GET['BranchId'] : '';
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $journalAdjustmentSummary = new JournalAdjustmentSummary($journalAdjustmentHeader->search());
        $journalAdjustmentSummary->setupLoading();
        $journalAdjustmentSummary->setupPaging($pageSize, $currentPage);
        $journalAdjustmentSummary->setupSorting();
        $filters = array(
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        );
        $journalAdjustmentSummary->setupFilter($filters);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($journalAdjustmentSummary->dataProvider, array(
                'startDate' => $startDate, 
                'endDate' => $endDate,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'journalAdjustmentSummary' => $journalAdjustmentSummary,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $startDate = $options['startDate'];
        $endDate = $options['endDate']; 
        $branchId = $options['branchId']; 
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Jurnal Penyesuaian');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Jurnal Penyesuaian');

        $worksheet->mergeCells('A1:O1');
        $worksheet->mergeCells('A2:O2');
        $worksheet->mergeCells('A3:O3');

        $worksheet->getStyle('A1:O6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:O6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Jurnal Penyesuaian');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate)) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate)));

        $worksheet->getStyle('A5:O5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Penyesuaian #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Status');
        $worksheet->setCellValue('D5', 'Catatan');
        $worksheet->setCellValue('E5', 'Pembuat');
        $worksheet->setCellValue('F5', 'Tanggal Input');
        $worksheet->setCellValue('G5', 'Edit Oleh');
        $worksheet->setCellValue('H5', 'Tanggal Edit');
        $worksheet->setCellValue('I5', 'Cancel');
        $worksheet->setCellValue('J5', 'Tanggal Cancel');
        $worksheet->setCellValue('K5', 'Code');
        $worksheet->setCellValue('L5', 'Name');
        $worksheet->setCellValue('M5', 'Memo');
        $worksheet->setCellValue('N5', 'Debit');
        $worksheet->setCellValue('O5', 'Credit');

        $worksheet->getStyle('A6:O6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        
        foreach ($dataProvider->data as $header) {
            foreach ($header->journalAdjustmentDetails as $detail) {
                $worksheet->getStyle("N{$counter}:O{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'transaction_number')));
                $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'date')) . ' ' . CHtml::encode(CHtml::value($header, 'time')));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'status')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'note')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'created_datetime')));
                $worksheet->setCellValue("G{$counter}", empty($header->user_id_updated) ? '' : CHtml::encode(CHtml::value($header, 'userIdUpdated.username')));
                $worksheet->setCellValue("H{$counter}", empty($header->updated_datetime) ? '' : CHtml::encode(CHtml::value($header, 'updated_datetime')));
                $worksheet->setCellValue("I{$counter}", empty($header->user_id_cancelled) ? '' : CHtml::encode(CHtml::value($header, 'userIdCancelled.username')));
                $worksheet->setCellValue("J{$counter}", empty($header->cancelled_datetime) ? '' : CHtml::encode(CHtml::value($header, 'cancelled_datetime')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'coa.code')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'coa.name')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'memo')));
                $worksheet->setCellValue("N{$counter}", CHtml::encode(CHtml::value($detail, 'debit')));
                $worksheet->setCellValue("O{$counter}", CHtml::encode(CHtml::value($detail, 'credit')));
                $counter++;

            }
        }
        $worksheet->getStyle("A{$counter}:O{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:O{$counter}")->getFont()->setBold(true);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Jurnal Penyesuaian.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
