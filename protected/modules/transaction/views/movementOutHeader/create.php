<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs = array(
    'Movement Out' => array('admin'),
    'Create',
);
?>

<div id="maincontent">
    <?php $this->renderPartial('_form', array(
        'movementOut' => $movementOut,
        'movementOutDate' => $movementOutDate,
        'movementOutHour' => $movementOutHour,
        'movementOutMinute' => $movementOutMinute,
        'yearList' => $yearList,
        'weeklist' => $weeklist,
    )); ?>
</div>