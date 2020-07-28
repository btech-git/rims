<?php
/* @var $this SectionDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Section Details',
);

$this->menu=array(
	array('label'=>'Create SectionDetail', 'url'=>array('create')),
	array('label'=>'Manage SectionDetail', 'url'=>array('admin')),
);
?>

<h1>Section Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
