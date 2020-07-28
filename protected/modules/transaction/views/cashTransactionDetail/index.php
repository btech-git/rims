<?php
/* @var $this CashTransactionDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cash Transaction Details',
);

$this->menu=array(
	array('label'=>'Create CashTransactionDetail', 'url'=>array('create')),
	array('label'=>'Manage CashTransactionDetail', 'url'=>array('admin')),
);
?>

<h1>Cash Transaction Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
