<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $saleRetailCustomerSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($saleRetailCustomerSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                        <span class="prefix">Halaman saat ini</span>
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
                                    <div class="small-4 columns">
                                        <span class="prefix">Customer</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($customer, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }',
                                        )); ?>

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
                                            'pager'=>array(
                                               'cssFile'=>false,
                                               'header'=>'',
                                            ),
                                            'selectionChanged' => 'js:function(id){
                                                $("#' . CHtml::activeId($customer, 'id') . '").val($.fn.yiiGridView.getSelection(id));
                                                $("#customer-dialog").dialog("close");
                                                if ($.fn.yiiGridView.getSelection(id) == "") {
                                                    $("#customer_name").html("");
                                                } else {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "JSON",
                                                        url: "' . CController::createUrl('ajaxJsonCustomer') . '",
                                                        data: $("form").serialize(),
                                                        success: function(data) {
                                                            $("#customer_name").html(data.customer_name);
                                                        },
                                                    });
                                                }
                                            }',
                                            'columns' => array(
                                                'name',
                                                array(
                                                    'name' => 'email',
                                                    'value' => 'CHtml::encode(CHtml::value($data, "email"))',
                                                ),
                                                array(
                                                    'name' => 'customer_type',
                                                    'filter' => false, 
                                                    'value' => '$data->customer_type',
                                                ),
                                                array(
                                                    'header' => 'COA account',
                                                    'value' => 'empty($data->coa_id) ? "" : $data->coa->name',
                                                ),
                                                array(
                                                    'header' => 'PIC',
                                                    'value' => 'empty($data->customerPics) ? "" : $data->customerPics[0]->name',
                                                ),
                                            ),
                                        )); ?>
                                        <?php $this->endWidget(); ?>
                                        <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?> 

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownlist($customer, 'customer_type', array('Individual' => 'Individual', 'Company' => 'Company'), array('empty' => '-- All Type --')); ?>
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
                    </div>

                    <div class="clear"></div>
                    <div class="row buttons">
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="right"><?php echo ReportHelper::summaryText($saleRetailCustomerSummary->dataProvider); ?></div>
                <br />
                <div class="right"><?php echo ReportHelper::sortText($saleRetailCustomerSummary->dataProvider->sort, array('Name')); ?></div>
                <div class="clear"></div>

                <br />
        
                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'customer' => $customer,
                        'saleRetailCustomerSummary' => $saleRetailCustomerSummary,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="hide">
                <div class="right"></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<br/>

<div class="right">
    <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $saleRetailCustomerSummary->dataProvider->pagination->itemCount,
        'pageSize' => $saleRetailCustomerSummary->dataProvider->pagination->pageSize,
        'currentPage' => $saleRetailCustomerSummary->dataProvider->pagination->getCurrentPage(false),
    )); */?>
</div>
<div class="clear"></div>