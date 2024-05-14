<div class="row">
    <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
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
                </tr>
            </tbody>
        </table>
        
        <div id="product_stock_table">
            <?php $this->renderPartial('_productStockTable', array(
                'productDataProvider' => $productDataProvider,
                'branches' => $branches,
                'endDate' => $endDate,
            )); ?>
        </div>
    </div>
</div>