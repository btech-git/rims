<?php
Yii::app()->clientScript->registerScript('report', '
	$(".breadcrumbs").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#PageSize").val("' . $purchaseInvoiceSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($purchaseInvoiceSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
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
                                    <label class="prefix">Halaman saat ini</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix">Supplier</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('SupplierName', $supplierName, array('size' => 3)); ?>
                                </div>
                            </div>
                        </div>

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
                                    <label class="prefix">Jumlah per Halaman</label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch </span>
                                </div>
                                 <div class="small-8 columns">
                                      <?php echo CHtml::activeDropDownlist($purchaseOrderHeader, 'main_branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Status</span>
                                </div>
                                 <div class="small-8 columns">
                                      <?php echo CHtml::activeDropDownlist($purchaseOrderHeader, 'status_document', array(
                                          'Approved' => 'Approved',
                                          'Draft' => 'Draft',
                                          'Revised' => 'Revised',
                                          'Rejected' => 'Rejected',
                                          'CANCELLED!!!' => 'CANCELLED!!!',
                                      ), array('empty'=>'-- All Status --')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="clear"></div>
                
                        <div class="row buttons">
                            <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                            <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                            <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
                </div>

                <?php echo CHtml::endForm(); ?>

            </div>

            <hr />

            <div class="right"><?php //echo ReportHelper::summaryText($purchaseInvoiceSummary->dataProvider); ?></div>
            <div class="clear"></div>
            <div class="right"><?php //echo ReportHelper::sortText($purchaseInvoiceSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
            <div class="clear"></div>

            <div>
                <?php $this->renderPartial('_summary', array(
                    'purchaseInvoiceSummary' => $purchaseInvoiceSummary, 
                    'startDate' => $startDate, 
                    'endDate' => $endDate,
                )); ?>
            </div>

            <div class="hide">
                <div class="right">
                    <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
                        'itemCount' => $purchaseInvoiceSummary->dataProvider->pagination->itemCount,
                        'pageSize' => $purchaseInvoiceSummary->dataProvider->pagination->pageSize,
                        'currentPage' => $purchaseInvoiceSummary->dataProvider->pagination->getCurrentPage(false),
                    ));*/ ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>