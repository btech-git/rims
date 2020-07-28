<?php
/* @var $this JurnalUmumController */
/* @var $model JurnalUmum */

$this->breadcrumbs=array(
	'Jurnal Umums'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List JurnalUmum', 'url'=>array('index')),
	array('label'=>'Manage JurnalUmum', 'url'=>array('admin')),
);
?>

<h1>Create JurnalUmum</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>