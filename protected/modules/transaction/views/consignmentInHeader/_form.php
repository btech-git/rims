<?php
/* @var $this ConsignmentInHeaderController */
/* @var $consignmentIn ->header ConsignmentInHeader */
/* @var $form CActiveForm */
?>
    <div class="clearfix page-action">
        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage Consignment In',
            Yii::app()->baseUrl . '/transaction/consignmentInHeader/admin', array(
                'class' => 'button cbutton right',
                'visible' => Yii::app()->user->checkAccess("transaction.consignmentInHeader.admin")
            )) ?>
        <h1><?php if ($consignmentIn->header->id == "") {
                echo "New Consignment In";
            } else {
                echo "Update Consignment In";
            } ?></h1>
        <!-- begin FORM -->
        <div class="form">
            <?php $form = $this->beginWidget('CActiveForm', array(
                'id' => 'consignment-in-header-form',
                'enableAjaxValidation' => false,
            )); ?>
            <?php //Yii::app()->clientScript->registerCoreScript('jquery'); ?>
            <?php //Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
            <p class="note">Fields with <span class="required">*</span> are required.</p>

            <?php echo $form->errorSummary($consignmentIn->header); ?>

            <div class="row">
                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'consignment_in_number',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($consignmentIn->header, 'consignment_in_number',
                                array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>
                            <?php echo $form->error($consignmentIn->header, 'consignment_in_number'); ?>
                        </div>
                    </div>
                </div>

                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'receive_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->hiddenField($consignmentIn->header, 'receive_id', array(
                                'size' => 30,
                                'maxlength' => 30,
                                'value' => $consignmentIn->header->isNewRecord ? Yii::app()->user->getId() : $consignmentIn->header->receive_id,
                                'readonly' => true
                            )); ?>
                            <?php echo $consignmentIn->header->isNewRecord ? Yii::app()->user->getName() : CHtml::encode(CHtml::value($consignmentIn->header, 'user.username')); ?>
                            <?php echo $form->error($consignmentIn->header, 'receive_id'); ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'date_posting',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo $form->textField($consignmentIn->header,'date_posting',array('value' => date('Y-m-d'), 'readonly' => true,)); ?>
                            <?php /*$this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $consignmentIn->header,
                                'attribute' => "date_posting",
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => date('Y-m-d'),
                                    //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                ),
                            ));*/ ?>
                            <?php echo $form->error($consignmentIn->header, 'date_posting'); ?>
                        </div>
                    </div>
                </div>

                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'receive_branch',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php //echo $form->textField($consignmentIn->header,'receive_branch',array('size'=>30,'maxlength'=>30)); ?>
                            <?php echo $form->dropDownlist($consignmentIn->header, 'receive_branch',
                                CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'),
                                array('prompt' => '[--Select Branch--]')); ?>
                            <?php echo $form->error($consignmentIn->header, 'receive_branch'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'status_document',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php if ($consignmentIn->header->isNewRecord) {
                                echo $form->textField($consignmentIn->header, 'status_document',
                                    array('value' => 'Draft', 'readonly' => true));
                            } else {
                                echo $form->dropDownList($consignmentIn->header, 'status_document', array(
                                    'Draft' => 'Draft',
                                    'Revised' => 'Revised',
                                    'Rejected' => 'Rejected',
                                    'Approved' => 'Approved',
                                    'Done' => 'Done'
                                ), array('prompt' => '[--Select Status Document--]'));
                            }
                            ?>
                            <?php echo $form->error($consignmentIn->header, 'status_document'); ?>
                        </div>
                    </div>
                </div>
                
                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'supplier_id',
                                array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-2 columns">
                            <a class="button expand"
                               href="<?php echo Yii::app()->baseUrl . '/master/supplier/create'; ?>"><span
                                        class="fa fa-plus"></span>Add</a>
                        </div>
                        <div class="small-6 columns">
                            <?php echo CHtml::activeHiddenField($consignmentIn->header, 'supplier_id'); ?>
                            <?php echo CHtml::activeTextField($consignmentIn->header, 'supplier_name', array(
                                'size' => 15,
                                'maxlength' => 10,
                                'readonly' => true,
                                //'disabled'=>true,
                                'onclick' => '$("#supplier-dialog").dialog("open"); return false;',
                                'onkeypress' => 'if (event.keyCode == 13) { $("#supplier-dialog").dialog("open"); return false; }',
                                'value' => $consignmentIn->header->supplier_id == "" ? '' : Supplier::model()->findByPk($consignmentIn->header->supplier_id)->name
                            )); ?>
                            <?php echo $form->error($consignmentIn->header, 'supplier_id'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="large-6 columns">
                    <div class="row collapse prefix-radius">
                        <div class="small-4 columns">
                            <?php echo $form->labelEx($consignmentIn->header, 'date_arrival', array('class' => 'prefix')); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                'model' => $consignmentIn->header,
                                'attribute' => "date_arrival",
                                'options' => array(
                                    'dateFormat' => 'yy-mm-dd',
                                    'changeMonth' => true,
                                    'changeYear' => true,
                                    'yearRange' => '1900:2020'
                                ),
                                'htmlOptions' => array(
                                    'value' => date('Y-m-d'),
                                ),
                            )); ?>
                            <?php echo $form->error($consignmentIn->header, 'date_arrival'); ?>
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

                                'onclick' => '$("#product-dialog").dialog("open"); return false;
                                jQuery.ajax({
                                    type: "POST",
                                    url: "' . CController::createUrl('ajaxHtmlAddDetail',
                                        array('id' => $consignmentIn->header->id)) . '",
                                    data: jQuery("form").serialize(),
                                    success: function(html) {
                                        jQuery("#product").html(html);
                                    },
                                });'
                            )); ?>
                        </div>
                        <div class="small-4 columns">

                            <?php echo CHtml::button('Add New Product', array(
                                'id' => 'detail-button',
                                'name' => 'Detail',
                                'style' => 'width:100%',
                                //'target'=>'_blank',
                                'onclick' => 'window.location.href = "' . Yii::app()->baseUrl . '/master/product/create/"',
                            )); ?>
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="detail" id="product">
                            <?php $this->renderPartial('_detail', array(
                                'consignmentIn' => $consignmentIn,
                                'product' => $product,
                                'productDataProvider' => $productDataProvider,
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </fieldset>


            <div class="row buttons text-center">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($consignmentIn->header->isNewRecord ? 'Create' : 'Save',
                    array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>


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
    // 'dataProvider'=>$supplierDataProvider,
    'dataProvider' => $supplier->search(),
    'filter' => $supplier,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'selectionChanged' => 'js:function(id){
		$("#ConsignmentInHeader_supplier_id").val($.fn.yiiGridView.getSelection(id));
		$("#supplier-dialog").dialog("close");
		$.ajax({
			type: "POST",
			dataType: "JSON",
			url: "' . CController::createUrl('ajaxSupplier', array('id' => '')) . '" + $.fn.yiiGridView.getSelection(id),
			data: $("form").serialize(),
			success: function(data) {
				$("#ConsignmentInHeader_supplier_name").val(data.name);	
				$.updateGridView("product-grid", "Product[product_supplier]", data.name);      	                        	
				                      	
			},
		});
	}',
    'columns' => array(
        'id',
        'name',
        // array('name'=>'product_name','value'=>'$data->product_name'),
    )
)); ?>
<?php $this->endWidget(); ?>
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Product',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
));
?>
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
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array('empty' => '-- All --',
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
				url: "' . CController::createUrl('ajaxHtmlAddDetail',
                        array('id' => $consignmentIn->header->id, 'productId' => '')) . '" + $.fn.yiiGridView.getSelection(id),
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
                    array('name' => 'product_supplier', 'value' => '$data->product_supplier'),
                ),
            )); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
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