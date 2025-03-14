<div>
    <table>
        <thead>
            <tr>
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
                    <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                        'empty' => '-- All --',
                        'order' => 'name',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                            'update' => '#product_sub_brand',
                        )) . 
                        CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_stock_table',
                        )),
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
                            )) . 
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                'update' => '#product_stock_table',
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
                        )) .
                        CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_stock_table',
                        )),
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
                            )) .
                            CHtml::ajax(array(
                                'type' => 'GET',
                                'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                'update' => '#product_stock_table',
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

    <table>
        <thead>
            <tr>
                <td>ID</td>
                <td>Code</td>
                <td>Name</td>
                <td>Gudang</td>
                <td colspan="2">Periode</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <?php echo CHtml::activeTextField($product, 'id', array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_stock_table',
                        )),
                    )); ?>
                </td>

                <td>
                    <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_stock_table',
                        )),
                    )); ?>
                </td>

                <td>
                    <?php echo CHtml::hiddenField('page', $currentPage, array('size' => 3, 'id' => 'CurrentPage')); ?>
                    <?php echo CHtml::activeTextField($product, 'name', array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_stock_table',
                        )),
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('WarehouseId', $warehouseId, CHtml::listData(Warehouse::model()->findAllByAttributes(array('status' => 'Active'), array('order' => 'name ASC')), 'id', 'name')); ?>
                </td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'StartDate',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'Mulai',
                        ),
                    )); ?>
                </td>
                <td>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'EndDate',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth'=>true,
                            'changeYear'=>true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'Sampai',
                        ),
                    )); ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div>
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>
</div>