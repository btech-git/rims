<?php
/* @var $this SectionDetailController */
/* @var $model SectionDetail */

$this->breadcrumbs=array(
	'Warehouse'=>Yii::app()->baseUrl.'/master/warehouse/admin',	
	'Section Details'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Section Detail', 'url'=>array('index')),
	array('label'=>'Manage Section Detail', 'url'=>array('admin')),
);
?>
<div id="maincontent">
	<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>