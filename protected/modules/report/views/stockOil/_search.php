<div>
    <table>
        <thead>
            <tr>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
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
                <td>Convert Liter</td>
                <td>Per Tanggal</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo CHtml::textField('ProductId', $productId); ?></td>
                <td><?php echo CHtml::textField('ProductCode', $productCode); ?></td>
                <td><?php echo CHtml::textField('ProductName', $productName); ?></td>
                <td>
                    <?php echo CHtml::dropDownList('ConvertToLitre', $convertToLitre, array(
                        1 => 'Rubah ke Liter'
                    ), array('empty' => 'Satuan Asal')); ?>
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
                            'placeholder' => 'Per Tanggal',
                        ),
                    )); ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <div>
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>
</div>