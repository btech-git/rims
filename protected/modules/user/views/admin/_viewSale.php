<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][salesHead]", CHtml::resolveValue($model, "roles[salesHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'salesHead')); ?>
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
            <td>Order Penjualan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleOrderCreate]", CHtml::resolveValue($model, "roles[saleOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleOrderEdit]", CHtml::resolveValue($model, "roles[saleOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleOrderApproval]", CHtml::resolveValue($model, "roles[saleOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleOrderSupervisor]", CHtml::resolveValue($model, "roles[saleOrderSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Penjualan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleInvoiceCreate]", CHtml::resolveValue($model, "roles[saleInvoiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleInvoiceEdit]", CHtml::resolveValue($model, "roles[saleInvoiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceEdit')); ?>
            </td>
            <td></td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleInvoiceSupervisor]", CHtml::resolveValue($model, "roles[saleInvoiceSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Sub Pekerjaan Luar</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseCreate]", CHtml::resolveValue($model, "roles[workOrderExpenseCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderExpenseCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseEdit]", CHtml::resolveValue($model, "roles[workOrderExpenseEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderExpenseEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseApproval]", CHtml::resolveValue($model, "roles[workOrderExpenseApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderExpenseApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseSupervisor]", CHtml::resolveValue($model, "roles[workOrderExpenseSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderExpenseSupervisor')); ?>
            </td>
        </tr>
    </tbody>
</table>