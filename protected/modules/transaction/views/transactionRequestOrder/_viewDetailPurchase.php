

			<?php $purchaseDetails= TransactionPurchaseOrderDetailRequest::model()->findAllByAttributes(array('purchase_request_id'=>$model->id));?>

			<table>
				<thead>
					<tr>
						<td>PO NO</td>
						<td>PO DATE</td>
						<td>Supplier</td>
						<td>PR Quantity</td>
						<td>Product</td>
						<td>Estimate Date Arrival</td>
						<td>R Branch</td>
						<td>PO Quantity</td>
						<td>Notes</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($purchaseDetails as $key => $purchaseDetail): ?>
						<?php $detailPurchase = TransactionPurchaseOrderDetail::model()->findByPK($purchaseDetail->purchase_order_detail_id); ?>
						<?php $purchase = TransactionPurchaseOrder::model()->findByPK($detailPurchase->purchase_order_id); ?>
					<tr>
						<td><?php echo $purchase->purchase_order_no; ?></td>
						<td><?php echo $purchase->purchase_order_date; ?></td>
						<td><?php echo $purchase->supplier->name; ?></td>
						<td><?php echo $purchaseDetail->purchase_request_quantity; ?></td>
						<td><?php echo $detailPurchase->product->name; ?></td>
						<td><?php echo $purchaseDetail->estimate_date_arrival; ?></td>
						<td><?php echo $purchaseDetail->purchase_request_branch_id != "" ? $purchaseDetail->purchaseRequestBranch->name : ''; ?></td>
						<td><?php echo $purchaseDetail->purchase_order_quantity; ?></td>
						<td><?php echo $purchaseDetail->notes; ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		