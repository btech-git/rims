<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 3% }
    .width1-2 { width: 5% }
    .width1-3 { width: 5% }
    .width1-4 { width: 5% }
    .width1-5 { width: 10% }
    .width1-6 { width: 20% }
    .width1-7 { width: 10% }
    .width1-8 { width: 10% }
    .width1-9 { width: 10% }
    .width1-10 { width: 10% }

'); ?>

<div style="font-weight: bold; text-align: center">
    <?php $employee = Employee::model()->findByPk($employeeId); ?>
    <div style="font-size: larger">Raperind Motor</div>
    <div style="font-size: larger">Kehadiran Hari Kerja <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
    <div><?php echo CHtml::encode(strftime("%B",mktime(0,0,0,$month))); ?> <?php echo $year; ?></div>
</div>

<hr />

<?php $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1">Tanggal</th>
            <th class="width1-2">Clock In</th>
            <th class="width1-3">Clock Out</th>
            <th class="width1-4">Telat</th>
            <th class="width1-5">Lama Kerja</th>
            <th class="width1-6">Izin/Cuti/Sakit</th>
            <th class="width1-7">Libur</th>
            <th class="width1-8">Tanpa Keterangan</th>
            <th class="width1-9">Lembur</th>
            <th class="width1-10">Status</th>
        </tr>
    </thead>
    <?php if ($employee !== null): ?>
        <tbody>
            <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
                <?php $date = $year . '-' . $month . '-' . str_pad($i, 2, '0', STR_PAD_LEFT); ?>
                <tr class="items1">
                    <td style="text-align: center"><?php echo $i; ?></td>
                    <?php if (isset($monthlyEmployeeAttendanceData[$date])): ?>
                        <?php $monthlyEmployeeAttendanceSummaryItem = $monthlyEmployeeAttendanceData[$date]; ?>
                        <?php $employeeTimesheet = new EmployeeTimesheet(); ?>
                        <?php $employeeTimesheet->duration_late = $monthlyEmployeeAttendanceSummaryItem['duration_late']; ?>
                        <?php $employeeTimesheet->duration_work = $monthlyEmployeeAttendanceSummaryItem['duration_work']; ?>
                        <?php $employeeTimesheet->duration_overtime = $monthlyEmployeeAttendanceSummaryItem['duration_overtime']; ?>
                        <td><?php echo CHtml::encode($monthlyEmployeeAttendanceSummaryItem['clock_in']); ?></td>
                        <td><?php echo CHtml::encode($monthlyEmployeeAttendanceSummaryItem['clock_out']); ?></td>
                        <td><?php echo CHtml::encode((int) $monthlyEmployeeAttendanceSummaryItem['duration_late'] > 900 ? $employeeTimesheet->lateTimeDiff : ''); ?></td>
                        <td><?php echo CHtml::encode($employeeTimesheet->workTimeDiff); ?></td>
                        <td><?php echo CHtml::encode($monthlyEmployeeAttendanceSummaryItem['remarks']); ?></td>
                        <td>No</td>
                        <td>No</td>
                        <td><?php echo CHtml::encode((int) $monthlyEmployeeAttendanceSummaryItem['duration_overtime'] > 900 ? $employeeTimesheet->overTimeDiff : ''); ?></td>
                        <td><?php echo CHtml::encode($monthlyEmployeeAttendanceSummaryItem['category_name']); ?></td>
                    <?php else: ?>
                        <?php $dayName = date('l', strtotime($date)); ?>
                        <td>00:00:00</td>
                        <td>00:00:00</td>
                        <td></td>
                        <td>00:00:00</td>
                        <td></td>
                        <td><?php echo CHtml::encode($employee->off_day === $dayNames[$dayName] ? 'Yes' : 'No'); ?></td>
                        <td><?php echo CHtml::encode($employee->off_day !== $dayNames[$dayName] ? 'Yes' : 'No'); ?></td>
                        <td></td>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endfor; ?>
        </tbody>
    <?php endif; ?>
</table>