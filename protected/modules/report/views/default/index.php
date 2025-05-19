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
                            Yii::app()->user->checkAccess('stockInventoryReport') || 
                            Yii::app()->user->checkAccess('stockCardReport') || 
                            Yii::app()->user->checkAccess('stockCardWarehouseReport')
                        ): ?>
                            <h2>Gudang</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Stok Gudang', 
                                        'url' => array('/frontDesk/inventory/check'), 
                                        'visible' => (Yii::app()->user->checkAccess('warehouseStockReport'))
                                    ),
                                    array(
                                        'label' => 'Kartu Stok', 
                                        'url' => array('/report/stockCard/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockCardItemReport')
                                    ),
                                    array(
                                        'label' => 'Mutasi per Barang', 
                                        'url' => array('/report/stockCardWithAmount/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockCardItemReport')
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
                            Yii::app()->user->checkAccess('stockCardReport')
                        ): ?>
                            <h2>Persediaan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Nilai Stok Persediaan', 
                                        'url' => array('/report/inventoryValue/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockValueReport')
                                    ),
                                    array(
                                        'label' => 'Stok Quantity + Nilai Persediaan', 
                                        'url' => array('/report/inventoryStockValue/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockQuantityValueReport')
                                    ),
                                    array(
                                        'label' => 'Posisi Stok Gudang', 
                                        'url' => array('/report/stockCardCategory/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('stockPositionReport')
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
                                    array(
                                        'label' => 'Laporan Salesman', 
                                        'url' => array('/report/salesmanPerformance/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
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
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport'),
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
                                        'label' => 'Rekap Jurnal Umum Sub Pekerjaan Luar', 
                                        'url' => array('/report/transactionJournalSummary/summaryWorkOrderExpense'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Material', 
                                        'url' => array('/report/transactionJournalSummary/summaryMovementOutMaterial'), 
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
                                    'label' => 'Piutang Customer Summary', 
                                    'url' => array('/report/receivableCustomer/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Customer Detail', 
                                    'url' => array('/report/receivableDetail/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
                                ),
//                                array(
//                                    'label' => 'Kartu Piutang Customer', 
//                                    'url' => array('/report/receivableTransaction/summary'), 
//                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
//                                ),
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
                                    array(
                                        'label' => 'Rincian Penjualan per Kendaraan', 
                                        'url' => array('/report/saleVehicleProduct/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan Jasa + Kategori Produk', 
                                        'url' => array('/report/saleByProductCategoryServiceType/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan Jasa + Kategori Produk Summary', 
                                        'url' => array('/report/companySaleByProductCategoryServiceType/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan Retail', 
                                        'url' => array('/report/saleFlowSummary/transaction'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleSummaryReport'))
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
                                        'url' => array('/accounting/cashDailySummary/index'), 
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
                                        'label' => 'Faktur Belum Lunas Supplier', 
                                        'url' => array('/report/payable/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('supplierPayableReport')
                                    ),
                                    array(
                                        'label' => 'Hutang Supplier Summary', 
                                        'url' => array('/report/payableSupplier/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableReport')
                                    ),
                                    array(
                                        'label' => 'Hutang Supplier Detail', 
                                        'url' => array('/report/payableDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableReport')
                                    ),
//                                    array(
//                                        'label' => 'Kartu Hutang Supplier', 
//                                        'url' => array('/report/payableTransaction/summary'), 
//                                        'visible' => Yii::app()->user->checkAccess('payableReport')
//                                    ),
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
                            Yii::app()->user->checkAccess('saleTaxReport') ||
                            Yii::app()->user->checkAccess('purchaseTaxReport')
                        ): ?>
                            <h2>Pajak</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laporan Penjualan PPn (Rincian & Detail)', 
                                        'url' => array('/report/saleInvoiceTaxOnlySummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian PPn (Rincian & Detail)', 
                                        'url' => array('/report/purchaseInvoiceTaxOnlySummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Ppn Recap Bulan', 
                                        'url' => array('/report/saleInvoiceCustomerTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian Ppn Recap Bulan', 
                                        'url' => array('/report/purchaseInvoiceSupplierTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Ppn Recap Tahun', 
                                        'url' => array('/report/saleInvoiceTaxYearly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian Ppn Recap Tahun', 
                                        'url' => array('/report/purchaseInvoiceTaxYearly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Ppn Summary', 
                                        'url' => array('/report/yearlySaleTaxSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian Ppn Summary', 
                                        'url' => array('/report/yearlyPurchaseTaxSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan NON Ppn Recap Bulan', 
                                        'url' => array('/report/saleInvoiceNonTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian NON Ppn Recap Bulan', 
                                        'url' => array('/report/purchaseInvoiceNonTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
//                            Yii::app()->user->checkAccess('summaryProfitLossReport') ||
//                            Yii::app()->user->checkAccess('standardProfitLossReport') || 
//                            Yii::app()->user->checkAccess('multiProfitLossReport') || 
//                            Yii::app()->user->checkAccess('summaryBalanceSheetReport') || 
//                            Yii::app()->user->checkAccess('standardBalanceSheetReport') || 
                            Yii::app()->user->checkAccess('director')
                        ): ?>
                            <h2>Keuangan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laba Rugi (induk)', 
                                        'url' => array('/report/profitLoss/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laba Rugi (Standar)', 
                                        'url' => array('/report/profitLossDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laba Rugi (Multi Periode)', 
                                        'url' => array('/report/profitLossMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Neraca (induk)', 
                                        'url' => array('/report/balanceSheet/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Neraca (Standar)', 
                                        'url' => array('/report/balanceSheetDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Neraca (Multi Periode)', 
                                        'url' => array('/report/balanceSheetMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Bank Bulanan', 
                                        'url' => array('/report/paymentByBankMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Transaksi Harian', 
                                        'url' => array('/report/dailyTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailyTransactionReport')
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
                            <h2>Management</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Daftar Aset Tetap', 
                                        'url' => array('/report/fixedAsset/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('fixedAssetReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Tahunan', 
                                        'url' => array('/report/yearlySaleSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Project', 
                                        'url' => array('/report/saleByProject/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Konfirmasi Transaksi Harian', 
                                        'url' => array('/report/dailyTransactionConfirmation/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Payment Type Bulanan', 
                                        'url' => array('/report/paymentMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Parts Bulanan', 
                                        'url' => array('/report/monthlyProductSale/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Jasa Bulanan', 
                                        'url' => array('/report/monthlyServiceSale/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Analisis Penjualan Parts', 
                                        'url' => array('/report/productSubMasterCategoryStatistics/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan User Performance', 
                                        'url' => array('/report/transactionLogUserCounter/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan User Transaction Input', 
                                        'url' => array('/report/userPerformanceDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Retail Summary', 
                                        'url' => array('/report/saleFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian Summary', 
                                        'url' => array('/report/purchaseFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Perpindahan Barang Summary', 
                                        'url' => array('/report/warehouseFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Penyesuaian Stok Gudang', 
                                        'url' => array('/report/stockAdjustment/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Jurnal Penyesuaian', 
                                        'url' => array('/report/journalAdjustment/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Laporan Penjualan Body Repair', 
                                        'url' => array('/report/bodyRepairCosting/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Log Transaksi', 
                                        'url' => array('/report/transactionLog/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
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