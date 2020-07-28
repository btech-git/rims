<table class="items">
			<thead>
			<tr>
				<th colspan="2">Equipment</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($service->equipmentDetails as $i => $equipmentDetail): ?>
					<tr>
						<td><?php echo CHtml::activeHiddenField($equipmentDetail,"[$i]equipment_id"); ?>
						<?php $equipment = Equipments::model()->findByPK($equipmentDetail->equipment_id); ?>
						<?php echo CHtml::activeTextField($equipmentDetail,"[$i]equipment_name",array('value'=>$equipmentDetail->equipment_id!= '' ? $equipment->name : '','readonly'=>true )); ?></td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveEquipmentDetail', array('id' => $service->header->id, 'index' => $i)),
							       	'update' => '#equipment',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>