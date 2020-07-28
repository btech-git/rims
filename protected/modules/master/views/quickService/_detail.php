<table class="items">
	<thead>
		<tr>
			<th>Service</th>
			<th>Price</th>
			<th>Discount Price</th>
			<th>Final Price</th>
			<th>Hour</th>
		</tr>
	</thead>
	<tbody >

		<?php //print_r($insurance->priceDetail) ?>
		<?php foreach ($quickService->details as $i => $detail): ?>
			<tr>
				<td>
					<?php echo CHtml::activeHiddenField($detail,"[$i]service_id"); ?>
					<?php $service = Service::model()->findByPK($detail->service_id); ?>
					<?php echo $service->serviceType->name; ?><br>
					<?php echo $service->serviceCategory->name; ?><br>
					<?php echo $service->name; ?>
					<?php //echo CHtml::activeTextField($priceDetail,"[$i]service_name",array('value'=>$priceDetail->service_id!= '' ? $service->name : '','readonly'=>true )); ?>
					<?php //echo CHtml::activeDropDownList($priceDetail,"[$i]service_id", CHtml::listData(Service::model()->findAll(array('order'=>'name')),'id','name'),array('prompt'=>'[--Select Service--]')); ?>
				</td>
				<td>
					<?php echo CHtml::activeTextField($detail,"[$i]price",array('readonly'=>true)); ?>
				</td>
				<td>
					<?php echo CHtml::activeTextField($detail,"[$i]discount_price"); ?>
				</td>
				<td width="230px">

					<div style="display:inline-block; vertical-align: middle;">
						<?php echo CHtml::activeTextField($detail,"[$i]final_price",array('readonly'=>true,'style'=>'width:130px;display:inline-block;')); ?>

						<?php 
						echo CHtml::button('Count', array(
							'id' => 'count',
							'style'=>'display:inline-block;',
							'onclick' =>'
							var price = +jQuery("#QuickServiceDetail_'.$i.'_price").val();
							var discount = +jQuery("#QuickServiceDetail_'.$i.'_discount_price").val();
							var total = price - discount;
							if(total<0)
							{
								alert ("Discount could not bigger than Price");
								jQuery("#QuickServiceDetail_'.$i.'_discount_price").val();
								jQuery("#QuickServiceDetail_'.$i.'_final_price").val();
							}
							else
							{
								jQuery("#QuickServiceDetail_'.$i.'_final_price").val(total);
							}
							',

							)
						); 
						?>
					</div>
					
				</td>
				<td>
					<?php echo CHtml::activeTextField($detail,"[$i]hour",array('readonly'=>true)); ?>
				</td>
						<?php /*<td>
							<?php
						    // echo CHtml::button('X', array(
						    //  	'onclick' => CHtml::ajax(array(
							   //     	'type' => 'POST',
							   //     	'url' => CController::createUrl('ajaxHtmlRemovePriceDetail', array('id' => $insurance->header->id, 'index' => $i)),
							   //     	'update' => '#price',
					     //  		)),
					     // 	));
				     	?>
				     </td> */?>
				 </tr>
				<?php endforeach ?>
				
			</tbody>
		</table>