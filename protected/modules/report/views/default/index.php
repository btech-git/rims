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
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterUserCreate') || 
                            Yii::app()->user->checkAccess('masterUserEdit') || 
                            Yii::app()->user->checkAccess('masterUserApproval') || 
                            Yii::app()->user->checkAccess('masterCompanyCreate') || 
                            Yii::app()->user->checkAccess('masterCompanyEdit') || 
                            Yii::app()->user->checkAccess('masterCompanyApproval') || 
                            Yii::app()->user->checkAccess('masterBranchCreate') || 
                            Yii::app()->user->checkAccess('masterBranchEdit') || 
                            Yii::app()->user->checkAccess('masterBranchApproval') || 
                            Yii::app()->user->checkAccess('masterSupplierCreate') || 
                            Yii::app()->user->checkAccess('masterSupplierEdit') || 
                            Yii::app()->user->checkAccess('masterSupplierApproval') || 
                            Yii::app()->user->checkAccess('masterEmployeeCreate') || 
                            Yii::app()->user->checkAccess('masterEmployeeEdit') || 
                            Yii::app()->user->checkAccess('masterEmployeeApproval') || 
                            Yii::app()->user->checkAccess('masterDeductionCreate') || 
                            Yii::app()->user->checkAccess('masterDeductionEdit') || 
                            Yii::app()->user->checkAccess('masterDeductionApproval') || 
                            Yii::app()->user->checkAccess('masterIncentiveCreate') || 
                            Yii::app()->user->checkAccess('masterIncentiveEdit') || 
                            Yii::app()->user->checkAccess('masterIncentiveApproval') || 
                            Yii::app()->user->checkAccess('masterPositionCreate') || 
                            Yii::app()->user->checkAccess('masterPositionEdit') || 
                            Yii::app()->user->checkAccess('masterPositionApproval') || 
                            Yii::app()->user->checkAccess('masterDivisionCreate') || 
                            Yii::app()->user->checkAccess('masterDivisionEdit') || 
                            Yii::app()->user->checkAccess('masterDivisionApproval') || 
                            Yii::app()->user->checkAccess('masterLevelCreate') || 
                            Yii::app()->user->checkAccess('masterLevelEdit') || 
                            Yii::app()->user->checkAccess('masterLevelApproval') || 
                            Yii::app()->user->checkAccess('masterUnitCreate') || 
                            Yii::app()->user->checkAccess('masterUnitEdit') || 
                            Yii::app()->user->checkAccess('masterUnitApproval') || 
                            Yii::app()->user->checkAccess('masterConversionCreate') || 
                            Yii::app()->user->checkAccess('masterConversionEdit') || 
                            Yii::app()->user->checkAccess('masterConversionApproval') || 
                            Yii::app()->user->checkAccess('masterHolidayCreate') || 
                            Yii::app()->user->checkAccess('masterHolidayEdit') || 
                            Yii::app()->user->checkAccess('masterHolidayApproval')
                        ):*/ ?>
                            <h2>Keuangan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Profit/Loss (induk)', 
                                        'url' => array('/report/profitLoss/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryProfitLossReport')
                                    ),
                                    array(
                                        'label' => 'Profit/Loss (Standar)', 
                                        'url' => array('/report/profitLossDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('standardProfitLossReport')
                                    ),
                                    array(
                                        'label' => 'Balance Sheet (induk)', 
                                        'url' => array('/report/balanceSheet/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('summaryBalanceSheetReport')
                                    ),
                                    array(
                                        'label' => 'Balance Sheet (Standar)', 
                                        'url' => array('/report/balanceSheetDetail/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('standardBalanceSheetReport')
                                    ),
                                ),
                            )); ?>
                        <?php //endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterBankCreate') || 
                            Yii::app()->user->checkAccess('masterBankEdit') || 
                            Yii::app()->user->checkAccess('masterBankApproval') || 
                            Yii::app()->user->checkAccess('masterCoaCreate') || 
                            Yii::app()->user->checkAccess('masterCoaEdit') || 
                            Yii::app()->user->checkAccess('masterCoaApproval') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeCreate') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeEdit') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeApproval')
                        ):*/ ?>
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
                        <?php //endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterProductCreate') || 
                            Yii::app()->user->checkAccess('masterProductEdit') || 
                            Yii::app()->user->checkAccess('masterProductApproval') || 
                            Yii::app()->user->checkAccess('masterProductCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterProductCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterProductCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterBrandCreate') || 
                            Yii::app()->user->checkAccess('masterBrandEdit') || 
                            Yii::app()->user->checkAccess('masterBrandApproval') || 
                            Yii::app()->user->checkAccess('masterSubBrandCreate') || 
                            Yii::app()->user->checkAccess('masterSubBrandEdit') || 
                            Yii::app()->user->checkAccess('masterSubBrandApproval') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesCreate') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesEdit') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesApproval') || 
                            Yii::app()->user->checkAccess('masterEquipmentCreate') || 
                            Yii::app()->user->checkAccess('masterEquipmentEdit') || 
                            Yii::app()->user->checkAccess('masterEquipmentApproval') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeCreate') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeEdit') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeApproval') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeCreate') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeEdit') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeApproval')
                        ):*/ ?>
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
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterServiceCreate') || 
                            Yii::app()->user->checkAccess('masterServiceEdit') || 
                            Yii::app()->user->checkAccess('masterServiceApproval') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterServiceTypeCreate') || 
                            Yii::app()->user->checkAccess('masterServiceTypeEdit') || 
                            Yii::app()->user->checkAccess('masterServiceTypeApproval') || 
                            Yii::app()->user->checkAccess('masterPricelistStandardCreate') || 
                            Yii::app()->user->checkAccess('masterPricelistStandardEdit') || 
                            Yii::app()->user->checkAccess('masterPricelistStandardApproval') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupCreate') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupEdit') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupApproval') || 
                            Yii::app()->user->checkAccess('masterPricelistSetCreate') || 
                            Yii::app()->user->checkAccess('masterPricelistSetEdit') || 
                            Yii::app()->user->checkAccess('masterPricelistSetApproval') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateCreate') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateEdit') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateApproval') || 
                            Yii::app()->user->checkAccess('masterStandardValueCreate') || 
                            Yii::app()->user->checkAccess('masterStandardValueEdit') || 
                            Yii::app()->user->checkAccess('masterStandardValueApproval') || 
                            Yii::app()->user->checkAccess('masterQuickServiceCreate') || 
                            Yii::app()->user->checkAccess('masterQuickServiceEdit') || 
                            Yii::app()->user->checkAccess('masterQuickServiceApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleApproval')
                        ):*/ ?>
                        <h2>Piutang</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Rincian Buku Besar Pembantu Piutang', 
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
                        <?php //endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterVehicleCreate') || 
                            Yii::app()->user->checkAccess('masterVehicleEdit') || 
                            Yii::app()->user->checkAccess('masterVehicleApproval') || 
                            Yii::app()->user->checkAccess('masterCustomerCreate') || 
                            Yii::app()->user->checkAccess('masterCustomerEdit') || 
                            Yii::app()->user->checkAccess('masterCustomerApproval') || 
                            Yii::app()->user->checkAccess('masterInsuranceCreate') || 
                            Yii::app()->user->checkAccess('masterInsuranceEdit') || 
                            Yii::app()->user->checkAccess('masterInsuranceApproval') ||
                            Yii::app()->user->checkAccess('masterCarMakeCreate') || 
                            Yii::app()->user->checkAccess('masterCarMakeEdit') || 
                            Yii::app()->user->checkAccess('masterCarMakeApproval') || 
                            Yii::app()->user->checkAccess('masterCarModelCreate') || 
                            Yii::app()->user->checkAccess('masterCarModelEdit') || 
                            Yii::app()->user->checkAccess('masterCarModelApproval') || 
                            Yii::app()->user->checkAccess('masterCarSubModelCreate') || 
                            Yii::app()->user->checkAccess('masterCarSubModelEdit') || 
                            Yii::app()->user->checkAccess('masterCarSubModelApproval') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailCreate') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailEdit') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailApproval') || 
                            Yii::app()->user->checkAccess('masterColorCreate') || 
                            Yii::app()->user->checkAccess('masterColorEdit') || 
                            Yii::app()->user->checkAccess('masterColorApproval')
                        ):*/ ?>
                            <h2>Penjualan</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array('label' => 'Penjualan Retail', 'url' => array('/report/saleRetail/summary'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                                    array('label' => 'Penjualan Retail Product', 'url' => array('/report/saleRetailProduct/summary'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                                    array('label' => 'Penjualan Retail Service', 'url' => array('/report/saleRetailService/summary'), 'visible' => (Yii::app()->user->checkAccess('saleOrderReport') || Yii::app()->user->checkAccess('saleInvoiceReport'))),
                                ),
                            )); ?>
                        <?php //endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ):*/ ?>
                            <h2>Aset Tetap</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Daftar Aset Tetap', 
                                        'url' => array('/report/fixedAsset/summary'), 
//                                        'visible' => Yii::app()->user->checkAccess('generalManager')
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
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ):*/ ?>
                            <h2>Hutang</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Rincian Buku Besar Pembantu Hutang', 
                                        'url' => array('/report/payableLedger/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('payableJournalReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Hutang Supplier', 
                                        'url' => array('/report/payable/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('supplierPayableReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Payment Out', 
                                        'url' => array('/report/paymentOut/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('paymentOutReport')
                                    ),
                                ),
                            )); ?>
                        <?php //endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ):*/ ?>
                            <h2>Pembelian</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Laporan Pembelian (Detail)', 
                                        'url' => array('/report/purchaseOrder/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                    array(
                                        'label' => 'Laporan Pembelian (Summary)', 
                                        'url' => array('/report/purchaseSummary/summary'), 
                                        'visible' => Yii::app()->user->checkAccess('purchaseOrderReport')
                                    ),
                                ),
                            )); ?>
                        <?php //endif; ?>
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
                                        'label' => 'Nilai Persediaan Barang', 
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
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ):*/ ?>
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
                        <?php //endif; ?>
                    </div>

                    <div class="small-4 columns">
                        <?php /*if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ):*/ ?>
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
                        <?php //endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>