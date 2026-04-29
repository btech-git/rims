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

    <hr />

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <div class="row" style="margin-top:20px" id="noliststyle">
                    
                    <div class="small-4 columns">
                        <?php if (Yii::app()->user->checkAccess('director')): ?>
                            <h2>Financial</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laba Rugi (Induk)', 
                                        'url' => array('/report/profitLoss/summary'), 
                                        'visible' => (Yii::app()->user->checkAccess('director'))
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
                                        'label' => 'Neraca (Induk)', 
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
                        <?php if (Yii::app()->user->checkAccess('director')): ?>
                            <h2>Sales</h2>
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
                                        'label' => 'Transaksi Retail Summary', 
                                        'url' => array('/report/saleFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Payment Type Bulanan', 
                                        'url' => array('/report/paymentMonthly/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Konfirmasi Transaksi Harian', 
                                        'url' => array('/report/dailyTransactionConfirmation/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Penjualan Kendaraan Customer', 
                                        'url' => array('/report/customerVehicleSaleTransaction/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-4 columns">
                        <?php if (Yii::app()->user->checkAccess('director')): ?>
                            <h2>Management</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Outstanding Purchase Order', 
                                        'url' => array('/report/outstandingPurchaseOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Outstanding Sales Transaction', 
                                        'url' => array('/report/outstandingSaleRetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Outstanding Work Order', 
                                        'url' => array('/report/outstandingWorkOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Outstanding Sales Order', 
                                        'url' => array('/report/outstandingSaleOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Outstanding Registration Transaction', 
                                        'url' => array('/report/outstandingRegistrationTransaction/summary'), 
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
                        <?php if (Yii::app()->user->checkAccess('director')): ?>
                            <h2>Transaksi Table</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Pembelian Harian Summary', 
                                        'url' => array('/report/purchaseFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Pembelian WO Summary', 
                                        'url' => array('/report/purchaseWorkOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Perpindahan Barang Summary', 
                                        'url' => array('/report/warehouseFlowSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Daftar Aset Tetap', 
                                        'url' => array('/report/fixedAsset/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('director')
                                    ),
                                    array(
                                        'label' => 'Penyesuaian Stok Gudang', 
                                        'url' => array('/report/stockAdjustment/summary'), 
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