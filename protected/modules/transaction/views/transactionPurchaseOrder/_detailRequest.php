<table id="detail-request">
	<tr>
		<td>Purchase Request no</td>
		<td>PR Quantity</td>
		<td>ETA</td>
		<td>Branch</td>
		<td>PO Quantity</td>
		<td>Notes</td>
	</tr>
	<?php $prodID = $index;?>
	<?php if ($purchaseOrder->header->isNewRecord): ?>
		<?php foreach ($requestOrderDetails as $j => $requestOrderDetail): ?>
			<tr>	
				<?php $purchaseOrderDetailRequest = new TransactionPurchaseOrderDetailRequest; ?>
				<?php $requestOrder = TransactionRequestOrder::model()->findByPk($requestOrderDetail->request_order_id); ?>
				
				<td>
					<?php echo CHtml::activeHiddenField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_id",array('value'=>$requestOrder->id)); ?>
					<?php echo CHtml::activeHiddenField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_detail_id",array('value'=>$requestOrderDetail->id)); ?>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_name",array('value'=>$requestOrder->request_order_no, 'readOnly' => true)); ?>
				</td>
				<td>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_quantity",array('value'=>$requestOrderDetail->quantity, 'readOnly' => true)); ?>
					
				</td>
				<td>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]estimate_date_arrival",array('value'=>$requestOrderDetail->estimated_arrival_date, 'readOnly' => true)); ?>
					
				</td>
				<td>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_branch_id",array('value'=>$requestOrder->requester_branch_id, 'readOnly' => true)); ?>
					
				</td>
				<td>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_order_quantity",array('class'=>'iniloh_'.$prodID)); ?>
				</td>
				<td>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]notes"); ?>
				</td>
				<td>
					<button type="button" class="btn-delete-row">
						X

					</button>
				</td>


			</tr>
		<?php endforeach ?>
	<?php else: ?>
		<?php $purchaseOrderDetailRequests = TransactionPurchaseOrderDetailRequest::model()->findAllByAttributes(array('purchase_order_detail_id'=>$detail->id));  ?>
		<?php foreach ($purchaseOrderDetailRequests as $j => $purchaseOrderDetailRequest): ?>
			<tr>
				<td><?php echo CHtml::activeHiddenField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_id"); ?>
					<?php echo CHtml::activeHiddenField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_detail_id"); ?>
					<?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_name",array('value'=>$purchaseOrderDetailRequest->purchase_request_id == '' ? '' : $purchaseOrderDetailRequest->purchaseRequest->request_order_no )); ?>
				</td>
				<td><?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_quantity"); ?></td>
				<td><?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]estimate_date_arrival"); ?></td>
				<td><?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_request_branch_id"); ?></td>
				<td><?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]purchase_order_quantity", array('class'=>'iniloh')); ?></td>
				<td><?php echo CHtml::activeTextField($purchaseOrderDetailRequest,"[$detail->product_id][$j]notes"); ?></td>
				<td>
					<button type="button" class="btn-delete-row">
						X
					</button>
				</td>
			</tr>

		<?php endforeach ?>
	<?php endif ?>


</table>
<script type="text/javascript">
	$('#detail-request').on('click','.btn-delete-row',function(){
		$(this).parent().parent().remove();
	});

	$(".iniloh_<?=$prodID?>").change(function() {
		//alert( "Handler for .change() called." );
		var sum = 0;
	     $('.iniloh_<?=$prodID?>').each(function() {
	     	var nilai = isNaN($(this).val()) ? 0 : $(this).val();
	        sum += Number(nilai);
	     });

		// var a = $("[id^=TransactionPurchaseOrderDetailRequest_]").val();
		$("#TransactionPurchaseOrderDetail_<?=$prodID?>_quantity").val(sum);
	});
 
</script>
