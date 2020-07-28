<fieldset>
			<legend>Details</legend>

			<table>
				<thead>
					<tr>
						<th>Product</th>
                        <td>Code</td>
                        <td>Kategori</td>
                        <td>Brand</td>
                        <td>Sub Brand</td>
                        <td>Sub Brand Series</td>
						<th>Quantity</th>
						<th>Price</th>
						<th>Total Price</th>
						
					</tr>
				</thead>
				<tbody>
					<?php foreach ($details as $key => $detail): ?>
						<tr>
							<td><?php echo $detail->product->name; ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.masterSubCategoryCode'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name'));  ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name'));  ?></td>
							<td><?php echo $detail->quantity; ?></td>
							<!-- <td><?php //echo $detail->qty_received == "" ? 0 : $detail->qty_received; ?></td>
							<td><?php //echo $detail->qty_request_left; ?></td> -->
							<td>Rp <?php echo $detail->sale_price; ?></td>
							<td>Rp <?php echo $detail->total_price; ?></td>
							
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</fieldset>	