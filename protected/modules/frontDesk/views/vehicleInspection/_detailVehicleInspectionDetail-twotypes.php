<style>
    input[type=radio].red{
		outline: 1px solid red
	}
	input[type=radio].green{
		outline: 1px solid green
	}
	input[type=radio].yellow{
		outline: 1px solid yellow
	}
	input[type=radio].gray{
		outline: 1px solid gray
	}
</style>

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
			<span style="color: green">Checked and Okay At This Time</span> | <span style="color: yellow">May Need Future Attention</span> | <span style="color: red">Requires Immediate Attention<span> | <span style="color: gray">Not Inspected At This Time</span>
		</tr>
		<tr>
			<td>
				<?php foreach ($vehicleInspection->vehicleInspectionDetails as $i => $vehicleInspectionDetail): ?>
					<!-- Start inspection loop -->
					<?php
						if($i==0){
							$section = $vehicleInspectionDetail->section_id;
							echo '<p style="background-color: #aaa">' . $vehicleInspectionDetail->section->name . '<p>';
						}

						$currSection = $vehicleInspectionDetail->section_id;
						
						if($currSection != $section){
							$section = $vehicleInspectionDetail->section_id;
							echo '<p style="background-color: #aaa">' . $vehicleInspectionDetail->section->name . '<p>';
						}

						//Print hidden fields
						echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]section_id",array('value'=>$vehicleInspectionDetail->section_id));
						echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]module_id",array('value'=>$vehicleInspectionDetail->module_id));
						echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_type_id",array('value'=>$vehicleInspectionDetail->checklist_type_id));


						$checklistTypeModules = InspectionChecklistTypeModule::model()->findAllByAttributes(array('checklist_type_id'=>$vehicleInspectionDetail->checklist_type_id));

						$text = '';
						$checked = '';
						$radio = '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id">';
						$radioArray = array();
						foreach ($checklistTypeModules as $key => $checklistTypeModule) {							
							if($checklistTypeModule->checklistType->type == "Radio"){
								if($vehicleInspectionDetail->checklist_module_id == $checklistTypeModule->checklistModule->id){
									$checked = 'checked';
								} else {
									$checked = '';
								}

								$radio .= '<input id="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '" class="' . strtolower($checklistTypeModule->checklistModule->color_indicator) . '" value="' . $checklistTypeModule->checklistModule->id . '" ' . $checked . ' name="VehicleInspectionDetail[' . $i . '][checklist_module_id]" type="radio"><label style="display:inline;" for="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '"></label>';
								$radioArray[$checklistTypeModule->checklistModule->id] = '';
								/*$radio .= CHtml::activeRadioButton($vehicleInspectionDetail,"[$i]checklist_module_id",array('value'=>$checklistTypeModule->checklistModule->id, 'class'=>strtolower($checklistTypeModule->checklistModule->color_indicator))
								) . CHtml::activeLabel($vehicleInspectionDetail, "[$i]checklist_module_id", array('label' => $checklistTypeModule->checklistType->show_label == 'Yes' ? $checklistTypeModule->checklistModule->name : '', 'style'=>'display:inline'));*/
								
								//$radio .= 

							} else {
								$text .= CHtml::activeTextField($vehicleInspectionDetail,"[$i]value") . CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_module_id", array('value'=>$checklistTypeModule->checklistModule->id));
							}
						}
						$radio .= '</span">';


						/*if($radioArray != '' || $radioArray != NULL){
							$vehicleInspectionDetail->checklist_module_radio = $vehicleInspectionDetail->checklist_module_id;
							echo CHtml::activeRadioButtonList($vehicleInspectionDetail,"[$i]checklist_module_id",$radioArray, array(
									'labelOptions'=>array('style'=>'display:inline;'),
									'separator'=>'  ',
									//'onclick'=>'jQuery("#VehicleInspectionDetail_' . $i . '_checklist_module_id").val(jQuery(this).val())',
									
							)) . $vehicleInspectionDetail->module->name . '<br />';
							//echo $radio . $vehicleInspectionDetail->module->name . '<br />';
							//echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]value");
							//echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_module_id");
						}*/

						if($radio != ''){
							echo $radio . $vehicleInspectionDetail->module->name . '<br />';
							//echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]value");
							//echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_module_id");
						}

						if($text != ''){
							//echo CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_module_id");
							echo "<span>" . $vehicleInspectionDetail->module->name . "</span>" .  $text . "<br />";
						}

					?>
					
				<?php endforeach ?>
				
			</td>
		</tr>
	</tbody>
</table>