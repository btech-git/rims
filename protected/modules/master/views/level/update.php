<?php
/* @var $this LevelController */
/* @var $model Level */

$this->breadcrumbs=array(
	'Company',
	'Levels'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update Level',
);

$this->menu=array(
	array('label'=>'List Level', 'url'=>array('index')),
	array('label'=>'Create Level', 'url'=>array('create')),
	array('label'=>'View Level', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Level', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>