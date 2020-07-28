<?php
/* @var $this CashTransactionImagesController */
/* @var $model CashTransactionImages */

$this->breadcrumbs=array(
	'Cash Transaction Images'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List CashTransactionImages', 'url'=>array('index')),
	array('label'=>'Manage CashTransactionImages', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create CashTransactionImages</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>