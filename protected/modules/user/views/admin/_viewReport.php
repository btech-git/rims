<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php echo $counter . CHtml::checkBox("User[roles][areaManager]", CHtml::resolveValue($model, "roles[areaManager]"), array('id' => 'User_roles_' . $counter, 'value' => 'areaManager')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Keuangan</td>
        </tr>
        <tr>
            <td>Laba/Rugi (induk)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][summaryProfitLossReport]", CHtml::resolveValue($model, "roles[summaryProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laba/Rugi (Standar)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][standardProfitLossReport]", CHtml::resolveValue($model, "roles[standardProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Induk)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][summaryBalanceSheetReport]", CHtml::resolveValue($model, "roles[summaryBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Standard)</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][standardBalanceSheetReport]", CHtml::resolveValue($model, "roles[standardBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Buku Besar</td>
        </tr>
        <tr>
            <td>Jurnal Umum</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][transactionJournalReport]", CHtml::resolveValue($model, "roles[transactionJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transactionJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Ringkasan Buku Besar</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][journalSummaryReport]", CHtml::resolveValue($model, "roles[journalSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'journalSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][generalLedgerReport]", CHtml::resolveValue($model, "roles[generalLedgerReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalLedgerReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Kas</td>
        </tr>
        <tr>
            <td>Approval Kas Harian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailyApprovalReport]", CHtml::resolveValue($model, "roles[cashDailyApprovalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailyApprovalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Summary Kas Harian</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashDailySummaryReport]", CHtml::resolveValue($model, "roles[cashDailySummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailySummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][financialForecastReport]", CHtml::resolveValue($model, "roles[financialForecastReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialForecastReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laporan Cash Transaction</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][cashTransactionReport]", CHtml::resolveValue($model, "roles[cashTransactionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Piutang</td>
        </tr>
        <tr>
            <td>Rincian Buku Besar Pembantu Piutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][receivableJournalReport]", CHtml::resolveValue($model, "roles[receivableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receivableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Penjualan Belum Lunas</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][customerReceivableReport]", CHtml::resolveValue($model, "roles[customerReceivableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'customerReceivableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penerimaan Penjualan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentInReport]", CHtml::resolveValue($model, "roles[paymentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Penjualan</td>
        </tr>
        <tr>
            <td>Penjualan per Pelanggan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleCustomerSummaryReport]", CHtml::resolveValue($model, "roles[saleCustomerSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleCustomerSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Pelanggan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleCustomerReport]", CHtml::resolveValue($model, "roles[saleCustomerReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleCustomerReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Barang / Jasa</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleSummaryReport]", CHtml::resolveValue($model, "roles[saleSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Barang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleProductReport]", CHtml::resolveValue($model, "roles[saleProductReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleProductReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Jasa</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][saleServiceReport]", CHtml::resolveValue($model, "roles[saleServiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleServiceReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Aset Tetap</td>
        </tr>
        <tr>
            <td>Daftar Aset Tetap</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][fixedAssetReport]", CHtml::resolveValue($model, "roles[fixedAssetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'fixedAssetReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Hutang</td>
        </tr>
        <tr>
            <td>Rincian Buku Besar Pembantu Hutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][payableJournalReport]", CHtml::resolveValue($model, "roles[payableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'payableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Pembelian Belum Lunas</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][supplierPayableReport]", CHtml::resolveValue($model, "roles[supplierPayableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'supplierPayableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembayaran Hutang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][paymentOutReport]", CHtml::resolveValue($model, "roles[paymentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Pembelian</td>
        </tr>
        <tr>
            <td>Pembelian per Pemasok</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseSupplierSummaryReport]", CHtml::resolveValue($model, "roles[purchaseSupplierSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseSupplierSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian per Pemasok</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseSupplierReport]", CHtml::resolveValue($model, "roles[purchaseSupplierReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseSupplierReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian per Barang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseProductSummaryReport]", CHtml::resolveValue($model, "roles[purchaseProductSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseProductSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian per Barang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][purchaseProductReport]", CHtml::resolveValue($model, "roles[purchaseProductReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseProductReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Persediaan</td>
        </tr>
        <tr>
            <td>Kartu Stok Persediaan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][stockCardReport]", CHtml::resolveValue($model, "roles[stockCardReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockCardReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Gudang</td>
        </tr>
        <tr>
            <td>Kuantitas Barang per Gudang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][stockInventoryReport]", CHtml::resolveValue($model, "roles[stockInventoryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockInventoryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Mutasi per Barang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][stockCardItemReport]", CHtml::resolveValue($model, "roles[stockCardItemReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockCardItemReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Mutasi per Gudang</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][stockCardWarehouseReport]", CHtml::resolveValue($model, "roles[stockCardWarehouseReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockCardWarehouseReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold" colspan="2">Pekerjaan Pesanan</td>
        </tr>
        <tr>
            <td>Penyelesaian Pesanan per Pekerjaan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderServiceReport]", CHtml::resolveValue($model, "roles[workOrderServiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderServiceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penyelesaian Pesanan per Kendaraan</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][workOrderVehicleReport]", CHtml::resolveValue($model, "roles[workOrderVehicleReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderVehicleReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laporan Mekanik</td>
            <td style="text-align: center">
                <?php echo CHtml::checkBox("User[roles][mechanicPerformanceReport]", CHtml::resolveValue($model, "roles[mechanicPerformanceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'mechanicPerformanceReport')); ?>
            </td>
        </tr>
    </tbody>
</table>