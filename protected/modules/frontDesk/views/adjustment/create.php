<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Penyesuaian Stok Barang</h1>
        <div class="form">
            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::errorSummary($adjustment->header); ?>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">		
                                    <?php echo CHtml::label('Tanggal', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $adjustment->header,
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
                                    <?php //echo CHtml::activeHiddenField($adjustment->header, 'date_posting'); ?>
                                    <?php //echo CHtml::encode($adjustment->header->date_posting); ?>
                                    <?php echo CHtml::error($adjustment->header, 'date_posting'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">		
                                    <?php echo CHtml::label('Tipe', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($adjustment->header, 'transaction_type', array(
                                        'Selisih Cabang' => 'Selisih Cabang',
                                        'Hilang' => 'Hilang / Lebih',
                                    ), array(
                                        'empty' => '-- Pilih Tipe --',
                                        'onchange' => '
                                            $("#' . CHtml::activeId($adjustment->header, 'branch_id') . '").val("");
                                            $("#' . CHtml::activeId($adjustment->header, 'branch_id_destination') . '").val("");
                                            $("#adjustment-detail-table tbody").empty();
                                            if ($(this).val() === "Selisih Cabang") {
                                                $("#branch-id-destination-div").show();
                                                $(".adjustment-detail-table-branch-destination-header").show();
                                                $(".adjustment-detail-table-branch-destination-body").show();
                                            } else {
                                                $("#branch-id-destination-div").hide();
                                                $(".adjustment-detail-table-branch-destination-header").hide();
                                                $(".adjustment-detail-table-branch-destination-body").hide();
                                            }
                                        ',
                                    )); ?>
                                    <?php echo CHtml::error($adjustment->header, 'transaction_type'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">		
                                    <?php echo CHtml::label('Cabang', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($adjustment->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- Pilih Branch --',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'POST',
                                            'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id' => $adjustment->header->id)),
                                            'update' => '#detail_div',
                                        )),
                                    )); ?>
                                    <?php echo CHtml::error($adjustment->header, 'branch_id'); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field" id="branch-id-destination-div" style="display: none">
                            <div class="row collapse">
                                <div class="small-4 columns">		
                                    <?php echo CHtml::label('Cabang Tujuan', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeDropDownList($adjustment->header, 'branch_id_destination', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                                        'empty' => '-- Pilih Branch Tujuan --',
                                        'onchange' => CHtml::ajax(array(
                                            'type' => 'POST',
                                            'url' => CController::createUrl('ajaxHtmlUpdateAllProduct', array('id' => $adjustment->header->id)),
                                            'update' => '#detail_div',
                                        )),
                                    )); ?>
                                    <?php echo CHtml::error($adjustment->header, 'branch_id_destination'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo CHtml::label('User', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($adjustment->header, 'user.username')); ?>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo CHtml::label('Status', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::encode(CHtml::value($adjustment->header, 'status')); ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <?php echo CHtml::label('Catatan', ''); ?>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo CHtml::activeTextArea($adjustment->header, 'note', array('rows' => 5, 'cols' => 30)); ?>
                                    <?php echo CHtml::error($adjustment->header, 'note'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="small-12 columns">
                    <fieldset>
                        <legend>Detail</legend>

                        <div class="row">
                            <div class="small-3 columns">
                                <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
                                <?php echo CHtml::hiddenField('ProductId'); ?>
                            </div>
                        </div>
                        
                        <br />
                        
                        <div class="row">
                            <div class="small-12 columns">
                                <div style="max-width: 130em; width: 100%;">
                                    <div style="overflow-y: hidden; margin-bottom: 1.25rem;" id="detail_div">
                                        <?php $this->renderPartial('_detail', array('adjustment' => $adjustment)); ?>
                                    </div>
                                </div>						
                            </div>
                        </div>
                    </fieldset>

                    <div class="buttons">
                        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class' => 'btn_blue')); ?>
                        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
                    </div>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
            <?php echo CHtml::endForm(); ?>
        </div><!-- form -->
    </div>
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
            'filter' => null,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'selectionChanged' => 'js:function(id) {
                $("#ProductId").val($.fn.yiiGridView.getSelection(id));
                $("#product-dialog").dialog("close");
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $adjustment->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { $("#detail_div").html(html); },
                });
            }',
            'columns' => array(
                'id',
                'name',
                'manufacturer_code',
                array(
                    'name' => 'unit_id',
                    'value' => '$data->unit->name'
                ),
                array(
                    'header' => 'Kategori',
                    'value' => '$data->masterSubCategoryCode'
                ),
                array(
                    'name' => 'product_brand_name',
                    'header' => 'Brand',
                    'value' => 'empty($data->brand) ? "" : $data->brand->name'
                ),
                array(
                    'name' => 'product_sub_brand_name',
                    'header' => 'Sub Brand',
                    'value' => 'empty($data->subBrand) ? "" : $data->subBrand->name'
                ),
                array(
                    'name' => 'product_sub_brand_series_name',
                    'header' => 'Sub Brand Series',
                    'value' => 'empty($data->subBrandSeries) ? "" : $data->subBrandSeries->name'
                ),
            ),
        )); ?>
    </div>
</div>
<?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>