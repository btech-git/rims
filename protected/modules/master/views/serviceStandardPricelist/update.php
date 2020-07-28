<?php
/* @var $this ServiceStandardPricelistController */
/* @var $model ServiceStandardPricelist */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service Standard Pricelists'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceStandardPricelist', 'url'=>array('index')),
	array('label'=>'Create ServiceStandardPricelist', 'url'=>array('create')),
	array('label'=>'View ServiceStandardPricelist', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ServiceStandardPricelist', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>