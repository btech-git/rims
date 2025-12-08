<div>
    <table>
        <thead>
            <tr>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
                <td>ID</td>
                <td>Code</td>
                <td>Name</td>
                <td>Ukuran</td>
                <td>Tahun Produksi</td>
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
                        <?php echo CHtml::dropDownList('SubBrandId', $subBrandId, CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $brandId)), 'id', 'name'), array(
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
                        <?php echo CHtml::dropDownList('SubBrandSeriesId', $subBrandSeriesId, CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $subBrandId)), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                        )); ?>
                    </div>
                </td>
                <td><?php echo CHtml::textField('ProductId', $productId, array('style' => 'width:100px')); ?></td>
                <td><?php echo CHtml::textField('ProductCode', $productCode, array('style' => 'width:100px')); ?></td>
                <td><?php echo CHtml::textField('ProductName', $productName); ?></td>
                <td>
                    <?php echo CHtml::dropDownList('TireSizeId', $tireSizeId, CHtml::listData(TireSize::model()->findAll(array('order' => 't.name ASC')), 'id', 'name'), array(
                        'empty' => '-- All --',
                    )); ?>
                </td>
                <td><?php echo CHtml::dropDownList('EndYear', $endYear, $yearList); ?></td>
            </tr>
        </tbody>
    </table>

    <div>
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>
</div>