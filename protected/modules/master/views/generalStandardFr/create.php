<?php
/* @var $this GeneralStandardFrController */
/* @var $model GeneralStandardFr */

$this->breadcrumbs=array(
	'General Standard Frs'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GeneralStandardFr', 'url'=>array('index')),
	array('label'=>'Manage GeneralStandardFr', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model,
																								)); ?>
		</div>