<?php 
	$poRequest = TransactionPurchaseOrderDetailRequest::model()->findByAttributes(array('purchase_request_id'=>$model->id));
	$poDetail = TransactionPurchaseOrderDetail::model()->findByPK($poRequest->purchase_order_detail_id);
	$receive = TransactionReceiveItem::model()->findByAttributes(array('purchase_order_id'=>$poDetail->purchase_order_id));
?>

<table>
	<tr>
			<td width="10%">Receive Item No</td>
			
			<td width="90%"><?php echo $receive->receive_item_no; ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<?php $receiveDetails= TransactionReceiveItemDetail::model()->findAllByAttributes(array('receive_item_id'=>$receive->id));?>
			<table>
				<thead>
					<tr>
						<td>Product</td>
						<td>Quantity</td>
						<td>Qty Good</td>
						<td>Qty Reject</td>
						<td>Qty More</td>
						<td>Qty Request Left</td>	
						<td>Notes</td>
						<td>Barcode Product</td>
					</tr>
				</thead>
				<tbody>
						<?php foreach ($receiveDetails as $key => $receiveDetail): ?>

					<tr>
						<td><?php echo $receiveDetail->product->name; ?></td>
						<td><?php echo $receiveDetail->qty_request; ?></td>
						<td><?php echo $receiveDetail->qty_good; ?></td>
						<td><?php echo $receiveDetail->qty_reject; ?></td>
						<td><?php echo $receiveDetail->qty_more; ?></td>
						<td><?php echo $receiveDetail->qty_request_left; ?></td>
						<td><?php echo $receiveDetail->note; ?></td>
						<td><?php echo $receiveDetail->barcode_product; ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</td>
	</tr>
</table>
