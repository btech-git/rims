<ul class="right clearfix">
    <li><?php echo CHtml::link('Marketing', array('/site/marketing')); ?></li>
    <?php if (
        Yii::app()->user->checkAccess('pendingTransactionView') || 
        Yii::app()->user->checkAccess('orderOutstandingView') || 
        Yii::app()->user->checkAccess('requestApprovalView') || 
        Yii::app()->user->checkAccess('masterApprovalView') || 
        Yii::app()->user->checkAccess('pendingJournalView')
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
                    array(
                        'label' => 'Pending Journal Purchase', 
                        'url' => array('/accounting/pendingJournal/indexPurchase'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Cash Transaction', 
                        'url' => array('/accounting/pendingJournal/indexCash'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Delivery', 
                        'url' => array('/accounting/pendingJournal/indexDelivery'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Movement In', 
                        'url' => array('/accounting/pendingJournal/indexMovementIn'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Movement Out', 
                        'url' => array('/accounting/pendingJournal/indexMovementOut'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Payment In', 
                        'url' => array('/accounting/pendingJournal/indexPaymentIn'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Payment Out', 
                        'url' => array('/accounting/pendingJournal/indexPaymentOut'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Receive Item', 
                        'url' => array('/accounting/pendingJournal/indexReceive'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Invoice', 
                        'url' => array('/accounting/pendingJournal/indexInvoice'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Sale Order', 
                        'url' => array('/accounting/pendingJournal/indexSale'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                    array(
                        'label' => 'Pending Journal Stock Adjustment', 
                        'url' => array('/accounting/pendingJournal/indexAdjustmentStock'), 
                        'visible' => Yii::app()->user->checkAccess('pendingJournalView')
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('saleEstimationCreate') || 
        Yii::app()->user->checkAccess('saleEstimationEdit') || 
        Yii::app()->user->checkAccess('saleEstimationView')|| 
        Yii::app()->user->checkAccess('saleEstimationSupervisor') || 
        Yii::app()->user->checkAccess('generalRepairCreate') || 
        Yii::app()->user->checkAccess('generalRepairEdit') || 
        Yii::app()->user->checkAccess('generalRepairView') || 
        Yii::app()->user->checkAccess('generalRepairSupervisor') || 
        Yii::app()->user->checkAccess('bodyRepairCreate') || 
        Yii::app()->user->checkAccess('bodyRepairEdit') || 
        Yii::app()->user->checkAccess('bodyRepairView') || 
        Yii::app()->user->checkAccess('bodyRepairSupervisor') || 
        Yii::app()->user->checkAccess('pricingRequestCreate') || 
        Yii::app()->user->checkAccess('pricingRequestEdit') || 
        Yii::app()->user->checkAccess('pricingRequestView') || 
        Yii::app()->user->checkAccess('pricingRequestApproval') || 
        Yii::app()->user->checkAccess('outstandingRegistrationView') || 
        Yii::app()->user->checkAccess('inspectionCreate') || 
        Yii::app()->user->checkAccess('inspectionEdit') || 
        Yii::app()->user->checkAccess('inspectionView') || 
        Yii::app()->user->checkAccess('inspectionApproval') || 
        Yii::app()->user->checkAccess('systemCheckCreate') || 
        Yii::app()->user->checkAccess('systemCheckEdit') || 
        Yii::app()->user->checkAccess('systemCheckView') || 
        Yii::app()->user->checkAccess('systemCheckApproval') || 
        Yii::app()->user->checkAccess('workOrderView') || 
        Yii::app()->user->checkAccess('outstandingWorkOrderView') || 
        Yii::app()->user->checkAccess('cashierView') || 
        Yii::app()->user->checkAccess('customerQueueView') || 
        Yii::app()->user->checkAccess('customerFollowUp') || 
        Yii::app()->user->checkAccess('serviceFollowUp') || 
        Yii::app()->user->checkAccess('vehicleStatusView')
    ): ?>
        <li class="mdropdown"><a href="#">RESEPSIONIS</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Estimasi Customer', 
                        'url' => array('/frontDesk/saleEstimation/admin'), 
                        'visible' => Yii::app()->user->checkAccess('saleEstimationCreate') || Yii::app()->user->checkAccess('saleEstimationEdit') || 
                            Yii::app()->user->checkAccess('saleEstimationView') || Yii::app()->user->checkAccess('saleEstimationSupervisor'),
                    ),
                    array(
                        'label' => 'Pendaftaran Customer', 
                        'url' => array('/frontDesk/customerRegistration/vehicleList'), 
                        'visible' => Yii::app()->user->checkAccess('generalRepairCreate') || Yii::app()->user->checkAccess('bodyRepairCreate'),
                    ),
                    array(
                        'label' => 'General Repair', 
                        'url' => array('/frontDesk/generalRepairRegistration/admin'), 
                        'visible' => Yii::app()->user->checkAccess('generalRepairCreate') || Yii::app()->user->checkAccess('generalRepairEdit') || 
                            Yii::app()->user->checkAccess('generalRepairView') || Yii::app()->user->checkAccess('generalRepairSupervisor'),
                    ),
                    array(
                        'label' => 'Body Repair', 
                        'url' => array('/frontDesk/bodyRepairRegistration/admin'), 
                        'visible' => Yii::app()->user->checkAccess('bodyRepairCreate') || Yii::app()->user->checkAccess('bodyRepairEdit') || 
                            Yii::app()->user->checkAccess('bodyRepairView') || Yii::app()->user->checkAccess('bodyRepairSupervisor'),
                    ),
                    array(
                        'label' => 'Permintaan Harga', 
                        'url' => array('/frontDesk/productPricingRequest/admin'),
                        'visible' => Yii::app()->user->checkAccess('pricingRequestCreate') || Yii::app()->user->checkAccess('pricingRequestEdit') || 
                            Yii::app()->user->checkAccess('pricingRequestView') || Yii::app()->user->checkAccess('pricingRequestApproval'),
                    ),
                    array(
                        'label' => 'Outstanding Registration', 
                        'url' => array('/frontDesk/registrationTransaction/adminOutstanding'),
                        'visible' => Yii::app()->user->checkAccess('outstandingRegistrationView'),
                    ),
                    array(
                        'label' => 'Inspeksi Kendaraan', 
                        'url' => array('/frontDesk/vehicleInspection/admin'), 
                        'visible' => Yii::app()->user->checkAccess('inspectionCreate') || Yii::app()->user->checkAccess('inspectionEdit') || 
                            Yii::app()->user->checkAccess('inspectionView') || Yii::app()->user->checkAccess('inspectionApproval'),
                    ),
                    array(
                        'label' => 'Vehicle System Check', 
                        'url' => array('/frontDesk/vehicleSystemCheck/admin'), 
                        'visible' => Yii::app()->user->checkAccess('systemCheckCreate') || Yii::app()->user->checkAccess('systemCheckEdit') || 
                            Yii::app()->user->checkAccess('systemCheckView') || Yii::app()->user->checkAccess('systemCheckApproval'),
                    ),
                    array(
                        'label' => 'Work Order Active', 
                        'url' => array('/frontDesk/workOrder/admin'),
                        'visible' => Yii::app()->user->checkAccess('workOrderView'),
                    ),
                    array(
                        'label' => 'Outstanding Work Order', 
                        'url' => array('/frontDesk/workOrder/adminOutstanding'),
                        'visible' => Yii::app()->user->checkAccess('outstandingWorkOrderView'),
                    ),
                    array(
                        'label' => 'Kasir', 
                        'url' => array('/frontDesk/registrationTransaction/cashier'), 
                        'visible' => (Yii::app()->user->checkAccess('cashierView')),
                    ),
                    array(
                        'label' => 'Daftar Antrian Customer', 
                        'url' => array('/frontDesk/customerWaitlist/index'), 
                        'visible' => Yii::app()->user->checkAccess('customerQueueView'),
                    ),
                    array(
                        'label' => 'Follow Up Warranty', 
                        'url' => array('/frontDesk/followUp/adminWarranty'), 
                        'visible' => Yii::app()->user->checkAccess('customerFollowUp'),
                    ),
                    array(
                        'label' => 'Follow Up Service', 
                        'url' => array('/frontDesk/followUp/adminService'), 
                        'visible' => Yii::app()->user->checkAccess('serviceFollowUp'),
                    ),
                    array(
                        'label' => 'Status Kendaraan', 
                        'url' => array('/frontDesk/vehicleStatus/index'), 
                        'visible' => (Yii::app()->user->checkAccess('vehicleStatusView')),
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('requestOrderCreate') || 
        Yii::app()->user->checkAccess('requestOrderEdit') || 
        Yii::app()->user->checkAccess('requestOrderView') || 
        Yii::app()->user->checkAccess('requestOrderApproval') || 
        Yii::app()->user->checkAccess('purchaseOrderCreate') || 
        Yii::app()->user->checkAccess('purchaseOrderEdit') || 
        Yii::app()->user->checkAccess('purchaseOrderView') || 
        Yii::app()->user->checkAccess('purchaseOrderApproval') || 
        Yii::app()->user->checkAccess('saleOrderCreate') || 
        Yii::app()->user->checkAccess('saleOrderEdit') || 
        Yii::app()->user->checkAccess('saleOrderView') || 
        Yii::app()->user->checkAccess('saleOrderApproval') || 
        Yii::app()->user->checkAccess('saleInvoiceCreate') || 
        Yii::app()->user->checkAccess('saleInvoiceEdit') || 
        Yii::app()->user->checkAccess('saleInvoiceView') || 
        Yii::app()->user->checkAccess('coretaxInvoiceView') || 
        Yii::app()->user->checkAccess('workOrderExpenseCreate') || 
        Yii::app()->user->checkAccess('workOrderExpenseEdit') || 
        Yii::app()->user->checkAccess('workOrderExpenseView') || 
        Yii::app()->user->checkAccess('workOrderExpenseApproval') || 
        Yii::app()->user->checkAccess('pricingRequestCreate') || 
        Yii::app()->user->checkAccess('pricingRequestEdit') || 
        Yii::app()->user->checkAccess('pricingRequestView') || 
        Yii::app()->user->checkAccess('pricingRequestApproval') || 
        Yii::app()->user->checkAccess('paymentInCreate') || 
        Yii::app()->user->checkAccess('paymentInEdit') || 
        Yii::app()->user->checkAccess('paymentInView') || 
        Yii::app()->user->checkAccess('paymentInApproval') || 
        Yii::app()->user->checkAccess('paymentOutCreate') || 
        Yii::app()->user->checkAccess('paymentOutEdit') || 
        Yii::app()->user->checkAccess('paymentOutView') || 
        Yii::app()->user->checkAccess('paymentOutApproval') || 
        Yii::app()->user->checkAccess('cashTransactionCreate') || 
        Yii::app()->user->checkAccess('cashTransactionEdit') || 
        Yii::app()->user->checkAccess('cashTransactionView')  || 
        Yii::app()->user->checkAccess('cashTransactionApproval')|| 
        Yii::app()->user->checkAccess('adjustmentJournalCreate') || 
        Yii::app()->user->checkAccess('adjustmentJournalView') || 
        Yii::app()->user->checkAccess('adjustmentJournalApproval')
    ) : ?>
        <li class="mdropdown"> <a href="#">TRANSAKSI</a>							
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'PEMBELIAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
//                    array(
//                        'label' => 'Order Permintaan', 
//                        'url' => array('/transaction/transactionRequestOrder/admin'), 
//                        'visible' => (Yii::app()->user->checkAccess('requestOrderCreate') || Yii::app()->user->checkAccess('requestOrderEdit') || 
//                            Yii::app()->user->checkAccess('requestOrderView') || Yii::app()->user->checkAccess('requestOrderApproval'))
//                    ),
                    array(
                        'label' => 'Order Pembelian', 
                        'url' => array('/transaction/transactionPurchaseOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('purchaseOrderCreate') || Yii::app()->user->checkAccess('purchaseOrderEdit') || 
                            Yii::app()->user->checkAccess('purchaseOrderView') || Yii::app()->user->checkAccess('purchaseOrderApproval'))
                    ),
//                    array(
//                        'label' => 'Pembelian Barang non stok', 
//                        'url' => array('/frontDesk/itemRequest/admin'), 
//                        'visible' => (Yii::app()->user->checkAccess('itemRequestCreate') || Yii::app()->user->checkAccess('itemRequestEdit') || Yii::app()->user->checkAccess('itemRequestView'))
//                    ),
//                    array(
//                        'label' => 'Perbandingan', 
//                        'url' => array('/transaction/compare/step1'), 
//                        'visible' => (Yii::app()->user->checkAccess('purchaseHead'))
//                    ),
                    array('label' => 'PENJUALAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Order Penjualan', 
                        'url' => array('/transaction/transactionSalesOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('saleOrderCreate') || Yii::app()->user->checkAccess('saleOrderEdit') || 
                            Yii::app()->user->checkAccess('saleOrderView') || Yii::app()->user->checkAccess('saleOrderApproval'))
                    ),
                    array(
                        'label' => 'Faktur Penjualan', 
                        'url' => array('/transaction/invoiceHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('saleInvoiceCreate') || Yii::app()->user->checkAccess('saleInvoiceEdit') || 
                            Yii::app()->user->checkAccess('saleInvoiceView'))
                    ),
                    array(
                        'label' => 'Faktur Pajak Coretax', 
                        'url' => array('/accounting/saleInvoiceCoretax/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('coretaxInvoiceView'))
                    ),
                    array(
                        'label' => 'Sub Pekerjaan Luar', 
                        'url' => array('/accounting/workOrderExpense/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('workOrderExpenseCreate') || Yii::app()->user->checkAccess('workOrderExpenseEdit') || 
                            Yii::app()->user->checkAccess('workOrderExpenseView') || Yii::app()->user->checkAccess('workOrderExpenseApproval'))
                    ),
                    array(
                        'label' => 'Permintaan Harga Cabang', 
                        'url' => array('/frontDesk/productPricingRequest/adminPending'), 
                        'visible' => (Yii::app()->user->checkAccess('pricingRequestCreate') || Yii::app()->user->checkAccess('pricingRequestEdit') || 
                            Yii::app()->user->checkAccess('pricingRequestView') || Yii::app()->user->checkAccess('pricingRequestApproval'))
                    ),
                    array('label' => 'PELUNASAN', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Payment In', 
                        'url' => array('/transaction/paymentIn/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('paymentInCreate') || Yii::app()->user->checkAccess('paymentInEdit') || 
                            Yii::app()->user->checkAccess('paymentInView') || Yii::app()->user->checkAccess('paymentInApproval'))
                    ),
                    array(
                        'label' => 'Payment Out', 
                        'url' => array('/accounting/paymentOut/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('paymentOutCreate') || Yii::app()->user->checkAccess('paymentOutEdit') || 
                            Yii::app()->user->checkAccess('paymentOutView') || Yii::app()->user->checkAccess('paymentOutApproval'))
                    ),
                    array('label' => 'TUNAI', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Transaksi Kas', 
                        'url' => array('/transaction/cashTransaction/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('cashTransactionCreate') || Yii::app()->user->checkAccess('cashTransactionEdit') || 
                            Yii::app()->user->checkAccess('cashTransactionView') || Yii::app()->user->checkAccess('cashTransactionApproval'))
                    ),
                    array(
                        'label' => 'Transaksi Jurnal Umum', 
                        'url' => array('/accounting/journalAdjustment/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('adjustmentJournalCreate') || Yii::app()->user->checkAccess('adjustmentJournalView') || 
                            Yii::app()->user->checkAccess('adjustmentJournalApproval'))
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('transferRequestCreate') || 
        Yii::app()->user->checkAccess('transferRequestEdit') || 
        Yii::app()->user->checkAccess('transferRequestView') || 
        Yii::app()->user->checkAccess('transferRequestApproval') || 
        Yii::app()->user->checkAccess('sentRequestCreate') || 
        Yii::app()->user->checkAccess('sentRequestEdit') || 
        Yii::app()->user->checkAccess('sentRequestView') || 
        Yii::app()->user->checkAccess('sentRequestApproval') || 
        Yii::app()->user->checkAccess('purchaseReturnCreate') || 
        Yii::app()->user->checkAccess('purchaseReturnEdit') || 
        Yii::app()->user->checkAccess('purchaseReturnView') || 
        Yii::app()->user->checkAccess('purchaseReturnApproval') || 
        Yii::app()->user->checkAccess('saleReturnCreate') || 
        Yii::app()->user->checkAccess('saleReturnEdit') || 
        Yii::app()->user->checkAccess('saleReturnView') || 
        Yii::app()->user->checkAccess('saleReturnApproval') || 
        Yii::app()->user->checkAccess('deliveryCreate') || 
        Yii::app()->user->checkAccess('deliveryEdit') || 
        Yii::app()->user->checkAccess('deliveryView') || 
        Yii::app()->user->checkAccess('receiveItemCreate') || 
        Yii::app()->user->checkAccess('receiveItemEdit') || 
        Yii::app()->user->checkAccess('receiveItemView') || 
        Yii::app()->user->checkAccess('receiveItemApproval') || 
        Yii::app()->user->checkAccess('partsSupplyCreate') || 
        Yii::app()->user->checkAccess('partsSupplyEdit') || 
        Yii::app()->user->checkAccess('partsSupplyView') || 
        Yii::app()->user->checkAccess('partsSupplyApproval') || 
        Yii::app()->user->checkAccess('consignmentInCreate') || 
        Yii::app()->user->checkAccess('consignmentInEdit') || 
        Yii::app()->user->checkAccess('consignmentInView') || 
        Yii::app()->user->checkAccess('consignmentInApproval') || 
        Yii::app()->user->checkAccess('consignmentOutCreate') || 
        Yii::app()->user->checkAccess('consignmentOutEdit') || 
        Yii::app()->user->checkAccess('consignmentOutView') || 
        Yii::app()->user->checkAccess('consignmentOutApproval') || 
        Yii::app()->user->checkAccess('movementInCreate') || 
        Yii::app()->user->checkAccess('movementInEdit') || 
        Yii::app()->user->checkAccess('movementInView') || 
        Yii::app()->user->checkAccess('movementInApproval') || 
        Yii::app()->user->checkAccess('movementOutCreate') || 
        Yii::app()->user->checkAccess('movementOutEdit') || 
        Yii::app()->user->checkAccess('movementOutView') || 
        Yii::app()->user->checkAccess('movementOutApproval') || 
        Yii::app()->user->checkAccess('movementServiceCreate') || 
        Yii::app()->user->checkAccess('movementServiceEdit') || 
        Yii::app()->user->checkAccess('movementServiceView') || 
        Yii::app()->user->checkAccess('movementServiceApproval') || 
        Yii::app()->user->checkAccess('materialRequestCreate') || 
        Yii::app()->user->checkAccess('materialRequestEdit') || 
        Yii::app()->user->checkAccess('materialRequestView') || 
        Yii::app()->user->checkAccess('materialRequestApproval') || 
        Yii::app()->user->checkAccess('stockAdjustmentCreate') || 
        Yii::app()->user->checkAccess('stockAdjustmentApproval') || 
        Yii::app()->user->checkAccess('stockAdjustmentView') || 
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
                        'visible' => (Yii::app()->user->checkAccess('transferRequestCreate') || Yii::app()->user->checkAccess('transferRequestEdit') || 
                            Yii::app()->user->checkAccess('transferRequestView') || Yii::app()->user->checkAccess('transferRequestApproval'))
                    ),
                    array(
                        'label' => 'Permintaan Kirim', 
                        'url' => array('/transaction/transactionSentRequest/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('sentRequestCreate') || Yii::app()->user->checkAccess('sentRequestEdit') || 
                            Yii::app()->user->checkAccess('sentRequestView') || Yii::app()->user->checkAccess('sentRequestApproval'))
                    ),
                    array(
                        'label' => 'Retur Beli', 
                        'url' => array('/transaction/transactionReturnOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('purchaseReturnCreate') || Yii::app()->user->checkAccess('purchaseReturnEdit') || 
                            Yii::app()->user->checkAccess('purchaseReturnView') || Yii::app()->user->checkAccess('purchaseReturnApproval'))
                    ),
                    array(
                        'label' => 'Retur Jual', 
                        'url' => array('/transaction/transactionReturnItem/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('saleReturnCreate') || Yii::app()->user->checkAccess('saleReturnEdit') || 
                            Yii::app()->user->checkAccess('saleReturnView') || Yii::app()->user->checkAccess('saleReturnApproval'))
                    ),
                    array(
                        'label' => 'Pengiriman Barang', 
                        'url' => array('/transaction/transactionDeliveryOrder/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('deliveryCreate') || Yii::app()->user->checkAccess('deliveryEdit') || 
                            Yii::app()->user->checkAccess('deliveryView'))
                    ),
                    array(
                        'label' => 'Penerimaan Barang', 
                        'url' => array('/transaction/transactionReceiveItem/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('receiveItemCreate') || Yii::app()->user->checkAccess('receiveItemEdit') || 
                            Yii::app()->user->checkAccess('receiveItemView') || Yii::app()->user->checkAccess('receiveItemApproval'))
                    ),
                    array(
                        'label' => 'Penerimaan Parts Supply', 
                        'url' => array('/frontDesk/receiveParts/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('partsSupplyCreate') || Yii::app()->user->checkAccess('partsSupplyEdit') || 
                            Yii::app()->user->checkAccess('partsSupplyView') || Yii::app()->user->checkAccess('partsSupplyApproval'))
                    ),
                    array(
                        'label' => 'Penerimaan Konsinyasi', 
                        'url' => array('/transaction/consignmentInHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('consignmentInCreate') || Yii::app()->user->checkAccess('consignmentInEdit') || 
                            Yii::app()->user->checkAccess('consignmentInView') || Yii::app()->user->checkAccess('consignmentInApproval'))
                    ),
                    array(
                        'label' => 'Pengeluaran Konsinyasi', 
                        'url' => array('/transaction/consignmentOutHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('consignmentOutCreate') || Yii::app()->user->checkAccess('consignmentOutEdit') || 
                            Yii::app()->user->checkAccess('consignmentOutView') || Yii::app()->user->checkAccess('consignmentOutApproval'))
                    ),
                    array('label' => 'GUDANG', 'url' => array('#'), 'itemOptions' => array('class' => 'title', 'style' => 'text-decoration: underline')),
                    array(
                        'label' => 'Barang Masuk Gudang', 
                        'url' => array('/transaction/movementInHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('movementInCreate') || Yii::app()->user->checkAccess('movementInEdit') || 
                            Yii::app()->user->checkAccess('movementInView') || Yii::app()->user->checkAccess('movementInApproval'))
                    ),
                    array(
                        'label' => 'Barang Keluar Gudang', 
                        'url' => array('/transaction/movementOutHeader/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('movementOutCreate') || Yii::app()->user->checkAccess('movementOutEdit') || 
                            Yii::app()->user->checkAccess('movementOutView') || Yii::app()->user->checkAccess('movementOutApproval'))
                    ),
                    array(
                        'label' => 'Pengeluaran Bahan Pemakaian', 
                        'url' => array('/frontDesk/movementOutService/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('movementServiceCreate') || Yii::app()->user->checkAccess('movementServiceEdit') || 
                            Yii::app()->user->checkAccess('movementServiceView') || Yii::app()->user->checkAccess('movementServiceApproval'))
                    ),
                    array(
                        'label' => 'Permintaan Bahan', 
                        'url' => array('/frontDesk/materialRequest/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('materialRequestCreate') || Yii::app()->user->checkAccess('materialRequestEdit') || 
                            Yii::app()->user->checkAccess('materialRequestView') || Yii::app()->user->checkAccess('materialRequestApproval'))
                    ),
                    array(
                        'label' => 'Stok Gudang', 
                        'url' => array('/frontDesk/inventory/check'), 
                        'visible' => (Yii::app()->user->checkAccess('warehouseStockReport'))
                    ),
                    array(
                        'label' => 'Analisa Stok Barang', 
                        'url' => array('/report/stockAnalysis/summary'), 
                        'visible' => (Yii::app()->user->checkAccess('stockAnalysisReport'))
                    ),
                    array(
                        'label' => 'Penyesuaian Stok', 
                        'url' => array('/frontDesk/adjustment/admin'), 
                        'visible' => (Yii::app()->user->checkAccess('stockAdjustmentCreate') || Yii::app()->user->checkAccess('stockAdjustmentView') || 
                            Yii::app()->user->checkAccess('stockAdjustmentApproval'))
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('brHeadCreate') || 
        Yii::app()->user->checkAccess('brHeadEdit') || 
        Yii::app()->user->checkAccess('brHeadView') || 
        Yii::app()->user->checkAccess('brMechanicCreate') || 
        Yii::app()->user->checkAccess('brMechanicEdit') ||
        Yii::app()->user->checkAccess('brMechanicView') ||
        Yii::app()->user->checkAccess('grMechanicCreate') || 
        Yii::app()->user->checkAccess('grMechanicEdit') || 
        Yii::app()->user->checkAccess('grMechanicView') || 
        Yii::app()->user->checkAccess('grHeadCreate') || 
        Yii::app()->user->checkAccess('grHeadEdit') || 
        Yii::app()->user->checkAccess('grHeadView') || 
        Yii::app()->user->checkAccess('vehicleInServiceView')
    ): ?>
        <li class="mdropdown"><a href="#">Management</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'GENERAL REPAIR', 'url' => array('#'), 'itemOptions' => array(
                        'class' => 'title', 
                        'style' => 'text-decoration: underline'
                    )),
                    array(
                        'label' => 'Mechanic POV', 
                        'url' => array('/frontDesk/generalRepairMechanic/index'), 
                        'visible' => (Yii::app()->user->checkAccess('grMechanicCreate') || Yii::app()->user->checkAccess('grMechanicEdit') || 
                            Yii::app()->user->checkAccess('grMechanicView'))
                    ),
                    array(
                        'label' => 'Head POV', 
                        'url' => array('/frontDesk/generalRepairManagement/index'), 
                        'visible' => (Yii::app()->user->checkAccess('grHeadCreate') || Yii::app()->user->checkAccess('grHeadEdit') || 
                            Yii::app()->user->checkAccess('grHeadView'))
                    ),
                    array('label' => 'BODY REPAIR', 'url' => array('#'), 'itemOptions' => array(
                        'class' => 'title', 
                        'style' => 'text-decoration: underline'
                    )),
                    array(
                        'label' => 'Mechanic POV', 
                        'url' => array('/frontDesk/bodyRepairMechanic/index'), 
                        'visible' => (Yii::app()->user->checkAccess('brMechanicCreate') || Yii::app()->user->checkAccess('brMechanicEdit') || 
                            Yii::app()->user->checkAccess('brMechanicView'))
                    ),
                    array(
                        'label' => 'Head POV', 
                        'url' => array('/frontDesk/bodyRepairManagement/index'), 
                        'visible' => (Yii::app()->user->checkAccess('brHeadCreate') || Yii::app()->user->checkAccess('brHeadEdit') || 
                            Yii::app()->user->checkAccess('brHeadView'))
                    ),
                    array('label' => 'KENDARAAN', 'url' => array('#'), 'itemOptions' => array(
                        'class' => 'title', 
                        'style' => 'text-decoration: underline'
                    )),
                    array(
                        'label' => 'Kendaraan Dalam Bengkel', 
                        'url' => array('/frontDesk/vehicleInboundList/index'), 
                        'visible' => (Yii::app()->user->checkAccess('vehicleInServiceView'))
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('payableDueReport') || 
        Yii::app()->user->checkAccess('receivableDueReport') || 
        Yii::app()->user->checkAccess('financialAnalysisReport') || 
        Yii::app()->user->checkAccess('kertasKerjaReport') || 
        Yii::app()->user->checkAccess('cashDailyReport') || 
        Yii::app()->user->checkAccess('assetManagementCreate') || 
        Yii::app()->user->checkAccess('assetManagementEdit') || 
        Yii::app()->user->checkAccess('assetManagementView') || 
        Yii::app()->user->checkAccess('financialSummary') || 
        Yii::app()->user->checkAccess('cancelledTransactionView')
    ): ?>
        <li class="mdropdown"><a href="#">ACCOUNTING/FINANCE</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Hutang Jatuh Tempo', 
                        'url' => array('/accounting/payableIncomingDue/index'), 
                        'visible' => Yii::app()->user->checkAccess('payableDueReport'),
                    ),
                    array(
                        'label' => 'Piutang Jatuh Tempo', 
                        'url' => array('/accounting/receivableIncomingDue/index'), 
                        'visible' => Yii::app()->user->checkAccess('receivableDueReport'),
                    ),
                    array(
                        'label' => 'Analisa Keuangan', 
                        'url' => array('/accounting/forecasting/admin'), 
                        'visible' => Yii::app()->user->checkAccess('financialAnalysisReport'),
                    ),
                    array(
                        'label' => 'Kertas Kerja', 
                        'url' => array('/accounting/coa/kertasKerja'), 
                        'visible' => Yii::app()->user->checkAccess('kertasKerjaReport'),
                    ),
                    array(
                        'label' => 'Laporan Kas Harian', 
                        'url' => array('/report/kasharian/report'), 
                        'visible' => Yii::app()->user->checkAccess('cashDailyReport'),
                    ),
                    array(
                        'label' => 'Aset Management', 
                        'url' => array('/accounting/assetManagement/admin'), 
                        'visible' => Yii::app()->user->checkAccess('assetManagementCreate') || Yii::app()->user->checkAccess('assetManagementEdit') || 
                            Yii::app()->user->checkAccess('assetManagementView'),
                    ),
                    array(
                        'label' => 'Financial Forecast', 
                        'url' => array('/accounting/financialForecast/summary'), 
                        'visible' => Yii::app()->user->checkAccess('financialSummary'),
                    ),
                    array(
                        'label' => 'Cancelled Transactions', 
                        'url' => array('/accounting/cancelledTransaction/index'), 
                        'visible' => Yii::app()->user->checkAccess('cancelledTransactionView'),
                    ),
                    array(
                        'label' => 'Dashboard Summary', 
                        'url' => array('/report/analyticsTransaction/summary'), 
                        'visible' => Yii::app()->user->checkAccess('director'),
                    ),
                    array(
                        'label' => 'Saldo Awal COA', 
                        'url' => array('/accounting/journalBeginning/admin'), 
                        'visible' => Yii::app()->user->checkAccess('director'),
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('masterEmployeeCreate') || 
        Yii::app()->user->checkAccess('masterEmployeeEdit') || 
        Yii::app()->user->checkAccess('masterEmployeeView') || 
        Yii::app()->user->checkAccess('masterEmployeeApproval') || 
        Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryCreate') || 
        Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryEdit') || 
        Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryView') || 
        Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryApproval') || 
        Yii::app()->user->checkAccess('masterHolidayCreate') || 
        Yii::app()->user->checkAccess('masterHolidayEdit') || 
        Yii::app()->user->checkAccess('masterHolidayView') || 
        Yii::app()->user->checkAccess('masterHolidayApproval') || 
        Yii::app()->user->checkAccess('employeeTimesheetCreate') || 
        Yii::app()->user->checkAccess('employeeTimesheetEdit') || 
        Yii::app()->user->checkAccess('employeeTimesheetView') || 
        Yii::app()->user->checkAccess('employeeLeaveApplicationCreate') || 
        Yii::app()->user->checkAccess('employeeLeaveApplicationEdit') || 
        Yii::app()->user->checkAccess('employeeLeaveApplicationView') || 
        Yii::app()->user->checkAccess('employeeLeaveApplicationApproval') || 
        Yii::app()->user->checkAccess('payrollReport') || 
        Yii::app()->user->checkAccess('employeeScheduleReport') || 
        Yii::app()->user->checkAccess('employeeAbsencyReport') || 
        Yii::app()->user->checkAccess('yearlyEmployeeAbsencyReport') || 
        Yii::app()->user->checkAccess('employeeBirthdateReport')
    ): ?>
        <li class="mdropdown"><a href="#">HRD</a>
            <?php $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array(
                        'label' => 'Data Karyawan', 
                        'url' => array('/master/employee/admin'), 
                        'visible' => Yii::app()->user->checkAccess('masterEmployeeCreate') || Yii::app()->user->checkAccess('masterEmployeeEdit') || 
                            Yii::app()->user->checkAccess('masterEmployeeView') || Yii::app()->user->checkAccess('masterEmployeeApproval')
                    ),
                    array(
                        'label' => 'Kategori Ketidakhadiran', 
                        'url' => array('/master/employeeOnleaveCategory/admin'), 
                        'visible' => Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryCreate') || Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryView') || Yii::app()->user->checkAccess('masterEmployeeOnleaveCategoryApproval')
                    ),
                    array(
                        'label' => 'Public Holiday', 
                        'url' => array('/master/publicDayOff/admin'), 
                        'visible' => Yii::app()->user->checkAccess('masterHolidayCreate') || Yii::app()->user->checkAccess('masterHolidayEdit') || 
                            Yii::app()->user->checkAccess('masterHolidayView') || Yii::app()->user->checkAccess('masterHolidayApproval')
                    ),
                    array(
                        'label' => 'Absensi Karyawan', 
                        'url' => array('/master/employeeTimesheet/admin'), 
                        'visible' => Yii::app()->user->checkAccess('employeeTimesheetCreate') || Yii::app()->user->checkAccess('employeeTimesheetEdit') || 
                            Yii::app()->user->checkAccess('employeeTimesheetView')
                    ),
                    array(
                        'label' => 'Pengajuan Cuti Karyawan', 
                        'url' => array('/master/employeeDayoff/adminDraft'), 
                        'visible' => Yii::app()->user->checkAccess('employeeLeaveApplicationCreate') || Yii::app()->user->checkAccess('employeeLeaveApplicationEdit') || 
                            Yii::app()->user->checkAccess('employeeLeaveApplicationView')
                    ),
                    array(
                        'label' => 'Data Cuti Karyawan', 
                        'url' => array('/master/employeeDayoff/admin'), 
                        'visible' => Yii::app()->user->checkAccess('employeeLeaveApplicationEdit') || Yii::app()->user->checkAccess('employeeLeaveApplicationView') || 
                            Yii::app()->user->checkAccess('employeeLeaveApplicationApproval')
                    ),
                    array(
                        'label' => 'Payroll', 
                        'url' => array('/master/employeePayroll/admin'), 
                        'visible' => Yii::app()->user->checkAccess('payrollReport')
                    ),
                    array(
                        'label' => 'Jadwal Karyawan', 
                        'url' => array('/master/employeeSchedule/index'), 
                        'visible' => Yii::app()->user->checkAccess('employeeScheduleReport')
                    ),
                    array(
                        'label' => 'Rekap Absensi Karyawan', 
                        'url' => array('/report/employeeAttendance/summary'), 
                        'visible' => Yii::app()->user->checkAccess('employeeAbsencyReport')
                    ),
                    array(
                        'label' => 'Absensi Karyawan Tahunan', 
                        'url' => array('/report/employeeYearlyAttendance/summary'), 
                        'visible' => Yii::app()->user->checkAccess('yearlyEmployeeAbsencyReport')
                    ),
                    array(
                        'label' => 'Ulang Tahun Karyawan', 
                        'url' => array('/master/employee/index'), 
                        'visible' => Yii::app()->user->checkAccess('employeeBirthdateReport')
                    ),
                ),
            )); ?>
        </li>
    <?php endif; ?>
    
    <?php if (
        Yii::app()->user->checkAccess('warehouseStockReport') || 
        Yii::app()->user->checkAccess('stockCardItemReport') ||  
        Yii::app()->user->checkAccess('stockCardWarehouseReport') || 
        Yii::app()->user->checkAccess('deliveryReport') || 
        Yii::app()->user->checkAccess('receiveItemReport') || 
        Yii::app()->user->checkAccess('workOrderExpenseReport') || 
        Yii::app()->user->checkAccess('stockValueReport') || 
        Yii::app()->user->checkAccess('stockQuantityValueReport') || 
        Yii::app()->user->checkAccess('stockPositionReport') || 
        Yii::app()->user->checkAccess('stockTireReport') || 
        Yii::app()->user->checkAccess('stockOilReport') || 
        Yii::app()->user->checkAccess('workOrderServiceReport') || 
        Yii::app()->user->checkAccess('workOrderVehicleReport') || 
        Yii::app()->user->checkAccess('mechanicPerformanceReport') || 
        Yii::app()->user->checkAccess('salesmanPerformanceReport') || 
        Yii::app()->user->checkAccess('transactionJournalReport') || 
        Yii::app()->user->checkAccess('journalSummaryReport') || 
        Yii::app()->user->checkAccess('summaryPurchaseReport') || 
        Yii::app()->user->checkAccess('summaryPaymentOutReport') ||
        Yii::app()->user->checkAccess('summarySaleReport') ||
        Yii::app()->user->checkAccess('summaryPaymentInReport') ||
        Yii::app()->user->checkAccess('summaryMovementInReport') ||
        Yii::app()->user->checkAccess('summaryMovementOutReport') ||
        Yii::app()->user->checkAccess('summaryWorkOrderExpenseReport') ||
        Yii::app()->user->checkAccess('summaryMovementOutMaterialReport') || 
        Yii::app()->user->checkAccess('summaryCashReport') || 
        Yii::app()->user->checkAccess('generalLedgerReport') || 
        Yii::app()->user->checkAccess('receivableJournalReport') || 
        Yii::app()->user->checkAccess('customerUnpaidInvoiceReport') || 
        Yii::app()->user->checkAccess('customerReceivableReport') || 
        Yii::app()->user->checkAccess('insuranceUnpaidInvoiceReport') || 
        Yii::app()->user->checkAccess('insuranceReceivableReport') || 
        Yii::app()->user->checkAccess('paymentInReport') || 
        Yii::app()->user->checkAccess('saleSummaryReport') || 
        Yii::app()->user->checkAccess('saleProductSummaryReport') || 
        Yii::app()->user->checkAccess('saleServiceSummaryReport') || 
        Yii::app()->user->checkAccess('saleServiceProductCategoryReport') || 
        Yii::app()->user->checkAccess('saleCustomerReport') || 
        Yii::app()->user->checkAccess('saleCustomerSummaryReport') || 
        Yii::app()->user->checkAccess('cashDailyApprovalReport') || 
        Yii::app()->user->checkAccess('cashDailySummaryReport') || 
        Yii::app()->user->checkAccess('financialForecastReport') || 
        Yii::app()->user->checkAccess('cashTransactionReport') || 
        Yii::app()->user->checkAccess('monthlyBankingReport') || 
        Yii::app()->user->checkAccess('adjustmentJournalReport') || 
        Yii::app()->user->checkAccess('payableJournalReport') || 
        Yii::app()->user->checkAccess('supplierPayableReport') || 
        Yii::app()->user->checkAccess('payableReport') || 
        Yii::app()->user->checkAccess('paymentOutReport') || 
        Yii::app()->user->checkAccess('purchaseSummaryReport') ||
        Yii::app()->user->checkAccess('purchaseSupplierSummaryReport') || 
        Yii::app()->user->checkAccess('purchaseProductSummaryReport') ||  
        Yii::app()->user->checkAccess('dailySaleBranchReport') || 
        Yii::app()->user->checkAccess('dailySaleAllBranchReport') || 
        Yii::app()->user->checkAccess('monthlySaleBranchReport') || 
        Yii::app()->user->checkAccess('monthlySaleAllBranchReport') || 
        Yii::app()->user->checkAccess('yearlySaleBranchReport') || 
        Yii::app()->user->checkAccess('yearlySaleAllBranchReport') || 
        Yii::app()->user->checkAccess('dailySaleFrontReport') || 
        Yii::app()->user->checkAccess('dailySaleAllFrontReport') || 
        Yii::app()->user->checkAccess('monthlySaleFrontReport') || 
        Yii::app()->user->checkAccess('monthlySaleAllFrontReport') || 
        Yii::app()->user->checkAccess('yearlySaleFrontReport') || 
        Yii::app()->user->checkAccess('yearlySaleAllFrontReport') || 
        Yii::app()->user->checkAccess('dailySaleMechanicReport') || 
        Yii::app()->user->checkAccess('dailySaleAllMechanicReport') || 
        Yii::app()->user->checkAccess('monthlySaleMechanicReport') || 
        Yii::app()->user->checkAccess('monthlySaleAllMechanicReport') || 
        Yii::app()->user->checkAccess('yearlySaleMechanicReport') || 
        Yii::app()->user->checkAccess('yearlySaleAllMechanicReport') || 
        Yii::app()->user->checkAccess('saleInvoiceDailyReport') || 
        Yii::app()->user->checkAccess('saleTaxReport') || 
        Yii::app()->user->checkAccess('purchaseTaxReport') || 
        Yii::app()->user->checkAccess('saleNonTaxReport') || 
        Yii::app()->user->checkAccess('purchaseNonTaxReport') || 
        Yii::app()->user->checkAccess('saleCustomerYearlyReport') || 
        Yii::app()->user->checkAccess('saleInsuranceYearlyReport') || 
        Yii::app()->user->checkAccess('saleVehicleMonthlyReport') || 
        Yii::app()->user->checkAccess('saleVehicleBrandReport') || 
        Yii::app()->user->checkAccess('saleVehicleCustomerReport') || 
        Yii::app()->user->checkAccess('customerFollowUpReport') || 
        Yii::app()->user->checkAccess('saleTireDailyReport') || 
        Yii::app()->user->checkAccess('saleOilDailyReport') || 
        Yii::app()->user->checkAccess('monthlyProductSaleReport') || 
        Yii::app()->user->checkAccess('monthlyServiceSaleReport') || 
        Yii::app()->user->checkAccess('productCategoryStatisticsReport') || 
        Yii::app()->user->checkAccess('partsComponentSaleTransactionReport') || 
        Yii::app()->user->checkAccess('monthlyMaterialServiceUsageReport')
    ): ?>
        <li><?php echo CHtml::link('Laporan', array('/report/default/index')); ?></li>
    <?php endif; ?>
    
    <?php if (Yii::app()->user->checkAccess('director')): ?>
        <li><?php echo CHtml::link('LAPORAN BoD', array('/report/default/indexManagement')); ?></li>
    <?php endif; ?>
</ul>
