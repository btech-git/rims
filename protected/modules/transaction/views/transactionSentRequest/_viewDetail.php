<?php if (count($sentDetails)>0): ?>
		<table>
			<thead>
				<tr>
					<td>Product</td>
					<td>Code</td>
					<td>Kategori</td>
					<td>Brand</td>
					<td>Sub Brand</td>
					<td>Sub Brand Series</td>
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
						<td><?php echo $sentDetail->product ? $sentDetail->product->manufacturer_code : '-'; ?></td>
						<td><?php echo $sentDetail->product ? $sentDetail->product->masterSubCategoryCode : '-'; ?></td>
						<td><?php echo $sentDetail->product ? $sentDetail->product->brand->name : '-'; ?></td>
						<td><?php echo $sentDetail->product ? $sentDetail->product->subBrand->name : '-'; ?></td>
						<td><?php echo $sentDetail->product ? $sentDetail->product->subBrandSeries->name : '-'; ?></td>
						<td><?php echo $sentDetail->quantity; ?></td>
						<td><?php echo $sentDetail->unit->name; ?></td>
						<td><?php echo $this->format_money($sentDetail->unit_price); ?></td>
						<td><?php echo $this->format_money($sentDetail->amount); ?></td>
						
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>

	<?php else: ?>
		<?php echo "No Detail Available!"; ?>
	<?php endif ?>