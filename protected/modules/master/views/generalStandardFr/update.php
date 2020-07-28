<?php
/* @var $this GeneralStandardFrController */
/* @var $model GeneralStandardFr */

$this->breadcrumbs=array(
	'General Standard Frs'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GeneralStandardFr', 'url'=>array('index')),
	array('label'=>'Create GeneralStandardFr', 'url'=>array('create')),
	array('label'=>'View GeneralStandardFr', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GeneralStandardFr', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model,
																								)); ?>
		</div>