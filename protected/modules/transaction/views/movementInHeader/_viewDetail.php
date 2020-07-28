<fieldset>
			<legend>Details</legend>

			<table>
				<thead>
					<tr>
						<th>Code</th>
						<th>Product Name</th>
						<th>Category</th>
						<th>Brand</th>
						<th>Sub Brand</th>
						<th>Sub Brand Series</th>
						<th>Qty Transaction</th>
						<th>Qty Movement</th>
						<th>Warehouse</th>
						
					</tr>
				</thead>
				<tbody>
					<?php foreach ($details as $key => $detail): ?>
						<tr>
							<td><?php echo $detail->product->manufacturer_code; ?></td>
							<td><?php echo $detail->product->name; ?></td>
							<td><?php echo $detail->product->masterSubCategoryCode; ?></td>
							<td><?php echo $detail->product->brand->name; ?></td>
							<td><?php echo $detail->product->subBrand->name; ?></td>
							<td><?php echo $detail->product->subBrandSeries->name; ?></td>
							<td><?php echo $detail->quantity_transaction; ?></td>
							<td><?php echo $detail->quantity; ?></td>
							<td><?php echo $detail->warehouse == "" ? "" : $detail->warehouse->name ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</fieldset>	