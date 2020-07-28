<?php
/* @var $this InsuranceCompanyPricelistController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Insurance Company Pricelists',
);

$this->menu=array(
	array('label'=>'Create InsuranceCompanyPricelist', 'url'=>array('create')),
	array('label'=>'Manage InsuranceCompanyPricelist', 'url'=>array('admin')),
);
?>

<h1>Insurance Company Pricelists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
