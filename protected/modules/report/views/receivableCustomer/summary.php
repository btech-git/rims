<?php
Yii::app()->clientScript->registerScript('report', '
    $(".breadcrumbs").addClass("hide");
    $("#EndDate").val("' . $endDate . '");
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
<!--                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Customer</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php /*echo CHtml::textField('CustomerId', $customerId, array(
                                            'readonly' => true,
                                            'onclick' => 'jQuery("#customer-dialog").dialog("open"); return false;',
                                        )); ?>
                                        <?php echo CHtml::openTag('span', array('id' => 'customer_name')); ?>
                                        <?php $customer = Customer::model()->findByPk($customerId); ?>
                                        <?php echo CHtml::encode(CHtml::value($customer, 'name')); ?>
                                        <?php echo CHtml::closeTag('span');*/ ?> 
                                    </div>
                                </div>
                            </div>
                        </div>-->
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array(
                                            'empty'=>'-- All Branch --',
                                            'disabled' => Yii::app()->user->checkAccess('director') ? '' : 'disabled',
                                        )); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Per Tanggal</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'EndDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth'=>true,
                                                'changeYear'=>true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
//                                                'placeholder' => 'Sampai',
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

                <div class="right"><?php echo ReportHelper::summaryText($receivableSummary->dataProvider); ?></div>
                
                <br />
                
                <div class="right"><?php //echo ReportHelper::sortText($receivableSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
                
                <div class="clear"></div>

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'receivableSummary' => $receivableSummary,
                        'receivableReportData' => $receivableReportData,
                        'receivablePaymentReportData' => $receivablePaymentReportData,
                        'endDate' => $endDate,
                        'branchId' => $branchId,
                        'customerId' => $customerId,
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hide">
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $receivableSummary->dataProvider->pagination->itemCount,
            'pageSize' => $receivableSummary->dataProvider->pagination->pageSize,
            'currentPage' => $receivableSummary->dataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>

<div class="grid-view">
    <?php /*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'customer-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Customer ',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id'=>'customer-grid',
                'dataProvider'=>$customerDataProvider,
                'filter' => $customer,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager'=>array(
                   'cssFile'=>false,
                   'header'=>'',
                ),
                'selectionChanged'=>'js:function(id){
                    $("#CustomerId").val($.fn.yiiGridView.getSelection(id));
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
                'columns'=> array(
                    'mobile_phone',
                    'name',
                    'email',
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
</div>