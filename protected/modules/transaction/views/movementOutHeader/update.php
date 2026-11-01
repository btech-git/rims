<?php
/* @var $this MovementOutHeaderController */
/* @var $movementOut->header MovementOutHeader */

$this->breadcrumbs=array(
	'Movement Out Headers'=>array('admin'),
	$movementOut->header->id=>array('view','id'=>$movementOut->header->id),
	'Update',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'movementOut'=>$movementOut,
        'movementOutDate' => $movementOutDate,
        'movementOutHour' => $movementOutHour,
        'movementOutMinute' => $movementOutMinute,
        'yearList' => $yearList,
        'weeklist' => $weeklist,
    )); ?>
</div>