
        <?php echo CHtml::errorSummary($saleEstimation->partsDetails); ?>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-secondary">
            <tr>
                <th style="width: 15%">Kode</th>
                <th>Item</th>
                <th style="width: 10%">Quantity</th>
                <th style="width: 15%">Harga Satuan</th>
                <th style="width: 10%">Disc Type</th>
                <th style="width: 10%">Discount</th>
                <th style="width: 15%">Total</th>
                <th style="width: 5%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($saleEstimation->partsDetails as $i => $partsDetail): ?>
                <tr>
                    <td><?php echo CHtml::activeTextField($partsDetail, "[$i]parts_code"); ?></td>
                    <td><?php echo CHtml::activeTextField($partsDetail, "[$i]parts_name"); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($partsDetail, "[$i]quantity", array(
                            'class' => 'form-control',
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalParts', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_price_parts_' . $i . '").html(data.totalPriceParts);
                                    $("#total_quantity_parts").html(data.totalQuantityParts);
                                    $("#sub_total_parts").html(data.subTotalParts);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                        ));
                        ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($partsDetail, "[$i]sale_price", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalParts', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_price_parts_' . $i . '").html(data.totalPriceParts);
                                    $("#total_quantity_parts").html(data.totalQuantityParts);
                                    $("#sub_total_parts").html(data.subTotalParts);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($partsDetail, "[$i]discount_type", array(
                            'Nominal' => 'Nominal',
                            'Percent' => '%'
                        ), array('prompt' => '[--Select Discount Type --]')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($partsDetail, "[$i]discount_value", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalParts', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_price_parts_' . $i . '").html(data.totalPriceParts);
                                    $("#total_quantity_parts").html(data.totalQuantityParts);
                                    $("#sub_total_parts").html(data.subTotalParts);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_total_transaction").html(data.taxTotalTransaction);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control",
                        )); ?>
                    </td>
                    <td style="text-align: right">
                        <span id="total_price_parts_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($partsDetail, 'total_price'))); ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($saleEstimation->header->isNewRecord): ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-outline-dark",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemovePartsDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail_parts_div',
                                )),
                            )); ?>
                        <?php else: ?>
                            <?php echo CHtml::button('X', array(
                                'class' => "btn btn-danger",
                                'onclick' => CHtml::ajax(array(
                                    'type' => 'POST',
                                    'url' => CController::createUrl('ajaxHtmlRemovePartsDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                                    'update' => '#detail_parts_div',
                                )),
                            )); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="fw-bold" style="text-align: right" colspan="2">Total Quantity</td>
                <td class="text-center fw-bold">
                    <span id="total_quantity_parts">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header,'total_quantity_new_parts'))); ?>                                                
                    </span>
                </td>
                <td class="fw-bold" style="text-align: right" colspan="3">Total Non-Stok</td>
                <td class="fw-bold" style="text-align: right">
                    <span id="sub_total_parts">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0", CHtml::value($saleEstimation->header, 'sub_total_new_parts'))); ?>                                                
                    </span>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
