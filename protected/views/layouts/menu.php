<ul class="right clearfix">
    <?php if (
        Yii::app()->user->checkAccess('pendingTransactionView') || 
        Yii::app()->user->checkAccess('orderOutstandingView') || 
        Yii::app()->user->checkAccess('requestApprovalView') || 
        Yii::app()->user->checkAccess('masterApprovalView')
    ): ?>
        <li class="mdropdown"><a href="#">PENDING</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Daftar Transaksi Pending', 
                        'url' => array('/transaction/pendingTransaction/index'), 
                        'visible' => Yii::app()->user->checkAccess('pendingTransactionView')
                    ),
                    array(
                        'label' => 'Order Outstanding', 
                        'url' => array('/frontDesk/outstandingOrder/index'), 
                        'visible' => Yii::app()->user->checkAccess('orderOutstandingView')
                    ),
                    array(
                        'label' => 'Approval Permintaan', 
                        'url' => array('/frontDesk/pendingRequest/index'), 
                        'visible' => Yii::app()->user->checkAccess('requestApprovalView')
                    ),
                    array(
                        'label' => 'Approval Data Master', 
                        'url' => array('/master/pendingApproval/index'), 
                        'visible' => Yii::app()->user->checkAccess('masterApprovalView')
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('generalRepairCreate') || 
        Yii::app()->user->checkAccess('generalRepairEdit') || 
        Yii::app()->user->checkAccess('bodyRepairCreate') || 
        Yii::app()->user->checkAccess('bodyRepairEdit') || 
        Yii::app()->user->checkAccess('inspectionCreate') || 
        Yii::app()->user->checkAccess('inspectionEdit') || 
        Yii::app()->user->checkAccess('cashierCreate') || 
        Yii::app()->user->checkAccess('cashierEdit') || 
        Yii::app()->user->checkAccess('workOrderApproval') || 
        Yii::app()->user->checkAccess('cashierApproval') || 
        Yii::app()->user->checkAccess('customerQueueApproval')
    ): ?>
        <li class="mdropdown"><a href="#">RESEPSIONIS</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Pendaftaran Customer', 
                        'url' => array('/frontDesk/customerRegistration/vehicleList'), 
                        'visible' => (Yii::app()->user->checkAccess('generalRepairCreate') || Yii::app()->user->checkAccess('bodyRepairCreate'))
                    ),
                    array(
                        'label' => 'General Repair', 
                        'url' => array('/frontDesk/generalRepairRegistration/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('generalRepairCreate') || Yii::app()->user->checkAccess('generalRepairEdit'))
                    ),
                    array(
                        'label' => 'Body Repair', 
                        'url' => array('/frontDesk/bodyRepairRegistration/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('bodyRepairCreate') || Yii::app()->user->checkAccess('bodyRepairEdit'))
                    ),
                    array(
                        'label' => 'Inspeksi Kendaraan', 
                        'url' => array('/frontDesk/vehicleInspection/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('inspectionCreate') || Yii::app()->user->checkAccess('inspectionEdit'))
                    ),
                    array(
                        'label' => 'SPK', 
                        'url' => array('/frontDesk/workOrder/admin'),
                        'visible' => Yii::app()->user->checkAccess('workOrderApproval')
                    ),
                    array(
                        'label' => 'Kasir', 
                        'url' => array('/frontDesk/registrationTransaction/cashier'), 
                        'visible' => (Yii::app()->user->checkAccess('cashierApproval'))
                    ),
                    array(
                        'label' => 'Daftar Antrian Customer', 
                        'url' => array('/frontDesk/registrationTransaction/customerWaitlist'), 
                        'visible' => Yii::app()->user->checkAccess('customerQueueApproval')
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('requestOrderCreate') || 
        Yii::app()->user->checkAccess('requestOrderEdit') || 
        Yii::app()->user->checkAccess('purchaseOrderCreate') || 
        Yii::app()->user->checkAccess('purchaseOrderEdit') || 
        Yii::app()->user->checkAccess('saleOrderCreate') || 
        Yii::app()->user->checkAccess('saleOrderEdit') || 
        Yii::app()->user->checkAccess('saleInvoiceCreate') || 
        Yii::app()->user->checkAccess('saleInvoiceEdit') || 
        Yii::app()->user->checkAccess('paymentInCreate') || 
        Yii::app()->user->checkAccess('paymentInEdit') || 
        Yii::app()->user->checkAccess('paymentOutCreate') || 
        Yii::app()->user->checkAccess('paymentOutEdit') || 
        Yii::app()->user->checkAccess('cashTransactionCreate') || 
        Yii::app()->user->checkAccess('cashTransactionEdit') || 
        Yii::app()->user->checkAccess('adjustmentJournalCreate') || 
        Yii::app()->user->checkAccess('adjustmentJournalEdit')
    ) : ?>
        <li class="mdropdown"> <a href="#">TRANSAKSI</a>							
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'PEMBELIAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Order Permintaan', 
                        'url' => array('/transaction/transactionRequestOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('requestOrderCreate') || Yii::app()->user->checkAccess('requestOrderEdit'))
                    ),
                    array(
                        'label' => 'Order Pembelian', 
                        'url' => array('/transaction/transactionPurchaseOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('purchaseOrderCreate') || Yii::app()->user->checkAccess('purchaseOrderEdit'))
                    ),
                    array(
                        'label' => 'Perbandingan', 
                        'url' => array('/transaction/compare/step1'), 
                        'visible' => (Yii::app()->user->checkAccess('purchaseHead'))
                    ),
                    array('label' => 'PENJUALAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Order Penjualan', 
                        'url' => array('/transaction/transactionSalesOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('saleOrderCreate') || Yii::app()->user->checkAccess('saleOrderEdit'))
                    ),
                    array(
                        'label' => 'Faktur Penjualan', 
                        'url' => array('/transaction/invoiceHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('saleInvoiceCreate') || Yii::app()->user->checkAccess('saleInvoiceEdit'))
                    ),
                    array('label' => 'PELUNASAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Payment In', 
                        'url' => array('/transaction/paymentIn/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('paymentInCreate') || Yii::app()->user->checkAccess('paymentInEdit'))
                    ),
                    array(
                        'label' => 'Payment Out', 
                        'url' => array('/accounting/paymentOut/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('paymentOutCreate') || Yii::app()->user->checkAccess('paymentOutEdit'))
                    ),
                    array('label' => 'TUNAI', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Transaksi Kas', 
                        'url' => array('/transaction/cashTransaction/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('cashTransactionCreate') || Yii::app()->user->checkAccess('cashTransactionEdit'))
                    ),
                    array(
                        'label' => 'Transaksi Jurnal Umum', 
                        'url' => array('/accounting/journalAdjustment/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('adjustmentJournalCreate') || Yii::app()->user->checkAccess('adjustmentJournalEdit'))
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('transferRequestCreate') || 
        Yii::app()->user->checkAccess('transferRequestEdit') || 
        Yii::app()->user->checkAccess('sentRequestCreate') || 
        Yii::app()->user->checkAccess('sentRequestEdit') || 
        Yii::app()->user->checkAccess('purchaseReturnCreate') || 
        Yii::app()->user->checkAccess('purchaseReturnEdit') || 
        Yii::app()->user->checkAccess('saleReturnCreate') || 
        Yii::app()->user->checkAccess('saleReturnEdit') || 
        Yii::app()->user->checkAccess('deliveryCreate') || 
        Yii::app()->user->checkAccess('deliveryEdit') || 
        Yii::app()->user->checkAccess('receiveItemCreate') || 
        Yii::app()->user->checkAccess('receiveItemEdit') || 
        Yii::app()->user->checkAccess('consignmentInCreate') || 
        Yii::app()->user->checkAccess('consignmentInEdit') || 
        Yii::app()->user->checkAccess('consignmentOutCreate') || 
        Yii::app()->user->checkAccess('consignmentOutEdit') || 
        Yii::app()->user->checkAccess('movementInCreate') || 
        Yii::app()->user->checkAccess('movementInEdit') || 
        Yii::app()->user->checkAccess('movementOutCreate') || 
        Yii::app()->user->checkAccess('movementOutEdit') || 
        Yii::app()->user->checkAccess('movementServiceCreate') || 
        Yii::app()->user->checkAccess('movementServiceEdit') || 
        Yii::app()->user->checkAccess('stockAdjustmentCreate') || 
        Yii::app()->user->checkAccess('stockAdjustmentEdit') || 
        Yii::app()->user->checkAccess('materialRequestCreate') || 
        Yii::app()->user->checkAccess('materialRequestEdit') || 
        Yii::app()->user->checkAccess('warehouseStockReport') || 
        Yii::app()->user->checkAccess('stockAnalysisReport')
    ): ?>
        <li class="mdropdown"><a href="#">GUDANG</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'OPERASIONAL', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Permintaan Transfer', 
                        'url' => array('/transaction/transferRequest/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('transferRequestCreate') || Yii::app()->user->checkAccess('transferRequestEdit'))
                    ),
                    array(
                        'label' => 'Permintaan Kirim', 
                        'url' => array('/transaction/transactionSentRequest/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('sentRequestCreate') || Yii::app()->user->checkAccess('sentRequestEdit'))
                    ),
                    array(
                        'label' => 'Retur Beli', 
                        'url' => array('/transaction/transactionReturnOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit'))
                    ),
                    array(
                        'label' => 'Retur Jual', 
                        'url' => array('/transaction/transactionReturnItem/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('saleReturnCreate') || Yii::app()->user->checkAccess('saleReturnEdit'))
                    ),
                    array(
                        'label' => 'Pengiriman Barang', 
                        'url' => array('/transaction/transactionDeliveryOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit'))
                    ),
                    array(
                        'label' => 'Penerimaan Barang', 
                        'url' => array('/transaction/transactionReceiveItem/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('receiveItemCreate') || Yii::app()->user->checkAccess('receiveItemEdit'))
                    ),
                    array(
                        'label' => 'Penerimaan Konsinyasi', 
                        'url' => array('/transaction/consignmentInHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('consignmentInCreate') || Yii::app()->user->checkAccess('consignmentInEdit'))
                    ),
                    array(
                        'label' => 'Pengeluaran Konsinyasi', 
                        'url' => array('/transaction/consignmentOutHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('consignmentOutCreate') || Yii::app()->user->checkAccess('consignmentOutEdit'))
                    ),
                    array('label' => 'GUDANG', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Barang Masuk Gudang', 
                        'url' => array('/transaction/movementInHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('movementInCreate') || Yii::app()->user->checkAccess('movementInEdit'))
                    ),
                    array(
                        'label' => 'Barang Keluar Gudang', 
                        'url' => array('/transaction/movementOutHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('movementOutCreate') || Yii::app()->user->checkAccess('movementOutEdit'))
                    ),
                    array(
                        'label' => 'Pengeluaran Bahan Pemakaian', 
                        'url' => array('/frontDesk/movementOutService/registrationTransactionList'), 
                        'visible' => (Yii::app()->user->checkAccess('movementServiceCreate') || Yii::app()->user->checkAccess('movementServiceEdit'))
                    ),
                    array(
                        'label' => 'Penyesuaian Stok', 
                        'url' => array('/frontDesk/adjustment/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('stockAdjustmentCreate') || Yii::app()->user->checkAccess('stockAdjustmentEdit'))
                    ),
                    array(
                        'label' => 'Permintaan Bahan', 
                        'url' => array('/frontDesk/materialRequest/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('materialRequestCreate') || Yii::app()->user->checkAccess('materialRequestEdit'))
                    ),
                    array(
                        'label' => 'Permintaan Maintenance', 
                        'url' => array('/frontDesk/maintenanceRequest/admin'), 
//                        'visible' => (Yii::app()->user->checkAccess('maintenanceRequestCreate') || Yii::app()->user->checkAccess('maintenanceRequestEdit'))
                    ),
                    array(
                        'label' => 'Stok Gudang', 
                        'url' => array('/frontDesk/inventory/check'), 
                        'visible' => (Yii::app()->user->checkAccess('warehouseStockReport'))
                    ),
                    array(
                        'label' => 'Analisa Stok Barang', 
                        'url' => array('/master/forecastingProduct/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('stockAnalysisReport'))
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (Yii::app()->user->checkAccess('grMechanicCreate') || Yii::app()->user->checkAccess('grMechanicEdit') || Yii::app()->user->checkAccess('brMechanicCreate') || Yii::app()->user->checkAccess('brMechanicEdit')): ?>
        <li class="mdropdown"><a href="#">Management</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'GENERAL REPAIR', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Mechanic POV', 
                        'url' => array('/frontDesk/generalRepairMechanic/index'), 
                        'visible' => (Yii::app()->user->checkAccess('grMechanicCreate') || Yii::app()->user->checkAccess('grMechanicEdit'))
                    ),
                    array(
                        'label' => 'Head POV', 
                        'url' => array('/frontDesk/generalRepairManagement/index'), 
                        'visible' => (Yii::app()->user->checkAccess('idleManagement'))
                    ),
                    array('label' => 'BODY REPAIR', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Mechanic POV', 
                        'url' => array('/frontDesk/bodyRepairMechanic/index'), 
                        'visible' => (Yii::app()->user->checkAccess('brMechanicCreate') || Yii::app()->user->checkAccess('brMechanicEdit'))
                    ),
                    array(
                        'label' => 'Head POV', 
                        'url' => array('/frontDesk/bodyRepairManagement/index'), 
                        'visible' => (Yii::app()->user->checkAccess('idleManagement'))
                    ),
    //				array('label'=>'Idle Management', 'url'=>array('/frontDesk/registrationTransaction/idleManagement'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.IdleManagement')),
                    array('label' => 'HRD', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Daftar Kehadiran', 
                        'url' => array('/master/employeeAttendance/index'), 
                        'visible' => Yii::app()->user->checkAccess('Master.EmployeeAttendance.Index')
                    ),
                    array(
                        'label' => 'Absensi', 
                        'url' => array('/master/employeeAttendance/attendance'), 
                        'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff'))
                    ),
                    array(
                        'label' => 'Gaji', 
                        'url' => array('/master/employeeAttendance/salary'), 
                        'visible' => Yii::app()->user->checkAccess('Master.EmployeeAttendance.Salary')
                    ),
                    array(
                        'label' => 'Libur Karyawan', 
                        'url' => array('/master/employeeDayoff/admin'), 
                        'visible' => Yii::app()->user->checkAccess('Master.EmployeeDayoff.Admin')
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('accountingReport') || 
        Yii::app()->user->checkAccess('financeReport') ||
        Yii::app()->user->checkAccess('receivableJournalReport') || 
        Yii::app()->user->checkAccess('generalLedgerReport') || 
        Yii::app()->user->checkAccess('cashTransactionReport') || 
        Yii::app()->user->checkAccess('summaryBalanceSheetReport') || 
        Yii::app()->user->checkAccess('standardBalanceSheetReport') || 
        Yii::app()->user->checkAccess('summaryProfitLossReport') || 
        Yii::app()->user->checkAccess('standardProfitLossReport') || 
        Yii::app()->user->checkAccess('financialAnalysisReport') || 
        Yii::app()->user->checkAccess('kertasKerjaReport') || 
        Yii::app()->user->checkAccess('transactionJournalReport') || 
        Yii::app()->user->checkAccess('journalSummaryReport') || 
        Yii::app()->user->checkAccess('cashDailyReport') || 
        Yii::app()->user->checkAccess('cashDailyApprovalReport') || 
        Yii::app()->user->checkAccess('cashDailySummaryReport') || 
        Yii::app()->user->checkAccess('financialForecastReport') || 
        Yii::app()->user->checkAccess('cashDailyTransactionReport')
    ): ?>
        <li class="mdropdown"><a href="#">ACCOUNTING/FINANCE</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Rincian Buku Besar Pembantu Piutang', 'url' => array('/report/receivableLedger/summary'), 'visible' => Yii::app()->user->checkAccess('receivableJournalReport')),
                    array('label' => 'Rincian Buku Besar Pembantu Hutang', 'url' => array('/report/payableLedger/summary'), 'visible' => Yii::app()->user->checkAccess('payableJournalReport')),
                    array('label' => 'Analisa Keuangan', 'url' => array('/accounting/forecasting/admin'), 'visible' => Yii::app()->user->checkAccess('financialAnalysisReport')),
                    array('label' => 'Laporan General Ledger (Buku Besar)', 'url' => array('/report/generalLedger/summary'), 'visible' => Yii::app()->user->checkAccess('generalLedgerReport')),
                    array('label' => 'Laporan Balance Sheet (induk)', 'url' => array('/report/balanceSheet/summary'), 'visible' => Yii::app()->user->checkAccess('summaryBalanceSheetReport')),
                    array('label' => 'Laporan Balance Sheet (Standar)', 'url' => array('/report/balanceSheetDetail/summary'), 'visible' => Yii::app()->user->checkAccess('standardBalanceSheetReport')),
                    array('label' => 'Laporan Profit/Loss (induk)', 'url' => array('/report/profitLoss/summary'), 'visible' => Yii::app()->user->checkAccess('summaryProfitLossReport')),
                    array('label' => 'Laporan Profit/Loss (Standar)', 'url' => array('/report/profitLossDetail/summary'), 'visible' => Yii::app()->user->checkAccess('standardProfitLossReport')),
                    array('label' => 'Laporan Cash Transaction', 'url' => array('/report/cashTransaction/summary'), 'visible' => Yii::app()->user->checkAccess('cashTransactionReport')),
//                    array('label' => 'Laporan Posisi Keuangan (Neraca)', 'url' => array('/report/balanceSheet/summary'), 'visible' => (Yii::app()->user->checkAccess('accountingReport') || Yii::app()->user->checkAccess('financeReport'))),
//                    array('label' => 'Laporan Laba Rugi', 'url' => array('/report/profitLoss/summary'), 'visible' => (Yii::app()->user->checkAccess('accountingReport') || Yii::app()->user->checkAccess('financeReport'))),
//                    array('label' => 'Buku Besar', 'url' => array('/report/generalLedger/summary'), 'visible' => (Yii::app()->user->checkAccess('accountingReport') || Yii::app()->user->checkAccess('financeReport'))),
                    array('label' => 'Kertas Kerja', 'url' => array('/accounting/coa/kertasKerja'), 'visible' => Yii::app()->user->checkAccess('kertasKerjaReport')),
                    array('label' => 'Jurnal Umum', 'url' => array('/report/transactionJournal/summary'), 'visible' => Yii::app()->user->checkAccess('transactionJournalReport')),
                    array('label' => 'Jurnal Umum Rekap', 'url' => array('/accounting/jurnalUmum/jurnalUmumRekap'), 'visible' => Yii::app()->user->checkAccess('journalSummaryReport')),
                    array('label' => 'Laporan Kas Harian', 'url' => array('/report/kasharian/report'), 'visible' => Yii::app()->user->checkAccess('cashDailyReport')),
                    array('label' => 'Approval Kas Harian', 'url' => array('/accounting/cashDailySummary/summary'), 'visible' => Yii::app()->user->checkAccess('cashDailyApprovalReport')),
                    array('label' => 'Summary Kas Harian', 'url' => array('/accounting/cashDailySummary/admin'), 'visible' => Yii::app()->user->checkAccess('cashDailySummaryReport')),
                    array('label' => 'Financial Forecast', 'url' => array('/accounting/financialForecast/summary'), 'visible' => Yii::app()->user->checkAccess('financialForecastReport')),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
            Yii::app()->user->checkAccess('purchaseOrderReport') || 
            Yii::app()->user->checkAccess('saleOrderReport') || 
            Yii::app()->user->checkAccess('saleInvoiceReport') || 
            Yii::app()->user->checkAccess('generalRepairReport') || 
            Yii::app()->user->checkAccess('bodyRepairReport') || 
            Yii::app()->user->checkAccess('consignmentInReport') || 
            Yii::app()->user->checkAccess('consignmentOutReport') || 
            Yii::app()->user->checkAccess('materialRequestReport') || 
            Yii::app()->user->checkAccess('movementInReport') || 
            Yii::app()->user->checkAccess('movementOutReport') || 
            Yii::app()->user->checkAccess('paymentInReport') || 
            Yii::app()->user->checkAccess('paymentOutReport') || 
            Yii::app()->user->checkAccess('deliveryReport') || 
            Yii::app()->user->checkAccess('receiveItemReport') || 
            Yii::app()->user->checkAccess('sentRequestReport') || 
            Yii::app()->user->checkAccess('transferRequestReport')
        ): ?>
        <li class="mdropdown"><a href="#">LAPORAN</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Inventory Stok Penjualan', 'url' => array('/report/stockSales/summary'), 'visible' => Yii::app()->user->checkAccess('stockInventoryReport')),
                    array('label' => 'Kartu Stok Persediaan', 'url' => array('/report/stockCard/summary'), 'visible' => Yii::app()->user->checkAccess('stockCardReport')),
//                    array('label' => 'Financial Forecast', 'url' => array('/report/financialForecast/summary'), 'visible' => Yii::app()->user->checkAccess('financialForecastReport')),
                    array('label' => 'Laporan Consignment In', 'url' => array('/report/consignmentIn/summary'), 'visible' => Yii::app()->user->checkAccess('consignmentInReport')),
                    array('label' => 'Laporan Consignment Out', 'url' => array('/report/consignmentOut/summary'), 'visible' => Yii::app()->user->checkAccess('consignmentOutReport')),
                    array('label' => 'Laporan Permintaan Bahan', 'url' => array('/report/materialRequest/summary'), 'visible' => Yii::app()->user->checkAccess('materialRequestReport')),
                    array('label' => 'Laporan Movement In', 'url' => array('/report/movementIn/summary'), 'visible' => Yii::app()->user->checkAccess('movementInReport')),
                    array('label' => 'Laporan Movement Out', 'url' => array('/report/movementOut/summary'), 'visible' => Yii::app()->user->checkAccess('movementOutReport')),
                    array('label' => 'Laporan Hutang Supplier', 'url' => array('/report/payable/summary'), 'visible' => Yii::app()->user->checkAccess('supplierPayableReport')),
                    array('label' => 'Laporan Piutang Customer', 'url' => array('/report/receivable/summary'), 'visible' => Yii::app()->user->checkAccess('customerReceivableReport')),
                    array('label' => 'Laporan Payment In', 'url' => array('/report/paymentIn/summary'), 'visible' => Yii::app()->user->checkAccess('paymentInReport')),
                    array('label' => 'Laporan Payment Out', 'url' => array('/report/paymentOut/summary'), 'visible' => Yii::app()->user->checkAccess('paymentOutReport')),
                    array('label' => 'Laporan Invoice Penjualan', 'url' => array('/report/saleInvoiceSummary/summary'), 'visible' => Yii::app()->user->checkAccess('saleInvoiceReport')),
                    array('label' => 'Laporan Order Penjualan', 'url' => array('/report/saleOrder/summary'), 'visible' => Yii::app()->user->checkAccess('saleOrderReport')),
                    array('label' => 'Laporan Penjualan Retail Summary', 'url' => array('/report/saleRetail/summary'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Penjualan Retail Product', 'url' => array('/report/saleRetailProduct/summary'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Penjualan Retail Service', 'url' => array('/report/saleRetailService/summary'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Pengiriman', 'url' => array('/report/delivery/summary'), 'visible' => Yii::app()->user->checkAccess('deliveryReport')),
                    array('label' => 'Laporan Pembelian (Detail)', 'url' => array('/report/purchaseOrder/summary'), 'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')),
                    array('label' => 'Laporan Pembelian (Summary)', 'url' => array('/report/purchaseSummary/summary'), 'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')),
                    array('label' => 'Laporan Penerimaan Barang', 'url' => array('/report/receiveItem/summary'), 'visible' => Yii::app()->user->checkAccess('receiveItemReport')),
                    array('label' => 'Laporan Sent Request', 'url' => array('/report/sentRequest/summary'), 'visible' => Yii::app()->user->checkAccess('sentRequestReport')),
                    array('label' => 'Laporan Transfer Request', 'url' => array('/report/transferRequest/summary'), 'visible' => Yii::app()->user->checkAccess('transferRequestReport')),
                    array('label' => '-----------------------'),
                    array('label' => 'Laporan Pembelian', 'url' => array('/transaction/transactionPurchaseOrder/laporanPembelian'), 'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')),
                    array('label' => 'Laporan Penjualan', 'url' => array('/transaction/transactionSalesOrder/laporanPenjualan'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Body Repair', 'url' => array('/report/bodyRepair/index'), 'visible' => Yii::app()->user->checkAccess('bodyRepairReport')),
                    array('label' => 'Laporan Penjualan Registration', 'url' => array('/frontDesk/RegistrationTransaction/laporanPenjualan'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Hutang Pembelian', 'url' => array('/transaction/transactionPurchaseOrder/laporanOutstanding'), 'visible' => (Yii::app()->user->checkAccess('accountingReport') || Yii::app()->user->checkAccess('financeReport'))),
                    array('label' => 'Laporan Piutang Penjualan', 'url' => array('/transaction/transactionSalesOrder/laporanOutstanding'), 'visible' => (Yii::app()->user->checkAccess('accountingReport') || Yii::app()->user->checkAccess('financeReport'))),
                    array('label' => 'Laporan Penjualan Harian Ban/Oli', 'url' => array('/report/laporanPenjualan/harian'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Penjualan Bulanan Ban/Oli', 'url' => array('/report/laporanPenjualan/bulanan'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Penjualan Tahunan Ban/Oli', 'url' => array('/report/laporanPenjualan/tahunan'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                    array('label' => 'Laporan Stok', 'url' => array('/report/laporanPenjualan/index'), 'visible' => Yii::app()->user->checkAccess('inventoryHead')),
                    array('label' => 'Laporan Bulanan Tahunan', 'url' => array('/frontDesk/registrationTransaction/monthlyYearly'), 'visible' => (Yii::app()->user->checkAccess('generalRepairReport') || Yii::app()->user->checkAccess('bodyRepairReport'))),
                    array('label' => 'Laporan Pendapatan', 'url' => array('/report/revenueRecap/index'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                ),
            )); ?>
        </li>
    <?php endif; ?>
</ul>
