<?php
/* @var $this VehicleCarSubModelDetailController */
/* @var $model VehicleCarSubModelDetail */

$this->breadcrumbs=array(
	'Vehicle',
	'Vehicle Car Sub Model Details'=>array('admin'),
	$model->name,
);

/*$this->menu=array(
	array('label'=>'List VehicleCarSubModelDetail', 'url'=>array('index')),
	array('label'=>'Create VehicleCarSubModelDetail', 'url'=>array('create')),
	array('label'=>'Update VehicleCarSubModelDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VehicleCarSubModelDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VehicleCarSubModelDetail', 'url'=>array('admin')),
);*/
?>

			<div id="maincontent">
				<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
				<a class="button cbutton right" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/admin');?>"><span class="fa fa-th-list"></span>Manage Vehicle Car SubModel Details</a>
				<?php if (Yii::app()->user->checkAccess("master.vehicleCarSubModelDetail.update")) { ?>
				<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
					<div class="clearfix page-action">
		
<h1>View VehicleCarSubModelDetail <?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		//'car_make_id',
		//'car_model_id',
		array('name'=>'car_sub_model_id', 'value'=>$model->carSubModel->name),
		//'car_sub_model_id',
		'name',
		'chasis_code',
		'assembly_year_start',
		'assembly_year_end',
		'transmission',
		'fuel_type',
		'power',
		'drivetrain',
		'description',
		'status',
		'luxury_value',
	),
)); ?>
</div>
</div>