<table class="items">
	<thead>
		<tr>
			<th>Service</th>
			<th>Damage Type</th>
			<th>Vehicle Type</th>
			<th>Price</th>
			<th>Action</th>
			<!-- <th></th> -->
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
		</thead>
		<tbody >
			
			<?php //print_r($insurance->priceDetail) ?>
			<?php foreach ($insurance->priceDetails as $i => $priceDetail): ?>
				<tr>
					
					<td>
						
						<?php echo CHtml::activeHiddenField($priceDetail,"[$i]service_id"); ?>
						
						<?php $service = Service::model()->findByPK($priceDetail->service_id); ?>
						<?php echo $service->serviceType->name; ?><br>
						<?php echo $service->serviceCategory->name; ?><br>
						<?php echo $service->name; ?>
						<?php //echo CHtml::activeTextField($priceDetail,"[$i]service_name",array('value'=>$priceDetail->service_id!= '' ? $service->name : '','readonly'=>true )); ?>
						<?php //echo CHtml::activeDropDownList($priceDetail,"[$i]service_id", CHtml::listData(Service::model()->findAll(array('order'=>'name')),'id','name'),array('prompt'=>'[--Select Service--]')); ?></td>
						<td><?php echo CHtml::activeDropDownList($priceDetail, "[$i]damage_type", array('Easy' => 'Easy',
							'Medium' => 'Medium','Hard'=>'Hard' )); ?></td>
						<td><?php echo CHtml::activeDropDownList($priceDetail, "[$i]vehicle_type", array('Common' => 'Common',
							'Lux' => 'Lux','Super Lux'=>'Super Lux' )); ?></td>
							<td>
								<?php echo CHtml::activeTextField($priceDetail,"[$i]price"); ?>
							</td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemovePriceDetail', array('id' => $insurance->header->id, 'index' => $i)),
							       	'update' => '#price',
					      		)),
					     	));
				     	?>
				     </td> 
				 </tr>
				<?php endforeach ?>
				
			</tbody>
		</table>