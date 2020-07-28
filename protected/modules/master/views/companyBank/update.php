<?php
/* @var $this CompanyBankController */
/* @var $model CompanyBank */

$this->breadcrumbs=array(
	'Company Banks'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CompanyBank', 'url'=>array('index')),
	array('label'=>'Create CompanyBank', 'url'=>array('create')),
	array('label'=>'View CompanyBank', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CompanyBank', 'url'=>array('admin')),
);
?>

<h1>Update CompanyBank <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>