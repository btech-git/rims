<?php
/* @var $this IncentiveController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Incentives',
);

$this->menu=array(
	array('label'=>'Create Incentive', 'url'=>array('create')),
	array('label'=>'Manage Incentive', 'url'=>array('admin')),
);
?>

<h1>Incentives</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
