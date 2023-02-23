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
                            Yii::app()->user->checkAccess('summaryBalanceSheetReport') || 
                            Yii::app()->user->checkAccess('standardBalanceSheetReport')
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
                                        'label' => 'Neraca (induk)', 
                                        'url' => array('/report/balanceSheet/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryBalanceSheetReport')
                                    ),
                                    array(
                                        'label' => 'Neraca (Standar)', 
                                        'url' => array('/report/balanceSheetDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('standardBalanceSheetReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('transactionJournalReport') || 
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
                                        'url' => array('/report/transactionJournalSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('transactionJournalReport')
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
                                    'label' => 'Faktur Belum Lunas', 
                                    'url' => array('/report/receivable/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
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
                            Yii::app()->user->checkAccess('saleOrderReport') || 
                            Yii::app()->user->checkAccess('saleInvoiceReport')
                        ): ?>
                            <h2>Penjualan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan per Pelanggan', 
                                        'url' => array('/report/saleRetailCustomer/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Pelanggan', 
                                        'url' => array('/report/saleRetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Barang/Jasa', 
                                        'url' => array('/report/saleRetailProductService/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Barang', 
                                        'url' => array('/report/saleRetailProduct/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Jasa', 
                                        'url' => array('/report/saleRetailService/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('generalManager')
                        ): ?>
                            <h2>Aset Tetap</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Daftar Aset Tetap', 
                                        'url' => array('/report/fixedAsset/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('generalManager')
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
                            Yii::app()->user->checkAccess('purchaseOrderReport')
                        ): ?>
                            <h2>Pembelian</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Pembelian per Pemasok', 
                                        'url' => array('/report/purchaseSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Pembelian per Pemasok', 
                                        'url' => array('/report/purchaseOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian per Barang', 
                                        'url' => array('/report/purchasePerProduct/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Pembelian per Barang', 
                                        'url' => array('/report/purchasePerProductDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ):*/ ?>
                            <h2>Persediaan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Kartu Stok Persediaan', 
                                        'url' => array('/report/inventoryValue/summary'), 
//                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                ),
                            )); ?>
                        <?php //endif; ?>
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
                            Yii::app()->user->checkAccess('warehouseStockReport') || 
                            Yii::app()->user->checkAccess('stockCardReport')
                        ): ?>
                            <h2>Gudang</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Kuantitas Barang per Gudang', 
                                        'url' => array('/frontDesk/inventory/check'), 
                                        'visible' => (Yii::app()->user->checkAccess('warehouseStockReport'))
                                    ),
                                    array(
                                        'label' => 'Mutasi per Barang', 
                                        'url' => array('/report/stockCard/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockCardReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('generalManager')
                        ): ?>
                            <h2>Pekerjaan Pesanan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laporan Mekanik', 
                                        'url' => array('/report/mechanicPerformance/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('generalManager')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>