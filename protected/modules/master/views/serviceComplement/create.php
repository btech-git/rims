<?php
/* @var $this ServiceComplementController */
/* @var $model ServiceComplement */

$this->breadcrumbs=array(
	'Service Complements'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceComplement', 'url'=>array('index')),
	array('label'=>'Manage ServiceComplement', 'url'=>array('admin')),
);
?>

<h1>Create ServiceComplement</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>