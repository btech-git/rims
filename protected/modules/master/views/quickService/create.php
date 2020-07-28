<?php
/* @var $this QuickServiceController */
/* @var $model QuickService */

$this->breadcrumbs=array(
	'Quick Services'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuickService', 'url'=>array('index')),
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