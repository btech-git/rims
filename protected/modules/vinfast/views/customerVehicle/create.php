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

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'model'=>$model,
        'customer'=>$customer,
        'customerDataProvider'=>$customerDataProvider
    )); ?>
</div>
