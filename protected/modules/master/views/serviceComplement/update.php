<?php
/* @var $this ServiceComplementController */
/* @var $model ServiceComplement */

$this->breadcrumbs=array(
	'Service Complements'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceComplement', 'url'=>array('index')),
	array('label'=>'Create ServiceComplement', 'url'=>array('create')),
	array('label'=>'View ServiceComplement', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiceComplement', 'url'=>array('admin')),
);
?>

<h1>Update ServiceComplement <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>