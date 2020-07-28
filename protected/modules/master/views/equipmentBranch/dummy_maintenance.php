<?php
/* @var $this EquipmentBranchController */
/* @var $model EquipmentBranch */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipmentBranch/admin';?>"><span class="fa fa-th-list"></span>Manage Equipment Branches</a>
<h1><?php echo "Update Equipment Branch"; ?></h1>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'equipment-branch-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($equipmentBranch); ?>

	<div class="row">
		<div class="small-12 medium-6 columns">   
			
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'branch_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($equipmentBranch->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Branch--]'));?>
						<?php echo $form->error($equipmentBranch->header,'branch_id'); ?>
					</div>
				</div>
			 </div>	
			 
			  <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'equipment_id'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->dropDownList($equipmentBranch->header, 'equipment_id', CHtml::listData(Equipments::model()->findAll(), 'id', 'name'),array(
										'prompt' => '[--Select Equipment--]'));?>
						<?php echo $form->error($equipmentBranch->header,'equipment_id'); ?>
					</div>
				</div>
			 </div>		 
				
			 
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'purchase_date'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
											'model' => $equipmentBranch->header,
											 'attribute' => "purchase_date",
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
																url: "' . CController::createUrl('ajaxGetAge') . '" ,
																data: jQuery("form").serialize(),
																success: function(data){
																	jQuery("#EquipmentBranch_age").val(data);
																},
															});',
													),
										 )); ?>
						<?php echo $form->error($equipmentBranch->header,'purchase_date'); ?>
					</div>
				</div>
			 </div>		 
		       
			 <div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'age'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($equipmentBranch->header,'age',array('placeHolder'=>'how many days old','readOnly'=>'readOnly')); ?>
						<?php echo $form->error($equipmentBranch->header,'age'); ?>
					</div>
				</div>
			 </div>		 
		
			<div class="field">
				<div class="row collapse">
					<div class="small-4 columns">
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'eq_condition'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($equipmentBranch->header,'eq_condition',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($equipmentBranch->header,'eq_condition'); ?>
					</div>
				</div>
			 </div>		 
		
	
	</div>
   
   <hr/>
   
   	<!-- Task form-->
			
			<?php 
				$check_period_tasks = 0;
				$j					= 0;
				$count 				= 1;
				$check_tasks_array  = array();
				foreach($equipmentBrTasks as  $j => $equipmentTasks): 
					$check_tasks_array[$j]['id'] = $equipmentTasks->id;
					$check_tasks_array[$j]['task'] = $equipmentTasks->task;
					switch($equipmentTasks->check_period){							
							case 'Daily':	
										$count= date("t");
										$check_period_tasks = $check_period_tasks+$count;
										$check_tasks_array[$j]['count'] = date("t");
										break;
							case 'Weekly':
										$year = date("Y");
										$month = date("m");
										$start_day_of_week = 1; //monday
										$num_of_days = date("t", mktime(0,0,0,$month,1,$year)); 
											// Count the number of times it hits $start_day_of_week.
										$num_of_weeks = 0;
										for($i=1; $i<=$num_of_days; $i++)
										{
										  $day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
										  if($day_of_week==$start_day_of_week)
											$num_of_weeks++;
										}									 
										$count= $num_of_weeks;	
										$check_tasks_array[$j]['count'] = $num_of_weeks;
										$check_period_tasks = $check_period_tasks+$count;										
										break;
							case 'Monthly':
										$count= 12;
										$check_tasks_array[$j]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
							case 'Quarterly':
										$count= 4;
										$check_tasks_array[$j]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
							case '6 Months':
										$count= 2;
										$check_tasks_array[$j]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
							case 'Yearly':
										$count= 1;
										$check_tasks_array[$j]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
						}						
						for($i=0;$i<$count;$i++){
						$k=$j;
						$j++;
						} ?>
						<!--<hr>-->	
			<?php endforeach;?>
		
<div class="row">
		<h2>Equipment Maintenance</h2>
	
   <!-- add maintenance form in loop -->
   <div class="row collapse">
	<div class="small-12 medium-12 columns">
	
   <?php
		// echo "<pre>"; print_r($check_tasks_array); exit;
		 //if($tasks_count==0 && $maintenance_count==0)
		 if($maintenance_count==0)
		 {
			 $k=0;
			foreach($check_tasks_array as $i => $task_id){ ?>
			<table class="detail">
				<th>Sr No.</th>
				<th>Employee </th>
				<th>Maintenance Date</th>
				<th>Next Maintenance Date </th>
				<th>Notes </th>
				<th>Condition </th>
				<th>Checked </th>
			 
				 <h3><?php echo $task_id['task']?></h3>
				 <?php 		 
				 for($j=0;$j<$task_id['count'];$j++){
				
				 $current_task_id = $task_id['id'];
				 $equipmentBranch = $this->instantiate($_GET['id']);
				 $this->loadState($equipmentBranch);
				
					$equipmentBranch->addMaintainanceDetail();
					//Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
					//Yii::app()->clientscript->scriptMap['jquery.js'] = false;
					  $this->renderPartial('_maintenance', array('equipmentBranch'=>$equipmentBranch,'equipmentTasks'=>$equipmentTasks,'j'=>$k,'task_id'=>$current_task_id), false, true); 
					$k = $k+1;
				 }?>
			 </table>
				<?php
			}	?>	 
</div>		
	</div>
	</div>
	<!-- end of add maintenance form in loop -->		
			<?php
		}		 
		else{
			?>
				<table class="detail">
				<th>Sr No.</th>
				<th>Employee </th>
				<th>Maintenance Date</th>
				<th>Next Maintenance Date </th>
				<th>Notes </th>
				<th>Condition </th>
				<th>Checked </th>
			<?php 
				
				$this->renderPartial('_detail_maintenance_form', array('equipmentBranch'=>$equipmentBranch
						));
						?>
				</table>
				</div>		
	</div>
	<!-- end of add maintenance form in loop -->
</div>
<hr>
		<?php 
			
			}	// end of if tasks==0 loop
		?>
<!-- end RIGHT -->	
<div class="row">	
	<div class="small-12 medium-12 columns"> 
	   <div class="row">
		<?php
			// calender widget integration to see events
			$this->widget('application.extensions.fullcalendar.EFullCalendarHeart', array(
				//'themeCssFile'=>'cupertino/jquery-ui.min.css',
				'options'=>array(
					'header'=>array(
						'left'=>'prev,next,today',
						'center'=>'title',
						'right'=>'month,agendaWeek,agendaDay',
					),
					'events'=>$this->createUrl('equipmentBranch/getEvents?id='.$equipmentBranch->header->id), // URL to get event
				)));
				
			?>
		</div>
	</div>
</div>
	
	
		<hr>
		<?php 
			
			//}	// end of if tasks==0 loop
		?>
		
		
	
	  
	
	


	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($equipmentBranch->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	
</div>	
</div>	
</div>	