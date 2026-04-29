<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][humanResourceHead]", CHtml::resolveValue($model, "roles[humanResourceHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'humanResourceHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1. Data Karyawan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeCreate]", CHtml::resolveValue($model, "roles[masterEmployeeCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeEdit]", CHtml::resolveValue($model, "roles[masterEmployeeEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeView]", CHtml::resolveValue($model, "roles[masterEmployeeView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeApproval]", CHtml::resolveValue($model, "roles[masterEmployeeApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>2. Master Kategori Ketidakhadiran</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeOnleaveCategoryCreate]", CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeOnleaveCategoryCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeOnleaveCategoryEdit]", CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeOnleaveCategoryEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeOnleaveCategoryView]", CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeOnleaveCategoryView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterEmployeeOnleaveCategoryApproval]", CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterEmployeeOnleaveCategoryApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>3. Public Holiday</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterHolidayCreate]", CHtml::resolveValue($model, "roles[masterHolidayCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterHolidayCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterHolidayEdit]", CHtml::resolveValue($model, "roles[masterHolidayEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterHolidayEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterHolidayView]", CHtml::resolveValue($model, "roles[masterHolidayView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterHolidayView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][masterHolidayApproval]", CHtml::resolveValue($model, "roles[masterHolidayApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'masterHolidayApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>4. Absensi Karyawan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeTimesheetCreate]", CHtml::resolveValue($model, "roles[employeeTimesheetCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeTimesheetCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeTimesheetEdit]", CHtml::resolveValue($model, "roles[employeeTimesheetEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeTimesheetEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeTimesheetView]", CHtml::resolveValue($model, "roles[employeeTimesheetView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeTimesheetView'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>5. Pengajuan Cuti Karyawan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeLeaveApplicationCreate]", CHtml::resolveValue($model, "roles[employeeLeaveApplicationCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeLeaveApplicationCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeLeaveApplicationEdit]", CHtml::resolveValue($model, "roles[employeeLeaveApplicationEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeLeaveApplicationEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeLeaveApplicationView]", CHtml::resolveValue($model, "roles[employeeLeaveApplicationView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeLeaveApplicationView'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>6. Data Cuti Karyawan</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeLeaveApplicationEdit]", CHtml::resolveValue($model, "roles[employeeLeaveApplicationEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeLeaveApplicationEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeLeaveApplicationView]", CHtml::resolveValue($model, "roles[employeeLeaveApplicationView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeLeaveApplicationView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeLeaveApplicationApproval]", CHtml::resolveValue($model, "roles[employeeLeaveApplicationApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeLeaveApplicationApproval',
                )); ?>
            </td>
        </tr>
        <tr>
            <td>7. Payroll</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][payrollReport]", CHtml::resolveValue($model, "roles[payrollReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'payrollReport'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>8. Jadwal Karyawan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeScheduleReport]", CHtml::resolveValue($model, "roles[employeeScheduleReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeScheduleReport'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>9. Rekap Absensi Karyawan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeAbsencyReport]", CHtml::resolveValue($model, "roles[employeeAbsencyReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeAbsencyReport'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>10. Absensi Karyawan Tahunan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][yearlyEmployeeAbsencyReport]", CHtml::resolveValue($model, "roles[yearlyEmployeeAbsencyReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'yearlyEmployeeAbsencyReport'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>11. Ulang Tahun Karyawan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][employeeBirthdateReport]", CHtml::resolveValue($model, "roles[employeeBirthdateReport]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'employeeBirthdateReport'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>