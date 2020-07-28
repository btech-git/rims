<?php
/* @var $this CoaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Coas',
);

$this->menu=array(
	array('label'=>'Create Coa', 'url'=>array('create')),
	array('label'=>'Manage Coa', 'url'=>array('admin')),
);
?>

<h1>Coas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
