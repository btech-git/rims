<?php
Yii::app()->clientScript->registerScript('report', '

	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
	$("#PageSize").val("' . $generalLedgerSummary->dataProvider->pagination->pageSize . '");
	$("#CurrentPage").val("' . ($generalLedgerSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                        <span class="prefix">Branch</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All Branch --')); ?>
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
                                        <span class="prefix">Category</span>
                                    </div>

                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownList($account, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                            'empty' => '-- All --',
                                            'order' => 'name',
                                            'onchange' => CHtml::ajax(array(
                                                'type' => 'GET',
                                                'url' => CController::createUrl('ajaxHtmlUpdateCoaSubCategorySelect'),
                                                'update' => '#coa_sub_category',
                                            )),
                                        )); ?>
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
                                        <span class="prefix">Sub Category</span>
                                    </div>
                                    
                                    <div class="small-8 columns" id="coa_sub_category">
                                        <?php echo CHtml::activeDropDownList($account, 'coa_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                            'empty' => '-- All --',
                                        )); ?>
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
                                        <span class="prefix">COA Code</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($account, 'code'); ?>
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
                                        <span class="prefix">COA Name</span>
                                    </div>
                                    
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($account, 'name'); ?>
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
                        <?php echo CHtml::resetButton('Hapus');  ?>
                        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
                    </div>

                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

                </div>

                <hr />

                <div class="relative">
                    <?php $this->renderPartial('_summary', array(
                        'account' => $account,
                        'generalLedgerSummary' => $generalLedgerSummary,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                        'branchId' => $branchId,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<div class="grid-view">
    <?php /*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'coa-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'COA ',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'coa-grid',
        'dataProvider'=>$coaDataProvider,
        'filter'=>$account,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'selectionChanged'=>'js:function(id){
            $("#' . CHtml::activeId($account, 'id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#coa-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#coa_id").html("");
                $("#coa_name").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonCoa') . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#coa_id").html(data.id);
                        $("#coa_name").html(data.name);
                    },
                });
            }
        }',
        'columns'=> array(
            'code',
            'name',
            array(
                'name' => 'coa_category_id',
                'filter' => CHtml::activeDropDownList($account, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->coaCategory!="" ? $data->coaCategory->name : ""',
            ),
            array(
                'name' => 'coa_sub_category_id',
                'filter' => CHtml::activeDropDownList($account, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->coaSubCategory!="" ? $data->coaSubCategory->name : ""'
            ),
        ),
    )); ?>
    
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog');*/ ?>
</div>