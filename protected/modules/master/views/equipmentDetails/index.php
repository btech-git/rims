<?php
/* @var $this EquipmentDetailsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Details',
);

$this->menu=array(
	array('label'=>'Create EquipmentDetails', 'url'=>array('create')),
	array('label'=>'Manage EquipmentDetails', 'url'=>array('admin')),
);
?>

<h1>Equipment Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
