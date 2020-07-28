<?php $deliveries = TransactionDeliveryOrder::model()->findAllByAttributes(array('sent_request_id'=>$sentRequest->header->id,'request_type'=>'Sent Request'));
	if(count($deliveries)!=0){ ?>
	<?php foreach ($deliveries as $key => $delivery): ?>
	<table>
		<tr>
			<td width="10%">Delivery Order No</td>
			<td><?php echo $delivery->delivery_order_no; ?></td>
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
							<td>QTY Request</td>
							<td>QTY Delivery</td>
							<td>QTY LEFT</td>
							<td>Note</td>
							<td>Barcode Product</td>
						</tr>
					</thead>
					<tbody>
								<?php $deliveryDetails = TransactionDeliveryOrderDetail::model()->findAllByAttributes(array('delivery_order_id'=>$delivery->id,'product_id'=>$detail->product_id)); ?>
								<?php foreach($deliveryDetails as $deliveryDetail) :?>
							<tr>
								<td><?php echo $deliveryDetail->product_id; ?></td>
								<td><?php echo $deliveryDetail->quantity_request; ?></td>
								<td><?php echo $deliveryDetail->quantity_delivery; ?></td>
								<td><?php echo $deliveryDetail->quantity_request_left; ?></td>
								<td><?php echo $deliveryDetail->note; ?></td>
								<td><?php echo $deliveryDetail->barcode_product; ?></td>
							</tr>
						<?php		endforeach ?>
						
						
					</tbody>
				</table>
				
			</td>
		</tr>
	</table>
<?php endforeach ?>
<?php
	}
			else {
				echo "NO DELIVERY HISTORY FOUND.";
			}
		?>