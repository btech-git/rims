<?php foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenance): ?>
	<?php //echo $i; ?>
		<div class="field">
			<div class="row collapse">
					<div class="small-6 columns">
					  <label class="prefix">Equipment Task</label>
					</div>
					<div class="small-6 columns">
						<?php echo CHtml::activeDropDownList($equipmentMaintenance, "[$i]equipment_task_id", CHtml::listData(EquipmentTask::model()->findAllByAttributes(array('equipment_id'=>$equipmentBranch->header->equipment_id)), 'id', 'task'),array(
										'prompt' => '[--Select Equipment Task--]','class'=>'sel_task'));?>
					</div>
				
			</div>
		</div>
		
		<div class="field">
			<div class="row collapse">
				<div class="small-6 columns">
					<label class="prefix">Employee</label>
				</div>
				<div class="small-6 columns">
					<?php echo CHtml::activeDropDownList($equipmentMaintenance, "[$i]employee_id", CHtml::listData(Employee::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Employee--]'));?>
										
				</div>
			</div>
		</div>

		<div class="field">
			<div class="row collapse">
				<div class="small-6 columns">
					<label class="prefix">Maintenance Date</label>
				</div>
				<div class="small-6 columns">
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $equipmentMaintenance,
											 'attribute' => "[$i]maintenance_date",
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
																url: "' . CController::createUrl('AjaxGetNext').'/maintenance_date/"+$(this).val()+"/selected_task/"+$(".sel_task option:selected").val(),
																data: jQuery("form").serialize(),
																success: function(data){
																	//alert(data)
																	//alert("#EquipmentMaintenance_'.$i.'_next_maintenance_date")
																	jQuery("#EquipmentMaintenance_'.$i.'_next_maintenance_date").val(data);
																	},
															});',
											),	
											));?>
										
				</div>
			</div>
		</div>
		
		<div class="field">
			<div class="row collapse">
				<div class="small-6 columns">
					<label class="prefix">Next Maintenance Date</label>
				</div>
				<div class="small-6 columns">
					<?php echo CHtml::ActiveTextField($equipmentMaintenance, "[$i]next_maintenance_date");?>
					<?php //echo CHtml::activeTextField($equipmentMaintenance,"[$i]name",array('size'=>30,'maxlength'=>30)); ?>					
				</div>
			</div>
		</div>
		
		<div class="field">
			<div class="row collapse">
				<div class="small-6 columns">
					<label class="prefix">Notes</label>
				</div>
				<div class="small-6 columns">
					<?php echo CHtml::ActiveTextArea($equipmentMaintenance, "[$i]notes");?>
				</div>
			</div>
		</div>
		
		<div class="field">
			<div class="row collapse">
				<div class="small-6 columns">
					<label class="prefix">Condition</label>
				</div>
				<div class="small-6 columns">
					<?php echo CHtml::ActiveTextField($equipmentMaintenance, "[$i]condition");?>
				</div>
			</div>
		</div>
		
		<div class="field">
			<div class="row collapse">
				<div class="small-6 columns">
					<label class="prefix">Checked</label>
				</div>
				<div class="small-6 columns">
					<?php echo CHtml::ActivedropDownList($equipmentMaintenance, "[$i]checked", array('checked' => 'Checked',
									'not-checked' => 'Unchecked', )); ?>
				</div>
			</div>
		</div>
		<?php
			echo CHtml::button('X', array(
				'class' =>'button extra right',
				'onclick' => CHtml::ajax(array(
					'type' => 'POST',
					'url' => CController::createUrl('ajaxHtmlRemoveMaintenanceDetail', array('id' => $equipmentBranch->header->id, 'index' => $i)),
					'update' => '#task',
				)),
			));
		?>
	<?php endforeach; ?>
	<br/>
			