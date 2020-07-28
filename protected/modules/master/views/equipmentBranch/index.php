<?php
/* @var $this EquipmentBranchController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Equipment Branches',
);

$this->menu=array(
	array('label'=>'Create EquipmentBranch', 'url'=>array('create')),
	array('label'=>'Manage EquipmentBranch', 'url'=>array('admin')),
);
?>

<h1>Equipment Branches</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
