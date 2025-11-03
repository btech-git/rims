<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Rekap Daftar Hadir Karyawan</div>
    <div>
        <?php echo 'Tanggal: ' . Yii::app()->dateFormatter->format("d MMMM yyyy", $startDate) . ' - ' . Yii::app()->dateFormatter->format("d MMMM yyyy", $endDate); ?>
    </div>
</div>

<br />

<?php $dayOfWeekList = array_flip(array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')); ?>

<table style="width: 100%; margin: 0 auto; border-spacing: 0pt">
    <thead>
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">NIP</th>
            <th style="text-align: center">Nama</th>
            <th style="text-align: center">Cabang</th>
            <th style="text-align: center">Divisi</th>
            <th style="text-align: center">Posisi</th>
            <th style="text-align: center">Level</th>
            <?php foreach ($onleaveCategories as $onleaveCategory): ?>
                <th class="width1-2"><?php echo CHtml::encode(CHtml::value($onleaveCategory, 'name')); ?></th>
            <?php endforeach; ?>
            <th style="text-align: center">Tanpa Keterangan</th>
            <th style="text-align: center">Total H. Kerja</th>
            <th style="text-align: center">Libur Mingguan</th>
            <th style="text-align: center">Libur Nasional</th>
            <th style="text-align: center">Terlambat</th>
            <th style="text-align: center">Lembur</th>
        </tr>
    </thead>
    <tbody>
        <?php $daysOfPeriod = round(((strtotime($endDate) - strtotime($startDate)) / 86400)) + 1; ?>
        <?php foreach ($employeePeriodicallyAttendanceData as $employeeId => $employeePeriodicallyAttendanceItem): ?>
            <?php $holidaysCount = 0; ?>
            <?php for ($day = 0; $day < $daysOfPeriod; $day++): ?>
                <?php $date = date('Y-m-d', strtotime($startDate . " +{$day} day")); ?>
                <?php $dayOfWeekNum = date('w', strtotime($date)); ?>
                <?php $employee = Employee::model()->findByPk($employeeId); ?>
                <?php if (!empty($employee->id) && (int) $dayOfWeekNum === $dayOfWeekList[$employee->off_day]): ?>
                    <?php $holidaysCount++; ?>
                <?php endif; ?>
            <?php endfor; ?>
            <tr>
                <td><?php echo CHtml::encode($employeeId); ?></td>
                <td><?php echo CHtml::encode($employeePeriodicallyAttendanceItem['employee_code']); ?></td>
                <td>
                    <?php echo CHtml::link(CHtml::encode($employeePeriodicallyAttendanceItem['employee_name']), Yii::app()->createUrl("report/employeeAttendance/attendanceDetail", array(
                        "EmployeeId" => $employeeId, 
                        "StartDate" => $startDate, 
                        "EndDate" => $endDate, 
                    )), array('target' => '_blank')); ?>
                </td>
                <td><?php echo CHtml::encode($employeePeriodicallyAttendanceItem['branch_name']); ?></td>
                <td><?php echo CHtml::encode($employeePeriodicallyAttendanceItem['division_name']); ?></td>
                <td><?php echo CHtml::encode($employeePeriodicallyAttendanceItem['position_name']); ?></td>
                <td><?php echo CHtml::encode($employeePeriodicallyAttendanceItem['level_name']); ?></td>
                <?php foreach ($onleaveCategories as $onleaveCategory): ?>
                    <?php $days = isset($employeePeriodicallyAttendanceItem[$onleaveCategory->id]['days']) ? $employeePeriodicallyAttendanceItem[$onleaveCategory->id]['days'] : '0'; ?>
                    <td style="text-align: right"><?php echo CHtml::encode($days); ?></td>
                <?php endforeach; ?>
                <?php $lateDays = isset($employeePeriodicallyAttendanceItem[16]['late_days']) ? $employeePeriodicallyAttendanceItem[16]['late_days'] : '0'; ?>
                <?php $overtimeDays = isset($employeePeriodicallyAttendanceItem[16]['overtime_days']) ? $employeePeriodicallyAttendanceItem[16]['overtime_days'] : '0'; ?>
                <?php $workingDays = $daysOfPeriod - $holidaysCount - $nationalHolidaysCount; ?>
                <?php $recordedDays = isset($employeeDaysCountData[$employeeId]) ? $employeeDaysCountData[$employeeId] : '0'; ?>
                <?php $nonRecordedDays = $workingDays - $recordedDays; ?>
                <td style="text-align: right"><?php echo CHtml::encode($nonRecordedDays); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode($workingDays); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode($holidaysCount); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode($nationalHolidaysCount); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode($lateDays); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode($overtimeDays); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>