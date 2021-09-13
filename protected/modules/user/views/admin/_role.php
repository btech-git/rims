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
        <td>
            <?php echo CHtml::checkBox("User[roles][masterData]", CHtml::resolveValue($model, "roles[masterData]"), array('id' => 'User_roles_' . $counter, 'value' => 'masterData')); ?>
            <?php echo CHtml::label('Master Data', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
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
            <th style="text-align: center">Report</th>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>General Repair</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairCreate]", CHtml::resolveValue($model, "roles[generalRepairCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairEdit]", CHtml::resolveValue($model, "roles[generalRepairEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][generalRepairReport]", CHtml::resolveValue($model, "roles[generalRepairReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalRepairReport')); ?></td>
        </tr>
        <tr>
            <td>Body Repair</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairCreate]", CHtml::resolveValue($model, "roles[bodyRepairCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairEdit]", CHtml::resolveValue($model, "roles[bodyRepairEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][bodyRepairReport]", CHtml::resolveValue($model, "roles[bodyRepairReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'bodyRepairReport')); ?></td>
        </tr>
        <tr>
            <td>Inspeksi Kendaraan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionCreate]", CHtml::resolveValue($model, "roles[inspectionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionEdit]", CHtml::resolveValue($model, "roles[inspectionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][inspectionReport]", CHtml::resolveValue($model, "roles[inspectionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'inspectionReport')); ?></td>
        </tr>
        <tr>
            <td>SPK</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][workOrderReport]", CHtml::resolveValue($model, "roles[workOrderReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderReport')); ?></td>
        </tr>
        <tr>
            <td>Kasir</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashierCreate]", CHtml::resolveValue($model, "roles[cashierCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashierEdit]", CHtml::resolveValue($model, "roles[cashierEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashierReport]", CHtml::resolveValue($model, "roles[cashierReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashierReport')); ?></td>
        </tr>
        <tr>
            <td>Daftar Antrian Customer</td>
            <td style="text-align: center"></td>
            <td style="text-align: center"></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][customerQueueReport]", CHtml::resolveValue($model, "roles[customerQueueReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'customerQueueReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Permintaan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestOrderCreate]", CHtml::resolveValue($model, "roles[requestOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestOrderEdit]", CHtml::resolveValue($model, "roles[requestOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][requestOrderReport]", CHtml::resolveValue($model, "roles[requestOrderReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'requestOrderReport')); ?></td>
        </tr>
        <tr>
            <td>Order Pembelian</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseOrderCreate]", CHtml::resolveValue($model, "roles[purchaseOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseOrderEdit]", CHtml::resolveValue($model, "roles[purchaseOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseOrderReport]", CHtml::resolveValue($model, "roles[purchaseOrderReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseOrderReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Order Penjualan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleOrderCreate]", CHtml::resolveValue($model, "roles[saleOrderCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleOrderEdit]", CHtml::resolveValue($model, "roles[saleOrderEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleOrderReport]", CHtml::resolveValue($model, "roles[saleOrderReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleOrderReport')); ?></td>
        </tr>
        <tr>
            <td>Faktur Penjualan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleInvoiceCreate]", CHtml::resolveValue($model, "roles[saleInvoiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleInvoiceEdit]", CHtml::resolveValue($model, "roles[saleInvoiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleInvoiceReport]", CHtml::resolveValue($model, "roles[saleInvoiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleInvoiceReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Payment In</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentInCreate]", CHtml::resolveValue($model, "roles[paymentInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentInEdit]", CHtml::resolveValue($model, "roles[paymentInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentInReport]", CHtml::resolveValue($model, "roles[paymentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInReport')); ?></td>
        </tr>
        <tr>
            <td>Payment Out</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentOutCreate]", CHtml::resolveValue($model, "roles[paymentOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentOutEdit]", CHtml::resolveValue($model, "roles[paymentOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][paymentOutReport]", CHtml::resolveValue($model, "roles[paymentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Transaksi Kas</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashTransactionCreate]", CHtml::resolveValue($model, "roles[cashTransactionCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashTransactionEdit]", CHtml::resolveValue($model, "roles[cashTransactionEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][cashTransactionReport]", CHtml::resolveValue($model, "roles[cashTransactionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionReport')); ?></td>
        </tr>
        <tr>
            <td>Transaksi Jurnal Umum</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][adjustmentJournalCreate]", CHtml::resolveValue($model, "roles[adjustmentJournalCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][adjustmentJournalEdit]", CHtml::resolveValue($model, "roles[adjustmentJournalEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][adjustmentJournalReport]", CHtml::resolveValue($model, "roles[adjustmentJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'adjustmentJournalReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Permintaan Transfer</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestCreate]", CHtml::resolveValue($model, "roles[transferRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestEdit]", CHtml::resolveValue($model, "roles[transferRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][transferRequestReport]", CHtml::resolveValue($model, "roles[transferRequestReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transferRequestReport')); ?></td>
        </tr>
        <tr>
            <td>Permintaan Kirim</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestCreate]", CHtml::resolveValue($model, "roles[sentRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestEdit]", CHtml::resolveValue($model, "roles[sentRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][sentRequestReport]", CHtml::resolveValue($model, "roles[sentRequestReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'sentRequestReport')); ?></td>
        </tr>
        <tr>
            <td>Retur Beli</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnCreate]", CHtml::resolveValue($model, "roles[purchaseReturnCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnEdit]", CHtml::resolveValue($model, "roles[purchaseReturnEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][purchaseReturnReport]", CHtml::resolveValue($model, "roles[purchaseReturnReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseReturnReport')); ?></td>
        </tr>
        <tr>
            <td>Retur Jual</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnCreate]", CHtml::resolveValue($model, "roles[saleReturnCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnEdit]", CHtml::resolveValue($model, "roles[saleReturnEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][saleReturnReport]", CHtml::resolveValue($model, "roles[saleReturnReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleReturnReport')); ?></td>
        </tr>
        <tr>
            <td>Pengiriman Barang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryCreate]", CHtml::resolveValue($model, "roles[deliveryCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryEdit]", CHtml::resolveValue($model, "roles[deliveryEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][deliveryReport]", CHtml::resolveValue($model, "roles[deliveryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'deliveryReport')); ?></td>
        </tr>
        <tr>
            <td>Penerimaan Barang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemCreate]", CHtml::resolveValue($model, "roles[receiveItemCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemEdit]", CHtml::resolveValue($model, "roles[receiveItemEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][receiveItemReport]", CHtml::resolveValue($model, "roles[receiveItemReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receiveItemReport')); ?></td>
        </tr>
        <tr>
            <td>Penerimaan Konsinyasi</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInCreate]", CHtml::resolveValue($model, "roles[consignmentInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInEdit]", CHtml::resolveValue($model, "roles[consignmentInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentInReport]", CHtml::resolveValue($model, "roles[consignmentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentInReport')); ?></td>
        </tr>
        <tr>
            <td>Pengeluaran Konsinyasi</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutCreate]", CHtml::resolveValue($model, "roles[consignmentOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutEdit]", CHtml::resolveValue($model, "roles[consignmentOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][consignmentOutReport]", CHtml::resolveValue($model, "roles[consignmentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'consignmentOutReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Barang Masuk Gudang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementInCreate]", CHtml::resolveValue($model, "roles[movementInCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementInEdit]", CHtml::resolveValue($model, "roles[movementInEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementInReport]", CHtml::resolveValue($model, "roles[movementInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementInReport')); ?></td>
        </tr>
        <tr>
            <td>Barang Keluar Gudang</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementOutCreate]", CHtml::resolveValue($model, "roles[movementOutCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementOutEdit]", CHtml::resolveValue($model, "roles[movementOutEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementOutReport]", CHtml::resolveValue($model, "roles[movementOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementOutReport')); ?></td>
        </tr>
        <tr>
            <td>Pengeluaran Bahan Pemakaian</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementServiceCreate]", CHtml::resolveValue($model, "roles[movementServiceCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementServiceEdit]", CHtml::resolveValue($model, "roles[movementServiceEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][movementServiceReport]", CHtml::resolveValue($model, "roles[movementServiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'movementServiceReport')); ?></td>
        </tr>
        <tr>
            <td>Penyesuaian Stok</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAdjustmentCreate]", CHtml::resolveValue($model, "roles[stockAdjustmentCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAdjustmentEdit]", CHtml::resolveValue($model, "roles[stockAdjustmentEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][stockAdjustmentReport]", CHtml::resolveValue($model, "roles[stockAdjustmentReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockAdjustmentReport')); ?></td>
        </tr>
        <tr>
            <td>Permintaan Bahan</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][materialRequestCreate]", CHtml::resolveValue($model, "roles[materialRequestCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][materialRequestEdit]", CHtml::resolveValue($model, "roles[materialRequestEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][materialRequestReport]", CHtml::resolveValue($model, "roles[materialRequestReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'materialRequestReport')); ?></td>
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
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>BR Mechanic POV</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][brMechanicCreate]", CHtml::resolveValue($model, "roles[brMechanicCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][brMechanicEdit]", CHtml::resolveValue($model, "roles[brMechanicEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][brMechanicReport]", CHtml::resolveValue($model, "roles[brMechanicReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'brMechanicReport')); ?></td>
        </tr>
        <tr>
            <td>GR Mechanic POV</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][grMechanicCreate]", CHtml::resolveValue($model, "roles[grMechanicCreate]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicCreate')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][grMechanicEdit]", CHtml::resolveValue($model, "roles[grMechanicEdit]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicEdit')); ?></td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][grMechanicReport]", CHtml::resolveValue($model, "roles[grMechanicReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'grMechanicReport')); ?></td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo CHtml::checkBox("User[roles][financeHead]", CHtml::resolveValue($model, "roles[financeHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'financeHead')); ?>
                <?php echo CHtml::label('ACCOUNTING/FINANCE', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Report</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ACCOUNTING</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][accountingReport]", CHtml::resolveValue($model, "roles[accountingReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'accountingReport')); ?></td>
        </tr>
        <tr>
            <td>FINANCE</td>
            <td style="text-align: center"><?php echo CHtml::checkBox("User[roles][financeReport]", CHtml::resolveValue($model, "roles[financeReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financeReport')); ?></td>
        </tr>
    </tbody>
</table>