<table style="border: 1px solid">
    <tr style="background-color: skyblue">
        <th style="text-align: center">Nama Produk</th>
        <th>Code</th>
        <th>Kategori</th>
        <th>Brand</th>
        <th>Sub Brand</th>
        <th>Sub Brand Series</th>
        <th style="text-align: center">Sekarang</th>
        <th style="text-align: center">Penyesuaian</th>
        <th style="text-align: center">Perbedaan</th>
        <th style="text-align: center">Unit</th>
        <th></th>
    </tr>
    <?php foreach ($adjustment->details as $i=>$detail): ?>
        <tr style="background-color: azure">
            <td>
                <?php echo CHtml::activeTextField($detail, "[$i]warehouse_id"); ?>
                <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code'));  ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode'));  ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name'));  ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name'));  ?></td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name'));  ?></td>
            <td style="text-align: center; width: 10%">
                <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_current"); ?>
                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_current'))); ?>
                <?php echo CHtml::error($detail, 'quantity_current'); ?>
            </td>
            <td style="text-align: center; width: 15%">
                    <?php echo CHtml::activeTextField($detail, "[$i]quantity_adjustment", array('size'=>7, 'maxLength'=>20,
                        'onchange'=>CHtml::ajax(array(
                            'type'=>'POST',
                            'dataType'=>'JSON',
                            'url'=>CController::createUrl('ajaxJsonDifference', array('id'=>$adjustment->header->id, 'index'=>$i)),
                            'success'=>'function(data) {
                                $("#quantity_difference_' . $i . '").html(data.quantityDifference);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'quantity_adjustment'); ?>
            </td>
            <td style="text-align: center; width: 10%">
                <span id="quantity_difference_<?php echo $i; ?>">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getQuantityDifference($adjustment->header->branch_id))); ?>
                </span>
            </td>
            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name'));  ?></td>
            <td style="width: 5%">
                <?php echo CHtml::button('Delete', array(
                    'onclick'=>CHtml::ajax(array(
                        'type'=>'POST',
                        'url'=>CController::createUrl('AjaxHtmlRemoveProduct', array('id'=>$adjustment->header->id, 'index'=>$i)),
                        'update'=>'#detail_div',
                    )),
                )); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
