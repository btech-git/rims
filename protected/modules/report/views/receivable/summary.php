<?php
Yii::app()->clientScript->registerScript('report', '
	$(".breadcrumbs").addClass("hide");

	$("#PageSize").val("' . $saleInvoiceSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($saleInvoiceSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                        <span class="prefix">Jumlah per Halaman</span>
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
                                        <span class="prefix">Customer</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($invoiceHeader, 'customer_id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                                        )); ?>

                                        <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($invoiceHeader, 'customer.name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Halaman saat ini</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Vehicle Plate #</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('PlateNumber', $plateNumber, array('size' => 3)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch </span>
                                    </div>
                                    <div class="small-8 columns">
                                          <?php echo CHtml::activeDropDownlist($invoiceHeader, 'branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-2 columns">
                                        <span class="prefix">Tanggal </span>
                                    </div>
                                    <div class="small-5 columns">
                                        <?php /* $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                                        ));*/ ?>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="right"><?php echo ReportHelper::summaryText($saleInvoiceSummary->dataProvider); ?></div>
                <br />
                <div class="right"><?php echo ReportHelper::sortText($saleInvoiceSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
                <div class="clear"></div>

                <br />
        
                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'saleInvoiceSummary' => $saleInvoiceSummary,
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
    <div>
        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
            'id' => 'customer-dialog',
            // additional javascript options for the dialog plugin
            'options' => array(
                'title' => 'Customer',
                'autoOpen' => false,
                'width' => 'auto',
                'modal' => true,
            ),
        )); ?>
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'customer-grid',
            'dataProvider' => $customerDataProvider,
            'filter' => $customer,
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'selectionChanged' => 'js:function(id) {
                $("#' . CHtml::activeId($invoiceHeader, 'customer_id') . '").val($.fn.yiiGridView.getSelection(id));
                $("#customer-dialog").dialog("close");
                if ($.fn.yiiGridView.getSelection(id) == "")
                {
                    $("#customer_name").html("");
                    $("#customer_type").html("");
                    $("#customer_mobile_phone").html("");
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        dataType: "JSON",
                        url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $invoiceHeader->id)) . '",
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#customer_name").html(data.customer_name);
                            $("#customer_type").html(data.customer_type);
                            $("#customer_mobile_phone").html(data.customer_mobile_phone);
                        },
                    });
                }
            }',
            'columns' => array(
                'name',
                'customer_type',
                'mobile_phone',
            ),
        )); ?>
        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
    </div>
</div>