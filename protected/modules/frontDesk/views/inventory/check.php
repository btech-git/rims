<div>
    <?php echo CHtml::beginForm(); ?>
    
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
                        <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array(
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
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAll(), 'id', 'name'), array(
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
                            <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAll(), 'id', 'name'), array(
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
                        <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(), 'id', 'name'), array(
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
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAll(), 'id', 'name'), array(
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
                            <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(), 'id', 'name'), array(
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
        
        <div>
            <?php echo CHtml::submitButton('Clear', array('name' => 'Clear')); ?>
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>
</div>

<div id="product_stock_table">
    <?php $this->renderPartial('_productStockTable', array(
        'productDataProvider' => $productDataProvider,
        'branches' => $branches,
    )); ?>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $productDataProvider->pagination->itemCount,
            'pageSize' => $productDataProvider->pagination->pageSize,
            'currentPage' => $productDataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>

<script>
    //$('ul.yiiPager > li > a').click(function(e) {
        //e.preventDefault();
        //$.ajax({
        //    type: 'GET',
        //    url: '/raperind/frontDesk/inventory/ajaxHtmlUpdateProductSubBrandSelect',
        //    data: $('form').serialize(),
        //    success: function(html) {
        //        $('#product_stock_table').html(html);
        //    }
        //});
        //var href = $(e.target).attr('href');
        //var pageNumber = href.replace(/.+(?:&|\?)page=(\d+)(?:&|$).*/g, '$1');
        //$('#page').val(pageNumber);
        //console.log(href, pageNumber);
    //});
</script>