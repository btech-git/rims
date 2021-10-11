<table>
    <tr>
        <td>
            <?php echo CHtml::checkBox("User[roles][director]", CHtml::resolveValue($model, "roles[director]"), array('id' => 'User_roles_' . $counter, 'value' => 'director')); ?>
            <?php echo CHtml::label('Director', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
        </td>
        <td>
            <?php echo CHtml::checkBox("User[roles][generalManager]", CHtml::resolveValue($model, "roles[generalManager]"), array('id' => 'User_roles_' . $counter, 'value' => 'generalManager')); ?>
            <?php echo CHtml::label('General Manager', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
        </td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][pendingHead]", CHtml::resolveValue($model, "roles[pendingHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'pendingHead')); ?>
                <?php echo CHtml::label('PENDING', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Daftar Transaksi Pending</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][pendingTransactionView]", CHtml::resolveValue($model, "roles[pendingTransactionView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'pendingTransactionView')); ?></td>
        </tr>
        <tr>
            <td>Order Outstanding</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][orderOutstandingView]", CHtml::resolveValue($model, "roles[orderOutstandingView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'orderOutstandingView')); ?></td>
        </tr>
        <tr>
            <td>Approval Permintaan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestApprovalView]", CHtml::resolveValue($model, "roles[requestApprovalView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestApprovalView')); ?></td>
        </tr>
        <tr>
            <td>Approval Data Master</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterApprovalView]", CHtml::resolveValue($model, "roles[masterApprovalView]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterApprovalView')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][frontOfficeHead]", CHtml::resolveValue($model, "roles[frontOfficeHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'frontOfficeHead')); ?>
                <?php echo CHtml::label('RESEPSIONIS', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>General Repair</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairCreate]", CHtml::resolveValue($model, "roles[generalRepairCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairEdit]", CHtml::resolveValue($model, "roles[generalRepairEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][generalRepairApproval]", CHtml::resolveValue($model, "roles[generalRepairApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairApproval')); ?></td>
        </tr>
        <tr>
            <td>Body Repair</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairCreate]", CHtml::resolveValue($model, "roles[bodyRepairCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairEdit]", CHtml::resolveValue($model, "roles[bodyRepairEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][bodyRepairApproval]", CHtml::resolveValue($model, "roles[bodyRepairApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairApproval')); ?></td>
        </tr>
        <tr>
            <td>Inspeksi Kendaraan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionCreate]", CHtml::resolveValue($model, "roles[inspectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionEdit]", CHtml::resolveValue($model, "roles[inspectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionEdit')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][inspectionApproval]", CHtml::resolveValue($model, "roles[inspectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionApproval')); ?></td>
        </tr>
        <tr>
            <td>SPK</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][workOrderApproval]", CHtml::resolveValue($model, "roles[workOrderApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderApproval')); ?></td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierCreate]", CHtml::resolveValue($model, "roles[cashierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierCreate')); ?></td>
            <td style="text-align: center"><?php //echo CHtml::checkBox("User[roles][cashierEdit]", CHtml::resolveValue($model, "roles[cashierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashierApproval]", CHtml::resolveValue($model, "roles[cashierApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierApproval')); ?></td>
        </tr>
        <tr>
            <td>Daftar Antrian Customer</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][customerQueueApproval]", CHtml::resolveValue($model, "roles[customerQueueApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'customerQueueApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][purchaseHead]", CHtml::resolveValue($model, "roles[purchaseHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'purchaseHead')); ?>
                <?php echo CHtml::label('PEMBELIAN', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
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

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][salesHead]", CHtml::resolveValue($model, "roles[salesHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'salesHead')); ?>
                <?php echo CHtml::label('PENJUALAN', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
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

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][accountingHead]", CHtml::resolveValue($model, "roles[accountingHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'accountingHead')); ?>
                <?php echo CHtml::label('PELUNASAN', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentInCreate]", CHtml::resolveValue($model, "roles[paymentInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentInEdit]", CHtml::resolveValue($model, "roles[paymentInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentInApproval]", CHtml::resolveValue($model, "roles[paymentInApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInApproval')); ?></td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentOutCreate]", CHtml::resolveValue($model, "roles[paymentOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentOutEdit]", CHtml::resolveValue($model, "roles[paymentOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentOutApproval]", CHtml::resolveValue($model, "roles[paymentOutApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][cashierHead]", CHtml::resolveValue($model, "roles[cashierHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'cashierHead')); ?>
                <?php echo CHtml::label('TUNAI', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Transaksi Kas</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashTransactionCreate]", CHtml::resolveValue($model, "roles[cashTransactionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashTransactionEdit]", CHtml::resolveValue($model, "roles[cashTransactionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashTransactionApproval]", CHtml::resolveValue($model, "roles[cashTransactionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionApproval')); ?></td>
        </tr>
        <tr>
            <td>Transaksi Jurnal Umum</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][adjustmentJournalCreate]", CHtml::resolveValue($model, "roles[adjustmentJournalCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][adjustmentJournalEdit]", CHtml::resolveValue($model, "roles[adjustmentJournalEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][adjustmentJournalApproval]", CHtml::resolveValue($model, "roles[adjustmentJournalApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][operationHead]", CHtml::resolveValue($model, "roles[operationHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'operationHead')); ?>
                <?php echo CHtml::label('OPERASIONAL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Permintaan Transfer</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestCreate]", CHtml::resolveValue($model, "roles[transferRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestEdit]", CHtml::resolveValue($model, "roles[transferRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestApproval]", CHtml::resolveValue($model, "roles[transferRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestApproval')); ?></td>
        </tr>
        <tr>
            <td>Permintaan Kirim</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestCreate]", CHtml::resolveValue($model, "roles[sentRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestEdit]", CHtml::resolveValue($model, "roles[sentRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestApproval]", CHtml::resolveValue($model, "roles[sentRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestApproval')); ?></td>
        </tr>
        <tr>
            <td>Retur Beli</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnCreate]", CHtml::resolveValue($model, "roles[purchaseReturnCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnEdit]", CHtml::resolveValue($model, "roles[purchaseReturnEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnApproval]", CHtml::resolveValue($model, "roles[purchaseReturnApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnApproval')); ?></td>
        </tr>
        <tr>
            <td>Retur Jual</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnCreate]", CHtml::resolveValue($model, "roles[saleReturnCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnEdit]", CHtml::resolveValue($model, "roles[saleReturnEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnApproval]", CHtml::resolveValue($model, "roles[saleReturnApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnApproval')); ?></td>
        </tr>
        <tr>
            <td>Pengiriman Barang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryCreate]", CHtml::resolveValue($model, "roles[deliveryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryEdit]", CHtml::resolveValue($model, "roles[deliveryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryApproval]", CHtml::resolveValue($model, "roles[deliveryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryApproval')); ?></td>
        </tr>
        <tr>
            <td>Penerimaan Barang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemCreate]", CHtml::resolveValue($model, "roles[receiveItemCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemEdit]", CHtml::resolveValue($model, "roles[receiveItemEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemApproval]", CHtml::resolveValue($model, "roles[receiveItemApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemApproval')); ?></td>
        </tr>
        <tr>
            <td>Penerimaan Konsinyasi</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInCreate]", CHtml::resolveValue($model, "roles[consignmentInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInEdit]", CHtml::resolveValue($model, "roles[consignmentInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInApproval]", CHtml::resolveValue($model, "roles[consignmentInApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInApproval')); ?></td>
        </tr>
        <tr>
            <td>Pengeluaran Konsinyasi</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutCreate]", CHtml::resolveValue($model, "roles[consignmentOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutEdit]", CHtml::resolveValue($model, "roles[consignmentOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutApproval]", CHtml::resolveValue($model, "roles[consignmentOutApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][inventoryHead]", CHtml::resolveValue($model, "roles[inventoryHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'inventoryHead')); ?>
                <?php echo CHtml::label('GUDANG', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Barang Masuk Gudang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementInCreate]", CHtml::resolveValue($model, "roles[movementInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementInEdit]", CHtml::resolveValue($model, "roles[movementInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementInApproval]", CHtml::resolveValue($model, "roles[movementInApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInApproval')); ?></td>
        </tr>
        <tr>
            <td>Barang Keluar Gudang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementOutCreate]", CHtml::resolveValue($model, "roles[movementOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementOutEdit]", CHtml::resolveValue($model, "roles[movementOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementOutApproval]", CHtml::resolveValue($model, "roles[movementOutApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutApproval')); ?></td>
        </tr>
        <tr>
            <td>Pengeluaran Bahan Pemakaian</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementServiceCreate]", CHtml::resolveValue($model, "roles[movementServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementServiceEdit]", CHtml::resolveValue($model, "roles[movementServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementServiceApproval]", CHtml::resolveValue($model, "roles[movementServiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceApproval')); ?></td>
        </tr>
        <tr>
            <td>Penyesuaian Stok</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAdjustmentCreate]", CHtml::resolveValue($model, "roles[stockAdjustmentCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAdjustmentEdit]", CHtml::resolveValue($model, "roles[stockAdjustmentEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAdjustmentApproval]", CHtml::resolveValue($model, "roles[stockAdjustmentApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentApproval')); ?></td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][materialRequestCreate]", CHtml::resolveValue($model, "roles[materialRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][materialRequestEdit]", CHtml::resolveValue($model, "roles[materialRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][materialRequestApproval]", CHtml::resolveValue($model, "roles[materialRequestApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestApproval')); ?></td>
        </tr>
        <tr>
            <td>Stok Gudang</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][warehouseStockReport]", CHtml::resolveValue($model, "roles[warehouseStockReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'warehouseStockReport')); ?></td>
        </tr>
        <tr>
            <td>Analisa Stok Barang</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAnalysisReport]", CHtml::resolveValue($model, "roles[stockAnalysisReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAnalysisReport')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][idleManagement]", CHtml::resolveValue($model, "roles[idleManagement]"), array('id' => 'User_roles_' . $counter, 'value' => 'idleManagement')); ?>
                <?php echo CHtml::label('IDLE MANAGEMENT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Management</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>BR Mechanic POV</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][brMechanicCreate]", CHtml::resolveValue($model, "roles[brMechanicCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][brMechanicEdit]", CHtml::resolveValue($model, "roles[brMechanicEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][brMechanicApproval]", CHtml::resolveValue($model, "roles[brMechanicApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicApproval')); ?></td>
        </tr>
        <tr>
            <td>GR Mechanic POV</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][grMechanicCreate]", CHtml::resolveValue($model, "roles[grMechanicCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][grMechanicEdit]", CHtml::resolveValue($model, "roles[grMechanicEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][grMechanicApproval]", CHtml::resolveValue($model, "roles[grMechanicApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][areaManager]", CHtml::resolveValue($model, "roles[areaManager]"), array('id' => 'User_roles_' . $counter, 'value' => 'areaManager')); ?>
                <?php echo CHtml::label('HEAD DEPT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Laporan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Rincian Buku Besar Pembantu Piutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][payableJournalReport]", CHtml::resolveValue($model, "roles[payableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'payableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar Pembantu Hutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][receivableJournalReport]", CHtml::resolveValue($model, "roles[receivableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receivableJournalReport')); ?>
            </td>
        </tr>
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
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][financialForecastReport]", CHtml::resolveValue($model, "roles[financialForecastReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialForecastReport')); ?>
            </td>
        </tr>
        <tr>
            <td>General Ledger</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalLedgerReport]", CHtml::resolveValue($model, "roles[generalLedgerReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalLedgerReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Balance Sheet (Induk)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][summaryBalanceSheetReport]", CHtml::resolveValue($model, "roles[summaryBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Balance Sheet (Standard)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][standardBalanceSheetReport]", CHtml::resolveValue($model, "roles[standardBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Profit/Loss (induk)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][summaryProfitLossReport]", CHtml::resolveValue($model, "roles[summaryProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Profit/Loss (Standar)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][standardProfitLossReport]", CHtml::resolveValue($model, "roles[standardProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Cash Transaction</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionReport]", CHtml::resolveValue($model, "roles[cashTransactionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionReport')); ?>
            </td>
        </tr>
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

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterCompany]", CHtml::resolveValue($model, "roles[masterCompany]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterCompany')); ?>
                <?php echo CHtml::label('SETTING COMPANY', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>User</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterUserCreate]", CHtml::resolveValue($model, "roles[masterUserCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterUserEdit]", CHtml::resolveValue($model, "roles[masterUserEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterUserApproval]", CHtml::resolveValue($model, "roles[masterUserApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUserApproval')); ?></td>
        </tr>
        <tr>
            <td>Company</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCompanyCreate]", CHtml::resolveValue($model, "roles[masterCompanyCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCompanyEdit]", CHtml::resolveValue($model, "roles[masterCompanyEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCompanyApproval]", CHtml::resolveValue($model, "roles[masterCompanyApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCompanyApproval')); ?></td>
        </tr>
        <tr>
            <td>Insurance Company</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInsuranceCreate]", CHtml::resolveValue($model, "roles[masterInsuranceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInsuranceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInsuranceEdit]", CHtml::resolveValue($model, "roles[masterInsuranceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInsuranceEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInsuranceApproval]", CHtml::resolveValue($model, "roles[masterInsuranceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInsuranceApproval')); ?></td>
        </tr>
        <tr>
            <td>Branch</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBranchCreate]", CHtml::resolveValue($model, "roles[masterBranchCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBranchEdit]", CHtml::resolveValue($model, "roles[masterBranchEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBranchApproval]", CHtml::resolveValue($model, "roles[masterBranchApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBranchApproval')); ?></td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSupplierCreate]", CHtml::resolveValue($model, "roles[masterSupplierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSupplierEdit]", CHtml::resolveValue($model, "roles[masterSupplierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSupplierApproval]", CHtml::resolveValue($model, "roles[masterSupplierApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSupplierApproval')); ?></td>
        </tr>
        <tr>
            <td>Employee</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEmployeeCreate]", CHtml::resolveValue($model, "roles[masterEmployeeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEmployeeCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEmployeeEdit]", CHtml::resolveValue($model, "roles[masterEmployeeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEmployeeEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEmployeeApproval]", CHtml::resolveValue($model, "roles[masterEmployeeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEmployeeApproval')); ?></td>
        </tr>
        <tr>
            <td>Deduction</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterDeductionCreate]", CHtml::resolveValue($model, "roles[masterDeductionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterDeductionEdit]", CHtml::resolveValue($model, "roles[masterDeductionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterDeductionApproval]", CHtml::resolveValue($model, "roles[masterDeductionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDeductionApproval')); ?></td>
        </tr>
        <tr>
            <td>Incentive</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterIncentiveCreate]", CHtml::resolveValue($model, "roles[masterIncentiveCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterIncentiveEdit]", CHtml::resolveValue($model, "roles[masterIncentiveEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterIncentiveApproval]", CHtml::resolveValue($model, "roles[masterIncentiveApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterIncentiveApproval')); ?></td>
        </tr>
        <tr>
            <td>Position</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPositionCreate]", CHtml::resolveValue($model, "roles[masterPositionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPositionEdit]", CHtml::resolveValue($model, "roles[masterPositionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPositionApproval]", CHtml::resolveValue($model, "roles[masterPositionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPositionApproval')); ?></td>
        </tr>
        <tr>
            <td>Division</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterDivisionCreate]", CHtml::resolveValue($model, "roles[masterDivisionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterDivisionEdit]", CHtml::resolveValue($model, "roles[masterDivisionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterDivisionApproval]", CHtml::resolveValue($model, "roles[masterDivisionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterDivisionApproval')); ?></td>
        </tr>
        <tr>
            <td>Level</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterLevelCreate]", CHtml::resolveValue($model, "roles[masterLevelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterLevelEdit]", CHtml::resolveValue($model, "roles[masterLevelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterLevelApproval]", CHtml::resolveValue($model, "roles[masterLevelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterLevelApproval')); ?></td>
        </tr>
        <tr>
            <td>Unit</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterUnitCreate]", CHtml::resolveValue($model, "roles[masterUnitCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterUnitEdit]", CHtml::resolveValue($model, "roles[masterUnitEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterUnitApproval]", CHtml::resolveValue($model, "roles[masterUnitApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterUnitApproval')); ?></td>
        </tr>
        <tr>
            <td>Unit Conversion</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterConversionCreate]", CHtml::resolveValue($model, "roles[masterConversionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterConversionEdit]", CHtml::resolveValue($model, "roles[masterConversionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterConversionApproval]", CHtml::resolveValue($model, "roles[masterConversionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterConversionApproval')); ?></td>
        </tr>
        <tr>
            <td>Public Holiday</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterHolidayCreate]", CHtml::resolveValue($model, "roles[masterHolidayCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterHolidayCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterHolidayEdit]", CHtml::resolveValue($model, "roles[masterHolidayEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterHolidayEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterHolidayApproval]", CHtml::resolveValue($model, "roles[masterHolidayApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterHolidayApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterAccounting]", CHtml::resolveValue($model, "roles[masterAccounting]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterAccounting')); ?>
                <?php echo CHtml::label('SETTING ACCOUNTING', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Bank</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBankCreate]", CHtml::resolveValue($model, "roles[masterBankCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBankCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBankEdit]", CHtml::resolveValue($model, "roles[masterBankEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBankEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBankApproval]", CHtml::resolveValue($model, "roles[masterBankApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBankApproval')); ?></td>
        </tr>
        <tr>
            <td>COA</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaCreate]", CHtml::resolveValue($model, "roles[masterCoaCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaEdit]", CHtml::resolveValue($model, "roles[masterCoaEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaApproval]", CHtml::resolveValue($model, "roles[masterCoaApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaApproval')); ?></td>
        </tr>
        <tr>
            <td>COA Category</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaCategoryCreate]", CHtml::resolveValue($model, "roles[masterCoaCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCategoryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaCategoryEdit]", CHtml::resolveValue($model, "roles[masterCoaCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCategoryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaCategoryApproval]", CHtml::resolveValue($model, "roles[masterCoaCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaCategoryApproval')); ?></td>
        </tr>
        <tr>
            <td>COA Sub Category</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaSubCategoryCreate]", CHtml::resolveValue($model, "roles[masterCoaSubCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaSubCategoryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaSubCategoryEdit]", CHtml::resolveValue($model, "roles[masterCoaSubCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaSubCategoryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCoaSubCategoryApproval]", CHtml::resolveValue($model, "roles[masterCoaSubCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCoaSubCategoryApproval')); ?></td>
        </tr>
        <tr>
            <td>Payment Type</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPaymentTypeCreate]", CHtml::resolveValue($model, "roles[masterPaymentTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPaymentTypeCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPaymentTypeEdit]", CHtml::resolveValue($model, "roles[masterPaymentTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPaymentTypeEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPaymentTypeApproval]", CHtml::resolveValue($model, "roles[masterPaymentTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPaymentTypeApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterProductInventory]", CHtml::resolveValue($model, "roles[masterProductInventory]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterProductInventory')); ?>
                <?php echo CHtml::label('SETTING PRODUCT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Product</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductCreate]", CHtml::resolveValue($model, "roles[masterProductCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductEdit]", CHtml::resolveValue($model, "roles[masterProductEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductApproval]", CHtml::resolveValue($model, "roles[masterProductApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductApproval')); ?></td>
        </tr>
        <tr>
            <td>Product Category</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCategoryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCategoryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductCategoryApproval')); ?></td>
        </tr>
        <tr>
            <td>Product Sub Master Category</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubMasterCategoryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubMasterCategoryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductSubMasterCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductSubMasterCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubMasterCategoryApproval')); ?></td>
        </tr>
        <tr>
            <td>Product Sub Category</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductSubCategoryCreate]", CHtml::resolveValue($model, "roles[masterProductSubCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubCategoryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductSubCategoryEdit]", CHtml::resolveValue($model, "roles[masterProductSubCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubCategoryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterProductSubCategoryApproval]", CHtml::resolveValue($model, "roles[masterProductSubCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterProductSubCategoryApproval')); ?></td>
        </tr>
        <tr>
            <td>Brand</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBrandCreate]", CHtml::resolveValue($model, "roles[masterBrandCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBrandCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBrandEdit]", CHtml::resolveValue($model, "roles[masterBrandEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBrandEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterBrandApproval]", CHtml::resolveValue($model, "roles[masterBrandApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterBrandApproval')); ?></td>
        </tr>
        <tr>
            <td>Sub Brand</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSubBrandCreate]", CHtml::resolveValue($model, "roles[masterSubBrandCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSubBrandEdit]", CHtml::resolveValue($model, "roles[masterSubBrandEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSubBrandApproval]", CHtml::resolveValue($model, "roles[masterSubBrandApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandApproval')); ?></td>
        </tr>
        <tr>
            <td>Sub Brand Series</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesCreate]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandSeriesCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesEdit]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandSeriesEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterSubBrandSeriesApproval]", CHtml::resolveValue($model, "roles[masterSubBrandSeriesApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterSubBrandSeriesApproval')); ?></td>
        </tr>
        <tr>
            <td>Equipment</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentCreate]", CHtml::resolveValue($model, "roles[masterEquipmentCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentEdit]", CHtml::resolveValue($model, "roles[masterEquipmentEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentApproval]", CHtml::resolveValue($model, "roles[masterEquipmentApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentApproval')); ?></td>
        </tr>
        <tr>
            <td>Equipment Type</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentTypeCreate]", CHtml::resolveValue($model, "roles[masterEquipmentTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentTypeCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentTypeEdit]", CHtml::resolveValue($model, "roles[masterEquipmentTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentTypeEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentTypeApproval]", CHtml::resolveValue($model, "roles[masterEquipmentTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentTypeApproval')); ?></td>
        </tr>
        <tr>
            <td>Equipment Sub Type</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeCreate]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentSubTypeCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeEdit]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentSubTypeEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterEquipmentSubTypeApproval]", CHtml::resolveValue($model, "roles[masterEquipmentSubTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterEquipmentSubTypeApproval')); ?></td>
        </tr>
        <tr>
            <td>Warehouse</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterWarehouseCreate]", CHtml::resolveValue($model, "roles[masterWarehouseCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterWarehouseCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterWarehouseEdit]", CHtml::resolveValue($model, "roles[masterWarehouseEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterWarehouseEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterWarehouseApproval]", CHtml::resolveValue($model, "roles[masterWarehouseApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterWarehouseApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterServiceList]", CHtml::resolveValue($model, "roles[masterServiceList]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterServiceList')); ?>
                <?php echo CHtml::label('SETTING SERVICE', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Service</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceCreate]", CHtml::resolveValue($model, "roles[masterServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceEdit]", CHtml::resolveValue($model, "roles[masterServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceApproval]", CHtml::resolveValue($model, "roles[masterServiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceApproval')); ?></td>
        </tr>
        <tr>
            <td>Service Category</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceCategoryCreate]", CHtml::resolveValue($model, "roles[masterServiceCategoryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCategoryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceCategoryEdit]", CHtml::resolveValue($model, "roles[masterServiceCategoryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCategoryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceCategoryApproval]", CHtml::resolveValue($model, "roles[masterServiceCategoryApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceCategoryApproval')); ?></td>
        </tr>
        <tr>
            <td>Service Type</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceTypeCreate]", CHtml::resolveValue($model, "roles[masterServiceTypeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceTypeCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceTypeEdit]", CHtml::resolveValue($model, "roles[masterServiceTypeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceTypeEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterServiceTypeApproval]", CHtml::resolveValue($model, "roles[masterServiceTypeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterServiceTypeApproval')); ?></td>
        </tr>
        <tr>
            <td>Price List Standard</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistStandardCreate]", CHtml::resolveValue($model, "roles[masterPricelistStandardCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistStandardCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistStandardEdit]", CHtml::resolveValue($model, "roles[masterPricelistStandardEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistStandardEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistStandardApproval]", CHtml::resolveValue($model, "roles[masterPricelistStandardApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistStandardApproval')); ?></td>
        </tr>
        <tr>
            <td>Price List Group</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistGroupCreate]", CHtml::resolveValue($model, "roles[masterPricelistGroupCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistGroupCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistGroupEdit]", CHtml::resolveValue($model, "roles[masterPricelistGroupEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistGroupEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistGroupApproval]", CHtml::resolveValue($model, "roles[masterPricelistGroupApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistGroupApproval')); ?></td>
        </tr>
        <tr>
            <td>Price List Set</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistSetCreate]", CHtml::resolveValue($model, "roles[masterPricelistSetCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistSetCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistSetEdit]", CHtml::resolveValue($model, "roles[masterPricelistSetEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistSetEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterPricelistSetApproval]", CHtml::resolveValue($model, "roles[masterPricelistSetApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterPricelistSetApproval')); ?></td>
        </tr>
        <tr>
            <td>Standard Flat Rate</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterStandardFlatrateCreate]", CHtml::resolveValue($model, "roles[masterStandardFlatrateCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardFlatrateCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterStandardFlatrateEdit]", CHtml::resolveValue($model, "roles[masterStandardFlatrateEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardFlatrateEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterStandardFlatrateApproval]", CHtml::resolveValue($model, "roles[masterStandardFlatrateApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardFlatrateApproval')); ?></td>
        </tr>
        <tr>
            <td>Standard Value</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterStandardValueCreate]", CHtml::resolveValue($model, "roles[masterStandardValueCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardValueCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterStandardValueEdit]", CHtml::resolveValue($model, "roles[masterStandardValueEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardValueEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterStandardValueApproval]", CHtml::resolveValue($model, "roles[masterStandardValueApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterStandardValueApproval')); ?></td>
        </tr>
        <tr>
            <td>Quick Service</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterQuickServiceCreate]", CHtml::resolveValue($model, "roles[masterQuickServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterQuickServiceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterQuickServiceEdit]", CHtml::resolveValue($model, "roles[masterQuickServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterQuickServiceEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterQuickServiceApproval]", CHtml::resolveValue($model, "roles[masterQuickServiceApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterQuickServiceApproval')); ?></td>
        </tr>
        <tr>
            <td>Inspection</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionCreate]", CHtml::resolveValue($model, "roles[masterInspectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionEdit]", CHtml::resolveValue($model, "roles[masterInspectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionApproval]", CHtml::resolveValue($model, "roles[masterInspectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionApproval')); ?></td>
        </tr>
        <tr>
            <td>Inspection Section</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionSectionCreate]", CHtml::resolveValue($model, "roles[masterInspectionSectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionSectionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionSectionEdit]", CHtml::resolveValue($model, "roles[masterInspectionSectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionSectionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionSectionApproval]", CHtml::resolveValue($model, "roles[masterInspectionSectionApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionSectionApproval')); ?></td>
        </tr>
        <tr>
            <td>Inspection Module</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionModuleCreate]", CHtml::resolveValue($model, "roles[masterInspectionModuleCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionModuleCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionModuleEdit]", CHtml::resolveValue($model, "roles[masterInspectionModuleEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionModuleEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterInspectionModuleApproval]", CHtml::resolveValue($model, "roles[masterInspectionModuleApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterInspectionModuleApproval')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][masterVehicleInventory]", CHtml::resolveValue($model, "roles[masterVehicleInventory]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterVehicleInventory')); ?>
                <?php echo CHtml::label('SETTING VEHICLE', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Create</th>
            <th style="text-align: center">Edit</th>
            <th style="text-align: center">Approval</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Vehicle</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterVehicleCreate]", CHtml::resolveValue($model, "roles[masterVehicleCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterVehicleCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterVehicleEdit]", CHtml::resolveValue($model, "roles[masterVehicleEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterVehicleEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterVehicleApproval]", CHtml::resolveValue($model, "roles[masterVehicleApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterVehicleApproval')); ?></td>
        </tr>
        <tr>
            <td>Customer</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCustomerCreate]", CHtml::resolveValue($model, "roles[masterCustomerCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCustomerEdit]", CHtml::resolveValue($model, "roles[masterCustomerEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCustomerApproval]", CHtml::resolveValue($model, "roles[masterCustomerApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCustomerApproval')); ?></td>
        </tr>
        <tr>
            <td>Car Make</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarMakeCreate]", CHtml::resolveValue($model, "roles[masterCarMakeCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarMakeCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarMakeEdit]", CHtml::resolveValue($model, "roles[masterCarMakeEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarMakeEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarMakeApproval]", CHtml::resolveValue($model, "roles[masterCarMakeApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarMakeApproval')); ?></td>
        </tr>
        <tr>
            <td>Car Model</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarModelCreate]", CHtml::resolveValue($model, "roles[masterCarModelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarModelCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarModelEdit]", CHtml::resolveValue($model, "roles[masterCarModelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarModelEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarModelApproval]", CHtml::resolveValue($model, "roles[masterCarModelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarModelApproval')); ?></td>
        </tr>
        <tr>
            <td>Car Sub Model</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarSubModelCreate]", CHtml::resolveValue($model, "roles[masterCarSubModelCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarSubModelEdit]", CHtml::resolveValue($model, "roles[masterCarSubModelEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarSubModelApproval]", CHtml::resolveValue($model, "roles[masterCarSubModelApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelApproval')); ?></td>
        </tr>
        <tr>
            <td>Car Sub Model Detail</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarSubModelDetailCreate]", CHtml::resolveValue($model, "roles[masterCarSubModelDetailCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelDetailCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarSubModelDetailEdit]", CHtml::resolveValue($model, "roles[masterCarSubModelDetailEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelDetailEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterCarSubModelDetailApproval]", CHtml::resolveValue($model, "roles[masterCarSubModelDetailApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterCarSubModelDetailApproval')); ?></td>
        </tr>
        <tr>
            <td>Color</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterColorCreate]", CHtml::resolveValue($model, "roles[masterColorCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterColorCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterColorEdit]", CHtml::resolveValue($model, "roles[masterColorEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterColorEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][masterColorApproval]", CHtml::resolveValue($model, "roles[masterColorApproval]"), array('id' => 'User_roles_' . $counter++, 'value' => 'masterColorApproval')); ?></td>
        </tr>
    </tbody>
</table>