<?php
/* @var $this ProductSpecificationTypeController */
/* @var $model ProductSpecificationType */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Specification Types'=>array('admin'),
	// $model->name=>array('view','id'=>$model->id),
	'Update Product Specification Type',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationType', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationType', 'url'=>array('create')),
	array('label'=>'View ProductSpecificationType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductSpecificationType', 'url'=>array('admin')),
);
?>

<h1>Update ProductSpecificationType <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>