<?php
/* @var $this CompanyBranchController */
/* @var $model CompanyBranch */

$this->breadcrumbs=array(
	'Company Branches'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CompanyBranch', 'url'=>array('index')),
	array('label'=>'Create CompanyBranch', 'url'=>array('create')),
	array('label'=>'Update CompanyBranch', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CompanyBranch', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CompanyBranch', 'url'=>array('admin')),
);
?>

<h1>View CompanyBranch #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'company_id',
		'branch_id',
	),
)); ?>
