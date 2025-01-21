<?php
Yii::app()->clientScript->registerScript('report', '
	$(".breadcrumbs").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#PageSize").val("' . $saleFlowSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($saleFlowSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm tabForm customer">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Jumlah per Halaman</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Halaman saat ini</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-2 columns">
                                    <span class="prefix">Tanggal </span>
                                </div>
                                
                                <div class="small-5 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'StartDate',
                                        'options' => array(
                                            'dateFormat' => 'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'placeholder' => 'Mulai',
                                        ),
                                    )); ?>
                                </div>

                                <div class="small-5 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'EndDate',
                                        'options' => array(
                                            'dateFormat' => 'yy-mm-dd',
                                            'changeMonth'=>true,
                                            'changeYear'=>true,
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'placeholder' => 'Sampai',
                                        ),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Status</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::dropDownlist('TransactionStatus', $transactionStatus, array(
                                        'Draft' => 'Draft', 
                                        'Approved' => 'Approved',
                                        'Rejected' => 'Rejected',
                                        'CANCELLED!!!' => 'Canceled', 
                                    ), array('empty' => '-- All Status --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                </div>

                <div class="row">
                    <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>

            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($saleFlowSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summarySale', array(
                    'saleFlowSummary' => $saleFlowSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($materialRequestFlowSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summaryMaterial', array(
                    'materialRequestFlowSummary' => $materialRequestFlowSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($transferRequestFlowSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summaryTransfer', array(
                    'transferRequestFlowSummary' => $transferRequestFlowSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($sentRequestFlowSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summarySent', array(
                    'sentRequestFlowSummary' => $sentRequestFlowSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <hr />

            <div class="relative">
                <div class="reportDisplay">
                    <?php echo ReportHelper::summaryText($purchaseOrderFlowSummary->dataProvider); ?>
                    <?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
                </div>

                <?php $this->renderPartial('_summaryPurchase', array(
                    'purchaseOrderFlowSummary' => $purchaseOrderFlowSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <div class="right">
                <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
                    'itemCount' => $saleFlowSummary->dataProvider->pagination->itemCount,
                    'pageSize' => $saleFlowSummary->dataProvider->pagination->pageSize,
                    'currentPage' => $saleFlowSummary->dataProvider->pagination->getCurrentPage(false),
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>