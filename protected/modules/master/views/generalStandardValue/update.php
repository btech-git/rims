<?php
/* @var $this GeneralStandardValueController */
/* @var $model GeneralStandardValue */

$this->breadcrumbs=array(
	'General Standard Values'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GeneralStandardValue', 'url'=>array('index')),
	array('label'=>'Create GeneralStandardValue', 'url'=>array('create')),
	array('label'=>'View GeneralStandardValue', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GeneralStandardValue', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model,
																								)); ?>
		</div>