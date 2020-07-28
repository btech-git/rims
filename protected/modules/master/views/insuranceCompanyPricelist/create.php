<?php
/* @var $this InsuranceCompanyPricelistController */
/* @var $model InsuranceCompanyPricelist */

$this->breadcrumbs=array(
	'Insurance Company Pricelists'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List InsuranceCompanyPricelist', 'url'=>array('index')),
	array('label'=>'Manage InsuranceCompanyPricelist', 'url'=>array('admin')),
);
?>

<h1>Create InsuranceCompanyPricelist</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>