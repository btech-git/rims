<?php 
$deliveryOrders = TransactionDeliveryOrder::model()->findAllByAttributes(array('transfer_request_id'=>$model->id));
if(count($deliveryOrders) != 0) {
	foreach ($deliveryOrders as $key => $deliveryOrder) :  ?>
		<table>
		<tr>
			<td width="10%">Delivery Order No</td>
			<td><?php echo $deliveryOrder->delivery_order_no; ?></td>
		</tr>
		<tr>
			<td  width="10%">Date Posting</td>
			<td><?php echo $deliveryOrder->posting_date; ?></td>
		</tr>
		<?php $receives = TransactionReceiveItem::model()->findAllByAttributes(array('delivery_order_id'=>$deliveryOrder->id)); 
			if(count($receives)!= 0) :
				foreach ($receives as $receive) : ?>
				<tr>
					<td colspan="2">
						<table>
							<thead>
								<tr>
									<td>Receive No</td>
									<td>Receive Date</td>
									<td>Product</td>
									<td>QTY Request</td>
									<td>QTY Delivered</td>
									<td>QTY Received</td>									
									<td>QTY Delivered LEFT</td>
									<td>QTY Request LEFT</td>
									<td>Note</td>
									<td>Barcode Product</td>
								</tr>
							</thead>
							<tbody>
                                <?php $receiveDetails = TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id'=>$receive->id)); ?>
                                <?php foreach($receiveDetails as $receiveDetail) :?>
									<tr>
										<td><?php echo $receive->receive_item_no; ?></td>
										<td><?php echo $receive->receive_item_date; ?></td>
										<td><?php echo $receiveDetail->product->name; ?></td>
										<td><?php echo $receiveDetail->qty_request; ?></td>
										<td><?php echo $receiveDetail->quantity_delivered; ?></td>
										<td><?php echo $receiveDetail->qty_received; ?></td>
										<td><?php echo $receiveDetail->quantity_delivered_left; ?></td>
										<td><?php echo $receiveDetail->qty_request_left; ?></td>
										<td><?php echo $receiveDetail->note; ?></td>
										<td><?php echo $receiveDetail->barcode_product; ?></td>
									</tr>
								<?php		endforeach ?>
								
								
							</tbody>
						</table>
						
					</td>
				</tr>
		<?php endforeach; //endforeach receive Item 
		endif //end if count receive				
		?>
		</table>

<?php endforeach ?>

<?php
	}
			else {
				echo "NO RECEIVE HISTORY FOUND.";
			}
		?>