<?php
/* @var $this ColorsController */
/* @var $model Colors */
$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Colors'=>array('admin'),
	'Update Color',
);
/*
$this->menu=array(
	array('label'=>'List Colors', 'url'=>array('index')),
	array('label'=>'Create Colors', 'url'=>array('create')),
	array('label'=>'View Colors', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Colors', 'url'=>array('admin')),
);*/
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/colors/admin';?>">Colors</a>
			<span>Update Color</span>
		</div>
	</div>
</div>-->


		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
