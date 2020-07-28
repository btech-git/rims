<?php
/* @var $this ChasisCodeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Chasis Codes',
);

$this->menu=array(
	array('label'=>'Create ChasisCode', 'url'=>array('create')),
	array('label'=>'Manage ChasisCode', 'url'=>array('admin')),
);
?>

<h1>Chasis Codes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
