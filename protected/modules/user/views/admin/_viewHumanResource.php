<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[humanResourceHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Master Employee</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Master Kategori Ketidakhadiran</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterEmployeeOnleaveCategoryApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Public Holiday</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterHolidayCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterHolidayEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterHolidayView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[masterHolidayApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Absensi Karyawan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[employeeTimesheetCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[employeeTimesheetEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[employeeTimesheetView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Cuti Karyawan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[employeeLeaveApplicationCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[employeeLeaveApplicationEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[employeeLeaveApplicationView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Rekap Absensi</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[absencyReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Payroll</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[payrollReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>