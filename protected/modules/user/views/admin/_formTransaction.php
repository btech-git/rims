<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">&nbsp;</th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseHead]", CHtml::resolveValue($model, "roles[purchaseHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'purchaseHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Pembelian</td>
        </tr>
        <tr>
            <td>1. Order Permintaan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][requestOrderCreate]", CHtml::resolveValue($model, "roles[requestOrderCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'requestOrderCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][requestOrderEdit]", CHtml::resolveValue($model, "roles[requestOrderEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'requestOrderEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][requestOrderView]", CHtml::resolveValue($model, "roles[requestOrderView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'requestOrderView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][requestOrderApproval]", CHtml::resolveValue($model, "roles[requestOrderApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'requestOrderApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>2. Order Pembelian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseOrderCreate]", CHtml::resolveValue($model, "roles[purchaseOrderCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'purchaseOrderCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseOrderEdit]", CHtml::resolveValue($model, "roles[purchaseOrderEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'purchaseOrderEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseOrderView]", CHtml::resolveValue($model, "roles[purchaseOrderView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'purchaseOrderView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseOrderApproval]", CHtml::resolveValue($model, "roles[purchaseOrderApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'purchaseOrderApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][salesHead]", CHtml::resolveValue($model, "roles[salesHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'salesHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Penjualan</td>
        </tr>
        <tr>
            <td>3. Order Penjualan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleOrderCreate]", CHtml::resolveValue($model, "roles[saleOrderCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleOrderCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleOrderEdit]", CHtml::resolveValue($model, "roles[saleOrderEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleOrderEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleOrderView]", CHtml::resolveValue($model, "roles[saleOrderView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleOrderView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleOrderApproval]", CHtml::resolveValue($model, "roles[saleOrderApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleOrderApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>4. Faktur Penjualan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleInvoiceCreate]", CHtml::resolveValue($model, "roles[saleInvoiceCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleInvoiceCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleInvoiceEdit]", CHtml::resolveValue($model, "roles[saleInvoiceEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleInvoiceEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleInvoiceView]", CHtml::resolveValue($model, "roles[saleInvoiceView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'saleInvoiceView'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>5. Faktur Penjualan Coretax</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][coretaxInvoiceView]", CHtml::resolveValue($model, "roles[coretaxInvoiceView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'coretaxInvoiceView'
                )); ?>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>6. Sub Pekerjaan Luar</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseCreate]", CHtml::resolveValue($model, "roles[workOrderExpenseCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'workOrderExpenseCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseEdit]", CHtml::resolveValue($model, "roles[workOrderExpenseEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'workOrderExpenseEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseView]", CHtml::resolveValue($model, "roles[workOrderExpenseView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'workOrderExpenseView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderExpenseApproval]", CHtml::resolveValue($model, "roles[workOrderExpenseApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'workOrderExpenseApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>7. Permintaan Harga Cabang</td>
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
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentHead]", CHtml::resolveValue($model, "roles[paymentHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'paymentHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Pelunasan</td>
        </tr>
        <tr>
            <td>8. Payment In</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentInCreate]", CHtml::resolveValue($model, "roles[paymentInCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentInCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentInEdit]", CHtml::resolveValue($model, "roles[paymentInEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentInEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentInView]", CHtml::resolveValue($model, "roles[paymentInView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentInView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentInApproval]", CHtml::resolveValue($model, "roles[paymentInApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentInApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>9. Payment Out</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentOutCreate]", CHtml::resolveValue($model, "roles[paymentOutCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentOutCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentOutEdit]", CHtml::resolveValue($model, "roles[paymentOutEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentOutEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentOutView]", CHtml::resolveValue($model, "roles[paymentOutView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentOutView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentOutApproval]", CHtml::resolveValue($model, "roles[paymentOutApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'paymentOutApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; background-color: greenyellow">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashierHead]", CHtml::resolveValue($model, "roles[cashierHead]"), array(
                    'id' => 'User_roles_' . $counter, 
                    'value' => 'cashierHead'
                )); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </td>
            <td colspan="5" style="text-align: center; font-weight: bold; background-color: greenyellow">Kas</td>
        </tr>
        <tr>
            <td>10. Transaksi Kas</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionCreate]", CHtml::resolveValue($model, "roles[cashTransactionCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cashTransactionCreate'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionEdit]", CHtml::resolveValue($model, "roles[cashTransactionEdit]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cashTransactionEdit'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionView]", CHtml::resolveValue($model, "roles[cashTransactionView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cashTransactionView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionApproval]", CHtml::resolveValue($model, "roles[cashTransactionApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'cashTransactionApproval'
                )); ?>
            </td>
        </tr>
        <tr>
            <td>11. Transaksi Jurnal Umum</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalCreate]", CHtml::resolveValue($model, "roles[adjustmentJournalCreate]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'adjustmentJournalCreate'
                )); ?>
            </td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalView]", CHtml::resolveValue($model, "roles[adjustmentJournalView]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'adjustmentJournalView'
                )); ?>
            </td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][adjustmentJournalApproval]", CHtml::resolveValue($model, "roles[adjustmentJournalApproval]"), array(
                    'id' => 'User_roles_' . $counter++, 
                    'value' => 'adjustmentJournalApproval'
                )); ?>
            </td>
        </tr>
    </tbody>
</table>