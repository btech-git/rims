<?php echo CHtml::beginForm(); ?>
    <div class="row">
        <div class="col">
            <div class="my-2 row">
                <label class="col col-form-label">Brand</label>
                <div class="col">
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
                </div>
                <label class="col col-form-label">Sub Brand</label>
                <div class="col">
                    <div id="product_sub_brand">
                        <?php $this->renderPartial('_productSubBrandSelect', array(
                            'product' => $product,
                        )); ?>
                    </div>
                </div>
                <label class="col col-form-label">Sub Brand Series</label>
                <div class="col">
                    <div id="product_sub_brand_series">
                        <?php $this->renderPartial('_productSubBrandSeriesSelect', array(
                            'product' => $product,
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="my-2 row">
                <label class="col col-form-label">Master Kategori</label>
                <div class="col">
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
                </div>
                <label class="col col-form-label">Sub Master Kategori</label>
                <div class="col">
                    <div id="product_sub_master_category">
                        <?php $this->renderPartial('_productSubMasterCategorySelect', array(
                            'product' => $product,
                        )); ?>
                    </div>
                </div>
                <label class="col col-form-label">Sub Kategori</label>
                <div class="col">
                    <div id="product_sub_category">
                        <?php $this->renderPartial('_productSubCategorySelect', array(
                            'product' => $product,
                        )); ?>
                    </div>
                </div>
            </div>
            <div class="my-2 row">
                <label class="col col-form-label">ID</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($product, 'id', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_data_container',
                        )),
                    )); ?>
                </div>
                <label class="col col-form-label">Code</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($product, 'manufacturer_code', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_data_container',
                        )),
                    )); ?>
                </div>
                <label class="col col-form-label">Name</label>
                <div class="col">
                    <?php echo CHtml::activeTextField($product, 'name', array(
                        'class' => 'form-control',
                        'onchange' => CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateProductStockTable'),
                            'update' => '#product_data_container',
                        )),
                    )); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter', 'class' => 'btn btn-outline-dark'));  ?>
    </div>

    <div id="product_data_container">
        <?php $this->renderPartial('_productDataTable', array(
            'productDataProvider' => $productDataProvider,
            'branches' => $branches,
            'endDate' => $endDate,
        )); ?>
    </div>
<?php echo CHtml::endForm(); ?>
