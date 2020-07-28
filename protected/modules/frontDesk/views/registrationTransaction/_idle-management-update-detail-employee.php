<table class="items">
			<thead>
			<tr>
				<th colspan="2">Employee</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($registrationService->employeeDetails as $i => $employeeDetail): ?>
					<tr>
						<td>
							<?php echo CHtml::activeHiddenField($employeeDetail,"[$i]employee_id"); ?>
							<?php $employeeName = Employee::model()->findByPK($employeeDetail->employee_id); ?>
							<?php //echo CHtml::activeTextField($checklistModuleDetail,"[$i]checklist_module_id"); ?>
							<?php echo CHtml::activeTextField($employeeDetail,"[$i]employee_name",array('value'=>$employeeDetail->employee_id != '' ? $employeeName->name : '','readonly'=>true )); ?>
						</td>
						<td>
							<?php
						    echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveEmployeeDetail', array('id' => $registrationService->header->id, 'index' => $i)),
							       	'update' => '#employee',
					      		)),
					     	));
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>