<div id="content">
    <div class="row">
        <div class="small-12 columns">
            <div class="breadcrumbs">
                <a href="#">Home</a>
                <span>Report</span>
            </div>
        </div>
    </div>
    <style type="text/css">
        /*.small-1a { width: 12%; border:0px solid #ccc; border-radius: 5px; margin-right:20px; float: left !important; }*/
        #noliststyle ul {
            list-style: none;
            margin: 0;
            padding: 0px;
            height: auto;
        }
        #noliststyle ul li a:hover { text-decoration: underline;}
    </style>

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <div class="clearfix page-action" style="text-align: center">
                    <span style="text-decoration: underline"><h1>REPORTS</h1></span>
                </div>
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('summaryProfitLossReport') ||
                            Yii::app()->user->checkAccess('standardProfitLossReport') || 
                            Yii::app()->user->checkAccess('multiProfitLossReport') || 
                            Yii::app()->user->checkAccess('summaryBalanceSheetReport') || 
                            Yii::app()->user->checkAccess('standardBalanceSheetReport') || 
                            Yii::app()->user->checkAccess('multiBalanceSheetReport')
                        ): ?>
                            <h2>Keuangan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laba Rugi (induk)', 
                                        'url' => array('/report/profitLoss/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryProfitLossReport')
                                    ),
                                    array(
                                        'label' => 'Laba Rugi (Standar)', 
                                        'url' => array('/report/profitLossDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('standardProfitLossReport')
                                    ),
                                    array(
                                        'label' => 'Laba Rugi (Multi Periode)', 
                                        'url' => array('/report/profitLossMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('multiProfitLossReport')
                                    ),
                                    array(
                                        'label' => 'Neraca (induk)', 
                                        'url' => array('/report/balanceSheet/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryBalanceSheetReport')
                                    ),
                                    array(
                                        'label' => 'Neraca (Standar)', 
                                        'url' => array('/report/balanceSheetDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('standardBalanceSheetReport')
                                    ),
                                    array(
                                        'label' => 'Neraca (Multi Periode)', 
                                        'url' => array('/report/balanceSheetMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('multiBalanceSheetReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('transactionJournalReport') || 
                            Yii::app()->user->checkAccess('journalSummaryReport') || 
                            Yii::app()->user->checkAccess('generalLedgerReport')
                        ): ?>
                            <h2>Buku Besar</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Jurnal Umum', 
                                        'url' => array('/report/transactionJournal/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('transactionJournalReport')
                                    ),
                                    array(
                                        'label' => 'Ringkasan Buku Besar', 
                                        'url' => array('/report/accountingJournalSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('generalManager'),
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pembelian', 
                                        'url' => array('/report/transactionJournalSummary/summaryPurchase'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pelunasan Pembelian', 
                                        'url' => array('/report/transactionJournalSummary/summaryPaymentOut'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Penjualan', 
                                        'url' => array('/report/transactionJournalSummary/summarySale'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Penerimaan Penjualan', 
                                        'url' => array('/report/transactionJournalSummary/summaryPaymentIn'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pemasukan Cabang - Barang', 
                                        'url' => array('/report/transactionJournalSummary/summaryMovementIn'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pengeluaran Cabang - Barang', 
                                        'url' => array('/report/transactionJournalSummary/summaryMovementOut'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Kas', 
                                        'url' => array('/report/transactionJournalSummary/summaryCash'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Buku Besar', 
                                        'url' => array('/report/generalLedger/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('generalLedgerReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('cashDailyApprovalReport') || 
                            Yii::app()->user->checkAccess('cashDailySummaryReport') || 
                            Yii::app()->user->checkAccess('financialForecastReport') || 
                            Yii::app()->user->checkAccess('cashTransactionReport')
                        ): ?>
                            <h2>Kas</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Approval Kas Harian', 
                                        'url' => array('/accounting/cashDailySummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('cashDailyApprovalReport')
                                    ),
                                    array(
                                        'label' => 'Summary Kas Harian', 
                                        'url' => array('/accounting/cashDailySummary/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('cashDailySummaryReport')
                                    ),
                                    array(
                                        'label' => 'Financial Forecast', 
                                        'url' => array('/report/financialForecast/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('financialForecastReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Cash Transaction', 
                                        'url' => array('/report/cashTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('cashTransactionReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <hr />
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('receivableJournalReport') || 
                            Yii::app()->user->checkAccess('customerReceivableReport') || 
                            Yii::app()->user->checkAccess('insuranceReceivableReport') || 
                            Yii::app()->user->checkAccess('paymentInReport')
                        ): ?>
                        <h2>Piutang</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Buku Besar Pembantu Piutang', 
                                    'url' => array('/report/receivableLedger/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('receivableJournalReport')
                                ),
                                array(
                                    'label' => 'Faktur Belum Lunas Customer', 
                                    'url' => array('/report/receivable/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
                                ),
                                array(
                                    'label' => 'Faktur Belum Lunas Asuransi', 
                                    'url' => array('/report/receivableInsuranceCompany/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('insuranceReceivableReport')
                                ),
                                array(
                                    'label' => 'Rincian Penerimaan Penjualan', 
                                    'url' => array('/report/paymentIn/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('paymentInReport')
                                ),
                            ),
                        )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('saleCustomerSummaryReport') || 
                            Yii::app()->user->checkAccess('saleCustomerReport') || 
                            Yii::app()->user->checkAccess('saleProductSummaryReport') || 
                            Yii::app()->user->checkAccess('saleProductReport') || 
                            Yii::app()->user->checkAccess('saleServiceSummaryReport') || 
                            Yii::app()->user->checkAccess('saleServiceReport')
                        ): ?>
                            <h2>Penjualan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan Summary', 
                                        'url' => array('/report/saleInvoiceSummary/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Pelanggan', 
                                        'url' => array('/report/saleRetailCustomer/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Pelanggan', 
                                        'url' => array('/report/saleRetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Barang', 
                                        'url' => array('/report/saleRetailProduct/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Barang', 
                                        'url' => array('/report/saleRetailProductDetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleProductReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Jasa', 
                                        'url' => array('/report/saleRetailService/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleServiceReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Jasa', 
                                        'url' => array('/report/saleRetailServiceDetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleServiceReport'))
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('fixedAssetReport')
                        ): ?>
                            <h2>Aset Tetap</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Daftar Aset Tetap', 
                                        'url' => array('/report/fixedAsset/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('fixedAssetReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <hr />
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('payableJournalReport') || 
                            Yii::app()->user->checkAccess('supplierPayableReport') || 
                            Yii::app()->user->checkAccess('paymentOutReport')
                        ): ?>
                            <h2>Hutang</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Buku Besar Pembantu Hutang', 
                                        'url' => array('/report/payableLedger/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableJournalReport')
                                    ),
                                    array(
                                        'label' => 'Faktur Belum Lunas', 
                                        'url' => array('/report/payable/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('supplierPayableReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Pembayaran Hutang', 
                                        'url' => array('/report/paymentOut/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('paymentOutReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('purchaseSupplierSummaryReport') ||
                            Yii::app()->user->checkAccess('purchaseSupplierReport') ||
                            Yii::app()->user->checkAccess('purchaseProductSummaryReport') ||
                            Yii::app()->user->checkAccess('purchaseProductReport')
                        ): ?>
                            <h2>Pembelian</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Pembelian Summary', 
                                        'url' => array('/report/purchaseInvoiceSummary/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('purchaseSupplierSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Pembelian per Pemasok', 
                                        'url' => array('/report/purchaseSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseSupplierSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Pembelian per Pemasok', 
                                        'url' => array('/report/purchaseOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseSupplierReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian per Barang', 
                                        'url' => array('/report/purchasePerProduct/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseProductSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Pembelian per Barang', 
                                        'url' => array('/report/purchasePerProductDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseProductReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('stockCardReport')
                        ): ?>
                            <h2>Persediaan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Kartu Stok Persediaan', 
                                        'url' => array('/report/inventoryValue/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockCardReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <hr />
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('stockInventoryReport') || 
                            Yii::app()->user->checkAccess('stockCardReport') || 
                            Yii::app()->user->checkAccess('stockCardWarehouseReport')
                        ): ?>
                            <h2>Gudang</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Kuantitas Barang per Gudang', 
                                        'url' => array('/frontDesk/inventory/check'), 
                                        'visible' => (Yii::app()->user->checkAccess('stockInventoryReport'))
                                    ),
                                    array(
                                        'label' => 'Mutasi per Barang', 
                                        'url' => array('/report/stockCard/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockCardReport')
                                    ),
                                    array(
                                        'label' => 'Mutasi per Gudang', 
                                        'url' => array('/report/stockCardByWarehouse/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockCardWarehouseReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('workOrderServiceReport') ||
                            Yii::app()->user->checkAccess('workOrderVehicleReport') ||
                            Yii::app()->user->checkAccess('mechanicPerformanceReport')
                        ): ?>
                            <h2>Pekerjaan Pesanan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penyelesaian Pesanan per Pekerjaan', 
                                        'url' => array('/report/registrationServiceCategory/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('workOrderServiceReport')
                                    ),
                                    array(
                                        'label' => 'Penyelesaian Pesanan per Kendaraan', 
                                        'url' => array('/report/registrationVehicleCarMake/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('workOrderVehicleReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Mekanik', 
                                        'url' => array('/report/mechanicPerformance/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('mechanicPerformanceReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('workOrderServiceReport') ||
                            Yii::app()->user->checkAccess('workOrderVehicleReport') ||
                            Yii::app()->user->checkAccess('mechanicPerformanceReport')
                        ):*/ ?>
                            <h2>Salesman</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laporan Salesman', 
                                        'url' => array('/report/salesmanPerformance/summary'), 
//                                        'visible' => Yii::app()->user->checkAccess('mechanicPerformanceReport')
                                    ),
                                ),
                            )); ?>
                        <?php //endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>