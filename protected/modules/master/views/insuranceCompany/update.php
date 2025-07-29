<?php
/* @var $this InsuranceCompanyController */
/* @var $model InsuranceCompany */

$this->breadcrumbs=array(
	'Company',
	'Insurance Companies'=>array('admin'),
	$insurance->header->name=>array('view','id'=>$insurance->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List InsuranceCompany', 'url'=>array('index')),
	array('label'=>'Create InsuranceCompany', 'url'=>array('create')),
	array('label'=>'View InsuranceCompany', 'url'=>array('view', 'id'=>$insurance->header->id)),
	array('label'=>'Manage InsuranceCompany', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <?php echo $this->renderPartial('_form', array(
        'insurance'=>$insurance,
        'service'=>$service,
        'serviceDataProvider'=>$serviceDataProvider,
        'serviceArray'=>$serviceArray,
    )); ?>
</div>