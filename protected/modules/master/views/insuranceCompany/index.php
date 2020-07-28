<?php
/* @var $this InsuranceCompanyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Insurance Companies',
);

$this->menu=array(
	array('label'=>'Create InsuranceCompany', 'url'=>array('create')),
	array('label'=>'Manage InsuranceCompany', 'url'=>array('admin')),
);
?>

<h1>Insurance Companies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
