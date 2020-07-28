<?php
/* @var $this VehicleCarModelController */
/* @var $model VehicleCarModel */

$this->breadcrumbs=array(
	'Vehicle Car Models'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List VehicleCarModel', 'url'=>array('index')),
	array('label'=>'Create VehicleCarModel', 'url'=>array('create')),
	array('label'=>'Update VehicleCarModel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete VehicleCarModel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage VehicleCarModel', 'url'=>array('admin')),
);
?>
<!-- <div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarModel/admin';?>">Vehicle Car Modal</a>
			<span>View Vehicle Car Model</span>
		</div>
	</div>
</div>
 -->

		<div id="maincontent">
			<div class="clearfix page-action">
				<?php $ccontroller = Yii::app()->controller->id; ?>
				<?php $ccaction = Yii::app()->controller->action->id; ?>
			<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarModel/admin';?>"><span class="fa fa-th-list"></span>Manage Vehicle Car Models</a>
				<?php if (Yii::app()->user->checkAccess("master.vehicleCarModel.update")) { ?>
			<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
				<?php } ?>
			<h1>View Vehicle Car Model <?php echo $model->id; ?></h1>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					//'id',
					'name',
					'description',
					array('name'=>'car_make_id','value'=>$model->carMake->name),
					'status',
				),
			)); ?>
			</div>
		</div>