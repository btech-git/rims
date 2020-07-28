<?php
/* @var $this QuickServiceDetailController */
/* @var $model QuickServiceDetail */

$this->breadcrumbs=array(
	'Quick Service Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuickServiceDetail', 'url'=>array('index')),
	array('label'=>'Manage QuickServiceDetail', 'url'=>array('admin')),
);
?>

<h1>Create QuickServiceDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>