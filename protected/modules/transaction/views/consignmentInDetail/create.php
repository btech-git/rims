<?php
/* @var $this ConsignmentInDetailController */
/* @var $model ConsignmentInDetail */

$this->breadcrumbs=array(
	'Consignment In Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ConsignmentInDetail', 'url'=>array('index')),
	array('label'=>'Manage ConsignmentInDetail', 'url'=>array('admin')),
);
?>

<h1>Create ConsignmentInDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>