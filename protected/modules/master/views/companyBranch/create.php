<?php
/* @var $this CompanyBranchController */
/* @var $model CompanyBranch */

$this->breadcrumbs=array(
	'Company Branches'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CompanyBranch', 'url'=>array('index')),
	array('label'=>'Manage CompanyBranch', 'url'=>array('admin')),
);
?>

<h1>Create CompanyBranch</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>