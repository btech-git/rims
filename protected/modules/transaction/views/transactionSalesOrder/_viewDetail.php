<?php //$ccontroller = Yii::app()->controller->id; ?>

<table>
	<thead>
		<tr>
			<tr>
				<th>Product</th>
                <th>Brand</th>
                <th>Sub Brand</th>
                <th>Sub Brand Series</th>
                <th>Category</th>
				<th>Quantity</th>
				<th>Unit</th>
				<th>Discount Step</th>
				<th>Discounts</th>
				<th>Total Qty</th>
				<th>Selling Price</th>
				<th>Unit Price</th>
				<th>Total Price</th>
			</tr>
			
		</tr>
	</thead>
    <?php foreach ($salesOrderDetails as $key => $salesOrderDetail): ?>
		<tr>
			<?php $product = Product::model()->findByPK($salesOrderDetail->product_id); ?>
			<td><?php echo $product->name; ?></td>
			<td><?php echo $product->brand->name; ?></td>
            <td><?php echo CHtml::encode(CHtml::value($product, 'subBrand->name')); ?></td>
            <td><?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries->name')); ?></td>
            <td><?php echo $product->masterSubCategoryCode; ?></td>
			<td><?php echo $salesOrderDetail->quantity; ?></td>
			<td><?php echo $salesOrderDetail->unit_id; ?></td>
			<td><?php echo $salesOrderDetail->discount_step == "" ? '-' : $salesOrderDetail->discount_step; ?></td>
			<td>
                <?php if ($salesOrderDetail->discount_step == 1): ?>
					<?php echo $salesOrderDetail->discount1_nominal; ?>
				<?php elseif($salesOrderDetail->discount_step == 2): ?>
					<?php echo $salesOrderDetail->discount1_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount2_nominal; ?>
				<?php elseif($salesOrderDetail->discount_step == 3): ?>
					<?php echo $salesOrderDetail->discount1_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount2_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount3_nominal; ?>
				<?php elseif($salesOrderDetail->discount_step == 4): ?>
					<?php echo $salesOrderDetail->discount1_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount2_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount3_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount4_nominal; ?>
				<?php elseif($salesOrderDetail->discount_step == 5): ?>
					<?php echo $salesOrderDetail->discount1_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount2_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount3_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount4_nominal. '<br>'; ?>
					<?php echo $salesOrderDetail->discount5_nominal; ?>
				<?php else: ?>
					<?php echo "0"; ?>
				<?php endif ?>
            </td>
			<td><?php echo $salesOrderDetail->total_quantity; ?></td>
			<td style="text-align: right"><?php echo AppHelper::formatMoney($salesOrderDetail->retail_price); ?></td>
			<td style="text-align: right"><?php echo AppHelper::formatMoney($salesOrderDetail->unit_price); ?></td>
			<td style="text-align: right"><?php echo AppHelper::formatMoney($salesOrderDetail->subTotal); ?></td>
		</tr>
    <?php endforeach ?>
    <tr>
        <td colspan="9" style="text-align: right; font-weight: bold">Total Quantity</td>
        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $model->total_quantity)); ?></td>
        <td colspan="2" style="text-align: right; font-weight: bold">Sub Total</td>
        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $model->subtotal)); ?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align: right; font-weight: bold">PPn</td>
        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $model->ppn_price)); ?></td>
    </tr>
    <tr>
        <td colspan="12" style="text-align: right; font-weight: bold">Grand Total</td>
        <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $model->total_price)); ?></td>
    </tr>
</table>
