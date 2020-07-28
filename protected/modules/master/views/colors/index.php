<?php
/* @var $this ColorsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Colors',
);

$this->menu=array(
	array('label'=>'Create Colors', 'url'=>array('create')),
	array('label'=>'Manage Colors', 'url'=>array('admin')),
);
?>

<h1>Colors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
