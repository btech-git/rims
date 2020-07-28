<?php
/* @var $this CashTransactionDetailController */
/* @var $model CashTransactionDetail */

$this->breadcrumbs=array(
	'Cash Transaction Details'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List CashTransactionDetail', 'url'=>array('index')),
	array('label'=>'Manage CashTransactionDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create CashTransactionDetail</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>