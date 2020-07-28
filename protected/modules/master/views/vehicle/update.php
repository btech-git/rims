<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicle'=>array('admin'),
	'Vehicles'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vehicle', 'url'=>array('index')),
	array('label'=>'Create Vehicle', 'url'=>array('create')),
	array('label'=>'View Vehicle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vehicle', 'url'=>array('admin')),
);
?>

<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="#">Home</a>
			<a href="#">Vehicle</a>
			<a href="#">Vehicle</a>
			<span>Update Vehicle</span>
		</div>
	</div>
</div>-->
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model, 'customer'=>$customer, 'customerDataProvider'=>$customerDataProvider)); ?>
</div>
