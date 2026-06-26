<?php

class WorkOrderExpensePaymentController extends Controller {

    public $layout = '//layouts/column1';
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('workOrderExpenseReport'))) {
                $this->redirect(array('/site/login'));
            }
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $workOrderExpense = Search::bind(new WorkOrderExpenseHeader('search'), isset($_GET['WorkOrderExpenseHeader']) ? $_GET['WorkOrderExpenseHeader'] : array());
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $pageSize = (isset($_GET['PageSize'])) ? $_GET['PageSize'] : '';
        $currentPage = (isset($_GET['page'])) ? $_GET['page'] : '';
        $currentSort = (isset($_GET['sort'])) ? $_GET['sort'] : '';

        $workOrderExpenseSummary = new WorkOrderExpensePaymentSummary($workOrderExpense->search());
        $workOrderExpenseSummary->setupLoading();
        $workOrderExpenseSummary->setupPaging($pageSize, $currentPage);
        $workOrderExpenseSummary->setupSorting();
        $workOrderExpenseSummary->setupFilter($startDate, $endDate, $branchId);

        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($branchId, $workOrderExpenseSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
        }

        $this->render('summary', array(
            'workOrderExpense' => $workOrderExpense,
            'workOrderExpenseSummary' => $workOrderExpenseSummary,
            'branchId' => $branchId,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currentSort' => $currentSort,
        ));
    }

    protected function saveToExcel($branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Sub Pekerjaan Luar');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Sub Pekerjaan Luar');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');
        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::value($branch, 'name'));
        $worksheet->setCellValue('A2', 'Sub Pekerjaan Luar Pembayaran');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Sub Pekerjaan #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'RG #');
        $worksheet->setCellValue('D5', 'Supplier');
        $worksheet->setCellValue('E5', 'Note');
        $worksheet->setCellValue('F5', 'Total');
        $worksheet->setCellValue('G5', 'Payment');
        $worksheet->setCellValue('H5', 'Remaining');
        $worksheet->setCellValue('I5', 'Payment #');
        $worksheet->setCellValue('J5', 'Tanggal');
        $worksheet->setCellValue('K5', 'Memo');
        $worksheet->setCellValue('L5', 'Type');
        $worksheet->setCellValue('M5', 'Amount');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        foreach ($dataProvider->data as $header) {
            foreach ($header->payOutDetails as $detail) {
                $worksheet->setCellValue("A{$counter}", CHtml::value($header, 'transaction_number'));
                $worksheet->setCellValue("B{$counter}", CHtml::value($header, 'transaction_date'));
                $worksheet->setCellValue("C{$counter}", CHtml::value($header, 'registrationTransaction.transaction_number'));
                $worksheet->setCellValue("D{$counter}", CHtml::value($header, 'supplier.name'));
                $worksheet->setCellValue("E{$counter}", CHtml::value($header, 'note'));
                $worksheet->setCellValue("F{$counter}", CHtml::value($header, 'grand_total'));
                $worksheet->setCellValue("G{$counter}", CHtml::value($header, 'total_payment'));
                $worksheet->setCellValue("H{$counter}", CHtml::value($header, 'payment_remaining'));
                $worksheet->setCellValue("I{$counter}", CHtml::value($detail, 'paymentOut.payment_number'));
                $worksheet->setCellValue("J{$counter}", CHtml::value($detail, 'paymentOut.payment_date'));
                $worksheet->setCellValue("K{$counter}", CHtml::value($detail, 'memo'));
                $worksheet->setCellValue("L{$counter}", CHtml::value($detail, 'paymentOut.paymentType.name'));
                $worksheet->setCellValue("M{$counter}", CHtml::value($detail, 'amount'));

                $counter++;
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
        header('Content-Disposition: attachment;filename="sub_pekerjaan_luar_pembayaran.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
