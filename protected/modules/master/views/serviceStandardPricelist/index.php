<?php
/* @var $this ServiceStandardPricelistController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Standard Pricelists',
);

$this->menu=array(
	array('label'=>'Create ServiceStandardPricelist', 'url'=>array('create')),
	array('label'=>'Manage ServiceStandardPricelist', 'url'=>array('admin')),
);
?>

<h1>Service Standard Pricelists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
