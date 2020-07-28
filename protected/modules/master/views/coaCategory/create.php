<?php
/* @var $this CoaCategoryController */
/* @var $model CoaCategory */

$this->breadcrumbs=array(
	'Coa Categories'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List CoaCategory', 'url'=>array('index')),
	array('label'=>'Manage CoaCategory', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create CoaCategory</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>