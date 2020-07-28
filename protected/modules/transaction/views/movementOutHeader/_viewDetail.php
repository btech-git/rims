<fieldset>
			<legend>Details</legend>

			<table>
				<thead>
					<tr>
						<th>Product</th>
                        <th>Code</th>
                        <th>Kategori</th>
                        <th>Brand</th>
                        <th>Sub Brand</th>
                        <th>Sub Brand Series</th>
						<th>Warehouse</th>
						<th>Quantity Transaction</th>
						<th>Quantity</th>
						<th>Quantity On warehouse</th>
						<th>Status</th>
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
							<td><?php echo $detail->warehouse == "" ? "" : $detail->warehouse->name ?></td>
							<td><?php echo $detail->quantity_transaction; ?></td>
							<td><?php echo $detail->quantity; ?></td>
							<?php $stockInventory = Inventory::model()->findByAttributes(array('product_id'=>$detail->product_id,'warehouse_id'=>$detail->warehouse_id)); ?>
							<td><?php echo count($stockInventory)!= 0 ? $stockInventory->total_stock : ''; ?></td>
							<td><?php echo empty($stockInventory) ? 'N/A' : $stockInventory->total_stock > $detail->quantity ? 'V' : 'X'; ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</fieldset>	