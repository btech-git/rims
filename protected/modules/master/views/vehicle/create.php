<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicles'=>array('admin'),
	'Manage Customer Vehicles'=>array('admin'),
	'New Vehicle',
);

$this->menu=array(
	array('label'=>'List Vehicle', 'url'=>array('index')),
	array('label'=>'Manage Customer Vehicles', 'url'=>array('admin')),
);
?>
<!--<div class="row">
	<div class="small-12 columns">
		<div class="breadcrumbs">
			<a href="#">Home</a>
			<a href="#">Vehicle</a>
			<a href="#">Vehicle</a>
			<span>New Vehicle</span>
		</div>
	</div>
</div>-->

<div id="maincontent">
<?php $this->renderPartial('_form', array('model'=>$model,'customer'=>$customer,'customerDataProvider'=>$customerDataProvider)); ?>
</div>
