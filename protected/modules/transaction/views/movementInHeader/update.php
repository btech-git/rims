<?php
/* @var $this MovementInHeaderController */
/* @var $model MovementInHeader */

$this->breadcrumbs=array(
	'Movement In Headers'=>array('admin'),
	$movementIn->header->id=>array('view','id'=>$movementIn->header->id),
	'Update',
);

/*$this->menu=array(
	array('label'=>'List MovementInHeader', 'url'=>array('index')),
	array('label'=>'Create MovementInHeader', 'url'=>array('create')),
	array('label'=>'View MovementInHeader', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage MovementInHeader', 'url'=>array('admin')),
);*/
?>

<!--<h1>Update MovementInHeader <?php echo $movementIn->header->id; ?></h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'movementIn'=>$movementIn,
        'movementInDate' => $movementInDate,
        'movementInHour' => $movementInHour,
        'movementInMinute' => $movementInMinute,
        'yearList' => $yearList,
    )); ?>
</div>