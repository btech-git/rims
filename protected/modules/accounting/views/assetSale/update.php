<?php
/* @var $this AssetSaleController */
/* @var $model AssetSale */

$this->breadcrumbs=array(
	'Asset Sales'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AssetSale', 'url'=>array('index')),
	array('label'=>'Create AssetSale', 'url'=>array('create')),
	array('label'=>'View AssetSale', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AssetSale', 'url'=>array('admin')),
);
?>

<h1>Update Asset Sale <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>