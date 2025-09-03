<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">Laporan Rekap Daftar Hadir Karyawan</div>
    <div>
        <?php //echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('MMMM yyyy', strtotime($yearMonth))); ?>
        <?php echo 'Tanggal: ' . Yii::app()->dateFormatter->format("d MMMM yyyy", $startDate) . ' - ' . Yii::app()->dateFormatter->format("d MMMM yyyy", $endDate); ?>
    </div>
</div>

<br />

<table style="width: 100%; margin: 0 auto; border-spacing: 0pt">
    <thead>
        <tr>
            <th style="text-align: center">ID</th>
            <th style="text-align: center">NIP</th>
            <th style="text-align: center">Nama</th>
            <th style="text-align: center">Kehadiran</th>
            <th style="text-align: center">Cuti</th>
            <th style="text-align: center">Sakit</th>
            <th style="text-align: center">Izin</th>
            <th style="text-align: center">Libur</th>
            <th style="text-align: center">Dinas Luar</th>
            <th style="text-align: center">Tanpa Keterangan</th>
            <th style="text-align: center">Total H. Kerja</th>
            <th style="text-align: center">Terlambat</th>
            <th style="text-align: center">Lembur</th>
<!--            <th style="text-align: center">Izin 1/2 hari</th>
            <th style="text-align: center">SDSD</th>
            <th style="text-align: center">STSD</th>
            <th style="text-align: center">Alfa</th>
            <th style="text-align: center">Tidak Hadir</th>-->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employeeData as $employee): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($employee, 'id')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($employee, 'code')); ?></td>
                <td>
                    <?php echo CHtml::link($employee->name, Yii::app()->createUrl("report/employeeAttendance/attendanceDetail", array(
                        "EmployeeId" => $employee->id, 
                        "StartDate" => $startDate, 
                        "EndDate" => $endDate, 
                    )), array('target' => '_blank')); ?>
                </td>
                <td><?php echo CHtml::encode($employee->getTotalWorkingDay($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalPaidLeave($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalSickDay($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalFullDayLeave($startDate, $endDate)); ?></td>
                <td><?php //echo CHtml::encode($employee->getTotalDayOff($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalBusinessTripDay($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalMissing($startDate, $endDate)); ?></td>
                <td>30</td>
                <td><?php echo CHtml::encode($employee->getTotalLateDay($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalOvertimeDay($startDate, $endDate)); ?></td>
<!--                <td><?php /*echo CHtml::encode($employee->getTotalHalfDayLeave($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalSdsd($startDate, $endDate)); ?></td>
                <td><?php echo CHtml::encode($employee->getTotalStsd($startDate, $endDate));*/ ?></td>-->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>