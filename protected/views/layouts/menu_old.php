<ul class="right clearfix">
	<li class="mdropdown"><a href="#">FRONT DESKkkk</a>
		<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Customer Vehicle Registration', 'url'=>array('/frontDesk/registrationTransaction/admin'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.Admin')),
					array('label'=>'Vehicle Inspection', 'url'=>array('/frontDesk/vehicleInspection/admin'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.VehicleInspection.Admin')),
					array('label'=>'Work Order', 'url'=>array('/frontDesk/registrationTransaction/adminWo'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.AdminWo')),
					array('label'=>'Cashier', 'url'=>array('/frontDesk/registrationTransaction/cashier'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.cashier')),
					array('label'=>'Customer Waitlist', 'url'=>array('/frontDesk/registrationTransaction/customerWaitlist'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.customerWaitlist')),
				),
		)); ?>
	</li>
	<li class="mdropdown"> <a href="#">Transaction</a>							
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Pending Order', 'url'=>array('/transaction/pendingTransaction/index'), 'visible'=>Yii::app()->user->checkAccess('Transaction.PendingTransaction.index')),
				array('label'=>'PURCHASE', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Request Order', 'url'=>array('/transaction/transactionRequestOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionRequestOrder.Admin')),
				array('label'=>'Purchase Order', 'url'=>array('/transaction/transactionPurchaseOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionPurchaseOrder.Admin')),
				array('label'=>'Compare', 'url'=>array('/transaction/compare/step1'), 'visible'=>Yii::app()->user->checkAccess('Transaction.compare.step1')),
				array('label'=>'SALES', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Sales Order', 'url'=>array('/transaction/transactionSalesOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionSalesOrder.Admin')),
				array('label'=>'Invoice', 'url'=>array('/transaction/invoiceHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.InvoiceHeader.Admin')),
				array('label'=>'PAYMENT', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Payment In', 'url'=>array('/transaction/paymentIn/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.PaymentIn.Admin')),
				array('label'=>'Payment Out', 'url'=>array('/transaction/paymentOut/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.PaymentOut.Admin')),
				array('label'=>'CASH', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Cash Transaction', 'url'=>array('/transaction/cashTransaction/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.CashTransaction.Admin')),
				
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">WAREHOUSE</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Inventory', 'url'=>array('/master/inventory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Inventory.Admin')),
				array('label'=>'Stok Gudang', 'url'=>array('/frontDesk/inventory/check'), 'visible'=>Yii::app()->user->checkAccess('Master.Inventory.Admin')),
				array('label'=>'Transfer Request', 'url'=>array('/transaction/transferRequest/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionTransferRequest.Admin')),
				array('label'=>'Sent Request', 'url'=>array('/transaction/transactionSentRequest/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionSentRequest.Admin')),
				array('label'=>'Return Item', 'url'=>array('/transaction/transactionReturnItem/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionReturnItem.Admin')),
				array('label'=>'Return Order', 'url'=>array('/transaction/transactionReturnOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionReturnOrder.Admin')),
				array('label'=>'Delivery Order', 'url'=>array('/transaction/transactionDeliveryOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionDeliveryOrder.Admin')),
				array('label'=>'Receive Item', 'url'=>array('/transaction/transactionReceiveItem/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionReceiveItem.Admin')),
				array('label'=>'Consignment In', 'url'=>array('/transaction/consignmentInHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.ConsignmentInHeader.Admin')),
				array('label'=>'Consignment Out', 'url'=>array('/transaction/consignmentOutHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.ConsignmentOutHeader.Admin')),
				array('label'=>'Movement In', 'url'=>array('/transaction/movementInHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.MovementInHeader.Admin')),
				array('label'=>'Movement Out', 'url'=>array('/transaction/movementOutHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.MovementOutHeader.Admin')),
				array('label'=>'Stock Adjustment', 'url'=>array('/frontDesk/adjustment/admin'), 'visible'=>Yii::app()->user->checkAccess('Transaction.StockAdjustment.Admin')),
				array('label'=>'Forecasting Product', 'url'=>array('/master/forecastingProduct/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ForecastingProduct.Admin')),
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">Management</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Idle Management', 'url'=>array('/frontDesk/registrationTransaction/idleManagement'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.IdleManagement')),
				array('label'=>'My Attendance', 'url'=>array('/master/employeeAttendance/index'), 'visible'=>Yii::app()->user->checkAccess('Master.EmployeeAttendance.Index')),
				array('label'=>'Absency', 'url'=>array('/master/employeeAttendance/attendance'), 'visible'=>Yii::app()->user->checkAccess('Master.EmployeeAttendance.Attendance')),
				array('label'=>'Salary', 'url'=>array('/master/employeeAttendance/salary'), 'visible'=>Yii::app()->user->checkAccess('Master.EmployeeAttendance.Salary')),
				array('label'=>'Employee Dayoffs', 'url'=>array('/master/employeeDayoff/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.EmployeeDayoff.Admin')),
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">Accounting</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Forecasting Finance', 'url'=>array('/accounting/forecasting/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.Forecasting.Admin')),
	            array('label'=>'Jurnal Penyesuaian', 'url'=>array('/accounting/jurnalPenyesuaian/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.JurnalPenyesuaian.Admin')),
	            array('label'=>'Laporan Posisi Keuangan (Neraca)', 'url'=>array('/accounting/neraca/index'), 'visible'=>Yii::app()->user->checkAccess('Accounting.Neraca.index')),
	            array('label'=>'Laporan Laba Rugi', 'url'=>array('/report/labaRugi/summary'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.IdleManagement')),
				array('label'=>'Buku Besar', 'url'=>array('/accounting/jurnalUmum/buku'), 'visible'=>Yii::app()->user->checkAccess('Accounting.JurnalUmum.Buku')),
				array('label'=>'Kertas Kerja', 'url'=>array('/accounting/coa/kertasKerja'), 'visible'=>Yii::app()->user->checkAccess('Accounting.Coa.KertasKerja')),
				 array('label'=>'Jurnal Umum', 'url'=>array('/accounting/jurnalUmum/index'), 'visible'=>Yii::app()->user->checkAccess('Accounting.JurnalUmum.Index')),
				array('label'=>'Jurnal Umum Rekap', 'url'=>array('/accounting/jurnalUmum/jurnalUmumRekap'), 'visible'=>Yii::app()->user->checkAccess('Accounting.JurnalUmum.JurnalUmumRekap')),
	            array('label'=>'Laporan Kas Harian', 'url'=>array('/report/kasharian/report'), 'visible'=>Yii::app()->user->checkAccess('Report.KasHarian.Report')),
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">Report</a>
		<?php  $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Laporan Pembelian', 'url'=>array('/transaction/transactionPurchaseOrder/laporanPembelian'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionPurchaseOrder.LaporanPembelian')),
                array('label'=>'Laporan Penjualan', 'url'=>array('/transaction/transactionSalesOrder/laporanPenjualan'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionSalesOrder.LaporanPenjualan')),
                array('label'=>'Laporan Body Repair', 'url'=>array('/report/bodyRepair/index'), 'visible'=>Yii::app()->user->checkAccess('Report.bodyrepair.index')),
                array('label'=>'Laporan Penjualan Registration', 'url'=>array('/frontDesk/RegistrationTransaction/laporanPenjualan'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.LaporanPenjualan')),
                array('label'=>'Laporan Outstanding Pembelian', 'url'=>array('/transaction/transactionPurchaseOrder/laporanOutstanding'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionPurchaseOrder.LaporanOutstanding')),
                array('label'=>'Laporan Outstanding Penjualan', 'url'=>array('/transaction/transactionSalesOrder/laporanOutstanding'), 'visible'=>Yii::app()->user->checkAccess('Transaction.TransactionSalesOrder.LaporanOutstanding')),
                array('label'=>'Laporan Penjualan Harian Ban/Oli', 'url'=>array('/report/laporanPenjualan/harian'), 'visible'=>Yii::app()->user->checkAccess('Report.LaporanPenjualan.Index')),
                array('label'=>'Laporan Penjualan Bulanan Ban/Oli', 'url'=>array('/report/laporanPenjualan/bulanan'), 'visible'=>Yii::app()->user->checkAccess('Report.LaporanPenjualan.Index')),
                array('label'=>'Laporan Penjualan Tahunan Ban/Oli', 'url'=>array('/report/laporanPenjualan/tahunan'), 'visible'=>Yii::app()->user->checkAccess('Report.LaporanPenjualan.Index')),
                array('label'=>'Laporan Stok', 'url'=>array('/report/laporanPenjualan/index'), 'visible'=>Yii::app()->user->checkAccess('Report.LaporanPenjualan.Index')),
                array('label'=>'Monthly Yearly Report', 'url'=>array('/frontDesk/registrationTransaction/monthlyYearly'), 'visible'=>Yii::app()->user->checkAccess('FrontDesk.RegistrationTransaction.MonthlyYearly')),
                array('label'=>'Revenue Recap Report', 'url'=>array('/report/revenueRecap/index'), 'visible'=>Yii::app()->user->checkAccess('Report.RevenueRecap.Index')),
            ),
        )); ?>
	</li>
</ul>