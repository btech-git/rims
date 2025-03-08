<?php

class PaymentByBankMonthlyController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('director') )) {
                $this->redirect(array('/site/login'));
            }
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
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $coaList = Coa::model()->findAll(array('condition' => 't.coa_sub_category_id IN (1, 2, 3) AND t.status = "Approved"'));
        
        $paymentInByBankList = JurnalUmum::getPaymentInByBankList($month, $year, $branchId);
        $paymentOutByBankList = JurnalUmum::getPaymentOutByBankList($month, $year, $branchId);
        
        $coaIdList = array();
        foreach ($coaList as $coa) {
            $coaIdList[] = $coa->id;
        }
        
        $paymentInList = array();
        $lastPaymentInDate = '';
        foreach ($paymentInByBankList as $paymentInByBankRow) {
            if ($lastPaymentInDate !== $paymentInByBankRow['tanggal_transaksi']) {
                $paymentInList[$paymentInByBankRow['tanggal_transaksi']][0] = $paymentInByBankRow['tanggal_transaksi'];
                foreach ($coaIdList as $coaId) {
                    $paymentInList[$paymentInByBankRow['tanggal_transaksi']][$coaId] = '0.00';
                }
            }
            $paymentInList[$paymentInByBankRow['tanggal_transaksi']][$paymentInByBankRow['coa_id']] = $paymentInByBankRow['total_amount'];
            $lastPaymentInDate = $paymentInByBankRow['tanggal_transaksi'];
        }

        
        $paymentOutList = array();
        $lastPaymentOutDate = '';
        foreach ($paymentOutByBankList as $paymentOutByBankRow) {
            if ($lastPaymentOutDate !== $paymentOutByBankRow['tanggal_transaksi']) {
                $paymentOutList[$paymentOutByBankRow['tanggal_transaksi']][0] = $paymentOutByBankRow['tanggal_transaksi'];
                foreach ($coaIdList as $coaId) {
                    $paymentOutList[$paymentOutByBankRow['tanggal_transaksi']][$coaId] = '0.00';
                }
            }
            $paymentOutList[$paymentOutByBankRow['tanggal_transaksi']][$paymentOutByBankRow['coa_id']] = $paymentOutByBankRow['total_amount'];
            $lastPaymentOutDate = $paymentOutByBankRow['tanggal_transaksi'];
        }

        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel(array(
                'paymentInList' => $paymentInList,
                'paymentOutList' => $paymentOutList,
                'coaList' => $coaList,
                'month' => $month,
                'year' => $year,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'paymentInList' => $paymentInList,
            'paymentOutList' => $paymentOutList,
            'yearList' => $yearList,
            'coaList' => $coaList,
            'month' => $month,
            'year' => $year,
            'numberOfDays' => $numberOfDays,
            'branchId' => $branchId,
        ));
    }
    
    protected function saveToExcel(array $options = array()) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $paymentInList = $options['paymentInList'];
        $paymentOutList = $options['paymentOutList'];
        $coaList = $options['coaList'];
        $month = $options['month'];
        $year = $options['year'];
        $branchId = $options['branchId'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Bank Bulanan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Bank Bulanan');

        $worksheet->mergeCells('A1:Z1');
        $worksheet->mergeCells('A2:Z2');
        $worksheet->mergeCells('A3:Z3');
        $worksheet->mergeCells('A5:Z5');

        $worksheet->getStyle('A1:Z6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Z6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Bank Bulanan');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));
        $worksheet->setCellValue('A5', 'Transaksi Bank Masuk');

        $worksheet->getStyle('A6:Z6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $paymentDailyTotals = array();
        $columnCounter = 'B';
        foreach ($coaList as $coa) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::encode(CHtml::value($coa, 'name')));
            $paymentDailyTotals[$coa->id] = '0.00'; 
            $columnCounter++;
        }
        $dailyTotal = '0.00';
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $worksheet->getStyle('A6:Z6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($paymentInList as $paymentInDate => $paymentInItem) {
            $columnCounter = 'B';
            $totalPerDate = '0.00';
            foreach ($paymentInItem as $coaId => $paymentInRetail) {
                if ($coaId > 0) {
                    $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentInRetail));
                    $paymentDailyTotals[$coaId] += $paymentInRetail;
                    $columnCounter++;
                } else {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($paymentInRetail));
                }
                if ($coaId > 0) {
                    $totalPerDate += $paymentInRetail;
                }
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($totalPerDate));
            $dailyTotal += $totalPerDate;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getFont()->setBold(true);
        $columnCounter = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly');
        foreach ($coaList as $coa) {
            $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentDailyTotals[$coa->id]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($dailyTotal));
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:Z{$counter}");
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Transaksi Bank Keluar');
        $counter++;

        $worksheet->getStyle("A{$counter}:Z{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getFont()->setBold(true);
        $paymentDailyTotals = array();
        $columnCounter = 'B';
        foreach ($coaList as $coa) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode(CHtml::value($coa, 'name')));
            $paymentDailyTotals[$coa->id] = '0.00'; 
            $columnCounter++;
        }
        $dailyTotal = '0.00';
        $worksheet->setCellValue("{$columnCounter}{$counter}", 'Total');
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        foreach ($paymentOutList as $paymentOutDate => $paymentOutItem) {
            $columnCounter = 'B';
            $totalPerDate = '0.00';
            foreach ($paymentOutItem as $coaId => $paymentOutRetail) {
                if ($coaId > 0) {
                    $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentOutRetail));
                    $paymentDailyTotals[$coaId] += $paymentOutRetail;
                    $columnCounter++;
                } else {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($paymentOutRetail));
                }
                if ($coaId > 0) {
                    $totalPerDate += $paymentOutRetail;
                }
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($totalPerDate));
            $dailyTotal += $totalPerDate;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getFont()->setBold(true);
        $columnCounter = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly');
        foreach ($coaList as $coa) {
            $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentDailyTotals[$coa->id]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($dailyTotal));
        $worksheet->getStyle("A{$counter}:Z{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Bank Bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}