<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs=array(
	'Company',
 	'Customers'=>array('admin'),
	'Create',
);

/*$this->menu=array(
	array('label'=>'List Customer', 'url'=>array('index')),
	array('label'=>'Manage Customer', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('customer'=>$customer,'service'=>$service,
			'serviceDataProvider'=>$serviceDataProvider,'coa'=>$coa,
			'coaDataProvider'=>$coaDataProvider,)); ?>
		</div>
