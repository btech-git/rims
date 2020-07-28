<?php
/* @var $this CompanyBranchController */
/* @var $model CompanyBranch */

$this->breadcrumbs=array(
	'Company Branches'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CompanyBranch', 'url'=>array('index')),
	array('label'=>'Create CompanyBranch', 'url'=>array('create')),
	array('label'=>'View CompanyBranch', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CompanyBranch', 'url'=>array('admin')),
);
?>

<h1>Update CompanyBranch <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>