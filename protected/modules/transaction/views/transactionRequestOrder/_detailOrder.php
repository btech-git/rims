<?php $orders = TransactionDetailOrder::model()->findAllByAttributes(array('purchase_request_detail_id'=>$detail->id)); ?>
<?php if(count($orders)>0){?>
	<table>
		<thead>
			<tr>
				<td>PO No</td>
				<td>PO Quantity</td>
				<td>PO Quantity Left</td>
				<td>Estimate Date Arrival</td>
				<td>Unit Price</td>
				<td>Total Price</td>
				<td>Supplier</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($orders as $key => $order): ?>
				<tr>
					<td><?php echo $order->purchase_order_id; ?></td>
					<td><?php echo $order->purchase_order_quantity; ?></td>
					<td><?php echo $order->purchase_order_quantity_left; ?></td>
					<td><?php echo $order->purchase_order_estimate_arrival_date; ?></td>
					<td><span class="numbers"><?php echo $order->unit_price; ?></span></td>
					<td><span class="numbers"><?php echo $order->total_price; ?></span></td>
					<td><?php echo $order->supplier_id; ?></td>
				</tr>
			<?php endforeach ?>
			
		</tbody>
		
	</table>
<?php
	}
			else {
				echo "NO PURCHASE ORDER FOUND.";
			}
		?>