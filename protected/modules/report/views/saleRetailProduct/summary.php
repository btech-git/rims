<?php
Yii::app()->clientScript->registerScript('report', '
    $("#StartDate").val("' . $startDate . '");
    $("#EndDate").val("' . $endDate . '");
    $("#PageSize").val("' . $saleRetailProductSummary->dataProvider->pagination->pageSize . '");
    $("#CurrentPage").val("' . ($saleRetailProductSummary->dataProvider->pagination->getCurrentPage(false) + 1) . '");
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
                                        <span class="prefix">Jumlah per Halaman</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('PageSize', '', array('size' => 3)); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Halaman saat ini</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::textField('page', '', array('size' => 3, 'id' => 'CurrentPage')); ?>
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
                                        <span class="prefix">Product</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($product, 'id', array(
                                            'readonly' => true,
                                            'onclick' => '$("#product-dialog").dialog("open"); return false;',
                                            'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }',
                                        )); ?>

                                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                            'id' => 'product-dialog',
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
                                                                    'onchange' => '
                                                                    $.fn.yiiGridView.update("product-grid", {data: {Product: {
                                                                        product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                                                        brand_id: $("#Product_brand_id").val(),
                                                                        sub_brand_id: $("#Product_sub_brand_id").val(),
                                                                        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                                                        product_master_category_id: $("#Product_product_master_category_id").val(),
                                                                        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                                                        product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                                                        id: $(this).val(),
                                                                        name: $("#Product_name").val(),
                                                                        manufacturer_code: $("#Product_manufacturer_code").val(),
                                                                    } } });',
                                                                )); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                                                                    'onchange' => '
                                                                    $.fn.yiiGridView.update("product-grid", {data: {Product: {
                                                                        product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
                                                                        brand_id: $("#Product_brand_id").val(),
                                                                        sub_brand_id: $("#Product_sub_brand_id").val(),
                                                                        sub_brand_series_id: $("#Product_sub_brand_series_id").val(),
                                                                        product_master_category_id: $("#Product_product_master_category_id").val(),
                                                                        product_sub_master_category_id: $("#Product_product_sub_master_category_id").val(),
                                                                        product_sub_category_id: $("#Product_product_sub_category_id").val(),
                                                                        manufacturer_code: $(this).val(),
                                                                        id: $("#Product_id").val(),
                                                                        name: $("#Product_name").val(),
                                                                    } } });',
                                                                )); ?>
                                                            </td>
                                                            <td>
                                                                <?php echo CHtml::activeTextField($product, 'name', array(
                                                                    'onchange' => '$.fn.yiiGridView.update("product-grid", {data: {Product: {
                                                                        product_supplier: [$("#TransactionPurchaseOrder_supplier_id").val()],
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
                                                                        id: $("#Product_id").val(),
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
                                                                        id: $("#Product_id").val(),
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
                                                                    )); ?>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?php $this->widget('zii.widgets.grid.CGridView', array(
                                                    'id'=>'product-grid',
                                                    'dataProvider'=>$productDataProvider,
                                                    'filter'=>null,
                                                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                                    'pager'=>array(
                                                        'cssFile'=>false,
                                                        'header'=>'',
                                                    ),
                                                    'selectionChanged'=>'js:function(id){
                                                        $("#' . CHtml::activeId($product, 'id') . '").val($.fn.yiiGridView.getSelection(id));
                                                        $("#product-dialog").dialog("close");
                                                        if ($.fn.yiiGridView.getSelection(id) == "") {
                                                            $("#product_name").html("");
                                                        } else {
                                                            $.ajax({
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                url: "' . CController::createUrl('ajaxJsonProduct') . '",
                                                                data: $("form").serialize(),
                                                                success: function(data) {
                                                                    $("#product_name").html(data.product_name);
                                                                },
                                                            });
                                                        }
                                                    }',
                                                    'columns'=>array(
                                                        'id',
                                                        'manufacturer_code',
                                                        'name',
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
                                                    ),
                                                )); ?>
                                            </div>
                                        </div>
                                        <?php echo CHtml::endForm(); ?>
                                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

                                        <?php echo CHtml::openTag('span', array('id' => 'product_name')); ?>
                                        <?php echo CHtml::encode(CHtml::value($product, 'name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?> 

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
<!--                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Type</span>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php //echo CHtml::activeDropDownlist($customer, 'customer_type', array('Individual' => 'Individual', 'Company' => 'Company'), array('empty' => '-- All Type --')); ?>
                                    </div>
                                </div>
                            </div>-->
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
                        'saleRetailProductSummary' => $saleRetailProductSummary,
                        'product' => $product,
                        'startDate' => $startDate,
                        'endDate' => $endDate,
                    )); ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
            
<br/>

<div class="right">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $saleRetailProductSummary->dataProvider->pagination->itemCount,
        'pageSize' => $saleRetailProductSummary->dataProvider->pagination->pageSize,
        'currentPage' => $saleRetailProductSummary->dataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>
<div class="clear"></div>