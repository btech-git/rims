<?php
Yii::app()->clientScript->registerScript('report', '
	$(".breadcrumbs").addClass("hide");

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#PageSize").val("' . $purchaseSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($purchaseSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
	$("#CurrentSort").val("' . $currentSort . '");
');
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form" style="text-align: center">

            <?php echo CHtml::beginForm(array(''), 'get'); ?>

            <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>

            <div class="row" style="background-color: #DFDFDF">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">Supplier</label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($purchaseOrderHeader, 'supplier_id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }'
                                        )); ?>

                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'supplier-dialog',
                                            // additional javascript options for the dialog plugin
                                            'options' => array(
                                                'title' => 'Supplier',
                                                'autoOpen' => false,
                                                'width' => 'auto',
                                                'modal' => true,
                                            ),
                                        )); ?>
                                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                                            'id' => 'supplier-grid',
                                            'dataProvider' => $supplierDataProvider,
                                            'filter' => $supplier,
                                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                            'pager' => array(
                                                'cssFile' => false,
                                                'header' => '',
                                            ),
                                            'selectionChanged' => 'js:function(id) {
                                                $("#' . CHtml::activeId($purchaseOrderHeader, 'supplier_id') . '").val($.fn.yiiGridView.getSelection(id));
                                                $("#supplier-dialog").dialog("close");
                                                if ($.fn.yiiGridView.getSelection(id) == "")
                                                {
                                                    $("#supplier_name").html("");
                                                    $("#supplier_code").html("");
                                                    $("#supplier_mobile_phone").html("");
                                                }
                                                else
                                                {
                                                    $.ajax({
                                                        type: "POST",
                                                        dataType: "JSON",
                                                        url: "' . CController::createUrl('ajaxJsonCustomer', array('id' => $purchaseOrderHeader->id)) . '",
                                                        data: $("form").serialize(),
                                                        success: function(data) {
                                                            $("#supplier_name").html(data.supplier_name);
                                                            $("#supplier_code").html(data.supplier_code);
                                                            $("#supplier_mobile_phone").html(data.supplier_mobile_phone);
                                                        },
                                                    });
                                                }
                                            }',
                                            'columns' => array(
                                                'code',
                                                'name',
                                                'mobile_phone',
                                            ),
                                        )); ?>
                                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                                        <?php echo CHtml::openTag('span', array('id' => 'supplier_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($purchaseOrderHeader, 'supplier.name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>    
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix">Tanggal</label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'StartDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
                                            ),
                                        )); ?>
                                        -
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'name' => 'EndDate',
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
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
                                        <span class="prefix">Branch </span>
                                    </div>
                                     <div class="small-8 columns">
                                          <?php echo CHtml::activeDropDownlist($purchaseOrderHeader, 'main_branch_id', CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <?php echo CHtml::resetButton('Clear', array('class' => 'button alert')); ?>
                                <?php echo CHtml::submitButton('Show', array('onclick' => '$("#CurrentSort").val(""); return true;', 'class' => 'button success')); ?>
                                <?php echo CHtml::submitButton('Save To Excel', array('name' => 'SaveToExcel', 'class' => 'button primary')); ?>
                            </div>

                            <br />
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php echo CHtml::hiddenField('sort', '', array('id' => 'CurrentSort')); ?>
            </div>

            <?php echo CHtml::endForm(); ?>

        </div>

        <hr />

        <div class="right"><?php echo ReportHelper::summaryText($purchaseSummary->dataProvider); ?></div>
        <div class="clear"></div>
        <div class="right"><?php echo ReportHelper::sortText($purchaseSummary->dataProvider->sort, array('Tanggal', 'Customer')); ?></div>
        <div class="clear"></div>

        <div>
            <?php $this->renderPartial('_summary', array(
                'purchaseSummary' => $purchaseSummary, 
                'startDate' => $startDate, 
                'endDate' => $endDate
            )); ?>
        </div>

        <div class="right">
            <?php /*$this->widget('system.web.widgets.pagers.CLinkPager', array(
                'itemCount' => $purchaseSummary->dataProvider->pagination->itemCount,
                'pageSize' => $purchaseSummary->dataProvider->pagination->pageSize,
                'currentPage' => $purchaseSummary->dataProvider->pagination->getCurrentPage(false),
            ));*/ ?>
        </div>
        <div class="clear"></div>
    </div>
</div>