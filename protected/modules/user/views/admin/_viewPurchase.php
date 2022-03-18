<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][purchaseHead]", CHtml::resolveValue($model, "roles[purchaseHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'purchaseHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Permintaan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestOrderCreate]", CHtml::resolveValue($model, "roles[requestOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestOrderEdit]", CHtml::resolveValue($model, "roles[requestOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestOrderApproval]", CHtml::resolveValue($model, "roles[requestOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderApproval')); ?></td>
        </tr>
        <tr>
            <td>Order Pembelian</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseOrderCreate]", CHtml::resolveValue($model, "roles[purchaseOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseOrderEdit]", CHtml::resolveValue($model, "roles[purchaseOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseOrderApproval]", CHtml::resolveValue($model, "roles[purchaseOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderApproval')); ?></td>
        </tr>
    </tbody>
</table>