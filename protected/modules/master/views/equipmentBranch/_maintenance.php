<?php
	foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenance): ?>
	<tr>
		<td><?php echo $k = $j+1;?>				
		<?php echo CHtml::activeHiddenField($equipmentMaintenance,"[$k]equipment_task_id", array('class'=>'task_class','value'=>$task_id)); ?>
		</td>
		<td><?php echo CHtml::activeDropDownList($equipmentMaintenance, "[$k]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
								'prompt' => '[--Select Employee--]'),array('size'=>35,'value'=> $equipmentMaintenance->employee_id != "" ? $equipmentMaintenance->employee->name : ''));?></td>
		<td>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
									'model' => $equipmentMaintenance,
									 'attribute' => "[$k]maintenance_date",
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
														url: "' . CController::createUrl('AjaxGetNext').'/maintenance_date/"+$(this).val()+"/selected_task/"+$(".task_class").val(),
														data: jQuery("form").serialize(),
														success: function(data){
																jQuery("#EquipmentMaintenance_'.$k.'_next_maintenance_date").val(data);
															},
													});',
									),	
									));?>
		</td>								
		<td><?php echo CHtml::ActiveTextField($equipmentMaintenance, "[$k]next_maintenance_date");?></td>
		<td><?php echo CHtml::ActiveTextArea($equipmentMaintenance, "[$k]notes");?>
		</td>
		<td><?php echo CHtml::ActiveTextArea($equipmentMaintenance, "[$k]condition");?>
		</td>
		<td><?php echo CHtml::ActivedropDownList($equipmentMaintenance, "[$k]checked", array('checked' => 'Checked',
							'not-checked' => 'Unchecked', )); ?>
		</td>
	</tr>
<?php endforeach; ?>