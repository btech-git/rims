<ul class="right clearfix">
	<li class="mdropdown"><a href="#">FRONT DESK</a>
		<?php $this->widget('zii.widgets.CMenu',array(
				'items'=>array(
					array('label'=>'Customer Vehicle Registration', 'url'=>array('/frontDesk/registrationTransaction/admin'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.admin')),
					array('label'=>'Vehicle Inspection', 'url'=>array('/frontDesk/vehicleInspection/admin'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.vehicleInspection.admin')),
					array('label'=>'Work Order', 'url'=>array('/frontDesk/registrationTransaction/adminWo'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.adminWo')),
					array('label'=>'Cashier', 'url'=>array('/frontDesk/registrationTransaction/cashier'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.cashier')),
					array('label'=>'Customer Waitlist', 'url'=>array('/frontDesk/registrationTransaction/customerWaitlist'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.customerWaitlist')),
				),
		)); ?>
	</li>
	<li class="mdropdown"> <a href="#">Transaction</a>							
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Pending Order', 'url'=>array('/transaction/pendingTransaction/index'), 'visible'=>Yii::app()->user->checkAccess('transaction.pendingTransaction.index')),
				array('label'=>'PURCHASE', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Request Order', 'url'=>array('/transaction/transactionRequestOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionRequestOrder.admin')),
				array('label'=>'Purchase Order', 'url'=>array('/transaction/transactionPurchaseOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionPurchaseOrder.admin')),
				array('label'=>'Compare', 'url'=>array('/transaction/compare/step1'), 'visible'=>Yii::app()->user->checkAccess('transaction.compare.step1')),
				array('label'=>'SALES', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Sales Order', 'url'=>array('/transaction/transactionSalesOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionSalesOrder.admin')),
				array('label'=>'Invoice', 'url'=>array('/transaction/invoiceHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.invoiceHeader.admin')),
				array('label'=>'PAYMENT', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Payment In', 'url'=>array('/transaction/paymentIn/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.paymentIn.admin')),
				array('label'=>'Payment Out', 'url'=>array('/transaction/paymentOut/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.paymentOut.admin')),
				array('label'=>'CASH', 'url'=>array('#'),'itemOptions' =>array('class' => 'title')),
				array('label'=>'Cash Transaction', 'url'=>array('/transaction/cashTransaction/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.cashTransaction.admin')),
				
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">WAREHOUSE</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Inventory', 'url'=>array('/master/inventory/admin'), 'visible'=>Yii::app()->user->checkAccess('master.inventory.admin')),
				array('label'=>'Transfer Request', 'url'=>array('/transaction/transactionTransferRequest/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionTransferRequest.admin')),
				array('label'=>'Sent Request', 'url'=>array('/transaction/transactionSentRequest/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionSentRequest.admin')),
				array('label'=>'Return Item', 'url'=>array('/transaction/transactionReturnItem/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionReturnItem.admin')),
				array('label'=>'Return Order', 'url'=>array('/transaction/transactionReturnOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionReturnOrder.admin')),
				array('label'=>'Delivery Order', 'url'=>array('/transaction/transactionDeliveryOrder/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionDeliveryOrder.admin')),
				array('label'=>'Receive Item', 'url'=>array('/transaction/transactionReceiveItem/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionReceiveItem.admin')),
				array('label'=>'Consignment In', 'url'=>array('/transaction/consignmentInHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.consignmentInHeader.admin')),
				array('label'=>'Consignment Out', 'url'=>array('/transaction/consignmentOutHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.consignmentOutHeader.admin')),
				array('label'=>'Movement In', 'url'=>array('/transaction/movementInHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.movementInHeader.admin')),
				array('label'=>'Movement Out', 'url'=>array('/transaction/movementOutHeader/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.movementOutHeader.admin')),
				array('label'=>'Stock Adjustment', 'url'=>array('/transaction/stockAdjustment/admin'), 'visible'=>Yii::app()->user->checkAccess('transaction.stockAdjustment.admin')),
				array('label'=>'Forecasting Product', 'url'=>array('/master/forecastingProduct/admin'), 'visible'=>Yii::app()->user->checkAccess('master.forecastingProduct.admin')),
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">Management</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Idle Management', 'url'=>array('/frontDesk/registrationTransaction/idleManagement'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.idleManagement')),
				array('label'=>'My Attendance', 'url'=>array('/master/employeeAttendance/index'), 'visible'=>Yii::app()->user->checkAccess('master.employeeAttendance.index')),
				array('label'=>'Absency', 'url'=>array('/master/employeeAttendance/attendance'), 'visible'=>Yii::app()->user->checkAccess('master.employeeAttendance.attendance')),
				array('label'=>'Salary', 'url'=>array('/master/employeeAttendance/salary'), 'visible'=>Yii::app()->user->checkAccess('master.employeeAttendance.salary')),
				array('label'=>'Employee Dayoffs', 'url'=>array('/master/employeeDayoff/admin'), 'visible'=>Yii::app()->user->checkAccess('master.employeeDayoff.admin')),
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">Accounting</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Forecasting Finance', 'url'=>array('/accounting/forecasting/admin'), 'visible'=>Yii::app()->user->checkAccess('accounting.forecasting.admin')),
	            array('label'=>'Jurnal Penyesuaian', 'url'=>array('/accounting/jurnalPenyesuaian/admin'), 'visible'=>Yii::app()->user->checkAccess('accounting.jurnalPenyesuaian.admin')),
	            array('label'=>'Laporan Posisi Keuangan (Neraca)', 'url'=>array('/accounting/neraca/index'), 'visible'=>Yii::app()->user->checkAccess('accounting.neraca.index')),
	            array('label'=>'Laporan Laba Rugi', 'url'=>array('/report/labaRugi/summary'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.idleManagement')),
				array('label'=>'Buku Besar', 'url'=>array('/accounting/jurnalUmum/buku'), 'visible'=>Yii::app()->user->checkAccess('accounting.jurnalUmum.buku')),
				array('label'=>'Kertas Kerja', 'url'=>array('/accounting/coa/kertasKerja'), 'visible'=>Yii::app()->user->checkAccess('accounting.coa.kertasKerja')),
				 array('label'=>'Jurnal Umum', 'url'=>array('/accounting/jurnalUmum/index'), 'visible'=>Yii::app()->user->checkAccess('accounting.jurnalUmum.index')),
				array('label'=>'Jurnal Umum Rekap', 'url'=>array('/accounting/jurnalUmum/jurnalUmumRekap'), 'visible'=>Yii::app()->user->checkAccess('accounting.jurnalUmum.jurnalUmumRekap')),
	            array('label'=>'Laporan Kas Harian', 'url'=>array('/report/kasharian/report'), 'visible'=>Yii::app()->user->checkAccess('report.kasharian.report')),
				),
			)); 
		?>
	</li>
	<li class="mdropdown"><a href="#">Report</a>
		<?php 
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Laporan Pembelian', 'url'=>array('/transaction/transactionPurchaseOrder/laporanPembelian'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionPurchaseOrder.laporanPembelian')),
				array('label'=>'Laporan Penjualan', 'url'=>array('/transaction/transactionSalesOrder/laporanPenjualan'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionSalesOrder.laporanPenjualan')),
				array('label'=>'Laporan Body Repair', 'url'=>array('/report/bodyrepair/index'), 'visible'=>Yii::app()->user->checkAccess('report.bodyrepair.index')),
				array('label'=>'Laporan Penjualan Registration', 'url'=>array('/frontDesk/registrationTransaction/laporanPenjualan'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.laporanPenjualan')),
				array('label'=>'Laporan Outstanding Pembelian', 'url'=>array('/transaction/transactionPurchaseOrder/laporanOutstanding'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionPurchaseOrder.laporanOutstanding')),
				array('label'=>'Laporan Outstanding Penjualan', 'url'=>array('/transaction/transactionSalesOrder/laporanOutstanding'), 'visible'=>Yii::app()->user->checkAccess('transaction.transactionSalesOrder.laporanOutstanding')),
				array('label'=>'Laporan Penjualan Harian Ban/Oli', 'url'=>array('/report/laporanpenjualan/harian'), 'visible'=>Yii::app()->user->checkAccess('report.laporanpenjualan.index')),
				array('label'=>'Laporan Penjualan Bulanan Ban/Oli', 'url'=>array('/report/laporanpenjualan/bulanan'), 'visible'=>Yii::app()->user->checkAccess('report.laporanpenjualan.index')),
				array('label'=>'Laporan Penjualan Tahunan Ban/Oli', 'url'=>array('/report/laporanpenjualan/tahunan'), 'visible'=>Yii::app()->user->checkAccess('report.laporanpenjualan.index')),
				array('label'=>'Laporan Stok', 'url'=>array('/report/laporanpenjualan/index'), 'visible'=>Yii::app()->user->checkAccess('report.laporanpenjualan.index')),
				array('label'=>'Monthly Yearly Report', 'url'=>array('/frontDesk/registrationTransaction/monthlyYearly'), 'visible'=>Yii::app()->user->checkAccess('frontDesk.registrationTransaction.monthlyYearly')),
				array('label'=>'Revenue Recap Report', 'url'=>array('/report/revenueRecap/index'), 'visible'=>Yii::app()->user->checkAccess('report.revenueRecap.index')),
				
				),
			)); 
		?>
	</li>
</ul>