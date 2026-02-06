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
                <td>SAE</td>
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
                        )),
                    )); ?>
                </td>

                <td>
                    <div id="product_sub_brand">
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $product->brand_id), array('order' => 'name ASC')), 'id', 'name'), array(
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
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $product->sub_brand_id), array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                        )); ?>
                    </div>
                </td>

                <td>
                    <?php $productMasterCategory = ProductMasterCategory::model()->findByPk(6); ?>
                    <?php echo CHtml::encode(CHtml::value($productMasterCategory, 'name')); ?>
                </td>

                <td>
                    <div id="product_sub_master_category">
                        <?php echo CHtml::activeDropDownList($product, 'product_sub_master_category_id', CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $productMasterCategory->id), array('order' => 'name ASC')), 'id', 'name'), array(
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
                        <?php echo CHtml::activeDropDownList($product, 'product_sub_category_id', CHtml::listData(ProductSubCategory::model()->findAll(array(
                            'condition' => 'product_master_category_id IN (6)',
                            'order' => 'name ASC'
                        )), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                        )); ?>
                    </div>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('OilSaeId', $oilSaeId, CHtml::listData(OilSae::model()->findAll(array('order' => 't.id ASC')), 'id', 'oilName'), array(
                        'empty' => '-- All --',
                    )); ?>
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
                <td>Bulan</td>
                <td>Tahun</td>
                <td>Convert Liter</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?php echo CHtml::activeTextField($product, 'id'); ?></td>
                <td><?php echo CHtml::activeTextField($product, 'manufacturer_code'); ?></td>
                <td>
                    <?php echo CHtml::hiddenField('page', $currentPage, array('size' => 3, 'id' => 'CurrentPage')); ?>
                    <?php echo CHtml::activeTextField($product, 'name'); ?>
                </td>
                <td>
                    <?php echo CHtml::dropDownList('Month', $month, array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'May',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Aug',
                        '09' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    )); ?>
                </td>
                <td><?php echo CHtml::dropDownList('Year', $year, $yearList); ?></td>
                <td>
                    <?php echo CHtml::dropDownList('ConvertToLitre', $convertToLitre, array(
                        1 => 'Rubah ke Liter'
                    ), array('empty' => 'Satuan Asal')); ?>
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