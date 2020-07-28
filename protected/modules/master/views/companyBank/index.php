<?php
/* @var $this CompanyBankController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Company Banks',
);

$this->menu=array(
	array('label'=>'Create CompanyBank', 'url'=>array('create')),
	array('label'=>'Manage CompanyBank', 'url'=>array('admin')),
);
?>

<h1>Company Banks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
