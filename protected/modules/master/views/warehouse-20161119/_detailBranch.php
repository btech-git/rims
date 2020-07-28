<table class="items">
			<thead>
			<tr>
				<th colspan="2">Branch</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($warehouse->branchDetails as $i => $branchDetail): ?>
					<tr>
						<td><?php echo CHtml::activeHiddenField($branchDetail,"[$i]branch_id"); ?>
						<?php $branch = Branch::model()->findByPK($branchDetail->branch_id); ?>
						<?php echo CHtml::activeTextField($branchDetail,"[$i]branch_name",array('value'=>$branchDetail->branch_id!= '' ? $branch->name : '','readonly'=>true )); ?></td>
						<!--<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveBranchDetail', array('id' => $warehouse->header->id, 'index' => $i)),
							       	'update' => '#branch',
					      		)),
					     	));
				     	?>
						</td>-->

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>