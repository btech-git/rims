<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">&nbsp;</th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseHead]", CHtml::resolveValue($model, "roles[purchaseHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'purchaseHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="4" style="text-align: center; font-weight: bold; background-color: greenyellow">Pembelian</td>
        </tr>
        <tr>
            <td>Order Permintaan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][requestOrderCreate]", CHtml::resolveValue($model, "roles[requestOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][requestOrderEdit]", CHtml::resolveValue($model, "roles[requestOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][requestOrderApproval]", CHtml::resolveValue($model, "roles[requestOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][requestOrderSupervisor]", CHtml::resolveValue($model, "roles[requestOrderSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Order Pembelian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseOrderCreate]", CHtml::resolveValue($model, "roles[purchaseOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseOrderEdit]", CHtml::resolveValue($model, "roles[purchaseOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseOrderApproval]", CHtml::resolveValue($model, "roles[purchaseOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseOrderSupervisor]", CHtml::resolveValue($model, "roles[purchaseOrderSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][salesHead]", CHtml::resolveValue($model, "roles[salesHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'salesHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="4" style="text-align: center; font-weight: bold; background-color: greenyellow">Penjualan</td>
        </tr>
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
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentHead]", CHtml::resolveValue($model, "roles[paymentHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'paymentHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Pelunasan</td>
        </tr>
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
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashierHead]", CHtml::resolveValue($model, "roles[cashierHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'cashierHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Tunai</td>
        </tr>
        <tr>
            <td>Transaksi Kas</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashTransactionCreate]", CHtml::resolveValue($model, "roles[cashTransactionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashTransactionEdit]", CHtml::resolveValue($model, "roles[cashTransactionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashTransactionApproval]", CHtml::resolveValue($model, "roles[cashTransactionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashTransactionSupervisor]", CHtml::resolveValue($model, "roles[cashTransactionSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionSupervisor')); ?>
            </td>
        </tr>
        <tr>
            <td>Jurnal Umum</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalCreate]", CHtml::resolveValue($model, "roles[adjustmentJournalCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalCreate')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalEdit]", CHtml::resolveValue($model, "roles[adjustmentJournalEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalEdit')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalApproval]", CHtml::resolveValue($model, "roles[adjustmentJournalApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalApproval')); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalSupervisor]", CHtml::resolveValue($model, "roles[adjustmentJournalSupervisor]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalSupervisor')); ?>
            </td>
        </tr>
    </tbody>
</table>