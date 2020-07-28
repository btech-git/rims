<table class="items">
			<thead>
			<tr>
				<th colspan="2">Module</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($section->moduleDetails as $i => $moduleDetail): ?>
					<tr>
						<td>
							<?php echo CHtml::activeHiddenField($moduleDetail,"[$i]module_id"); ?>
							<?php $moduleName = InspectionModule::model()->findByPK($moduleDetail->module_id); ?>
							<?php //echo CHtml::activeTextField($checklistModuleDetail,"[$i]checklist_module_id"); ?>
							<?php echo CHtml::activeTextField($moduleDetail,"[$i]module_name",array('value'=>$moduleDetail->module_id != '' ? $moduleName->name : '','readonly'=>true )); ?>
						</td>
						<td>
							<?php
						    /*echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveModuleDetail', array('id' => $section->header->id, 'index' => $i)),
							       	'update' => '#module',
					      		)),
					     	));*/
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>