<?php
/* @var $this CompanyController */
/* @var $model Company */

$this->breadcrumbs=array(
	'Company',		
	'Companies'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Company', 'url'=>array('index')),
	array('label'=>'Manage Company', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

		<?php echo $this->renderPartial('_form', array(
					'company'=>$company,
					'bank'=>$bank,
					'bankDataProvider'=>$bankDataProvider,
					'branch'=>$branch,
					'branchDataProvider'=>$branchDataProvider,
					'branchArray'=>$branchArray,
					'coa'=>$coa,
					'coaDataProvider'=>$coaDataProvider,
					)); ?>
		</div>
