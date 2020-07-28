<?php
/* @var $this ServicePricelistController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Pricelists',
);

$this->menu=array(
	array('label'=>'Create ServicePricelist', 'url'=>array('create')),
	array('label'=>'Manage ServicePricelist', 'url'=>array('admin')),
);
?>

<h1>Service Pricelists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
