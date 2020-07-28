<?php
/* @var $this ServicePricelistController */
/* @var $model ServicePricelist */

$this->breadcrumbs=array(
	'Service Pricelists'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServicePricelist', 'url'=>array('index')),
	array('label'=>'Create ServicePricelist', 'url'=>array('create')),
	array('label'=>'View ServicePricelist', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServicePricelist', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>