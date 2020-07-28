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
						<th>Received Quantity</th>
						<th>Quantity Left</th>
						<th>Price</th>
						<th>Total Price</th>
						<th>Note</th>
						<th>Barcode Product</th>
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
							<td><?php echo $detail->qty_received == "" ? 0 : $detail->qty_received; ?></td>
							<td><?php echo $detail->qty_request_left; ?></td>
							<td>Rp <?php echo Yii::app()->numberFormatter->format('#,##0', $detail->price); ?></td>
							<td>Rp <?php echo Yii::app()->numberFormatter->format('#,##0', $detail->total_price); ?></td>
							<td><?php echo $detail->note; ?></td>
							<td><?php echo $detail->barcode_product; ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="font-weight: bold; text-align: right">Total Quantity</td>
                        <td style="font-weight: bold; text-align: right"><?php echo CHtml::encode(CHtml::value($model, 'total_quantity'));  ?></td>
                        <td colspan="3" style="font-weight: bold; text-align: right">Total Price</td>
                        <td colspan="3" style="font-weight: bold; text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($model, 'total_price')));  ?></td>
                    </tr>
                </tfoot>
			</table>
		</fieldset>	