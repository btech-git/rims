<?php
/* @var $this ServiceComplementController */
/* @var $model ServiceComplement */

$this->breadcrumbs=array(
	'Service Complements'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ServiceComplement', 'url'=>array('index')),
	array('label'=>'Create ServiceComplement', 'url'=>array('create')),
	array('label'=>'Update ServiceComplement', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ServiceComplement', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ServiceComplement', 'url'=>array('admin')),
);
?>

<h1>View ServiceComplement #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'service_id',
		'complement_id',
	),
)); ?>
