<table>
    <thead>
        <tr>
            <th style="text-align: center; width: 50%">
                <?php if (CHtml::resolveValue($model, "roles[reportHead]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
                <?php //echo CHtml::label('HEAD DEPT', 'User_roles_' . $counter++, array('style' => 'display: inline')); ?>
            </th>
            <th style="text-align: center">Laporan</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Laba/Rugi (induk)</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[summaryProfitLossReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Laba/Rugi (Standar)</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[standardProfitLossReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Laba/Rugi (Multi Periode)</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[multiProfitLossReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Induk)</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[summaryBalanceSheetReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Standard)</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[standardBalanceSheetReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Neraca (Multi Periode)</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[multiBalanceSheetReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Jurnal Umum</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[transactionJournalReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Ringkasan Buku Besar</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[journalSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[generalLedgerReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Approval Kas Harian</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashDailyApprovalReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Summary Kas Harian</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashDailySummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Financial Forecast</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[financialForecastReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Cash Transaction</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[cashTransactionReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Buku Besar Pembantu Piutang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[receivableJournalReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Belum Lunas Customer</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[customerReceivableReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Belum Lunas Asuransi</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[insuranceReceivableReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Piutang Customer</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[receivableReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penerimaan Penjualan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentInReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Summary</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Pelanggan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleCustomerSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Pelanggan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleCustomerReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Barang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleProductSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Barang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleProductReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan per Jasa</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleServiceSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Jasa</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleServiceReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan per Kendaraan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleVehicleReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Penjualan Ppn</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleTaxReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penjualan Jasa + Kategori Produk</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[saleServiceProductCategoryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Daftar Aset Tetap</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[fixedAssetReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Buku Besar Pembantu Hutang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[payableJournalReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Faktur Pembelian Belum Lunas</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[supplierPayableReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Hutang Supplier</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[payableReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembayaran Hutang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[paymentOutReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian Summary</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian per Pemasok</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseSupplierSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian per Pemasok</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseSupplierReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Pembelian per Barang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseProductSummaryReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian per Barang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseProductReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Rincian Pembelian Ppn</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[purchaseTaxReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Nilai Stok Persediaan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockValueReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Stok Quantity + Nilai Stok Persediaan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockQuantityValueReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Posisi Stok Gudang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockPositionReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Kartu Stok Gudang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[warehouseStockReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Mutasi per Barang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockCardItemReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Mutasi per Gudang</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[stockCardWarehouseReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penyelesaian Pesanan per Pekerjaan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderServiceReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Penyelesaian Pesanan per Kendaraan</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[workOrderVehicleReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Mekanik Performance</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[mechanicPerformanceReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Salesman Performance</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[salesmanPerformanceReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td>Transaksi Harian</td>
            <td style="text-align: center">
                <?php if (CHtml::resolveValue($model, "roles[dailyTransactionReport]")): ?>
                    <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/icons/check_green.png', '', array('width' => 20)); ?>
                <?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>