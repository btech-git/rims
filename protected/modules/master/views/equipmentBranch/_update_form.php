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
   
   
    <!-- begin RIGHT -->
	<div class="small-12 medium-5b columns">
   <!-- start of branch-->
		<div class="row">
   	<!-- Task form-->
		<!--<div class="row">
			<?php echo CHtml::button('Add Equipment Maintenance', array(
							'id' => 'detail-button',
							'name' => 'Detail',
							'class'=>'button extra right',
							'onclick' => '
								jQuery.ajax({
									type: "POST",
									url: "' . CController::createUrl('ajaxHtmlAddMaintenanceDetail', array('id' => $equipmentBranch->header->id)) . '",
									data: jQuery("form").serialize(),
									success: function(html) {
										jQuery("#task").html(html);
									},
								});',

							)
						); ?>
			<h2>Equipment Maintenance</h2>
			<div id="task">
					<?php $this->renderPartial('_detailMaintenance', array('equipmentBranch'=>$equipmentBranch
						)); ?>
			</div>
		</div>-->
		<!-- End of Task form-->
	
	<div></div>


	



      </div>
   </div>
   
   
<!-- end RIGHT -->	
<hr>
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
	<?php $todays_month_year = date('Y-m'); ?>
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
					<?php if($equipmentMaintenanc->equipmentTask->check_period=="Weekly" && (date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year)){?>
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
					<?php if($equipmentMaintenanc->equipmentTask->check_period=="6 monthly"){?>
						<tr style="border-bottom:1px solid black;">
							<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>
							<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
							<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>	
							<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
							<td><?php $equipmentMaintenanc->checked="checked"?$image="/images/icons/tick.png" : "/images/icons/tick.png";?>
										<img src="<?php echo  $image;?>" alt="Mountain View" style="width:304px;height:228px;">
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
	
	
		<hr>


	<div class="field buttons text-center">
		<?php echo CHtml::submitButton($equipmentBranch->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->
</div>	