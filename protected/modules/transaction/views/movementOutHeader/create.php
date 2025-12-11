<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs = array(
    'Movement Out' => array('admin'),
    'Create',
);

/* $this->menu=array(
  array('label'=>'List MovementOutHeader', 'url'=>array('index')),
  array('label'=>'Manage MovementOutHeader', 'url'=>array('admin')),
  ); */
?>

<!--<h1>Create MovementOutHeader</h1>-->

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'movementOut' => $movementOut,
        'movementOutDate' => $movementOutDate,
        'movementOutHour' => $movementOutHour,
        'movementOutMinute' => $movementOutMinute,
        'yearList' => $yearList,
    )); ?>
</div>