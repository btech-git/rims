<?php

class EmployeeAttendanceController extends Controller {

    public $layout = '//layouts/column1';
    public function filters() {
        return array(
//            'access',
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

        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');
        $branchId = isset($_GET['BranchId']) ? $_GET['BranchId'] : '';
        
        $employeePeriodicallyAttendance = EmployeeTimesheet::getEmployeePeriodicallyAttendance($startDate, $endDate, $branchId);
        
        $onleaveCategories = EmployeeOnleaveCategory::model()->findAllByAttributes(array('is_inactive' => 0), array('order' => 'is_onsite DESC, id ASC'));
        
        $employeePeriodicallyAttendanceData = array();
        foreach ($employeePeriodicallyAttendance as $employeePeriodicallyAttendanceItem) {
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']][$employeePeriodicallyAttendanceItem['employee_onleave_category_id']]['days'] = $employeePeriodicallyAttendanceItem['days'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']][$employeePeriodicallyAttendanceItem['employee_onleave_category_id']]['late_days'] = $employeePeriodicallyAttendanceItem['late_days'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']][$employeePeriodicallyAttendanceItem['employee_onleave_category_id']]['overtime_days'] = $employeePeriodicallyAttendanceItem['overtime_days'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']]['employee_name'] = $employeePeriodicallyAttendanceItem['employee_name'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']]['employee_code'] = $employeePeriodicallyAttendanceItem['employee_code'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']]['branch_name'] = $employeePeriodicallyAttendanceItem['branch_name'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']]['position_name'] = $employeePeriodicallyAttendanceItem['position_name'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']]['level_name'] = $employeePeriodicallyAttendanceItem['level_name'];
            $employeePeriodicallyAttendanceData[$employeePeriodicallyAttendanceItem['employee_id']]['division_name'] = $employeePeriodicallyAttendanceItem['division_name'];
        }
        
        $employeeDaysCountData = array();
        foreach ($employeePeriodicallyAttendance as $employeePeriodicallyAttendanceItem) {
            if (!isset($employeeDaysCountData[$employeePeriodicallyAttendanceItem['employee_id']])) {
                $employeeDaysCountData[$employeePeriodicallyAttendanceItem['employee_id']] = 0;
            }
            $employeeDaysCountData[$employeePeriodicallyAttendanceItem['employee_id']] += $employeePeriodicallyAttendanceItem['days'];
        }
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($employeePeriodicallyAttendanceData , $onleaveCategories, $employeeDaysCountData, $startDate, $endDate, $branchId);
        }

        $this->render('summary', array(
            'employeePeriodicallyAttendanceData' => $employeePeriodicallyAttendanceData,
            'onleaveCategories' => $onleaveCategories,
            'employeeDaysCountData' => $employeeDaysCountData,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'branchId' => $branchId,
        ));
    }

    public function actionAttendanceDetail() {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        $employeeId = (isset($_GET['EmployeeId'])) ? $_GET['EmployeeId'] : '';
        $startDate = (isset($_GET['StartDate'])) ? $_GET['StartDate'] : date('Y-m-d');
        $endDate = (isset($_GET['EndDate'])) ? $_GET['EndDate'] : date('Y-m-d');

        $employeeTimesheet = new EmployeeTimesheet('search');
        $employeeTimesheet->unsetAttributes();
        
        if (isset($_GET['EmployeeTimesheet'])) {
            $employeeTimesheet->attributes = $_GET['EmployeeTimesheet'];
        }

        $employeeTimesheetDataProvider = $employeeTimesheet->searchByReport();
        $employeeTimesheetDataProvider->criteria->addCondition("t.employee_id = :employee_id AND t.date BETWEEN :start_date AND :end_date");
        $employeeTimesheetDataProvider->criteria->params = array(
            ':employee_id' => $employeeId, 
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        $employee = Employee::model()->findByPk($employeeId);
        
//        if (isset($_GET['SaveToExcel'])) {
//            $this->saveToExcelTransactionJournal($transactionJournalSummary, $coaId, $startDate, $endDate, $branchId);
//        }

        $this->render('attendanceDetail', array(
            'employeeTimesheet' => $employeeTimesheet,
            'employeeTimesheetDataProvider' => $employeeTimesheetDataProvider,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'employeeId' => $employeeId,
            'employee' => $employee,
        ));
    }

    protected function saveToExcel($employeePeriodicallyAttendanceData , $onleaveCategories, $employeeDaysCountData, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Rekap Daftar Hadir Karyawan');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Rekap Daftar Hadir Karyawan');

        $worksheet->mergeCells('A1:Q1');
        $worksheet->mergeCells('A2:Q2');
        $worksheet->mergeCells('A3:Q3');
       
        $worksheet->getStyle('A1:Q3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:Q3')->getFont()->setBold(true);

        $branch = Branch::model()->findByPk($branchId);
        $worksheet->setCellValue('A1', 'Raperind Motor ' . CHtml::encode(($branch === null) ? '' : $branch->name));
        $worksheet->setCellValue('A2', 'Laporan Rekap Daftar Hadir Karyawan');
        $worksheet->setCellValue('A3', 'Periode: ' . $startDateString . ' - ' . $endDateString);

        $column = 'H';
        $worksheet->setCellValue('A5', 'ID');
        $worksheet->setCellValue('B5', 'NIP');
        $worksheet->setCellValue('C5', 'Nama');
        $worksheet->setCellValue('D5', 'Cabang');
        $worksheet->setCellValue('E5', 'Divisi');
        $worksheet->setCellValue('F5', 'Posisi');
        $worksheet->setCellValue('G5', 'Level');
        foreach ($onleaveCategories as $onleaveCategory) {
            $worksheet->setCellValue("{$column}5", CHtml::value($onleaveCategory, 'name'));
            $column++;
        }
        $worksheet->setCellValue("{$column}5", 'Tanpa Keterangan');
        $column++;
        $worksheet->setCellValue("{$column}5", 'Total H. Kerja');
        $column++;
        $worksheet->setCellValue("{$column}5", 'Libur');
        $column++;
        $worksheet->setCellValue("{$column}5", 'Terlambat');
        $column++;
        $worksheet->setCellValue("{$column}5", 'Lembur');

        $worksheet->getStyle("A5:{$column}5")->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle("A5:{$column}5")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->getStyle('A5:{$column}5')->getFont()->setBold(true);
        
        $counter = 7;

        $dayOfWeekList = array_flip(array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'));
        $daysOfPeriod = round(((strtotime($endDate) - strtotime($startDate)) / 86400)) + 1;
        
        foreach ($employeePeriodicallyAttendanceData as $employeeId => $employeePeriodicallyAttendanceItem) {
            $holidaysCount = 0;
            for ($day = 0; $day < $daysOfPeriod; $day++) {
                $date = date('Y-m-d', strtotime($startDate . " +{$day} day"));
                $dayOfWeekNum = date('w', strtotime($date));
                $employee = Employee::model()->findByPk($employeeId);
                if (!empty($employee->id) && (int) $dayOfWeekNum === $dayOfWeekList[$employee->off_day]) {
                    $holidaysCount++;
                }
            }
        
            $column = 'H';
            $worksheet->setCellValue("A{$counter}", CHtml::value($employee, 'id'));
            $worksheet->setCellValue("B{$counter}", CHtml::value($employee, 'code'));
            $worksheet->setCellValue("C{$counter}", CHtml::value($employee, 'name'));
            $worksheet->setCellValue("D{$counter}", CHtml::value($employee, 'branch.code'));
            $worksheet->setCellValue("E{$counter}", CHtml::value($employee, 'division.name'));
            $worksheet->setCellValue("F{$counter}", CHtml::value($employee, 'position.name'));
            $worksheet->setCellValue("G{$counter}", CHtml::value($employee, 'level.name'));
            foreach ($onleaveCategories as $onleaveCategory) {
                $days = isset($employeePeriodicallyAttendanceItem[$onleaveCategory->id]['days']) ? $employeePeriodicallyAttendanceItem[$onleaveCategory->id]['days'] : '0';
                $worksheet->setCellValue("{$column}{$counter}", $days);
                $column++;
            }
            $lateDays = isset($employeePeriodicallyAttendanceItem[16]['late_days']) ? $employeePeriodicallyAttendanceItem[16]['late_days'] : '0';
            $overtimeDays = isset($employeePeriodicallyAttendanceItem[16]['overtime_days']) ? $employeePeriodicallyAttendanceItem[16]['overtime_days'] : '0';
            $workingDays = $daysOfPeriod - $holidaysCount;
            $recordedDays = isset($employeeDaysCountData[$employeeId]) ? $employeeDaysCountData[$employeeId] : '0';
            $nonRecordedDays = $workingDays - $recordedDays;
            $worksheet->setCellValue("{$column}{$counter}", $nonRecordedDays);
            $column++;
            $worksheet->setCellValue("{$column}{$counter}", $workingDays);
            $column++;
            $worksheet->setCellValue("{$column}{$counter}", $holidaysCount);
            $column++;
            $worksheet->setCellValue("{$column}{$counter}", $lateDays);
            $column++;
            $worksheet->setCellValue("{$column}{$counter}", $overtimeDays);

            $counter++;
        }
        
        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="rekap_absensi_karyawan.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
    
    protected function saveToExcelTransactionJournal($transactionJournalSummary, $coaId, $startDate, $endDate, $branchId) {
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
        $documentProperties->setTitle('Journal Detail Transaction');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Journal Detail Transaction');

        $worksheet->mergeCells('A1:F1');
        $worksheet->mergeCells('A2:F2');
        $worksheet->mergeCells('A3:F3');
        $worksheet->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:F5')->getFont()->setBold(true);

        $coa = Coa::model()->findByPk($coaId);
        $worksheet->setCellValue('A1', 'Journal Detail Transaction');
        $worksheet->setCellValue('A2', CHtml::encode(CHtml::value($coa, 'codeName')));
        $worksheet->setCellValue('A3', $startDateString . ' - ' . $endDateString);
        
        $worksheet->setCellValue('A5', 'Transaksi #');
        $worksheet->setCellValue('B5', 'Tanggal');
        $worksheet->setCellValue('C5', 'Description');
        $worksheet->setCellValue('D5', 'Memo');
        $worksheet->setCellValue('E5', 'Debet');
        $worksheet->setCellValue('F5', 'Kredit');
        $counter = 7;

        $totalDebit = '0.00';
        $totalCredit = '0.00';
        foreach ($transactionJournalSummary->dataProvider->data as $header) {
            $debitAmount = $header->debet_kredit == "D" ? CHtml::encode(CHtml::value($header, 'total')) : 0;
            $creditAmount = $header->debet_kredit == "K" ? CHtml::encode(CHtml::value($header, 'total')) : 0;
            
            $worksheet->setCellValue("A{$counter}", CHtml::encode(CHtml::value($header, 'kode_transaksi')));
            $worksheet->setCellValue("B{$counter}", CHtml::encode(CHtml::value($header, 'tanggal_transaksi')));
            $worksheet->setCellValue("C{$counter}", CHtml::encode(CHtml::value($header, 'transaction_subject')));
            $worksheet->setCellValue("D{$counter}", CHtml::encode(CHtml::value($header, 'transaction_type')));
            $worksheet->setCellValue("E{$counter}", $debitAmount);
            $worksheet->setCellValue("F{$counter}", $creditAmount);

            $totalDebit += $debitAmount;
            $totalCredit += $creditAmount;
            $counter++;
        }
        
        $worksheet->setCellValue("D{$counter}", 'TOTAL');
        $worksheet->setCellValue("E{$counter}", $totalDebit);
        $worksheet->setCellValue("F{$counter}", $totalCredit);

        for ($col = 'A'; $col !== 'J'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();
        // We'll be outputting an excel file
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Journal Detail Transaction.xls"');
        header('Cache-Control: max-age=0');
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}
