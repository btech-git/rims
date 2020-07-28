<?php
/* @var $this VehicleCarMakeController */
/* @var $model VehicleCarMake */

$this->breadcrumbs=array(
	'Vehicle'=>Yii::app()->baseUrl.'/master/vehicle/admin',
	'Vehicle Car Makes'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VehicleCarMake', 'url'=>array('index')),
	array('label'=>'Manage VehicleCarMake', 'url'=>array('admin')),
);
?>
<div id="maincontent">
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>