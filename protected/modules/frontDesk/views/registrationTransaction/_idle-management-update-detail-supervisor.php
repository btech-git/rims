<table class="items">
			<thead>
			<tr>
				<th colspan="2">Employee</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($registrationService->supervisorDetails as $i => $supervisorDetail): ?>
					<tr>
						<td>
							<?php echo CHtml::activeHiddenField($supervisorDetail,"[$i]supervisor_id"); ?>
							<?php $supervisorName = Employee::model()->findByPK($supervisorDetail->supervisor_id); ?>
							<?php //echo CHtml::activeTextField($checklistModuleDetail,"[$i]checklist_module_id"); ?>
							<?php echo CHtml::activeTextField($supervisorDetail,"[$i]supervisor_name",array('value'=>$supervisorDetail->supervisor_id != '' ? $supervisorName->name : '','readonly'=>true )); ?>
						</td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveSupervisorDetail', array('id' => $registrationService->header->id, 'index' => $i)),
							       	'update' => '#supervisor',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>