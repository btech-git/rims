<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs = array(
    'Product' => array('admin'),
    'Products' => array('admin'),
    'Manage Products',
);

$this->menu = array(
    array('label' => 'List Product', 'url' => array('index')),
    array('label' => 'Create Product', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
//$('#advsearch').click(function(){
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
        
	if ($(this).hasClass('active')) {
            $(this).text('');
            $('#Product_findkeyword').hide();
	} else {
            $('#Product_findkeyword').show();
            $(this).text('Advanced Search');
	}
        
	return false;
});

/*$('.search-form form').submit(function(){
    $('#product-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
*/

$('form').submit(function(){
   $.fn.yiiGridView.update('product-grid', {
        data: $(this).serialize()
    });
    
    return false;
});

");
?>
    <!-- BEGIN maincontent -->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterProductCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/product/create'; ?>"><span class="fa fa-plus"></span>New Product</a>
            <a style="margin-right: 10px;padding: 7px;" class="button info right" href="<?php echo Yii::app()->baseUrl . '/master/product/upload'; ?>"><span class="fa fa-plus"></span>Upload Product</a>
        <?php } ?>
        <h1>Manage Product</h1>

        <!-- BEGIN aSearch -->
        <div class="search-bar">
            <div class="clearfix button-bar">
                <div class="row">
                    <div class="medium-12 columns">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                        )); ?>
                        <div class="medium-3 columns">
                            <?php echo CHtml::activeTextField($model, 'id', array('placeholder' => 'ID', "style" => "margin-bottom:0px;")); ?>
                        </div>
                        
                        <div class="medium-3 columns">
                            <?php echo CHtml::activeTextField($model, 'manufacturer_code', array('placeholder' => 'Code', "style" => "margin-bottom:0px;")); ?>
                        </div>
                        
                        <div class="medium-6 columns">
                            <?php echo CHtml::activeTextField($model, 'name', array('placeholder' => 'Name', "style" => "margin-bottom:0px;")); ?>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="medium-12 columns">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                        )); ?>
                        <?php echo CHtml::beginForm(); ?>
                        <div class="medium-2 columns">
                            <?php echo CHtml::activeDropDownList($model, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All Brand --',
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
                        </div>
                        
                        <div class="medium-2 columns" id="product_sub_brand">
                            <?php echo CHtml::activeDropDownList($model, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All Sub Brand --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSeriesSelect'),
                                    'update' => '#product_sub_brand_series',
                                )),
                            )); ?>
                        </div>
                        
                        <div class="medium-2 columns" id="product_sub_brand_series">
                            <?php echo CHtml::activeDropDownList($model, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All Sub Brand Series --',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_stock_table',
                                )),
                            )); ?>
                        </div>
                        
                        <div class="medium-2 columns">
                            <?php echo CHtml::activeDropDownList($model, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All Master Category --',
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
                        </div>
                        
                        <div class="medium-2 columns" id="product_sub_master_category">
                            <?php echo CHtml::activeDropDownList($model, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All Sub Master Category--',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubCategorySelect'),
                                    'update' => '#product_sub_category',
                                )),
                            )); ?>
                        </div>
                        
                        <div class="medium-2 columns" id="product_sub_category">
                            <?php echo CHtml::activeDropDownList($model, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All Sub Category--',
                                'order' => 'name',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_stock_table',
                                )),
                            )); ?>
                        </div>
                        
                        <?php echo CHtml::endForm(); ?>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="search-form" style="display:none">
                <?php /*$this->renderPartial('_search',array(
                        'model'=>$model,
                    )); */ ?>
            </div><!-- search-form -->
        </div>
    </div>
    <!-- END aSearch -->


    <!-- BEGIN gridview -->
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'product-grid',
            'dataProvider' => $model->search(),
            'filter' => null,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'afterAjaxUpdate' => 'function(id, data){
                var textbold = $("#Product_findkeyword").val();
                var j = jQuery.noConflict();
                j("td").mark(textbold, {
                    "className": "higlig"
                });
            }',
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '2',
                    'header' => 'Selected',
                    'value' => '$data->id',
                ),
                'id',
                'manufacturer_code',
                array(
                    'name' => 'name',
                    'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))',
                    'type' => 'raw'
                ),
                array(
                    'name' => 'brand_id',
                    'value' => '$data->brand ? $data->brand->name : \'\'',
                ),
                array(
                    'name' => 'sub_brand_id',
                    'value' => '$data->subBrand ? $data->subBrand->name : \'\'',
                    'filter' => false,
                ),
                array(
                    'name' => 'sub_brand_series_id',
                    'value' => '$data->subBrandSeries ? $data->subBrandSeries->name : \'\'',
                    'filter' => false,
                ),
                array(
                    'header' => 'Master Category',
                    'value' => '$data->productMasterCategory->name',
                    'filter' => false,
                ),
                array(
                    'header' => 'Sub Master Category',
                    'value' => '$data->productSubMasterCategory->name',
                    'filter' => false,
                ),
                array(
                    'header' => 'Sub Category',
                    'value' => '$data->productSubCategory->name',
                    'filter' => false,
                ),
                'date_posting',
                array('name'=>'user_id', 'value'=>'$data->user->username'),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{price} {edit}',
                    'buttons' => array (
                        'price' => array (
                            'label' => 'price',
                            'url' => 'Yii::app()->createUrl("master/product/ajaxHtmlPrice", array("id"=>$data->id))',
                            'options' => array(
                                'ajax' => array(
                                    'type' => 'POST',
                                    // ajax post will use 'url' specified above
                                    'url' => 'js: $(this).attr("href")',
                                    'success' => 'function(html) {
                                        $("#price_div").html(html);
                                        $("#price-dialog").dialog("open");
                                    }',
                                ),
                            ),
                        ),
                        'edit' => array (
                            'label' => 'edit',
                            'url' => 'Yii::app()->createUrl("master/product/update", array("id"=>$data->id))',
                        ),

                    ),
                ),
            ),
        )); ?>
    </div>
    <!-- END gridview -->
</div>

    <!--Price Dialog -->
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'price-dialog',
    'options' => array(
        'title' => 'Price List',
        'autoOpen' => false,
        'modal' => true,
        'width' => '480',
    ),
)); ?>

<div id="price_div"></div>

<?php $this->endWidget(); ?>

<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.mark.min.js',
    CClientScript::POS_HEAD, array('charset' => 'UTF-8'));
    Yii::app()->clientScript->registerScript('search', "

    	$('#Product_findkeyword').keypress(function(e) {
            if (e.which == 13) {
                $.fn.yiiGridView.update('product-grid', {
                        data: $(this).serialize()
                });
                return false;
            }
        });

        $('#Product_product_master_category_id, #Product_product_sub_master_category_id,#Product_product_sub_category_id,#Product_brand_id,#Product_sub_brand_id,#Product_sub_brand_series_id,#Product_name,#Product_manufacturer_code,#Product_id').change(function(){
            $.fn.yiiGridView.update('product-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>