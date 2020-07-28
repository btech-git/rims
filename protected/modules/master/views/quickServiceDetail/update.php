<?php
/* @var $this QuickServiceDetailController */
/* @var $model QuickServiceDetail */

$this->breadcrumbs=array(
	'Quick Service Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuickServiceDetail', 'url'=>array('index')),
	array('label'=>'Create QuickServiceDetail', 'url'=>array('create')),
	array('label'=>'View QuickServiceDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage QuickServiceDetail', 'url'=>array('admin')),
);
?>

<h1>Update QuickServiceDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>