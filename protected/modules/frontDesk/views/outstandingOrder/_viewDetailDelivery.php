<?php $deliveries = TransactionDeliveryOrder::model()->findAllByAttributes(array('sales_order_id'=>$model->id));
	if(count($deliveries)!=0){ ?>
	<?php foreach ($deliveries as $key => $delivery): ?>
	<table>
		<tr>
			<td width="10%">Delivery Order No</td>
			<td><?php echo $delivery->delivery_order_no; ?></td>
		</tr>
		<tr>
			<td width="10%">Sender Branch</td>
			<td><?php echo $delivery->senderBranch->name; ?></td>
		</tr>
		<tr>
			<td  width="10%">Date Posting</td>
			<td><?php echo $delivery->delivery_date; ?></td>
		</tr>
		<tr>
			<td colspan="2">
				<table>
					<thead>
						<tr>
							<td>Product</td>
							<td>Brand</td>
							<td>Sub Brand</td>
							<td>Sub Brand Series</td>
							<td>Master Category</td>
							<td>Sub Master Category</td>
							<td>Sub Category</td>
							<td>QTY Request</td>
							<td>QTY Delivery</td>
							<td>QTY LEFT</td>
							<td>Note</td>
							<td>Barcode Product</td>
						</tr>
					</thead>
					<tbody>
                        <?php $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id'=>$delivery->id)); ?>
                        <?php foreach($deliveryDetails as $deliveryDetail) :?>
							<tr>
								<td><?php echo $deliveryDetail->product->name; ?></td>
                                <td><?php echo $deliveryDetail->product->brand->name; ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.subBrand.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($deliveryDetail, 'product.subBrandSeries.name')); ?></td>
                                <td><?php echo $deliveryDetail->product->productMasterCategory->name; ?></td>
                                <td><?php echo $deliveryDetail->product->productSubMasterCategory->name; ?></td>
                                <td><?php echo $deliveryDetail->product->productSubCategory->name; ?></td>
								<td><?php echo $deliveryDetail->quantity_request; ?></td>
								<td><?php echo $deliveryDetail->quantity_delivery; ?></td>
								<td><?php echo $deliveryDetail->quantity_request_left; ?></td>
								<td><?php echo $deliveryDetail->note; ?></td>
								<td><?php echo $deliveryDetail->barcode_product; ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
<?php endforeach ?>
<?php
	}
			else {
				echo "NO RECEIVE HISTORY FOUND.";
			}
		?>