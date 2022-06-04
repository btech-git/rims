<?php
Yii::app()->clientScript->registerScript('report', '

    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $receivableLedgerSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($receivableLedgerSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                    <div class="small-2 columns">
                                        <span class="prefix">Customer</span>
                                    </div>
                                    
                                    <div class="small-5 columns">
                                        <?php echo CHtml::textField('CustomerName', $customerName, array(
//                                            'readonly' => true, 
//                                            'onclick' => '$("#customer-dialog").dialog("open"); return false;', 
//                                            'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }'
                                        )); ?>
                                    </div>
                                    
                                    <div class="small-5 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
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
                                    <div class="small-2 columns">
                                        <span class="prefix">Periode:</span>
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
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'receivableLedgerSummary' => $receivableLedgerSummary,
                        'customer' => $customer,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<div>
    <?php /*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
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
            $("#' . CHtml::activeId($customer, 'id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#customer-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#customer_type").html("");
                $("#customer_name").html("");
                $("#customer_address").html("");

            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonCustomer') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#customer_type").html(data.customer_type);
                        $("#customer_name").html(data.customer_name);
                        $("#customer_address").html(data.customer_address);
                    },
                });
            }
        }',
        'columns' => array(
            'name',
            'customer_type',
            'address',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>