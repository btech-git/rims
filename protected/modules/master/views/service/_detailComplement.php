<table class="items">
			<thead>
			<tr>
				<th colspan="2">Service Complement</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
				
				<?php foreach ($service->complementDetails as $i => $complementDetail): ?>
				
					<tr>
						<td><?php echo CHtml::activeHiddenField($complementDetail,"[$i]complement_id"); ?>
						<?php $service = Service::model()->findByPK($complementDetail->complement_id); ?>
						<?php echo CHtml::activeTextField($complementDetail,"[$i]complement_name",array('value'=>$complementDetail->complement_id!= '' ? $service->name : '','readonly'=>true )); ?></td>
						
						

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>