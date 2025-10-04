<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama</th>
        <th style="text-align: center" colspan="3">Brand</th>
        <th style="text-align: center" colspan="3">Category</th>
        <th style="text-align: center">Quantity</th>
        <th style="text-align: center">Memo</th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($productPricingRequest->details as $i => $detail): ?>
        <tr style="background-color: azure">
            <td><?php echo CHtml::activeTextField($detail, "[$i]product_name"); ?></td>
            <td style="width: 8%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]brand_id", CHtml::listData(Brand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Brand --')); ?>
            </td>
            <td style="width: 8%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]sub_brand_id", CHtml::listData(SubBrand::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Sub Brand --')); ?>
            </td>
            <td style="width: 8%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]sub_brand_series_id", CHtml::listData(SubBrandSeries::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Sub Brand Series --')); ?>
            </td>
            <td style="width: 8%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_master_category_id", CHtml::listData(ProductMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Master Category --')); ?>
            </td>
            <td style="width: 8%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_sub_master_category_id", CHtml::listData(ProductSubMasterCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Sub Master Category --')); ?>
            </td>
            <td style="width: 8%">
                <?php echo CHtml::activeDropDownList($detail, "[$i]product_sub_category_id", CHtml::listData(ProductSubCategory::model()->findAll(array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Sub Category --')); ?>
            </td>
            <td style="width: 8%"><?php echo CHtml::activeTextField($detail, "[$i]quantity"); ?></td>
            <td><?php echo CHtml::activeTextField($detail, "[$i]memo"); ?></td>
            <td style="width: 3%">
                <?php echo CHtml::button('Delete', array(
                    'onclick' => CHtml::ajax(array(
                        'type' => 'POST',
                        'url' => CController::createUrl('AjaxHtmlRemoveDetail', array('id' => $productPricingRequest->header->id, 'index' => $i)),
                        'update' => '#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>