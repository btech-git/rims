<?php
/* @var $this CashTransactionDetailController */
/* @var $model CashTransactionDetail */

$this->breadcrumbs=array(
	'Cash Transaction Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List CashTransactionDetail', 'url'=>array('index')),
	array('label'=>'Create CashTransactionDetail', 'url'=>array('create')),
	array('label'=>'View CashTransactionDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CashTransactionDetail', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update CashTransactionDetail <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>