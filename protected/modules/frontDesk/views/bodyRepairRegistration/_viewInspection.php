<?php if($model->work_order_number != ""): ?>
	<?php $inspections = VehicleInspection::model()->findAllByAttributes(array('work_order_number'=>$model->work_order_number)); ?>
	<?php if(count($inspections) > 0): ?>
				
						<?php foreach ($inspections as $i => $inspection): ?>
							<h1>Inspection Date <?php echo $inspection->inspection_date ?></h1>
								<h2>Vehicle Report</h2>
									<div class="grid-view" id="vehicleReport" >
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
														<?php foreach ($inspection->vehicleInspectionDetails as $i => $vehicleInspectionDetail): ?>
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

																foreach ($checklistTypeModules as $key => $checklistTypeModule) {							
																	if($checklistTypeModule->checklistType->type == "Radio"){
																		if($vehicleInspectionDetail->checklist_module_id == $checklistTypeModule->checklistModule->id){
																			$checked = 'checked';
																		} else {
																			$checked = '';
																		}

																		$radio .= '<input id="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '" class="' . strtolower($checklistTypeModule->checklistModule->color_indicator) . '" value="' . $checklistTypeModule->checklistModule->id . '" ' . $checked . ' disabled name="VehicleInspectionDetail[' . $i . '][checklist_module_id]" type="radio">' . CHtml::activeLabel($vehicleInspectionDetail, "[$i]checklist_module_id", array('label' => $checklistTypeModule->checklistType->show_label == 'Yes' ? $checklistTypeModule->checklistModule->name : '', 'style'=>'display:inline')) . '<label style="display:inline;" for="VehicleInspectionDetail_' . $i . '_checklist_module_id_' . $i . '"></label>';
																		
																	} else {
																		$text .= CHtml::activeTextField($vehicleInspectionDetail,"[$i]value",array("disabled"=>"disabled")) . CHtml::activeHiddenField($vehicleInspectionDetail,"[$i]checklist_module_id", array('value'=>$checklistTypeModule->checklistModule->id));
																	}
																}
																$radio .= '</span>';

																if($radio != '<span id="VehicleInspectionDetail_' . $i . '_checklist_module_id"></span>'){
																	echo $radio . $vehicleInspectionDetail->module->name . CHtml::error($vehicleInspectionDetail,"[$i]checklist_module_id") . '<br />';
																}

																if($text != ''){
																	echo "<span>" . $vehicleInspectionDetail->module->name . "</span>" .  $text . "<br />";
																}

															?>
															
														<?php endforeach ?>
														
													
										<div class="clearfix"></div><div style="display:none" class="keys"></div>
									</div>
							
						<?php endforeach ?>
				
	<?php else: ?>
		<?php echo "NO HISTORY"; ?>
	<?php endif ?>
	<?php endif ?>