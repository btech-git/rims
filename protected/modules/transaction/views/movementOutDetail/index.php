<?php
/* @var $this MovementOutDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Movement Out Details',
);

$this->menu=array(
	array('label'=>'Create MovementOutDetail', 'url'=>array('create')),
	array('label'=>'Manage MovementOutDetail', 'url'=>array('admin')),
);
?>

<h1>Movement Out Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
