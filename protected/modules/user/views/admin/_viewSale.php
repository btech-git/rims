<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][salesHead]", CHtml::resolveValue($model, "roles[salesHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'salesHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Penjualan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleOrderCreate]", CHtml::resolveValue($model, "roles[saleOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleOrderEdit]", CHtml::resolveValue($model, "roles[saleOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleOrderApproval]", CHtml::resolveValue($model, "roles[saleOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderApproval')); ?></td>
        </tr>
        <tr>
            <td>Faktur Penjualan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleInvoiceCreate]", CHtml::resolveValue($model, "roles[saleInvoiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleInvoiceEdit]", CHtml::resolveValue($model, "roles[saleInvoiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][saleInvoiceApproval]", CHtml::resolveValue($model, "roles[saleInvoiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceApproval')); ?></td>
        </tr>
    </tbody>
</table>