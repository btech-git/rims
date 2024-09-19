<?php
/* @var $this MovementOutHeaderController */
/* @var $movementOut->header MovementOutHeader */

$this->breadcrumbs=array(
	'Movement Out Headers'=>array('admin'),
	$movementOut->header->id=>array('view','id'=>$movementOut->header->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List MovementOutHeader', 'url'=>array('index')),
	array('label'=>'Create MovementOutHeader', 'url'=>array('create')),
	array('label'=>'View MovementOutHeader', 'url'=>array('view', 'id'=>$movementOut->header->id)),
	array('label'=>'Manage MovementOutHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update MovementOutHeader <?php echo $movementOut->header->id; ?></h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'movementOut'=>$movementOut,
    )); ?>
</div>