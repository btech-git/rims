<?php
/* @var $this EquipmentController */
/* @var $model Equipment */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Equipment'=>array('admin'),
	'View Equipment '.$model->name,
);

// $this->menu=array(
// 	array('label'=>'List Equipment', 'url'=>array('index')),
// 	array('label'=>'Create Equipment', 'url'=>array('create')),
// 	array('label'=>'Update Equipment', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Equipment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Equipment', 'url'=>array('admin')),
// );
?>


<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
			<?php $ccaction = Yii::app()->controller->action->id; ?>
		<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/equipment/admin';?>"><span class="fa fa-th-list"></span>Manage Equipment</a>
				<?php if (Yii::app()->user->checkAccess("master.equipment.update")) { ?>
		<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>		
		<?php } ?>
		<h1>View Equipment <?php echo $model->name; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					//'id',
					'name',
					'purchase_date',
					'maintenance_schedule',
					'period',
					'status',
				),
			)); ?>
	</div>
</div>
<div class="row">
	<div class="small-12 columns">
		<h3>Services</h3>
		<table >
			<thead>
				<tr>
					<td>Name</td>
				</tr>
			</thead>
			<?php foreach ($serviceEquipments as $key => $serviceEquipment): ?>
				<tr>
						<?php $service = Service::model()->findByPK($serviceEquipment->service_id); ?>
					<td><?php echo $service->name; ?></td>	
					
				</tr>
			<?php endforeach ?>
		</table>
	</div>
</div>


