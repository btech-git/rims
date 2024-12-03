<?php
Yii::app()->clientScript->registerScript('report', '
    $("#TransactionDate").val("' . $transactionDate . '");
    $("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div>
                <div class="myForm">
                    <?php echo CHtml::beginForm(array(''), 'get'); ?>                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch </span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- Pilih Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Tanggal</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'TransactionDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                                'placeholder' => 'Tanggal Transaksi',
                                            ),
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                        <?php echo CHtml::submitButton('Konfirmasi Transaksi', array('name' => 'Confirmation', 'class' => 'button success right')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <div style="font-weight: bold; text-align: center">
                        <div style="font-size: larger">
                            <?php $branch = Branch::model()->findByPk($branchId); ?>
                            <?php echo CHtml::encode(CHtml::value($branch, 'name')); ?>
                        </div>
                        <div style="font-size: larger">Laporan Transaksi Harian</div>
                        <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($transactionDate))); ?></div>
                    </div>

                    <br />

                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Penjualan' => array(
                                'content' => $this->renderPartial('_summarySale', array(
                                    'registrationTransactionRetailData' => $registrationTransactionRetailData,
                                    'registrationTransactionCompanyData' => $registrationTransactionCompanyData,
                                    'invoiceHeaderRetailData' => $invoiceHeaderRetailData,
                                    'invoiceHeaderCompanyData' => $invoiceHeaderCompanyData,
                                    'paymentInRetailData' => $paymentInRetailData,
                                    'paymentInCompanyData' => $paymentInCompanyData,
                                ), true),
                            ),
                            'Pembelian' => array(
                                'content' => $this->renderPartial('_summaryPurchase', array(
                                    'paymentOutData' => $paymentOutData,
                                    'purchaseOrderData' => $purchaseOrderData,
                                ), true),
                            ),
                            'Kas' => array(
                                'content' => $this->renderPartial('_summaryCash', array(
                                    'cashTransactionInData' => $cashTransactionInData,
                                    'cashTransactionOutData' => $cashTransactionOutData,
                                ), true),
                            ),
                            'Gudang' => array(
                                'content' => $this->renderPartial('_summaryInventory', array(
                                    'movementInData' => $movementInData,
                                    'movementOutData' => $movementOutData,
                                    'deliveryData' => $deliveryData,
                                    'receiveItemData' => $receiveItemData, 
                                    'sentRequestData' => $sentRequestData,
                                    'transferRequestData' => $transferRequestData,
                                ), true),
                            ),
                            'Kendaraan' => array(
                                'content' => $this->renderPartial('_summaryVehicle', array(
                                    'vehicleData' => $vehicleData,
                                    'registrationTransactionData' => $registrationTransactionData,
                                ), true),
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
            
            <br/>

            <div class="hide">
                <div class="right"></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<div class="hide">
    <div class="right">
        <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $deliveryOrderSummary->dataProvider->pagination->itemCount,
            'pageSize' => $deliveryOrderSummary->dataProvider->pagination->pageSize,
            'currentPage' => $deliveryOrderSummary->dataProvider->pagination->getCurrentPage(false),
        ));*/ ?>
    </div>
    <div class="clear"></div>
</div>