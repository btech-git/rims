<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[purchaseHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('PEMBELIAN', 'User_roles_', array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Permintaan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[requestOrderCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[requestOrderEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[requestOrderView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[requestOrderApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[requestOrderSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Order Pembelian</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseOrderCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseOrderEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseOrderView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseOrderApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseOrderSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[salesHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('PENJUALAN', 'User_roles_', array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Penjualan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleOrderCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleOrderEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleOrderView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleOrderApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleOrderSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Penjualan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleInvoiceCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleInvoiceEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleInvoiceView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td>&nbsp;</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleInvoiceSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Sub Pekerjaan Luar</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderExpenseCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderExpenseEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderExpenseView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderExpenseApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderExpenseSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[accountingHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('PELUNASAN', 'User_roles_', array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentInCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentInEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentInView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentInApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentInSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentOutCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentOutEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentOutView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentOutApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentOutSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[cashierHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php echo CHtml::label('TUNAI', 'User_roles_', array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
            <th style="text-align: center">Approval</th>
            <th style="text-align: center">Supervisor</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Transaksi Kas</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashTransactionCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashTransactionEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashTransactionView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashTransactionApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashTransactionSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Transaksi Jurnal Umum</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalCreate]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalEdit]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalView]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalApproval]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[adjustmentJournalSupervisor]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>