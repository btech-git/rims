<?php //if (count($registrationTransaction->serviceDetails) > 0):  ?>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Claim</th>
            <th>Hour</th>
            <th>Note</th>
            <th>Price</th>
            <th>Discount Type</th>
            <th>Discount Price</th>
            <th>Total Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($registrationTransaction->serviceDetails as $i => $serviceDetail): ?>
            <?php echo CHtml::errorSummary($serviceDetail); ?>
            <?php if ($serviceDetail->is_body_repair == 0) : ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($serviceDetail, "[$i]service_id"); ?>
                        <?php echo CHtml::activeTextField($serviceDetail, "[$i]service_name", array('readonly' => true, 'value' => $serviceDetail->service_id != "" ? $serviceDetail->service->name : '')); ?>
                        <?php echo CHtml::activeHiddenField($serviceDetail, "[$i]is_quick_service"); ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($serviceDetail, "[$i]claim", array('readonly' => true, 'size' => 5)); ?></td>
                    <td>
                        <?php $service = Service::model()->findByPk($serviceDetail->service_id); ?>
                        <?php echo CHtml::activeTextField($serviceDetail, "[$i]hour", array(
                            'readonly' => true, 
                            'value' => $serviceDetail->service_id != "" ? $service->flat_rate_hour : '', 
                            'size' => 5,
                        )); ?>
                    </td>
                    <td><?php echo CHtml::activeTextField($serviceDetail, "[$i]note", array('size' => 20, 'maxLength' => 100)); ?></td>
                    <td><?php echo CHtml::activeTextField($serviceDetail, "[$i]price", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $registrationTransaction->header->id, 'index' => $i)),
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
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($serviceDetail, "[$i]discount_type", array(
                            'Nominal' => 'Nominal',
                            'Percent' => '%'
                        ), array('prompt' => '[--Select Discount Type--]')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($serviceDetail, "[$i]discount_price", array(
                            'readonly' => $serviceDetail->is_quick_service == 1 ? true : false,
                            'size' => 5,
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $registrationTransaction->header->id, 'index' => $i)),
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
                        )); ?>
                    </td>
                    <td >
                        <span id="total_amount_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($serviceDetail, 'totalAmount'))); ?>
                        </span>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveServiceDetail', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                'update' => '#detail_service_div',
                            )) .
                            CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalService', array('id' => $registrationTransaction->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_amount_' . $i . '").html(data.totalAmount);
                                    $("#total_quantity_service").html(data.totalQuantityService);
                                    $("#sub_total_service").html(data.subTotalService);
                                    $("#total_discount_service").html(data.totalDiscountService);
                                    $("#grand_total_service").html(data.grandTotalService);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#grand_total_transaction").html(data.grandTotal);
                                }',
                            )),
                        )); ?>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
</table>
<?php //endif  ?>
