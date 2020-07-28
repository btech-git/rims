<?php
/* @var $this ProductSpecificationOilController */
/* @var $model ProductSpecificationOil */

$this->breadcrumbs=array(
	'Product Specification Oils'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationOil', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationOil', 'url'=>array('create')),
	array('label'=>'View ProductSpecificationOil', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductSpecificationOil', 'url'=>array('admin')),
);
?>

<h1>Update ProductSpecificationOil <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>