<?php
/* @var $this ServiceComplementController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Complements',
);

$this->menu=array(
	array('label'=>'Create ServiceComplement', 'url'=>array('create')),
	array('label'=>'Manage ServiceComplement', 'url'=>array('admin')),
);
?>

<h1>Service Complements</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
