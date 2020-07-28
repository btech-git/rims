<?php
/* @var $this InsuranceCompanyPricelistController */
/* @var $model InsuranceCompanyPricelist */

$this->breadcrumbs=array(
	'Insurance Company Pricelists'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List InsuranceCompanyPricelist', 'url'=>array('index')),
	array('label'=>'Create InsuranceCompanyPricelist', 'url'=>array('create')),
	array('label'=>'Update InsuranceCompanyPricelist', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete InsuranceCompanyPricelist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InsuranceCompanyPricelist', 'url'=>array('admin')),
);
?>

<h1>View InsuranceCompanyPricelist #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'insurance_company_id',
		'service_id',
		'damage_type',
		'vehicle_type',
		'price',
	),
)); ?>
