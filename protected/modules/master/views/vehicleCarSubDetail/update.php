<?php
/* @var $this VehicleCarSubDetailController */
/* @var $model VehicleCarSubDetail */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Vehicle Car Sub Details'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VehicleCarSubDetail', 'url'=>array('index')),
	array('label'=>'Create VehicleCarSubDetail', 'url'=>array('create')),
	array('label'=>'View VehicleCarSubDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VehicleCarSubDetail', 'url'=>array('admin')),
);
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="<?php echo Yii::app()->baseUrl.'/site/index';?>">Home</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicle/admin';?>">Vehicle</a>
			<a href="<?php echo Yii::app()->baseUrl.'/master/vehicleCarSubDetail/admin';?>">Vehicle Car Sub Detail</a>
			<span>Update Vehicle Car Sub Detail</span>
		</div>
	</div>
</div>-->
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>