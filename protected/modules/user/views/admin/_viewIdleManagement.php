<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][idleManagement]", CHtml::resolveValue($model, "roles[idleManagement]"), array('id' => 'User_roles_' . $counter, 'value' => 'idleManagement')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Management</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>BR Mechanic POV</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brMechanicCreate]", CHtml::resolveValue($model, "roles[brMechanicCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brMechanicEdit]", CHtml::resolveValue($model, "roles[brMechanicEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][brMechanicApproval]", CHtml::resolveValue($model, "roles[brMechanicApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>GR Mechanic POV</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grMechanicCreate]", CHtml::resolveValue($model, "roles[grMechanicCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grMechanicEdit]", CHtml::resolveValue($model, "roles[grMechanicEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][grMechanicApproval]", CHtml::resolveValue($model, "roles[grMechanicApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Cuti Karyawan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeDayoffCreate]", CHtml::resolveValue($model, "roles[employeeDayoffCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'employeeDayoffCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeDayoffEdit]", CHtml::resolveValue($model, "roles[employeeDayoffEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'employeeDayoffEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][employeeDayoffApproval]", CHtml::resolveValue($model, "roles[employeeDayoffApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'employeeDayoffApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>Daftar Kehadiran</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][attendanceReport]", CHtml::resolveValue($model, "roles[attendanceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'attendanceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Absensi</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][absencyReport]", CHtml::resolveValue($model, "roles[absencyReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'absencyReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Gaji</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][payrollReport]", CHtml::resolveValue($model, "roles[payrollReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'payrollReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Mechanic Report</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][mechanicPerformanceReport]", CHtml::resolveValue($model, "roles[mechanicPerformanceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'mechanicPerformanceReport')); ?>
            </td>
        </tr>
    </tbody>
</table>