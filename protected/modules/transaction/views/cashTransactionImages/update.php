<?php
/* @var $this CashTransactionImagesController */
/* @var $model CashTransactionImages */

$this->breadcrumbs=array(
	'Cash Transaction Images'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List CashTransactionImages', 'url'=>array('index')),
	array('label'=>'Create CashTransactionImages', 'url'=>array('create')),
	array('label'=>'View CashTransactionImages', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CashTransactionImages', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update CashTransactionImages <?php echo $model->id; ?></h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>