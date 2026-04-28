<!--<div <?php //if ($saleEstimation->header->isNewRecord && !$isSubmitted): ?>style="display: none"<?php //endif; ?> id="transaction-form">-->
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    
    <div class="form">
        <?php echo CHtml::errorSummary($saleEstimation->header); ?>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">FORM ESTIMASI</legend>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'transaction_date', array('class' => 'form-label', 'label' => 'Tanggal')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $saleEstimation->header,
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
                                                'class' => 'form-control readonly-form-input',
                                            ),
                                        )); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'transaction_date'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Kendaraan', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeHiddenField($saleEstimation->header, 'vehicle_id', array('value' => $saleEstimation->header->vehicle_id)); ?>
                                        <?php if (empty($vehicle)): ?>
                                            <?php echo CHtml::textField('VehicleName', '', array(
                                                'class' => 'form-control readonly-form-input', 
                                                'readonly' => true,
                                                'onclick' => '$("#vehicle-dialog").dialog("open"); return false;',
                                                'onkeypress' => 'if (event.keyCode == 13) { $("#vehicle-dialog").dialog("open"); return false; }',
                                            )); ?>
                                        <?php else: ?>
                                            <?php echo CHtml::textField('VehicleName', $vehicle->carMakeModelSubCombination, array(
                                                'class' => 'form-control', 
                                                'readonly' => true,
                                            )); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Customer', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeHiddenField($saleEstimation->header, 'customer_id', array('value' => $saleEstimation->header->customer_id)); ?>
                                        <?php echo CHtml::openTag('span', array('id' => 'customer_name_span')); ?>
                                        <?php echo CHtml::encode(CHtml::value($saleEstimation->header, 'customer.name')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                        <?php echo CHtml::error($saleEstimation->header, 'customer_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Nomor Polisi', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'plate_number_span')); ?>
                                        <?php echo CHtml::encode(CHtml::value($saleEstimation->header, 'vehicle.plate_number')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Alamat', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'customer_address_span')); ?>
                                        <?php echo CHtml::encode(CHtml::value($saleEstimation->header, 'customer.address')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Phone', false, array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::openTag('span', array('id' => 'customer_phone_span')); ?>
                                        <?php echo CHtml::encode(CHtml::value($saleEstimation->header, 'customer.mobile_phone')); ?>
                                        <?php echo CHtml::closeTag('span'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'employee_id_sale_person', array('class' => 'form-label', 'label' => 'Salesman')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeDropDownlist($saleEstimation->header, 'employee_id_sale_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                                            "position_id" => 2,
                                            'status' => 'Active',
                                        )), "id", "name"), array("empty" => "--Assign Sales--", 'class' => 'form-select' . ($saleEstimation->header->hasErrors('employee_id_sale_person') ? ' is-invalid' : ''))); ?>
                                        <?php echo CHtml::error($saleEstimation->header, 'employee_id_sale_person', array('class' => 'invalid-feedback d-block')); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'previous_mileage', array('class' => 'form-label', 'label' => 'KM Service Terakhir')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($saleEstimation->header, 'previous_mileage', array('class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'previous_mileage'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'vehicle_mileage', array('class' => 'form-label', 'label' => 'KM (saat ini)')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextField($saleEstimation->header, 'vehicle_mileage', array('class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'vehicle_mileage'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'problem', array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($saleEstimation->header,'problem',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'problem'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::activeLabelEx($saleEstimation->header, 'note', array('class' => 'form-label')); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($saleEstimation->header,'note',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                                        <?php echo CHtml::error($saleEstimation->header,'note'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">SUKU CADANG - SPAREPARTS</legend>
            <div class="row">
                <?php echo CHtml::button('Cari Barang', array(
                    'name' => 'Search', 
                    'onclick' => '$("#product-dialog").dialog("open"); return false;', 
                    'onkeypress' => 'if (event.keyCode == 13) { $("#product-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::hiddenField('ProductId'); ?>
                <?php //echo CHtml::activeHiddenField($saleEstimation->header, 'detailIdsToBeDeleted'); ?>
            </div>

            <div class="detail_product" id="detail_product_div">
                <?php $this->renderPartial('_detailProduct', array(
                    'saleEstimation' => $saleEstimation,
                    'branches' => $branches,
                )); ?>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">JASA PERBAIKAN - SERVICE</legend>
            <div class="row">
                <?php echo CHtml::button('Cari Service', array(
                    'name' => 'Search', 
                    'onclick' => '$("#service-dialog").dialog("open"); return false;', 
                    'onkeypress' => 'if (event.keyCode == 13) { $("#service-dialog").dialog("open"); return false; }'
                )); ?>
                <?php echo CHtml::hiddenField('ServiceId'); ?>
                <?php //echo CHtml::activeHiddenField($saleEstimation->header, 'detailIdsToBeDeleted'); ?>
            </div>

            <div class="detail_service" id="detail_service_div">
                <?php $this->renderPartial('_detailService', array('saleEstimation' => $saleEstimation)); ?>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">TOTAL TRANSAKSI</legend>
            <div class="detail" id="detail-total">
                <?php $this->renderPartial('_detailTotal', array('saleEstimation' => $saleEstimation)); ?>
            </div>
        </fieldset>

        <div class="d-grid">
            <div class="row">
                <div class="col text-center">
                    <?php //echo CHtml::htmlButton($saleEstimation->header->isNewRecord ? 'Back' : 'Add Product Service', array('id' => 'back-button', 'class'=>'btn btn-warning btn-sm')); ?>
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class'=>'btn btn-danger btn-sm')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'btn btn-success btn-sm')); ?>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
    
    <?php echo CHtml::endForm(); ?>
</div>

<?php if ($saleEstimation->header->vehicle_id === null): ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'vehicle-dialog',
        // additional javascript options for the dialog plugin
        'options' => array(
            'title' => 'Vehicle',
            'autoOpen' => false,
            'width' => 'auto',
            'modal' => true,
        ),
    )); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'vehicle-grid',
        'dataProvider' => $vehicleDataProvider,
        'filter' => $vehicleData,
        'selectionChanged' => 'js:function(id){
            $("#' . CHtml::activeId($saleEstimation->header, 'vehicle_id') . '").val($.fn.yiiGridView.getSelection(id));
            $("#vehicle-dialog").dialog("close");
            if ($.fn.yiiGridView.getSelection(id) == "") {
                $("#VehicleName").val("");
                $("#customer_name_span").html("");
                $("#' . CHtml::activeId($saleEstimation->header, 'customer_id') . '").val("");
                $("#plate_number_span").html("");
                $("#frame_number_span").html("");
            } else {
                $.ajax({
                    type: "POST",
                    dataType: "JSON",
                    url: "' . CController::createUrl('ajaxJsonVehicle', array('id' => $saleEstimation->header->id)) . '",
                    data: $("form").serialize(),
                    success: function(data) {
                        $("#VehicleName").val(data.vehicle_name);
                        $("#customer_name_span").html(data.customer_name);
                        $("#' . CHtml::activeId($saleEstimation->header, 'customer_id') . '").val(data.customer_id);
                        $("#plate_number_span").html(data.vehicle_plate_number);
                        $("#customer_phone_span").html(data.customer_phone);
                    },
                });
            }
        }',
        'columns' => array(
            array(
                'header' => 'Nomor Polisi',
                'filter' => CHtml::activeTextField($vehicleData, 'plate_number'),
                'value' => 'CHtml::encode(CHtml::value($data, "plate_number"))',
            ),
            array(
                'header' => 'Kendaraan',
                'value' => 'CHtml::encode(CHtml::value($data, "carMakeModelSubCombination"))',
            ),
            array(
                'header' => 'Nomor Rangka',
                'value' => 'CHtml::encode(CHtml::value($data, "frame_number"))',
            ),
            array(
                'header' => 'Customer',
                'filter' => CHtml::textField('CustomerName', $customerName),
                'value' => 'empty($data->customer_id) ? "" : $data->customer->name',
            ),
        )
    )); ?>
    <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php endif; ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'product-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Spare Parts',
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
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',
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
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',
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
                                <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',
                                    'onchange' => CHtml::ajax(array(
                                        'type' => 'GET',
                                        'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                        'update' => '#product_stock_table',
                                    )),
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',
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
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',
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
                                <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array('empty' => '-- All --',
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
                        url: "' . CController::createUrl('ajaxHtmlAddProductDetail', array('id' => $saleEstimation->header->id)) . '",
                        data: $("form").serialize(),
                        success: function(html) { $("#detail_product_div").html(html); },
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

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'service-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Service',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => true,
    ),
)); ?>

    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'service-grid',
        'dataProvider' => $serviceDataProvider,
        'filter' => $service,
        'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
        'pager' => array(
            'cssFile' => false,
            'header' => '',
        ),
        'selectionChanged' => 'js:function(id) {
            $("#ServiceId").val($.fn.yiiGridView.getSelection(id));
            $("#service-dialog").dialog("close");
            $.ajax({
                type: "POST",
                url: "' . CController::createUrl('ajaxHtmlAddServiceDetail', array('id' => $saleEstimation->header->id)) . '",
                data: $("form").serialize(),
                success: function(html) { $("#detail_service_div").html(html); },
            });
        }',
        'columns' => array(
            'id',
            'name',
            'code',
            array(
                'name' => 'service_category_id',
                'header' => 'Kategori',
                'filter' => CHtml::activeDropDownList($service, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->serviceCategory->name',
            ),
            array(
                'name' => 'service_type_id',
                'header' => 'Type',
                'filter' => CHtml::activeDropDownList($service, 'service_type_id', CHtml::listData(ServiceType::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('empty' => '-- All --')),
                'value' => '$data->serviceType->name',  
            ),
            array(
                'name' => 'price',
                'header' => 'Price',
                'value' => 'number_format($data->lastSalePrice, 2)',
                'htmlOptions' => array('style' => 'text-align:right'),
            ),
        ),
    ));	?>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>//
//    $(document).ready(function() {
//        $('#back-button').on('click', function() {
//            $('#transaction-form').hide();
//            $('#master-list').show();
//        });
//    });
//</script>
