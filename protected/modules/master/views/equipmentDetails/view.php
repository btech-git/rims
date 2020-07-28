<?php
/* @var $this EquipmentDetailsController */
/* @var $model EquipmentDetails */

$this->breadcrumbs=array(
	'Product',
	'Equipment Details'=>array('admin'),	
	'View equipment Details '.$model->id,
);

/*$this->menu=array(
	array('label'=>'List EquipmentDetails', 'url'=>array('index')),
	array('label'=>'Create EquipmentDetails', 'url'=>array('create')),
	array('label'=>'Update EquipmentDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete EquipmentDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage EquipmentDetails', 'url'=>array('admin')),
);*/
?>

	
			<div id="maincontent">
				<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
				<a class="button cbutton right" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/admin');?>"><span class="fa fa-th-list"></span>Manage Equipment Branches</a>
				<?php if (Yii::app()->user->checkAccess("master.equipmentDetails.update")) { ?>
				<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<div class="clearfix page-action">
					
					<h1>View EquipmentDetails #<?php echo $model->id; ?></h1>

					<?php $this->widget('zii.widgets.CDetailView', array(
						'data'=>$model,
						'attributes'=>array(
							'id',
							'equipment_id',
							'equipment_code',
							'brand',
							'purchase_date',
							'age',
							//'quantity',
							'status',
						),
					)); ?>
				</div>
			</div>
			<?php $todays_month_year = date('Y-m'); //echo count($equipmentMaintenance); ?>
	<div class="row">
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
			if(count($model->equipmentMaintenances)>0){ 
				foreach ($model->equipmentMaintenances as $key => $equipmentMaintenanc): ?>
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
						<td><?php echo $equipmentMaintenanc->employee->name; ?></td>	
						<td><?php if($equipmentMaintenanc->checked=="checked")
									$image = Yii::app()->baseUrl."/images/icons/tick.png";
								  else 
									$image = Yii::app()->baseUrl."/images/icons/cancel.png";?>
							<img src="<?php echo  $image;?>" alt="<?php echo $equipmentMaintenanc->checked;?>" style="width:16px;height:16px;">
						</td>				
						<td><a href="<?php echo Yii::app()->createUrl("master/equipmentDetails/updateDetail", array("id"=>$equipmentMaintenanc->equipment_detail_id));?>">edit</a></td>						
					</tr>
			<?php }
				endforeach;
			}
			else{ ?>
				<tr style="border-bottom:1px solid black;">
					<td colspan="9" style="text-align:center;">
					No tasks
					</td>
				</tr>
			<?php
			} 
			if($month_task_count<=0){?>
				<tr style="border-bottom:1px solid black;">
					<td colspan="9" style="text-align:center;">
					No tasks
					</td>
				</tr>					
		<?php }?>
		</table>
	</div>
	
	<?php
	// calender widget integration to see events
	$this->widget('ext.fullcalendar.EFullCalendarHeart', array(
		//'themeCssFile'=>'cupertino/jquery-ui.min.css',
		'options'=>array(
			'header'=>array(
				'left'=>'prev,next,today',
				'center'=>'title',
				'right'=>'month,agendaWeek,agendaDay',
			),
			'events'=>$this->createUrl('equipmentDetails/getEvents?id='.$model->id), // URL to get event
		)));
	?>