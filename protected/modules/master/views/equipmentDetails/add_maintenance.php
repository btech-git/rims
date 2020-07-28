<?php
	 $todays_month_year = date('Y-m');
	foreach ($equipmentDetails->equipmentMaintenances as $i => $equipmentMaintenance): ?>
	<tr>
		<td><?php  echo $j+1; 
				   $taskClass = 'task_'.$j.'_class'; 
				   ?></td>
		<?php echo CHtml::activeHiddenField($equipmentMaintenance,"[$j]equipment_task_id", array('class'=>$taskClass,'value'=>$task_id)); ?>
		<?php echo CHtml::activeHiddenField($equipmentMaintenance,"[$j]equipment_id", array('value'=>$equipment_id)); ?>
		<?php echo CHtml::activeHiddenField($equipmentMaintenance,"[$j]equipment_detail_id", array('value'=>$equipmentDetails->header->id)); ?>
		<td><?php echo CHtml::activeDropDownList($equipmentMaintenance, "[$j]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
								'prompt' => '[--Select Employee--]'),array('size'=>35,'value'=> $equipmentMaintenance->employee_id != "" ? $equipmentMaintenance->employee->name : ''));?></td>
		<td><?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
									'model' => $equipmentMaintenance,
									 'attribute' => "[$j]maintenance_date",
									 // additional javascript options for the date picker plugin
									 'options'=>array(
										'dateFormat' => 'yy-mm-dd',
										'changeMonth'=>true,
										 'changeYear'=>true,
										 'yearRange'=>'1900:2020',
									),	
									'htmlOptions'=>array(
										'onchange'=>  'jQuery.ajax({
														type: "POST",
														//dataType: "JSON",
														url: "' . CController::createUrl('AjaxGetNext').'/maintenance_date/"+$(this).val()+"/selected_task/"+$(".'.$taskClass.'").val(),
														data: jQuery("form").serialize(),
														success: function(data){
															jQuery("#EquipmentMaintenances_'.$j.'_next_maintenance_date").val(data);
															},
													});',
									),	
									));?>
		</td>						
		<td><?php echo CHtml::ActiveTextField($equipmentMaintenance, "[$j]next_maintenance_date");?>
		</td>
		<td>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
									'model' => $equipmentMaintenance,
									 'attribute' => "[$j]check_date",
									 // additional javascript options for the date picker plugin
									 'options'=>array(
										'dateFormat' => 'yy-mm-dd',
										'changeMonth'=>true,
										 'changeYear'=>true,
										 'yearRange'=>'1900:2020',
									)));?>
		</td>
		<td><?php echo CHtml::ActiveTextArea($equipmentMaintenance, "[$j]notes");?>
		</td>
		<td>
		<?php echo  CHtml::ActiveDropDownList($equipmentMaintenance, "[$j]equipment_condition", 
										array('Good' => 'Good',
											  'Bad' => 'Bad',
											  'Check' => 'Need Further Check',
											  'Replacement' => 'Need Replacement')); ?>
		</td>
		<td><?php echo CHtml::ActiveDropDownList($equipmentMaintenance, "[$j]checked", array('checked' => 'Checked',
							'not-checked' => 'Unchecked', )); ?>
		</td>
	</tr>
<?php 
endforeach; ?>