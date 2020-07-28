<?php if (count($sentDetails)>0): ?>
		<table>
			<thead>
				<tr>
					<td>Product</td>
					<td>Quantity</td>
					<td>Unit Price (HPP)</td>
					<td>Unit</td>
					<td>Amount</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($sentDetails as $key => $sentDetail): ?>
					<tr>
						<td><?php echo $sentDetail->product ? $sentDetail->product->name : '-'; ?></td>
						<td style="text-align: center"><?php echo $sentDetail->quantity; ?></td>
						<td style="text-align: right"><?php echo $this->format_money($sentDetail->unit_price); ?></td>
						<td><?php echo $sentDetail->unit->name; ?></td>
						<td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $sentDetail->amount)); ?></td>
						
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

	<?php else: ?>
		<?php echo "No Detail Available!"; ?>
	<?php endif ?>