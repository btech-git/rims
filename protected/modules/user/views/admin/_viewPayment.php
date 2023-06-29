<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentHead]", CHtml::resolveValue($model, "roles[paymentHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'paymentHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentInCreate]", CHtml::resolveValue($model, "roles[paymentInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentInEdit]", CHtml::resolveValue($model, "roles[paymentInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentInApproval]", CHtml::resolveValue($model, "roles[paymentInApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentInSupervisor]", CHtml::resolveValue($model, "roles[paymentInSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentOutCreate]", CHtml::resolveValue($model, "roles[paymentOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentOutEdit]", CHtml::resolveValue($model, "roles[paymentOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentOutApproval]", CHtml::resolveValue($model, "roles[paymentOutApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentOutSupervisor]", CHtml::resolveValue($model, "roles[paymentOutSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutSupervisor')); ?>
            </td>
        </tr>
    </tbody>
</table>