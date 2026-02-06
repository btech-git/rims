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
                    <?php echo CHtml::dropDownList('BrandId', $brandId, CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array(
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
                        <?php echo CHtml::dropDownList('SubBrandId', $subBrandId, CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $brandId), array('order' => 'name ASC')), 'id', 'name'), array(
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
                        <?php echo CHtml::dropDownList('SubBrandSeriesId', $subBrandSeriesId, CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $subBrandId), array('order' => 'name ASC')), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                        )); ?>
                    </div>
                </td>

                <td>
                    <?php $productMasterCategory = ProductMasterCategory::model()->findByPk($masterCategoryId); ?>
                    <?php echo CHtml::encode(CHtml::value($productMasterCategory, 'name')); ?>
                </td>

                <td>
                    <div id="product_sub_master_category">
                        <?php echo CHtml::dropDownList('SubMasterCategoryId', $subMasterCategoryId, CHtml::listData(ProductSubMasterCategory::model()->findAllByAttributes(array('product_master_category_id' => $masterCategoryId), array('order' => 'name ASC')), 'id', 'name'), array(
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
                        <?php echo CHtml::dropDownList('SubCategoryId', $subCategoryId, CHtml::listData(ProductSubCategory::model()->findAll(array(
                            'condition' => 'product_sub_master_category_id IN (25, 26, 27)',
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
                <td>Branch</td>
                <td>Tahun</td>
                <td>Convert Liter</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?php echo CHtml::textField('ProductId', $productId); ?></td>
                <td><?php echo CHtml::textField('ProductCode', $productCode); ?></td>
                <td><?php echo CHtml::textField('ProductName', $productName); ?></td>
                <td>
                    <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
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