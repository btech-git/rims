
<?php //foreach ($requestDetails as $key => $requestDetail): ?>	
<?php $receive = TransactionReceiveItem::model()->findByAttributes(array('request_type'=>'Purchase Order','supplier_id'=>$purchaseOrder->header->supplier_id,'purchase_order_id'=>$purchaseOrder->header->id)); ?>
<?php if (count($receive) > 0): ?>
<table>
	<tr>
		<td width="10%">Receive Item No</td>
		<td><?php echo $receive->receive_item_no; ?></td>
	</tr>
	<tr>
		<td colspan="2">
			<?php $receiveDetail= TransactionReceiveItemDetail::model()->findByAttributes(array('receive_item_id'=>$receive->id,'product_id'=>$detail->product_id));?>
			<?php if (count($receiveDetail) != 0): ?>
				<table>
				<thead>
					<tr>
						<td>Product</td>
						<td>Quantity</td>
						<td>Qty Received</td>
						<td>Qty Request Left</td>	
						<td>Notes</td>
						<td>Barcode Product</td>
					</tr>
				</thead>
				<tbody>
					<?php //foreach ($receiveDetails as $key => $receiveDetail): ?>

					<tr>
						<td><?php echo $receiveDetail->product->name; ?></td>
						<td><?php echo $receiveDetail->qty_request; ?></td>
						<td><?php echo $receiveDetail->qty_received; ?></td>
						<td><?php echo $receiveDetail->qty_request_left; ?></td>
						<td><?php echo $receiveDetail->note; ?></td>
						<td><?php echo $receiveDetail->barcode_product; ?></td>
					</tr>
					<?php //endforeach ?>
				</tbody>
			</table>
			<?php endif ?>
			
		</td>
	</tr>
</table>
<?php else: ?>
	<?php echo "NO RECEIVE HISTORY FOUND"; ?>
<?php endif ?>

<?php //endforeach ?>