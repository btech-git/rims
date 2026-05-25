<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
    )); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'transaction_number', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model,'transaction_number'); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model,'transaction_date', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name' => 'StartDate',
                                'attribute' => $startDate,
                                'options'=>array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'readonly' => true,
                                ),
                            )); ?>
                        </div>
                        <div class="medium-2 columns" style="text-align: center; vertical-align: middle">
                            S/D
                        </div>
                        <div class="medium-5 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                'name' => 'EndDate',
                                'attribute' => $endDate,
                                'options'=>array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth'=>true,
                                    'changeYear'=>true,
                                ),
                                'htmlOptions'=>array(
                                    'readonly' => true,
                                ),
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'status', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status', array(
                            'Draft' => 'Draft',
                            'Revised' => 'Need Revision',
                            'Rejected'=>'Rejected',
                            'Approved' => 'Approved',
                        ), array('empty' => '-- all --')); ?>
                    </div>
                </div>
            </div>
            
        </div>
        
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'COA Asal', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('CoaId', $coaId, array(
                            'readonly' => true,
                            'onclick' => '$("#coa-dialog").dialog("open"); return false;', 
                            'onkeypress' => 'if (event.keyCode == 13) { $("#coa-dialog").dialog("open"); return false; }',
                        )); ?>

                        <?php echo CHtml::openTag('span', array('id' => 'coa_name')); ?>
                        <?php $coaModel = Coa::model()->findByPk($coaId); ?>
                        <?php echo CHtml::encode(CHtml::value($coaModel, 'name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'COA Tujuan', array('class'=>'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('CoaIdDetail', $coaIdDetail, array(
                            'readonly' => true,
                            'onclick' => '$("#coa-detail-dialog").dialog("open"); return false;', 
                            'onkeypress' => 'if (event.keyCode == 13) { $("#coa-detail-dialog").dialog("open"); return false; }',
                        )); ?>

                        <?php echo CHtml::openTag('span', array('id' => 'coa_detail_name')); ?>
                        <?php $coaDetailModel = Coa::model()->findByPk($coaIdDetail); ?>
                        <?php echo CHtml::encode(CHtml::value($coaDetailModel, 'name')); ?>
                        <?php echo CHtml::closeTag('span'); ?>
                    </div>
                </div>
            </div>	

            <?php if ((int) $user->branch_id == 6): ?>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->label($model,'branch_id', array('class'=>'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo CHtml::activeDropDownList($model, 'branch_id', CHtml::listData(Branch::model()->findAllByPk(Yii::app()->user->branch_ids, array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="field buttons text-right">
                <?php echo CHtml::submitButton('Search',array('class'=>'button cbutton')); ?>
            </div>
        </div>
    </div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->

<!--COA Detail-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Name</td>
                        <td>Category</td>
                        <td>Sub Category</td>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::textField('CodeHeader', $codeHeader, array(
                                'onchange' => '
                                $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    code: $(this).val(),
                                    name: $("#coa_name").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::textField('NameHeader', $nameHeader, array(
                                'onchange' => '
                                $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    name: $(this).val(),
                                    code: $("#coa_code").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::dropDownList('CoaCategoryHeaderId', $coaCategoryHeaderId, CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateSubCategorySelect'),
                                    'update' => '#sub_category',
                                )) . '$.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    coa_category_id: $(this).val(),
                                    id: $("#coa_id").val(),
                                    code: $("#coa_code").val(),
                                    name: $("#coa_name").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <div id="sub_category">
                                <?php echo CHtml::dropDownList('CoaSubCategoryHeaderId', $coaSubCategoryHeaderId, CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                    $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                        coa_sub_category_id: $(this).val(),
                                        code: $("#coa_code").val(),
                                        coa_category_id: $("#coa_category_id").val(),
                                        name: $("#coa_name").val(),
                                    } } });',
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'coa-header-grid',
                'dataProvider' => $coaDataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id) {
                    $("#CoaId").val($.fn.yiiGridView.getSelection(id));
                    $("#coa-dialog").dialog("close");
                    if ($.fn.yiiGridView.getSelection(id) == "") {
                        $("#coa_name").html("");
                    } else {
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonCoa') . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#coa_name").html(data.coa_name);
                            },
                        });
                    }
                }',
                'columns' => array(
                    array(
                        'name' => 'name', 
                        'value' => '$data->name', 
                        'type' => 'raw'
                    ),
                    'code',
                    array(
                        'name' => 'coa_category_id',
                        'value' => '$data->coaCategory!="" ?$data->coaCategory->name:""',
                    ),
                    array(
                        'name' => 'coa_sub_category_id',
                        'value' => '$data->coaSubCategory!="" ?$data->coaSubCategory->name:""'
                    ),
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<!--COA Detail-->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-detail-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'COA Detail',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>
    <?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
            <table>
                <thead>
                    <tr>
                        <td>Code</td>
                        <td>Name</td>
                        <td>Category</td>
                        <td>Sub Category</td>
                    </tr>
                </thead>
                
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::textField('CodeDetail', $codeDetail, array(
                                'onchange' => '
                                $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    code: $(this).val(),
                                    name: $("#coa_name").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::textField('NameDetail', $nameDetail, array(
                                'onchange' => '
                                $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    name: $(this).val(),
                                    code: $("#coa_code").val(),
                                    coa_category_id: $("#coa_category_id").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <?php echo CHtml::dropDownList('CoaCategoryDetailId', $coaCategoryDetailId, CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateSubCategorySelect'),
                                    'update' => '#sub_category',
                                )) . '$.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                    coa_category_id: $(this).val(),
                                    id: $("#coa_id").val(),
                                    code: $("#coa_code").val(),
                                    name: $("#coa_name").val(),
                                    coa_sub_category_id: $("#coa_sub_category_id").val(),
                                } } });',
                            )); ?>
                        </td>
                        
                        <td>
                            <div id="sub_category">
                                <?php echo CHtml::dropDownList('CoaSubCategoryDetailId', $coaSubCategoryDetailId, CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'onchange' => '
                                    $.fn.yiiGridView.update("coa-detail-grid", {data: {Coa: {
                                        coa_sub_category_id: $(this).val(),
                                        code: $("#coa_code").val(),
                                        coa_category_id: $("#coa_category_id").val(),
                                        name: $("#coa_name").val(),
                                    } } });',
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'coa-detail-grid',
                'dataProvider' => $coaDetailDataProvider,
                'filter' => null,
                'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id) {
                    $("#CoaIdDetail").val($.fn.yiiGridView.getSelection(id));
                    $("#coa-detail-dialog").dialog("close");
                    if ($.fn.yiiGridView.getSelection(id) == "") {
                        $("#coa_detail_name").html("");
                    } else {
                        $.ajax({
                            type: "POST",
                            dataType: "JSON",
                            url: "' . CController::createUrl('ajaxJsonCoa') . '",
                            data: $("form").serialize(),
                            success: function(data) {
                                $("#coa_detail_name").html(data.coa_name);
                            },
                        });
                    }
                }',
                'columns' => array(
                    array(
                        'name' => 'name', 
                        'value' => '$data->name', 
                        'type' => 'raw'
                    ),
                    'code',
                    array(
                        'name' => 'coa_category_id',
                        'value' => '$data->coaCategory!="" ?$data->coaCategory->name:""',
                    ),
                    array(
                        'name' => 'coa_sub_category_id',
                        'value' => '$data->coaSubCategory!="" ?$data->coaSubCategory->name:""'
                    ),
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
