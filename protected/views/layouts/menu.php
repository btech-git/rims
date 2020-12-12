<ul class="right clearfix">
    <li class="mdropdown"><a href="#">PENDING</a>
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Daftar Transaksi Pending', 
                    'url' => array('/transaction/pendingTransaction/index'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Order Outstanding', 
                    'url' => array('/frontDesk/outstandingOrder/index'), 
                    'visible' => Yii::app()->user->checkAccess('outstandingOrderView')
                ),
                array(
                    'label' => 'Approval Permintaan', 
                    'url' => array('/frontDesk/pendingRequest/index'), 
                    'visible' => Yii::app()->user->checkAccess('Transaction.TransactionTransferRequest.Admin')
                ),
            ),
        )); ?>
    </li>
    <li class="mdropdown"><a href="#">RESEPSIONIS</a>
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Pendaftaran Customer', 
                    'url' => array('/frontDesk/customerRegistration/vehicleList'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'General Repair', 
                    'url' => array('/frontDesk/generalRepairRegistration/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'Body Repair', 
                    'url' => array('/frontDesk/bodyRepairRegistration/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'Inspeksi Kendaraan', 
                    'url' => array('/frontDesk/vehicleInspection/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('maintenanceMechanicStaff') || Yii::app()->user->checkAccess('bodyRepairMechanicStaff') || Yii::app()->user->checkAccess('carSalonStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'SPK', 
                    'url' => array('/frontDesk/workOrder/admin'),
                    'visible' => (Yii::app()->user->checkAccess('maintenanceMechanicStaff') || Yii::app()->user->checkAccess('bodyRepairMechanicStaff') || Yii::app()->user->checkAccess('carSalonStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'Kasir', 
                    'url' => array('/frontDesk/registrationTransaction/cashier'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Daftar Antrian Customer', 
                    'url' => array('/frontDesk/registrationTransaction/customerWaitlist'), 
                    'visible' => (Yii::app()->user->checkAccess('maintenanceMechanicStaff') || Yii::app()->user->checkAccess('bodyRepairMechanicStaff') || Yii::app()->user->checkAccess('carSalonStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
            ),
        )); ?>
    </li>
    <li class="mdropdown"> <a href="#">TRANSAKSI</a>							
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'PEMBELIAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Order Permintaan', 
                    'url' => array('/transaction/transactionRequestOrder/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Order Pembelian', 
                    'url' => array('/transaction/transactionPurchaseOrder/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Perbandingan', 
                    'url' => array('/transaction/compare/step1'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array('label' => 'PENJUALAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Order Penjualan', 
                    'url' => array('/transaction/transactionSalesOrder/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Faktur Penjualan', 
                    'url' => array('/transaction/invoiceHeader/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('bodyRepairMechanicStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array('label' => 'PELUNASAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Payment In', 
                    'url' => array('/transaction/paymentIn/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Payment Out', 
                    'url' => array('/accounting/paymentOut/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array('label' => 'TUNAI', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Transaksi Kas', 
                    'url' => array('/transaction/cashTransaction/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
            ),
        )); ?>
    </li>
    <li class="mdropdown"><a href="#">GUDANG</a>
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'OPERASIONAL', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Permintaan Transfer', 
                    'url' => array('/transaction/transferRequest/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Permintaan Kirim', 
                    'url' => array('/transaction/transactionSentRequest/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Retur Beli', 
                    'url' => array('/transaction/transactionReturnItem/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'Retur Jual', 
                    'url' => array('/transaction/transactionReturnOrder/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'Pengiriman Barang', 
                    'url' => array('/transaction/transactionDeliveryOrder/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Penerimaan Barang', 
                    'url' => array('/transaction/transactionReceiveItem/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Penerimaan Konsinyasi', 
                    'url' => array('/transaction/consignmentInHeader/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array(
                    'label' => 'Pengeluaran Konsinyasi', 
                    'url' => array('/transaction/consignmentOutHeader/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array('label' => 'GUDANG', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Barang Masuk Gudang', 
                    'url' => array('/transaction/movementInHeader/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array(
                    'label' => 'Barang Keluar Gudang', 
                    'url' => array('/transaction/movementOutHeader/admin'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff') || Yii::app()->user->checkAccess('businessDevelopmentStaff'))
                ),
                array('label' => 'Pengeluaran Bahan Pemakaian', 'url' => array('/frontDesk/movementOutService/registrationTransactionList'), 'visible' => Yii::app()->user->checkAccess('movementOutView')),
                array(
                    'label' => 'Penyesuaian Stok', 
                    'url' => array('/frontDesk/adjustment/admin'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
//                array('label' => 'Gudang', 'url' => array('/master/inventory/admin'), 'visible' => Yii::app()->user->checkAccess('Master.Inventory.Admin')),
                array(
                    'label' => 'Stok Gudang', 
                    'url' => array('/frontDesk/inventory/check'), 
                    'visible' => Yii::app()->user->checkAccess('businessDevelopmentStaff')
                ),
                array('label' => 'Analisa Stok Barang', 'url' => array('/master/forecastingProduct/admin'), 'visible' => Yii::app()->user->checkAccess('forecastingProductView')),
                array('label' => 'Permintaan Bahan', 'url' => array('/frontDesk/materialRequest/admin'), 'visible' => Yii::app()->user->checkAccess('Master.Inventory.Admin')),
            ),
        )); ?>
    </li>
    <li class="mdropdown"><a href="#">Management</a>
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'GENERAL REPAIR', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Mechanic POV', 
                    'url' => array('/frontDesk/generalRepairMechanic/index'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff'))
                ),
                array(
                    'label' => 'Head POV', 
                    'url' => array('/frontDesk/idleManagement/indexHead'), 
                    'visible' => (Yii::app()->user->checkAccess('serviceAdvisorHead') || Yii::app()->user->checkAccess('maintenanceMechanicHead') || Yii::app()->user->checkAccess('bodyRepairAdminHead') || Yii::app()->user->checkAccess('bodyRepairQualityControlHead') || Yii::app()->user->checkAccess('bodyRepairMechanicHead'))
                ),
                array('label' => 'BODY REPAIR', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array(
                    'label' => 'Mechanic POV', 
                    'url' => array('/frontDesk/bodyRepairMechanic/index'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff'))
                ),
                array(
                    'label' => 'Head POV', 
                    'url' => array('/frontDesk/bodyRepairManagement/index'), 
                    'visible' => (Yii::app()->user->checkAccess('serviceAdvisorHead') || Yii::app()->user->checkAccess('maintenanceMechanicHead') || Yii::app()->user->checkAccess('bodyRepairAdminHead') || Yii::app()->user->checkAccess('bodyRepairQualityControlHead') || Yii::app()->user->checkAccess('bodyRepairMechanicHead'))
                ),
//				array('label'=>'Idle Management', 'url'=>array('/frontDesk/registrationTransaction/idleManagement'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.IdleManagement')),
                array('label' => 'HRD', 'url' => array('#'), 'itemOptions' => array('class' => 'title')),
                array('label' => 'Daftar Kehadiran', 'url' => array('/master/employeeAttendance/index'), 'visible' => Yii::app()->user->checkAccess('Master.EmployeeAttendance.Index')),
                array(
                    'label' => 'Absensi', 
                    'url' => array('/master/employeeAttendance/attendance'), 
                    'visible' => (Yii::app()->user->checkAccess('frontOfficeStaff') || Yii::app()->user->checkAccess('serviceAdvisorStaff') || Yii::app()->user->checkAccess('cashier') || Yii::app()->user->checkAccess('bodyRepairAdminStaff') || Yii::app()->user->checkAccess('bodyRepairQualityControlStaff'))
                ),
                array('label' => 'Gaji', 'url' => array('/master/employeeAttendance/salary'), 'visible' => Yii::app()->user->checkAccess('Master.EmployeeAttendance.Salary')),
                array('label' => 'Libur Karyawan', 'url' => array('/master/employeeDayoff/admin'), 'visible' => Yii::app()->user->checkAccess('Master.EmployeeDayoff.Admin')),
            ),
        )); ?>
    </li>
    <li class="mdropdown"><a href="#">ACCOUNTING/FINANCE</a>
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Analisa Keuangan', 'url' => array('/accounting/forecasting/admin'), 'visible' => Yii::app()->user->checkAccess('forecastingFinanceView')),
                array('label' => 'Jurnal Penyesuaian', 'url' => array('/accounting/jurnalPenyesuaian/admin'), 'visible' => Yii::app()->user->checkAccess('adjustmentJournalView')),
                array('label' => 'Laporan Posisi Keuangan (Neraca)', 'url' => array('/accounting/neraca/index'), 'visible' => Yii::app()->user->checkAccess('balanceSheetReport')),
                array('label' => 'Laporan Laba Rugi', 'url' => array('/report/labaRugi/summary'), 'visible' => Yii::app()->user->checkAccess('profitLossReport')),
                array('label' => 'Buku Besar', 'url' => array('/accounting/jurnalUmum/buku'), 'visible' => Yii::app()->user->checkAccess('ledgerReport')),
                array('label' => 'Kertas Kerja', 'url' => array('/accounting/coa/kertasKerja'), 'visible' => Yii::app()->user->checkAccess('financialReport')),
                array('label' => 'Jurnal Umum', 'url' => array('/accounting/jurnalUmum/index'), 'visible' => Yii::app()->user->checkAccess('accountJournalDetailReport')),
                array('label' => 'Jurnal Umum Rekap', 'url' => array('/accounting/jurnalUmum/jurnalUmumRekap'), 'visible' => Yii::app()->user->checkAccess('accountJournalSummaryReport')),
                array('label' => 'Laporan Kas Harian', 'url' => array('/report/kasharian/report'), 'visible' => Yii::app()->user->checkAccess('dailyCashReport')),
                array('label' => 'Approval Kas Harian', 'url' => array('/accounting/cashDailySummary/summary'), 'visible' => Yii::app()->user->checkAccess('dailyCashReport')),
                array('label' => 'Summary Kas Harian', 'url' => array('/accounting/cashDailySummary/admin'), 'visible' => Yii::app()->user->checkAccess('dailyCashReport')),
                array('label' => 'Financial Forecast', 'url' => array('/accounting/financialForecast/summary'), 'visible' => Yii::app()->user->checkAccess('dailyCashReport')),
            ),
        )); ?>
    </li>
    <li class="mdropdown"><a href="#">LAPORAN</a>
        <?php $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Laporan Pembelian', 'url' => array('/transaction/transactionPurchaseOrder/laporanPembelian'), 'visible' => Yii::app()->user->checkAccess('purchaseReport')),
                array('label' => 'Laporan Penjualan', 'url' => array('/transaction/transactionSalesOrder/laporanPenjualan'), 'visible' => Yii::app()->user->checkAccess('salesReport')),
                array('label' => 'Laporan Body Repair', 'url' => array('/report/bodyRepair/index'), 'visible' => Yii::app()->user->checkAccess('bodyRepairReport')),
                array('label' => 'Laporan Penjualan Registration', 'url' => array('/frontDesk/RegistrationTransaction/laporanPenjualan'), 'visible' => Yii::app()->user->checkAccess('salesRegistrationReport')),
                array('label' => 'Laporan Hutang Pembelian', 'url' => array('/transaction/transactionPurchaseOrder/laporanOutstanding'), 'visible' => Yii::app()->user->checkAccess('accountPayableReport')),
                array('label' => 'Laporan Piutang Penjualan', 'url' => array('/transaction/transactionSalesOrder/laporanOutstanding'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Penjualan Harian Ban/Oli', 'url' => array('/report/laporanPenjualan/harian'), 'visible' => Yii::app()->user->checkAccess('tireOilDailySalesReport')),
                array('label' => 'Laporan Penjualan Bulanan Ban/Oli', 'url' => array('/report/laporanPenjualan/bulanan'), 'visible' => Yii::app()->user->checkAccess('tireOilMonthlySalesReport')),
                array('label' => 'Laporan Penjualan Tahunan Ban/Oli', 'url' => array('/report/laporanPenjualan/tahunan'), 'visible' => Yii::app()->user->checkAccess('tireOilYearlySalesReport')),
                array('label' => 'Laporan Stok', 'url' => array('/report/laporanPenjualan/index'), 'visible' => Yii::app()->user->checkAccess('stockReport')),
                array('label' => 'Laporan Bulanan Tahunan', 'url' => array('/frontDesk/registrationTransaction/monthlyYearly'), 'visible' => Yii::app()->user->checkAccess('monthlyYearlyReport')),
                array('label' => 'Laporan Pendapatan', 'url' => array('/report/revenueRecap/index'), 'visible' => Yii::app()->user->checkAccess('revenueRecapReport')),
                array('label' => '-----------------------'),
                array('label' => 'Laporan Cash Transaction', 'url' => array('/report/cashTransaction/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Consignment In', 'url' => array('/report/consignmentIn/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Consignment Out', 'url' => array('/report/consignmentOut/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Invoice Penjualan', 'url' => array('/report/saleInvoice/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Permintaan Bahan', 'url' => array('/report/materialRequest/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Movement In', 'url' => array('/report/movementIn/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Movement Out', 'url' => array('/report/movementOut/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Pembelian', 'url' => array('/report/purchaseSummary/summary'), 'visible' => Yii::app()->user->checkAccess('purchaseReport')),
                array('label' => 'Laporan Hutang Supplier', 'url' => array('/report/payable/summary'), 'visible' => Yii::app()->user->checkAccess('accountPayableReport')),
                array('label' => 'Laporan InvoicePenjualan', 'url' => array('/report/saleInvoiceSummary/summary'), 'visible' => Yii::app()->user->checkAccess('salesReport')),
                array('label' => 'Laporan Piutang Customer', 'url' => array('/report/receivable/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Payment In', 'url' => array('/report/paymentIn/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Payment Out', 'url' => array('/report/paymentOut/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Penjualan Retail Summary', 'url' => array('/report/saleRetail/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Penjualan Retail Product', 'url' => array('/report/saleRetailProduct/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Penjualan Retail Service', 'url' => array('/report/saleRetailService/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Pengiriman', 'url' => array('/report/delivery/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Pembelian', 'url' => array('/report/purchaseOrder/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Penerimaan Barang', 'url' => array('/report/receiveItem/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Order Penjualan', 'url' => array('/report/saleOrder/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Sent Request', 'url' => array('/report/sentRequest/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
                array('label' => 'Laporan Transfer Request', 'url' => array('/report/transferRequest/summary'), 'visible' => Yii::app()->user->checkAccess('accountReceivableReport')),
            ),
        )); ?>
    </li>
</ul>