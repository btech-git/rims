<table class="items">
			<thead>
			<tr>
				<th colspan="2">Position</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($division->positions as $i => $position): ?>
					<tr>
						<td><?php echo CHtml::activeHiddenField($position,"[$i]position_id"); ?>
						<?php $pos_name = Position::model()->findByPK($position->position_id); ?>
						<?php echo CHtml::activeTextField($position,"[$i]position_name",array('value'=>$position->position_id!= '' ? $pos_name->name : '','readonly'=>true )); ?></td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemovePositionDetail', array('id' => $division->header->id, 'index' => $i)),
							       	'update' => '#position',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>