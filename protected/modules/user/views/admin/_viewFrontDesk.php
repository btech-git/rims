<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][frontOfficeHead]", CHtml::resolveValue($model, "roles[frontOfficeHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'frontOfficeHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>General Repair</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairCreate]", CHtml::resolveValue($model, "roles[generalRepairCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairCreate')); ?></td>
                <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairEdit]", CHtml::resolveValue($model, "roles[generalRepairEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][generalRepairApproval]", CHtml::resolveValue($model, "roles[generalRepairApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairApproval')); ?></td>
        </tr>
        <tr>
            <td>Body Repair</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairCreate]", CHtml::resolveValue($model, "roles[bodyRepairCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairEdit]", CHtml::resolveValue($model, "roles[bodyRepairEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][bodyRepairApproval]", CHtml::resolveValue($model, "roles[bodyRepairApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairApproval')); ?></td>
        </tr>
        <tr>
            <td>Inspeksi Kendaraan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionCreate]", CHtml::resolveValue($model, "roles[inspectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionEdit]", CHtml::resolveValue($model, "roles[inspectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][inspectionApproval]", CHtml::resolveValue($model, "roles[inspectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionApproval')); ?></td>
        </tr>
        <tr>
            <td>SPK</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][workOrderApproval]", CHtml::resolveValue($model, "roles[workOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderApproval')); ?></td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierCreate]", CHtml::resolveValue($model, "roles[cashierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierCreate')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierEdit]", CHtml::resolveValue($model, "roles[cashierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashierApproval]", CHtml::resolveValue($model, "roles[cashierApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierApproval')); ?></td>
        </tr>
        <tr>
            <td>Daftar Antrian Customer</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][customerQueueApproval]", CHtml::resolveValue($model, "roles[customerQueueApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'customerQueueApproval')); ?></td>
        </tr>
    </tbody>
</table>