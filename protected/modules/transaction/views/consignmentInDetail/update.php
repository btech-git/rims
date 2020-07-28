<?php
/* @var $this ConsignmentInDetailController */
/* @var $model ConsignmentInDetail */

$this->breadcrumbs=array(
	'Consignment In Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ConsignmentInDetail', 'url'=>array('index')),
	array('label'=>'Create ConsignmentInDetail', 'url'=>array('create')),
	array('label'=>'View ConsignmentInDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ConsignmentInDetail', 'url'=>array('admin')),
);
?>

<h1>Update ConsignmentInDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>