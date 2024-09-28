<table>
    <thead>
        <tr>
            <th>Service name</th>
            <th>Price</th>
            <th>Discount Type</th>
            <th>Discount Price</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($saleEstimation->serviceDetails as $i => $serviceDetail): ?>
            <tr>
                <td>
                    <?php echo CHtml::activeHiddenField($serviceDetail, "[$i]service_id"); ?>
                    <?php echo CHtml::encode(CHtml::value($serviceDetail, 'service.name')); ?>
                </td>
                <td><?php
                    echo CHtml::activeTextField($serviceDetail, "[$i]price", array(
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $saleEstimation->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalAmount);
                                    $("#total_quantity_service").html(data.totalQuantityService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#total_discount_service").html(data.totalDiscountService);
                                    $("#grand_total_service").html(data.grandTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                        )),
                        'class' => "form-control is-valid",
                    ));
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::activeDropDownList($serviceDetail, "[$i]discount_type", array(
                        'Nominal' => 'Nominal',
                        'Percent' => '%'
                            ), array('prompt' => '[--Select Discount Type--]'));
                    ?>
                </td>
                <td>
                    <?php
                    echo CHtml::activeTextField($serviceDetail, "[$i]discount_value", array(
                        'size' => 5,
                        'onchange' => CHtml::ajax(array(
                            'type' => 'POST',
                            'dataType' => 'JSON',
                            'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $saleEstimation->header->id, 'index' => $i)),
                            'success' => 'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalAmount);
                                    $("#total_quantity_service").html(data.totalQuantityService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#total_discount_service").html(data.totalDiscountService);
                                    $("#grand_total_service").html(data.grandTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#tax_service_amount").html(data.taxServiceAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                        )),
                        'class' => "form-control is-valid",
                    ));
                    ?>
                </td>
                <td>
                    <span id="total_amount_<?php echo $i; ?>">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($serviceDetail, 'totalAmount'))); ?>
                    </span>
                </td>
                <td>
                    <?php echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveServiceDetail', array('id' => $saleEstimation->header->id, 'index' => $i)),
                            'update' => '#detail-service',
                        ))
                    )); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
