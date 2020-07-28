<?php
/* @var $this PositionController */
/* @var $model Position */

$this->breadcrumbs=array(
	'Company',
	'Positions'=>array('admin'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List Position', 'url'=>array('index')),
	array('label'=>'Manage Position', 'url'=>array('admin')),
);*/
?>



		<div id="maincontent">

			<?php $this->renderPartial('_form', array('position'=>$position,'level'=>$level,'levelDataProvider'=>$levelDataProvider,'levelArray'=>$levelArray)); ?>
		</div>
