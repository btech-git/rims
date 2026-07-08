<?php

class MonthlyEmployeeAttendanceController extends Controller {

    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {
        if ($filterChain->action->id === 'summary') {
            if (!(Yii::app()->user->checkAccess('employeeAbsencyReport'))) {
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
        $year = (isset($_GET['Year'])) ? $_GET['Year'] : $yearNow;
        $employeeId = (isset($_GET['EmployeeId'])) ? $_GET['EmployeeId'] : '';
        
        $monthlyEmployeeAttendanceSummary = EmployeeTimesheet::getMonthlyEmployeeAttendance($year, $month, $employeeId);
        
        $monthlyEmployeeAttendanceData = array();
        foreach ($monthlyEmployeeAttendanceSummary as $monthlyEmployeeAttendanceSummaryItem) {
            $monthlyEmployeeAttendanceData[$monthlyEmployeeAttendanceSummaryItem['date']] = $monthlyEmployeeAttendanceSummaryItem;
        }
        
        $yearList = array();
        for ($y = $yearNow - 4; $y <= $yearNow; $y++) {
            $yearList[$y] = $y;
        }
        
        $dayNames = array(
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        );
        
        if (isset($_GET['ResetFilter'])) {
            $this->redirect(array('summary'));
        }
        
        if (isset($_GET['SaveExcel'])) {
            $this->saveToExcel($monthlyEmployeeAttendanceData, $month, $year, $dayNames, $employeeId);
        }
        
        $this->render('summary', array(
            'monthlyEmployeeAttendanceData' => $monthlyEmployeeAttendanceData,
            'yearList' => $yearList,
            'year' => $year,
            'month' => $month,
            'dayNames' => $dayNames,
            'employeeId' => $employeeId,
        ));
    }
    
    protected function saveToExcel($monthlyEmployeeAttendanceData, $month, $year, $dayNames, $employeeId) {
        set_time_limit(0);
        ini_set('memory_limit', '1024M');

        spl_autoload_unregister(array('YiiBase', 'autoload'));
        include_once Yii::getPathOfAlias('ext.phpexcel.Classes') . DIRECTORY_SEPARATOR . 'PHPExcel.php';
        spl_autoload_register(array('YiiBase', 'autoload'));

        $objPHPExcel = new PHPExcel();

        $documentProperties = $objPHPExcel->getProperties();
        $documentProperties->setCreator('Raperind Motor');
        $documentProperties->setTitle('Kehadiran Hari Kerja');

        $worksheet = $objPHPExcel->setActiveSheetIndex(0);
        $worksheet->setTitle('Kehadiran Hari Kerja');

        $worksheet->mergeCells('A1:J1');
        $worksheet->mergeCells('A2:J2');
        $worksheet->mergeCells('A3:J3');

        $worksheet->getStyle('A1:J5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $worksheet->getStyle('A1:J5')->getFont()->setBold(true);

        $employee = Employee::model()->findByPk($employeeId);
        $worksheet->setCellValue('A1', 'Raperind Motor ');
        $worksheet->setCellValue('A2', 'Kehadiran Hari Kerja ' . CHtml::value($employee, 'name'));
        $worksheet->setCellValue('A3', strftime("%B",mktime(0,0,0,$month)) . ' ' . $year);
        
        $worksheet->getStyle('A5:J5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
        $worksheet->setCellValue('A5', 'Tanggal');
        $worksheet->setCellValue('B5', 'Clock In');
        $worksheet->setCellValue('C5', 'Clock Out');
        $worksheet->setCellValue('D5', 'Telat');
        $worksheet->setCellValue('E5', 'Lama Kerja');
        $worksheet->setCellValue('F5', 'Izin/Cuti/Sakit');
        $worksheet->setCellValue('G5', 'Libur');
        $worksheet->setCellValue('H5', 'Tanpa Keterangan');
        $worksheet->setCellValue('I5', 'Lembur');
        $worksheet->setCellValue('J5', 'Status');
        $worksheet->getStyle('A5:J5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        $counter = 6;
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        if ($employee !== null) {
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $date = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);

                $worksheet->setCellValue("A{$counter}", $i);
                if (isset($monthlyEmployeeAttendanceData[$date])) {
                    $monthlyEmployeeAttendanceSummaryItem = $monthlyEmployeeAttendanceData[$date];
                    $employeeTimesheet = new EmployeeTimesheet();
                    $employeeTimesheet->duration_late = $monthlyEmployeeAttendanceSummaryItem['duration_late']; 
                    $employeeTimesheet->duration_work = $monthlyEmployeeAttendanceSummaryItem['duration_work'];
                    $employeeTimesheet->duration_overtime = $monthlyEmployeeAttendanceSummaryItem['duration_overtime'];
                    $worksheet->setCellValue("B{$counter}", $monthlyEmployeeAttendanceSummaryItem['clock_in']);
                    $worksheet->setCellValue("C{$counter}", $monthlyEmployeeAttendanceSummaryItem['clock_out']);
                    $worksheet->setCellValue("D{$counter}", (int) $monthlyEmployeeAttendanceSummaryItem['duration_late'] > 900 ? $employeeTimesheet->lateTimeDiff : '');
                    $worksheet->setCellValue("E{$counter}", $employeeTimesheet->workTimeDiff);
                    $worksheet->setCellValue("F{$counter}", $monthlyEmployeeAttendanceSummaryItem['remarks']);
                    $worksheet->setCellValue("G{$counter}", 'No');
                    $worksheet->setCellValue("H{$counter}", 'No');
                    $worksheet->setCellValue("I{$counter}", (int) $monthlyEmployeeAttendanceSummaryItem['duration_overtime'] > 900 ? $employeeTimesheet->overTimeDiff : '');
                    $worksheet->setCellValue("J{$counter}", $monthlyEmployeeAttendanceSummaryItem['category_name']);
                } else {
                    $dayName = date('l', strtotime($date));
                    $worksheet->setCellValue("B{$counter}", '00:00:00');
                    $worksheet->setCellValue("C{$counter}", '00:00:00');
                    $worksheet->setCellValue("E{$counter}", '00:00:00');
                    $worksheet->setCellValue("G{$counter}", $employee->off_day === $dayNames[$dayName] ? 'Yes' : 'No');
                    $worksheet->setCellValue("H{$counter}", $employee->off_day !== $dayNames[$dayName] ? 'Yes' : 'No');
                }
                
                $counter++;
            }
        }
        
        $worksheet->getStyle("A{$counter}:J{$counter}")->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);

        for ($col = 'A'; $col !== 'Z'; $col++) {
            $objPHPExcel->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        ob_end_clean();

        header('Content-type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=kehadiran_hari_kerja_" . $employee->name . ".xls");
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');

        Yii::app()->end();
    }
}