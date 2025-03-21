<?php

class PaymentMonthlyController extends Controller {

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
        
        $paymentTypes = PaymentType::model()->findAll(array('condition' => 'id NOT IN (2, 12)'));
        
        $paymentInByTypeList = PaymentIn::getPaymentByTypeList($month, $year, $branchId);
        $paymentOutByTypeList = PaymentOut::getPaymentByTypeList($month, $year, $branchId);
        
        $paymentTypeIdList = array();
        foreach ($paymentTypes as $paymentType) {
            $paymentTypeIdList[] = $paymentType->id;
        }
        
        $paymentInList = array();
        $lastPaymentInDate = '';
        foreach ($paymentInByTypeList as $paymentInByTypeRow) {
            if ($lastPaymentInDate !== $paymentInByTypeRow['payment_date']) {
                $paymentInList[$paymentInByTypeRow['payment_date']][0] = $paymentInByTypeRow['payment_date'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentInList[$paymentInByTypeRow['payment_date']][$paymentTypeId] = '0.00';
                }
            }
            $paymentInList[$paymentInByTypeRow['payment_date']][$paymentInByTypeRow['payment_type_id']] = $paymentInByTypeRow['total_amount'];
            $lastPaymentInDate = $paymentInByTypeRow['payment_date'];
        }

        
        $paymentOutList = array();
        $lastPaymentOutDate = '';
        foreach ($paymentOutByTypeList as $paymentOutByTypeRow) {
            if ($lastPaymentOutDate !== $paymentOutByTypeRow['payment_date']) {
                $paymentOutList[$paymentOutByTypeRow['payment_date']][0] = $paymentOutByTypeRow['payment_date'];
                foreach ($paymentTypeIdList as $paymentTypeId) {
                    $paymentOutList[$paymentOutByTypeRow['payment_date']][$paymentTypeId] = '0.00';
                }
            }
            $paymentOutList[$paymentOutByTypeRow['payment_date']][$paymentOutByTypeRow['payment_type_id']] = $paymentOutByTypeRow['total_amount'];
            $lastPaymentOutDate = $paymentOutByTypeRow['payment_date'];
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
                'paymentTypes' => $paymentTypes,
                'month' => $month,
                'year' => $year,
                'branchId' => $branchId,
            ));
        }

        $this->render('summary', array(
            'paymentInList' => $paymentInList,
            'paymentOutList' => $paymentOutList,
            'yearList' => $yearList,
            'paymentTypes' => $paymentTypes,
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
        $paymentTypes = $options['paymentTypes'];
        $month = $options['month'];
        $year = $options['year'];
        $branchId = $options['branchId'];
        
        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Laporan Payment Bulanan by Type');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Laporan Payment Bulanan by Type');

        $worksheet->mergeCells('A1:N1');
        $worksheet->mergeCells('A2:N2');
        $worksheet->mergeCells('A3:N3');
        $worksheet->mergeCells('A5:N5');

        $worksheet->getStyle('A1:N6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:N6')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'RAPERIND MOTOR ' . CHtml::encode(CHtml::value($branch, 'name')));
        $worksheet->setCellValue('A2', 'Laporan Payment Bulanan by Type');
        $worksheet->setCellValue('A3', CHtml::encode(strftime("%B",mktime(0,0,0,$month))) . ' ' . CHtml::encode($year));
        $worksheet->setCellValue('A5', 'Transaksi Kas Masuk');

        $worksheet->getStyle('A6:N6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $paymentDailyTotals = array();
        $columnCounter = 'B';
        foreach ($paymentTypes as $paymentType) {
            $worksheet->setCellValue("{$columnCounter}6", CHtml::encode(CHtml::value($paymentType, 'name')));
            $paymentDailyTotals[$paymentType->id] = '0.00'; 
            $columnCounter++;
        }
        $dailyTotal = '0.00';
        $worksheet->setCellValue("{$columnCounter}6", 'Total');
        $worksheet->getStyle('A6:N6')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 8;
        foreach ($paymentInList as $paymentInDate => $paymentInItem) {
            $columnCounter = 'B';
            $totalPerDate = '0.00';
            foreach ($paymentInItem as $paymentTypeId => $paymentInRetail) {
                if ($paymentTypeId > 0) {
                    $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentInRetail));
                    $paymentDailyTotals[$paymentTypeId] += $paymentInRetail;
                    $columnCounter++;
                } else {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($paymentInRetail));
                }
                if ($paymentTypeId > 0) {
                    $totalPerDate += $paymentInRetail;
                }
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($totalPerDate));
            $dailyTotal += $totalPerDate;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);
        $columnCounter = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly Cash');
        foreach ($paymentTypes as $paymentType) {
            $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentDailyTotals[$paymentType->id]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($dailyTotal));
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        $worksheet->mergeCells("A{$counter}:N{$counter}");
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->setCellValue("A{$counter}", 'Transaksi Kas Keluar');
        $counter++;

        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);
        $paymentDailyTotals = array();
        $columnCounter = 'B';
        foreach ($paymentTypes as $paymentType) {
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode(CHtml::value($paymentType, 'name')));
            $paymentDailyTotals[$paymentType->id] = '0.00'; 
            $columnCounter++;
        }
        $dailyTotal = '0.00';
        $worksheet->setCellValue("{$columnCounter}{$counter}", 'Total');
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        foreach ($paymentOutList as $paymentOutDate => $paymentOutItem) {
            $columnCounter = 'B';
            $totalPerDate = '0.00';
            foreach ($paymentOutItem as $paymentTypeId => $paymentOutRetail) {
                if ($paymentTypeId > 0) {
                    $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentOutRetail));
                    $paymentDailyTotals[$paymentTypeId] += $paymentOutRetail;
                    $columnCounter++;
                } else {
                    $worksheet->setCellValue("A{$counter}", CHtml::encode($paymentOutRetail));
                }
                if ($paymentTypeId > 0) {
                    $totalPerDate += $paymentOutRetail;
                }
            }
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($totalPerDate));
            $dailyTotal += $totalPerDate;

            $counter++;
        }
        
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A{$counter}:N{$counter}")->getFont()->setBold(true);
        $columnCounter = 'B';
        $worksheet->setCellValue("A{$counter}", 'Total Monthly Cash');
        foreach ($paymentTypes as $paymentType) {
            $worksheet->getStyle("{$columnCounter}{$counter}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($paymentDailyTotals[$paymentType->id]));
            $columnCounter++;
        }
        $worksheet->setCellValue("{$columnCounter}{$counter}", CHtml::encode($dailyTotal));
        $worksheet->getStyle("A{$counter}:N{$counter}")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $counter++;$counter++;

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }
        
        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Payment Bulanan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}