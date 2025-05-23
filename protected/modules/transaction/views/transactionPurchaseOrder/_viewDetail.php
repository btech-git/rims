<?php //$ccontroller = Yii::app()->controller->id; ?>
<table>
    <?php foreach ($purchaseOrderDetails as $key => $purchaseOrderDetail): ?>
        <thead>
            <tr>
                <td>ID</td>
                <td>Product</td>
                <td>Quantity</td>
                <td>Unit</td>
                <td>Discounts Step(s)</td>
                <td>Discounts</td>
                <td>Retail Price</td>
                <td>Unit Price</td>
                <td>Total Price</td>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <?php $product = Product::model()->findByPK($purchaseOrderDetail->product_id); ?>
                <td>
                    <?php if (!Yii::app()->user->checkAccess("director")): ?>
                        <?php echo $product->id; ?>
                    <?php else: ?>
                        <?php echo CHtml::link($product->id, array("/master/product/view", "id"=>$product->id), array('target' => 'blank')); ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $product->name; ?></td>
                <td style="text-align: center"><?php echo $purchaseOrderDetail->quantity; ?></td>
                <td><?php echo $product->unit->name; ?></td>
                <td><?php echo $purchaseOrderDetail->discount_step != ""? $purchaseOrderDetail->discount_step : '-'; ?></td>
                <td>
                    <?php if ($purchaseOrderDetail->discount_step == 1): ?>
                        <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ')'; ?>
                    <?php elseif($purchaseOrderDetail->discount_step == 2): ?>
                        <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ')'; ?>
                    <?php elseif($purchaseOrderDetail->discount_step == 3): ?>
                        <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount3_nominal . ' (' . $purchaseOrderDetail->discountType3Literal . ')'; ?>
                    <?php elseif($purchaseOrderDetail->discount_step == 4): ?>
                        <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount3_nominal . ' (' . $purchaseOrderDetail->discountType3Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount4_nominal . ' (' . $purchaseOrderDetail->discountType4Literal . ')'; ?>
                    <?php elseif($purchaseOrderDetail->discount_step == 5): ?>
                        <?php echo $purchaseOrderDetail->discount1_nominal . ' (' . $purchaseOrderDetail->discountType1Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount2_nominal . ' (' . $purchaseOrderDetail->discountType2Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount3_nominal . ' (' . $purchaseOrderDetail->discountType3Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount4_nominal . ' (' . $purchaseOrderDetail->discountType4Literal . ') || '; ?>
                        <?php echo $purchaseOrderDetail->discount5_nominal . ' (' . $purchaseOrderDetail->discountType5Literal . ')'; ?>
                    <?php else: ?>
                        <?php echo "0"; ?>
                    <?php endif ?>
                </td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->retail_price, 2)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->unit_price, 2)); ?></td>
                <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->total_price, 2)); ?></td>
            </tr>
            <tr>
                <td colspan="9">
                    <?php $unit = Unit::model()->findByPk($purchaseOrderDetail->unit_id); ?>
                    Manufacture Code: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.manufacturer_code')); ?> ||
                    Category: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.masterSubCategoryCode')); ?> ||
                    Brand: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.brand.name')); ?> ||
                    Sub Brand: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.subBrand.name')); ?> ||
                    Brand Series: <?php echo CHtml::Encode(CHtml::value($purchaseOrderDetail, 'product.subBrandSeries.name')); ?> ||
                    Unit: <?php echo CHtml::encode(CHtml::value($unit, 'name')); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:right" colspan="5">Total DPP</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->total_before_tax)); ?>
                </td>
                <td colspan="2" style="text-align:right">DPP</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->price_before_tax)); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:right" colspan="5">Total Quantity</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($purchaseOrderDetail, 'total_quantity'))); ?>
                </td>
                <td  colspan="2" style="text-align:right">PPN</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->tax_amount)); ?>
                </td>
            </tr>
            <tr>
                <td style="text-align:right" colspan="5">Total Discount</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'discount'))); ?>
                </td>
                <td colspan="2" style="text-align:right">Price After Discount</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($purchaseOrderDetail, 'unit_price'))); ?>
                </td>
            </tr>
            <tr>
                <td colspan="8" style="text-align:right">Sub Total (DPP + PPN)</td>
                <td style="text-align:right">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $purchaseOrderDetail->total_price)); ?>
                </td>
            </tr>
        </tbody>
        
        <tfoot>
        </tfoot>
    <?php endforeach; ?>
</table>

<div class="field">
    <div class="row collapse">
        <table>
            <thead>
                <tr>
                    <td style="text-align: center; font-weight: bold">TOTAL QUANTITY</td>
                    <td style="text-align: center; font-weight: bold">PRICE</td>
                    <td style="text-align: center; font-weight: bold">DISCOUNT</td>
                    <td style="text-align: center; font-weight: bold">SUB TOTAL</td>
                    <td style="text-align: center; font-weight: bold">PPN</td>
                    <td style="text-align: center; font-weight: bold">GRAND TOTAL</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->total_quantity)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->price_before_discount)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->discount)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->subtotal)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->ppn_price)); ?>
                    </td>
                    <td style="text-align: right">
                        <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $model->total_price)); ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>