<table class="items">
			<thead>
			<tr>
				<th colspan="2">Checklist Module</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($checklistType->checklistModuleDetails as $i => $checklistModuleDetail): ?>
					<tr>
						<td>
							<?php echo CHtml::activeHiddenField($checklistModuleDetail,"[$i]checklist_module_id"); ?>
							<?php $checklistModuleName = InspectionChecklistModule::model()->findByPK($checklistModuleDetail->checklist_module_id); ?>
							<?php //echo CHtml::activeTextField($checklistModuleDetail,"[$i]checklist_module_id"); ?>
							<?php echo CHtml::activeTextField($checklistModuleDetail,"[$i]checklist_module_name",array('value'=>$checklistModuleDetail->checklist_module_id != '' ? $checklistModuleName->name : '','readonly'=>true )); ?>
						</td>
						<td>
							<?php
						    /*echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveChecklistModuleDetail', array('id' => $checklistType->header->id, 'index' => $i)),
							       	'update' => '#checklistModule',
					      		)),
					     	));*/
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>