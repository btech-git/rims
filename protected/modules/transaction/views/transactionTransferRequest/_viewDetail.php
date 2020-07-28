<?php if (count($transferDetails)>0): ?>
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
				<?php foreach ($transferDetails as $key => $transferDetail): ?>
					<tr>
						<td><?php echo $transferDetail->product ? $transferDetail->product->name : '-'; ?></td>
						<td><?php echo $transferDetail->quantity; ?></td>
						<td><?php echo $this->format_money($transferDetail->unit_price); ?></td>
						<td><?php echo $transferDetail->unit_id; ?></td>
						<td><?php echo $transferDetail->amount; ?></td>
						
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

	<?php else: ?>
		<?php echo "No Detail Available!"; ?>
	<?php endif ?>