<?php
/* @var $this CashTransactionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cash Transactions',
);

$this->menu=array(
	array('label'=>'Create CashTransaction', 'url'=>array('create')),
	array('label'=>'Manage CashTransaction', 'url'=>array('admin')),
);
?>

<h1>Cash Transactions</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
