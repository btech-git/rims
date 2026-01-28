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
                            Yii::app()->user->checkAccess('warehouseStockReport') || 
                            Yii::app()->user->checkAccess('stockCardItemReport') || 
                            Yii::app()->user->checkAccess('stockCardWarehouseReport') || 
                            Yii::app()->user->checkAccess('deliveryReport') || 
                            Yii::app()->user->checkAccess('receiveItemReport') || 
                            Yii::app()->user->checkAccess('workOrderExpenseReport')
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
                                    array(
                                        'label' => 'Pengiriman Barang', 
                                        'url' => array('/report/delivery/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('deliveryReport')
                                    ),
                                    array(
                                        'label' => 'Penerimaan Barang', 
                                        'url' => array('/report/receiveItem/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('receiveItemReport')
                                    ),
                                    array(
                                        'label' => 'Sub Pekerjaan Luar', 
                                        'url' => array('/report/workOrderExpense/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('workOrderExpenseReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('stockValueReport') ||
                            Yii::app()->user->checkAccess('stockQuantityValueReport') ||
                            Yii::app()->user->checkAccess('stockPositionReport')
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
                                    array(
                                        'label' => 'Stok Ban per Tahun Produksi', 
                                        'url' => array('/report/stockTire/check'), 
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
                            Yii::app()->user->checkAccess('mechanicPerformanceReport') ||
                            Yii::app()->user->checkAccess('salesmanPerformanceReport')
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
                                        'label' => 'Mekanik Performance', 
                                        'url' => array('/report/mechanicPerformance/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('mechanicPerformanceReport')
                                    ),
                                    array(
                                        'label' => 'Salesman Performance', 
                                        'url' => array('/report/salesmanPerformance/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('salesmanPerformanceReport')
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
                            Yii::app()->user->checkAccess('generalLedgerReport') || 
                            Yii::app()->user->checkAccess('summaryPurchaseReport') || 
                            Yii::app()->user->checkAccess('summaryPaymentOutReport') || 
                            Yii::app()->user->checkAccess('summarySaleReport') || 
                            Yii::app()->user->checkAccess('summaryPaymentInReport') || 
                            Yii::app()->user->checkAccess('summaryMovementInReport') || 
                            Yii::app()->user->checkAccess('summaryMovementOutReport') || 
                            Yii::app()->user->checkAccess('summaryWorkOrderExpenseReport') || 
                            Yii::app()->user->checkAccess('summaryMovementOutMaterialReport') || 
                            Yii::app()->user->checkAccess('summaryCashReport')
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
                                        'label' => 'Jurnal Umum (unbalanced)', 
                                        'url' => array('/report/transactionJournal/balanceErrorSummary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Ringkasan Buku Besar', 
                                        'url' => array('/report/accountingJournalSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('journalSummaryReport'),
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pembelian', 
                                        'url' => array('/report/transactionJournalSummary/summaryPurchase'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryPurchaseReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pelunasan Pembelian', 
                                        'url' => array('/report/transactionJournalSummary/summaryPaymentOut'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryPaymentOutReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Penjualan', 
                                        'url' => array('/report/transactionJournalSummary/summarySale'), 
                                        'visible' => Yii::app()->user->checkAccess('summarySaleReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Penerimaan Penjualan', 
                                        'url' => array('/report/transactionJournalSummary/summaryPaymentIn'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryPaymentInReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pemasukan Cabang - Barang', 
                                        'url' => array('/report/transactionJournalSummary/summaryMovementIn'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryMovementInReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Pengeluaran Cabang - Barang', 
                                        'url' => array('/report/transactionJournalSummary/summaryMovementOut'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryMovementOutReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Sub Pekerjaan Luar', 
                                        'url' => array('/report/transactionJournalSummary/summaryWorkOrderExpense'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryWorkOrderExpenseReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Material', 
                                        'url' => array('/report/transactionJournalSummary/summaryMovementOutMaterial'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryMovementOutMaterialReport')
                                    ),
                                    array(
                                        'label' => 'Rekap Jurnal Umum Kas', 
                                        'url' => array('/report/transactionJournalSummary/summaryCash'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryCashReport')
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
                            Yii::app()->user->checkAccess('receivableReport') || 
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
                                    'label' => 'Piutang Customer', 
                                    'url' => array('/report/receivableCustomer/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('receivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Customer Detail', 
                                    'url' => array('/report/receivableDetail/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('receivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Customer Bulanan', 
                                    'url' => array('/report/monthlyCustomerReceivable/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Customer Tahunan', 
                                    'url' => array('/report/yearlyCustomerReceivable/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
                                ),
                                array(
                                    'label' => 'Faktur Belum Lunas Asuransi', 
                                    'url' => array('/report/receivableInsuranceCompany/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('insuranceReceivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Asuransi', 
                                    'url' => array('/report/receivableInsuranceData/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('receivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Asuransi Detail', 
                                    'url' => array('/report/receivableInsuranceDetail/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('receivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Asuransi Bulanan', 
                                    'url' => array('/report/monthlyInsuranceReceivable/summary'), 
                                    'visible' => Yii::app()->user->checkAccess('customerReceivableReport')
                                ),
                                array(
                                    'label' => 'Piutang Asuransi Tahunan', 
                                    'url' => array('/report/yearlyInsuranceReceivable/summary'), 
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
                            Yii::app()->user->checkAccess('saleCustomerSummaryReport') || 
                            Yii::app()->user->checkAccess('saleCustomerReport') || 
                            Yii::app()->user->checkAccess('saleSummaryReport') || 
                            Yii::app()->user->checkAccess('saleProductSummaryReport') || 
                            Yii::app()->user->checkAccess('saleServiceSummaryReport') || 
                            Yii::app()->user->checkAccess('saleProductReport') || 
                            Yii::app()->user->checkAccess('saleServiceSummaryReport') || 
                            Yii::app()->user->checkAccess('saleServiceReport') || 
                            Yii::app()->user->checkAccess('saleServiceProductCategoryReport')
                        ): ?>
                            <h2>Penjualan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan Summary', 
                                        'url' => array('/report/saleInvoiceSummary/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Barang', 
                                        'url' => array('/report/saleRetailProduct/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleProductSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Barang', 
                                        'url' => array('/report/saleRetailProductDetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleProductReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Jasa', 
                                        'url' => array('/report/saleRetailService/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleServiceSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Jasa', 
                                        'url' => array('/report/saleRetailServiceDetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleServiceReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan Jasa + Kategori Produk', 
                                        'url' => array('/report/saleByProductCategoryServiceType/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleServiceProductCategoryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan Jasa + Kategori Produk Summary', 
                                        'url' => array('/report/companySaleByProductCategoryServiceType/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleServiceProductCategoryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Customer', 
                                        'url' => array('/report/saleRetailCustomer/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Customer', 
                                        'url' => array('/report/saleRetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Asuransi', 
                                        'url' => array('/report/saleRetailInsurance/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Asuransi', 
                                        'url' => array('/report/saleRetailInsuranceDetail/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerReport'))
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
                            Yii::app()->user->checkAccess('cashTransactionReport') || 
                            Yii::app()->user->checkAccess('monthlyBankingReport') || 
                            Yii::app()->user->checkAccess('dailyTransactionReport')
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
                                        'label' => 'Transaksi Kas', 
                                        'url' => array('/report/cashTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('cashTransactionReport')
                                    ),
                                    array(
                                        'label' => 'Bank Bulanan', 
                                        'url' => array('/report/paymentByBankMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlyBankingReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('payableJournalReport') || 
                            Yii::app()->user->checkAccess('supplierPayableReport') || 
                            Yii::app()->user->checkAccess('payableReport') || 
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
                                        'label' => 'Hutang Supplier', 
                                        'url' => array('/report/payableSupplier/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableReport')
                                    ),
                                    array(
                                        'label' => 'Hutang Supplier Detail', 
                                        'url' => array('/report/payableDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableReport')
                                    ),
                                    array(
                                        'label' => 'Kartu Hutang', 
                                        'url' => array('/report/payableTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableReport')
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
                            Yii::app()->user->checkAccess('purchaseSummaryReport') ||
                            Yii::app()->user->checkAccess('purchaseSupplierSummaryReport') ||
                            Yii::app()->user->checkAccess('purchaseSupplierReport') ||
                            Yii::app()->user->checkAccess('purchaseProductSummaryReport') ||
                            Yii::app()->user->checkAccess('purchaseProductReport')
                        ): ?>
                            <h2>Pembelian</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Faktur Pembelian', 
                                        'url' => array('/report/purchaseInvoiceSummary/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('purchaseSummaryReport'))
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
                                        'label' => 'Pembelian per Parts', 
                                        'url' => array('/report/purchasePerProduct/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseProductSummaryReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Pembelian per Parts', 
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
    
    <hr />

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('dailySaleBranchReport') ||
                            Yii::app()->user->checkAccess('dailySaleAllBranchReport') ||
                            Yii::app()->user->checkAccess('monthlySaleBranchReport') ||
                            Yii::app()->user->checkAccess('monthlySaleAllBranchReport') ||
                            Yii::app()->user->checkAccess('yearlySaleBranchReport') ||
                            Yii::app()->user->checkAccess('yearlySaleAllBranchReport')
                        ): ?>
                            <h2>Penjualan Cabang</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan per Cabang Harian', 
                                        'url' => array('/report/saleInvoiceBranchDaily/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailySaleBranchReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan All Cabang Harian', 
                                        'url' => array('/report/dailyMultipleBranchSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailySaleAllBranchReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Cabang Bulanan', 
                                        'url' => array('/report/monthlySingleBranchSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlySaleBranchReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan All Cabang Bulanan', 
                                        'url' => array('/report/monthlyMultipleBranchSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlySaleAllBranchReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Cabang Tahunan', 
                                        'url' => array('/report/yearlySingleBranchSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlySaleBranchReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan All Cabang Tahunan', 
                                        'url' => array('/report/yearlyMultipleBranchSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlySaleAllBranchReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('dailySaleFrontReport') ||
                            Yii::app()->user->checkAccess('dailySaleAllFrontReport') ||
                            Yii::app()->user->checkAccess('monthlySaleFrontReport') ||
                            Yii::app()->user->checkAccess('monthlySaleAllFrontReport') ||
                            Yii::app()->user->checkAccess('yearlySaleFrontReport') ||
                            Yii::app()->user->checkAccess('yearlySaleAllFrontReport')
                        ): ?>
                            <h2>Penjualan Front</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan per Front Office Harian', 
                                        'url' => array('/report/saleInvoiceMarketingDaily/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailySaleFrontReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan All Front Office Harian', 
                                        'url' => array('/report/dailyMultipleEmployeeSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailySaleAllFrontReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Front Office Bulanan', 
                                        'url' => array('/report/monthlySingleEmployeeSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlySaleFrontReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan All Front Office Bulanan', 
                                        'url' => array('/report/monthlyMultipleEmployeeSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlySaleAllFrontReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Front Office Tahunan', 
                                        'url' => array('/report/yearlySingleEmployeeSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlySaleFrontReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan All Front Office Tahunan', 
                                        'url' => array('/report/yearlyMultipleEmployeeSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlySaleAllFrontReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('dailySaleMechanicReport') ||
                            Yii::app()->user->checkAccess('dailySaleAllMechanicReport') ||
                            Yii::app()->user->checkAccess('monthlySaleMechanicReport') ||
                            Yii::app()->user->checkAccess('monthlySaleAllMechanicReport') ||
                            Yii::app()->user->checkAccess('yearlySaleMechanicReport') ||
                            Yii::app()->user->checkAccess('yearlySaleAllMechanicReport')
                        ): ?>
                            <h2>Penjualan Mechanic</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan per Mekanik Harian', 
                                        'url' => array('/report/registrationTransactionMechanicDaily/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailySaleMechanicReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan all Mekanik Harian', 
                                        'url' => array('/report/dailyMultipleMechanicTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('dailySaleAllMechanicReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Mekanik Bulanan', 
                                        'url' => array('/report/monthlySingleMechanicTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlySaleMechanicReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan all Mekanik Bulanan', 
                                        'url' => array('/report/monthlyMultipleMechanicTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlySaleAllMechanicReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Mekanik Tahunan', 
                                        'url' => array('/report/yearlySingleMechanicTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlySaleMechanicReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan all Mekanik Tahunan', 
                                        'url' => array('/report/yearlyMultipleMechanicTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlySaleAllMechanicReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <hr />

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
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
                                        'label' => 'Penjualan PPn (Rincian & Detail)', 
                                        'url' => array('/report/saleInvoiceTaxOnlySummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian PPn (Rincian & Detail)', 
                                        'url' => array('/report/purchaseInvoiceTaxOnlySummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Ppn Recap Bulan', 
                                        'url' => array('/report/saleInvoiceCustomerTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian Ppn Recap Bulan', 
                                        'url' => array('/report/purchaseInvoiceSupplierTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Ppn Recap Tahun', 
                                        'url' => array('/report/saleInvoiceTaxYearly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian Ppn Recap Tahun', 
                                        'url' => array('/report/purchaseInvoiceTaxYearly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Ppn Summary', 
                                        'url' => array('/report/yearlySaleTaxSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian Ppn Summary', 
                                        'url' => array('/report/yearlyPurchaseTaxSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseTaxReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan NON Ppn Recap Bulan', 
                                        'url' => array('/report/saleInvoiceNonTaxMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTaxReport')
                                    ),
                                    array(
                                        'label' => 'Pembelian NON Ppn Recap Bulan', 
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
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('saleCustomerSummaryReport') || 
                            Yii::app()->user->checkAccess('saleCustomerReport') || 
                            Yii::app()->user->checkAccess('saleVehicleReport') || 
                            Yii::app()->user->checkAccess('saleVehicleMonthlyReport') ||
                            Yii::app()->user->checkAccess('saleVehicleYearlyReport') ||
                            Yii::app()->user->checkAccess('customerFollowUpReport') ||
                            Yii::app()->user->checkAccess('saleTireMonthlyReport') ||
                            Yii::app()->user->checkAccess('saleTireYearlyReport')
                        ): ?>
                            <h2>Customer Data</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan per Customer Tahunan', 
                                        'url' => array('/report/yearlyMultipleCustomerSaleTransaction/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Asuransi Tahunan', 
                                        'url' => array('/report/yearlyMultipleInsuranceSaleTransaction/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Model Kendaraan Bulanan', 
                                        'url' => array('/report/saleInvoiceCarSubModelMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleVehicleMonthlyReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan per Model Kendaraan Tahunan', 
                                        'url' => array('/report/saleInvoiceCarSubModelYearly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleVehicleYearlyReport')
                                    ),
                                    array(
                                        'label' => 'Rincian Penjualan per Brand Kendaraan', 
                                        'url' => array('/report/saleVehicleProduct/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleVehicleReport'))
                                    ),
                                    array(
                                        'label' => 'Penjualan per Kendaraan Customer Tahunan', 
                                        'url' => array('/report/yearlyMultipleVehicleSaleTransaction/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleCustomerSummaryReport'))
                                    ),
                                    array(
                                        'label' => 'Customer Follow Up + Warranty', 
                                        'url' => array('/frontDesk/followUp/adminSales'), 
                                        'visible' => Yii::app()->user->checkAccess('customerFollowUpReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Ban Bulanan', 
                                        'url' => array('/report/monthlyTireSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTireMonthlyReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Ban Tahunan', 
                                        'url' => array('/report/yearlyTireSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTireYearlyReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Oli Bulanan', 
                                        'url' => array('/report/monthlyOilSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTireMonthlyReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Oli Tahunan', 
                                        'url' => array('/report/yearlyOilSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('saleTireYearlyReport')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <hr />

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('monthlyProductSaleReport') ||
                            Yii::app()->user->checkAccess('monthlyServiceSaleReport') ||
                            Yii::app()->user->checkAccess('productCategoryStatisticsReport') ||
                            Yii::app()->user->checkAccess('monthlyProductSaleTransactionReport') ||
                            Yii::app()->user->checkAccess('yearlyProductSaleTransactionReport') ||
                            Yii::app()->user->checkAccess('monthlyMaterialServiceUsage') ||
                            Yii::app()->user->checkAccess('yearlyMaterialServiceUsage')
                        ): ?>
                            <h2>Stock Analysis & Order</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan Parts Bulanan', 
                                        'url' => array('/report/monthlyProductSale/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlyProductSaleReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Jasa Bulanan', 
                                        'url' => array('/report/monthlyServiceSale/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlyServiceSaleReport')
                                    ),
                                    array(
                                        'label' => 'Analisis Penjualan Parts', 
                                        'url' => array('/report/productSubMasterCategoryStatistics/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('productCategoryStatisticsReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Parts & Components Bulanan', 
                                        'url' => array('/report/monthlyProductSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('monthlyProductSaleTransactionReport')
                                    ),
                                    array(
                                        'label' => 'Penjualan Parts & Components Tahunan', 
                                        'url' => array('/report/yearlyProductSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('yearlyProductSaleTransactionReport')
                                    ),
                                    array(
                                        'label' => 'Pemakaian Bahan Material Bulanan', 
                                        'url' => array('/report/monthlyMaterialServiceUsage/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Pemakaian Bahan Material Tahunan', 
                                        'url' => array('/report/yearlyMaterialServiceUsage/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('director')
//                            Yii::app()->user->checkAccess('workOrderServiceReport') ||
//                            Yii::app()->user->checkAccess('workOrderVehicleReport') ||
//                            Yii::app()->user->checkAccess('mechanicPerformanceReport')
                        ): ?>
                            <h2>Management</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Penjualan Tahunan', 
                                        'url' => array('/report/yearlySaleSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Penjualan Project', 
                                        'url' => array('/report/saleInvoiceProjectNonCogs/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Penjualan Project (HPP + COGS)', 
                                        'url' => array('/report/saleInvoiceProject/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Penjualan Body Repair', 
                                        'url' => array('/report/bodyRepairCosting/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Transaksi Harian', 
                                        'url' => array('/report/dailyTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Outstanding Work Order', 
                                        'url' => array('/report/outstandingWorkOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('director')
//                            Yii::app()->user->checkAccess('workOrderServiceReport') ||
//                            Yii::app()->user->checkAccess('workOrderVehicleReport') ||
//                            Yii::app()->user->checkAccess('mechanicPerformanceReport')
                        ): ?>
                            <h2>Management</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Daftar Aset Tetap', 
                                        'url' => array('/report/fixedAsset/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Konfirmasi Transaksi Harian', 
                                        'url' => array('/report/dailyTransactionConfirmation/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Payment Type Bulanan', 
                                        'url' => array('/report/paymentMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Penyesuaian Stok Gudang', 
                                        'url' => array('/report/stockAdjustment/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Jurnal Penyesuaian', 
                                        'url' => array('/report/journalAdjustment/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'User Performance', 
                                        'url' => array('/report/transactionLogUserCounter/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'User Transaction Input', 
                                        'url' => array('/report/userPerformanceDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Log Transaksi', 
                                        'url' => array('/report/transactionLog/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Log Master', 
                                        'url' => array('/report/masterLog/summary'), 
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
    
    <hr />

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-4 columns">
                        <?php if (
                            Yii::app()->user->checkAccess('saleRetailReport') ||
                            Yii::app()->user->checkAccess('director')
                        ): ?>
                            <h2>Transaksi</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Transaksi Retail', 
                                        'url' => array('/report/saleFlowSummary/transaction'), 
                                        'visible' => (Yii::app()->user->checkAccess('saleRetailReport'))
                                    ),
                                    array(
                                        'label' => 'Transaksi Retail Summary', 
                                        'url' => array('/report/saleFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Pembelian Harian Summary', 
                                        'url' => array('/report/purchaseFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Pembelian WO', 
                                        'url' => array('/report/purchaseWorkOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Perpindahan Barang Summary', 
                                        'url' => array('/report/warehouseFlowSummary/summary'), 
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
</div>