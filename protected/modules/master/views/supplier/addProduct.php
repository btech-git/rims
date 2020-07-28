<?php $this->breadcrumbs=array(
 	'Suppliers'=>array('admin'),
	'Create',
); ?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>
	<div class="row">
        <?php //echo $form->errorSummary($model); ?>
        <div id="maincontent">
            <h2>Supplier</h2>
            <div id="supplier">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Company</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($supplier->header, 'name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($supplier->header, 'company')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($supplier->header, 'description')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h2>Product</h2>
            <?php echo CHtml::button('Cari Product', array(
                'id' => 'btn_product',
                'name' => 'Search',
                'onclick' => '$("#product-dialog").dialog("open"); return false;',
                'onkeypress' => 'if (event.keyCode == 13) { $("#search-dialog").dialog("open"); return false; }'
            )); ?>
            <?php echo CHtml::hiddenField('ProductId'); ?>
            
            <br /><br />
            
            <div id="detail_div">
                <?php $this->renderPartial('_detailProduct', array(
                    'supplier' => $supplier,
                )); ?>
            </div>
        </div>
    </div>
    
    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'class'=>'button alert', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Save', array('name' => 'Submit', 'class'=>'button primary', 'confirm' => 'Are you sure you want to save?')); ?>
	</div>

    <?php echo CHtml::endForm(); ?>
</div>

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

<?php echo CHtml::beginForm('', 'post'); ?>
<table>
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Brand</th>
            <th>Sub Brand</th>
            <th>Sub Brand Series</th>
            <th>Master Kategori</th>
            <th>Sub Master Kategori</th>
            <th>Sub Kategori</th>
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
                <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
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
                    } } });',
                )); ?>
            </td>
            <td>
                <div id="product_sub_brand">
                    <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name')), 'id', 'name'), array(
                        'empty' => '-- All --',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                            'update' => '#product_sub_brand_series',
                        )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                            brand_id: $("#Product_brand_id").val(),
                            sub_brand_id: $(this).val(),
                            sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                            product_master_category_id: $("#Product_product_master_category_id").val(),
                            product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                            product_sub_category_id: $("#Product_product_sub_category_id").val(),
                            manufacturer_code: $("#Product_manufacturer_code").val(),
                            name: $("#Product_name").val(),
                        } } });',
                    )); ?>
                </div>
            </td>
            <td>
                <div id="product_sub_brand_series">
                    <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                        'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                            brand_id: $("#Product_brand_id").val(),
                            sub_brand_id: $("#Product_sub_brand_id").val(),
                            sub_brand_series_id: $(this).val(),
                            product_master_category_id: $("#Product_product_master_category_id").val(),
                            product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                            product_sub_category_id: $("#Product_product_sub_category_id").val(),
                            manufacturer_code: $("#Product_manufacturer_code").val(),
                            name: $("#Product_name").val(),
                        } } });',
                    )); ?>
                </div>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
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
                    <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                            'update' => '#product_sub_category',
                        )) . '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                            brand_id: $("#Product_brand_id").val(),
                            sub_brand_id: $("#Product_sub_brand_id").val(),
                            sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                            product_master_category_id: $("#Product_product_master_category_id").val(),
                            product_sub_master_category_id: $(this).val(),
                            product_sub_category_id: $("#Product_product_sub_category_id").val(),
                            manufacturer_code: $("#Product_manufacturer_code").val(),
                            name: $("#Product_name").val(),
                        } } });',
                    )); ?>
                </div>
            </td>
            <td>
                <div id="product_sub_category">
                    <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --',
                        'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                            brand_id: $("#Product_brand_id").val(),
                            sub_brand_id: $("#Product_sub_brand_id").val(),
                            sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                            product_master_category_id: $("#Product_product_master_category_id").val(),
                            product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                            product_sub_category_id: $(this).val(),
                            manufacturer_code: $("#Product_manufacturer_code").val(),
                            name: $("#Product_name").val(),
                        } } });',
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
    'pager'=>array(
       'cssFile'=>false,
       'header'=>'',
    ),
    'columns' => array(
        array(
            'id' => 'selectedIds',
            'class' => 'CCheckBoxColumn',
            'selectableRows' => '50',
        ),
        'manufacturer_code',
        'name',
        array(
            'name'=>'brand_id', 
            'value'=>'$data->brand->name',
        ),
        array(
            'name'=>'sub_brand_id', 
            'value'=>'$data->subBrand->name',
        ),
        array(
            'name'=>'sub_brand_series_id', 
            'value'=>'$data->subBrandSeries->name',
        ),
        array(
            'name'=>'product_master_category_name', 
            'header' => 'Master Category',
            'value'=>'$data->productMasterCategory->name'
        ),
        array(
            'name'=>'product_sub_master_category_name', 
            'header' => 'Sub Master Category',
            'value'=>'$data->productSubMasterCategory->name'
        ),
        array(
            'name'=>'product_sub_category_name', 
            'header' => 'Sub Category',
            'value'=>'$data->productSubCategory->name'
        ),
    ),
)); ?>

<?php echo CHtml::ajaxSubmitButton('Add Product', CController::createUrl('ajaxHtmlAddProducts', array('id' => $supplier->header->id)), array(
    'type' => 'POST',
    'data' => 'js:$("form").serialize()',
    'success' => 'js:function(html) {
        $("#detail_div").html(html);
        $("#product-dialog").dialog("close");
    }'
)); ?>

<?php echo CHtml::endForm(); ?>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>