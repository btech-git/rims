<?php
/* @var $this ServicePricelistController */
/* @var $model ServicePricelist */

$this->breadcrumbs=array(
	'Service Pricelists'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServicePricelist', 'url'=>array('index')),
	array('label'=>'Manage ServicePricelist', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>