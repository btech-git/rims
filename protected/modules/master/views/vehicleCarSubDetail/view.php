<?php
/* @var $this VehicleCarSubDetailController */
/* @var $model VehicleCarSubDetail */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Vehicle Car Sub Details'=>array('admin'),
	'View Vehicle Car Sub Detail '.$model->name,
);

$this->menu=array(
	// array('label'=>'List VehicleCarSubDetail', 'url'=>array('index')),
	// array('label'=>'Create VehicleCarSubDetail', 'url'=>array('create')),
	// array('label'=>'Update VehicleCarSubDetail', 'url'=>array('update', 'id'=>$model->id)),
	// array('label'=>'Delete VehicleCarSubDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	// array('label'=>'Manage VehicleCarSubDetail', 'url'=>array('admin')),
);
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
				<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
				<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubDetail/admin';?>">Vehicle Car Sub Detail</a>
			<span>View Vehicle Car Sub Detail</span>
		</div>
	</div>
</div>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
	<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubDetail/admin';?>"><span class="fa fa-th-list"></span>Manage Vehicle Car Sub Details</a>
				<?php if (Yii::app()->user->checkAccess("master.vehicleCarSubDetail.update")) { ?>
	<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
	<h1>View Vehicle Car Sub Detail <?php echo $model->name; ?></h1>

	<?php $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			//'id',
			'name',
			'assembly_year',
			'transmission',
			'fuel_type',
			array('name'=>'car_make_id','value'=>$model->carMake->name),
			array('name'=>'car_model_id','value'=>$model->carModel->name),
			'status',
			'power_id',
			'drivetrain',
			'chasis_code',
			'description',
			'luxury_value',
		),
	)); ?>
	</div>
</div>