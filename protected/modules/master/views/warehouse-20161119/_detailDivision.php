<table class="items">
			<thead>
			<tr>
				<th colspan="2">Division</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($warehouse->divisionDetails as $i => $divisionDetail): ?>
					<tr>
						<td><?php echo CHtml::activeHiddenField($divisionDetail,"[$i]division_id"); ?>
						<?php $division = Division::model()->findByPK($divisionDetail->division_id); ?>
						<?php echo CHtml::activeTextField($divisionDetail,"[$i]division_name",array('value'=>$divisionDetail->division_id!= '' ? $division->name : '','readonly'=>true )); ?></td>
						<!--<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveDivisionDetail', array('id' => $warehouse->header->id, 'index' => $i)),
							       	'update' => '#division',
					      		)),
					     	));
				     	?>
						</td>-->

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>