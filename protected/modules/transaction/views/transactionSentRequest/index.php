<?php
/* @var $this TransactionSentRequestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Transaction Sent Requests',
);

$this->menu=array(
	array('label'=>'Create TransactionSentRequest', 'url'=>array('create')),
	array('label'=>'Manage TransactionSentRequest', 'url'=>array('admin')),
);
?>

<h1>Transaction Sent Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
