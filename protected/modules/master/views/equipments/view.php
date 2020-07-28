<?php
/* @var $this EquipmentsController */
/* @var $model Equipments */

$this->breadcrumbs=array(
	'Products',
	'Equipments'=>array('admin'),
	'View Equipment '.$model->name,
);

/*$this->menu=array(
	array('label'=>'List Equipments', 'url'=>array('index')),
	array('label'=>'Create Equipments', 'url'=>array('create')),
	array('label'=>'Update Equipments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Equipments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Equipments', 'url'=>array('admin')),
);*/
?>


	
			<div id="maincontent">
				<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
				<a class="button cbutton right" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/admin');?>"><span class="fa fa-th-list"></span>Manage Equipments</a>
				<?php if (Yii::app()->user->checkAccess("master.equipments.update")) { ?>
				<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<div class="clearfix page-action">
					
<h1>View Equipment <?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
	//	array('name'=>'branch_id', 'value'=>$model->branch->name),
		array('name'=>'equipment_type_id', 'value'=>$model->equipmentType->name),
		array('name'=>'equipment_sub_type_id', 'value'=>$model->equipmentSubType->name),
		'name',
		'status',
	),
)); ?>


	
</div>

</div>


	<!--<div class="row">
		<h3>Details</h5>
		<table >
			<?php foreach ($equipmentDetails as $key => $equipmentDetail): ?>
				<tr>
						<?php //$branch = Branch::model()->findByPK($equipmentBranch->branch_id); ?>
					<td><?php echo $equipmentDetail->equipment_code; ?></td>	
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
	
	<div class="row">
		<h3>Tasks</h5>
		<table >
			<?php foreach ($equipmentTasks as $key => $equipmentTask): ?>
				<tr>
					<td><?php echo $equipmentTask->task; ?></td>	
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>-->
	
	<?php $todays_month_year = date('Y-m'); //echo count($equipmentMaintenance); ?>
	<!--<div class="row">
		<h3>Tasks with Maintenance Schedule</h5>
		<table>			
			<tr>
				<th>Equipment</th>
				<th>Equipment Type</th>
				<th>Equipment Sub Type</th>
				<th>Task</th>
				<th>Check Period</th>
				<th>Maintenance Date</th>
				<th>Next Maintenance Date</th>
				<th>Check Date</th>
				<th>Checked by</th>
				<th>Checked</th>
				<th>Update</th>				
			</tr>
			<?php
			$month_task_count = 0;
			if(count($equipmentMaintenances)>0){ 
				foreach ($equipmentMaintenances as $key => $equipmentMaintenanc): ?>
				<?php if((date("Y-m", strtotime($equipmentMaintenanc->maintenance_date))==$todays_month_year) || (date("Y-m", strtotime($equipmentMaintenanc->next_maintenance_date))==$todays_month_year)){
					$month_task_count++;?>
					<tr style="border-bottom:1px solid black;">
						<td><?php echo $equipmentMaintenanc->equipment->name; ?> </td>
						<td><?php echo $equipmentMaintenanc->equipment->equipmentType->name; ?> </td>
						<td><?php echo $equipmentMaintenanc->equipment->equipmentSubType->name; ?> </td>
						<td><?php echo $equipmentMaintenanc->equipmentTask->task; ?> </td>
						<td><?php echo $equipmentMaintenanc->equipmentTask->check_period; ?></td>	
						<td><?php echo $equipmentMaintenanc->maintenance_date; ?></td>	
						<td><?php echo $equipmentMaintenanc->next_maintenance_date; ?></td>
						<td><?php echo $equipmentMaintenanc->check_date; ?></td>
						<td><?php //echo $equipmentMaintenanc->employee->name; ?></td>	
						<td><?php if($equipmentMaintenanc->checked=="Checked")
									$image = Yii::app()->baseUrl."/images/icons/tick.png";
								  else 
									$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
							<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
						</td>				
						<td><a href="<?php echo Yii::app()->createUrl("master/equipmentMaintenance/update", array("id"=>$equipmentMaintenanc->id));?>">edit</a></td>						
					</tr>
			<?php }
				endforeach;
			}
			else{ ?>
				<tr style="border-bottom:1px solid black;">
					<td colspan="11" style="text-align:center;">
					No tasks
					</td>
				</tr>
			<?php
			} 
			if($month_task_count<=0){?>
				<tr style="border-bottom:1px solid black;">
					<td colspan="11" style="text-align:center;">
					No tasks
					</td>
				</tr>					
		<?php }?>
		</table>
	</div>-->
	
	<div class="row">
	<div class="small-12 columns">
		<div id="maincontent">

			<div class="clearfix page-action">
				<h1>Maintenance Detail for <?php echo $model->name; ?></h1>
				<?php 
					$tableTotal = '';
					
					if(count($equipmentDetails)>0){						
						
					foreach ($equipmentDetails as $key => $equipmentDetail) {
						$tableTotal .= '<h3> Equipment Name : '.$equipmentDetail->equipment->name.'<br>
											Equipment Type : '.$equipmentDetail->equipment->equipmentType->name.'<br>
											Equipment Sub-Type : '.$equipmentDetail->equipment->equipmentSubType->name.'
											</h3>';
							$equipmentDetailsId = $equipmentDetail->id;
							
							$equipmentTasks 	= EquipmentTask::model()->findAllByAttributes(array('equipment_id'=>$equipmentDetail->equipment->id));					
							if( count($equipmentTasks)>0){
								foreach($equipmentTasks as $i => $equipmentTask){
									$equipmentTaskId = $equipmentTask->id;
									
									$tableTotal .= '<table>
														<tr>
															<th colspan="7"> Equipment Task : '.$equipmentTask->task.' <br/>
																			 Check Period : '.$equipmentTask->check_period.'</th>
														</tr>
														<tr>
															<th>Maintenance Date</th>
															<th>Next Maintenance Date</th>
															<th>Checked By</th>
															<th>Check Date</th>
															<th>Equipment Condition</th>
															<th>Checked</th>
															<th>edit</th>
															
														</tr>';	
									$equipmentMaintenances 	= EquipmentMaintenances::model()->findAllByAttributes(array('equipment_detail_id'=>$equipmentDetailsId, 'equipment_id'=>$equipmentTask->equipment_id,'equipment_task_id'=>$equipmentTask->id));					
									if(count($equipmentMaintenances)>0){ 
										foreach($equipmentMaintenances as $key => $equipmentMaintenanc){
											$employee_name = Employee::model()->findByPk($equipmentMaintenanc->employee_id);
											if($equipmentMaintenanc->employee_id != 0)
												$image = Yii::app()->baseUrl."/images/icons/tick.png";
											else 
												$image = Yii::app()->baseUrl."/images/icons/cancel.png";
											
											$updateUrl = Yii::app()->createUrl("master/equipments/updateDetails?id=".$equipmentMaintenanc->equipment_id);
												
											$tableTotal .= '<tr style="border-bottom:1px solid black;">
											<td>'.$equipmentMaintenanc->maintenance_date.'</td>	
											<td>'.$equipmentMaintenanc->next_maintenance_date.'</td>
											<td>'.$employee_name["name"].'</td>
											<td>'.$equipmentMaintenanc->check_date.'</td>	
											<td>'.$equipmentMaintenanc->equipment_condition.'</td>	
											<td>
												<img src="'.$image.'" alt="'.$equipmentMaintenanc->checked.'" style="width:16px;height:16px;">
											</td>				
											<td><a href="'.$updateUrl.'">edit</a></td></tr>';
										}
										$tableTotal .= '</table>';
									}
									else{
											$tableTotal .= '<tr style="border-bottom:1px solid black;">
										<td colspan="7">
											No maintenances to display!
										</td>
										</table>';
									}
								}
							}
							
						
						$tabarray[$equipmentDetail->equipment_code]=$tableTotal;
						$tableTotal = '';
					}
					}
					else{
						$tableTotal .= '<tr style="border-bottom:1px solid black;">
										<td colspan="7">
											No maintenance details to display!
										</td>
										</table>';
						$tabarray['No Details']=$tableTotal;
					}

					$this->widget('zii.widgets.jui.CJuiTabs',array(
					    'tabs'=>$tabarray,
					    // additional javascript options for the accordion plugin
					    'options' => array(
					        'collapsible' => true,        
					    ),
					    'id'=>'MyTab-Menu1'
					));
				?> 
			</div>


		</div>
	</div>
	</div>
	
	<br>
	</hr>
	</hr>
	
	<!-- calendar start-->
	<!--
	<div class="row">	
		<div class="small-12 medium-12 columns"> 
		<h1>Maintenance Events Calendar for <?php echo $model->name; ?></h1>
				
		  <?php
				// calender widget integration to see events
				/*$this->widget('application.extensions.fullcalendar.EFullCalendarHeart', array(
					//'themeCssFile'=>'cupertino/jquery-ui.min.css',
					'options'=>array(
						'header'=>array(
							'left'=>'prev,next,today',
							'center'=>'title',
							'right'=>'month,agendaWeek,agendaDay',
						),
						'events'=>$this->createUrl('equipments/getEvents?id='.$model->id), // URL to get event
					)));*/
					
				?>
		</div>
	</div>
	-->
	<!-- end of calendar-->
	</hr>		
	