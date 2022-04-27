<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][areaManager]", CHtml::resolveValue($model, "roles[areaManager]"), array('id' => 'User_roles_' . $counter, 'value' => 'areaManager')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Inventory Stok Penjualan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][stockInventoryReport]", CHtml::resolveValue($model, "roles[stockInventoryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockInventoryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Kartu Stok Persediaan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][stockCardReport]", CHtml::resolveValue($model, "roles[stockCardReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockCardReport')); ?>
            </td>
        </tr>
<!--        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php //echo CHtml::checkBox("User[roles][financialForecastReport]", CHtml::resolveValue($model, "roles[financialForecastReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialForecastReport')); ?>
            </td>
        </tr>-->
        <tr>
            <td>Consignment In</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][consignmentInReport]", CHtml::resolveValue($model, "roles[consignmentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Consignment Out</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][consignmentOutReport]", CHtml::resolveValue($model, "roles[consignmentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][materialRequestReport]", CHtml::resolveValue($model, "roles[materialRequestReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Movement In</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][movementInReport]", CHtml::resolveValue($model, "roles[movementInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Movement Out</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][movementOutReport]", CHtml::resolveValue($model, "roles[movementOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseReport]", CHtml::resolveValue($model, "roles[purchaseReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Hutang Supplier</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][supplierPayableReport]", CHtml::resolveValue($model, "roles[supplierPayableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'supplierPayableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Invoice Penjualan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleInvoiceReport]", CHtml::resolveValue($model, "roles[saleInvoiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Piutang Customer</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][customerReceivableReport]", CHtml::resolveValue($model, "roles[customerReceivableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'customerReceivableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentInReport]", CHtml::resolveValue($model, "roles[paymentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentOutReport]", CHtml::resolveValue($model, "roles[paymentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail Summary</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleSummaryReport]", CHtml::resolveValue($model, "roles[saleSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail Product</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleProductReport]", CHtml::resolveValue($model, "roles[saleProductReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleProductReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail Service</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleServiceReport]", CHtml::resolveValue($model, "roles[saleServiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleServiceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Pengiriman</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][deliveryReport]", CHtml::resolveValue($model, "roles[deliveryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penerimaan Barang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][receiveReport]", CHtml::resolveValue($model, "roles[receiveReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Order Penjualan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleOrderReport]", CHtml::resolveValue($model, "roles[saleOrderReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Sent Request</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][sentRequestReport]", CHtml::resolveValue($model, "roles[sentRequestReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Transfer Request</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][transferRequestReport]", CHtml::resolveValue($model, "roles[transferRequestReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestReport')); ?>
            </td>
        </tr>
    </tbody>
</table>