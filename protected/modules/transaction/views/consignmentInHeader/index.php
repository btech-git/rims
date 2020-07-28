<?php
/* @var $this ConsignmentInHeaderController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Consignment In Headers',
);

$this->menu=array(
	array('label'=>'Create ConsignmentInHeader', 'url'=>array('create')),
	array('label'=>'Manage ConsignmentInHeader', 'url'=>array('admin')),
);
?>

<h1>Consignment In Headers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
