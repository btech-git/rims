<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventory'=>array('admin'),
	'Inventories'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);*/
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>

<?php //$this->renderPartial('_form', array('model'=>$model)); ?>