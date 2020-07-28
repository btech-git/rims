<?php
/* @var $this CompanyBranchController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Company Branches',
);

$this->menu=array(
	array('label'=>'Create CompanyBranch', 'url'=>array('create')),
	array('label'=>'Manage CompanyBranch', 'url'=>array('admin')),
);
?>

<h1>Company Branches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
