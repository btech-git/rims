<?php
/* @var $this AssetDepreciationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Asset Depreciations',
);

$this->menu=array(
	array('label'=>'Create AssetDepreciation', 'url'=>array('create')),
	array('label'=>'Manage AssetDepreciation', 'url'=>array('admin')),
);
?>

<h1>Asset Depreciations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
