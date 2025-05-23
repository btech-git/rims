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
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $product->brand_id)), 'id', 'name'), array(
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
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $product->sub_brand_id)), 'id', 'name'), array(
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
                        <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $product->product_master_category_id)), 'id', 'name'), array(
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
                        <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAllByAttributes(array('product_sub_master_category_id' => $product->product_sub_master_category_id)), 'id', 'name'), array(
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
                <td>Per Tanggal</td>
                <td>Stok Operator</td>
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
                    <?php echo CHtml::activeTextField($product, 'name', array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_stock_table',
                        )),
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::hiddenField('page', $pageNumber, array('id' => 'CurrentPage')); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'name' => 'EndDate',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'placeholder' => 'Per Tanggal',
                        ),
                    )); ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('StockOperator', $stockOperator, array(
                        '' => '',
                        '>=' => '>= 0',
                        '>' => '> 0',
                        '<' => '< 0',
                        '=' => '= 0',
                        '<=' => '<= 0',
                        '<>' => '<> 0',
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