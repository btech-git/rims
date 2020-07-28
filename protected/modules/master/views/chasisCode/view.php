<?php
/* @var $this ChasisCodeController */
/* @var $model ChasisCode */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Chassis Codes'=>array('admin'),
	'View Chassis Code '.$model->name,
);

$this->menu=array(
	array('label'=>'List ChasisCode', 'url'=>array('index')),
	array('label'=>'Create ChasisCode', 'url'=>array('create')),
	array('label'=>'Update ChasisCode', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ChasisCode', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ChasisCode', 'url'=>array('admin')),
);
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/admin';?>">Chassis Code</a>
			<span>View Chassis Code</span>
		</div>
	</div>
</div>-->

		<div id="maincontent">
			<div class="clearfix page-action">
					<?php $ccontroller = Yii::app()->controller->id; ?>
					<?php $ccaction = Yii::app()->controller->action->id; ?>
					<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/chasisCode/admin';?>"><span class="fa fa-th-list"></span>Manage Chasis Codes</a>
					<a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>Edit</a>
					<h1>View Chasis Code <?php echo $model->name; ?></h1>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data'=>$model,
				'attributes'=>array(
					//'id',
					'name',
					'status',
					array('name'=>'car_make_id','value'=>$model->brand->name),
				),
			)); ?>
			</div>
		</div>