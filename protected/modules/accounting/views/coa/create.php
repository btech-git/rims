<?php
/* @var $this CoaController */
/* @var $model Coa */

$this->breadcrumbs=array(
	'Coas'=>array('index'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Coa', 'url'=>array('index')),
	array('label'=>'Manage Coa', 'url'=>array('admin')),
);*/
?>

<!--<h1>Create Coa</h1>-->

<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?></div>