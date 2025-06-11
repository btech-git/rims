<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][managerFront]", CHtml::resolveValue($model, "roles[managerFront]"), array('id' => 'User_roles_' . $counter, 'value' => 'managerFront')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Kasir</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashierFrontCreate]", CHtml::resolveValue($model, "roles[cashierFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierFrontCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashierFrontEdit]", CHtml::resolveValue($model, "roles[cashierFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierFrontEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashierFrontSupervisor]", CHtml::resolveValue($model, "roles[cashierFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierFrontSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Registration</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][registrationTransactionFrontCreate]", CHtml::resolveValue($model, "roles[registrationTransactionFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'registrationTransactionFrontCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][registrationTransactionFrontEdit]", CHtml::resolveValue($model, "roles[registrationTransactionFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'registrationTransactionFrontEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][registrationTransactionFrontSupervisor]", CHtml::resolveValue($model, "roles[registrationTransactionFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'registrationTransactionFrontSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Estimasi</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleEstimationFrontCreate]", CHtml::resolveValue($model, "roles[saleEstimationFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleEstimationFrontCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleEstimationFrontEdit]", CHtml::resolveValue($model, "roles[saleEstimationFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleEstimationFrontEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleEstimationFrontSupervisor]", CHtml::resolveValue($model, "roles[saleEstimationFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleEstimationFrontSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Invoice</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleInvoiceFrontCreate]", CHtml::resolveValue($model, "roles[saleInvoiceFrontCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceFrontCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleInvoiceFrontEdit]", CHtml::resolveValue($model, "roles[saleInvoiceFrontEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceFrontEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleInvoiceFrontSupervisor]", CHtml::resolveValue($model, "roles[saleInvoiceFrontSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceFrontSupervisor')); ?>
            </td>
        </tr>
    </tbody>
</table>