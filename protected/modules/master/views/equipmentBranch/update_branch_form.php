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
));
	Yii::app()->clientscript->registerCoreScript('jquery');
	Yii::app()->clientscript->registerCoreScript('jquery.ui');
 ?>	
	<hr>
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	<?php echo $form->errorSummary($equipmentBranch->header); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'brand'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($equipmentBranch->header,'brand',array('size'=>30,'maxlength'=>30)); ?>
						<?php echo $form->error($equipmentBranch->header,'brand'); ?>
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
					  <label class="prefix"><?php echo $form->labelEx($equipmentBranch->header,'quantity'); ?></label>
					</div>
					<div class="small-8 columns">
						<?php echo $form->textField($equipmentBranch->header,'quantity',array('placeHolder'=>'Quantity')); ?>
						<?php echo $form->error($equipmentBranch->header,'quantity'); ?>
					</div>
				</div>
			 </div>
		
	
	</div>
   
   <hr/>
   
   	<!-- Task form-->
			
			<?php 
				$check_period_tasks = 0;
				$j					= 0;
				$l					= 0;
				$count 				= 1;
				$check_tasks_array  = array();
				$equipmentBranchTasks  = array();
				// get tasks of all same branch related equipments
				foreach($branchEquipments as  $j => $branches){
					$equipmentBranchTasks[$j] = equipmentTask::model()->findAllByAttributes(array('equipment_id'=>$branches->id)); 
				}
				// end of get tasks of all same branch related equipments
				/*echo"<pre>";
				echo count($equipmentBranchTasks); 
				print_r($equipmentBranchTasks); 
				//exit;*/
				foreach($equipmentBranchTasks as  $j => $equipmentTasks): 
				//	echo"<pre>";
					//print_r($equipmentTask);
				for($p=0;$p<count($equipmentTasks);$p++){ 
					
					$check_tasks_array[$l]['id'] = $equipmentTasks[$p]['id'];
					$check_tasks_array[$l]['task'] = $equipmentTasks[$p]['task'];
					$equipmentName = Equipments::model()->findByPk($equipmentTasks[$p]['equipment_id']);
					$check_tasks_array[$l]['equipment_id'] = $equipmentTasks[$p]['equipment_id'];
					$check_tasks_array[$l]['equipment_name'] = $equipmentName['name'];
					switch($equipmentTasks[$p]['check_period']){							
							case 'Daily':	
										$count= date("t");
										$check_period_tasks = $check_period_tasks+$count;
										$check_tasks_array[$l]['count'] = date("t");
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
										$check_tasks_array[$l]['count'] = $num_of_weeks;
										$check_period_tasks = $check_period_tasks+$count;										
										break;
							case 'Monthly':
										$count= 12;
										$check_tasks_array[$l]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
							case 'Quarterly':
										$count= 4;
										$check_tasks_array[$l]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
							case '6 Months':
										$count= 2;
										$check_tasks_array[$l]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
							case 'Yearly':
										$count= 1;
										$check_tasks_array[$l]['count'] = $count;
										$check_period_tasks = $check_period_tasks+$count;
										break;
						}		
						$l++;
						 ?>
						<!--<hr>-->	
				<?php }
			endforeach;
				//}
				
				?>
		
		<div class="row">
			<h2>Equipment Maintenance</h2>
	
		   <!-- add maintenance form in loop -->
		   <div class="row collapse">
			<div class="small-12 medium-12 columns">
			 <?php
			// echo $maintenanceCount;
			if($maintenanceCount==0)
			{
				$k=0;?>
				
				<?php foreach($check_tasks_array as $i => $task_id){ ?> 
				<h4><?php echo $task_id['equipment_name']." - " .$task_id['task']; ?></h4>
				<table class="detail">
					<th>Sr No.</th>
					<th>Employee </th>
					<th>Maintenance Date</th>
					<th>Next Maintenance Date </th>
					<th>Check Date </th>
					<th>Notes </th>
					<th>Condition </th>
					<th>Checked </th>
			 
					<!-- <h3><?php //echo $task_id['task'];?></h3>-->
					 <?php 	
					 for($j=0;$j<$task_id['count'];$j++){					
					 $current_task_id = $task_id['id'];
					 $equipmentBranch = $this->instantiate($_GET['id']);
					 $this->loadState($equipmentBranch);
				
					$equipmentBranch->addMaintainanceDetail();
					//Yii::app()->clientscript->scriptMap['jquery-ui.js'] = true;
					//Yii::app()->clientscript->scriptMap['jquery.js'] = true;
					$this->renderPartial('add_maintenance', array('equipmentBranch'=>$equipmentBranch,'equipmentTasks'=>$equipmentTasks,'j'=>$k,'task_id'=>$current_task_id,'equipment_id'=>$task_id['equipment_id']), false, true); 
					$k = $k+1;
				 }?>
					 </table>			
				<!-- end of add maintenance form in loop -->
				</div>
				</div>	
				</div>
				</hr>
					<?php
				}	// end of add maintenance form in loop 
			}		 
			else{
			?>
				<table class="detail">
					<th>Sr No.</th>
					<th>Equipment </th>
					<th>Employee </th>
					<th>Maintenance Date</th>
					<th>Next Maintenance Date </th>
					<th>Check Date </th>
					<th>Notes </th>
					<th>Condition </th>
					<th>Checked </th>
					<?php $this->renderPartial('_detail_maintenance_form', array('equipmentBranch'=>$equipmentBranch));?>
				</table>
				</div>
				</div>		
			</div>
			<!-- end of add maintenance form in loop -->
			</hr>
			<!-- calendar start-->
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
			<!-- end of calendar-->
			</hr>		
			
			<!-- tasks stat-->
			<!-- load tasks -->
			<hr><?php $todays_month_year = date('Y-m'); ?>
			<!-- task schedule details starts  for daily-->
			<div class="row">	
				<div class="small-12 medium-6 columns"> 
				   <div class="row">
						<h3>Daily Tasks with Maintenance Schedule</h5>
						<table>			
							<tr>
								<th>Task</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked by</th>
								<th>Checked</th>
								<th>Update</th>					
							</tr>
							<?php
							if($dailyTasks<=0){ ?>
								<tr style="border-bottom:1px solid black;">
									<td colspan="6" style="text-align:center;">
									No Daily tasks
									</td>
								</tr> 
							<?php }
							else
							foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc):?>
							<?php if($equipmentMaintenanc->equipmentTask->check_period=="Daily" && (date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year)){?>
								<tr style="border-bottom:1px solid black;">
									<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>	
									<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
									<td><?php if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											  else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
										<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
									</td>
									<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
								</tr>
							<?php }?>
							<?php endforeach ?>
						</table>
					</div>
				</div>
			</div>
			
			<!-- task schedule details starts  for weekly-->
			<div class="row">
				<div class="small-12 medium-6 columns"> 
				   <div class="row">
						<h3>Weekly Tasks with Maintenance Schedule</h5>
						<table>			
							<tr>
								<th>Task</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked by</th>
								<th>Checked</th>
								<th>Update</th>				
							</tr>
							<?php
							if($weeklyTasks<=0){ ?>
								<tr style="border-bottom:1px solid black;">
									<td colspan="6" style="text-align:center;">
									No Weekly tasks
									</td>
								</tr> 
							<?php }
							else
							foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc):?>
							<?php if($equipmentMaintenanc->equipmentTask->check_period=="Weekly" && (date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year || date("Y-m", strtotime($equipmentMaintenanc->next_maintenance_date))==$todays_month_year)){?>
								<tr style="border-bottom:1px solid black;">
									<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>	
									<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
									<td><?php if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											  else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
										<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
									</td>
									<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
								</tr>
							<?php }?>
							<?php endforeach ?>
						</table>
					</div>
				</div>
			</div>
			
			<!-- task schedule details starts  for monthly-->
			<div class="row">
				<div class="small-12 medium-6 columns"> 
				   <div class="row">
						<h3>Monthly Tasks with Maintenance Schedule</h5>
						<table>			
							<tr>
								<th>Task</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked by</th>
								<th>Checked</th>
								<th>Update</th>					
							</tr>
							<?php
							if($monthlyTasks<=0){ ?>
								<tr style="border-bottom:1px solid black;">
									<td colspan="6" style="text-align:center;">
									No Monthly tasks
									</td>
								</tr> 
							<?php }
							else
							foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc):?>
							<?php if($equipmentMaintenanc->equipmentTask->check_period=="Monthly"){?>
								<tr style="border-bottom:1px solid black;">
									<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>	
									<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
									<td><?php if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											  else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
										<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
									</td>							
									<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
								</tr>
							<?php }?>
							<?php endforeach ?>
						</table>
					</div>
				</div>
			</div>
			
			
			<!-- task schedule details starts  for quarterly-->
			<div class="row">
				<div class="small-12 medium-6 columns"> 
				   <div class="row">
						<h3>Quarterly Tasks with Maintenance Schedule</h5>
						<table>			
							<tr>
								<th>Task</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked by</th>
								<th>Checked</th>
								<th>Update</th>				
							</tr>
							<?php
							if($quarterlyTasks<=0){ ?>
								<tr style="border-bottom:1px solid black;">
									<td colspan="6" style="text-align:center;">
									No Quarterly tasks
									</td>
								</tr> 
							<?php }
							else
							foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc):?>
							<?php if($equipmentMaintenanc->equipmentTask->check_period=="Quarterly"){?>
								<tr style="border-bottom:1px solid black;">
									<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>
									<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>
									<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
									<td><?php if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											  else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
										<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
									</td>								
									<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
								</tr>
							<?php }?>
							<?php endforeach ?>
						</table>
					</div>
				</div>
			</div>
			
			<!-- task schedule details starts  for 6 monthly-->
			<div class="row">
				<div class="small-12 medium-6 columns"> 
				   <div class="row">
						<h3>6 Monthly Tasks with Maintenance Schedule</h5>
						<table>			
							<tr>
								<th>Task</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked by</th>
								<th>Checked</th>
								<th>Update</th>				
							</tr>
							<?php
							if($halfyearlyTasks<=0){ ?>
								<tr style="border-bottom:1px solid black;">
									<td colspan="6" style="text-align:center;">
									No 6 monthly tasks
									</td>
								</tr> 
							<?php }
							else
							foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc):?>
							<?php if($equipmentMaintenanc->equipmentTask->check_period=="6 Months"){?>
								<tr style="border-bottom:1px solid black;">
									<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>
									<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
									<td><?php if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											  else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
												<img src="<?php echo  $image;?>" alt="Mountain View" style="width:16px;height:16px;">
									</td>	
									<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
								</tr>
							<?php }?>
							<?php endforeach ?>
						</table>
					</div>
				</div>
			</div>
			
			<!-- task schedule details starts  for yearly-->
			<div class="row">
				<div class="small-12 medium-6 columns"> 
				   <div class="row">
						<h3>Yearly Tasks with Maintenance Schedule</h5>
						<table>			
							<tr>
								<th>Task</th>
								<th>Maintenance Date</th>
								<th>Next Maintenance Date</th>
								<th>Checked by</th>
								<th>Checked</th>
								<th>Update</th>				
							</tr>
							<?php
							if($yearlyTasks<=0){ ?>
								<tr style="border-bottom:1px solid black;">
									<td colspan="6" style="text-align:center;">
									No yearly tasks
									</td>
								</tr> 
							<?php }
							else
							foreach ($equipmentBranch->equipmentMaintenances as $i => $equipmentMaintenanc):?>
							<?php if($equipmentMaintenanc->equipmentTask->check_period=="Yearly"){?>
								<tr style="border-bottom:1px solid black;">
									<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>
									<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>	
									<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
									<td><?php if($equipmentMaintenanc->checked=="checked")
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											  else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
										<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
									</td>
									<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
								</tr>
							<?php }?>
							<?php endforeach ?>
						</table>
					</div>
				</div>
			</div>
	
	
			
			<!-- end of tasks-->
		<hr>
	
			<!-- end of tasks -->
				<?php			
			}	// end of if tasks==0 loop?>
					
	<!-- end RIGHT -->	
	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($equipmentBranch->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>
	<?php $this->endWidget(); ?>
</div><!-- form -->
</div>	