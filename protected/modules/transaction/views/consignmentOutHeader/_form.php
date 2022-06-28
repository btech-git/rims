<?php
/* @var $this ConsignmentOutHeaderController */
/* @var $consignmentOut->header ConsignmentOutHeader */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'consignment-out-header-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($consignmentOut->header); ?>

    <div class="row">        
        <div class="large-6 columns">
            <div class="row collapse prefix-radius">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($consignmentOut->header, 'sender_id', array('class' => 'prefix')); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->hiddenField($consignmentOut->header, 'sender_id', array('readonly' => true, 'value' => $consignmentOut->header->isNewRecord ? Yii::app()->user->getId() : $consignmentOut->header->sender_id)); ?>
                    <?php echo $consignmentOut->header->isNewRecord ? Yii::app()->user->getName() : CHtml::encode(CHtml::value($consignmentOut->header, 'user.username')); ?>
                    <?php echo $form->error($consignmentOut->header, 'sender_id'); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="large-6 columns">
            <div class="row collapse prefix-radius">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($consignmentOut->header, 'date_posting', array('class' => 'prefix')); ?>
                </div>
                <div class="small-8 columns">
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $consignmentOut->header,
                        'attribute' => "date_posting",
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                            'yearRange' => '1900:2020'
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'value' => date('Y-m-d'),
                        ),
                    )); ?>
                    <?php //echo $form->textField($consignmentOut->header, 'date_posting', array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                    <?php echo $form->error($consignmentOut->header, 'date_posting'); ?>
                </div>
            </div>
        </div>

        <div class="large-6 columns">
            <div class="row collapse prefix-radius">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($consignmentOut->header, 'branch_id', array('class' => 'prefix')); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->dropDownlist($consignmentOut->header, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('prompt' => '[--Select Branch--]')); ?>
                    <?php echo $form->error($consignmentOut->header, 'branch_id'); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="large-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($consignmentOut->header, 'customer_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-2 columns">
                        <a class="button expand" href="<?php echo Yii::app()->baseUrl . '/master/customer/create'; ?>"><span class="fa fa-plus"></span>Add</a>
                    </div>
                    <div class="small-6 columns">
                        <?php echo CHtml::activeHiddenField($consignmentOut->header, 'customer_id'); ?>
                        <?php echo CHtml::activeTextField($consignmentOut->header, 'customer_name', array(
                            'size' => 15,
                            'maxlength' => 10,
                            'readonly' => true,
                            'onclick' => '$("#customer-dialog").dialog("open"); return false;',
                            'onkeypress' => 'if (event.keyCode == 13) { $("#customer-dialog").dialog("open"); return false; }',
                            'value' => $consignmentOut->header->customer_id == "" ? '' : Customer::model()->findByPk($consignmentOut->header->customer_id)->name
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
                            'pager' => array(
                                'cssFile' => false,
                                'header' => '',
                            ),
                            'selectionChanged' => 'js:function(id){
                                $("#ConsignmentOutHeader_customer_id").val($.fn.yiiGridView.getSelection(id));
                                $("#customer-dialog").dialog("close");
                                $.ajax({
                                    type: "POST",
                                    dataType: "JSON",
                                    url: "' . CController::createUrl('ajaxCustomer', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
                                    data: $("form").serialize(),
                                    success: function(data) {
                                        $("#ConsignmentOutHeader_customer_name").val(data.name);		                        	
                                    },
                                });
                                $("#customer-grid").find("tr.selected").each(function(){
                                    $(this).removeClass( "selected" );
                                });
                            }',
                            'columns' => array('name')
                        )); ?>
                        <?php $this->endWidget(); ?>
                        <?php echo $form->error($consignmentOut->header, 'customer_id'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="large-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($consignmentOut->header, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php
                        if ($consignmentOut->header->isNewRecord) {
                            echo $form->textField($consignmentOut->header, 'status', array('value' => 'Draft', 'readonly' => true));
                        } else {
                            echo $form->dropDownList($consignmentOut->header, 'status', array('Draft' => 'Draft', 'Revised' => 'Revised', 'Rejected' => 'Rejected', 'Approved' => 'Approved', 'Done' => 'Done'), array('prompt' => '[--Select status Document--]'));
                        }
                        ?>
                        <?php echo $form->error($consignmentOut->header, 'status'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="large-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($consignmentOut->header, 'delivery_date', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo $form->textField($consignmentOut->header,'delivery_date'); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $consignmentOut->header,
                            'attribute' => "delivery_date",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
//                                'yearRange' => '1900:2020'
                            ),
                            'htmlOptions' => array(
                                'value' => date('Y-m-d'),
                            ),
                        )); ?>
                        <?php echo $form->error($consignmentOut->header, 'delivery_date'); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="large-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($consignmentOut->header, 'periodic', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-7 columns">
                        <?php echo $form->textField($consignmentOut->header, 'periodic'); ?>
                        <?php echo $form->error($consignmentOut->header, 'periodic'); ?>
                    </div>
                    <div class="small-1 columns">
                        <label class="postfix" >days</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="large-6 columns">
            <div class="row collapse prefix-radius">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($consignmentOut->header, 'total_price', array('class' => 'prefix')); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->hiddenField($consignmentOut->header, 'total_price', array('size' => 18, 'maxlength' => 18, 'readonly' => true)); ?>
                    <?php echo $form->textField($consignmentOut->header, 'total_price', array('id' => 'consignment_out_total_price_view', 'name' => 'view', 'readonly' => true, 'value' => $this->format_money($consignmentOut->header->total_price))); ?>
                    <?php echo $form->error($consignmentOut->header, 'total_price'); ?>
                </div>
            </div>
        </div>

        <div class="large-6 columns">
            <div class="row collapse prefix-radius">
                <div class="small-4 columns">
                    <?php echo $form->labelEx($consignmentOut->header, 'total_quantity', array('class' => 'prefix')); ?>
                </div>
                <div class="small-8 columns">
                    <?php echo $form->textField($consignmentOut->header, 'total_quantity', array('readonly' => true)); ?>
                    <?php echo $form->error($consignmentOut->header, 'total_quantity'); ?>
                </div>
            </div>
        </div>

    </div>

    <fieldset>
        <legend>Detail Product</legend>
        <div class="row">
            <div class="large-5 columns">
                <div class="small-4 columns">
                    <?php echo CHtml::button('Add Details', array(
                        'id' => 'detail-button',
                        'name' => 'Detail',
                        'style' => 'width:100%',
                        'onclick' => '
                            $("#product-dialog").dialog("open"); return false;
                            jQuery.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $consignmentOut->header->id)) . '",
                                data: jQuery("form").serialize(),
                                success: function(html) {
                                    jQuery("#product").html(html);
                                },
                            });
                        '
                    )); ?>
                </div>
                
                <div class="small-4 columns">
                    <?php echo CHtml::button('Add New Product', array(
                        'id' => 'detail-button',
                        'name' => 'Detail',
                        'style' => 'width:100%',
                        //'target'=>'_blank',
                        'onclick' => ' 
                            window.location.href = "' . Yii::app()->baseUrl . '/master/product/create/"
                        ',
                    )); ?>
                </div>
                <div class="small-4 columns">
                    <?php echo CHtml::button('Count Total', array(
                        'id' => 'total-button',
                        'name' => 'Total',
                        'style' => 'width:100%',
                        'onclick' => '
                            $.ajax({
                                type: "POST",
                                url: "' . CController::createUrl('ajaxGetTotal', array('id' => $consignmentOut->header->id,)) . '",
                                data: $("form").serialize(),
                                dataType: "json",
                                success: function(data) {
                                    //console.log(data.total);
                                    //console.log(data.requestType);
                                    $("#ConsignmentOutHeader_total_price").val(data.total);
                                    $("#consignment_out_total_price_view").val(data.total.toLocaleString(\'id\', {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                                    $("#ConsignmentOutHeader_total_quantity").val(data.total_items);
                                },
                            });',
                    )); ?>
                </div>
            </div>
        </div>

        <br />
        
        <div class="row">
            <div class="large-12 columns">
                <div class="detail" id="product">
                    <?php $this->renderPartial('_detail', array(
                        'consignmentOut' => $consignmentOut,
                        'product' => $product,
                        'productDataProvider' => $productDataProvider,
                    )); ?>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton($consignmentOut->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
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
                    <td>ID</td>
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
                        <?php echo CHtml::activeTextField($product, 'id', array(
                            'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                brand_id: $("#Product_brand_id").val(),
                                sub_brand_id: $("#Product_sub_brand_id").val(),
                                sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                product_master_category_id: $("#Product_product_master_category_id").val(),
                                product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                manufacturer_code: $("#Product_manufacturer_code").val(),
                                name: $("#Product_name").val(),
                                id: $(this).val(),
                            } } });',
                        )); ?>
                    </td>
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
                                    id: $("#Product_id").val(),
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
                                    id: $("#Product_id").val(),
                                } } });',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array(
                            'empty' => '-- All --',
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
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <div id="product_sub_brand">
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_stock_table',
                                )),
                            )); ?>
                        </div>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                                id: $("#Product_id").val(),
                            } } });',
                        )); ?>
                    </td>
                    <td>
                        <div id="product_sub_master_category">
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
            'filter' => $product,
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
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $consignmentOut->header->id, 'productId' => '')) . '" + $.fn.yiiGridView.getSelection(id),
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
                'id',
                array('name' => 'name', 'value' => '$data->name'),
                'manufacturer_code',
                array(
                    'name'=>'product_brand_name', 
                    'value'=>'empty($data->brand_id) ? "" : $data->brand->name'
                ),
                array(
                    'header' => 'Sub Brand', 
                    'name' => 'product_sub_brand_name', 
                    'value' => 'empty($data->sub_brand_id) ? "" : $data->subBrand->name'
                ),
                array(
                    'header' => 'Sub Brand Series', 
                    'name' => 'product_sub_brand_series_name', 
                    'value' => 'empty($data->sub_brand_series_id) ? "" : $data->subBrandSeries->name'
                ),
                'masterSubCategoryCode: Kategori',
                array(
                    'name'=>'unit_id', 
                    'value'=>'empty($data->unit_id) ? "" : $data->unit->name'
                ),
                array('name' => 'product_supplier', 'value' => '$data->product_supplier'),
            ),
        )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php Yii::app()->clientScript->registerScript('search', "
    $('#Product_findkeyword').keypress(function(e) {
        if(e.which == 13) {
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