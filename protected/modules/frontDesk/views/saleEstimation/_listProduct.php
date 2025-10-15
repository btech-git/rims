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
                                'class' => 'form-control',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_data_container',
                                )),
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                                'class' => 'form-control',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_data_container',
                                )),
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeTextField($product, 'name', array(
                                'class' => 'form-control',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_data_container',
                                )),
                            )); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'brand_id', CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'class' => 'form-select',
                                'empty' => '-- All --',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubBrandSelect'),
                                    'update' => '#product_sub_brand',
                                )) . 
                                CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_data_container',
                                )),
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_brand">
                                <?php $this->renderPartial('_productSubBrandSelect', array(
                                    'product' => $product,
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <div id="product_sub_brand_series">
                                <?php $this->renderPartial('_productSubBrandSeriesSelect', array(
                                    'product' => $product,
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <?php echo CHtml::activeDropDownList($product, 'product_master_category_id', CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
                                'empty' => '-- All --',
                                'class' => 'form-select',
                                'onchange' => CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductSubMasterCategorySelect'),
                                    'update' => '#product_sub_master_category',
                                )) .
                                CHtml::ajax(array(
                                    'type' => 'GET',
                                    'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                                    'update' => '#product_data_container',
                                )),
                            )); ?>
                        </td>
                        <td>
                            <div id="product_sub_master_category">
                                <?php $this->renderPartial('_productSubMasterCategorySelect', array(
                                    'product' => $product,
                                )); ?>
                            </div>
                        </td>
                        <td>
                            <div id="product_sub_category">
                                <?php $this->renderPartial('_productSubCategorySelect', array(
                                    'product' => $product,
                                )); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center">
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter', 'class' => 'btn btn-danger'));  ?>
    </div>

    <hr />

    <div id="product_data_container">
        <?php $this->renderPartial('_productDataTable', array(
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
        )); ?>
    </div>
<?php echo CHtml::endForm(); ?>
