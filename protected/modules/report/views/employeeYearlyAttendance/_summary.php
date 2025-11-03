<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 10% }
    .width1-2 { width: 10% }
    .width1-3 { width: 10% }

'); ?>

<fieldset>
    <legend>Attendance Tahunan</legend>
    <table class="report">
        <thead style="position: sticky; top: 0">
            <tr id="header1">
                <th class="width1-1">Bulan</th>
                <?php foreach ($onleaveCategories as $onleaveCategory): ?>
                    <th class="width1-2"><?php echo CHtml::encode(CHtml::value($onleaveCategory, 'name')); ?></th>
                <?php endforeach; ?>
                <th>Tanpa Keterangan</th>
                <th>Total H. Kerja</th>
                <th>Terlambat</th>
                <th>Libur Mingguan</th>
                <th>Libur Nasional</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($employee !== null): ?>
                <?php for ($month = 1; $month <= 12; $month++): ?>
                    <?php $daysOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); ?>
                    <?php $holidaysCount = 0; ?>
                    <?php for ($day = 1; $day <= $daysOfMonth; $day++): ?>
                        <?php $date = $year . '-' . $month . '-' . $day; ?>
                        <?php $dayOfWeekNum = date('w', strtotime($date)); ?>
                        <?php if (!empty($employee->id) && (int) $dayOfWeekNum === $dayOfWeekList[$employee->off_day]): ?>
                            <?php $holidaysCount++; ?>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php $nationalHolidaysCount = PublicDayOff::model()->count(array(
                        'condition' => 'YEAR(t.date) = :year AND MONTH(t.date) = :month', 
                        'params' => array(':year' => $year, ':month' => $month),
                    )); ?>

                    <tr class="items1">
                        <td style="text-align: left"><?php echo CHtml::encode($monthList[$month]); ?></td>
                        <?php foreach ($onleaveCategories as $onleaveCategory): ?>
                            <?php $days = isset($employeeYearlyAttendanceData[$month][$onleaveCategory->id]['days']) ? $employeeYearlyAttendanceData[$month][$onleaveCategory->id]['days'] : '0'; ?>
                            <td style="text-align: right"><?php echo CHtml::encode($days); ?></td>
                        <?php endforeach; ?>
                        <?php $lateDays = isset($employeeYearlyAttendanceData[$month][16]['late_days']) ? $employeeYearlyAttendanceData[$month][16]['late_days'] : '0'; ?>
                        <?php $workingDays = $daysOfMonth - $holidaysCount - $nationalHolidaysCount; ?>
                        <?php $recordedDays = isset($employeeDaysCountData[$month]) ? $employeeDaysCountData[$month] : '0'; ?>
                        <?php $nonRecordedDays = $workingDays - $recordedDays; ?>
                        <td style="text-align: right"><?php echo CHtml::encode($nonRecordedDays); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode($workingDays); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode($lateDays); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode($holidaysCount); ?></td>
                        <td style="text-align: right"><?php echo CHtml::encode($nationalHolidaysCount); ?></td>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
        </tbody>
    </table>
</fieldset>