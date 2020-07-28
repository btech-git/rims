<?php $requestOrders = TransactionRequestOrderDetail::model()->findAllByAttributes(array('request_order_id'=>$model->id)); 
foreach ($requestOrders as $requestOrder) : ?>
	<?php if ($requestOrder->supplier != NULL): ?>
		<fieldset>
            <legend><?php echo $requestOrder->supplier->name; ?></legend>
            <div class="row">
                <div class="large-12 columns">
                    <table>
                        <thead>
                            <tr>
                                <td>Product</td>
                                <td>Quantity</td>
                                <td>Unit</td>
                                <td>Disc Step(s)</td>
                                <td>Disc</td>
                                <td>Last Price</td>
                                <td>Retail Price</td>
                                <td>Unit Price</td>
                                <td>Total Price</td>
                            </tr>

                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $requestOrder->product->name; ?></td>
                                <td><?php echo $requestOrder->quantity; ?></td>
                                <td><?php echo $requestOrder->product->unit->name; ?></td>
                                <td><?php echo $requestOrder->discount_step != ""? $requestOrder->discount_step : '-'; ?></td>
                                <td>
                                    <?php if ($requestOrder->discount_step == 1): ?>
                                        <?php echo $requestOrder->discount1_nominal . ' (' . $requestOrder->discountType1Literal . ')'; ?>
                                    <?php elseif($requestOrder->discount_step == 2): ?>
                                        <?php echo $requestOrder->discount1_nominal . ' (' . $requestOrder->discountType1Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount2_nominal . ' (' . $requestOrder->discountType2Literal . ')'; ?>
                                    <?php elseif($requestOrder->discount_step == 3): ?>
                                        <?php echo $requestOrder->discount1_nominal . ' (' . $requestOrder->discountType1Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount2_nominal . ' (' . $requestOrder->discountType2Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount3_nominal . ' (' . $requestOrder->discountType3Literal . ')'; ?>
                                    <?php elseif($requestOrder->discount_step == 4): ?>
                                        <?php echo $requestOrder->discount1_nominal . ' (' . $requestOrder->discountType1Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount2_nominal . ' (' . $requestOrder->discountType2Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount3_nominal . ' (' . $requestOrder->discountType3Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount4_nominal . ' (' . $requestOrder->discountType4Literal . ')'; ?>
                                    <?php elseif($requestOrder->discount_step == 5): ?>
                                        <?php echo $requestOrder->discount1_nominal . ' (' . $requestOrder->discountType1Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount2_nominal . ' (' . $requestOrder->discountType2Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount3_nominal . ' (' . $requestOrder->discountType3Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount4_nominal . ' (' . $requestOrder->discountType4Literal . ') || '; ?>
                                        <?php echo $requestOrder->discount5_nominal . ' (' . $requestOrder->discountType5Literal . ')'; ?>
                                    <?php else: ?>
                                        <?php echo "0"; ?>
                                    <?php endif ?>
                                </td>
                                <td><?php echo number_format($requestOrder->last_buying_price,0); ?></td>
                                <td><?php echo number_format($requestOrder->retail_price,0); ?></td>
                                <td><?php echo number_format($requestOrder->unit_price,0); ?></td>
                                <td><?php echo number_format($requestOrder->total_price,0); ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <?php $unit = Unit::model()->findByPk($requestOrder->unit_id); ?>
                                    Manufacture Code: <?php echo CHtml::Encode(CHtml::value($requestOrder, 'product.manufacturer_code')); ?> ||
                                    Category: <?php echo CHtml::Encode(CHtml::value($requestOrder, 'product.masterSubCategoryCode')); ?> ||
                                    Brand: <?php echo CHtml::Encode(CHtml::value($requestOrder, 'product.brand.name')); ?> ||
                                    Sub Brand: <?php echo CHtml::Encode(CHtml::value($requestOrder, 'product.subBrand.name')); ?> ||
                                    Brand Series: <?php echo CHtml::Encode(CHtml::value($requestOrder, 'product.subBrandSeries.name')); ?> ||
                                    Unit: <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                                </td>
                                <td style="text-align: right" colspan="2">Total Qty</td>
                                <td style="text-align: center"><?php echo $requestOrder->total_quantity; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    <?php else: ?>
        <?php echo "NO SUPPLIER" ?>
    <?php endif; ?>
<?php endforeach; ?>

