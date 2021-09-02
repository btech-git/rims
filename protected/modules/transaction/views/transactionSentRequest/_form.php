<?php
/* @var $this TransactionSentRequestController */
/* @var $sentRequest ->header TransactionSentRequest */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Sent Request',
        Yii::app()->baseUrl . '/transaction/transactionSentRequest/admin', array(
            'class' => 'button cbutton right',
            'visible' => Yii::app()->user->checkAccess("transaction.transactionSentRequest.admin")
        )) ?>
    <h1><?php if ($sentRequest->header->id == "") {
            echo "New Transaction Sent Request";
        } else {
            echo "Update Transaction Sent Request";
        } ?></h1>
    <!-- begin FORM -->
    <div class="form">

        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'transaction-sent-request-form',
            'enableAjaxValidation' => false,
        )); ?>

        <p class="note">Fields with <span class="required">*</span> are required.</p>

        <?php echo $form->errorSummary($sentRequest->header); ?>

        <div class="row">
            <div class="small-12 medium-6 columns">
<!--                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php //echo $form->labelEx($sentRequest->header, 'sent_request_no', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo CHtml::encode(CHtml::value($sentRequest->header, 'sent_request_no')); ?>
                            <?php //echo $form->textField($sentRequest->header, 'sent_request_no', array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php //echo $form->error($sentRequest->header, 'sent_request_no'); ?>
                        </div>
                    </div>
                </div>-->

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($sentRequest->header, 'sent_request_date',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($sentRequest->header, 'sent_request_date',
                                array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $sentRequest->header,
                                'attribute' => "sent_request_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $sentRequest->header->isNewRecord ? date('Y-m-d') : $sentRequest->header->sent_request_date,
                                ),
                            ));*/ ?>
                            <?php echo $form->error($sentRequest->header, 'sent_request_date'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($sentRequest->header, 'status_document',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($sentRequest->header, 'status_document', array(
                                'value' => $sentRequest->header->isNewRecord ? 'Draft' : $sentRequest->header->status_document,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->error($sentRequest->header, 'status_document'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($sentRequest->header, 'estimate_arrival_date',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $sentRequest->header,
                                'attribute' => "estimate_arrival_date",
                                // additional javascript options for the date picker plugin
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
//                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => $sentRequest->header->isNewRecord ? date('Y-m-d') : $sentRequest->header->estimate_arrival_date,
                                ),
                            ));
                            ?>
                            <?php echo $form->error($sentRequest->header, 'estimate_arrival_date'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="small-12 medium-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($sentRequest->header, 'requester_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($sentRequest->header, 'requester_id', array(
                                'value' => $sentRequest->header->isNewRecord ? Yii::app()->user->getId() : $sentRequest->header->requester_id,
                                'readonly' => true
                            )); ?>
                            <?php echo ($sentRequest->header->isNewRecord) ? CHtml::encode(Yii::app()->user->getName()) : CHtml::encode($sentRequest->header->user->username); ?>
                            <?php echo $form->error($sentRequest->header, 'requester_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($sentRequest->header, 'requester_branch_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->dropDownlist($sentRequest->header,'requester_branch_id',CHtml::listData(Branch::model()->findAll(),'id','name'),array('prompt'=>'[--Select Branch--]')); ?>
                            <?php echo $form->hiddenField($sentRequest->header, 'requester_branch_id', array(
                                'value' => $sentRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->id : $sentRequest->header->requester_branch_id,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->textField($sentRequest->header, 'requester_branch_name', array(
                                'value' => $sentRequest->header->isNewRecord ? Branch::model()->findByPk(User::model()->findByPk(Yii::app()->user->getId())->branch_id)->name : $sentRequest->header->requesterBranch->name,
                                'readonly' => true
                            )); ?>
                            <?php echo $form->error($sentRequest->header, 'requester_branch_id'); ?>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($sentRequest->header, 'destination_branch_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->dropDownlist($sentRequest->header, 'destination_branch_id',
                                CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'),
                                array('prompt' => '[--Select Branch--]')); ?>
                            <?php echo $form->error($sentRequest->header, 'destination_branch_id'); ?>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
            
        <div class="row">
            <div class="large-12 columns">    
                <fieldset>
                    <legend>Detail Product</legend>
                    <div class="row">
                        <div class="large-5 columns">
                            <div class="small-6 columns">
                                <?php echo CHtml::button('Add Details', array(
                                    'id' => 'detail-button',
                                    'name' => 'Detail',
                                    'style' => 'width:100%',

                                    'onclick' => '$("#product-dialog").dialog("open"); return false;
                                    jQuery.ajax({
                                        type: "POST",
                                        url: "' . CController::createUrl('ajaxHtmlAddDetail',
                                            array('id' => $sentRequest->header->id)) . '",
                                        data: jQuery("form").serialize(),
                                        success: function(html) {
                                            jQuery("#product").html(html);
                                        },
                                    });'
                                )); ?>
                            </div>
                        </div>
                    </div>

                    <br />
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="detail" id="product">
                                <?php $this->renderPartial('_detail', array(
                                    'sentRequest' => $sentRequest,
                                    'product' => $product,
                                )); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="field buttons text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton($sentRequest->header->isNewRecord ? 'Create' : 'Save',
                        array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
    
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Product',
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
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
                        <td>Master Kategori</td>
                        <td>Sub Master Kategori</td>
                        <td>Sub Kategori</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                                'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $(this).val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'name', array(
                                'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $(this).val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                    'update' => '#product_sub_brand',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $(this).val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $("#Product_product_master_category_id").val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_brand">
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                        'update' => '#product_sub_brand_series',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <div id="product_sub_brand_series">
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                    'update' => '#product_sub_master_category',
                                )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                    brand_id: $("#Product_brand_id").val(),
                                    sub_brand_id: $("#Product_sub_brand_id").val(),
                                    sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                    product_master_category_id: $(this).val(),
                                    product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                    product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                    manufacturer_code: $("#Product_manufacturer_code").val(),
                                    name: $("#Product_name").val(),
                                } } });',
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_master_category">
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                        'update' => '#product_sub_category',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <div id="product_sub_category">
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                    'empty' => '-- All --',
                                    'order' => 'name',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'product-grid',
                'dataProvider' => $productDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'selectionChanged' => 'js:function(id){
                    $("#product-dialog").dialog("close");
                    $.ajax({
                        type: "POST",
                        dataType: "html",
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $sentRequest->header->id, 'productId' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                        data: $("form").serialize(),
                        success: function(data) {
                            $("#product").html(data);
                        },
                    });

                    $("#product-grid").find("tr.selected").each(function(){
                        $(this).removeClass( "selected" );
                    });
                }',
                'columns' => array(
//                    'id',
                    array('name' => 'name', 'value' => '$data->name'),
                    'manufacturer_code',
                    array(
                        'header' => 'Kategori',
                        'value' => '$data->masterSubCategoryCode'
                    ),
                    array(
                        'name' => 'unit_id', 
                        'value' => '$data->unit->name'
                    ),
                    array(
                        'header' => 'Brand', 
                        'name'=>'product_brand_name', 
                        'value'=>'$data->brand->name'),
                    array(
                        'header' => 'Sub Brand', 
                        'name'=>'product_sub_brand_name', 
                        'value'=>'empty($data->subBrand) ? "" : $data->subBrand->name'
                    ),
                    array(
                        'header' => 'Sub Brand Series', 
                        'name'=>'product_sub_brand_series_name', 
                        'value'=>'empty($data->subBrandSeries) ? "" : $data->subBrandSeries->name'
                    ),
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('search', "
    $('#Product_findkeyword').keypress(function(e) {
        if (e.which == 13) {
            $.fn.yiiGridView.update('product-grid', {
                data: $(this).serialize()
            });
            return false;
        }
    });
"); ?>
<?php Yii::app()->clientScript->registerScript('updateGridView', '
	$.updateGridView = function(gridID, name, value) {
		$("#"+gridID+" input[name=\""+name+"\"], #"+gridID+" select[name=\""+name+"\"]").val(value);
		$.fn.yiiGridView.update(gridID, {data: $.param(
			$("#"+gridID+" .filters input, #"+gridID+" .filters select")
        )});
    }
', CClientScript::POS_READY); ?>