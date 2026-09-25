<div>
    <table>
        <thead>
            <tr>
                <td>Brand</td>
                <td>Sub Brand</td>
                <td>Sub Brand Series</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="width: 33%">
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

                <td style="width: 33%">
                    <div id="product_sub_brand">
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_id', CHtml::listData(SubBrand::model()->findAllByAttributes(array('brand_id' => $product->brand_id)), 'id', 'name'), array(
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

                <td style="width: 33%">
                    <div id="product_sub_brand_series">
                        <?php echo CHtml::activeDropDownList($product, 'sub_brand_series_id', CHtml::listData(SubBrandSeries::model()->findAllByAttributes(array('sub_brand_id' => $product->sub_brand_id)), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
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
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>
                    <?php echo CHtml::activeTextField($product, 'id'); ?>
                </td>

                <td>
                    <?php echo CHtml::activeTextField($product, 'manufacturer_code'); ?>
                </td>

                <td>
                    <?php echo CHtml::activeTextField($product, 'name'); ?>
                </td>
                <td>
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
            </tr>
        </tbody>
    </table>

    <div>
        <?php echo CHtml::submitButton('Tampilkan'); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>
</div>