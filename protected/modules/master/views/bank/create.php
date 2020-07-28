<?php
/* @var $this BankController */
/* @var $model Bank */

$this->breadcrumbs=array(
	'Accounting',
	'Banks'=>array('admin'),
	'Create',
	);

// $this->menu=array(
// 	array('label'=>'List Bank', 'url'=>array('index')),
// 	array('label'=>'Manage Bank', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
