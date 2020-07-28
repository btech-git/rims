<?php
/* @var $this GeneralStandardValueController */
/* @var $model GeneralStandardValue */

$this->breadcrumbs=array(
	'General Standard Values'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List GeneralStandardValue', 'url'=>array('index')),
	array('label'=>'Manage GeneralStandardValue', 'url'=>array('admin')),
);
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('model'=>$model,
																								)); ?>
		</div>