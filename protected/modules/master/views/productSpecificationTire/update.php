<?php
/* @var $this ProductSpecificationTireController */
/* @var $model ProductSpecificationTire */

$this->breadcrumbs=array(
	'Product Specification Tires'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationTire', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationTire', 'url'=>array('create')),
	array('label'=>'View ProductSpecificationTire', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductSpecificationTire', 'url'=>array('admin')),
);
?>

<h1>Update ProductSpecificationTire <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>