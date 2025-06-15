<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][reportHead]", CHtml::resolveValue($model, "roles[reportHead]"), array('id' => 'User_roles_' . $counter, 'value' => 'reportHead')); ?>
                <?php echo CHtml::label('SELECT ALL', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">View</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Gudang</td>
        </tr>
        <tr>
            <td>Kartu Stok Gudang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][warehouseStockReport]", CHtml::resolveValue($model, "roles[warehouseStockReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'warehouseStockReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Mutasi per Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][stockCardItemReport]", CHtml::resolveValue($model, "roles[stockCardItemReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockCardItemReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Mutasi per Gudang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][stockCardWarehouseReport]", CHtml::resolveValue($model, "roles[stockCardWarehouseReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockCardWarehouseReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Persediaan</td>
        </tr>
        <tr>
            <td>Nilai Stok Persediaan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][stockValueReport]", CHtml::resolveValue($model, "roles[stockValueReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockValueReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Stok Quantity + Nilai Stok Persediaan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][stockQuantityValueReport]", CHtml::resolveValue($model, "roles[stockQuantityValueReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockQuantityValueReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Posisi Stok Gudang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][stockPositionReport]", CHtml::resolveValue($model, "roles[stockPositionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'stockPositionReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Pekerjaan Pesanan</td>
        </tr>
        <tr>
            <td>Penyelesaian Pesanan per Pekerjaan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][workOrderServiceReport]", CHtml::resolveValue($model, "roles[workOrderServiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderServiceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penyelesaian Pesanan per Kendaraan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][workOrderVehicleReport]", CHtml::resolveValue($model, "roles[workOrderVehicleReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'workOrderVehicleReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Mekanik Performance</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][mechanicPerformanceReport]", CHtml::resolveValue($model, "roles[mechanicPerformanceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'mechanicPerformanceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Salesman Performance</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][salesmanPerformanceReport]", CHtml::resolveValue($model, "roles[salesmanPerformanceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'salesmanPerformanceReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Buku Besar</td>
        </tr>
        <tr>
            <td>Jurnal Umum</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][transactionJournalReport]", CHtml::resolveValue($model, "roles[transactionJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'transactionJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Ringkasan Buku Besar</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][journalSummaryReport]", CHtml::resolveValue($model, "roles[journalSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'journalSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Pembelian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryPurchaseReport]", CHtml::resolveValue($model, "roles[summaryPurchaseReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryPurchaseReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Pelunasan Pembelian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryPaymentOutReport]", CHtml::resolveValue($model, "roles[summaryPaymentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryPaymentOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Penjualan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summarySaleReport]", CHtml::resolveValue($model, "roles[summarySaleReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summarySaleReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Penerimaan Penjualan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryPaymentInReport]", CHtml::resolveValue($model, "roles[summaryPaymentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryPaymentInReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Pemasukan Cabang - Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryMovementInReport]", CHtml::resolveValue($model, "roles[summaryMovementInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryMovementInReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Pengeluaran Cabang - Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryMovementOutReport]", CHtml::resolveValue($model, "roles[summaryMovementOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryMovementOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Sub Pekerjaan Luar</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryWorkOrderExpenseReport]", CHtml::resolveValue($model, "roles[summaryWorkOrderExpenseReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryWorkOrderExpenseReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Material</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryMovementOutMaterialReport]", CHtml::resolveValue($model, "roles[summaryMovementOutMaterialReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryMovementOutMaterialReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rekap Jurnal Umum Kas</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryCashReport]", CHtml::resolveValue($model, "roles[summaryCashReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryCashReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][generalLedgerReport]", CHtml::resolveValue($model, "roles[generalLedgerReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'generalLedgerReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Piutang</td>
        </tr>
        <tr>
            <td>Buku Besar Pembantu Piutang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][receivableJournalReport]", CHtml::resolveValue($model, "roles[receivableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receivableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Belum Lunas Customer</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][customerReceivableReport]", CHtml::resolveValue($model, "roles[customerReceivableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'customerReceivableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Belum Lunas Asuransi</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][insuranceReceivableReport]", CHtml::resolveValue($model, "roles[insuranceReceivableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'insuranceReceivableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Piutang Customer</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][receivableReport]", CHtml::resolveValue($model, "roles[receivableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'receivableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penerimaan Penjualan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentInReport]", CHtml::resolveValue($model, "roles[paymentInReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentInReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Penjualan</td>
        </tr>
        <tr>
            <td>Penjualan Summary</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleSummaryReport]", CHtml::resolveValue($model, "roles[saleSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Pelanggan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleCustomerSummaryReport]", CHtml::resolveValue($model, "roles[saleCustomerSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleCustomerSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Pelanggan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleCustomerReport]", CHtml::resolveValue($model, "roles[saleCustomerReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleCustomerReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleProductSummaryReport]", CHtml::resolveValue($model, "roles[saleProductSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleProductSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleProductReport]", CHtml::resolveValue($model, "roles[saleProductReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleProductReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Jasa</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleServiceSummaryReport]", CHtml::resolveValue($model, "roles[saleServiceSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleServiceSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Jasa</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleServiceReport]", CHtml::resolveValue($model, "roles[saleServiceReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleServiceReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Kendaraan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleVehicleReport]", CHtml::resolveValue($model, "roles[saleVehicleReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleVehicleReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Jasa + Kategori Produk</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleServiceProductCategoryReport]", CHtml::resolveValue($model, "roles[saleServiceProductCategoryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleServiceProductCategoryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Retail</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleRetailReport]", CHtml::resolveValue($model, "roles[saleRetailReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleRetailReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Kas</td>
        </tr>
        <tr>
            <td>Approval Kas Harian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashDailyApprovalReport]", CHtml::resolveValue($model, "roles[cashDailyApprovalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailyApprovalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Summary Kas Harian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashDailySummaryReport]", CHtml::resolveValue($model, "roles[cashDailySummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashDailySummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][financialForecastReport]", CHtml::resolveValue($model, "roles[financialForecastReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'financialForecastReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Cash Transaction</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][cashTransactionReport]", CHtml::resolveValue($model, "roles[cashTransactionReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'cashTransactionReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Hutang</td>
        </tr>
        <tr>
            <td>Buku Besar Pembantu Hutang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][payableJournalReport]", CHtml::resolveValue($model, "roles[payableJournalReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'payableJournalReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Belum Lunas Supplier</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][supplierPayableReport]", CHtml::resolveValue($model, "roles[supplierPayableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'supplierPayableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Hutang Supplier</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][payableReport]", CHtml::resolveValue($model, "roles[payableReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'payableReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembayaran Hutang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][paymentOutReport]", CHtml::resolveValue($model, "roles[paymentOutReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'paymentOutReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Pembelian</td>
        </tr>
        <tr>
            <td>Pembelian Summary</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseSummaryReport]", CHtml::resolveValue($model, "roles[purchaseSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian per Pemasok</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseSupplierSummaryReport]", CHtml::resolveValue($model, "roles[purchaseSupplierSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseSupplierSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian per Pemasok</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseSupplierReport]", CHtml::resolveValue($model, "roles[purchaseSupplierReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseSupplierReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian per Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseProductSummaryReport]", CHtml::resolveValue($model, "roles[purchaseProductSummaryReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseProductSummaryReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian per Barang</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseProductReport]", CHtml::resolveValue($model, "roles[purchaseProductReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseProductReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Pajak</td>
        </tr>
        <tr>
            <td>Penjualan Ppn</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][saleTaxReport]", CHtml::resolveValue($model, "roles[saleTaxReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'saleTaxReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian Ppn</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][purchaseTaxReport]", CHtml::resolveValue($model, "roles[purchaseTaxReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'purchaseTaxReport')); ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Keuangan</td>
        </tr>
        <tr>
            <td>Laba/Rugi (induk)</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryProfitLossReport]", CHtml::resolveValue($model, "roles[summaryProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laba/Rugi (Standar)</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][standardProfitLossReport]", CHtml::resolveValue($model, "roles[standardProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Laba/Rugi (Multi Periode)</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][multiProfitLossReport]", CHtml::resolveValue($model, "roles[multiProfitLossReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'multiProfitLossReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Induk)</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][summaryBalanceSheetReport]", CHtml::resolveValue($model, "roles[summaryBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'summaryBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Standard)</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][standardBalanceSheetReport]", CHtml::resolveValue($model, "roles[standardBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'standardBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Multi Periode)</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][multiBalanceSheetReport]", CHtml::resolveValue($model, "roles[multiBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'multiBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Bank Bulanan</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][multiBalanceSheetReport]", CHtml::resolveValue($model, "roles[multiBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'multiBalanceSheetReport')); ?>
            </td>
        </tr>
        <tr>
            <td>Transaksi Harian</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php echo CHtml::checkBox("User[roles][multiBalanceSheetReport]", CHtml::resolveValue($model, "roles[multiBalanceSheetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'multiBalanceSheetReport')); ?>
            </td>
        </tr>
<!--        <tr>
            <td style="text-align: center; font-weight: bold; background-color: greenyellow" colspan="2">Management</td>
        </tr>
        <tr>
            <td>Daftar Aset Tetap</td>
            <td style="text-align: center">
                <?php //echo $counter; ?>
                <?php //echo CHtml::checkBox("User[roles][fixedAssetReport]", CHtml::resolveValue($model, "roles[fixedAssetReport]"), array('id' => 'User_roles_' . $counter++, 'value' => 'fixedAssetReport')); ?>
            </td>
        </tr>-->
    </tbody>
</table>