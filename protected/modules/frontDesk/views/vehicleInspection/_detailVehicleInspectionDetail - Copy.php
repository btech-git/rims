<table class="items">
	<thead>
		<tr>
			<th colspan="2"></th>
			<!-- <th><a href="#" class="sort-link">Level</a></th>
			<th><a href="#" class="sort-link"></a></th> -->
		</tr>
	</thead>
	<tbody >
		<tr>
			<td>
				<?php foreach ($vehicleInspection->vehicleInspectionDetails as $i => $vehicleInspectionDetail): ?>
					<!-- Start inspection loop -->
					<?php

						$inspectionSections = InspectionSections::model()->findAllByAttributes(array('inspection_id'=>$_POST['VehicleInspection']['inspection_id']));

						//var_dump($inspectionSections);

						foreach ($inspectionSections as $key => $inspectionSection) {
							echo $inspectionSection->section->name . "<br />";

							$sectionModules = InspectionSectionModule::model()->findAllByAttributes(array('section_id'=>$inspectionSection->section_id));

							foreach ($sectionModules as $key => $sectionModule) {
								
								

								$checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id'=>$sectionModule->module->checklist_type_id));
								
								$radio = '';
								$text = '';
								
								foreach ($checklistTypeModules as $key => $checklistTypeModule) {
									
									//echo $checklistTypeModule->checklistModule->id;
									if($checklistTypeModule->checklistType->type == "Radio"){
										$radioArray[$checklistTypeModule->checklistModule->id] = '';
										//$radio .= "<input id='VehicleInspectionDetail_" . $i . "_checklist_module_id_" . $key . "' type='radio' name='VehicleInspectionDetail[" . $i . "][checklist_module_id]' value='" . $checklistTypeModule->checklistModule->id . "'><label for='VehicleInspectionDetail_" . $i . "_checklist_module_id_" . $key . "' style='display:inline'> </label>";
									} else {
										$text .= CHtml::activeTextField($vehicleInspectionDetail,"[$i]checklist_module_id", array('name'=>''));
									}
								}
								
								//echo CHtml::activeRadioButtonList($vehicleInspectionDetail,"[$i]checklist_module_id",$radioArray,array('labelOptions'=>array('style'=>'display:inline'),'separator'=>'  ',)) . "<br />";
								//var_dump($radioArray);
								//echo '<input id="ytVehicleInspectionDetail_0_checklist_module_id" type="hidden" name="VehicleInspectionDetail[0][checklist_module_id]" value="">';
								//echo '<span id="VehicleInspectionDetail_0_checklist_module_id">';
								//echo $radio . ' ' . $sectionModule->module->name . "<br />";
								echo CHtml::activeRadioButtonList($vehicleInspectionDetail,"[$sectionModule->id]checklist_module_radio",$radioArray,array('labelOptions'=>array('style'=>'display:inline'),'separator'=>'  ',)) . $sectionModule->module->name . "<br />";

								//echo '</span>';
								echo $text . "<br />";

								echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]section_id");
								echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]module_id");
								echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_type_id");
								echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_module_id");


								
							}
						}


					?>
					
				<?php endforeach ?>
				
			</td>
		</tr>
	</tbody>
</table>