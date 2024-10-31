<table style="border: 1px solid" id="adjustment-detail-table">
    <thead>
        <tr style="background-color: skyblue">
            <th colspan="2">&nbsp;</th>
            <th colspan="3" style="text-align:center">Asal</th>
            <th colspan="3" style="text-align:center; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-header">Tujuan</th>
            <th colspan="3">&nbsp;</th>
        </tr>
        <tr style="background-color: skyblue">
            <th style="text-align: center">Code</th>
            <th style="text-align: center">Nama Produk</th>
            <th style="text-align: center">Sekarang</th>
            <th style="text-align: center">Penyesuaian</th>
            <th style="text-align: center">Perbedaan</th>
            <th style="text-align: center; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-header">Sekarang</th>
            <th style="text-align: center; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-header">Penyesuaian</th>
            <th style="text-align: center; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-header">Perbedaan</th>
            <th style="text-align: center">Unit</th>
            <th style="text-align: center">Memo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($adjustment->details as $i => $detail): ?>
            <tr style="background-color: azure">
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                <td>
                    <?php echo CHtml::activeHiddenField($detail, "[$i]product_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                </td>
                <td style="text-align: center; width: 10%">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_current"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_current'))); ?>
                    <?php echo CHtml::error($detail, 'quantity_current'); ?>
                </td>
                <td style="text-align: center; width: 10%">
                    <?php echo CHtml::activeTextField($detail, "[$i]quantity_adjustment", array(
                        'size' => 1, 
                        'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDifference', array('id' => $adjustment->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#quantity_difference_' . $i . '").html(data.quantityDifference);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'quantity_adjustment'); ?>
                </td>
                <td style="text-align: center; width: 10%">
                    <span id="quantity_difference_<?php echo $i; ?>">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getQuantityDifference())); ?>
                    </span>
                </td>
                <td style="text-align: center; width: 10%; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-body">
                    <?php echo CHtml::activeHiddenField($detail, "[$i]quantity_current_destination"); ?>
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($detail, 'quantity_current_destination'))); ?>
                    <?php echo CHtml::error($detail, 'quantity_current_destination'); ?>
                </td>
                <td style="text-align: center; width: 10%; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-body">
                    <?php echo CHtml::activeTextField($detail, "[$i]quantity_adjustment_destination", array(
                        'size' => 1, 
                        'maxLength' => 20,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonDifference', array('id' => $adjustment->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                $("#quantity_difference_destination_' . $i . '").html(data.quantityDifferenceDestination);
                            }',
                        )),
                    )); ?>
                    <?php echo CHtml::error($detail, 'quantity_adjustment_destination'); ?>
                </td>
                <td style="text-align: center; width: 10%; <?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>display: none<?php endif; ?>" class="adjustment-detail-table-branch-destination-body">
                    <span id="quantity_difference_destination_<?php echo $i; ?>">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $detail->getQuantityDifferenceDestination())); ?>
                    </span>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'product.unit.name')); ?></td>
                <td><?php echo CHtml::activeTextField($detail, "[$i]memo"); ?></td>
                <td style="width: 5%">
                    <?php echo CHtml::button('Delete', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('AjaxHtmlRemoveProduct', array('id' => $adjustment->header->id, 'index' => $i)),
                            'update' => '#detail_div',
                        )),
                    )); ?>
                </td>
            </tr>
            <tr>
                <td colspan="<?php if ($adjustment->header->transaction_type !== 'Selisih Cabang'): ?>8<?php else: ?>11<?php endif; ?>" class="adjustment-detail-table-branch-destination-header">
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode')); ?> ||
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> ||
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> || 
                    <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>