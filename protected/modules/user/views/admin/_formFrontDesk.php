<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][frontOfficeHead]", CHtml::resolveValue($model, "roles[frontOfficeHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'frontOfficeHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1. Estimasi</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleEstimationCreate]", CHtml::resolveValue($model, "roles[saleEstimationCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleEstimationCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleEstimationEdit]", CHtml::resolveValue($model, "roles[saleEstimationEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleEstimationEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleEstimationView]", CHtml::resolveValue($model, "roles[saleEstimationView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleEstimationView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleEstimationSupervisor]", CHtml::resolveValue($model, "roles[saleEstimationSupervisor]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleEstimationSupervisor'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>2. General Repair</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalRepairCreate]", CHtml::resolveValue($model, "roles[generalRepairCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'generalRepairCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalRepairEdit]", CHtml::resolveValue($model, "roles[generalRepairEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'generalRepairEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalRepairView]", CHtml::resolveValue($model, "roles[generalRepairView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'generalRepairView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalRepairSupervisor]", CHtml::resolveValue($model, "roles[generalRepairSupervisor]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'generalRepairSupervisor'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>3. Body Repair</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][bodyRepairCreate]", CHtml::resolveValue($model, "roles[bodyRepairCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'bodyRepairCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][bodyRepairEdit]", CHtml::resolveValue($model, "roles[bodyRepairEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'bodyRepairEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][bodyRepairView]", CHtml::resolveValue($model, "roles[bodyRepairView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'bodyRepairView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][bodyRepairSupervisor]", CHtml::resolveValue($model, "roles[bodyRepairSupervisor]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'bodyRepairSupervisor'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>4. Permintaan Harga</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][pricingRequestCreate]", CHtml::resolveValue($model, "roles[pricingRequestCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'pricingRequestCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][pricingRequestEdit]", CHtml::resolveValue($model, "roles[pricingRequestEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'pricingRequestEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][pricingRequestView]", CHtml::resolveValue($model, "roles[pricingRequestView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'pricingRequestView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][pricingRequestApproval]", CHtml::resolveValue($model, "roles[pricingRequestApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'pricingRequestApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>5. Outstanding Registration</td>
            <td style="text-align: center">
                <?php //echo CHtml::checkBox("User[roles][pricingRequestCreate]", CHtml::resolveValue($model, "roles[pricingRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'pricingRequestCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo CHtml::checkBox("User[roles][pricingRequestEdit]", CHtml::resolveValue($model, "roles[pricingRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'pricingRequestEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][outstandingRegistrationView]", CHtml::resolveValue($model, "roles[outstandingRegistrationView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'outstandingRegistrationView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php //echo CHtml::checkBox("User[roles][pricingRequestApproval]", CHtml::resolveValue($model, "roles[pricingRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'pricingRequestApproval')); ?>
            </td>
        </tr>
        <tr>
            <td>6. Inspeksi Kendaraan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][inspectionCreate]", CHtml::resolveValue($model, "roles[inspectionCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'inspectionCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][inspectionEdit]", CHtml::resolveValue($model, "roles[inspectionEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'inspectionEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][inspectionView]", CHtml::resolveValue($model, "roles[inspectionView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'inspectionView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][inspectionApproval]", CHtml::resolveValue($model, "roles[inspectionApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'inspectionApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>7. Vehicle System Check</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][systemCheckCreate]", CHtml::resolveValue($model, "roles[systemCheckCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'systemCheckCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][systemCheckEdit]", CHtml::resolveValue($model, "roles[systemCheckEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'systemCheckEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][systemCheckView]", CHtml::resolveValue($model, "roles[systemCheckView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'systemCheckView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][systemCheckApproval]", CHtml::resolveValue($model, "roles[systemCheckApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'systemCheckApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>8. Work Order Active</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderView]", CHtml::resolveValue($model, "roles[workOrderView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'workOrderView',
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>9. Outstanding Work Order</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][outstandingWorkOrderView]", CHtml::resolveValue($model, "roles[outstandingWorkOrderView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'outstandingWorkOrderView'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>10. Kasir</td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierCreate]", CHtml::resolveValue($model, "roles[cashierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierCreate')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierEdit]", CHtml::resolveValue($model, "roles[cashierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierEdit')); ?></td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashierView]", CHtml::resolveValue($model, "roles[cashierView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cashierView',
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>11. Daftar Antrian Customer</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][customerQueueView]", CHtml::resolveValue($model, "roles[customerQueueView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'customerQueueView'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>12. Follow Up Warranty</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][customerFollowUp]", CHtml::resolveValue($model, "roles[customerFollowUp]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'customerFollowUp'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>13. Follow Up Service</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][serviceFollowUp]", CHtml::resolveValue($model, "roles[serviceFollowUp]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'serviceFollowUp'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>14. Status Kendaraan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][vehicleStatusView]", CHtml::resolveValue($model, "roles[vehicleStatusView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'vehicleStatusView',
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
    </tbody>
</table>