<?php
/* @var $this QuickServiceController */
/* @var $quickService->header QuickService */

$this->breadcrumbs=array(
	'Quick Services'=>array('admin'),
	$quickService->header->name=>array('view','id'=>$quickService->header->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List QuickService', 'url'=>array('index')),
	array('label'=>'Create QuickService', 'url'=>array('create')),
	array('label'=>'View QuickService', 'url'=>array('view', 'id'=>$quickService->header->id)),
	array('label'=>'Manage QuickService', 'url'=>array('admin')),
);
?>
	<div id="maincontent">

			<?php echo $this->renderPartial('_form', array(
						'quickService'=>$quickService,
						'service'=>$service,
						'serviceDataProvider'=>$serviceDataProvider,
						'serviceArray'=>$serviceArray,
				)); ?>
	</div>