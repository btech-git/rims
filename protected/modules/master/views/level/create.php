<?php
/* @var $this LevelController */
/* @var $model Level */

$this->breadcrumbs=array(
	'Company',
	'Levels'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Level', 'url'=>array('index')),
	array('label'=>'Manage Level', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>