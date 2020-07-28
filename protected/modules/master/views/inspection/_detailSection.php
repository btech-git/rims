<table class="items">
			<thead>
			<tr>
				<th colspan="2">Section</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
			</thead>
			<tbody >
			
			
				<?php foreach ($inspection->sectionDetails as $i => $sectionDetail): ?>
					<tr>
						<td>
							<?php echo CHtml::activeHiddenField($sectionDetail,"[$i]section_id"); ?>
							<?php $sectionName = InspectionSection::model()->findByPK($sectionDetail->section_id); ?>
							<?php //echo CHtml::activeTextField($checklistModuleDetail,"[$i]checklist_module_id"); ?>
							<?php echo CHtml::activeTextField($sectionDetail,"[$i]section_name",array('value'=>$sectionDetail->section_id != '' ? $sectionName->name : '','readonly'=>true )); ?>
						</td>
						<td>
							<?php
						    /*echo CHtml::button('X', array(
						     	'onclick' => CHtml::ajax(array(
							       	'type' => 'POST',
							       	'url' => CController::createUrl('ajaxHtmlRemoveSectionDetail', array('id' => $inspection->header->id, 'index' => $i)),
							       	'update' => '#section',
					      		)),
					     	));*/
				     	?>
						</td>

					</tr>
				<?php endforeach ?>
				
			</tbody>
			</table>