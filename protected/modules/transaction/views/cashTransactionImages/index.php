<?php
/* @var $this CashTransactionImagesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cash Transaction Images',
);

$this->menu=array(
	array('label'=>'Create CashTransactionImages', 'url'=>array('create')),
	array('label'=>'Manage CashTransactionImages', 'url'=>array('admin')),
);
?>

<h1>Cash Transaction Images</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
