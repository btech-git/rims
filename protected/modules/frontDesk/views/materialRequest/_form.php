<script type="text/javascript">
    $(document).ready(function () {
        $('.dateClass').live("keyup", function (e) {
            var Length=$(this).attr("maxlength");

            if ($(this).val().length >= parseInt(Length)){
                $(this).next('.dateClass').focus();
            }
        });
    }
</script>

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">

            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::errorSummary($materialRequest->header); ?>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Request Tanggal', ''); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $materialRequest->header,
                                            'attribute' => "transaction_date",
                                            'options' => array(
                                                'minDate' => '-1W',
                                                'maxDate' => '+6M',
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
//                                                'value' => date('Y-m-d'),
                                            ),
                                        )); ?>
                                        <?php echo CHtml::error($materialRequest->header, 'transaction_date'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if ($materialRequest->header->isNewRecord): ?>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <label class="prefix"><?php echo 'Work Order'; ?></label>
                                        </div>
                                        <div class="small-8 columns">
                                            <?php echo CHtml::activeTextField($materialRequest->header, 'registration_transaction_id', array(
                                                'size' => 15,
                                                'maxlength' => 10,
                                                'readonly' => true,
                                                'onclick' => '$("#registration-dialog").dialog("open"); return false;',
                                                'onkeypress' => 'if (event.keyCode == 13) { $("#registration-dialog").dialog("open"); return false; }',
                                            )); ?>
                                            <?php echo CHtml::error($materialRequest->header, 'registration_transaction_id'); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Branch'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'branch.name')); ?>
                                        <?php echo CHtml::error($materialRequest->header,'branch_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('User', ''); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode($materialRequest->header->user->username); ?>
                                        <?php echo CHtml::error($materialRequest->header,'user_id'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Note', ''); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($materialRequest->header, 'note', array('rows' => 5, 'columns' => '10')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'WO #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'work_order_number')); ?>
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.work_order_number')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Tanggal WO'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'work_order_date')); ?>
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.transaction_date')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Repair Type'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'work_order_type')); ?>
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.repair_type')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Customer'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'work_order_customer')); ?>
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.customer.name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Plate #'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'work_order_plate')); ?>
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.vehicle.plate_number')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Vehicle'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'work_order_vehicle')); ?>
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.vehicle.carMake.name')); ?> -
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.vehicle.carModel.name')); ?> -
                                        <?php echo CHtml::encode(CHtml::value($materialRequest->header, 'registrationTransaction.vehicle.carSubModel.name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="medium-12 columns">
                        <div id="detail_service">
                            <?php $this->renderPartial('_detailService', array(
                                'materialRequest' => $materialRequest,
                            )); ?>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <div class="medium-12 columns">
                        <div id="detail_product">
                            <?php $this->renderPartial('_detailProduct', array(
                                'materialRequest' => $materialRequest,
                            )); ?>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <?php echo CHtml::button('Cari Barang', array('name' => 'Search', 'onclick' => '$("#product-dialog").dialog("open"); return false;', 'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }')); ?>
                    <?php echo CHtml::hiddenField('ProductId'); ?>
                </div>

                <br /><br />

                <div id="detail_div">
                    <?php $this->renderPartial('_detail', array(
                        'materialRequest' => $materialRequest,
                        'branches' => $branches,
                    )); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
                <?php echo IdempotentManager::generate(); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div><!-- form -->

<?php if ($materialRequest->header->isNewRecord): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'registration-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Work Order',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'registration-grid',
        'dataProvider' => $registrationTransactionDataProvider,
        'filter' => $registrationTransaction,
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#' . CHtml::activeId($materialRequest->header, 'registration_transaction_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#registration-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#work_order_number").html("");
                $("#work_order_date").html("");
                $("#work_order_customer").html("");
                $("#work_order_vehicle").html("");
                $("#work_order_plate").html("");
                $("#work_order_type").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonWorkOrder', array('id' => $materialRequest->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#work_order_number").html(data.workOrderNumber);
                        $("#work_order_date").html(data.workOrderDate);
                        $("#work_order_customer").html(data.workOrderCustomer); 
                        $("#work_order_vehicle").html(data.workOrderVehicle); 
                        $("#work_order_plate").html(data.workOrderPlate);
                        $("#work_order_type").html(data.workOrderType);

                    },
                });
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $materialRequest->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { $("#detail_product").html(html); },
                });
                $.ajax({
                    type: "POST",
                    url: "' . CController::createUrl('ajaxHtmlAddService', array('id' => $materialRequest->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) { $("#detail_service").html(html); },
                });
            }
        }',
        'columns' => array(
            array(
                'name' => 'work_order_number',
                'header' => 'WO #',
                'value' => '$data->work_order_number',
            ),
            array(
                'header' => 'Tanggal',
                'name' => 'transaction_date',
                'filter' => false, 
                'value' => 'Yii::app()->dateFormatter->format("d MMMM yyyy", $data->transaction_date)',
            ),
            'repair_type',
            array(
                'header' => 'Customer',
                'filter' => CHtml::textField('CustomerName', $customerName, array('size' => '30', 'maxLength' => '60')),
                'value' => 'CHtml::value($data, "customer.name")',
            ),
            array(
                'header' => 'Plate #',
                'filter' => CHtml::textField('VehicleNumber', $vehicleNumber),
                'value' => 'CHtml::value($data, "vehicle.plate_number")',
            ),
            'note',
        ),
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php endif; ?>

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
                        url: "' . CController::createUrl('ajaxHtmlAddDetail', array('id' => $materialRequest->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(html) { $("#detail_div").html(html); },
                    });
                }',
                'columns' => array(
                    'id',
                    'name',
                    'manufacturer_code',
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
                    array(
                        'name' => 'unit_id',
                        'header' => 'Unit',
                        'value' => 'empty($data->unit) ? "" : $data->unit->name'
                    ),
                    array(
                        'header' => 'COA',
                        'value' => 'empty($data->productSubMasterCategory) ? "" : $data->productSubMasterCategory->coaPersediaanBarangDagang->name'
                    ),
                ),
            ));	?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
