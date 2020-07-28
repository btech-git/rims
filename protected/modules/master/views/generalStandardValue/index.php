<?php
/* @var $this GeneralStandardValueController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'General Standard Values',
);

$this->menu=array(
	array('label'=>'Create GeneralStandardValue', 'url'=>array('create')),
	array('label'=>'Manage GeneralStandardValue', 'url'=>array('admin')),
);
?>

<h1>General Standard Values</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
