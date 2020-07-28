<?php
/* @var $this ProductSpecificationInfoController */
/* @var $model ProductSpecificationInfo */

$this->breadcrumbs=array(
	'Product'=>Yii::app()->baseUrl.'/master/product/admin',
	'Product Specification Infos'=>array('admin'),
	//$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProductSpecificationInfo', 'url'=>array('index')),
	array('label'=>'Create ProductSpecificationInfo', 'url'=>array('create')),
	array('label'=>'View ProductSpecificationInfo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProductSpecificationInfo', 'url'=>array('admin')),
);
?>

<h1>Update ProductSpecificationInfo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>