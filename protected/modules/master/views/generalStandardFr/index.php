<?php
/* @var $this GeneralStandardFrController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'General Standard Frs',
);

$this->menu=array(
	array('label'=>'Create GeneralStandardFr', 'url'=>array('create')),
	array('label'=>'Manage GeneralStandardFr', 'url'=>array('admin')),
);
?>

<h1>General Standard Frs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
