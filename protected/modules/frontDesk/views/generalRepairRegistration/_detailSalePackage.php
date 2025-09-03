<?php if (count($generalRepairRegistration->packageDetails) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th style="width: 10%">Start Date</th>
                <th style="width: 10%">End Date</th>
                <th style="width: 10%">Quantity</th>
                <th style="width: 10%">Price</th>
                <th style="width: 10%">Total</th>
                <th style="width: 3%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($generalRepairRegistration->packageDetails as $i => $packageDetail): ?>
                <?php echo CHtml::errorSummary($packageDetail); ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($packageDetail, "[$i]sale_package_header_id"); ?>
                        <?php echo CHtml::encode(CHtml::value($packageDetail, "salePackageHeader.name")); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($packageDetail, "salePackageHeader.start_date")); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($packageDetail, "salePackageHeader.end_date")); ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($packageDetail, "[$i]quantity", array(
                            'onchange' => CHtml::ajax(array(
                                'type' => 'POST',
                                'dataType' => 'JSON',
                                'url' => CController::createUrl('ajaxJsonTotalPackage', array('id' => $generalRepairRegistration->header->id, 'index' => $i)),
                                'success' => 'function(data) {
                                    $("#total_price_' . $i . '").html(data.totalPrice);
                                    $("#quantity_sum").html(data.quantitySum);
                                    $("#total_price_sum").html(data.totalPriceSum);
                                    $("#sub_total_transaction").html(data.subTotalTransaction);
                                    $("#tax_item_amount").html(data.taxItemAmount);
                                    $("#grand_total_transaction").html(data.grandTotalTransaction);
                                }',
                            )),
                            'class' => "form-control is-valid",
                        )); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::activeHiddenField($packageDetail, "[$i]price"); ?>
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($packageDetail, "price"))); ?>
                    </td>
                    <td style="width: 10%; text-align: right">
                        <?php //echo CHtml::activeHiddenField($packageDetail, "[$i]total_price", array('readonly' => true,)); ?>
                        <span id="total_price_<?php echo $i; ?>">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($packageDetail, 'total_price'))); ?>
                        </span>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemovePackageDetail', array('id' => $generalRepairRegistration->header->id, 'index' => $i)),
                                'update' => '#package',
                            )),
                        )); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
