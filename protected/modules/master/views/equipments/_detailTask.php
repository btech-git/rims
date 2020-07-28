<?php foreach ($equipment->taskDetails as $i => $taskDetail): ?>
	<?php //echo $i; ?>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label class="prefix">Task</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeTextField($taskDetail,"[$i]task",array('size'=>50,'maxlength'=>50)); ?>				
				</div>
			</div>
		</div>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label class="prefix">Description</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeTextArea($taskDetail,"[$i]description"); ?>				
				</div>
			</div>
		</div>
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					<label class="prefix">Check Period</label>
				</div>
				<div class="small-8 columns">
					<?php echo CHtml::activeDropDownList($taskDetail,"[$i]check_period", array('Daily' => 'Daily',
									'Weekly' => 'Weekly','Monthly'=> 'Monthly','Quarterly'=>'Quarterly','6 Months'=>'6 Months', 'Yearly' => 'Yearly'), array('prompt'=>'[-- Select Period --]')); ?>
				</div>
			</div>
		</div>	
		<div class="field">
			<div class="row collapse">
				<div class="small-4 columns">
					
				</div>
				<div class="small-8 columns">
					<?php
				    echo CHtml::button('X', array(
				    	'class' =>'button extra right',
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemoveTaskDetail', array('id' => $equipment->header->id, 'index' => $i)),
					       	'update' => '#task',
			      		)),
			     	));
		     	?>	
				</div>
			</div>
		</div>	
	

	<?php endforeach; ?>
	<br/>
			