<?php

class DailyTransactionConfirmationController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('cashTransactionReport') ))
                $this->redirect(array('/site/login'));
        }

        $filterChain->run();
    }

    public function actionSummary() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $monthNow = date('m');
        $yearNow = date('Y');
        
        $month = isset($_GET['Month']) ? $_GET['Month'] : $monthNow;
        $year = isset($_GET['Year']) ? $_GET['Year'] : $yearNow;
        
        $confirmationList = DailyTransactionConfirmation::getConfirmationList($month, $year);
        
        $confirmationListData = array();
        foreach ($confirmationList as $confirmationListItem) {
            $confirmationListData[$confirmationListItem['transaction_date']][$confirmationListItem['branch_id']] = true;
        }
        
        $branches = Branch::model()->findAll();
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
//        if (isset($_GET['SaveExcel'])) {
//            $this->saveToExcel($cashTransactionSummary, $branchId, $cashTransactionSummary->dataProvider, array('startDate' => $startDate, 'endDate' => $endDate));
//        }

        $this->render('summary', array(
            'confirmationListData' => $confirmationListData,
            'yearList' => $yearList,
            'branches' => $branches,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
        ));
    }

    protected function saveToExcel($cashTransactionSummary, $branchId, $dataProvider, array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Cash Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Cash Transaction');

        $worksheet->mergeCells('A1:M1');
        $worksheet->mergeCells('A2:M2');
        $worksheet->mergeCells('A3:M3');

        $worksheet->getStyle('A1:M5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:M5')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Cash Transaction');
        $worksheet->setCellValue('A3', Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['startDate'])) . ' - ' . Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($options['endDate'])));

        $worksheet->getStyle('A5:M5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $worksheet->setCellValue('A5', 'Transaction #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Tipe');
        $worksheet->setCellValue('D5', 'COA');
        $worksheet->setCellValue('E5', 'Debit');
        $worksheet->setCellValue('F5', 'Credit');
        $worksheet->setCellValue('G5', 'Branch');
        $worksheet->setCellValue('H5', 'Admin');
        $worksheet->setCellValue('I5', 'Status');
        $worksheet->setCellValue('J5', 'Payment Type');
        $worksheet->setCellValue('K5', 'Coa');
        $worksheet->setCellValue('L5', 'Amount');
        $worksheet->setCellValue('M5', 'Note');

        $worksheet->getStyle('A5:M5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 7;
        foreach ($dataProvider->data as $header) {
            foreach ($header->cashTransactionDetails as $detail) {
                $worksheet->getStyle("E{$counter}:F{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $worksheet->setCellValue("A{$counter}", CHtml::encode($header->transaction_number));
                $worksheet->setCellValue("B{$counter}", CHtml::encode($header->transaction_date));
                $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transaction_type')));
                $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'coa.name')));
                $worksheet->setCellValue("E{$counter}", CHtml::encode(CHtml::value($header, 'debit_amount')));
                $worksheet->setCellValue("F{$counter}", CHtml::encode(CHtml::value($header, 'credit_amount')));
                $worksheet->setCellValue("G{$counter}", CHtml::encode(CHtml::value($header, 'branch.name')));
                $worksheet->setCellValue("H{$counter}", CHtml::encode(CHtml::value($header, 'user.username')));
                $worksheet->setCellValue("I{$counter}", CHtml::encode(CHtml::value($header, 'status')));
                $worksheet->setCellValue("J{$counter}", CHtml::encode(CHtml::value($header, 'paymentType.name')));
                $worksheet->setCellValue("K{$counter}", CHtml::encode(CHtml::value($detail, 'coa.name')));
                $worksheet->setCellValue("L{$counter}", CHtml::encode(CHtml::value($detail, 'amount')));
                $worksheet->setCellValue("M{$counter}", CHtml::encode(CHtml::value($detail, 'notes')));

                $counter++;
            }
        }

        for ($col = 'A'; $col !== 'P'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Cash Transaction.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
