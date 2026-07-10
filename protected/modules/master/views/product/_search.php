<?php
/* @var $this ProductController */
/* @var $model Product */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    )); ?>
    
    <div class="row">
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model, 'id', array('placeholder' => 'ID', "style" => "margin-bottom:0px;")); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'name', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model, 'name', array('placeholder' => 'Name', "style" => "margin-bottom:0px;")); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'brand_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
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
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'sub_brand_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns" id="product_sub_brand">
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
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'sub_brand_series_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns" id="product_sub_brand_series">
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
                </div>
            </div>
        </div>

        <div class="small-12 medium-6 columns">	
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'manufacturer_code', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($model, 'manufacturer_code', array('placeholder' => 'Code', "style" => "margin-bottom:0px;")); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'product_master_category_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
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
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'product_sub_master_category_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns" id="product_sub_master_category">
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
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'product_sub_category_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns" id="product_sub_category">
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
                </div>
            </div>

            <div class="field buttons text-right">
                <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
            </div>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->