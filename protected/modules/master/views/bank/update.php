<?php
/* @var $this BankController */
/* @var $model Bank */

$this->breadcrumbs=array(
		'Accounting',
		'Banks'=>array('admin'),
		//$model->name=>array('view','id'=>$model->id),
		'Update Bank',
);

// $this->menu=array(
// 	array('label'=>'List Bank', 'url'=>array('index')),
// 	array('label'=>'Create Bank', 'url'=>array('create')),
// 	array('label'=>'View Bank', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage Bank', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>