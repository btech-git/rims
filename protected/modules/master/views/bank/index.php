<?php
/* @var $this BankController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Banks',
);

$this->menu=array(
	array('label'=>'Create Bank', 'url'=>array('create')),
	array('label'=>'Manage Bank', 'url'=>array('admin')),
);
?>

<h1>Banks</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
